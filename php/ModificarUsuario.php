<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
  <title>Registrar Usuario</title>

<style type="text/css" src="../css/modal.css"></style>
</head>
<body>
<?php require_once('../includes/header.php'); ?>
<?php include '../Connections/conexion.php'; ?>

<script >
	function handleClick(cb) {
  if(cb.checked){
  	 $('#password').attr("type","text");}
  else{
  	$('#password').attr("type","password");}
  
}
</script>

<script src="../js/jquery.min.js"></script>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">
 
<?php 
// INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->
$a=1;
if ($_SESSION['Id_NivUsu'] == $a)
{ 


$seleccion = $_GET['seleccion'];
?>
  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Registro de Usuarios</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Registro de Usuarios</h1></b>
  </header>

  <br><br>
<div class=" w3-container w3-content w3-margin-right">
  <div class="w3-card-4 w3-col s12 l10">
  <div class="w3-container w3-teal">
    <h2>Datos del Usuario</h2>


<?php 
    
    $consulta = $conexion -> prepare("SELECT log.nombre_login, log.apellido_login, log.usuario, usuario, id_nivusu, nivel_nivusu, id_dep, dep.departamento 
                            FROM ((login as log 
                            INNER JOIN departamento as dep on dep.id_dep = log.id_dep1)
                            INNER JOIN nivel_usuario as niv on niv.id_nivusu = log.id_nivusu1) where id_login ='$seleccion';");
    $consulta -> execute();
    $ver = $consulta-> fetchAll();
    foreach ($ver as $datos){
      $nombreLogin = $datos['nombre_login'];
      $nombreLogin = $datos['apellido_login'];
      $nombreLogin = $datos['usuario'];
      $nombreLogin = $datos['id_nivusu'];
      $nombreLogin = $datos['nivel_nivusu'];      
      $nombreLogin = $datos['id_dep'];
      $nombreLogin = $datos['departamento'];
    }?>
    
  </div>
  <form class="w3-container" name="FormRegistro" method="POST" action="ActualizarUsuario.php">
    <br>
    <div class="w3-row-padding">
    <div class="w3-half">    
         <label class=""><b>Usuario Seleccionado:</b></label>
         <input style="border: 0" readonly name="Seleccion" value="<?php echo $seleccion; ?>" type="text" id="Seleccion" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="">
       </div>      
  </div>
    <br>
    <div class="w3-row-padding">
	  <div class="w3-half">    
         <label class=""><b>Nombre</b></label>
         <input name="Nombre" value="<?php echo $datos['nombre_login']; ?>" type="text" id="Nombre" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></div>
      <div class="w3-half">    
         <label class=""><b>Apellido</b></label>
         <input name="Apellido" value="<?php echo $datos['apellido_login']; ?>" type="text" id="Apellido" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></div>
	</div>
	<br>
    <div class="w3-row-padding">
	  <div class="w3-third">    
         <label class=""><b>Nombre de Usuario</b></label>
         <input name="Usuario" value="<?php echo $datos['usuario']; ?>" type="text" id="Usuario" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></div>
      <div class="w3-third">    
         <label class=""><b>Contraseña</b></label>
         <input name="password" type="password" id="password" required class="w3-input w3-border w3-hover-gray"></div>
	  <div class="w3-third w3-margin-top">    
		 <input id="check" type="checkbox" name="check_mostrar" onclick='handleClick(this);' class="w3-check w3-margin-left">
		 <label for="check" class="w3-small w3-margin-left"><b>Mostrar Contraseña</b></label></div>
	</div>
	<br>
	<div class="w3-row-padding">
		<label for=""><b>Nivel de Usuario</b></label>
		<select required class="w3-select w3-border w3-hover-gray" name="NivelUsuario" id="">
			<option value="<?php echo $datos['id_nivusu'] ?>" > <?php echo $datos['nivel_nivusu']; ?> </option>
			<?php 
          $ConsultaNivelUsuario = $conexion ->prepare("SELECT * FROM nivel_usuario;");
          $ConsultaNivelUsuario -> execute();
          $ResultadoNivelUsuario =  $ConsultaNivelUsuario->fetchAll();
          
          foreach($ResultadoNivelUsuario as $verNivel)
             { ?>

            <option value="<?php echo $verNivel['id_nivusu']; ?>"><?php echo $verNivel['nivel_nivusu']; ?> </option>            
             <?php } ?>
		</select>
	</div>
  <br>
  <div class="w3-row-padding">
    <label for=""><b>Departamento</b></label>
    <select required class="w3-select w3-border w3-hover-gray" name="departamento" id="departamento">
      <option value="<?php echo $datos['id_dep']; ?>" ><?php echo $datos['departamento']; ?></option>
      <?php 
          $ConsultaDepartamento = $conexion ->prepare("SELECT * FROM departamento;");
          $ConsultaDepartamento -> execute();
          $ResultadoDepartamento =  $ConsultaDepartamento -> fetchAll();
          
          foreach($ResultadoDepartamento as $VerDepartamento)            
             { ?>

            <option value="<?php echo $VerDepartamento['id_dep']; ?>"><?php echo $VerDepartamento['departamento']; ?> </option>            
             <?php } ?>
    </select>
  </div>
	<br>
    <div class="w3-center">
    <button class="w3-btn w3-blue" name="guardae" type="submit">Actualizar</button></div>
	<br>
  </form>
 </div>
</div>

<div>
  <?php 
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
               <h2 class="w3-center w3-margin-top">PARA REGISTRAR USUARIO</h2>           
       </div>
       <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">CONTACTE CON EL ADMINISTRADOR DEL SISTEMA</h4>
       <div class="w3-center w3-margin-top w3-margin-bottom">
           <button name="EnviarFornulario" type="submit" class="w3-btn w3-blue w3-center w3-margin-top w3-margin-bottom"><a id="mclose" href="dashboard.php">Continuar</a></button>
         <br>
       </div>
    </div> <!-- contenedor -->
  </div>    
</div>


<?php } ?>
  <br><br><br>
  <?php require_once('../includes/footer.php'); ?>
</div>

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