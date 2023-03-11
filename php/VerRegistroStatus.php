<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de Registro del Solicitante</title>
</head>

<body>
<div align="center">
  <pre dir="ltr">&nbsp;</pre>
</div>

<?php require_once('../Connections/conexion.php'); ?>
<?php
$query_NuevoStatus = "SELECT * FROM definicion_status ORDER BY nombre_defsta ASC";
$NuevoStatus = mysql_query($query_NuevoStatus, $con) or die(mysql_error());
$row_NuevoStatus = mysql_fetch_assoc($NuevoStatus);
$totalRows_NuevoStatus = mysql_num_rows($NuevoStatus);
?><style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:879px;
	height:374px;
	z-index:1;
	left: 198px;
	top: 124px;
}
-->
</style>
 <?php 
//condicionar si los datos son enviados por POST o por GET cuando se registre el nuevo status
$seleccion = $_GET['seleccion'];

//Consulta para la busqueda segun la opcion ingresada por el paciente
$ConsultaSolicitud = "SELECT id_solici, numero_solici, requerimientos_solici, edad_pac, fecha_solici, fec_nac_pac, cedula_pac, nombre_pac, apellido_pac, sector_pac, telefono1_pac, telefono2_pac, cedula_rep, nombre_rep, apellido_rep, telefono_rep, localidad, municipio, estado, nombre_login, apellido_login
FROM (((((((solicitud as sol 
INNER JOIN paciente as pac ON pac.id_pac = sol.id_pac1) 
LEFT JOIN union_pac_rep as uni ON uni.id_pac1 = pac.id_pac) 
LEFT JOIN representante as rep ON rep.id_rep = uni.id_rep1) 
INNER JOIN t_localidad as parroq ON parroq.id_localidad = sol.id_localidad1)
INNER JOIN t_municipio as munici ON munici.id_municipio = parroq.id_municipio) 
INNER JOIN t_estado as est ON est.id_estado = munici.id_estado)
INNER JOIN login as log ON log.id_login = sol.id_login)
WHERE id_solici = $seleccion";

$ResultadoSolicitud = mysqli_query($con, $ConsultaSolicitud); // se ejecuta la consulta
$ExtSolici = mysqli_fetch_assoc($ResultadoSolicitud);// se extraen todos los datos del Id seleccionado

$IngresadoPor = ($ExtSolici['nombre_login'].$ExtSolici['apellido_login']);

?>

<?php 
//inicio del cuerpo del programa de aca en adelante
 ?>

<div id="Layer1">
  <p align="left">&nbsp;</p>
  <table width="878" height="104" border="0">
    <tr>
      <th colspan="3" scope="col"><strong><em>STATUS DE SOLICITUD DEL PACIENTE </em></strong></th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
    <tr>
      <th colspan="2" scope="col"><div align="left"><strong>Fecha: </strong><?php print ($ExtSolici['fecha_solici']); ?> </div></th>
      <th width="341" scope="col"><div align="left"></div></th>
      <th width="30" scope="col"><div align="left"></div></th>
      <th width="37" scope="col"><div align="left"></div></th>
    </tr>
    <tr>
      <td colspan="2"><strong>Nro. Solicitud: </strong><?php print ($ExtSolici['numero_solici']); ?></td>
      <td><div align="left"></div></td>
      <td><div align="left"></div></td>
      <td><div align="left"></div></td>
    </tr>
    <tr>
      <td colspan="2"><div align="left"><strong>Responsable: </strong><?php print ($IngresadoPor); ?></div></td>
      <td><div align="left"></div></td>
      <td><div align="left"></div></td>
      <td><div align="left"></div></td>
    </tr>
    <tr>
      <td height="23" colspan="2"><div align="left">
        <h2>Paciente:</h2>
      </div></td>
      <td><div align="left">
        <h2>Representante</h2>
      </div></td>
      <td><div align="left"></div></td>
      <td><div align="left"></div></td>
    </tr>
    <tr>
      <td height="23" colspan="2"><strong>C&egrave;dula: </strong><?php print ($ExtSolici['cedula_pac']); ?> </td>
      <td><strong>C&egrave;dula: </strong><?php print ($ExtSolici['cedula_rep']); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="2"><strong>Nombre y Apellido: </strong><?php print ($ExtSolici['nombre_pac']." ".$ExtSolici['apellido_pac']); ?></td>
      <td><strong>Nombre y Apellido: </strong><?php print ($ExtSolici['nombre_rep']." ".$ExtSolici['apellido_rep']); ?> </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="181" height="23"><strong>Fecha de Nac.</strong> <?php print ($ExtSolici['fec_nac_pac']); ?></td>
      <td width="255">Edad: <?php print ($ExtSolici['edad_pac']); ?></td>
      <td><strong>Telefonos rep: </strong><?php print ($ExtSolici['telefono_rep']); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="2"><strong>Telefonos pac:</strong> <?php print ("Represe".$ExtSolici['telefono1_pac']." ".$ExtSolici['telefono2_pac']); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="3"><strong>Direccion:</strong> <?php print ($ExtSolici['estado']." - ".$ExtSolici['municipio']." - ".$ExtSolici['localidad']." - ". $ExtSolici['sector_pac']); ?></td>      
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="3"><strong>Requerimientos:</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="3"> <?php print ($ExtSolici['requerimientos_solici']); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="23" colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>    
<?php 
  $IdSolici = $ExtSolici['telefono1_pac'];
      $ConsultaStatus = "SELECT observaciones_status, fecha_status, nombre_defsta FROM (status INNER JOIN definicion_status as def ON status.id_defsta1 = def.id_defsta) WHERE id_solici1 = 2 order by id_status;";
      $ResultadoStatus = mysqli_query($con , $ConsultaStatus);
      $ContadorStatus=0;
      ?>    
    
<?php 
      while($VerStatus = mysqli_fetch_assoc($ResultadoStatus))
        { $ContadorStatus++;?>
          <tr>            
            <td colspan="3"><strong>Status</strong> <?php printf(" ".$ContadorStatus.":") ?> <strong>Fecha:</strong> <?php echo $VerStatus["fecha_status"]; ?> </td>            
            <td></td>   
			<td></td>
          </tr>             
          <tr>
            <td><strong>Estado:</strong><?php echo " -- ".$VerStatus["nombre_defsta"]; ?></td>
			<td><strong>Observacion:</strong><?php echo " -- ".$VerStatus["observaciones_status"]; }?></td>
            <td></td>
			<td></td>
			<td></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td></td>
            <td></td>
          </tr> 
  </table> 
<table width="876" border="0">
	<tr>
		<td><div align="center">
		  <input type="button" name="imprimir" value="Imprimir P&aacute;gina" onclick="window.print();">
	    </div></td>
	</tr>
</table>
  
</div>
</body>
</html>
