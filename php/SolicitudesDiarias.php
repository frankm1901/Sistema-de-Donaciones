<!DOCTYPE html>
<html>
<head>
  <title>Solicitudes Pendientes</title>
  <!-- <meta http-equiv="refresh" content="20" /> -->
<meta charset="utf-8">

<style type="text/css">

<!--
#Layer2 {
  position:absolute;
  width:985px;
  height:129px;
  z-index:1;
  left: 196px;
  top: 196px;
}
-->
</style>

</head>
<body>

<?php 
if (!isset($_SESSION)) {
  session_start();  
$usuario = $_SESSION['MM_Username'];
}
?>
<?php 
include '../Connections/conexion.php';
//Consulta para extraer el departamento al cual pertenece el usuario

 ?>
<?php require_once('../includes/header.php'); ?>
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:240px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Solicitudes Pendientes</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Solicitudes Pendientes</h1></b>
  </header>
  <div>

<?php
$patologias = $_POST['patologias'];
$departamento = $_POST['departamento'];

    ?>
</div>
    <div class="w3-content w3-responsive" id="Layer3">
    <br>
    <table class="w3-table-all w3-hoverable w3-border w3-centered w3-card-4">
    <th colspan = 8  > <center> <h3> Solicitudes pendientes por Trabajar</h3></center></th>
      <tr class="w3-teal">
          <td class="w3-teal">Asignado</td>
          <td class="w3-teal">Cédula</td>
          <td class="w3-teal">Nombre y Apellido</td>
          <td class="w3-teal">Patologias</td>
          <td colspan = "3" class="w3-teal">Requerimientos</td>
          <td class="w3-teal"></td>             
      </tr>
    <?php  
    //$patologias = '';   
            $ConsultaStatus = $conexion -> prepare ("SELECT id_solici, cedula_sol, nombre_sol, apellido_sol, patologias, requerimientos 
                                                    from solicitud 
                                                    INNER JOIN departamento on id_dep = id_dep
                                                    where patologias like '%$patologias%' and departamento like '%$departamento%'
                                                    ORDER BY requerimientos;");                      
            $ConsultaStatus -> execute();            
            $consulStatus = $ConsultaStatus -> fetchAll();        
            $i = 1;
            foreach($consulStatus as $VerStatus)
                { 
                  $idSolici = $VerStatus['id_solici'];                    
                  
                    $consultarDefStatus = $conexion -> prepare("SELECT id_defsta1 from status 
                                                                WHERE id_solici1 = '$idSolici'
                                                                order by id_status desc;");
                    $consultarDefStatus -> execute();
                    $definirStatus = $consultarDefStatus -> fetchAll();
                    $ver = true;
                    foreach($definirStatus AS $definir){
                      if ($definir['id_defsta1'] == 7 || $definir['id_defsta1'] == 8 || $definir['id_defsta1'] == 9 ){
                        $ver = false;
                        break;
                      }
                    }
                    if ($ver){
                      $idSolici."  ".$ver;                      
                      ?>
                      <tr> 
                        <td><?php echo $i++; ?></td>          
                        <td><?php echo $VerStatus["cedula_sol"]; ?></td>          
                        <td><?php echo $VerStatus["nombre_sol"]." ".$VerStatus["apellido_sol"]; ?></td>          
                        <td><?php echo $VerStatus["patologias"]; ?> </td>
                        <td><?php echo $VerStatus["requerimientos"]; ?> </td>                        
                        <td><?php// echo $nombre_defsta; ?> </td>                        
                        <td><?php// echo $observaciones_status; ?> </td>  
                        <td class="w3-center "><a href="ConsultarStatus.php?seleccion=<?php echo $VerStatus['id_solici']; ?>"><button class="w3-btn w3-blue w3-tiny">Ver <i class="fa fa-caret-right w3-margin-left"></i></button></a></td>
                      </tr>      
                    <?php       
                    }

                  
                } ?>
    </table>
    </div>
<br><br>
<?php require_once('../includes/footer.php'); ?>
</div>

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
</script>
</body>
</html>
