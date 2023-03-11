<?php 
require ('../Connections/conexion.php');
	
	//$id_estado = $_POST['id_estado'];

	
	$queryM = "SELECT patologia FROM patologias ORDER BY patologia";
	
	$resultadoM = $mysqli->query($queryM);
	
	$html= "<option value='0'>Seleccionar Patologias</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['patologia']."'>".$rowM['patologia']."</option>";
	}
	
	echo $html;
?>		