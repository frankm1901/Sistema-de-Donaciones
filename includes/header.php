<!DOCTYPE html>
<html>
<title>SISDO | Sistema de Donaciones</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- font awesome -->
  <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
  <!-- custom css --> 
  <link rel="stylesheet" href="../css/w3.css"> 
  <link rel="stylesheet" href="../css/conf.css">
  <link rel="stylesheet" href="../css/stylesheet.css">

  <!-- jquery
  <script src="assets/jquery/jquery.min.js"></script> 
  jquery ui -->  
  <link rel="stylesheet" href="../assets/jquery-ui/jquery-ui.min.css">
  <script src="../assets/jquery-ui/jquery-ui.min.js"></script>
  

<style>
html,body,h2,h3,h5 {font-family: "Raleway", sans-serif}
hr {   display: block;
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
  <?php
//initialize the session
if (!isset($_SESSION)) {
session_start();  
}
?>

<?php
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
  
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    //header("Location: $logoutGoTo")
    header ("Location: ../index.php");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
  <?php        
          //***********INICIO DE LA CONSULTA PARA EXTRAER EL NOMBRE Y APELLIDO DEL USUARIO*******************                        
      ?>
  <!-- Top container -->
  <div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onClick="w3_open();"><i class="fa fa-bars"></i>  Menú</button>
    <span class="w3-bar-item w3-left w3-xlarge"><b style="font-family: Arial;">Sistema de Donaciones</b></span>
    <span class="w3-bar-item w3-right w3-xlarge"><b>SISDO</b></span>
  </div>

  <!-- Sidebar/menu -->
  <br>
  <nav class="w3-sidebar w3-collapse w3-light-gray w3-animate-left" style="z-index:3;width:245px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
     <div class="w3-col s4">
       <img src="../assets/img/img-useravatar.png" class="w3-circle w3-margin-top w3-margin-right" style="width:46px">
     </div>
     <div class="w3-col s8 w3-bar w3-margin-top">
       <span> Usuario:</span><br>
       <span><b class="w3-small"><?php echo $_SESSION['Nombre']." ".$_SESSION['Apellido']."<br>".$_SESSION['departamento']."<br>".$_SESSION['nivel_nivusu'];?></b></span>
     </div>
    </div>
    <br><hr>
    <div class="w3-container">
      <h5><b> Herramientas</b></h5>
    </div>
    <div class="w3-bar-block">
    
      <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onClick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Cerrar Menú</a>
      <a href="dashboard.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i>  Inicio</a>
      <a href="BusquedaDatos.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-search fa-fw"></i>  Búsqueda de Datos</a>
      <a href="solicitante.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-plus fa-fw"></i>  Ingresar Solicitud</a>
      <a href="Requerimiento.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-plus-square fa-fw"></i>  Ingresar Requerimientos</a>
      <a href="Patologias.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-plus fa-fw"></i>  Ingresar Patologías</a>
      <a href="centroDeSalud.php" class="w3-bar-item w3-button w3-padding"><i class=" fa fa-hospital-o"></i>  Ingresar Centro de Salud</a>
      <a href="editarPatologias.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-pencil-square-o  fa-fw"></i>  Editar Patologías</a>      
      <a href="editarRequerimiento.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-pencil-square   fa-fw"></i>  Editar Requerimientos</a>
      <a href="Reportes.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-file-text fa-fw"></i>  Generar Reportes</a>
      <!-- <a href="verSolicitudes.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-inbox fa-fw"></i>  Solicitudes Pendientes</a> -->
      
      <?php if ($_SESSION['Id_NivUsu'] == 1) { ?>
            <a href="RegistrarUsuario.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-plus fa-fw"></i>  Registrar Usuarios</a>
            <a href="ListarUsuario.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bars "></i>  Listar Usuarios</a>
            <a href="ListarStatusEliminados.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-trash "></i>  Status Eliminados</a>
            <a href="ListarRegistrosEliminados.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-trash-o "></i>  Registros Eliminados</a>            
      <?php } ?>
      


      <a onClick="document.getElementById('id01').style.display='block'" class="w3-bar-item w3-button w3-padding w3-hover-red"><i class="fa fa-sign-out fa-fw"></i>  Salir</a><br><br>

      <div class="w3-container">
        <hr>
        <div class="cleanslate w24tz-current-time w24tz-small" style="display: inline-block !important; visibility: hidden !important; min-width:220px !important; min-height:100px !important;"><p><a style="text-decoration: none " class="clock24" id="tz24-1541175354-c158-eyJob3VydHlwZSI6MTIsInNob3dkYXRlIjoiMSIsInNob3dzZWNvbmRzIjoiMSIsImNvbnRhaW5lcl9pZCI6ImNsb2NrX2Jsb2NrX2NiNWJkYzc4M2E5Y2ZiZiIsInR5cGUiOiJkYiIsImxhbmciOiJlcyJ9" title="Caracas hora" target="_blank" rel="nofollow"></a></p>
        <div id="clock_block_cb5bdc783a9cfbf"></div>
      </div>
   <script type="text/javascript" src="//w.24timezones.com/l.js" async></script>
</div>
</div>
</nav>

<div id="id01" class="w3-modal">
  <div class="w3-modal-content w3-margin-top w3-card-4 w3-animate-zoom" style="width:40%;">
    <header class="w3-container w3-indigo"> 
      <!--<span onClick="document.getElementById('id01').style.display='none'" 
      class="w3-button w3-display-topright w3-hover-red"><i class="fa fa-close"></i></span>-->
      <h2><i class="fa fa-warning"></i> Salir del Sistema</h2>
    </header>
    <div class="w3-container">
      <br>
      <h5 class="w3-margin-left"> ¿Está seguro de cerrar la sesión actual?</h5>
      <br><br>
      <div class="w3-center">
        <a href="<?php echo $logoutAction ?>"><button class="w3-btn w3-green w3-medium"> Aceptar</button></a>
        <button onClick="document.getElementById('id01').style.display='none'" class="w3-btn w3-red w3-medium w3-margin-left"> Cancelar</button>
      </div> 
      <br><br>
    </div>    
  </div>
</div>
</div>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onClick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
      modal.style.display = "none";
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