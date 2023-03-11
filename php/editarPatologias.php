<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <script src="../assets/jquery/jquery.min.js"></script>
  <script src="../assets/select2/js/select2.min.js"></script>  
  <link rel="stylesheet" href="../assets/select2/css/select2.min.css">
</head>
<body>
  
<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Editar Patologias</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Editar Patologias</h1></b>
  </header>

  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO  -->

<?php// if ($_SESSION['Id_Dep'] == 1 or $_SESSION['Id_Dep'] == 2 or $_SESSION['Id_Dep'] == 3 or $_SESSION['Id_Dep'] == 5)
///*{ ?>  
  <br><br>


  <?php include '../Connections/conexion.php';?>

<?php  
if($_POST){
 $Patologias = $_POST['patologias'];//Datos del Select
 $Patologia = $_POST['patologia']; //Datos del Input
  
// Verificar si la Patologia Existe para no insertarla nuevamente 
 $verificar = $conexion -> prepare(" UPDATE patologias SET patologia = :Patologia WHERE idpat = :Patologias;"); 
 $verificar->bindParam(':Patologia', $Patologia);
 $verificar->bindParam(':Patologias', $Patologias);
 if (!$verificar->execute()){     
  echo "Error al Actualizar los Datos"; 
 }
}
?>
<div class="w3-container w3-content w3-margin-top" id="Layer1">
  <form method="POST" action="#"  >
    <div class="w3-card-4 w3-col s12 l10">
      <div class="w3-container w3-teal">
        <h2>Datos de la Patología</h2>
      </div>
      <br>
      <div class="w3-row-padding">       
        <div> <P>          
          <h3><label class="w3-margin-left">Seleccionar la Patologias a Editar</label> </h3>
          </p>
          <div class="w3-row-padding">
            <select class="js-example-basic-multiple" required style="width:100%;" id="patologias" name="patologias">
              <option>  </option>
                <?php 
                  $patologiaSql = $conexion -> prepare("SELECT * FROM patologias order by patologia;");
                  $patologiaSql -> execute();      
                  $verPatologia = $patologiaSql -> fetchAll();
                  foreach ($verPatologia as $ver)
                    {?>
                      <option value="<?php echo $ver['idpat']; ?>" ><?php echo $ver['patologia']; ?></option>
                <?php }?>   
            </select>
            </p>
          </div>
        </div>            
        <!-- Fin de la consulta para el select de los Requerimientos -->                    
        <div class="w3-row-padding">       
          <div> <P>          
          <p>  
        <h3>Edite la Patología Seleccionada </h3>
        <input maxlength="50" disabled name="patologia" type="text" id="patologia" style="width: 100%" placeholder="Ingrese la Patologìa" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text"></p>
      </div>

      <div class="w3-row-padding w3-center">
        <br>          
        <button name="EnviarPatologia" disabled type="submit" id="EnviarPatologia" class="w3-btn w3-blue">Editar Patología</button>
      </div>  
      <br>
    </div>  
  </form>
</div>
  
<div> 

  <br><br><br>
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
</script>
<script src="../js/editarPatologias.js"></script>
</body>
</html>