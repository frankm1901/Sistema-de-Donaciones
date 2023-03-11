<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>

<?php
//initialize the session
if (!isset($_SESSION)) {
session_start();  
}

?>

<!DOCTYPE html>
<html>
<title>Sistema de Donaciones</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- bootstrap -->
  <!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">-->
  <!-- bootstrap theme-->
  <!-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-theme.min.css"> -->
  <!-- font awesome -->
  <!-- <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">-->
  <!-- Custom CSS --> 
  <!-- <link rel="stylesheet" href="css/stylesheet.css">-->
  <!-- W3.CSS --> 
  <!-- <link rel="stylesheet" href="css/w3.css">-->
  <!-- jquery -->
  <!-- <script src="assets/jquery/jquery.min.js"></script>-->
  <!-- jquery ui -->  
  <!--<link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css"> -->
  <!-- <script src="assests/jquery-ui/jquery-ui.min.js"></script> -->
  <!-- bootstrap js -->
  <!-- <script src="assets/bootstrap/js/bootstrap.min.js"></script> -->

<style>
  @font-face {
    font-family: 'harabara_maisharabaramaisdemo', 'Open Sans';
    src: url('css/harabara_mais_demo-webfont.woff2') format('woff2'),
         url('css/harabara_mais_demo-webfont.woff') format('woff');
    font-weight: normal;
    font-style: normal;

}

h1,h4 { font-family: 'harabara_maisharabaramaisdemo', Arial, sans-serif; }

html,body,h2,h3,h5 {font-family: "Raleway", sans-serif}
hr {
       display: block;
       position: relative;
       padding: 0;
       margin: 8px auto;
       height: 0;
       width: 100%;
       max-height: 0;
       font-size: 1px;
       line-height: 0;
       clear: both;
       border: none;
       border-top: 1px solid #aaaaaa;
       border-bottom: 1px solid #ffffff;
    }
</style>
<body>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff; padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Bienvenido al Sistema</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:21px 25px">
    <h1 class="w3-xxxlarge w3-text-white">Bienvenido al Sistema</h1></b>
  </header>

  <div class="w3-container" style="padding:25px">
   <h3 class="w3-margin-left">Seleccione una opción para comenzar.</h3>
  </div>

  <div class="w3-row-padding w3-margin-bottom">

    <a href="BusquedaDatos.php">
      <div class="w3-quarter">
        <div class="w3-container w3-padding-16 w3-card-4 w3-margin-bottom" style="background:#e6b800;">
          <div class="w3-left w3-text-white"><i class="fa fa-search w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5 class="w3-text-white">Búsqueda de Datos</h5>
        </div></a>
      </div>  

    <a href="solicitante.php">
      <div class="w3-quarter">
        <div class="w3-container w3-teal w3-padding-16 w3-card-4 w3-margin-bottom">
          <div class="w3-left"><i class="fa fa-edit w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5>Ingresar Solicitud</h5>
        </div></a>
      </div>

    
     
      <a href="Requerimiento.php">
      <div class="w3-quarter">
        <div class="w3-container w3-deep-orange w3-padding-16 w3-card-4 w3-margin-bottom">
          <div class="w3-left"><i class="fa fa-plus-square w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5>Ingresar Requerimientos</h5>
        </div></a>
      </div> 

      <a href="Patologias.php">
      <div class="w3-quarter">
        <div class="w3-container w3-purple w3-padding-16 w3-card-4 w3-margin-bottom">
          <div class="w3-left"><i class="fa fa-plus w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5>Ingresar Patologías</h5>
        </div></a>
      </div> 

      <a href="centroDeSalud.php">
      <div class="w3-quarter">
        <div class="w3-container w3-deep-orange w3-padding-16 w3-card-4 w3-margin-bottom">
          <div class="w3-left"><i class="w3-xxlarge fa fa-hospital-o "></i></div>
          <div class="w3-clear"></div>
          <h5>Ingresar Centro de Salud</h5>
        </div></a>
      </div> 
      
      <a href="editarPatologias.php">
      <div class="w3-quarter">
        <div class="w3-container w3-purple w3-padding-16 w3-card-4">
          <div class="w3-left"><i class="fa fa-pencil-square-o w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5>Editar Patologias</h5>
        </div></a>
      </div> 

      <a href="editarRequerimiento.php">
      <div class="w3-quarter">
        <div class="w3-container w3-deep-orange w3-padding-16 w3-card-4">
          <div class="w3-left"><i class="fa fa-pencil-square w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5>Editar Requerimientos</h5>
        </div></a>
      </div> 

      <a href="Reportes.php">
      <div class="w3-quarter">
        <div class="w3-container w3-indigo w3-padding-16 w3-card-4 w3-margin-bottom">
          <div class="w3-left"><i class="fa fa-file-text w3-xxlarge"></i></div>
          <div class="w3-clear"></div>
          <h5>Generar Reportes</h5>
        </div></a>
      </div> 
  
    <a href="verSolicitudes.php">
        <div class="w3-quarter">
          <div class=" w3-container w3-red w3-padding-16 w3-card-4 ">
            <div class="w3-left"><i class="fa fa-inbox w3-xxlarge"></i></div>
            <div class="w3-clear"></div>
            <h5>Solicitudes Pendientes</h5>
          </div></a>
        </div> 
 
  <?php if ($_SESSION['Id_NivUsu'] == 1) { ?>
      <a href="RegistrarUsuario.php">
         <div class="w3-quarter">
           <div class="w3-container w3-blue-gray w3-padding-16 w3-card-4 w3-margin-bottom">
             <div class="w3-left"><i class="fa fa-user-plus w3-xxlarge"></i></div>
             <div class="w3-clear"></div>
             <h5>Registro de Usuarios</h5>
           </div></a>
      </div>

      <a href="ListarUsuario.php">
         <div class="w3-quarter">
           <div class="w3-container w3-teal w3-padding-16 w3-card-4 w3-margin-bottom">
             <div class="w3-left"><i class="fa fa-bars w3-xxlarge"></i></div>
             <div class="w3-clear"></div>
             <h5>Listar Usuarios</h5>
           </div></a>
      </div>


  <?php } ?> 
  </div>
  <br>
  <?php require_once('../includes/footer.php'); ?>
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

// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

<body>
</html>