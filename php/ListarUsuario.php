<?php 
session_start();
if ($_SESSION['Id_NivUsu'] == 1) {
require_once('../includes/header.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large " style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Datos de Usuarios</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Datos de Usuarios</h1></b>
  </header>
  <br>
  <?php
include '../Connections/conexion.php';
?>
<div class="w3-responsive" align="center" id="Layer2">
<table border="1" class="w3-card-4 w3-table-all w3-hoverable" style="width:90%"> 
        <tr>
          <td class="w3-teal" colspan="4"><div class="w3-center"><h3>Datos de los Usuarios</h3></div></td> 
          
          <td class="w3-blue"colspan="3"><div class="w3-center"><h3>Acciones</h3></div></td>
          
        </tr>
          <tr>
          <td class="w3-center w3-gray"><b>Departamento</b></td>          
          <td colspan="2" class="w3-center w3-gray"><b>Nombre y Apellido</b></td>
          <td class="w3-center w3-gray"><b>Usuario</b></td>                          
          <td colspan="3" class="w3-gray" ></td>
        </tr>        
      <?php 
      $consulta = $conexion -> prepare("SELECT id_login, nombre_login, apellido_login, usuario, departamento 
                                        FROM login 
                                        inner join departamento on id_dep = id_dep1 order by id_dep1 asc;");
      
      $consulta ->execute();
      $verUsuarios = $consulta -> fetchAll();

      $contador=0;
      foreach ($verUsuarios as $usuarios)
        { ++$contador;?>
          <tr>
            <td class="w3-center"><?php echo $usuarios["departamento"]; ?></td>            
            <td colspan="2" class="w3-margin-left"><?php echo $usuarios["nombre_login"]." ".$usuarios["apellido_login"]; ?></td>          
            <td class="w3-center"><?php echo $usuarios["usuario"]; ?></td>
            </td>
            
            <td class="w3-center "><a href="ModificarUsuario.php?seleccion=<?php echo $usuarios['id_login']; ?>"><button class="w3-btn w3-blue w3-tiny">Editar <i class="fa fa-caret-right w3-margin-left"></i></button></a></td>
          </tr> 
      <?php
      }?>
</table> 
</div>       
<?php 

?>
 <p>&nbsp;</p>
</div>
    <!-- FIN DEL IF CONDICIONAL DE LA VALIDACION DE QUE LOS CAMPOS SE HALLAN ENVIADOS -->

  </div>
<br><br>
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

<?php }else {         
        header("Location: ./dashboard.php");
      }

?>
</body>
</html>