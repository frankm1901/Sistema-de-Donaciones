 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
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

$NombreLogin=$_SESSION['Nombre']; // Id del Usuario quien ingreso la solicitud
$ApellidoLogin=$_SESSION['Apellido']; // Id del Usuario quien ingreso la solicitud
$DepartamentoLogin=$_SESSION['departamento']; // Id del Usuario quien ingreso la solicitud

$datosUsuario = $NombreLogin.' '.$ApellidoLogin.' Dpto: '.$DepartamentoLogin;
$fecha_ingreso = date("Y-m-d"); //esta fecha se toma desde el momento en que se hace el registro
echo "<br>Fecha del Solicitante: ".$fechaSolicitante = $_POST['fechaSolicitante']; // Fecha en que se recibe la Solicitud
echo "<br>Fecha de Recibido    : ".$fechaRecibidoSRS = $_POST['fechaRecibidoSRS']; // Fecha en que se recibe la Solicitud

$IdLogin=$_SESSION['Id_Login']; // Id del Usuario quien ingreso la solicitud

// Asignamos las variables a los datos del Solicitante
isset($_POST['informemedico']) 	? $informemedico = 'si' 	: $informemedico = 'no';
isset($_POST['copiacedula']) 	? $copiacedula = 'si' 		: $copiacedula = 'no';
isset($_POST['cartasolicitud']) ? $cartasolicitud = 'si' 	: $cartasolicitud = 'no';
isset($_POST['presupuesto']) ? $presupuesto = 'si' 			: $presupuesto = 'no';

  if (empty($_POST['cedula_sol']))
		{$_POST['cedula_sol'] = 0; 	}	

isset($_POST['cedula_sol']) ? $cedula_sol =  $_POST['cedula_sol'] 	: $cedula_sol =  0;

$nombre_sol = $_POST['nombre_sol'];
$apellido_sol = $_POST['apellido_sol'];

isset($_POST['user_date']) ? $fec_nac_sol =  $_POST['user_date'] 	: $fec_nac_sol =  null;
isset($_POST['edad_sol'])  ? $edad_sol =  $_POST['edad_sol'] 		: $edad_sol =  null;


isset($_POST['telefono_sol'])  ? $telefono_sol =  $_POST['telefono_sol'] 		: $telefono_sol =  null;
isset($_POST['parroquia'])  ? $id_localidades =  $_POST['parroquia'] 		: $id_localidades =  133;


echo "<br>El Id Localidades es: ".$id_localidades;

isset($_POST['sector_sol'])  ? $sector_sol =  $_POST['sector_sol'] 		: $sector_sol =  null;
  
 
  if (empty($_POST['nombre_pac']))
		{ $_POST['vinculo_pac'] = null; 		$_POST['cedula_pac'] = null; 				$_POST['telefono_pac'] = null; 		$_POST['nombre_pac'] = null;
			$_POST['apellido_pac'] = null; 	$_POST['user_date_pac'] = null ;$_POST['edad_pac'] = null; $_POST['parroquiaPaciente'] = 133; 
			$_POST['sector_pac'] = null;
    }
	
$vinculo_pac = $_POST['vinculo_pac'];
if (empty($_POST['cedula_pac'])){$cedula_pac = null; }else{$cedula_pac =  $_POST['cedula_pac'];}
if (empty($_POST['telefono_pac'])){$telefono_pac = null; }	else{$telefono_pac =  $_POST['telefono_pac'];}

$nombre_pac = $_POST['nombre_pac'];
$apellido_pac = $_POST['apellido_pac'];
	
isset($_POST['user_date_pac']) ? $fec_nac_pac =  $_POST['user_date_pac'] : $fec_nac_pac =  null;
isset($_POST['edad_pac'])  ? $edad_pac =  $_POST['edad_pac'] 		: $edad_pac =  null;
	
isset($_POST['parroquiaPaciente']) ? $id_localidadespac = $_POST['parroquiaPaciente'] : $id_localidadespac = 133;

$sector_pac = $_POST['sectorPaciente'];

if (empty($_POST['sectorPaciente']))
		{ $_POST['sectorPaciente'] = null;}
$sectorPaciente = $_POST['sectorPaciente'];

// Desagrupamos el array y se coloca como un texto separados por como y con un espacio en blanco
$patologias = (implode(", ", $_POST['patologias']));
$requerimientos = (implode(", ", $_POST['requerimientos']));
echo "<br>"; 
//if (isset($_POST['lugar_recep'])){ $_POST['lugar_recep'] = 133; }

$id_localidadrecepcion = $_POST['lugar_recep'];
echo "<br>";

$firmado = $_POST['firmado'];

/*echo "<br> id Medio de recepcion: ".*/ $recepcion = $_POST['recepcion'];

if (empty($_POST['observaciones']))
		{ $_POST['observaciones'] = null;}
/*echo "<br> Observaciones: ".*/ $observaciones = $_POST['observaciones'];

$InsSol = "false";
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
		
				$insertarSolicitante -> execute(); //SI EL REGISTRO SE REALIZA CORRECTAMENTE SE ASIGNA UN VALOR A LA VARIABLE $InsSol
					
			}else 
			{	$idCedulaSol = $conexion ->prepare("SELECT id_listado FROM ver_listado WHERE cedula = '$cedula_sol';");
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
				$actualizarSolicitante->bindParam(':sector',$sector_sol);         $actualizarSolicitante->bindParam(':id_listado',$id_listado); 

				$actualizarSolicitante -> execute();					
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
				$insertarPaciente->bindParam(':apellidos',$apellido_pac); 	$insertarPaciente->bindParam(':fecha_nacimiento',$fec_nac_pac); 
				$insertarPaciente->bindParam(':telefonos',$telefono_pac); 	$insertarPaciente->bindParam(':parroquia',$id_localidadespac); 
				$insertarPaciente->bindParam(':sector',$sector_pac); 
		
				$insertarPaciente -> execute(); //SI EL REGISTRO SE REALIZA CORRECTAMENTE SE ASIGNA UN VALOR A LA VARIABLE $InsSol					
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
				$actualizarPaciente->bindParam(':telefonos',$telefono_pac); 	$actualizarPaciente->bindParam(':parroquia',$id_localidadespac); 
				$actualizarPaciente->bindParam(':sector',$sector_pac);         $actualizarPaciente->bindParam(':id_listado',$id_listadoPac); 

				$actualizarPaciente -> execute();               
			}		
	}
//**********************************  E X T R A E M O S   E L   I D    D E L    S O L I C I T A N T E  *****************************************
$idCedulaSol = $conexion ->prepare("SELECT id_listado FROM ver_listado WHERE cedula = '$cedula_sol';");
$idCedulaSol -> execute();
$resultIdCedSol = $idCedulaSol -> fetchAll();

foreach($resultIdCedSol as $verIdCedulas)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
	{ $verIdListadoSol = $verIdCedulas['0'];}	
		$id_listado = $verIdListadoSol;

  //******************************************************************************************************************
  //**********************************  D A T O S   D E L   P A C I E N T E  *****************************************
  //******************************************************************************************************************

  
  
  	echo "<br>Edad Solicitante".$edad_sol;
	  $idPatologia = 1; 	$idDonaci = 1; 	$idoperado = null;
	  $activo = 'activo'; $iRedSal = 333;
	  $insertarSol = $conexion->prepare("INSERT INTO solicitud (id_localidades1, idpat1, id_donaci1, id_login, id_redsal1, id_listado1, idrecepcion1, 
													ingresado_por, fecha_registro_sistema, fecha_recibido_solicitud, fecha_recibido_srs,
													nombre_sol, apellido_sol, cedula_sol, telefono_sol, fec_nac_sol, edad_sol, sector_sol, 
													vinculofamiliar, cedula_pac, telefono_pac, nombre_pac, apellido_pac, fec_nac_pac, edad_pac, id_localidadespac, sector_pac,  
													patologias, requerimientos, medioderecepcion, id_localidadrecepcion, firmado, observaciones, activo, idoperado, informemedico, copiacedula, cartadesolicitud, presupuesto)	 
													VALUES (:id_localidades1, :idpat1, :id_donaci1, :id_login, :id_redsal1, :id_listado1, :idrecepcion1, 
													:ingresado_por, :fecha_registro_sistema, :fecha_recibido_solicitud, :fecha_recibido_srs,
													:nombre_sol, :apellido_sol, :cedula_sol, :telefono_sol, :fec_nac_sol, :edad_sol, :sector_sol, 
													:vinculofamiliar, :cedula_pac, :telefono_pac, :nombre_pac, :apellido_pac, :fec_nac_pac, :edad_pac, :id_localidadespac, :sector_pac,  
													:patologias, :requerimientos, :medioderecepcion, :id_localidadrecepcion, :firmado, :observaciones, :activo, :idoperado, :informemedico, :copiacedula, :cartadesolicitud, :presupuesto);");
	
    $insertarSol->bindParam(':id_localidades1', $id_localidades);				    	$insertarSol->bindParam(':idpat1',$idPatologia);  
    $insertarSol->bindParam(':id_donaci1',$idDonaci);	 						        $insertarSol->bindParam(':id_login',$IdLogin); 
    $insertarSol->bindParam(':id_redsal1',$iRedSal); 							        $insertarSol->bindParam(':id_listado1',$verIdListadoSol);
    $insertarSol->bindParam(':idrecepcion1',$recepcion);						        $insertarSol->bindParam(':ingresado_por',$datosUsuario); 
    $insertarSol->bindParam(':fecha_registro_sistema',$fecha_ingreso); 	    			$insertarSol->bindParam(':fecha_recibido_solicitud',$fechaSolicitante); 
    $insertarSol->bindParam(':fecha_recibido_srs',$fechaRecibidoSRS);		    		$insertarSol->bindParam(':nombre_sol',$nombre_sol); 
    $insertarSol->bindParam(':apellido_sol',$apellido_sol);					        	$insertarSol->bindParam(':cedula_sol',$cedula_sol);
    $insertarSol->bindParam(':telefono_sol',$telefono_sol);					        	$insertarSol->bindParam(':fec_nac_sol',$fec_nac_sol);
    $insertarSol->bindParam(':edad_sol',$edad_sol);							            $insertarSol->bindParam(':sector_sol',$sector_sol);
    $insertarSol->bindParam(':vinculofamiliar',$vinculo_pac);					      	$insertarSol->bindParam(':cedula_pac',$cedula_pac);
    $insertarSol->bindParam(':telefono_pac',$telefono_pac );					        $insertarSol->bindParam(':nombre_pac',$nombre_pac);
    $insertarSol->bindParam(':apellido_pac',$apellido_pac);					        	$insertarSol->bindParam(':fec_nac_pac',$fec_nac_pac);
    $insertarSol->bindParam(':edad_pac',$edad_pac);							            $insertarSol->bindParam(':id_localidadespac', $id_localidadespac);
    $insertarSol->bindParam(':sector_pac',$sector_pac);						          	$insertarSol->bindParam(':patologias',$patologias);
    $insertarSol->bindParam(':requerimientos',$requerimientos);				      		$insertarSol->bindParam(':medioderecepcion', $recepcion); 
    $insertarSol->bindParam(':id_localidadrecepcion',$id_localidadrecepcion);			$insertarSol->bindParam(':firmado', $firmado); 
    $insertarSol->bindParam(':observaciones',$observaciones);					      	$insertarSol->bindParam(':activo',$activo);
	$insertarSol->bindParam(':idoperado',$idoperado);									$insertarSol->bindParam(':informemedico',$informemedico);
	$insertarSol->bindParam(':copiacedula',$copiacedula);								$insertarSol->bindParam(':cartadesolicitud',$cartasolicitud);
	$insertarSol->bindParam(':presupuesto',$presupuesto);
	
    //$insertarSol -> execute();    
    //$lastInsertId = $conexion->lastInsertId();    
    //if($lastInsertId>0)
    if($insertarSol -> execute()){
			$InsSol = true; 
			//echo "<br><br>Datos ingresados correctamente de la solicitud ";	
			//OBTENERMOS EL ULTIMO ID INGRESADO PARA INSERTARLO EN LA TABLA STATUS
			$obtenerIdSolici = $conexion -> prepare("select max(id_solici) FROM solicitud;");
			$obtenerIdSolici -> execute();
			$idSolici = $obtenerIdSolici -> fetchAll();	

			foreach ($idSolici as $idSol){
				$id = $idSol['0'];
			}
			
			$observacionesStatus = "Proceso Aperturado";
			$id_defsta1 = 5;			
			$id_redsal2 = 333;			$activado = 'SI';
			
			$ingresoStatus = $conexion -> prepare("INSERT INTO STATUS (observaciones_status, fecha_status, id_defsta1, id_solici1, id_login1, nombre_login, asignado, id_redsal2, activa, fecha_registro_status) 
													VALUES (:observaciones_status, :fecha_status, :id_defsta1, :id_solici1, :id_login1, :nombre_login, :asignado, :id_redsal2, :activa, :fecha_registro_status)");	
		
			$ingresoStatus->bindParam(':observaciones_status',$observacionesStatus);	$ingresoStatus->bindParam(':fecha_status',$fecha_ingreso);
			$ingresoStatus->bindParam(':id_defsta1',$id_defsta1);						$ingresoStatus->bindParam(':id_solici1',$id);
			$ingresoStatus->bindParam(':id_login1',$IdLogin);							$ingresoStatus->bindParam(':nombre_login',$datosUsuario);
			$ingresoStatus->bindParam(':asignado',$DepartamentoLogin);					$ingresoStatus->bindParam(':id_redsal2',$id_redsal2);
			$ingresoStatus->bindParam(':activa',$activado);								$ingresoStatus->bindParam(':fecha_registro_status',$fecha_ingreso);		
			

			$ingresoStatus -> execute();		


			$lastInsertIdStatus = $conexion->lastInsertId();

			if(!$lastInsertIdStatus > 0)	
			//if (!$ingresoStatus -> execute())
			{print_r($ingresoStatus->errorInfo());}

			//header("Location: solicitante.php");	
	}else
		{$InsSol = false;												
			print_r($insertarSol->errorInfo());  
			
			
  echo "<br><br><br>  fecha_registro_sistema ".$fecha_ingreso;
  echo "<br> Fecha recibido_solicitud ".$fechaSolicitante;
  echo "<br> Fecha _recibido_srs ".$fechaRecibidoSRS;
  echo "<br> Fecha fec_nac_sol: ".$fec_nac_sol ;
  echo "<br> Fecha _nac_pac: ".$fec_nac_pac."<br>";
		}	
		$consultarSol = null;
		$conexion = null;
	



/******** AREA DE TRABAJO PARA EL PACIENTE NO REFLEJADO COMO SOLICITANTE **********************/
//CONSULTAR LOS DATOS DE LA TABLA PACIENTE PARA CONSTATAR SI LOS MISMOS SE ENCUENTRAN REGISTRADOS
//if (!$InsSol){

?>

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
