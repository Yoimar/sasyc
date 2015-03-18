<?php

use Illuminate\Console\Command;

class MigrarSasyc extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrar:sasyc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que migra sasyc viejo a la nueva version';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $this->resetearBD();
        DB::setDefaultConnection('migracion_sasyc');
        $this->cargarTablaNivelInstruccion();
        $this->cargarTablaParentescos('personas_sasyc');
        $this->cargarTablaParentescos('personas_familia');
        $this->migrarPersonas();
        $this->migrarFamiliares();
        $this->migrarRequerimientos();
        $this->migrarAreas();
        $this->migrarRecaudos();
        $this->migrarRecepciones();
        $this->migrarSolicitudes();
    }

    private function resetearBD(){
        $db_final = Config::get('database.connections.migracion_sasyc.database');
        $this->info("Verificando si sasyc_migracion existe");
        $existe = DB::select("SELECT 1 FROM pg_database WHERE datname = '$db_final'");
        if(!empty($existe)){
            $this->info("Borrando base de datos ".$db_final);
            DB::statement('DROP DATABASE '.$db_final);
        }
        $this->info("Cerrando conexion con la BD");
        DB::disconnect('sasyc_migracion');
        DB::disconnect('pgsql');
        $this->info("Creando base de datos ".$db_final);
        DB::statement('CREATE DATABASE '.$db_final);
        $this->info("Corriendo archivos de migrations y seeds");
        $this->call('migrate', ['--database' => 'migracion_sasyc']);
        $this->call('db:seed', ['--database'=>'migracion_sasyc']);

    }

    private function cargarTablaNivelInstruccion(){
        //Se buscan los distintos niveles de instruccion en el sasyc viejo...
        $this->info("Migrando Niveles academicos");
        $niveles = DB::connection('sasyc_viejo')->table('personas_sasyc')->distinct()->select('nivelinstruccion')->get();
        foreach($niveles as $key=>$nivel){
            $existe = NivelAcademico::where('nombre','ILIKE',$nivel->nivelinstruccion)->count();
            if($existe==0){
                $this->info("Creando ".$nivel->nivelinstruccion);
                NivelAcademico::create(['nombre'=>$nivel->nivelinstruccion,'orden'=>$key]);
            }
        }
    }

    private function cargarTablaParentescos($origen){
        //Se buscan los distintos parentescos en el sasyc viejo...
        $this->info("Migrando parentescos");
        $parentescos = DB::connection('sasyc_viejo')->table($origen)->distinct()->select('parentesco')->get();
        foreach($parentescos as $key=>$parentesco){
            $existe = Parentesco::where('nombre','ILIKE',$parentesco->parentesco)->count();
            if($existe==0){
                $this->info("Creando ".$parentesco->parentesco);
                Parentesco::create(['nombre'=>$parentesco->parentesco,'inverso'=>'No Aplica']);
            }
        }
    }

    private function migrarPersonas(){
        $arrEstadoCivil = [
            ''=>null,
            'S'=>1,
            'D'=>4,
            'C'=>2,
            'O'=>5,
            'V'=>3,
        ];
        $nacionalidades = [
            'E'=>2,
            'V'=>1,
        ];
        $this->info("Migrando personas");
        $personas = DB::connection('sasyc_viejo')->table('personas_sasyc')->get();
        foreach($personas as $persona){
            $personaNueva = new Persona();
            //Esto es importante, como estamos forzando el id la concurrencia da error....
            $personaNueva->desabilitarConcurrencia();
            $personaNueva->desabilitarValidaciones();
            $personaNueva->id = $persona->idpersona;
            $personaNueva->nombre = $persona->nombre;
            $personaNueva->apellido = $persona->apellido;
            $personaNueva->tipo_nacionalidad_id = $nacionalidades[$persona->nacionalidad];
            $personaNueva->ci = $persona->ci;
            $personaNueva->sexo = $persona->sexo;
            $personaNueva->estado_civil_id = $arrEstadoCivil[$persona->estadocivil];
            $personaNueva->lugar_nacimiento = $persona->lugarnacimiento;
            if($persona->fecnacimiento!=''){
                $carbon = new Carbon($persona->fecnacimiento);
                $personaNueva->fecha_nacimiento = $carbon->format('d/m/Y');
            }
            $personaNueva->nivelAcademico()->associate(NivelAcademico::where('nombre','ILIKE',$persona->nivelinstruccion)->first());
            $personaNueva->zona_sector = $persona->zonasector;
            $personaNueva->calle_avenida = $persona->calleavenida;
            $personaNueva->apto_casa = $persona->aptocasa;
            $personaNueva->telefono_fijo = $persona->telefono;
            $personaNueva->telefono_celular = $persona->celular;
            $personaNueva->telefono_otro = $persona->telefotros;
            $personaNueva->ind_trabaja = $persona->trabaja == 'S';
            $personaNueva->ocupacion = $persona->ocupacion;
            $personaNueva->ingreso_mensual = $persona->ingresomensual;
            $personaNueva->observaciones = $persona->observaciones;
            $personaNueva->ind_asegurado = $persona->asegurado == 'S';
            $personaNueva->empresa_seguro = $persona->empresaseguro;
            $personaNueva->cobertura = $persona->cobertura;
            $personaNueva->otro_apoyo = $persona->otroapoyo;
            $personaNueva->save();
            $this->info("Persona ".$persona->ci." se migro correctamente");
        }
    }

    private function migrarFamiliares(){
        $this->info("Migrando familiares");
        $parientes = DB::connection('sasyc_viejo')->table('personas_familia')->get();
        foreach($parientes as $pariente){
            $this->info("Migrando ".$pariente->idbeneficiario.'->'.$pariente->idfamiliar);
            $parentesco = Parentesco::where('nombre','ILIKE',$pariente->parentesco)->first();
            $insert = [
                'persona_beneficiario_id'=>$pariente->idbeneficiario,
                'persona_familia_id'=>$pariente->idfamiliar,
                'parentesco_id'=>$parentesco->id,
                'created_at'=> new Carbon(),
                'updated_at'=>new Carbon(),
            ];
            DB::table('familia_persona')->insert($insert);
        }
    }

    private function migrarRequerimientos(){
        $this->info("Migrando requerimientos");
        $requerimientos = DB::connection('sasyc_viejo')->table('requerimientos')->get();
        foreach($requerimientos as $requerimiento){
            $this->info("Migrando requerimiento: ".$requerimiento->codrequerimiento);
            $requerimientoNuevo = new Requerimiento();
            $requerimientoNuevo->desabilitarValidaciones();
            $requerimientoNuevo->desabilitarConcurrencia();
            $requerimientoNuevo->id = $requerimiento->codrequerimiento;
            $requerimientoNuevo->nombre = $requerimiento->nombrequerimiento;
            $requerimientoNuevo->cod_item = $requerimiento->coditem;
            $requerimientoNuevo->cod_cta = $requerimiento->codcta;
            $requerimientoNuevo->descripcion = $requerimiento->descrequerimiento;
            $requerimientoNuevo->tipo_requerimiento_id = $requerimiento->tipo=='M' ? 2:1;
            $requerimientoNuevo->tipo_ayuda_id = $requerimiento->codplancaso =='MED' ? 1:2;
            $requerimientoNuevo->save();
            $this->info("Requerimiento ".$requerimientoNuevo->nombre.' migrado');
        }
    }

    private function migrarAreas(){
        $this->info("Migrando areas");
        $areas = DB::connection('sasyc_viejo')->table('especialidad')->get();
        foreach($areas as $area){
            $this->info("Migrando area: ".$area->codespecialidad);
            $areaNueva = new Area();
            $areaNueva->desabilitarConcurrencia();
            $areaNueva->desabilitarValidaciones();
            $areaNueva->id = $area->codespecialidad;
            $areaNueva->nombre = $area->nombespecialidad;
            $areaNueva->descripcion = $area->descespecialidad;
            $areaNueva->tipo_ayuda_id = 1;
            $areaNueva->save();
        }
    }

    private function migrarRecaudos(){
        $this->info("Migrando recaudos");
        $recaudos = DB::connection('sasyc_viejo')->table('recaudos_sasyc')->get();
        foreach($recaudos as $recaudo){
            $this->info("Migrando recaudo: ".$recaudo->codrecaudo);
            $recaudoNuevo = new Recaudo();
            $recaudoNuevo->desabilitarConcurrencia();
            $recaudoNuevo->desabilitarValidaciones();
            $recaudoNuevo->id = $recaudo->codrecaudo;
            $recaudoNuevo->nombre = $recaudo->nombrecaudo;
            $recaudoNuevo->descripcion = $recaudo->descrecaudo;
            $recaudoNuevo->ind_activo = $recaudo->indactivo == 'S';
            $recaudoNuevo->ind_vence = $recaudo->indvence == 'S';
            $recaudoNuevo->ind_obligatorio = $recaudo->indobligatorio == 'S';
            $recaudoNuevo->save();
        }
    }

    private function migrarRecepciones(){
        $this->info("Migrando recepciones");
        $recepciones = DB::connection('sasyc_viejo')->table('referencias')->get();
        foreach($recepciones as $recepcion){
            $this->info("Migrando recepcion: ".$recepcion->codreferidopor);
            $recepcionNueva = new Recepcion();
            $recepcionNueva->desabilitarConcurrencia();
            $recepcionNueva->desabilitarValidaciones();
            $recepcionNueva->id = $recepcion->codreferidopor;
            $recepcionNueva->nombre = $recepcion->nombre;
            $recepcionNueva->save();
        }
    }

    private function migrarSolicitudes(){
        $arrayEstatus = [
            'APR'=>'APR',
            'ANU'=>'ANU',
            'ACP'=>'ACA',
            'CER'=>'CER',
            'PEN'=>'ELA',
        ];
        $this->info("Migrando solicitudes");
        $solicitudes = DB::connection('sasyc_viejo')->table('solicitud_sasyc')->get();
        foreach($solicitudes as $solicitud){
            $this->info("Migrando solicitud: ".$solicitud->numsol);
            $solicitudNueva = new Solicitud();
            $solicitudNueva->desabilitarConcurrencia();
            $solicitudNueva->desabilitarValidaciones();
            $solicitudNueva->id = $solicitud->idsolicitud;
            $solicitudNueva->created_at = new \Carbon\Carbon($solicitud->fecsol);
            $solicitudNueva->descripcion = $solicitud->desccaso;
            $solicitudNueva->referente_id = 1;
            $solicitudNueva->recepcion_id = $solicitud->codreferidopor;
            $solicitudNueva->num_solicitud = $solicitud->numsol;
            $solicitudNueva->ind_mismo_benef = $solicitud->indmismobenef=='S';
            $solicitudNueva->persona_beneficiario_id = $solicitud->idbeneficiario;
            $solicitudNueva->persona_solicitante_id = $solicitud->idsolicitante;
            $solicitudNueva->observaciones = $solicitud->observaciones;
            if($solicitud->fecasignacion!=''){
                $carbon = new Carbon($solicitud->fecasignacion);
                $solicitudNueva->fecha_asignacion = $carbon->format('d/m/Y');
                $solicitudNueva->usuario_asignacion_id = 1;
            }
            $solicitudNueva->ind_inmediata = $solicitud->prioridad > 0;
            $solicitudNueva->estatus = $arrayEstatus[$solicitud->stssolicitud];
            if($solicitud->fecapr!=''){
                $carbon = new Carbon($solicitud->fecapr);
                $solicitudNueva->fecha_aprobacion = $carbon->format('d/m/Y');
                $solicitudNueva->usuario_autorizacion_id = 1;
            }
            $solicitudNueva->area_id = $solicitud->codespecialidad;
            $solicitudNueva->necesidad = $solicitud->diagnostico;
            $solicitudNueva->organismo_id = 1;
            $solicitudNueva->tipo_proc = $solicitud->tipoproc;
            $solicitudNueva->num_proc = $solicitud->numproc;
            if($solicitud->fecacp!=''){
                $carbon = new Carbon($solicitud->fecacp);
                $solicitudNueva->fecha_aceptacion = $carbon->format('d/m/Y');
            }
            $solicitudNueva->moneda = $solicitud->codmoneda;
            if($solicitud->feccierre!=''){
                $carbon = new Carbon($solicitud->feccierre);
                $solicitudNueva->fecha_cierre = $carbon->format('d/m/Y');
            }
            $solicitudNueva->save();
        }
    }

    private function migrarInformeSocioEconomico(){
        $tipos = [
          'Q'=>1,
            'Q'=>1,
            'Q'=>1,
            'Q'=>1,
            'Q'=>1,
            'Q'=>1,
        ];
        $this->info("Migrando informes socio economicos");
        $informes = DB::connection('sasyc_viejo')->table('inf_social')->get();
        foreach($informes as $informe){
            $this->info("Migrando recepcion: ".$informe->idsolicitud);
            $solicitud = Solicitud::findOrFail($informe->idsolicitud);
            $solicitud->tipo_vivienda_id =
            $recepcionNueva = new Recepcion();
            $recepcionNueva->desabilitarConcurrencia();
            $recepcionNueva->desabilitarValidaciones();
            $recepcionNueva->id = $recepcion->codreferidopor;
            $recepcionNueva->nombre = $recepcion->nombre;
            $recepcionNueva->save();
        }
    }
}