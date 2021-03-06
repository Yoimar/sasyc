@extends('administracion.principal')
@section('contenido2')
<div class="panel panel-danger">
    <div class="panel-heading">
        @include('templates.tituloBarra',array('obj'=>$recepcion, 'titulo'=>'recepcion'))
    </div>
    <div class="panel-body">
        @include('templates.errores')
        {{Form::open(array('url'=>'administracion/tablas/recepciones'))}}
        {{Form::concurrencia($recepcion)}}
        <div class="row">
        	{{Form::hidden('id',$recepcion->id)}}
            {{Form::btInput($recepcion, 'nombre', 6)}}
        </div>
        {{Form::submitBt()}}
        {{Form::close()}}
    </div>
</div>
@stop