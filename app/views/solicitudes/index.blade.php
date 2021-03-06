@extends('layouts.master')
@section('contenido')
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-danger">
            <div class="panel-heading" data-toggle="collapse" data-parent="#PanelBusqueda" href="#PanelBusqueda">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#PanelBusqueda" href="#PanelBusqueda">
                        Búsqueda
                    </a>
                </h4>
            </div>
            <div id="PanelBusqueda" class="panel-collapse collapse">             
                @if(isset($campo) or isset($anulando) or isset($reasignar))                
                    <div class="panel-body">
                        {{Form::busqueda(['url'=>'solicitudes','method'=>'GET'])}}
                        @include('solicitudes.busqueda')
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                                
                                <a href="{{url('solicitudes'.$ruta)}}" class="btn btn-default btn-reset"><i class="glyphicon glyphicon-trash"></i> Cancelar</a>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                @else
                    <div class="panel-body">
                        {{Form::busqueda(['url'=>'solicitudes','method'=>'GET'])}}
                        @include('solicitudes.busqueda')
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
                                
                                <a href="{{url('solicitudes')}}" class="btn btn-default btn-reset"><i class="glyphicon glyphicon-trash"></i> Cancelar</a>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                @endif
            </div>
        </div>
        @if(isset($campo))
            @include('solicitudes.asignar')
        @endif
        <div class="panel panel-danger">
            <div class="panel-heading"><h4 class="panel-title">Solicitudes. <small>Mostrando registros del {{$solicitudes->getFrom()}} al {{$solicitudes->getTo()}} de un total de {{$solicitudes->getTotal()}} registros</small></h4></div>
            <div class="panel-body" id='solicitudes-lista'>
                @foreach ($solicitudes as $solicitud)
                    <div class="row filaLista marcar-solicitud agregar-sol">
                        {{Form::hidden('solicitudes[]', $solicitud->id)}}
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            <b>{{$solicitud->personaBeneficiario->nombre_completo}}</b>
                            <br><a href="#" data-toggle="tooltip" data-original-title="{{$solicitud->personaBeneficiario->informacion_contacto}}">(Información de contacto)</a>
                            @unless($solicitud->ind_mismo_benef)
                                <br>Solicitante: {{$solicitud->personaSolicitante->nombre_completo}}
                                <br>Cédula: <b>{{$solicitud->personaSolicitante->ci}}</b><br>
                                <br><a href="#" data-toggle="tooltip" data-original-title="{{$solicitud->personaSolicitante->informacion_contacto}}">(Información de contacto)</a>
                            @endunless
                            <br>Solicitud: <b>{{$solicitud->num_solicitud}}</b>
                            @if(!isset($campo))
                            	<br>Referencia: <b>{{$solicitud->id}}</b><br>
                            	<br>Referido por: <b>{{$solicitud->referente->nombre}}</b>
                            @endif
                            <br>Estatus: <b>{{$solicitud->estatus_display}}</b>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4">
                            {{$solicitud->descripcion}} / {{$solicitud->necesidad}}
                            <br><b>{{$solicitud->area->tipoAyuda->nombre or ""}} / {{$solicitud->area->nombre or ""}}</b>
                            @if(!isset($campo))
                            <br>{{$solicitud->recepcion->nombre or ""}} / {{$solicitud->organismo->nombre or ""}}                            
	                            <br>¿Atención Inmediata?: <b>{{$solicitud->ind_inmediata ? "Si":"No"}}</b>
	                        @endif
	                            <br>Fecha Registro: <b>{{$solicitud->created_at->format('d/m/Y H:i')}}</b>
	                        @if(!isset($campo)))
	                            <br>Autorizado: <b>{{$solicitud->usuarioAutorizacion->nombre or "Sin Asignar"}}</b>
	                            <br>Departamento: <b>{{$solicitud->departamento->nombre or "Sin Asignar"}}</b>
	                            <br>Encargado: <b>{{$solicitud->usuarioAsignacion->nombre or "Sin Asignar"}}</b>
                            @endif
                        </div>
                        <div class="col-xs-12 col-sm-3 col-md-3">
                            @if(count($solicitud->presupuestos)>0)
                                <b>Requerimiento: {{$solicitud->presupuestos[0]->requerimiento->nombre or "Sin Asignar"}}</b>
                                <div style="padding-left: 10px;">
                                @if(!isset($campo))
                                    @if($solicitud->presupuestos[0]->proceso->ind_beneficiario)
                                        Beneficiario: <b>{{$solicitud->presupuestos[0]->beneficiario->nombre or "Sin Asignar"}}</b>
                                    @endif
                                    @if($solicitud->presupuestos[0]->proceso->ind_cantidad)
                                        <br>Cantidad: <b>{{$solicitud->presupuestos[0]->cantidad or "Sin Asignar"}}</b>
                                    @endif
                                @endif
                                    @if($solicitud->presupuestos[0]->proceso->ind_monto)
                                        @if(!isset($campo))
                                        	<br>Monto Solicitado: <b>{{$solicitud->presupuestos[0]->monto or "Sin Asignar"}}</b>
                                        @endif
                                        <br>Monto Aprobado: <b>{{$solicitud->presupuestos[0]->montoapr or "Sin Asignar"}}</b>
                                    @endif
                                @if(!isset($campo)) 
                                    <br>Estatus: <b>{{$solicitud->presupuestos[0]->estatus_doc or "Sin Generar"}}</b>
                                    <br>IdDoc: <b>{{$solicitud->presupuestos[0]->documento_id or "Sin Generar"}}</b>
                                    @if( ($solicitud->presupuestos[0]->proceso_id==1) or ($solicitud->presupuestos[0]->ind_beneficiario=="t") )                                        
                                            <br>N° de Cheque: <b>{{$solicitud->presupuestos[0]->cheque or "Sin Generar"}}</b>                                        
                                    @endif                             
                                    <br>
                                    @if(count($solicitud->presupuestos)>1)
                                        {{HTML::button('solicitudes/requerimientos/'.$solicitud->id, 'plus','Ver más', true)}}
                                    @endif
                                 @endif
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-xs-12 col-sm-2 col-md-2 text-right">
                            {{HTML::button('solicitudes/ver/'.$solicitud->id, 'search','Ver Solicitud')}}
                            <?php
                            $id=Sentry::getUser()->id;
                            ?>
                            @if ($solicitud->usuario_asignacion_id == $id || $solicitud->usuario_asignacion_id == null )
                            @if($solicitud->puedeModificar())
                                {{HTML::button('solicitudes/modificar/'.$solicitud->id, 'pencil','Modificar Solicitud')}}
                            @endif
                            @endif
                            @if(isset($anulando))
                                {{HTML::button('solicitudes/anular/'.$solicitud->id, 'trash','Anular Solicitud', true)}}
                            @endif
                            @if(isset($cerrar))
                                {{HTML::button('solicitudes/cerrar/'.$solicitud->id, 'lock','Cerrar Solicitud', true)}}
                            @endif
                            @if(isset($solo_asignadas) && !isset($reasignar) && $solicitud->puedeAceptarAsignacion())
                                {{HTML::button('solicitudes/aceptarasignacion/'.$solicitud->id, 'check','Aceptar Asignación', true)}}
                            @endif
                            @if(isset($solo_asignadas) && !isset($reasignar) && $solicitud->puedeDevolverAsignacion())
                                {{HTML::button('solicitudes/devolverasignacion/'.$solicitud->id, 'undo','Devolver Asignación', true)}}
                            @endif
                            @if(isset($solo_asignadas) && !isset($reasignar) && $solicitud->puedeSolicitarAprobacion())
                                {{HTML::button('solicitudes/solicitaraprobacion/'.$solicitud->id, 'certificate','Solicitar Aprobación', true)}}
                            @endif
                            {{HTML::button('solicitudes/historial/'.$solicitud->id, 'bitcoin','Bitacora', true)}}
                        </div>
                    </div>
                @endforeach
                <h4><small>Mostrando registros del {{$solicitudes->getFrom()}} al {{$solicitudes->getTo()}} de un total de {{$solicitudes->getTotal()}} registros</small></h4>
                {{$solicitudes->appends(Input::all())->links()}}
            </div>
        </div>
        
    </div>
@stop
@section('javascript')
    {{HTML::script('js/views/solicitudes/index.js')}}
@stop