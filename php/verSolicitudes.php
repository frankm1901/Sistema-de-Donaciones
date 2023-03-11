<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <!-- jquery -->
  <script src="../assets/jquery/jquery.min.js"></script>
  <!--select2-->
  <link rel="stylesheet" href="../assets/select2/css/select2.min.css">
  <script src="../assets/select2/js/select2.min.js"></script>  
</head>
<body>
<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Solicitudes Pendientes</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Solicitudes Pendientes</h1></b>
  </header>

  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

<?php if ($_SESSION['Id_Dep'] == 1 or $_SESSION['Id_Dep'] == 2 or $_SESSION['Id_Dep'] == 3 or $_SESSION['Id_Dep'] == 5)
{ ?>  
  <br><br>

 <div class="w3-container w3-content w3-margin-top" id="Layer1">
   <form method="POST" action="SolicitudesDiarias.php"  >
     <div class="w3-card-4 w3-col s12 l10">
      <div class="w3-container w3-teal">
        <h2>Detalle de la Solicitud</h2>
      </div>
      <br>
      <div class="w3-row-padding">       
      <div> <P>
        <!-- Inicio de la consulta para el Select de los Requerimientos -->            
      <div><p> 
           <!-- <h3><label class="w3-margin-left">Solicitudes Pendientes a Consultar</label> </h3> -->
          </p>
      </div>     
      <!-- <div class="w3-col w3-container" >
        <p>
              <input class="w3-check w3-margin-left w3-margin-top" type="radio" value = "noOperadosDetalladosPorPatologias" id = "noOperadosDetalladosPorPatologias" name="detalle"  
              onchange="document.getElementById('patologias').disabled = true"> 
              <label class="w3-margin-left" for = "noOperadosDetalladosPorPatologias">CANTIDAD - NO OPERADOS DETALLADOS POR PATOLOGIAS</label>                 
        </p>
        <p>
              <input class="w3-check w3-margin-left w3-margin-top" type="radio" value = "noOperadosDetalladosPorPatologias" id = "noOperadosDetalladosPorPatologias" name="detalle"  
              onchange="document.getElementById('patologias').disabled = true"> 
              <label class="w3-margin-left" for = "noOperadosDetalladosPorPatologias">CANTIDAD - NO OPERADOS DETALLADOS POR PATOLOGIAS</label>                 
        </p>
      </div>                                          -->
      <div class="w3-row-padding">        
      <select class = "js-example-basic-multiple-departamento" required="required" style="width:35% hight : 40px" name="departamento" id="departamento">
        <option> </option>
            <?php
           
            $sqlDepartamento = $conexion -> prepare ("SELECT * from departamento where id_dep > 1 AND departamento <> '$Departamento' order by id_dep desc;");                                                      
            $sqlDepartamento -> execute();
            $verDepartamento = $sqlDepartamento -> fetchAll();

            foreach($verDepartamento as $verDep)
              {  ?>
                <option value="<?php echo $verDep['departamento']?>"><?php echo $verDep['departamento']?></option>
                <?php 
              }?>
          </select>     
        </div>
        </p>
        <p>

        <div class="w3-row-padding">
                    <select class="js-example-basic-multiple" required="required" style="width:100%;" name="patologias" >
                        <option> </option>
                            <?php 
                                  // Consulta para seleccionar los elementos de la tabla DONACIONES
                                  $consulta = $conexion -> prepare("SELECT patologia FROM patologias order by patologia;");
                                  $consulta -> execute();
                                  $resultado = $consulta -> fetchAll();                                                                                           
                              foreach($resultado as $result)
                                  { 
                            ?>
                                    <option value="<?php echo $result['patologia']; ?>"><?php echo $result['patologia']; ?>                                    </option>
                            <?php }
                            ?>           
                    </select>    
          </div>
          <p>     
      
          
</div> 

    <div class="w3-row-padding w3-center">
          <br>
      <button name="EnviarPatologia" type="submit" id="EnviarPatologia" class="w3-btn w3-blue">Buscar Solicitudes</button>
    </div>  
      <br>
  </form>
</div>
</div>
  
<div> 


  <?php 
} else{
echo "<br><br><br>";
echo "<div class='w3-center w3-text-red'><i class='w3-jumbo fa fa-warning'></i></div><br>";
echo "<h2 class='w3-center'><b>NO TIENE PRIVILEGIOS SUFICIENTES<br>";
echo "PARA REGISTRAR LAS PATOLOGIAS<br><br>";
echo "CONTACTE CON EL ADMINISTRADOR DEL SISTEMA</b></h2>";}
?>
  <br><br><br>
  <?php require_once('../includes/footer.php'); ?>
</div>
<script>
     $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
  placeholder: 'Seleccionar Patologia...'
});
});

$(document).ready(function() {
    $('.js-example-basic-multiple-departamento').select2({
  placeholder: 'Seleccionar Departamento...'
});
});

 </script>
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