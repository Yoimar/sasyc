@extends('reportes.html.'.Input::get('formato_reporte','pdf'))
@section('reporte')
    <h4 ALIGN=CENTER >Relación de Casos Pendientes</h4>
    <table border="0" cellpadding="5" cellspacing="3">
        <tr style=' background:#d8d8d8;'>
            <td style="width: 140px;height:auto; font-size: 13px;"  valign="middle">
                <strong>Referencia</strong>
            </td> 
            <td style="width: 50px;height: auto; font-size: 13px;" ALIGN=CENTER  valign="middle">
                <strong>Fecha</strong>
            </td>
            <td style="width: 80px;height: auto; font-size: 13px;" ALIGN=CENTER  valign="middle">
                <strong># Caso</strong>
            </td> 
            <td style="width: 170px;height: auto; font-size: 13px;"  valign="middle">
                <strong>Beneficiario</strong>
            </td>
            <td style="width: 130px;height: auto; font-size: 13px;"  valign="middle">
                <strong>Tratamiento</strong>
            </td> 
            <td style="width: 130px;height: auto; font-size: 13px;"  valign="middle">
                <strong>Estatus</strong>
            </td>
            <td style="width: 130px;height: auto; font-size: 13px;"  valign="middle">
                <strong>Monto</strong>
            </td>
        </tr>
        <!------------------------------------------->
        <?php $contador=0; $subtotal=0; ?>
        <!------------------------------------------->
        @foreach($solicitudes as $resultado)
            @foreach($resultado->presupuestos as $key=>$presupuesto)
                <tr>
                    <td style="width: 140px;height:auto;">
                        {{$presupuesto->solicitud->referente_externo}}
                    </td>
                    <td ALIGN=CENTER style="width: 50px;height:auto;">
                        {{$presupuesto->solicitud->created_at->format('d/m/Y')}}
                    </td>
                    <td ALIGN=CENTER style="width: 80px;height:auto;">
                        {{$presupuesto->solicitud->num_solicitud}}
                    </td>
                    <td style="width: 170px;height:auto;"> 
                        {{$presupuesto->solicitud->personaBeneficiario->nombre}}&nbsp;
                        {{$presupuesto->solicitud->personaBeneficiario->apellido}}
                    </td>
                    <td style="width: 130px;height:auto;">
                        {{$presupuesto->requerimiento->nombre}}
                    </td>
                    <td ALIGN=CENTER style="width: 130px;height:auto;">
                        {{$presupuesto->solicitud->estatus_display}}
                    </td>
                    <td ALIGN=right style="width: 130px;height:auto;">
                       {{$presupuesto->monto_for}}
                    </td>
                </tr>
                <?php 
                    $total += $presupuesto->monto;
                    $subtotal+=$presupuesto->monto;
                ?>
                <!------------------------------------------->
                @if($presupuesto->monto_for != null)
                    @if(($parametro[$contador]!= $parametro[$contador+1]))
                    <tr style="background: yellow;">
                        <td><strong>Total</strong></td><td></td><td></td><td></td>
                        <td></td><td></td>
                        <td valign="middle" ALIGN=right>{{tm($subtotal)}}</td>
                    </tr> <?php $contador++;  $subtotal=0; ?>         
                    @endif
                @endif
                <!------------------------------------------->
            @endforeach 
        @endforeach    
        <!------------------------------------------->
        <tr style="background: yellow;">
           <td><strong>Total</strong></td><td></td><td></td><td></td>
           <td></td><td></td>
           <td valign="middle" ALIGN=right>{{tm($subtotal)}}</td>
       </tr>
       <!------------------------------------------->
        <tr style=' background: lightcyan;'>
            <td style="width: 140px;height:auto; font-size: 13px;"  valign="middle">
                <strong>Total General</strong>
            </td> 
            <td style="width: 50px;height: auto; font-size: 13px;" ALIGN=CENTER  valign="middle">
                
            </td>
            <td style="width: 80px;height: auto; font-size: 13px;" ALIGN=CENTER  valign="middle">
               
            </td> 
            <td style="width: 170px;height: auto; font-size: 13px;"  valign="middle">
                
            </td>
            <td style="width: 130px;height: auto; font-size: 13px;"  valign="middle">
                
            </td> 
            <td style="width: 130px;height: auto; font-size: 13px;"  valign="middle">
                
            </td>
            <td style="width: 130px;height: auto; font-size: 13px;"  valign="middle" ALIGN=right>
                <strong>{{tm($total)}}</strong>
            </td>
        </tr>
    </table>
@endsection