<!DOCTYPE html>
<html>
<head>
	<title>Ingreso Usuario</title>
  <style type="text/css" src="../css/modal.css"></style>
</head>
<body>


<?php 
session_start();
// INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

?>
<?php 

include '../Connections/conexion.php';
//session_start();
echo "El Id_NIvUsu Nivel de Usuario es: .".$_SESSION['Id_NivUsu']."<br>";
echo "El Id_dep1 del Departamento es  : .".$_SESSION['Id_Dep']."<br>";

// INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->


print "<br>El Nombre es: ".$Nombre=$_POST['Nombre'];
print "<br>El Apellido es: ".$Apellido=$_POST['Apellido'];
print "<br>El Usuario es: ".$Usuario=$_POST['Usuario'];

print "<br>El Password es: ".$Password=md5($_POST['password']);
print "<br>El Nivel de Usuario es: ".$IdNivUsu = $_POST['NivelUsuario'];
print "<br>El Nivel de Departamento es: ".$Id_Dep = $_POST['departamento'];

echo "<br> fecha de Ingreso: ". $fechaIngreso = date('Y-m-d');



echo "<br>";
?>

<?php 
//Consulta para la Insercion de los Datos en la Tabla Login

$resultado = $conexion->prepare("INSERT INTO login (nombre_login, apellido_login, usuario, Password, id_nivusu1, id_dep1, fecha_login) 
VALUES (:nombre_login, :apellido_login, :usuario, :Password, :id_nivusu1, :id_dep1, :fecha_login);");

$resultado -> bindParam(':nombre_login', $Nombre);
$resultado -> bindParam(':apellido_login', $Apellido);
$resultado -> bindParam(':usuario', $Usuario);
$resultado -> bindParam(':Password', $Password);
$resultado -> bindParam(':id_nivusu1', $IdNivUsu);
$resultado -> bindParam(':id_dep1', $Id_Dep);
$resultado -> bindParam(':fecha_login', $fechaIngreso);

if ($resultado -> execute())
{ header("location: RegistrarUsuario.php");
} else {
        echo "<br>Error al insertar datos<br>";
        print_r($conexion->errorInfo());
      }
      



//Se procede a realizar la insercion de los datos en la Tabla Login

//echo $ingreso ? "<br><br>Exito al Insertar los Datos en la Tabla Login":"<br><br>Error al Insertar los Datos en la Tabla Login";
  

/*   if ($prepareSql ->execute()){
    echo "-------------------------------------------";
    */
    //header("location: RegistrarUsuario.php");
      /*    }   */


?>



<!--
<div id="modal">  -->                 <!-- padre -->
  <!-- <div id="modal-back"></div> -->       <!-- fondo -->
  <!--<div class="modal" class="w3-col s5 l5"> -->
      <!--<div id="modal-c" > -->           <!-- subcontenedor -->
       <!--<br>
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
    </div> -->               <!-- contenedor -->
  <!-- </div>    
</div>
-->
<?php

?>
</body>
</html>