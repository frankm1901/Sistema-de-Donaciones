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
    <b><h1 class="w3-xxxlarge w3-text-white">Ingresar Patologias</h1></b>
  </header>

  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

<?php if ($_SESSION['Id_NivUsu'] == 1 or $_SESSION['Id_NivUsu'] == 2 or $_SESSION['Id_NivUsu'] == 3 or $_SESSION['Id_NivUsu'] == 5)
{ ?>  
  <br><br>
 <div class="w3-container w3-content w3-margin-top" id="Layer1">
   <form method="POST" action="IngresoPatologia.php"  >
     <div class="w3-card-4 w3-col s12 l10">
      <div class="w3-container w3-teal">
        <h2>Datos de la Patología</h2>
      </div>
      <br>
      <div class="w3-row-padding">       
          <div> <P>
<!-- Inicio de la consulta para el Select de los Requerimientos -->
         
 <div><p> 
           <h3><label class="w3-margin-left">Consultar la existencia de Patologias</label> </h3>
        </p></div>            

<div class="w3-row-padding">
<select class="js-example-basic-multiple" style="width:100%;" id="requerimientos" name="requerimientos[]" multiple="multiple">
  <option>  </option>
    <?php 

      $patologiaSql = $conexion -> prepare("SELECT * FROM patologias order by patologia;");
      $patologiaSql -> execute();      
      $verPatologia = $patologiaSql -> fetchAll();
      foreach ($verPatologia as $ver)
        {?>
          <option ><?php echo $ver['patologia']; ?></option>
    <?php }?>   
</select>
</p>
</div>
<!-- Fin de la consulta para el select de los Requerimientos -->                    
          <p>  
           <h3>Ingresar el Nombre de la Patología </h3>
          <input maxlength="50" name="patologia" type="text" id="patologia" style="width: 95%" placeholder="Ingrese la Patologìa" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text"></p>
        </div> 

        <div class="w3-row-padding w3-center">
          <br>
          <button name="EnviarPatologia" type="submit" id="EnviarPatologia" class="w3-btn w3-blue">Ingresar Patología</button>
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
  placeholder: 'Seleccionar Patologias...'
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