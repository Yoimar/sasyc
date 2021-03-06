{{Form::open(['url'=>'solicitudes/asignar', 'class'=>'saveajax','data-callback'=>'asignado'])}}
<div class="panel panel-danger">
  @if(isset($reasignar))
    <div class="panel-heading"><h4 class="panel-title">Reasignar solicitudes seleccionadas</h4></div>
  @else
    <div class="panel-heading"><h4 class="panel-title">Asignar solicitudes seleccionadas</h4></div>
  @endif
    <div class="panel-body">
        <div id='solicitudes-marcadas'>

        </div>
        <div class="row">
            {{Form::hidden('campo', $campo)}}
            @if($campo=="departamento")
            {{Form::btInput($solicitud, 'departamento_id')}}
            @elseif($campo=="usuario")
            {{Form::btInput($solicitud, 'usuario_asignacion_id', 12, 'select',[],$analistas)}}
            @endif
        </div>
        @if(Usuario::puedeAcceder('POST.solicitudes.asignar'))
        @include('templates.bootstrap.submit', ['nomostrar'=>true, 'nombreSubmit'=>'Asignar'])
        @endif
    </div>
</div>
{{Form::close()}}