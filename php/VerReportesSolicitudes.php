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
if (! $mysqli){die ("ERROR EN LA CONEXION CON MYSQL: ".mysql_error());}
?>
<?php 


?>
<?php
//********************Inicio para el Reporte de Cantidad de Solicitudes Ingresadas**********************************
 // Recibimos las variables mediante el methodo POST
 //Asignamos las variables a los datos de Inicio del Formulario
    $FechaInicio = $_POST['FechaInicio'];
    $FechaFinal = $_POST['FechaFinal'];   

if ($FechaInicio > $FechaFinal) {print("<h1>Debe Ingresar Una Fecha Valida</h1><br>");
print("<h1>La Fecha Inicio no puede ser menor a la Fecha Final</h1>");
}else{
      if ($FechaFinal > $Fecha = date("Y-m-d"))
        {print("<h1>Debe Ingresar Una Fecha Valida</h1><br>");  
          print("<h1>La Fecha Final no puede ser Mayor a la Fecha Actual</h1>");
      }else
      {

  //realizamos una consulta con la Base de Datos a la tabla Solicitud

    $ConsultaSolicitud = "SELECT localidad, municipio, id_solici, numero_solici, edad_pac, cedula_pac, nombre_pac, apellido_pac, telefono1_pac, telefono2_pac, fecha_solici, Requerimientos_solici, fecha_solici, patologias 
    FROM (((solicitud as sol
    INNER JOIN paciente as pac ON pac.id_pac = sol.id_pac1)
    INNER JOIN t_localidad as parroq ON parroq.id_localidad = sol.id_localidad1)
    INNER JOIN t_municipio as munici ON munici.id_municipio = parroq.id_municipio)
    WHERE sol.fecha_solici >= '$FechaInicio' and sol.fecha_solici <= '$FechaFinal' order by id_solici;";

    $ResultadoConsultaSolicitud = mysqli_query($mysqli , $ConsultaSolicitud); // Ejecutamos la consulta
    $TotalSolicitud = mysqli_num_rows ($ResultadoConsultaSolicitud); // Extraemos la cantidad de registros existentes
    $contador=0;

    ?>

</div>
    <div class="w3-responsive" id="Layer3">
    <br>    
    <?php 

    echo "<h2>Cantidad de Solicitudes Ingresadas</h2>";
    printf("<br><b class='w3-margin-left'>Fecha Inicial: </b>".$FechaInicio);
    printf("<br><b class='w3-margin-left'>Fecha Final: </b> ".$FechaFinal);    
    printf("<br><b class='w3-margin-left'>Cantidad de registros coincidentes: </b> ".$TotalSolicitud."<br><br>"); 
     ?>
    <table border="1" class="w3-table-all w3-hoverable w3-border w3-centered w3-card-4">
      <tr class="w3-teal">
          <td width="5%" class="w3-teal">Nº Solicitud</td>
          <td width="10%" class="w3-teal">Fecha Ingreso</td>
          <td width="20%" class="w3-teal">Nombre y Apellido</td>          
          <td width="10%" class="w3-teal">Cédula</td>
          <td width="10%" class="w3-teal">Edad</td>      
          <td width="10%" class="w3-teal">Telefono</td>      
          <td width="20%" class="w3-teal">Patologías</td>          
          <td width="15%" class="w3-teal">Requerimientos</td>
          <td width="5%" class="w3-teal">Status</td>
      </tr>
    <?php 
    while($misdatos = mysqli_fetch_assoc($ResultadoConsultaSolicitud))
      { $contador++;?>
        <?php $solicitud = $misdatos["id_solici"];?>
<?php //Inicio de la consulta para verificar el Status de la Solicitud
          $ConsultaStatus = "SELECT nombre_defsta FROM (status INNER JOIN definicion_status as def ON def.id_defsta = status.id_defsta1 ) WHERE id_solici1 = '$solicitud';";
            $ResultadoStatus = mysqli_query ($mysqli , $ConsultaStatus);
            $TotalStatus = mysqli_num_rows($ResultadoStatus);
            ?>      
            <?php
            while($VerStatus = mysqli_fetch_assoc($ResultadoStatus))
               { ?>
                <?php $ver = $VerStatus["nombre_defsta"]; ?>                
                <?php }    
                ?>
        <tr>    
          <td><?php echo $misdatos["numero_solici"]; ?></td>
          <td><?php echo $misdatos["fecha_solici"]; ?></td>
          <td><?php echo $misdatos["nombre_pac"]." ".$misdatos["apellido_pac"]; ?></td>                    
          <td><?php echo $misdatos["cedula_pac"]; ?></td>          
          <td><?php echo $misdatos["edad_pac"]; ?></td>
          <td><?php echo $misdatos["telefono1_pac"]." - ".$misdatos["telefono2_pac"]; ?></td>
          <td><?php echo $misdatos["patologias"]; ?></td>          
          <td><?php echo $misdatos["Requerimientos_solici"]; ?> </td>          
          <td><?php echo $ver; ?> </td>
        </tr>    
        <?php } ?>
    </table>
    </div>
<br><br>
<?php }}  ?>
<?php 
require_once('../includes/footer.php'); ?>
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
