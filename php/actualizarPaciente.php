 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php// require_once('../includes/header.php');?>	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<link rel="stylesheet" href="css/spinner.css">
<link rel="stylesheet" type="text/css" href="../css/modal.css">
<!--<meta http-equiv="refresh" content="1;registro_paciente.php" />-->
</head>

<body>
<?php include '../Connections/conexion.php'; ?>
<?php  
	session_start();
	
?>


<?php 

///************************************************************************************
// Recibimos las variables mediante el methodo POST	
//Asignamos las variables a los datos de Inicio del Formulario

$seleccion=$_POST['seleccion'];//ID DE LA TABLA SOLICITUD
$fechaHoy = date("Y-m-d");  
$IdLogin=$_SESSION['Id_Login']; // Id del Usuario quien ingreso la solicitud
$NombreLogin=$_SESSION['Nombre']; // Id del Usuario quien ingreso la solicitud
$ApellidoLogin=$_SESSION['Apellido']; // Id del Usuario quien ingreso la solicitud
$DepartamentoLogin=$_SESSION['departamento']; // Id del Usuario quien ingreso la solicitud
//AGRUPAMOS LOS DATOS DEL USUARIO LOGUEADO PARA INGRESARLO EN UNA SOLA VARIABLE

$datosUsuario = $NombreLogin.' '.$ApellidoLogin.' Dpto: '.$DepartamentoLogin. ' Fecha: '.$fechaHoy;

isset($_POST['informemedico']) 	? $informemedico = 'si' 	: $informemedico = 'no';
isset($_POST['copiacedula']) 	? $copiacedula = 'si' 		: $copiacedula = 'no';
isset($_POST['cartasolicitud']) ? $cartasolicitud = 'si' 	: $cartasolicitud = 'no';
isset($_POST['presupuesto']) 	? $presupuesto = 'si' 		: $presupuesto = 'no';

isset($_POST['cedula_sol']) ?  $cedula_sol =  $_POST['cedula_sol'] : $cedula_sol = null ;

echo $cedula_sol;
$nombre_sol = $_POST['nombre_sol'];
$apellido_sol = $_POST['apellido_sol'];

!isset($_POST['user_date']) ? $fec_nac_sol = null : $fec_nac_sol = $_POST['user_date'];

!isset($_POST['edad_sol']) ? $edad_sol = null : $edad_sol = $_POST['edad_sol'];
!isset($_POST['telefono1_sol']) ? $telefono_sol = null : $telefono_sol = $_POST['telefono_sol'];
!isset($_POST['parroquia']) ? $id_localidades = 133 : $id_localidades = $_POST['parroquia'];
!isset($_POST['sector_sol']) ? $sector_sol = null : $sector_sol = $_POST['sector_sol'];

//ASIGNAMOS LOS DATOS RECIBIDOS A LAS VARIABLES PARA LOS DATOS DEL PACIENTE             
//$_POST['vinculo_pac'] = "";


isset($_POST['vinculo_pac']) 	? $vinculo_pac = $_POST['vinculo_pac'] 		: $vinculo_pac = null;	
!isset($_POST['cedula_pac']) 	? $cedula_pac = $_POST['cedula_pac'] 		: $cedula_pac = null;		  

!isset($_POST['telefono_pac']) 	? $telefono_pac = $_POST['telefono_pac'] 		: $telefono_pac = null;		  
!isset($_POST['user_date_pac']) 	? $fec_nac_pac = $_POST['user_date_pac'] 		: $fec_nac_pac = null;		  
!isset($_POST['edad_pac']) 	? $edad_pac = $_POST['edad_pac'] 		: $edad_pac = null;		  
isset($_POST['parroquiaPaciente']) 	? $parroquiapaciente = $_POST['parroquiaPaciente'] 		: $parroquiapaciente = null;	
!isset($_POST['sectorPaciente']) 	? $sector_pac = $_POST['sectorPaciente'] 		: $sector_pac = null;		  

isset($_POST['nombre_pac']) 	? $nombre_pac = $_POST['nombre_pac'] 		: $nombre_pac = null;		  
isset($_POST['apellido_pac']) 	? $apellido_pac = $_POST['apellido_pac'] 		: $apellido_pac = null;		  

//EXTRACCION DE LOS DATOS A EDITAR DETALLADA DE LO SOLICITADO
// Desagrupamos el array y se coloca como un texto separados por como y con un espacio en blanco
$fecha_recibido_solicitud  = $_POST['fechagira'];
$fecha_recibido_srs = $_POST['fechasrs'];
$patologias = (implode(", ", $_POST['patologias']));
$requerimientos = (implode(", ", $_POST['requerimientos']));
$medioderecepcion = $_POST['recepcion'];
$id_localidadrecepcion = $_POST['lugar_recep'];
$firmado = $_POST['firmado'];

isset($_POST['observaciones']) 	? $observaciones = $_POST['observaciones'] 		: $observaciones = null;		  

$InsSol = true;
//******************************************************************************************************************
//********************************  D A T O S   D E L   S O L I C I T A N T E  *************************************
//******************************************************************************************************************
//CONDICIONAMOS SI HAY DATOS EN EL CAMPO CEDULA PARA NO REGISTRAR LOS DATOS EN LA TABLA LISTADO	
if ($cedula_sol <> 0)
	{// VERIFICAMOS SI YA HAY REGISTROS COINCIDENTES CON EL NUMERO DE CEDULA DEL SOLICITANTE PARA NO INGRESARLOS NUEVAMENTE
		$cedula_sol;
		$cedulaSol = $conexion ->prepare("SELECT count(*) FROM ver_listado WHERE cedula = '$cedula_sol';");
		$cedulaSol -> execute();
		$resultCedSol = $cedulaSol -> fetchAll();
		
		foreach($resultCedSol as $verCedulas)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
			{ $verListadoSolFor = $verCedulas['0'];}	

			$verListadoSol = $verListadoSolFor;
		//Si no existen registros de la persona procedemos a ingresar los datos del Solicitante
		if ($verListadoSol == 0) 
			{////Ingresamos los datos del solicitante a la tabla listado para actualizar la misma			

				$insertarSolicitante = $conexion->prepare("INSERT INTO listado (cedula, nombres, apellidos, fecha_nacimiento, telefonos, parroquia, sector)
															VALUES (:cedula, :nombres, :apellidos, :fecha_nacimiento, :telefonos, :parroquia, :sector);");						

				$insertarSolicitante->bindParam(':cedula',$cedula_sol);			$insertarSolicitante->bindParam(':nombres',$nombre_sol);
				$insertarSolicitante->bindParam(':apellidos',$apellido_sol); 	$insertarSolicitante->bindParam(':fecha_nacimiento',$fec_nac_sol); 
				$insertarSolicitante->bindParam(':telefonos',$telefono_sol); 	$insertarSolicitante->bindParam(':parroquia',$id_localidades); 
				$insertarSolicitante->bindParam(':sector',$sector_sol); 
		
				if( $insertarSolicitante -> execute()) //SI EL REGISTRO SE REALIZA CORRECTAMENTE SE ASIGNA UN VALOR A LA VARIABLE $InsSol
					{	$InsSol = true; echo "<br>Los datos estan siendo insertados<br>";
					}else
					{	$InsSol = false;
						echo "<br>Error al Ingresar los Datos de la solicitud<br><br><br>";
						print_r($insertarSolicitante->errorInfo());		
					}		
			}else 
			{

				$idCedulaSol = $conexion ->prepare("SELECT id_listado FROM ver_listado WHERE cedula = '$cedula_sol';");
				$idCedulaSol -> execute();
				$resultIdCedSol = $idCedulaSol -> fetchAll();
				
				foreach($resultIdCedSol as $verIdCedulas)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
					{ $verIdListadoSol = $verIdCedulas['0'];}	
					$id_listado = $verIdListadoSol;
				
					
				$actualizarSolicitante = $conexion->prepare("UPDATE listado SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos, 
															fecha_nacimiento = :fecha_nacimiento, telefonos = :telefonos, parroquia = :parroquia, sector = :sector
															WHERE id_listado = :id_listado;");						

				$actualizarSolicitante->bindParam(':cedula',$cedula_sol);			$actualizarSolicitante->bindParam(':nombres',$nombre_sol);
				$actualizarSolicitante->bindParam(':apellidos',$apellido_sol); 	$actualizarSolicitante->bindParam(':fecha_nacimiento',$fec_nac_sol); 
				$actualizarSolicitante->bindParam(':telefonos',$telefono_sol); 	$actualizarSolicitante->bindParam(':parroquia',$id_localidades); 
				$actualizarSolicitante->bindParam(':sector',$sector_sol);         $actualizarSolicitante->bindParam(':id_listado',$$verIdListadoSol); 

				if(!$actualizarSolicitante -> execute()) 
					{					
					echo "<br>Error al actualizar registros del Solicitante<br><br>";
					print_r($actualizarSolicitante->errorInfo());
				}
			}		
	}

//******************************************************************************************************************
//**********************************  D A T O S   D E L   P A C I E N T E  *****************************************
//******************************************************************************************************************

//CONDICIONAMOS PARA INGRESAR LOS DATOS DEL PACIENTE A LA TABLA LISTADO EN CASO DE POSEER CEDULA
if ($cedula_pac <> 0)
	{// VERIFICAMOS SI YA HAY REGISTROS COINCIDENTES CON EL NUMERO DE CEDULA DEL SOLICITANTE PARA NO INGRESARLOS NUEVAMENTE
		$cedulaPac = $conexion ->prepare("SELECT count(*) FROM ver_listado WHERE cedula = '$cedula_pac';");
		$cedulaPac -> execute();
		$resultCedPac = $cedulaPac -> fetchAll();
		
		foreach($resultCedPac as $verCedulasPac)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
			{ $verListadoPac = $verCedulasPac['0'];}	

		//Si no existen registros de la persona procedemos a ingresar los datos del Solicitante
		if ($verListadoPac == 0) 
			{////Ingresamos los datos del solicitante a la tabla listado para actualizar la misma			

				$insertarPaciente = $conexion->prepare("INSERT INTO listado (cedula, nombres, apellidos, fecha_nacimiento, telefonos, parroquia, sector)
															VALUES (:cedula, :nombres, :apellidos, :fecha_nacimiento, :telefonos, :parroquia, :sector);");						

				$insertarPaciente->bindParam(':cedula',$cedula_pac);			$insertarPaciente->bindParam(':nombres',$nombre_pac);
				$insertarPaciente->bindParam(':apellidos',$apellido_pac); 		$insertarPaciente->bindParam(':fecha_nacimiento',$fec_nac_pac); 
				$insertarPaciente->bindParam(':telefonos',$telefono_pac); 		$insertarPaciente->bindParam(':parroquia',$parroquiapaciente); 
				$insertarPaciente->bindParam(':sector',$sector_pac); 
		
				if( $insertarPaciente -> execute()) //SI EL REGISTRO SE REALIZA CORRECTAMENTE SE ASIGNA UN VALOR A LA VARIABLE $InsSol
					{	$InsSol = true; 
					}else
					{	print_r($insertarPaciente->errorInfo());					
						$InsSol = false; // asignamos False a la Variable para referencia de no ingresado los datos						
					}		
			}else 
			{
				$idCedulaPac = $conexion ->prepare("SELECT id_listado FROM ver_listado WHERE cedula = '$cedula_pac';");
				$idCedulaPac -> execute();
				$resultIdCedPac = $idCedulaPac -> fetchAll();
		
				foreach($resultIdCedPac as $verIdCedulasPac)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
					{ $verIdListadoPac = $verIdCedulasPac['0'];}	
					$id_listadoPac = $verIdListadoPac;
          
				$actualizarPaciente = $conexion->prepare("UPDATE listado SET cedula = :cedula, nombres = :nombres, apellidos = :apellidos, 
															fecha_nacimiento = :fecha_nacimiento, telefonos = :telefonos, parroquia = :parroquia, sector = :sector
															WHERE id_listado = :id_listado;");						

				$actualizarPaciente->bindParam(':cedula',$cedula_pac);			$actualizarPaciente->bindParam(':nombres',$nombre_pac);
				$actualizarPaciente->bindParam(':apellidos',$apellido_pac); 	$actualizarPaciente->bindParam(':fecha_nacimiento',$fec_nac_pac); 
				$actualizarPaciente->bindParam(':telefonos',$telefono_pac); 	$actualizarPaciente->bindParam(':parroquia',$parroquiapaciente); 
				$actualizarPaciente->bindParam(':sector',$sector_pac);         $actualizarPaciente->bindParam(':id_listado',$id_listadoPac); 
				if(!$actualizarPaciente -> execute()) 
					{
					echo "<br>Error al actualizar registros del Paciente<br><br>";
					print_r($actualizarPaciente->errorInfo());						
				}
			}		
	}

//***************************************************************************************************************************************************
//**********************************  A C T U A L I Z A M O S   D A T O S   D E   L A   S O L I C I T U D   *****************************************
//***************************************************************************************************************************************************
  //obtenemos los datos de las personas que editaron anteriormente este registro
  $verActualizadoSql = $conexion -> prepare("SELECT id_solici, actualizadopor FROM solicitud where id_solici = $seleccion order by id_solici ");
  $verActualizadoSql -> execute();
  $verActualizado = $verActualizadoSql -> fetchAll();
  
  foreach( $verActualizado as $verAct){
      $actualizado = $verAct['actualizadopor'];
    }
  




  //Agregamos el registro obtenido asi como los datos del usuario actual

  $actualizarSolicitud = $conexion->prepare("UPDATE solicitud SET  id_localidades1 = :id_localidades1, cedula_sol = :cedula_sol, nombre_sol = :nombre_sol, apellido_sol = :apellido_sol, 
												  telefono_sol = :telefono_sol, fec_nac_sol = :fec_nac_sol, edad_sol = :edad_sol, sector_sol = :sector_sol, vinculofamiliar = :vinculofamiliar, 
												  cedula_pac = :cedula_pac, nombre_pac = :nombre_pac, apellido_pac = :apellido_pac, telefono_pac = :telefono_pac, fec_nac_pac = :fec_nac_pac, 
                                                  edad_pac = :edad_pac, id_localidadespac = :id_localidadespac, sector_pac = :sector_pac, fecha_recibido_solicitud = :fecha_recibido_solicitud, 
												  fecha_recibido_srs = :fecha_recibido_srs, patologias = :patologias, requerimientos = :requerimientos, medioderecepcion = :medioderecepcion, 
                                                  id_localidadrecepcion = :id_localidadrecepcion, firmado = :firmado, observaciones = :observaciones, informemedico = :informemedico, 
												  copiacedula = :copiacedula, cartadesolicitud = :cartadesolicitud, presupuesto = :presupuesto, actualizadopor = :actualizadopor
                                                  WHERE id_solici = :id_solici;");						

		$actualizarSolicitud->bindParam(':id_localidades1',$id_localidades); 			$actualizarSolicitud->bindParam(':cedula_sol',$cedula_sol);			    
        $actualizarSolicitud->bindParam(':nombre_sol',$nombre_sol);						$actualizarSolicitud->bindParam(':apellido_sol',$apellido_sol); 	    
        $actualizarSolicitud->bindParam(':telefono_sol',$telefono_sol);  	    		$actualizarSolicitud->bindParam(':fec_nac_sol',$fec_nac_sol ); 
        $actualizarSolicitud->bindParam(':edad_sol',$edad_sol); 						$actualizarSolicitud->bindParam(':sector_sol',$sector_sol);         	
        $actualizarSolicitud->bindParam(':vinculofamiliar',$vinculo_pac); 				$actualizarSolicitud->bindParam(':cedula_pac',$cedula_pac);     	    
        $actualizarSolicitud->bindParam(':nombre_pac',$nombre_pac);     				$actualizarSolicitud->bindParam(':apellido_pac',$apellido_pac);     	  
        $actualizarSolicitud->bindParam(':telefono_pac',$telefono_pac);     			$actualizarSolicitud->bindParam(':fec_nac_pac',$fec_nac_pac);     	    
        $actualizarSolicitud->bindParam(':edad_pac',$edad_pac);     					$actualizarSolicitud->bindParam(':id_localidadespac',$parroquiapaciente);   
        $actualizarSolicitud->bindParam(':sector_pac',$sector_pac); 					$actualizarSolicitud->bindParam(':fecha_recibido_solicitud',$fecha_recibido_solicitud); 	
        $actualizarSolicitud->bindParam(':fecha_recibido_srs',$fecha_recibido_srs); 	$actualizarSolicitud->bindParam(':patologias',$patologias); 	
        $actualizarSolicitud->bindParam(':requerimientos',$requerimientos); 			$actualizarSolicitud->bindParam(':medioderecepcion',$medioderecepcion); 
        $actualizarSolicitud->bindParam(':id_localidadrecepcion',$id_localidadrecepcion);$actualizarSolicitud->bindParam(':firmado',$firmado); 	
        $actualizarSolicitud->bindParam(':observaciones',$observaciones); 				$actualizarSolicitud->bindParam(':actualizadopor',$datosUsuario); 					
		$actualizarSolicitud->bindParam(':informemedico',$informemedico);				$actualizarSolicitud->bindParam(':copiacedula',$copiacedula);								
		$actualizarSolicitud->bindParam(':cartadesolicitud',$cartasolicitud);			$actualizarSolicitud->bindParam(':presupuesto',$presupuesto);
		$actualizarSolicitud->bindParam(':id_solici',$seleccion); 	

		if($actualizarSolicitud -> execute()) 				
			{header("Location: solicitante.php");											
		}else{
			echo "<br>Error al actualizar registros de la Solicitud<br><br>";
			print_r($actualizarSolicitud->errorInfo());					
		}	
		$consultarSol = null;
		$conexion = null;

/******** AREA DE TRABAJO PARA EL PACIENTE NO REFLEJADO COMO SOLICITANTE **********************/
//CONSULTAR LOS DATOS DE LA TABLA PACIENTE PARA CONSTATAR SI LOS MISMOS SE ENCUENTRAN REGISTRADOS

if (!$InsSol){?>
	<div id="modal"> <!-- padre -->
	<div id="modal-back"></div> <!-- fondo -->
		<div class="modal" class="w3-col s5 l5">
			<div id="modal-c" > <!-- subcontenedor -->
            <br>
			 <div class="w3-center w3-container">
			     <h2 class=" w3-margin-top" style=" align='center';" >Error al Insertar Datos</h2>			     
			 </div>
			  	<h3 style="font-family: Arial; align='center';" class="w3-margin-top w3-margin-bottom">Contacte con: </h3>
			 	<h4 style="font-family: Arial; align='center';" class="w3-center w3-margin-top w3-margin-bottom">Departamento de Desarrolladores de O.T.I.C.</h4>
			 
			 <div class="w3-center w3-margin-top w3-margin-bottom">
			     <button style=" align='center';" name="EnviarFormulario" type="submit" class="w3-btn w3-blue w3-center w3-margin-top w3-margin-bottom"><a id="mclose" href="solicitante.php">Continuar</a></button>
				 <br><br><br>
			 </div>
		</div> <!-- contenedor -->
	</div>
</div>
<?php 
	}
	


	
 ?>

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
