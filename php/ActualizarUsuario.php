<!DOCTYPE html>
<html>
<head>
	<title>Ingreso Usuario</title>
  <style type="text/css" src="../css/modal.css"></style>
  

<?php //require_once('../includes/header.php'); ?>


<script src="../assets/select2/js/select2.min.js"></script>  
</head>
<body>


<?php 
session_start();
// INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->
  $a=1;
  if ($_SESSION['Id_NivUsu'] == $a)
  { 	
  ?>
  <?php 

  include '../Connections/conexion.php';


$_SESSION['Id_NivUsu']."<br>";
$_SESSION['Id_Dep']."<br>";

$Seleccion=$_POST['Seleccion'];
$Nombre=$_POST['Nombre'];
$Apellido=$_POST['Apellido'];
$Usuario=$_POST['Usuario'];
$Password=md5($_POST['password']);
$IdNivUsu = $_POST['NivelUsuario'];
$Id_Dep = $_POST['departamento'];


  echo "<br>";
  
  //Consulta para la Insercion de los Datos en la Tabla Login
  $ConsultaUsuario = $conexion->prepare ("UPDATE login SET nombre_login = '$Nombre', apellido_login = '$Apellido', usuario = '$Usuario', Password='$Password', id_nivusu1 = '$IdNivUsu', id_dep1 = '$Id_Dep' where id_login = '$Seleccion';");		
  echo $ConsultaUsuario -> execute() ? header("Location: ListarUsuario.php"):print_r($ConsultaUsuario->errorInfo());  
}else{
?>
<div id="modal"> <!-- padre -->
  <div id="modal-back"></div> <!-- fondo -->
  <div class="modal" class="w3-col s5 l5">
      <div id="modal-c" > <!-- subcontenedor -->
       <br>
       <div class="w3-container">
        <div class='w3-content w3-center w3-text-red'><i class='w3-jumbo fa fa-warning'></i></div><br>
           <h2 class="w3-center w3-margin-top">NO TIENE PRIVILEGIOS SUFICIENTES</h2>
               <h2 class="w3-center w3-margin-top">PARA REGISTRAR USUARIOS</h2>           
       </div>
       <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">CONTACTE CON EL ADMINISTRADOR DEL SISTEMA</h4>
       <div class="w3-center w3-margin-top w3-margin-bottom">
           <button name="EnviarFornulario" type="submit" class="w3-btn w3-blue w3-center w3-margin-top w3-margin-bottom"><a id="mclose" href="dashboard.php">Continuar</a></button>
         <br>
       </div>
    </div> <!-- contenedor -->
  </div>    
</div>
<?php
}
?>
</body>
</html>