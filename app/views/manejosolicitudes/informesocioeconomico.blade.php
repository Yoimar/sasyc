{{Form::hidden('id',$solicitud->id)}}
<div class="row">
    {{Form::btInput($solicitud,'tipo_vivienda_id',4)}}
    {{Form::btInput($solicitud,'tenencia_id',4)}}
    {{Form::btInput($solicitud,'total_ingresos',4)}}
</div>
<div class="row">
    {{Form::textarea('informe_social',$solicitud->informe_social, array('class' => 'form-control ckeditor','placeholder'=>'Informe social','required'=>'','id'=>'editor_informe')) }}
</div>
<hr>
@include('templates.bootstrap.submit')
