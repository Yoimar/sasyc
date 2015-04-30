@foreach($permisos as $key=>$seccion)
<div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#acordion" href="#acordion{{$key}}{{$asignados}}">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#acordion" href="#acordion{{$key}}{{$asignados}}">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10">
                        {{$seccion['Descripcion'] or "Sin información"}}
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
                        <div class="text-right">
                            @if($asignados)
                            <button type="button" class="btn btn-danger btn-xs" title="Denegar permiso" onclick="denegarPermisoPorGrupo('acordion{{$key}}{{$asignados}}','{{$grupo->id}}');"><i class="glyphicon glyphicon-arrow-left"></i></button>
                            @else
                             <button type="button" class="btn btn-danger btn-xs" title="Conceder permiso" onclick="concederPermisoPorGrupo('acordion{{$key}}{{$asignados}}','{{$grupo->id}}');"><i class="glyphicon glyphicon-arrow-right"></i></button>                           
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        </h4>
    </div>
    <div id="acordion{{$key}}{{$asignados}}" class="panel-collapse collapse">
        <div class="panel-body">
            <table class="table table-hover table-bordered">
                <?php unset($seccion['Descripcion']); ?>
                @foreach($seccion as $key2=>$permisos)
                <tr>
                    <td width="95%">
                        {{$permisos}}
                    </td>
                    @if($asignados)
                    <td>
                         <button type="button" class="btn btn-danger btn-xs" title="Denegar permiso" onclick="denegarPermiso('{{$grupo->id}}','{{$key2}}');"><i class="glyphicon glyphicon-arrow-left"></i></button>
                    </td>
                    @else
                    <td>
                        <button type="button" class="btn btn-primary btn-xs" title="Conceder permiso" onclick="concederPermiso('{{$grupo->id}}','{{$key2}}');"><i class="glyphicon glyphicon-arrow-right"></i></button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@section('javascript')
    {{HTML::script('js/views/administracion/permisos.js')}}
@stop

@endforeach