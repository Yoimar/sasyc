@extends('reportes.html.'.Input::get('formato_reporte','xls'))
@section('reporte')
<?php $i = 1; ?>
<table border="0" cellpadding="10" cellspacing="0">
    <tr >
        <th colspan="9" class="texto-centrado-excel">
            <strong>Relación de Casos Pendientes</strong>  
        </th>
    </tr>
    <thead>
        <tr class="texto-centrado-excel fondo-excel">
            <th>
                <strong>N°T</strong>  
            </th> 
            <th>
                <strong>N°</strong>  
            </th>         
            <th>
                <strong>Referencia</strong>
            </th> 
            <th>
                <strong>Fecha</strong>
            </th>
            <th>
                <strong># Caso</strong>
            </th> 
            <th>
                <strong>Beneficiario</strong>
            </th>
            <th>
                <strong>Estatus</strong>
            </th>        
            <th>
                <strong>Tratamiento</strong>
            </th> 
            <th>
                <strong>Monto</strong>
            </th>
            <th class="texto-centrado-excel fondo-excel">
            </th>
        </tr>
    </thead>
    <!------------------------------------------->
    <?php
    $contador = 0;
    $totalref = 0;
    $subtotal = 0;
    $totalgen = 0;
    $n_caso = 1;
    $n_casoref = 1;
    $referencia = ""
    ?>
    <!------------------------------------------->
    <tbody>
        @foreach($solicitudes as $resultado)
        @if(@$totalref!=0)
        @if(($referencia!= "") && ($referencia!= $resultado->referencia_externa))
        <?php $n_casoref = 1; ?> 
        <tr class="fondo-inferior-excel">
            <td colspan="3">
                <strong>Total {{$referencia}}</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="texto-derecha-excel">{{tm($totalref)}}</td>
            <?php $totalref = 0; ?> 
        </tr>
        @endif 
        @endif 
        <tr>
            <td >
                <strong>{{$n_caso}}</strong>            
            </td>               
            <td >
                <strong>{{$n_casoref}}</strong>
            </td>
            <?php
            $n_caso++;
            $n_casoref++;
            $referencia = trim($resultado->referencia_externa);
            ?>         
            <td >
                {{$referencia}}
            </td >
            <td >
                {{$resultado->created_at->format('d/m/Y')}}
            </td>
            <td >
                {{$resultado->num_solicitud}}
            </td>
            <td > 
                {{$resultado->personaBeneficiario->nombre}}&nbsp;
                {{$resultado->personaBeneficiario->apellido}}
            </td>
            <td >
                {{$resultado->estatus_display}}
            </td>        
            <td >
            </td>
            <td class="texto-derecha-excel">
            </td>
        </tr>

        @foreach($resultado->presupuestos as $key=>$presupuesto)
        <tr>
            <td >
            </td>
            <td >
            </td>        
            <td >
            </td>
            <td >
            </td>
            <td >
            </td>
            <td > 
            </td>
            <td >
            </td>        
            <td>
                {{$presupuesto->requerimiento->nombre}}
            </td>
            <td class="texto-derecha-excel">
                {{$presupuesto->montoapr_for}}
            </td>
        </tr>
        <?php
        $subtotal += $presupuesto->montoapr;
        $totalref+=$presupuesto->montoapr;
        $totalgen+=$presupuesto->montoapr;
        ?>
        @endforeach 
        <?php $i++; ?>
        @if(@$subtotal!=0)
        <tr class="fondo-inferior-excel">
            <td colspan="3">
                <strong>Total Caso {{$resultado->num_solicitud}}</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="texto-derecha-excel">{{tm($subtotal)}}</td>
        </tr>
        @endif    
        <?php
        $contador++;
        $subtotal = 0;
        ?> 
        @endforeach    
        @if(@$totalref!=0)
        <tr class="fondo-inferior-excel">
            <td colspan="3">
                <strong>Total {{$referencia}}</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="texto-derecha-excel">{{tm($totalref)}}</td>
        </tr>
        @endif     
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>     
        <tr class="fondo-inferior-excel">
            <td class="texto-centrado-excel">
                <strong>{{$n_caso-1}}</strong>
            </td>
            <td class="texto-centrado-excel">            
            </td>        
            <td >
                <strong>Monto Total General</strong>
            </td> 
            <td >

            </td>
            <td >

            </td> 
            <td >

            </td>
            <td >

            </td> 
            <td >

            </td>
            <td class="texto-derecha-excel">
                <strong>{{tm($totalgen)}}</strong>
            </td>
        </tr>
    </tbody>
</table>
@endsection