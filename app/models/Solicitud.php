<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Solicitud
 *
 * @author Nadin Yamani
 * @property integer $id
 * @property integer $ano
 * @property string $descripcion
 * @property integer $persona_beneficiario_id
 * @property integer $persona_solicitante_id
 * @property integer $tipo_ayuda_id
 * @property integer $area_id
 * @property integer $referente_id
 * @property integer $recepcion_id
 * @property integer $organismo_id
 * @property boolean $ind_mismo_benef
 * @property boolean $ind_inmediata
 * @property string $actividad
 * @property string $referencia
 * @property string $accion_tomada
 * @property string $necesidad
 * @property string $tipo_proc
 * @property integer $num_proc
 * @property string $facturas
 * @property string $observaciones
 * @property string $moneda
 * @property integer $prioridad
 * @property string $estatus
 * @property integer $usuario_asignacion_id
 * @property integer $usuario_autorizacion_id
 * @property \Carbon\Carbon $fecha_solicitud
 * @property \Carbon\Carbon $fecha_asignacion
 * @property \Carbon\Carbon $fecha_aceptacion
 * @property \Carbon\Carbon $fecha_aprobacion
 * @property \Carbon\Carbon $fecha_cierre
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Persona $personaBeneficiario
 * @property-read \Persona $personaSolicitante
 * @property-read \TipoAyuda $tipoAyuda
 * @property-read \Area $area
 * @property-read \Referente $referente
 * @property-read \Recepcion $recepcion
 * @property-read \Organismo $organismo
 * @property-read \UsuarioAsignacion $usuarioAsignacion
 * @property-read \UsuarioAutorizacion $usuarioAutorizacion
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereAno($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereDescripcion($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud wherePersonaBeneficiarioId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud wherePersonaSolicitanteId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereTipoAyudaId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereAreaId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereReferenteId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereRecepcionId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereOrganismoId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereIndMismoBenef($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereIndInmediata($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereActividad($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereReferencia($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereAccionTomada($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereNecesidad($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereTipoProc($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereNumProc($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereFacturas($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereObservaciones($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereMoneda($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud wherePrioridad($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereEstatus($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereUsuarioAsignacionId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereUsuarioAutorizacionId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereFechaSolicitud($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereFechaAsignacion($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereFechaAceptacion($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereFechaAprobacion($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereFechaCierre($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Solicitud whereUpdatedAt($value) 
 */
class Solicitud extends BaseModel implements DefaultValuesInterface {

    protected $table = "solicitudes";

    /**
     * Campos que se pueden llenar mediante el uso de mass-assignment
     * @link http://laravel.com/docs/eloquent#mass-assignment
     * @var array
     */
    protected $fillable = [
        'ano', 'descripcion', 'persona_beneficiario_id', 'persona_solicitante_id',
        'tipo_ayuda_id', 'area_id', 'referente_id', 'recepcion_id', 'organismo_id',
        'ind_mismo_benef', 'ind_inmediata', 'actividad', 'referencia',
        'accion_tomada', 'necesidad', 'tipo_proc', 'num_proc', 'facturas',
        'observaciones', 'moneda', 'prioridad', 'estatus', 'usuario_asignacion_id',
        'usuario_autorizacion_id', 'fecha_solicitud', 'fecha_asignacion',
        'fecha_aceptacion', 'fecha_aprobacion', 'fecha_cierre',
    ];

    /**
     * Reglas que debe cumplir el objeto al momento de ejecutar el metodo save, 
     * si el modelo no cumple con estas reglas el metodo save retornará false, 
     * y los cambios realizados no haran persistencia.
     * @link http://laravel.com/docs/validation#available-validation-rules
     * @var array
     */
    protected $rules = [
        'ano' => 'required|integer',
        'descripcion' => 'required',
        'persona_beneficiario_id' => 'integer',
        'persona_solicitante_id' => 'integer',
        'tipo_ayuda_id' => 'required|integer',
        'area_id' => 'required|integer',
        'referente_id' => 'required|integer',
        'recepcion_id' => 'required|integer',
        'organismo_id' => 'required|integer',
        'ind_mismo_benef' => 'required',
        'ind_inmediata' => 'required',
        'actividad' => '',
        'referencia' => '',
        'accion_tomada' => '',
        'necesidad' => 'required',
        'tipo_proc' => '',
        'num_proc' => 'integer',
        'facturas' => '',
        'observaciones' => '',
        'moneda' => 'required',
        'prioridad' => 'required|integer',
        'estatus' => 'required',
        'usuario_asignacion_id' => 'integer',
        'usuario_autorizacion_id' => 'integer',
        'fecha_solicitud' => 'required',
        'fecha_asignacion' => '',
        'fecha_aceptacion' => '',
        'fecha_aprobacion' => '',
        'fecha_cierre' => '',
    ];
    protected $dates = ['fecha_solicitud', 'fecha_asignacion', 'fecha_aceptacion', 'fecha_aprobacion', 'fecha_cierre'];

    protected function getPrettyFields() {
        return [
            'ano' => 'Año',
            'descripcion' => 'Descripción',
            'persona_beneficiario_id' => 'Beneficiario',
            'persona_solicitante_id' => 'Solicitante',
            'tipo_ayuda_id' => 'Tipo de ayuda',
            'area_id' => 'Area',
            'referente_id' => 'Referido por',
            'recepcion_id' => 'Recepción',
            'organismo_id' => 'Procesado por',
            'ind_mismo_benef' => 'Solicitante es el mismo Beneficiario?',
            'ind_inmediata' => 'Atención inmediata?',
            'actividad' => 'Actividad',
            'referencia' => 'Referencia',
            'accion_tomada' => 'Acción Tomada',
            'necesidad' => 'Necesidad',
            'tipo_proc' => 'Tipo de procesamiento',
            'num_proc' => 'Número de procesamiento',
            'facturas' => 'Facturas',
            'observaciones' => 'Observaciones',
            'moneda' => 'Moneda',
            'prioridad' => 'Prioridad',
            'estatus' => 'Estatus',
            'usuario_asignacion_id' => 'Analista',
            'usuario_autorizacion_id' => 'Autorizado por',
            'fecha_solicitud' => 'Fecha de solicitud',
            'fecha_asignacion' => 'Fecha de asignación',
            'fecha_aceptacion' => 'Fecha de aceptación',
            'fecha_aprobacion' => 'Fecha de aprobación',
            'fecha_cierre' => 'Fecha cierre',
        ];
    }

    protected function getPrettyName() {
        return "solicitudes";
    }

    /**
     * Define una relación pertenece a PersonaBeneficiario
     * @return PersonaBeneficiario
     */
    public function personaBeneficiario() {
        return $this->belongsTo('Persona');
    }

    /**
     * Define una relación pertenece a PersonaSolicitante
     * @return PersonaSolicitante
     */
    public function personaSolicitante() {
        return $this->belongsTo('Persona');
    }

    /**
     * Define una relación pertenece a TipoAyuda
     * @return TipoAyuda
     */
    public function tipoAyuda() {
        return $this->belongsTo('TipoAyuda');
    }

    /**
     * Define una relación pertenece a Area
     * @return Area
     */
    public function area() {
        return $this->belongsTo('Area');
    }

    /**
     * Define una relación pertenece a Referente
     * @return Referente
     */
    public function referente() {
        return $this->belongsTo('Referente');
    }

    /**
     * Define una relación pertenece a Recepcion
     * @return Recepcion
     */
    public function recepcion() {
        return $this->belongsTo('Recepcion');
    }

    /**
     * Define una relación pertenece a Organismo
     * @return Organismo
     */
    public function organismo() {
        return $this->belongsTo('Organismo');
    }

    /**
     * Define una relación pertenece a UsuarioAsignacion
     * @return UsuarioAsignacion
     */
    public function usuarioAsignacion() {
        return $this->belongsTo('UsuarioAsignacion');
    }

    /**
     * Define una relación pertenece a UsuarioAutorizacion
     * @return UsuarioAutorizacion
     */
    public function usuarioAutorizacion() {
        return $this->belongsTo('UsuarioAutorizacion');
    }

    public function getDefaultValues() {
        return [
            'ano' => Carbon::now()->format('Y'),
            'fecha_solicitud' => Carbon::now(),
            'estatus' => 'ELA',
            'ind_mismo_benef' => false,
            'moneda' => 'VEF',
            'prioridad' => 1,
        ];
    }

    public function reglasCreacion() {
        $this->rules = [
            'ind_mismo_benef' => 'required',
            'persona_solicitante_id' => 'required_if:ind_mismo_benef,1',
            'persona_beneficiario_id' => 'required',
            'ind_menor' => 'required',
        ];
    }

    public static function crear(array $values) {
        $solicitud = new Solicitud();
        $solicitud->fill($values);
        $solicitud->reglasCreacion();
        $solicitud->validate();
        return $solicitud;
    }

}
