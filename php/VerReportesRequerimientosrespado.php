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

<?php require_once('../includes/header.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large w3-text-white" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left">Reporte</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Reporte</h1></b>
  </header>
  <div>

<?php 
// Conexion con el servidor y la base de datos 
include '../Connections/conexion.php';
if (! $conexion){die ("ERROR EN LA CONEXION CON MYSQL: ".mysql_error());}
?>
<?php 

if ($_POST['RequerFechaInicio'] == "" or $_POST['RequerFechaFinal'] == ""){ print("No se envio una fecha valida en requerimientos<BR>");
}else{
//********************Inicio para el Reporte de Cantidad de Solicitudes Ingresadas**********************************
// Recibimos las variables mediante el methodo POST y es asignada a una variable
  $FechaInicio = $_POST['RequerFechaInicio'];
  $FechaFinal = $_POST['RequerFechaFinal'];
  $Requerimiento = $_POST['SelectRequer'];   
  $Patologia = $_POST['SelectPatol'];   


  

    
  ?>
</div>
    <div class="w3-responsive" id="Layer3">
    <br>
    <?php 
    echo "<h2 class='w3-margin-left'>Cantidad de Solicitudes Ingresadas</h2>";
    printf("<br><b class='w3-margin-left'>Fecha Inicial: </b>".$FechaInicio);
    printf("<br><b class='w3-margin-left'>Fecha Final: </b> ".$FechaFinal); 
    print("<br><b class='w3-margin-left'>El Requerimientos es: </b> ".$Requerimiento);
    print("<br><b class='w3-margin-left'>La Patologia es: </b> ".$Patologia);
    //printf("<br><b class='w3-margin-left'>Cantidad de registros coincidentes: </b> ".$TotalSolicitud."<br><br>"); 
     ?>
    <table border="1" class="w3-table-all w3-hoverable w3-border w3-centered w3-card-4">
      <tr class="w3-teal">
          <td width="5%" class="w3-teal">N° Solicitud</td>
          <td width="20%" class="w3-teal">Patologías</td>
          <td width="20%" class="w3-teal">Nombre y Apellido</td>
          <td width="10%" class="w3-teal">Cédula</td>          
          <td width="15%" class="w3-teal">Parroquia</td>
          <td width="15%" class="w3-teal">Fecha Ingreso</td>
          <td width="5%" class="w3-teal">Status</td>
      </tr>    
    <?php 
            //realizamos una consulta con la Base de Datos a la tabla Solicitud
            $ConsultaSolicitud = $conexion ->prepare("SELECT id_solici, id_localidades, name_municipio, patologias, edad_sol, cedula_sol, nombre_sol, apellido_sol, fecha_recibido_solicitud
                                                            FROM solicitud                                                     
                                                            INNER JOIN localidades ON localidades.id_localidades = id_localidades1
                                                            WHERE fecha_recibido_solicitud >= '$FechaInicio' 
                                                                  and fecha_recibido_solicitud<= '$FechaFinal' 
                                                                  and requerimientos LIKE '%$Requerimiento%' 
                                                                  and patologias LIKE '%$Patologia%'
                                                            order by id_solici;");
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();
            $contador=0;
            foreach ($ConsulSolicitud as $ConSol)
            { 
              
              $solicitud = $ConSol["id_solici"];?>

              <?php //Inicio de la consulta para verificar el Status de la Solicitud
                $ConsultaStatus = $conexion ->prepare("SELECT nombre_defsta FROM (status INNER JOIN definicion_status as def ON def.id_defsta = status.id_defsta1 ) WHERE id_solici1 = '$solicitud';");
                $ConsultaStatus -> execute();
                $ResultadoStatus = $ConsultaStatus -> fetchAll();
                  ?>      
                  <?php
                  foreach($ResultadoStatus as $VerStatus)
                    { ?>
                      <?php $ver = $VerStatus["nombre_defsta"]; ?>                
                      <?php }    
                      ?>
              <tr>    
                <td width="91"><?php echo $ConSol["id_solici"]; ?></td>
          <td width="245"><?php echo $ConSol["patologias"]; ?></td>
          <td width="213"><?php echo $ConSol["nombre_sol"]." ".$ConSol["apellido_sol"]; ?></td>          
          <td width="115"><?php echo $ConSol["cedula_sol"]; ?></td>
          <td width="245"><?php echo $ConSol["name_municipio"]; ?></td>
          
          
          
          <td width="224"><?php echo $ConSol["fecha_recibido_solicitud"]; ?> </td>
          <td><?php echo $ver; ?> </td>
        </tr>    
        <?php } ?>
    </table>
    </div>
<br><br>
<?php require_once('../includes/footer.php'); ?>
</div>
<?php } ?>

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