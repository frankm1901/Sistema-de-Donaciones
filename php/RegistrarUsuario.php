<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
  <title>Registrar Usuario</title>

<style type="text/css" src="../css/modal.css"></style>
</head>
<body>

<?php 
session_start();
if ($_SESSION['Id_NivUsu'] == 1) {


require_once('../includes/header.php'); ?>
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
  </div>
  <form class="w3-container" name="FormRegistro" method="POST" action="IngresoUsuario.php">
    <br>
    <div class="w3-row-padding">
	  <div class="w3-half">    
         <label class=""><b>Nombre</b></label>
         <input name="Nombre" type="text" id="Nombre" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></div>
      <div class="w3-half">    
         <label class=""><b>Apellido</b></label>
         <input name="Apellido" type="text" id="Apellido" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></div>
	</div>
	<br>
    <div class="w3-row-padding">
	  <div class="w3-third">    
         <label class=""><b>Nombre de Usuario</b></label>
         <input name="Usuario" type="text" id="Usuario" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></div>
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
			<option value="" disabled selected>Seleccionar Nivel de Usuario...</option>
			<?php 
          
//Iniciamos la consulta a la tabla de la base de datos para extraer los niveles de usuario
          $usuarioSql = "select * from nivel_usuario ";
//preparamos la consuylta          
          $prepareSql = $conexion->prepare($usuarioSql);
//ejecutamos la consulta preparada          
          $prepareSql->execute();
//Asignamos los datos de la tabla a la variable usuario          
          $usuario = $prepareSql->fetchALL();
                   
//Mostramos los resultados          
          foreach($usuario as $usu){          
          ?>
            <option value="<?php echo $usu['id_nivusu']; ?>"><?php echo $usu['nivel_nivusu']; ?> </option>            
          <?php } ?>
		</select>
	</div>
  <br>
  <div class="w3-row-padding">
    <label for=""><b>Departamento</b></label>
    <select required class="w3-select w3-border w3-hover-gray" name="departamento" id="departamento">
      <option value="" disabled selected>Seleccionar Departamento...</option>
      <?php 
//Iniciamos la consulta y la ejecucion de la sentencia para extraer los datos 
// de la tabla Departamento      
            $departSql = "select * from departamento";
            $prepareSql = $conexion -> prepare($departSql);
            $prepareSql -> execute();
            $dptoDatos = $prepareSql->fetchAll();
            
            foreach($dptoDatos as $dpto)                     
             { ?>

            <option value="<?php echo $dpto['id_dep']; ?>"><?php echo $dpto['departamento']; ?> </option>            
             <?php } ?>
    </select>
  </div>
	<br>
    <div class="w3-center">
    <button class="w3-btn w3-blue" name="guardae" type="submit">Registrar</button></div>
	<br>
  </form>
 </div>
</div>

<div>
  <?php 
     
}

     }else{   
          header("Location: ./dashboard.php");
         } 
?>
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