<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
</head>
<body>
  
<?php require_once('../includes/header.php'); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large " style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Busqueda de Datos</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Busqueda de Datos</h1></b>
  </header>
  <br>
  <?php
include '../Connections/conexion.php';

if ($_GET){$_POST['DatosPaciente'] = $_GET['cedulaEnviada']; }

if ($_POST)//CONDICIONAMOS SI SE ENVIARON DATOS POR EL METODO POST
{ //INICIO DEL CUERPO DE LA BUSQUEDA PARA LOS DATOS DEL PACIENTE
  if (isset($_POST['DatosPaciente']))
  {  
     $DatosPaciente = $_POST['DatosPaciente'];
    ?>

      <div class="" id="Layer1">          
          <form id="FormBuscarPaciente" name="FormBuscarPaciente" method="post" action="">
            <div class="w3-responsive w3-row">
              <table class="w3-table w3-content w3-margin-center">
                <tr>
                <td style="width:85%"><input required = "required" name="DatosPaciente" maxlength="15" id="DatosPaciente" type="text" placeholder="Ingrese Datos a Buscar"  value="<?php echo $_POST['DatosPaciente']; ?>" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required class="w3-input w3-border w3-hover-gray"></td>
                <td style="width:15%"><button name="submit" type="submit" class="w3-margin-left w3-btn w3-green" ><b>Buscar</b></button></label></td>
                
                </tr>   
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              </table>
            </div>
          </form>
      </div>

      <div class="w3-responsive" align="center" id="Layer2">
      <table border="" class="w3-card-4 w3-table-all w3-hoverable" style="width:90%"> 
              <tr>
                <td class="w3-teal" colspan="1"><div class="w3-center"><h3>Solicitante</h3></div></td> 
                <td class="w3-indigo" colspan="4"><div class="w3-center"><h3>Representado</h3></div></td>
                <td class="w3-deep-orange" colspan="3"><div class="w3-center"><h3>Requiere</h3></div></td>                
                <td class="w3-blue"colspan="2"><div class="w3-center"><h3>Acciones</h3></div></td>                
              </tr>
              <tr>                
                <td class="w3-center w3-gray"><b>Cédula</b></td>
                <td colspan="4" class="w3-center w3-gray"><b>Nombre y Apellido</b></td>                
                <td colspan="3" class="w3-center w3-gray"><b>Solicitado</b></td>       
                <td colspan="2" class="w3-gray" ></td>
              </tr>
            <?php 
        
            //echo "Datos del Paciente a ser buscados: ".$DatosPaciente;
                $consulta = $conexion ->prepare("SELECT id_solici, patologias, requerimientos, cedula_sol, nombre_sol, apellido_sol, cedula_pac, apellido_pac, nombre_pac from solicitud
                                                  WHERE nombre_sol LIKE '%$DatosPaciente%' or apellido_sol LIKE '%$DatosPaciente%' 
                                                  or nombre_pac LIKE '%$DatosPaciente%'  or apellido_pac LIKE '%$DatosPaciente%'
                                                  or cast (cedula_pac as varchar) LIKE '%$DatosPaciente%' or cast (cedula_sol as varchar) LIKE '%$DatosPaciente%'
                                                  and activo = 'activo'
                                                  order by patologias, nombre_sol LIMIT 30 OFFSET 0;");                           
                $consulta -> execute();
                $busqueda = $consulta-> fetchALL();            

                foreach($busqueda as $misdatos)
                    { 
                      if ($misdatos['nombre_pac'] == 'null')
                        { $misdatos['nombre_pac'] = '';    $misdatos['apellido_pac'] = '';   $misdatos['cedula_pac'] = '';
                          $misdatos['telefono_pac'] = ''; 
                        }                                                  
                      if ($misdatos['cedula_sol'] == 0){$misdatos['cedula_sol']='';} 
                      if ($misdatos['cedula_pac'] == 0){$misdatos['cedula_pac']='';}  
                      ?>      
                        <tr>
                            <td colspan="1" class="w3-center"><strong>Solicitante: </strong><?php echo $misdatos["cedula_sol"]; ?> <br>
                                                  <strong>Paciente: </strong><?php echo $misdatos["cedula_pac"]; ?></td>

                            <td colspan="4" class="w3-margin-left"><strong>Solicitante: </strong><?php echo $misdatos["nombre_sol"]." ".$misdatos["apellido_sol"]; ?><br>                                      
                                                                  <strong>Paciente: </strong><?php echo $misdatos["nombre_pac"]." ".$misdatos["apellido_pac"]; ?></td>
                            <td colspan="3" class="w3-center"><strong>Patologia: </strong> <?php echo $misdatos["patologias"]; ?><br>
                                                  <strong>Requerimientos: </strong> <?php echo $misdatos["requerimientos"]; ?></td>
                            
                            <td colspan="1" class="w3-center"><a href="ConsultarStatus.php?seleccion=<?php echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-blue w3-tiny">Ver <i class="fa fa-caret-right w3-margin-left"></i></button></a></td>
                            
                            <td colspan="1" class="w3-center "><a href="editarPaciente.php?seleccion=<?php echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-blue w3-tiny">Editar <i class="fa fa-caret-right w3-margin-left"></i></button></a></td>
                    
                            <!--<td class="w3-center "><a href="_registro_paciente.php?seleccion=<?php //echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-blue w3-tiny">Nuevo <i class="fa fa-caret-right w3-margin-left"></i></button></a></td>
                              -->        
                            <?php 
                              //if (($_SESSION['Id_NivUsu'] == 1) or ($_SESSION['Id_NivUsu'] == 3)) 
                                //  { ?>   
                                   <!-- <td class="w3-center "><a href="actualizarSolicitantes.php?seleccion=<?php echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-blue w3-tiny">Editar <i class="fa fa-caret-right w3-margin-left"></i></button></a></td>
                                -->
                                    <?php 
                                  //} ?>            
                        </tr> 
                        <?php
                    }?>       
          </table> 
          </div>       
          <?php 
  }
}
else
{ ?>
  <div id="Layer1">
    <form id="FormBuscarPaciente" name="FormBuscarPaciente" method="post" action="">
      <br>  
    <div class="w3-responsive" align="center">
        <table class="w3-table w3-content w3-margin-center" width="614" border="0">
        <tr>
            <td style="width:85%"><input maxlength="15" name="DatosPaciente" id="DatosPaciente" type="text" placeholder="Ingrese Datos a Buscar" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></td>
            <td style="width:15%"><button name="submit" type="submit" class="w3-margin-left w3-btn w3-green">Buscar</button></label></td>
            
      </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
        </table>
        </p>
        </div>
        <div class="w3-responsive">
        <table border="3" class="w3-card-4 w3-table-all w3-hoverable w3-content" style="width:90%">
          <tr>
            <td class="w3-teal" colspan="3"><div class="w3-center"><h3>Datos del Solicitante</h3></div></td>
            <td class="w3-indigo"colspan="3"><div class="w3-center"><h3>Datos del paciente</h3></div></td>
          </tr>
          <tr>
            <td class="w3-center w3-gray"><b>N° Solicitud</b></td>
            <td class="w3-center w3-gray"><b>Cédula</b></td>
            <td class="w3-center w3-gray"><b>Nombre y Apellido</b></td>
            <td class="w3-center w3-gray"><b>Cédula</b></td>
            <td class="w3-center w3-gray"><b>Nombre y Apellido</b></td> 

          </tr>
        </table>
        </div>
      <p>&nbsp;</p>
    </form>
  <p>&nbsp;</p>
  </div>
    <!-- FIN DEL IF CONDICIONAL DE LA VALIDACION DE QUE LOS CAMPOS SE HALLAN ENVIADOS -->
    
<?php } ?>
  </div>
<br><br>
<?php require_once('../includes/footer.php'); ?>

</div>

<script>
  // Change style of top container on scroll
window.onscroll = function() {myFunction()};
function myFunction() 
{
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) 
    {
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