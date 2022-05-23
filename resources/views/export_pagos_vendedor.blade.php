<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=payment_empleados.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border=1>
<tr style="background-color:#777777;color:#FFFFFF">
<td><b>Usuario</td>
<td><b>Nombre</td>
<td><b>Tienda</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Comision</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Bono Rentas</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Total Pago</td>
</tr>
<?php
foreach ($pagos as $pago) {
	?>
	<tr>
	<td>{{$pago->ejecutivo->user}}</td>
    <td>{{$pago->ejecutivo->name}}</td>
    <td>{{$pago->ejecutivo->subarea->nombre}}</td>
	<td style="color:#0000FF"><b>{{$pago->comisiones}}</td>
	<td style="color:#0000FF"><b>{{$pago->bono_rentas}}</td>
    <td style="background-color:#0000FF;color:#FFFFFF"><b>{{$pago->total_pago}}</td>
	</tr>
<?php
}
?>
</table>