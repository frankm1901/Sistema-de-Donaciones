<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>

<!-- jquery -->
<script src="../assets/jquery/jquery.min.js"></script>

<!--select2-->
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">

<script src="../assets/select2/js/select2.min.js"></script>  
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Ingresar Requerimientos</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Ingresar Requerimientos</h1></b>
  </header>

  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

<?php if ($_SESSION['Id_NivUsu'] == 1 or $_SESSION['Id_NivUsu'] == 2 or $_SESSION['Id_NivUsu'] == 3 or $_SESSION['Id_NivUsu'] == 5)
{ ?>  
  <br><br>

 <div class="w3-container w3-content w3-margin-right" id="Layer1">
   <form method="POST" action="IngresoRequerimiento.php"  >
     <div class="w3-card-4 w3-col s12 l10">
      <div class="w3-container w3-teal">
        <h2>Datos del Requerimiento</h2>
      </div>
      <br>
      <div class="w3-row-padding">
    <div><p>           

<!-- Inicio de la consulta para el Select de los Requerimientos -->
 <div><p> 
          <h3><label class="w3-margin-left">Consultar la existencia de Requerimientos </label> </h3>
        </p></div>

<div class="w3-row-padding">
<select class="js-example-basic-multiple" style="width:100%;" id="requerimientos" name="requerimientos[]" multiple="multiple">
  <option>  </option>
    <?php 
          // Consulta para seleccionar los elementos de la tabla DONACIONES
          $tipoRequerimiento = $conexion -> prepare("SELECT * FROM donaciones order by nombre_donaci");
          $tipoRequerimiento -> execute();
          $listarRequerimiento = $tipoRequerimiento -> fetchAll();   
    
          foreach ($listarRequerimiento as $misdatos)
            {?>
                <option><?php echo $misdatos['nombre_donaci']; ?></option>
      <?php }?>   
</select>
</p>
</div>
<!-- Fin de la consulta para el select de los Requerimientos -->


        <label><h3>Ingreso de Requerimientos</h3></label> 
        <div class="w3-half"><p>            
          <label class="w3-margin-left">Tipo de Requerimiento</label>   
          <select class="w3-select w3-border" name="TipoReq" id="TipoReq" required>
            <option value="" disabled selected>Seleccionar Tipo de Requerimiento</option>
            
                  <?php           
                   // Consulta para seleccionar los elementos de la tabla DONACIONES
                      $tipoDonacion = $conexion -> prepare("SELECT * FROM tipo_donaciones order by nombre_tipdon");
                      $tipoDonacion -> execute();
                      $listarDonacion = $tipoDonacion -> fetchAll();   
    
                      foreach ($listarDonacion as $donaci)
                        {?>
                            <option value=<?php echo $donaci['id_tipdon']; ?>><?php echo $donaci['nombre_tipdon']; ?></option>
                  <?php }?>     
          </select></p>
          </div>
          
          <div class="w3-half"><p>  
           <label class="w3-margin-left">Descripción</label>   
          <input maxlength="50" name="Requerimiento" type="text" id="Requerimiento" placeholder="Ingrese la Descripción" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
        </div> 

        <div class="w3-row-padding w3-center">
          <br>
          <button name="EnviarRequerimiento" type="submit" id="EnviarRequerimiento" class="w3-btn w3-blue">Ingresar Requerimiento</button>
        </div>  
        <br>
    </form>
    </div>
  </div>
  <?php 
    //mysql_free_result($TipoRequerimiento);
  ?>

<div> 


  <?php 
} else{
echo "<br><br><br>";
echo "<div class='w3-center w3-text-red'><i class='w3-jumbo fa fa-warning'></i></div><br>";
echo "<h2 class='w3-center'><b>NO TIENE PRIVILEGIOS SUFICIENTES<br>";
echo "PARA REGISTRAR REQUERIMIENTOS<br><br>";
echo "CONTACTE CON EL ADMINISTRADOR DEL SISTEMA</b></h2>";}
?>
  <br><br><br>
  <?php require_once('../includes/footer.php'); ?>
</div>

<script>
     $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
  placeholder: 'Consultar Requerimientos Existentes...'
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