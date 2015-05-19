<div class="modal-dialog" id="div-candidato-documentos">
    <div class="modal-content">
        {{Form::open(array('url'=>'solicitudes/solicitaraprobacion', 'class'=>'saveajax'))}}
        {{Form::hidden('id', $solicitud->id)}}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Cerrar</span>
            </button>
            <h4 class="modal-title">Enviar solicitud de aprobacion</h4>
        </div>
        <div class="modal-body">
            @include('solicitudes.detalle_solicitud_modal')
            {{Form::btInput($solicitud, 'usuario_autorizacion_id')}}
            <h4>Presupuestos</h4>
            {{HTML::simpleTable($solicitud->presupuestos, 'Presupuesto')}}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
             @if(Usuario::puedeAcceder('GET.solicitudes.solicitaraprobacion'))
            <button type="submit" class="btn btn-primary">Solicitar Aprobación</button>
            @endif
        </div>
        {{Form::close()}}
    </div>
</div>