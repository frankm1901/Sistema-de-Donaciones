<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Status</title> 

<script src="../assets/jquery/jquery.min.js"></script>
<script src="../assets/select2/js/select2.min.js"></script> 
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">

<style>
  #costoDiv,
  #departamentoDiv,
  #redsaludDiv,
  #donacionesDiv{
        display: none;
      }
</style>
</head>
<body>
<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>

<div class="w3-main" style="margin-left:245px;margin-top:33px;">
<!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:10px 5px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-text-white w3-margin-left">Status del Paciente</span></h4>
  </div>  
  <header class="w3-container" style="background:#3385ff;padding:5px 1px">
    <b><h1 class="w3-xxxlarge w3-text-white">Status del Paciente</h1></b>
  </header>
  <?php 
  $Departamento = $_SESSION['departamento'];
  $nivelUsuario = $_SESSION['Id_NivUsu'];
  $hoy = date("j-n-Y"); 

  $realizadopor =  $_SESSION['Nombre'] ." ".$_SESSION['Apellido']." Dpto: ".$_SESSION['departamento']." Fecha: ".$hoy; 

  //condicionar si los datos son enviados por POST o por GET cuando se registre el nuevo status  
//>Condicional que muestra solo lo seleccionado al consultar status
  if (isset ($_GET['seleccion'])){
      $seleccion = $_GET['seleccion'];      
    }            
//Condicional que se ejecuta en caso de que se escoja lo seleccionado
    if (isset ($_GET['eliminar'])){
      $eliminar = $_GET['eliminar'];

      $porciones = explode(",", $eliminar);
      $seleccion = $porciones[0];
      $eliminar  = $porciones[1];      

      $activado = 'NO';
      $actualizarStatus = $conexion->prepare("UPDATE status SET activa = :activa, realizadopor = :realizadopor WHERE id_status = :id_status;");						

      $actualizarStatus->bindParam(':activa',$activado);			$actualizarStatus->bindParam(':realizadopor',$realizadopor);
      $actualizarStatus->bindParam(':id_status',$eliminar); 	

      if(!$actualizarStatus -> execute()) {print_r($actualizarStatus->errorInfo());}

      $consultarRedSalud = $conexion ->prepare("select id_redsal2 from status where id_solici1 = $seleccion ORDER BY id_status asc");
      $consultarRedSalud -> execute();

      $ConsultarRed = $consultarRedSalud -> fetchAll();

      foreach($ConsultarRed as $verRedSal)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
        { 
         $redSal = $verRedSal['id_redsal2'];
        }        
        $editarRedSal = $conexion -> prepare("UPDATE solicitud set id_redsal1 = $redSal where id_solici = $seleccion");
        $editarRedSal -> execute();
    }
        
  if ($_POST) { //seleccion ObservacionesStatus status
    //echo "<br>Observaciones: ";
    $observaciones_status = $_POST['ObservacionesStatus'];
    
    $hoyFecha = date("d-m-Y");
    $fecha_status = $_POST['fechaStatus'];
    $status = $_POST['status'];
    $IdSolicitud = $_POST['seleccionstatus'];

    $id_login = $_SESSION['Id_Login'];
    $usuario = $_SESSION['Nombre'].' '.$_SESSION['Apellido'].' Dpto: '.$_SESSION['departamento'];
    $Departamento = $_SESSION['departamento'];

    if(!isset($_POST['departamento'])){
      $dpto = $_SESSION['departamento']; 
    }else{echo "Asignado: ".$dpto = $_POST['departamento']; }

    $enviadoRedSalud = true; // Para condicionar si se envio o no el Id de la red Salud
    if (!isset($_POST['redsalud'])){
      $idRedSalud = 333;$enviadoRedSalud = false;      
    }else{$idRedSalud = $_POST['redsalud']; }

    if (!isset($_POST['donaciones'])){$requerimientosaprobados = null;}else{$requerimientosaprobados = (implode(", ", $_POST['donaciones']));}

    !isset($_POST['costo']) ? $costo = null : $costo = $_POST['costo'];
    if ($costo == ""){$costo = null;}

    if ($status == 8){$idRedSalud = 378; }
    if ($status != 6){$dpto = $Departamento; }
    $seleccion = $_POST['seleccionstatus'];

    //Inserta de los datos a la Tabla Status 
    $activado = 'SI';
    $Tstatus = $conexion -> prepare ("INSERT INTO status (observaciones_status, fecha_status, id_defsta1, id_solici1, id_login1, nombre_login, asignado, id_redsal2, requerimientosaprobados, costo, activa, fecha_Registro_status) 
                VALUES (:observaciones_status, :fecha_status, :id_defsta1, :id_solici1, :id_login1, :nombre_login, :asignado, :id_redsal2, :requerimientosaprobados, :costo, :activa, :fecha_Registro_status)");
    $Tstatus->bindParam(':observaciones_status',$observaciones_status);		
    $Tstatus->bindParam(':fecha_status',$fecha_status);		
    $Tstatus->bindParam(':id_defsta1',$status);		
    $Tstatus->bindParam(':id_solici1',$IdSolicitud);		
    $Tstatus->bindParam(':id_login1',$id_login);		
    $Tstatus->bindParam(':nombre_login',$usuario);		
    $Tstatus->bindParam(':asignado',$dpto);		
    $Tstatus->bindParam(':id_redsal2',$idRedSalud);		
    $Tstatus->bindParam(':requerimientosaprobados',$requerimientosaprobados);		
    $Tstatus->bindParam(':costo',$costo);		
    $Tstatus->bindParam(':activa',$activado);		
    $Tstatus->bindParam(':fecha_Registro_status',$hoyFecha);		
    

    //$Tstatus -> execute();
    if (!$Tstatus -> execute()) { 
      print_r($Tstatus->errorInfo());
    }else {        
        if($enviadoRedSalud == true){
            //Procedemos a actualizar el registro del Id del Centro de Salud en la tabla solicitud
            $actualizarIdSolicitud = $conexion->prepare("UPDATE solicitud SET id_redsal1 = :id_redsal1, idoperado = :idoperado
                                  WHERE id_solici = :id_solici;");						

            $actualizarIdSolicitud->bindParam(':id_redsal1',$idRedSalud);			$actualizarIdSolicitud->bindParam(':idoperado',$idRedSalud);
            $actualizarIdSolicitud->bindParam(':id_solici',$IdSolicitud); 	
            
            if(!$actualizarIdSolicitud -> execute()) {print_r($actualizarIdSolicitud->errorInfo());}
        }
    }
  }

  //Consulta para la busqueda segun la opcion ingresada por el paciente
  $ConsultaSolicitud = $conexion -> prepare("SELECT id_solici, fecha_recibido_srs, fecha_recibido_solicitud, ingresado_por, 
                                              cedula_sol, telefono_sol, nombre_sol, apellido_sol, fec_nac_sol, edad_sol, name_municipio, name_parroquia, sector_sol,
                                              cedula_pac, nombre_pac, apellido_pac, telefono_pac, fec_nac_pac, edad_pac,
                                              informemedico, copiacedula, cartadesolicitud, presupuesto,
                                              patologias, requerimientos 
                                              from solicitud
                                              inner join localidades on id_localidades = id_localidades1
                                              where id_solici = '$seleccion' and activo = 'activo';");
  $ConsultaSolicitud -> execute();

  $ConsultaSol = $ConsultaSolicitud -> fetchAll();

  foreach($ConsultaSol as $ConsulSol)// EXTRAEMOS LA CANTIDAD DE REGISTROS COINCIDENTES
    { ?>

  <div class="w3-container w3-content w3-center">
    <br>
  <table class="w3-table w3-bordered w3-border w3-card-4">
    <tr>
      <td class="w3-center" colspan = "1"><strong>Fecha Recibido S.R.S.: </strong> <br><?php echo $ConsulSol['fecha_recibido_srs']; ?> </td>  
      <td class="w3-center" colspan = "2"><strong>Fecha de la Solicitud.:</strong> <br><?php echo $ConsulSol['fecha_recibido_solicitud']; ?></td>      
      <td class="w3-center" colspan = "2"><strong>Registrado por: </strong> <br><?php echo $ConsulSol['ingresado_por']; ?></td>      
    </tr>        
    <tr>
      <td class="w3-teal w3-border-right w3-border-black" colspan="3"><h4>Datos del Solicitante</h4></td>
      <td class="w3-indigo" colspan = '2' ><h4>Datos del Paciente</h4></td>
    </tr>
    <tr>
      <td class="w3-border-right w3-border-black" height="23" colspan="3">
        <strong>Cédula: </strong>   <?php echo $ConsulSol['cedula_sol']; ?><br> 
        <strong>Teléfonos:</strong> <?php echo $ConsulSol['telefono_sol']; ?> <br>        
        <strong>Nombre y Apellido </strong><?php echo $ConsulSol['nombre_sol']." ".$ConsulSol['apellido_sol']; ?><br>
        <strong>Fecha de Nac.</strong> <?php echo $ConsulSol['fec_nac_sol']; ?><br>
        <strong>Edad: </strong><?php echo $ConsulSol['edad_sol']; ?><br>      
        <strong>Dirección:</strong> <?php echo $ConsulSol['name_parroquia']." ".$ConsulSol['name_municipio']." ".$ConsulSol['sector_sol']; ?>
      </td>
      <td class="w3-border-right w3-border-black"  colspan = "2">
        <strong>Cédula: </strong><?php print $ConsulSol['cedula_pac']; ?><strong><br>
        <strong>Nombre y Apellido: </strong><?php echo $ConsulSol['nombre_pac']." ".$ConsulSol['apellido_pac']; ?> <br>        
        <strong>Teléfonos: </strong><?php echo $ConsulSol['telefono_pac']; ?><br>
        <strong>Fecha de Nac: </strong><?php echo $ConsulSol['fec_nac_pac']; ?><br>
        <strong>Edad: </strong><?php echo $ConsulSol['edad_pac']; ?><br>          
      </td>
    </tr>    
    <tr>
      <td height="23" colspan="1"></h4><strong>Informe Medico:<br> </strong><?php echo $ConsulSol['informemedico'].' ';?></td>      
      <td height="23" colspan="1"><strong>Copia Cedula: <br></strong><?php echo $ConsulSol['copiacedula']; ?> </td>      
      <td height="23" colspan="1"><strong> Carta de Solicitud:<br> </strong><?php echo $ConsulSol['cartadesolicitud'].' ';?></td>      
      <td height="23" colspan="1"><strong>Presupuesto:<br> </strong><?php echo $ConsulSol['presupuesto']; ?> </td> 
    </tr>         
    <tr>
      <td height="23" colspan="2"><strong> Patologias: </strong><?php echo $ConsulSol['patologias'].' ';?></td>      
      <td height="23" colspan="3"><strong>Requerimientos: </strong><?php echo $ConsulSol['requerimientos']; ?> </td>      
    </tr>         
    <tr>
      <td class="w3-blue-gray" colspan="5"><strong><h4>Status</h4></strong></td
    </tr>    
    <?php } ?>

    <?php 
    //CONSULTA DEL TOTAL DEL STATUS
    $ConsultaTotalStatus = $conexion -> prepare("SELECT count(id_solici1) as cant, id_solici1
                                            from status
                                            inner Join solicitud on id_solici = id_solici1
                                            inner JOIN definicion_status on id_defsta = id_defsta1
                                            inner join redsalud on id_redsal = id_redsal2 
                                            WHERE id_solici1 = '$seleccion'  and activo = 'activo' and activa = 'SI'
                                            GROUP BY id_solici1;");
    $ConsultaTotalStatus -> execute();
    $ResultadoTotalStatus = $ConsultaTotalStatus -> fetchAll();      
    
    foreach ($ResultadoTotalStatus as $VerSTotaltatus){
      $cantidad = $VerSTotaltatus['cant'];
    }      

    
    //CONSULTA DEL STATUS
    $ConsultaStatus = $conexion -> prepare("SELECT id_status, id_defsta1, id_solici1, observaciones_status, fecha_status, nombre_redsal, nombre_defsta, nombre_login, asignado, id_redsal2, requerimientosaprobados
                                            from status
                                            inner Join solicitud on id_solici = id_solici1
                                            inner JOIN definicion_status on id_defsta = id_defsta1
                                            inner join redsalud on id_redsal = id_redsal2 
                                            WHERE id_solici1 = '$seleccion'  and activo = 'activo' and activa = 'SI'
                                            order by id_status desc;");
    $ConsultaStatus -> execute();
    $ResultadoStatus = $ConsultaStatus -> fetchAll();      
    ?>    
    <?php $habilitar = true; 
    foreach ($ResultadoStatus as $VerStatus)      
      { $ContadorStatus=0; $compara = $VerStatus["id_defsta1"];           
        if ($compara == 7 || $compara == 8 || $compara == 9 ){ 
           $habilitar = false;
        }
        ?>
        <tr>              
          <td colspan="" width="200"><strong>Estado:</strong><br><?php echo " ".$VerStatus["nombre_defsta"].'<strong> <br>Dpto Asignado: </strong>'.$VerStatus["asignado"]; ?> </td> 
          <td colspan="2" width="280" ><?php 
            if ($VerStatus["id_redsal2"] <> 333) {?>
              <strong>Centro Asistencial: </strong><br><?php echo $VerStatus["nombre_redsal"]; ?>
              <br><strong>Requerimientos Aprobados: </strong><br><?php echo $VerStatus["requerimientosaprobados"]; ?>
              <?php             
              //ACTUALIZAR EL CAMPO DE IDOPERADO EN LA TABLA SOLICITUD PARA DEFINIR SI LA SOLICITUD ESTA O NO RESUELTA
              $actualizarSolicitud = $conexion->prepare("UPDATE solicitud SET idoperado = :idoperado															                          WHERE id_solici = :id_solici;");						
              $actualizarSolicitud->bindParam(':idoperado',$idRedSalud);
              $actualizarSolicitud->bindParam(':id_solici',$seleccion);            
              $actualizarSolicitud -> execute();
            }?>    </td>            
          <td colspan="" ><strong>Emitido por: </strong><br><?php echo $VerStatus["nombre_login"]; ?>
          <br><strong>Observación:</strong><br><?php echo " ".$VerStatus["observaciones_status"]; ?></strong></td>
          <td colspan="" width="100">  <strong>Fecha:</strong><br><?php echo $VerStatus["fecha_status"]; ?> 
            <?php 
              if($cantidad > 1){ 
                if($nivelUsuario == 1 || $nivelUsuario == 2 || $nivelUsuario == 5){               
            ?>
                <a href="ConsultarStatus.php?eliminar=<?php echo $VerStatus["id_solici1"].",".$VerStatus["id_status"]; ?>"><button class="w3-btn w3-indigo w3-small ">Eliminar Status <i class="fa fa-caret-right "></i></button></a></td>                      
            <?php    }}  $cantidad--;   ?>
        </tr>
        <?php         
      }?>
      
      </table>
  <br>
<?php 
if ($habilitar != false){ 
?>
<section id="ingresoStatus">
  <form name="IngresoStatus" method="POST" action="ConsultarStatus.php" >
    <table class="w3-table w3-card-4 w3-bordered w3-border" border="0">
      <tr>
        <th class="w3-green" colspan="4">
          <div>
            <h4>Ingresar Nuevo Status</h4>
          </div>
        </th>
      </tr>
      <tr>
        <td>
          <div></div>
        </td>
      </tr>      
      <tr>      
        <td class="w3-center">
            <div id="statusSec">
              <select required class="w3-select w3-border w3-half w3-hover-gray" style="width:25%;" name="status" id="status" >
              <option value="">Seleccione un Elemento</option>
                <?php
                    $sqlDefSta = $conexion -> prepare ("SELECT * FROM definicion_status WHERE id_defsta > 1 order by nombre_defsta;");
                    $sqlDefSta -> execute();
                    $versqlDefSta = $sqlDefSta -> fetchAll();

                    foreach($versqlDefSta as $verDefSta)
                    {  ?>
                    <option value="<?php echo $verDefSta['id_defsta']?>"><?php echo $verDefSta['nombre_defsta']?></option>
                    <?php }
                    ?>
              </select>
            </div>

            <div id="ObservacionesStatusDiv">
              <input class="w3-input w3-border w3-half w3-margin-left w3-hover-gray" placeholder="OBSERVACIONES" style="width:45%" 
                    onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  
                    name="ObservacionesStatus" type="text" id="ObservacionesStatus" />
            </div>

            <div id="seleccionstatusSec">
              <input type="hidden" name="seleccionstatus" value="<?php printf($seleccion) ?>" />
            </div>

            <div id="fechaStatusSec">
              <input min="2022-01-01" max="<?php echo date("Y-m-d"); ?>" style="width:20%" required = "required" name="fechaStatus" type="date" id="fechaStatus" class="w3-input w3-border w3-half w3-margin-left w3-hover-gray">            
            </div>            
            </td>
      </tr>      
      <tr>
        <td w3-center">          
          <p id="departamentoDiv">      
            <label for="departamento">Seleccione Centro de Salud</label>        
            <select disabled class="w3-select w3-border w3-half w3-hover-gray w3-margin-right " require style="width:100%;" name="departamento" id="departamento" >
              <?php           
              $sqlDepartamento = $conexion -> prepare ("SELECT * from departamento where id_dep > 1 AND departamento != '$Departamento' order by id_dep desc;");                                                      
              $sqlDepartamento -> execute();
              $verDepartamento = $sqlDepartamento -> fetchAll();
              foreach($verDepartamento as $verDep)
                {  ?>
                  <option value="<?php echo $verDep['departamento']?>"><?php echo $verDep['departamento']?></option>
                  <?php 
                }?>
            </select>     
            <br><br><br> 
          </p>                   
          <p id="redsaludDiv">  
            <label for="redsalud">Seleccione Centro de Salud</label>          
            <select disabled style="width:100%;" class="w3-select w3-border w3-half w3-hover-gray w3-margin-left js-example-basic-multipleredsalud" name="redsalud" required id="redsalud" >
            <option></option>
            <?php
              $sqlRedSalud = $conexion -> prepare ("SELECT * FROM verredsalud order by id_redsal;");
              $sqlRedSalud -> execute();
              $verSqlRedSalud = $sqlRedSalud -> fetchAll();

              foreach($verSqlRedSalud as $verSal)
                { if ($verSal['id_redsal'] != 333){  ?>

                  <option value="<?php echo $verSal['id_redsal']?>"><?php echo $verSal['nombre_redsal']?></option>
                  <?php }
                }?>
            </select>
          </p>            
          <p id="donacionesDiv">
            <label for="donaciones">Seleccione Requerimiento Aprobado</label>
            <select disabled style="width:100%;" class="w3-select w3-border w3-half w3-hover-gray w3-margin-left js-example-basic-multipleDonaciones" name="donaciones[]" multiple required id="donaciones" >
              <option></option>
              <?php
                $sqlDonaciones = $conexion -> prepare ("SELECT requerimientos FROM solicitud where id_solici = '$seleccion' order by requerimientos;");
                $sqlDonaciones -> execute();
                $verDonaciones = $sqlDonaciones -> fetchAll();

                foreach($verDonaciones as $verSal)
                  { $requerimientos = $verSal['requerimientos'];}

                  $datos = explode(",", $requerimientos);
                  for($i=0; $i<sizeof($datos); $i++){
                    ?>
                    <option value="<?php echo $datos[$i]?>"><?php echo $datos[$i]?></option>
                    <?php       
                  }?>
            </select>
            </p>            
            <p id="costoDiv">
              <input disabled maxlength="20" onKeyPress="return validarCosto(event)"  class="w3-input w3-border w3-half w3-hover-gray" placeholder="Costo"  style="width:20%" name="costo" type="text" id="costo"/>
            </p>               
          <button class="w3-btn w3-blue w3-margin-left" type="submit" name="registrostatus"/> Ingresar Status</button></td>
        </td>
        
        <td class="w3-center">            
          <input type="hidden" name="seleccionstatus" value="<?php printf($seleccion) ?>" />         
      </tr>

      <tr><td><div></div></td></tr>
      <br>
    </table>
  </form>
  </section>
  <?php }
  ?>
  </p>
  <p>&nbsp;</p>
</div>
<?php
$conexion = null;
$ConsultaStatus = null;
$sqlDefSta = null;
?>
<?php require_once('../includes/footer.php'); ?>
</div>

<script>
$(document).ready(function() 
{
    $('.js-example-basic-multipleredsalud').select2(
      {
        placeholder: 'Seleccione Centro de Salud...'        
      }); 
    $('.js-example-basic-multipleDonaciones').select2(
      {
        placeholder: 'Requerimientos aprobados...'        
      }); 
}); 
</script>
<script src="../js/scroll.js "></script>
<script src = "../js/consultarstatus.js" ></script>
<script src = "../js/validarNumeros.js" ></script>
</body>
</html>
