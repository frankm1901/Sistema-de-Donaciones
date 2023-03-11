<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link rel="stylesheet" href="../css/ajustartabla.css">  
</head>
<body>

<?php require_once('../includes/header.php'); ?>

<!-- !PAGE CONTENT! -->
<!-- Estructura del cuerpo de trabajo de la Página -->
<div class="w3-main" style="margin-left:245px;margin-top:1px;">
  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large " style="background:#3385ff;padding:0px 15px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Busqueda de Datos</span></h4>
  </div>  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Busqueda de Datos</h1></b>
  </header>
  <?php
  require_once('../Connections/conexion.php');
  
  $Fecha = date("d-m-Y");

  if(isset($_POST['enviado'])){ //Recibimos los datos enviados en el form del modal    
    $eliminado = $_POST['eliminar'];
    $busqueda = $_POST['busqueda'];
    
    $enviado = $_POST['enviado'];
    $_POST['DatosPaciente'] = $_POST['busqueda']; //asignamos el dato enviado para reasignarla al input de busqueda
    
    //Asignamos a la variable los datos de la session del usuario que elimino el registro
    $eliminadoPor = $_SESSION['Nombre']." ".$_SESSION['Apellido']." <strong>Dpto: </strong>".$_SESSION['departamento']." Fecha: ".$Fecha;    
    //inactivamos el registro para una posterior eliminacion definitiva
    $eliminadoSql = $conexion -> prepare("UPDATE SOLICITUD SET activo = 'inactivo', eliminadopor = '$eliminadoPor'  WHERE id_solici = $eliminado;");
    
    if($eliminadoSql->execute()){ //En caso de que el proceso se ejecute de forma exitosa se inactiva el registro
      ?>
      <div style="width:50%;" class="w3-content w3-margin-center">
        <div>
          <div id="primero" style="display: none; color : white;" class="w3-teal"> <h4><center>Regitro eliminado temporalmente con Exito</center> 
          </div>      
          <div id="segundo" style="display: none; color : red;" class="w3-deep-orange"><center> El Registro pasara por una revision para su Eliminación definitiva</center> </h4>
          </div>    
        </div>    
      </div>      
      <?php
    }
  }
  //
  $nivelUsuario = $_SESSION['Id_NivUsu'];
  if (isset($_POST['eliminado'])){  
      $eliminado = $_POST['eliminado'];
      $busquedaActual = $_POST['busqueda'];      
      $_POST['DatosPaciente']=$_POST['busqueda'];      
  }
  $DatosPaciente = '';
  if (isset($_POST['DatosPaciente'])){  
    $DatosPaciente = $_POST['DatosPaciente'];
  }
  //Contatamos si los datos son enviados o no
  if (!$_POST){ //CONDICIONAMOS SI SE ENVIARON DATOS POR EL METODO POST
              //INICIO DEL CUERPO DE LA BUSQUEDA PARA LOS DATOS DEL PACIENTE
      $consulta = $conexion ->prepare("SELECT id_solici, patologias, requerimientos, cedula_sol, nombre_sol, apellido_sol, cedula_pac, apellido_pac, nombre_pac from solicitud
      WHERE activo = 'activo'
      order by id_solici asc LIMIT 50 OFFSET 0;");                           

  }else{
    $consulta = $conexion ->prepare("SELECT id_solici, patologias, requerimientos, cedula_sol, nombre_sol, apellido_sol, cedula_pac, apellido_pac, nombre_pac from solicitud
              WHERE (nombre_sol LIKE '%$DatosPaciente%' or apellido_sol LIKE '%$DatosPaciente%' 
              or nombre_pac LIKE '%$DatosPaciente%'  or apellido_pac LIKE '%$DatosPaciente%'
              or cast (cedula_pac as varchar) LIKE '%$DatosPaciente%' or cast (cedula_sol as varchar) LIKE '%$DatosPaciente%')
              and activo = 'activo'
              order by id_solici asc LIMIT 50 OFFSET 0;");                           

  }

  $consulta -> execute();
  $busqueda = $consulta-> fetchALL();            
        ?>
        <div class="" id="Layer1">          
          <form id="FormBuscarPaciente" name="FormBuscarPaciente" method="post" action="BusquedaDatos.php">
            <div class="w3-responsive w3-row">
              <table class="w3-table w3-content w3-margin-center">
                <tr>
                  <td style="width:85%"><input required = "required" name="DatosPaciente" maxlength="15" id="DatosPaciente" type="text" placeholder="Ingrese Datos a Buscar"  value="<?php echo $DatosPaciente; ?>" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required class="w3-input w3-border w3-hover-gray"></td>
                  <td style="width:15%"><button name="submit" type="submit" class="w3-margin-left w3-btn w3-green" ><b>Buscar</b></button></label></td>                
                </tr>   
              </table>
            </div>
          </form>
        
        <div class="w3-responsive" align="center" id="Layer1">
          <table border="" class="w3-card-4 w3-table-all w3-hoverable"> 
            <tr>
              <td class="w3-teal" style="width:49%"><div class="w3-center"><h3>Datos Personales</h3></div></td> 
              <td class="w3-deep-orange" style="width:30%"><div class="w3-center"><h3>Requiere</h3></div></td>                
              <td class="w3-blue" style="width:21%"><div class="w3-center"><h3>Acciones</h3></div></td>                
            </tr>
          </table>              
        </div>

        <div class="w3-responsive" align="center" id="Layer2" >    
          <table border="" class="w3-card-4 w3-table-all w3-hoverable" >   
            <?php 
            //echo "Datos del Paciente a ser buscados: ".$DatosPaciente;
            foreach($busqueda as $misdatos){ 
              if ($misdatos['nombre_pac'] == 'null'){ 
                  $misdatos['nombre_pac'] = '';    $misdatos['apellido_pac'] = '';   $misdatos['cedula_pac'] = '';
                  $misdatos['telefono_pac'] = ''; 
              }                                                  
              if ($misdatos['cedula_sol'] == 0){$misdatos['cedula_sol']='';} 
              if ($misdatos['cedula_pac'] == 0){$misdatos['cedula_pac']='';}  
              ?>      
              <tr>
                <td style="width:50%" id="idReg" >
                  <strong>N°: </strong><?php echo $misdatos["id_solici"]; ?> 
                  <strong><br>Solicitante: </strong><?php echo $misdatos["cedula_sol"]; ?> 
                  <strong> - </strong><?php echo " ".$misdatos["nombre_sol"]." ".$misdatos["apellido_sol"]; ?><br>
                  <?php 
                  if ($misdatos["nombre_pac"] != ""){ ?>
                      <strong>Paciente: </strong><?php echo $misdatos["cedula_pac"]; ?>
                      <strong> - </strong><?php echo $misdatos["nombre_pac"]." ".$misdatos["apellido_pac"]; }?>

                </td>
                <td style="width:30%">
                    <strong>Patologia: </strong> <?php echo $misdatos["patologias"]; ?><br>
                    <strong>Requerimientos: </strong> <?php echo $misdatos["requerimientos"]; ?>
                </td>                            
                <td style="width:20%" class="w3-center">
                    <a href="ConsultarStatus.php?seleccion=<?php echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-blue w3-small ">Ver <i class="fa fa-caret-right "></i></button></a> 
                    <a href="editarPaciente.php?seleccion=<?php echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-blue w3-small ">Edit Todo <i class="fa fa-caret-right "></i></button></a><h4></h4>
                    <a href="editarDatosPaciente.php?seleccion=<?php echo $misdatos['id_solici']; ?>"><button class="w3-btn w3-indigo w3-small ">Edit Datos <i class="fa fa-caret-right "></i></button></a>                                   
                    <?php                     
                    if($_SESSION['Id_NivUsu'] == 1 || $_SESSION['Id_NivUsu'] == 2 || $_SESSION['Id_NivUsu'] == 5){ ?>
                      <form action="BusquedaDatos.php" method="POST">
                        <input type="hidden" value="<?php echo $misdatos['id_solici'];?>" name="eliminado">                        
                        <input type="hidden" value="<?php echo $DatosPaciente;?>" name="busqueda">                        
                        <button class="w3-btn w3-red w3-small ">Eliminar Reg. <i class="fa fa-caret-right "></i></button> </td>                    
                      </form>
                      <?php 
                    } ?>
              </tr> 
              <?php
            }?>       
          </table> 
        </div>           
</div>
<?php 

if (isset($_POST['eliminado'])){  ?>    
  <div id="mensajeEliminar" class="w3-modal" style="display: block;" >
    <div class="w3-modal-content w3-margin-top w3-card-4 w3-animate-zoom" style="width:40%;">
      <header class="w3-container w3-red"> 
        <!--<span onClick="document.getElementById('id01').style.display='none'" 
        class="w3-button w3-display-topright w3-hover-red"><i class="fa fa-close"></i></span>-->
        <h2><i class="fa fa-solid fa-hand-paper-o w3-center" ></i> Eliminar Registro</h2>      
      </header>
      <div class="w3-container">
        <br>          
        <p id="variable"></p>
        <h5 class="w3-margin-left w3-center"><strong><big> ¿Está seguro de Eliminar el Registro?</big></strong></h5>            
        <form action="BusquedaDatos.php" method="POST">
          <input type="hidden" value="<?php echo $eliminado;?>" name="eliminar">
          <input type="hidden" value="<?php echo $busquedaActual;?>" name="busqueda">
          <input type="hidden" value="1" name = "enviado">
          <br><br>

          <div class="w3-center">                
            <button class="w3-btn w3-red w3-medium ">Eliminar Reg. </button></a>               
          </div>                 
        </form>
        <!-- Se extrae el boton de cancelar para que no se envie el formulario del Modal -->
        <button onClick="document.getElementById('mensajeEliminar').style.display='none'" class="w3-btn w3-green w3-medium w3-margin-left"> Cancelar</button>              

        
        <br><br>
      </div>    
    </div>
  </div>
  <?php
} ?>

<br><br>
<?php require_once('../includes/footer.php'); ?>

<script src="../js/busquedadatos.js" ></script>
</body>
</html>