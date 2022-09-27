<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ventas_cl.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border=1>
<tr bgcolor="#eeeeee">
    <td class=""><center>Vendido por</td>
    <td class=""><center>Sucursal</td>
    <td class=""><center>Movimiento</td>
    <td class=""><center>Cliente</td>
    <td class=""><center>Plan</td>
    <td class=""><center>Renta</td>
    <td class=""><center>Plazo</td>
    <td class=""><center>Fecha</td>
    <td class=""><center>Propiedad</td>
    <td class=""><center>IMEI</td>
    <td class=""><center>ICCID</td>
    <td class=""><center>DN</td>
    <td class=""><center>Cliente</td>
    <td class=""><center>Addon control</td>
    <td class=""><center>Seguro de Proteccion</td>
    <td class=""><center>Renta Seguro</td>
    <td class=""><center>Cuenta</td>
    <td class=""><center>Orden</td>
    <td class=""><center>Forma Pago</td>
    <td class=""><center>CO_ID</td>
    <td class=""><center>Observaciones</td>
    <td class=""><center>Fecha Captura</td>
</tr>
<?php
foreach ($registros as $venta) {
	?>
<tr>
<td class="">{{$venta->det_ejecutivo->name}}</td>
<td class="">{{$venta->det_sucursal->nombre}}</td>
<td class="">{{$venta->tipo}}</td>
<td class="">{{$venta->cliente}}</td>
<td class="">{{$venta->det_plan->nombre}}</td>
<td class=""><center>${{number_format($venta->renta,2)}}</td>
<td class=""><center>{{$venta->plazo}}</td>
<td class=""><center>{{$venta->fecha}}</td>
<td class=""><center>{{$venta->propiedad}}</td>
<td class=""><center>{{$venta->imei}}</td>
<td class=""><center>{{$venta->iccid}}</td>
<td class=""><center>{{$venta->dn}}</td>
<td class=""><center>{{$venta->cliente}}</td>
<td class=""><center>{{$venta->addon_control}}</td>
<td class=""><center>{{$venta->seguro_proteccion}}</td>
<td class=""><center>{{$venta->renta_seguro}}</td>
<td class=""><center>{{$venta->cuenta}}</td>
<td class=""><center>{{$venta->orden}}</td>
<td class=""><center>{{$venta->forma_pago}}</td>
<td class=""><center>{{$venta->cis_id}}</td>
<td class=""><center>{{$venta->observaciones}}</td>
<td class=""><center>{{$venta->created_at}}</td>

<td class=""></td>
</tr>
<?php
}
?>
</table>