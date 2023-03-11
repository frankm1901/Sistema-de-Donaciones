 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta charset="utf-8">
<head>
	
<?php require_once('../includes/header.php');?>	

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<link rel="stylesheet" href="../css/modal.css">
<link rel="stylesheet" href="../css/spinner.css">
<!--<meta http-equiv="refresh" content="1;registro_paciente.php" />-->
<style type="text/css" src="../css/modal.css"></style>

</head>
<body>
<?php include '../Connections/conexion.php'; ?>
<?php  
	session_start();
	
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
   <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
      <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Ingresar Paciente</span></h4>
   </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <h1 class="w3-xxxlarge w3-text-white">Ingresar Paciente</h1></b>
  </header>
  
  <br><br><br>
  <div class="w3-container w3-margin-top">
     <div class="spinner">
         <div class="bounce1"></div>
         <div class="bounce2"></div>
         <div class="bounce3"></div>
     </div>
  </div>

<?php

$seleccion = $_POST['seleccion'];

// Recibimos las variables mediante el methodo POST	
//Asignamos las variables a los datos de Inicio del Formulario
$fecha_ingreso = $_POST['fecha_ingreso']; //esta fecha se toma desde el momento en que se hace el registro
//print("<br>Numero de Solicitud es: ".$numero_solici);
$IdLogin=$_SESSION['Id_Login'];

// Asignamos las variables a los datos del Paciente
$edad_pac = $_POST['edad_pac'];
$fec_nac_pac = $_POST['user_date'];
$nombre_pac = $_POST['nombre_pac'];
$apellido_pac = $_POST['apellido_pac'];
$cedula_pac = $_POST['cedula_pac'];
$sector_pac = $_POST['sector_pac'];
$telefono1_pac = $_POST['telefono1_pac'];
$telefono2_pac = $_POST['telefono2_pac'];
//Condicionamos si la variable esta vacia y se le asigna un valor 0 
if (empty($_POST['telefono2_pac'])){ $telefono2_pac = 0 ; echo "la variable esta vacia: ".$_POST['telefono2_pac']."<br>"; }
$id_parroq = $_POST['cbx_localidad'];
$id_redsal = 333;





//Declaracion de la Variable Error a los fines de enviar un mensaje en caso de no insertar algun registro
	$Error=true;
	$ErrorActUnion = "";
	$ErrorInsPac = "";
	$ErrorActPac = "";
	$ErrorInsRep = "";
	$ErrorActRep = "";
	$ErrorInsStatus = "";
	$ErrorInsSolicitud = "";
	$ErrorInsUnion = "";
	$ActPac = "";
	$ActRep = "";
	$ExitoSolicitud = false;
	$InsertarPM = "";
	$InsertarAM = "";

?>

<?php 


//Realizamos la consulta para obtener la informacion de todos los registros antes de ser modificados
//Consulta para la Tabla Paciente
  $ConsultaSolicitud = "SELECT DISTINCT id_solici, numero_solici, requerimientos_solici, edad_pac, fecha_solici, fec_nac_pac, cedula_pac, nombre_pac, apellido_pac, sector_pac, telefono1_pac, telefono2_pac, cedula_rep, nombre_rep, apellido_rep, telefono_rep, localidad, municipio, estado, nombre_login, apellido_login, nombre_redsal, nombre_defsta, observaciones_status
FROM ((((((((((solicitud as sol 
INNER JOIN paciente as pac ON pac.id_pac = sol.id_pac1) 
LEFT JOIN union_pac_rep as uni ON uni.id_pac1 = pac.id_pac) 
LEFT JOIN representante as rep ON rep.id_rep = uni.id_rep1) 
INNER JOIN t_localidad as parroq ON parroq.id_localidad = sol.id_localidad1)
INNER JOIN t_municipio as munici ON munici.id_municipio = parroq.id_municipio) 
INNER JOIN t_estado as est ON est.id_estado = munici.id_estado)
INNER JOIN login as log ON log.id_login = sol.id_login)
INNER JOIN redsalud as red ON red.id_redsal = sol.id_redsal1)
LEFT JOIN status as status ON status.id_solici1 = sol.id_solici)
LEFT JOIN definicion_status as defsta ON defsta.id_defsta = status.id_defsta1)
WHERE id_solici = '$seleccion'";


$ResultadoSolicitud = mysqli_query($mysqli , $ConsultaSolicitud); // se ejecuta la consulta
//AM = ANTES MODIFICADOS
$AM = mysqli_fetch_assoc($ResultadoSolicitud);// se extraen todos los datos del Id seleccionado


echo "/********************************************La Solicitud antes de la Modificacion: <br>";
echo $AM."<br>";


//Asignacion de las variables a utiliza en la insercion de los datos a la tabla modificacion
$AMnumero_solici = $AM['numero_solici']; $AMrequerimientos_solici = $AM['requerimientos_solici']; $AMedad_pac = $AM['edad_pac']; $AMfecha_solici = $AM['fecha_solici']; $AMfec_nac_pac = $AM['fec_nac_pac']; $AMcedula_pac = $AM['cedula_pac']; $AMnombre_pac = $AM['nombre_pac']; $AMapellido_pac = $AM['apellido_pac']; $AMsector_pac = $AM['sector_pac']; $AMtelefono1_pac = $AM['telefono1_pac']; $AMtelefono2_pac = $AM['telefono2_pac']; $AMcedula_rep = $AM['cedula_rep']; $AMnombre_rep = $AM['nombre_rep']; $AMapellido_rep = $AM['apellido_rep']; $AMtelefono_rep = $AM['telefono_rep']; $AMlocalidad = $AM['localidad']; $AMmunicipio = $AM['municipio']; $AMestado = $AM['estado']; $AMnombre_login = $AM['nombre_login']; $AMapellido_login = $AM['apellido_login']; $AMnombre_redsal = $AM['nombre_redsal']; $AMnombre_defsta = $AM['nombre_defsta']; $AMobservaciones_status = $AM['observaciones_status'];



// Metodo para la insercion de los datos en la tabla modificacion

$insertAM = "INSERT INTO modificados (AM_PM, id_login1, numero_solici, requerimientos, edad_pac, fecha_solici, fecha_nac_pac, cedula_pac, nombre_pac, apellido_pac, sector_pac, telefono1_pac, telefono2_pac, cedula_rep, nombre_rep, apellido_rep, telefono_rep, localidad, municipio, estado, nombre_login, apellido_login, nombre_defsta, observaciones_status) VALUES ('AM', $IdLogin, '$AMnumero_solici', '$AMrequerimientos_solici', '$AMedad_pac', '$AMfecha_solici', '$AMfec_nac_pac', '$AMcedula_pac', '$AMnombre_pac', '$AMapellido_pac', '$AMsector_pac', '$AMtelefono1_pac', '$AMtelefono2_pac', '$AMcedula_rep', '$AMnombre_rep', '$AMapellido_rep', '$AMtelefono_rep', '$AMlocalidad', '$AMmunicipio', '$AMestado', '$AMnombre_login', '$AMapellido_login', '$AMnombre_defsta', '$AMobservaciones_status')";

$ejecutaInsertAM = mysqli_query($mysqli, $insertAM);

if (!$ejecutaInsertAM) {$Error = 'false'; $InsertarAM = "Error al Insertar - AM - en la Tabla de Modificados ";} //echo "<br> ************************Error al Insertar - PM - en la Tabla de Modificados **************************** <br>";}else echo "<br>************************   Exito al Insertar PM en la Tabla de Donaciones   *****************";


///				PACIENTE
///************************************************************************************
//Extraer el ID del Paciente en la tabla solicitud
$extraerIdSolici = " SELECT id_pac1 FROM solicitud where id_pac1 = '$seleccion'";
$resultadExtraerIdSolici = mysqli_query ($mysqli, $extraerIdSolici);
$VerIdSolici = mysqli_fetch_assoc($resultadExtraerIdSolici);
$idPac = $VerIdSolici['id_pac1'];

		 //Consulta de los datos a la Tabla Paciente
			$Tablapaciente =("UPDATE paciente SET fec_nac_pac = '$fec_nac_pac', nombre_pac = '$nombre_pac', apellido_pac = '$apellido_pac', cedula_pac = '$cedula_pac', sector_pac = '$sector_pac', id_parroq2 = '$id_parroq', telefono1_pac = '$telefono1_pac', telefono2_pac = '$telefono2_pac' WHERE id_pac = '$idPac';");
			//Se procede a realizar la Actualizacion de los datos
			$ActualizarTpaciente = mysqli_query($mysqli, $Tablapaciente);	

			//Verificacion de la Insercion del Registro
			if (!$ActualizarTpaciente){$error = "false"; $ErrorActPac =" <br> Error al Actualizar Datos del Paciente <br>";}
			
		
		$Representante = "false"; $IdRep = 0;


///	REPRESENTANTE
///*************************************************************************************
if (!isset($_POST['cedula_rep']) and !isset($_POST['telefono_rep']) and !isset($_POST['nombre_rep']) and !isset($_POST['apellido_rep']))
	{	$EnviadoRep = 'false';
		$cedula_rep = "";
		$telefono_rep = "";
		$nombre_rep = "";
		$apellido_rep = "";	
	}
else{	
		echo "<br>cedula_rep: ".$cedula_rep = $_POST['cedula_rep'];
		echo "<br>telefono_rep: ".$telefono_rep = $_POST['telefono_rep'];
		echo "<br>nombre_rep: ".$nombre_rep = $_POST['nombre_rep'];
		echo "<br>apellido_rep: ".$apellido_rep = $_POST['apellido_rep'];
		$Representante = 'true';

//para verificar si el REPRESENTANTE ya existe	
		$consultacedularep = "SELECT id_rep, cedula_rep FROM representante WHERE cedula_rep = '$cedula_rep'";
		$resultadocedularep = mysqli_query($mysqli , $consultacedularep);		
		$rowcedularep = mysqli_fetch_row($resultadocedularep); //extrae los datos en caso de que hallan registros
	    
	    $cantidad_representante = mysqli_num_rows($resultadocedularep);//contar si hay registros coincidentes		
		
		if ($cantidad_representante == 0 )	{	
			
		//Consulta de los datos a la Tabla Representante	
			$Trepresentante =("INSERT INTO representante (nombre_rep, apellido_rep, cedula_rep, telefono_rep) VALUES ('$nombre_rep', '$apellido_rep', '$cedula_rep', '$telefono_rep')");		
		//Se procede a realizar la insercion de los datos
			$RegistroTrepresentante = mysqli_query($mysqli, $Trepresentante);

		if (!$RegistroTrepresentante){$Error=false; $ErrorinsRep = "Insertar Datos del Representante <br>";}		

		//Metodo para extraer el ID del Representante
			if ($result1 = mysqli_query($mysqli, "SELECT id_rep FROM representante"))
			{$IdRep = mysqli_num_rows($result1); mysqli_free_result($result1);	}				
			$Representante = 'true';			
		}
		else
		{
			$IdRep = $rowcedularep [0];
			$CedulaRep = $rowcedularep [1];	
			$Representante = 'true';			
		
		//Consulta de los datos a la Tabla Representante
			$TablaRepresentante =("UPDATE representante SET nombre_rep = '$nombre_rep', apellido_rep  = '$apellido_rep', cedula_rep= '$cedula_rep', telefono_rep= '$telefono_rep' WHERE id_rep = '$IdRep'");
		//Se procede a realizar la Actualizacion de los datos
			$ActualizarTRepresentante = mysqli_query($mysqli, $TablaRepresentante);	

		//Verificacion de la Insercion del Registro
			if (!$ActualizarTRepresentante){$error = "false"; $ErrorActRep="<br> Error al Actualizar Datos del Representante <br>";}							
		}
	}
//			SOLICITUD			
///*************************************************************************************



?>
</div>


<?php 

//Realizamos la consulta para obtener la informacion de todos los registros despues de ser modificados
//Consulta para la Tabla Paciente
  $ConsultaSolicitud = "SELECT DISTINCT id_solici, numero_solici, requerimientos_solici, edad_pac, fecha_solici, fec_nac_pac, cedula_pac, nombre_pac, apellido_pac, sector_pac, telefono1_pac, telefono2_pac, cedula_rep, nombre_rep, apellido_rep, telefono_rep, localidad, municipio, estado, nombre_login, apellido_login, nombre_redsal, nombre_defsta, observaciones_status
FROM ((((((((((solicitud as sol 
INNER JOIN paciente as pac ON pac.id_pac = sol.id_pac1) 
LEFT JOIN union_pac_rep as uni ON uni.id_pac1 = pac.id_pac) 
LEFT JOIN representante as rep ON rep.id_rep = uni.id_rep1) 
INNER JOIN t_localidad as parroq ON parroq.id_localidad = sol.id_localidad1)
INNER JOIN t_municipio as munici ON munici.id_municipio = parroq.id_municipio) 
INNER JOIN t_estado as est ON est.id_estado = munici.id_estado)
INNER JOIN login as log ON log.id_login = sol.id_login)
INNER JOIN redsalud as red ON red.id_redsal = sol.id_redsal1)
LEFT JOIN status as status ON status.id_solici1 = sol.id_solici)
LEFT JOIN definicion_status as defsta ON defsta.id_defsta = status.id_defsta1)
WHERE id_solici = '$seleccion'";



echo "La Solicitud despues de la Modificacion: <br>";



$ResultadoSolicitud = mysqli_query($mysqli , $ConsultaSolicitud); // se ejecuta la consulta
//PM = POST MODIFICADOS
$PM = mysqli_fetch_assoc($ResultadoSolicitud);// se extraen todos los datos del Id seleccionado



//Asignacion de las variables a utiliza en la insercion de los datos a la tabla modificacion
$PMnumero_solici = $PM['numero_solici']; $PMrequerimientos_solici = $PM['requerimientos_solici']; $PMedad_pac = $PM['edad_pac']; $PMfecha_solici = $PM['fecha_solici']; $PMfec_nac_pac = $PM['fec_nac_pac']; $PMcedula_pac = $PM['cedula_pac']; $PMnombre_pac = $PM['nombre_pac']; $PMapellido_pac = $PM['apellido_pac']; $PMsector_pac = $PM['sector_pac']; $PMtelefono1_pac = $PM['telefono1_pac']; $PMtelefono2_pac = $PM['telefono2_pac']; $PMcedula_rep = $PM['cedula_rep']; $PMnombre_rep = $PM['nombre_rep']; $PMapellido_rep = $PM['apellido_rep']; $PMtelefono_rep = $PM['telefono_rep']; $PMlocalidad = $PM['localidad']; $PMmunicipio = $PM['municipio']; $PMestado = $PM['estado']; $PMnombre_login = $PM['nombre_login']; $PMapellido_login = $PM['apellido_login']; $PMnombre_redsal = $PM['nombre_redsal']; $PMnombre_defsta = $PM['nombre_defsta']; $PMobservaciones_status = $PM['observaciones_status'];

// Metodo para la insercion de los datos en la tabla modificacion

echo "Consulta despues de la modificacion";
echo $PMnumero_solici;

$insertPM = "INSERT INTO modificados (AM_PM, id_login1, numero_solici, edad_pac, fecha_solici, fecha_nac_pac, cedula_pac, nombre_pac, apellido_pac, sector_pac, telefono1_pac, telefono2_pac, cedula_rep, nombre_rep, apellido_rep, telefono_rep, localidad, municipio, estado, nombre_login, apellido_login, nombre_defsta, observaciones_status) VALUES ('PM', $IdLogin, '$PMnumero_solici', '$PMedad_pac', '$PMfecha_solici', '$PMfec_nac_pac', '$PMcedula_pac', '$PMnombre_pac', '$PMapellido_pac', '$PMsector_pac', '$PMtelefono1_pac', '$PMtelefono2_pac', '$PMcedula_rep', '$PMnombre_rep', '$PMapellido_rep', '$PMtelefono_rep', '$PMlocalidad', '$PMmunicipio', '$PMestado', '$PMnombre_login', '$PMapellido_login', '$PMnombre_defsta', '$PMobservaciones_status')";

$ejecutaInsertPM = mysqli_query($mysqli, $insertPM);

if (!$ejecutaInsertPM) {$Error = 'false'; $InsertarPM = "Error al Insertar - PM - en la Tabla de Modificados "; }//echo "<br> ************************Error al Insertar - PM - en la Tabla de Modificados **************************** <br>";}else echo "<br>************************   Exito al Insertar PM en la Tabla de Donaciones   *****************";

?>

<?php
 //INICIO DE LA SECUENCIA DEL ALERT PARA INFORMAR SOBRE EL NUMERO DE REGISTRO INSERTADO
//UTILIZANDO MODAL Y CSS
 ?>
<?php 
//$Error = 'false';
if ($Error=='true' ){ ?>
<div id="modal"> <!-- padre -->
	<div id="modal-back"></div> <!-- fondo -->
	<div class="modal" class="w3-col s5 l5">
			<div id="modal-c" > <!-- subcontenedor -->
			 <br>
			 <div class="w3-container">
			     <h2 class="w3-center w3-margin-top">Actualizacion Exitosa</h2>
			     <h6 style="color: red" align="center" ><?php //***********************echo($ActPac."<br>".$ActRep); ?></h6>
			 </div>
			 <?php if ($ExitoSolicitud) { ?>
			 <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">El Registro de solicitud Actualizado es: <?php echo "<b class='w3-xlarge'>" .$AMnumero_solici. "</b>"; ?></h4>
			  <?php } ?>
			 <div align="center" class="w3-center w3-margin-top w3-margin-bottom">
			     <button name="EnviarFornulario" type="submit" class="w3-btn w3-blue w3-center w3-margin-top w3-margin-bottom"><a id="mclose" href="registro_paciente.php">Continuar</a></button>
			     <br>
				 <br>
			 </div>
		</div> <!-- contenedor -->
	</div>		
</div>

<?php
} else {
	?>
	<div id="modal"> <!-- padre -->
	<div id="modal-back"></div> <!-- fondo -->
		<div class="modal" class="w3-col s5 l5">
			<div id="modal-c" > <!-- subcontenedor -->
            <br>
			 <div class="w3-container">
			     <h2 class="w3-center w3-margin-top">Error al Actualizar Datos</h2>
			     <h6 style="color: red" align="center" ><?php echo($ActPac."<br>".$ActRep."<br>"); ?></h6>
			 </div>
			 <br>
			 <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">Contacte con el Departamento de Desarrolladores de O.T.I.C.</h4>
			 <br>
			 <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">Error al: <?php echo "<b class='w3-large'>" ."<br>".$ErrorInsPac.$ErrorActPac.$ErrorInsRep.$ErrorActRep.$ErrorInsStatus.$ErrorInsSolicitud.$ErrorInsUnion.$ErrorActUnion."</b>";
			 if (!$ejecutaInsertPM) echo"Error al Ingresar Datos a la Tabla Modifica";?></h4>
			 <br>
			<?php if ($ExitoSolicitud) { ?>
			 <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">El número de solicitud es: <?php echo "<b class='w3-xlarge'>" .$AMnumero_solici. "</b>"; ?></h4>
			  <?php } ?>
			 <div class="w3-center w3-margin-top w3-margin-bottom">
			     <button name="EnviarFornulario" type="submit" class="w3-btn w3-blue w3-center w3-margin-top w3-margin-bottom"><a id="mclose" href="registro_paciente.php">Continuar</a></button>
				 <br>
			 </div>
		</div> <!-- contenedor -->
	</div>
</div>

<?php } ?>

<?php require_once('../includes/footer.php');?>

<script>
// Change style of top container on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("myTop").classList.add("w3-card-4", "w3-animate-opacity");
        document.getElementById("myIntro").classList.add("w3-show-inline-block");
    } else {
        document.getElementById("myIntro").classList.remove("w3-show-inline-block");
        document.getElementById("myTop").classList.remove("w3-card-4", "w3-animate-opacity");
    }
}

// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
