<script>

function activar(){
  document.getElementById('cedulaPaciente').disabled = false;
}
</script>
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
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Cédula del Solicitante</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Cédula del Solicitante</h1></b>
  </header>

  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

<?php// if ($_SESSION['Id_NivUsu'] == 1 or $_SESSION['Id_NivUsu'] == 2 or $_SESSION['Id_NivUsu'] == 3 or $_SESSION['Id_NivUsu'] == 5)
{ ?>  
  <br><br>

 <div class="w3-container w3-content w3-margin-top" id="Layer1">
   <form method="POST" action="registro_paciente.php"  >
     <div class="w3-card-4 w3-col s12 l10">
      <div class="w3-container w3-teal">
        <h2>Cedula de los Solicitante</h2>
      </div>
      <br>
      <div class="w3-row-padding">       
        <div> <P>
          <!-- Inicio de la consulta para el Select de los Requerimientos -->         
          <div><p> 
            <h3><label class="w3-margin-left">Cédula del Solicitantes</label> </h3>
            </p>
          </div>            
          <p>             
          <input onKeyPress="return validarCedula(event)"  maxlength="12" placeholder="Cedula del Solicitante" name="cedulaSolicitante"  type="text" id="cedulaSolicitante" onkeyup="javascript:activar()" onKeyPress="return numeros(event) "  class="w3-input w3-border w3-hover-gray">                            
        </div> 
        
      </div>
      <div class="w3-row-padding">       
        <div> <P>
          <!-- Inicio de la consulta para el Select de los Requerimientos -->         
          <div><p> 
            <h3><label class="w3-margin-left">Cédula del Paciente</label> </h3>
            </p>
          </div>            
          <p>             
          <input  onKeyPress="return validarCedula(event)" maxlength="12" placeholder="Cedula del Paciente" name="cedulaPaciente" disabled type="text" id="cedulaPaciente" onKeyPress="return numeros(event)"  class="w3-input w3-border w3-hover-gray">                            
        </div> 
        <div class="w3-row-padding w3-center">
          <br>
          <button name="EnviarCedula" type="submit" id="EnviarCedula" class="w3-btn w3-blue">Verificar Cédula</button>
        </div>  
        <br>
      </div>
    </form>    
  </div>
  
<div> 


  <?php /*
} else{
echo "<br><br><br>";
echo "<div class='w3-center w3-text-red'><i class='w3-jumbo fa fa-warning'></i></div><br>";
echo "<h2 class='w3-center'><b>NO TIENE PRIVILEGIOS SUFICIENTES<br>";
echo "PARA REGISTRAR LAS PATOLOGIAS<br><br>";
echo "CONTACTE CON EL ADMINISTRADOR DEL SISTEMA</b></h2>";}*/
echo "Id: ".$_SESSION['Id_Dep'];
?>
  <br><br><br>
  <?php require_once('../includes/footer.php'); ?>
</div>

<script src="../js/validarNumeros.js"></script>
<script src="../js/registroPaciente.js"></script>
</body>
</html>