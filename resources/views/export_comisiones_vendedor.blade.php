<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=comisiones_empleados.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border=1>
<tr style="background-color:#777777;color:#FFFFFF">
<td><b>Usuario</td>
<td><b>Nombre</td>
<td><b>Tienda</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Tipo</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Fecha</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Plan</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Renta</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Plazo</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Contrato</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>DN</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Propiedad</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Comision VENDEDOR</td>
<td style="background-color:#0000FF;color:#FFFFFF"><b>Comision GERENTE</td>
</tr>
<?php
foreach ($comisiones as $comision) {
	?>
	<tr>
	<td>{{$comision->ejecutivo}}</td>
    <td>{{$usuarios[$comision->ejecutivo]}}</td>
    <td>{{$ultimas_tiendas[$comision->ejecutivo]}}</td>
    <td>{{$comision->tipo}}</td>
    <td>{{$comision->fecha}}</td>
    <td>{{$planes[$comision->plan]}}</td>
    <td>{{$comision->renta}}</td>
    <td>{{$comision->plazo}}</td>
    <td>{{$comision->co_id}}</td>
    <td>{{$comision->dn}}</td>
    <td>{{$comision->propiedad}}</td>
    <td>{{$comision->comision_vendedor}}</td>
    <td>{{$comision->comision_gerente}}</td>

	</tr>
<?php
}
?>
<?php
foreach ($comisiones_addon as $comision) {
	?>
	<tr>
	<td>{{$comision->ejecutivo}}</td>
    <td>{{$usuarios[$comision->ejecutivo]}}</td>
    <td>{{$ultimas_tiendas[$comision->ejecutivo]}}</td>
    <td>{{$comision->tipo_addon}}</td>
    <td>{{$comision->fecha}}</td>
    <td>{{$planes[$comision->plan]}}</td>
    <td>{{$comision->tipo_addon=='SEGURO PROTECCION'?$comision->renta_seguro:0}}</td>
    <td>{{$comision->plazo}}</td>
    <td>{{$comision->co_id}}</td>
    <td>{{$comision->dn}}</td>
    <td>{{$comision->propiedad}}</td>
    <td>{{$comision->comision_vendedor}}</td>
    <td>{{$comision->comision_gerente}}</td>

	</tr>
<?php
}
?>
</table>