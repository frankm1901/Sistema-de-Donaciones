<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>

<!-- jquery -->
<script src="../assets/jquery/jquery.min.js"></script>

<!--select2-->
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">

<script src="../assets/select2/js/select2.min.js"></script>  
<!-- !PAGE CONTENT! -->Id_NivUsu
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Ingresar Centro de Salud</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Ingresar Centro de Salud</h1></b>
  </header>

  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

<?php if ($_SESSION['Id_NivUsu'] == 1 or $_SESSION['Id_NivUsu'] == 2 or $_SESSION['Id_NivUsu'] == 3 or $_SESSION['Id_NivUsu'] == 5)
{ ?>  
  <br><br>

 <div class="w3-container w3-content w3-margin-right" id="Layer1">
   <form method="POST" action="IngresoCentroSalud.php"  >
     <div class="w3-card-4 w3-col s12 l10">
      <div class="w3-container w3-teal">
        <h2>Centro de Salud</h2>
      </div>
      <br>
      <div class="w3-row-padding">
    <div><p>           

<!-- Inicio de la consulta para el Select de los Requerimientos -->
 <div><p> 
          <h3><label class="w3-margin-left">Consultar la existencia del Centro de Salud </label> </h3>
        </p></div>

<div class="w3-row-padding">
<select class="js-example-basic-multiple" style="width:100%;" id="centrosalud" name="centrosalud[]" multiple="multiple">
  <option>  </option>
    <?php 
          // Consulta para seleccionar los elementos de la tabla DONACIONES
          $tipoCentroSalud = $conexion -> prepare("SELECT * FROM redsalud order by nombre_redsal");
          $tipoCentroSalud -> execute();
          $listarCentroSalud = $tipoCentroSalud -> fetchAll();   
    
          foreach ($listarCentroSalud as $misdatos)
            {?>
                <option><?php echo $misdatos['nombre_redsal']; ?></option>
      <?php }?>   
</select>
</p>
</div>
<!-- Fin de la consulta para el select de los Requerimientos -->


        <label><h3>Ingreso del Centro de Salud</h3></label> 
        <div class="w3-row-padding">                      
                <label>Municipio</label>    <br>
                <select name="parroquia" style="width: 100%" required="required" id="parroquia" class="w3-select w3-border js-example-basic-multiple-localidad">
                

                        <option value="" disabled selected>Seleccionar Municipio</option> -->
                        <?php  
                            $queryM = $conexion ->prepare("SELECT id_localidades, id_parroquia, name_parroquia, name_municipio FROM localidades ORDER BY name_municipio, name_parroquia desc;");
                            $queryM -> execute();
                            $verMunicipio = $queryM -> fetchAll();
                            //var_dump ($verMunicipio);

                            foreach ($verMunicipio as $rowM)
                                { ?>
                                    <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                               <?php }    ?> 
                </select>
            </div>

        <div class="w3-half w3-margin-right" style="width: 47%" ><p>            
          <label class="w3-margin-left">Tipo de Centro de Salud</label>   
          <select class="w3-select w3-border" name="TipoCentro" id="TipoCentro" required>
            <option value="" disabled selected>Seleccionar Tipo de Centro de Salud</option>
            
                  <?php           
                   // Consulta para seleccionar los elementos de la tabla DONACIONES
                      $tipoDonacion = $conexion -> prepare("SELECT * FROM tiporedsalud order by nombre_tiporedsal desc");
                      $tipoDonacion -> execute();
                      $listarDonacion = $tipoDonacion -> fetchAll();   
    
                      foreach ($listarDonacion as $donaci)
                        {?>
                            <option value=<?php echo $donaci['id_tiporedsal']; ?>><?php echo $donaci['nombre_tiporedsal']; ?></option>
                  <?php }?>     
          </select></p>
          </div>
          
          <div class="w3-half" style="width: 50%"><p>  
           <label class="w3-margin-left">Descripción del Centro de Salud</label>   
          <input maxlength="100" name="centroSalud" type="text" id="centroSalud" placeholder="Ingrese el centro de Salud" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
        </div> 

        <div class="w3-row-padding w3-center w3-margin-left">
          <br>
          <button name="EnviarRequerimiento" type="submit" id="EnviarRequerimiento" class="w3-btn w3-blue">Registrar el centro de Salud</button>
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
  placeholder: 'Consultar Centro de Salud...'
});
});



$(document).ready(function() {
    $('.js-example-basic-multiple-localidad').select2({
  placeholder: 'Seleccionar Parroquia y Municipio...'
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