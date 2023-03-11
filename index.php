<link rel="stylesheet" type="text/css" href="css/parpadea.css">
<?php include_once('Connections/conexion.php'); ?>
<?php
// *** Validate request to login to this site.
$aca = "false";
if (!isset($_SESSION)) {   
    session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) { 
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];    
}

if (isset($_POST['usuario'])) {
   $Username=$_POST['usuario'];
   $password= md5($_POST['password']);
    //$password= $_POST['password'];
    
  
    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "php/dashboard.php";
    $MM_redirectLoginFailed = "index.php";
    $MM_redirecttoReferrer = false;

    //extraemos el id del departamento para poder restringir el acceso a Registrar Usuario y Registro de Requerimientos
    $sentenciaSql = $conexion->prepare("SELECT id_login, id_dep, departamento, id_nivusu1, nivel_nivusu, nombre_login, apellido_login 
                                  FROM ((login as log 
                                  right JOIN departamento as dep ON dep.id_dep = log.id_dep1) 
                                  right JOIN nivel_usuario as niv ON niv.id_nivusu = log.id_nivusu1)
                                  where usuario = ? and password = ?;"); 
    $sentenciaSql->execute([$Username, $password]);
    $datos = $sentenciaSql->fetch(PDO::FETCH_OBJ);
    print_r($datos);

    if ($sentenciaSql->rowcount()==1) {
        $loginStrGroup = "";
      //declare two session variables and assign them
        $_SESSION['Nombre'] = $datos->nombre_login;
        $_SESSION['Apellido'] = $datos->apellido_login;     
        $_SESSION['Id_Login'] = $datos->id_login;    
        $_SESSION['Id_Dep'] = $datos->id_dep;    
        $_SESSION['departamento'] = $datos->departamento;    
        $_SESSION['Id_NivUsu'] = $datos->id_nivusu1;    
        //$_SESSION['Id_NivUsu'] = 2;
        $_SESSION['nivel_nivusu'] = $datos->nivel_nivusu; 
        $_SESSION['MM_Username'] = $Username;
        $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

        if (isset($_SESSION['PrevUrl']) && false) {
          $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
        }
        header("Location: " . $MM_redirectLoginSuccess );    
    }else {    
      //header("Location: ". $MM_redirectLoginFailed );    
      $aca = "true";  
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>SISDO | Sistemas de Donaciones</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. --> 
  <link rel="icon" href="assets/img/img-icon.png"> 

  <!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="css/style.css">	
  <link rel="stylesheet" href="css/w3.css">	
  <link rel="stylesheet" href="css/conf.css">
  <link rel="stylesheet" href="css/stylesheet.css">
  
  <!-- jquery -->
	<script src="assets/jquery/jquery.min.js"></script>
  
  <!-- jquery ui -->  
  <link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
 
</head>

<body>

  <!-- Top container  -->
  <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
    <span class="w3-bar-item w3-left w3-xlarge"><b style="font-family: Arial;">Sistema de Donaciones</b></span>
    <span class="w3-bar-item w3-right w3-xlarge"><b style="font-family: Arial;">SISDO</b></span>
  </div>
 
  <!--HEADER
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff; padding:10px 5px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Sistema de Donaciones</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:17px 20px">
    <br><br><h1 class="w3-xxxlarge w3-text-white w3-margin-top w3-center">Sistema de Donaciones</h1></b>
  </header>
  -->
  <header class="w3-container w3-white" style="padding: 5px 10px">
    <br>
    <center><img class="w3-margin-top w3-image" src="assets/img/img-logoNuevo.png"></center>
   
  </header>
  
  <hgroup> 
   <h3  class="w3-text-red">Bienvenido </h3>
   <h4 class="w3-text-red">Por favor, ingrese sus datos para iniciar</h4>
 </hgroup>

 <form id="login-form" name="iniciar_sesion" role="form" method="post" action="<?php echo $loginFormAction; ?>">
   <?php 

  if ($aca == "true") {  ?>
    <span class="parpadea mensaje"><strong>Usuario / Contraseña incorrectossss</strong></span>  
    <br>  <br>
    <?php
  }

   ?>
   <input type="hidden" name="is_login" value="1">
   <div class="group">
     <input type="text" name="usuario" required id="usuario" placeholder="Usuario..."><span class="highlight"></span><span class="bar"></span>
     <label>Usuario</label>
   </div>
 
   <div class="group">
     <input type="password" required name="password" id="password" placeholder="Contraseña...">
     <span class="highlight"></span>
     <span class="bar"></span>
     <label>Contraseña</label>
   </div>
   
   <button type="submit" name="inicio" id="inicio" class="button buttonBlue"><b>Entrar</b>
     <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
   </button>
 
 
 </form>
  <br>
 <?php require_once('includes/footer.php'); ?>

 <!-- Javascript -->
   <script src='js/jquery.min.js'></script>
   <script src="js/index.js"></script>
   
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
