{{Form::open(['url'=>'solicitudes/nueva', 'id'=>'nuevaSolicitud'])}}
<div class="row" id="div-mismo-benef">
    {{Form::btInput($solicitud,'ind_mismo_benef')}}
</div>  
<div id='div-solicitante'>
    <hr>
    <h4>Datos del Solicitante</h4>
    {{Form::hidden('persona_solicitante_id', Input::old('persona_solicitante_id'), ['id'=>'persona_solicitante_id'])}}
    <div class="row">

        {{Form::btInput($personaSolicitante,'tipo_nacionalidad_id',5)}}
        {{Form::btInput($personaSolicitante,'ci',5)}}
        <div class="col-xs-12 col-sm-12 col-md-2">
            <div class="form-group">
                    <button type="button" class="btn btn-primary buscar-cne"><i class="glyphicon glyphicon-search"></i> CNE</button>
            </div> 
        </div>     
    </div>
    <div class="row">
        {{Form::btInput($personaSolicitante,'nombre',5)}}
        {{Form::btInput($personaSolicitante,'apellido',5)}}
        <div class="col-xs-12 col-sm-12 col-md-2">
            <div class="form-group">
                <button type="button" class="btn btn-primary buscar-sate"><i class="glyphicon glyphicon-search"></i> SATE</button>
            </div> 
        </div>           
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="button" class="btn btn-primary salvar-persona" style="display: none;"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
        </div>
    </div>
    <div id="lista-relacionados"></div>  
</div>
<hr>
<h4>Datos del Beneficiario</h4>
<div class="row">
    {{Form::btInput($solicitud,'ind_beneficiario_menor')}}
</div>
<div id='div-beneficiario'>
    {{Form::hidden('persona_beneficiario_id', Input::old('persona_beneficiario_id'), ['id'=>'persona_beneficiario_id'])}}
    <div class="row">
        <div id="div-menor">
            {{Form::btInput($personaBeneficiario,'tipo_nacionalidad_id',5)}}
            {{Form::btInput($personaBeneficiario,'ci',5)}}
            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <button type="button" class="btn btn-primary buscar-cne"><i class="glyphicon glyphicon-search"></i> CNE</button>
                </div> 
            </div>     
        </div>
    </div>
    <div class="row">
        {{Form::btInput($personaBeneficiario,'nombre',5)}}
        {{Form::btInput($personaBeneficiario,'apellido',5)}}
        <div class="col-xs-12 col-sm-12 col-md-2">
            <div class="form-group">
                <button type="button" class="btn btn-primary buscar-sate"><i class="glyphicon glyphicon-search"></i> SATE</button>
            </div> 
        </div>            
    </div>
    <div class="row">
        <div class="col-lg-12">
             @if(Usuario::puedeAcceder('POST.solicitudes.nueva'))
            <button type="button" class="btn btn-primary salvar-persona" style="display: none;"><i class="glyphicon glyphicon-floppy-disk"></i> Guardar</button>
             @endif
        </div>
    </div>
    <div id="lista-solicitudesanteriores"></div>     
</div>
<hr>
@include('templates.bootstrap.submit',['nombreSubmit'=>'Siguiente','nomostrar'=>true,'icon'=>'forward', 'clase'=>'siguiente'])
@section('javascript')
{{HTML::script('js/views/solicitudes/nuevasolicitud.js')}}
@stop
{{Form::close()}}