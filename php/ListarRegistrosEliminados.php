<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link rel="stylesheet" href="../css/ajustartabla.css">   
</head>
<body>
 <!--Incluimos el Header en la Página --> 
<?php require_once('../includes/header.php'); ?>

<!-- !PAGE CONTENT! Establece el ancho del area a trabajar -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">
  <!--HEADER-->
  <!--Para mostrar el Titulo de la Página // Una especie de menu no navegable --> 
  <div id="myTop" class="w3-container w3-top w3-large " style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Status Eliminados</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Status Eliminados</h1></b>
  </header>

  <br>
  <?php
  include '../Connections/conexion.php';
  $nivelUsuario = $_SESSION['Id_NivUsu']; //Obtenemos el nivel del usuario
  //EL metodo GET solo se utiliza en caso de hacer click en una de las acciones Eliminar y Restaurar
  if ($_GET){    //Inicio a trabajar en caso de realizar alguna accion
    if (isset ($_GET['remove'])){  //Verificamos si el dato enviado se realizo mediante la variable remove para eliminar definitivamente el Registro
        $remove = $_GET['remove'];
        $datos = explode(",", $remove);
        $remove = $datos[0];
        $_POST['DatosPaciente'] = $dato  = $datos[1];      
        $deleteSql = $conexion -> prepare("DELETE FROM solicitud WHERE id_solici = '$remove';");
        
        if(!$deleteSql -> execute()){
          //En caso de que la execucion tenga algun error emitimos un mensaje
          echo "Error al Eliminar Registro<br>Consulte con el Departamento de O.T.I.C. Area de Desarrollo Web";
        }else{  ?>
            <!-- En caso de que la execucion se realizo de forma correcta mostramos el siguiente mensaje -->
            <div style="width:50%;" class="w3-content w3-margin-center">
              <div>
                <div id="primero" style="display: none; color : white;" class="w3-teal"> <center>Regitro eliminado con Exito</center> 
                <div id="segundo" style="display: none;"></div>
                </div>                    
              </div>    
            </div>      
          <?php
        }
    }else if (isset ($_GET['update'])){ //Verificamos si el dato enviado se realizo mediante la variable update para actualizar los registros
            $update = $_GET['update'];       
            $datos = explode(",",$update);
            $update = $datos['0'];
            $_POST['DatosPaciente'] = $dato = $datos['1'];          
            $updateSql = $conexion -> prepare("UPDATE solicitud SET activo = 'activo' where id_solici = '$update';");            
            if(!$updateSql -> execute()){
              //En caso de que la execucion tenga algun error emitimos un mensaje
              echo "Error al Restaurar Registro<br>Consulte con el Departamento de O.T.I.C. Area de Desarrollo Web";
            }else{  ?>
              <!-- En caso de que la execucion se realizo de forma correcta mostramos el siguiente mensaje -->
              <div style="width:50%;" class="w3-content w3-margin-center">
                <div>
                  <div id="primero" style="display: none; color : white;" class="w3-teal"> <center>Regitro Restaurado con Exito</center> 
                  <div id="segundo" style="display: none;"></div>
                  </div>                    
                </div>    
              </div>      
              <?php
            }
    }            
  }
  //Condicionamos para saber si se envio datos al momento de ejecutar la busqueda
  if (!isset($_POST['DatosPaciente'])){
      //Si los datos a buscar estan en blanco se procede a mostrar todos los registros existentes
      $consulta = $conexion ->prepare("SELECT nombre_sol, apellido_sol, cedula_sol, patologias, requerimientos, cedula_pac, nombre_pac, apellido_pac, id_solici, eliminadopor
                                    from solicitud 
                                    WHERE activo = 'inactivo'
                                    order by id_solici asc LIMIT 50 OFFSET 0;");  
      //Consulta para extraer el numero de Registro de la consulta realizada...
      $consultaRow = $conexion ->prepare("SELECT count(id_solici)
                                      from solicitud 
                                      WHERE activo = 'inactivo';");
      
      //Asignamos a la variable el dato enviado a buscar para reasignarlo al imput de busqueda
      $DatosPaciente = ""; $_POST['DatosPaciente']="";
}else{
    $DatosPaciente = $_POST['DatosPaciente'];
    $consulta = $conexion ->prepare("SELECT nombre_sol, apellido_sol, cedula_sol, patologias, requerimientos, cedula_pac, nombre_pac, apellido_pac, id_solici, eliminadopor
                                    from solicitud 
                                    WHERE (nombre_sol LIKE '%$DatosPaciente%'   or apellido_sol LIKE '%$DatosPaciente%' 
                                    or nombre_pac LIKE '%$DatosPaciente%'   or apellido_pac LIKE '%$DatosPaciente%' 
                                    OR cast (cedula_sol as varchar) LIKE '%$DatosPaciente%' or cast (cedula_pac as varchar) LIKE '%$DatosPaciente%')
                                    and activo = 'inactivo'
                                    order by id_solici asc LIMIT 50 OFFSET 0;");    
    
    //Consulta para extraer el numero de Registro de la consulta realizada...
    $consultaRow = $conexion ->prepare("SELECT count(id_solici)
                                        from solicitud 
                                        WHERE (nombre_sol LIKE '%$DatosPaciente%'   or apellido_sol LIKE '%$DatosPaciente%' 
                                    or nombre_pac LIKE '%$DatosPaciente%'   or apellido_pac LIKE '%$DatosPaciente%' 
                                    OR cast (cedula_sol as varchar) LIKE '%$DatosPaciente%' or cast (cedula_pac as varchar) LIKE '%$DatosPaciente%')
                                    and activo = 'inactivo';");  
//Asignamos a la variable el dato enviado a buscar para reasignarlo al imput de busqueda
} ?>
<?php
$consultaRow ->execute();
$datos = $consultaRow -> fetchAll();
foreach($datos as $row){
  $totalRegistros =  $row[0];  
}


?>

<div class="" id="Layer1">          
  <form id="FormBuscarPaciente" name="FormBuscarPaciente" method="post" action="ListarRegistrosEliminados.php">
    <div class="w3-responsive w3-row">
      <table class="w3-table w3-content w3-margin-center">
        <tr>
          <td style="width:85%"><input required = "required" name="DatosPaciente" maxlength="15" id="DatosPaciente" type="text" placeholder="Ingrese Datos del Status Eliminado a Buscar"  value="<?php echo $DatosPaciente; ?>" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required class="w3-input w3-border w3-hover-gray"></td>
          <td style="width:15%"><button name="submit" type="submit" class="w3-margin-left w3-btn w3-green" ><b>Buscar</b></button></label></td>                
        </tr>                
        <tr>
            <td><h4> <center> La cantidad de Registros es: <?php echo $totalRegistros; ?></center></h4></td>
        </tr>   
      </table>
    </div>
  </form>  
</div>

      
<div class="w3-responsive" align="center" id="Layer1">
  <table border="" class="w3-card-4 w3-table-all w3-hoverable"> 
    <tr>
        <td class="w3-teal" colspan="11" style="width: 50%;"><div class="w3-center"><h3>Solicitud en Proceso de Eliminación</h3></div></td>                     
    </tr>              
    <tr>
      <td style="width: 35%;" class="w3-center w3-gray"><b>Datos del Solicitante</b></td>
      <td style="width: 30%;" class="w3-center w3-gray"><b>Informacion Requerida</td>
      <td style="width: 25%;" class="w3-center w3-gray"><b>Eliminado Por:</b></td>
      <td style="width: 10%;" class="w3-center w3-gray"><b>Acciones</b></td>
    </tr>  
  </table>
    
<div class="w3-responsive" align="center" id="Layer2">
  <table border="" class="w3-card-4 w3-table-all w3-hoverable"> 
    <?php
      
      $consulta -> execute(); // ejecutamos la consulta condicionada realizada anteriormente
      $busqueda = $consulta-> fetchALL();  //extraemos la informacion y se la asigamos a la variable

      foreach($busqueda as $misdatos){ // Recorremos cada uno de los datos extraidos
        if ($misdatos['nombre_pac'] == 'null'){ //Condición en caso de no haber datos del Paciente
            //Asignamos un dato en blanco a cada uno de los datos del Paciente por no haber registros de ellos
            $misdatos['nombre_pac'] = '';    $misdatos['apellido_pac'] = '';   $misdatos['cedula_pac'] = '';
            $misdatos['telefono_pac'] = ''; 
        }                                                  
        //Condicionamos la cedula del Paciente y del Solicitante en caso de que sea "0" se le asigna un dato en blanco
        if ($misdatos['cedula_sol'] == 0){$misdatos['cedula_sol']='';} 
        if ($misdatos['cedula_pac'] == 0){$misdatos['cedula_pac']='';}  ?>              
      <!-- Procedemos a mostrar cada uno de los Registros Extraidos en las celdas de las tablas correspondientes  -->
        <tr>
          <td style="width: 36%;" id="idReg" >
            <strong>N°: </strong><?php echo $misdatos["id_solici"]; ?> 
            <strong><br>Solicitante: </strong><?php echo $misdatos["cedula_sol"]; ?> 
            <strong> - </strong><?php echo " ".$misdatos["nombre_sol"]." ".$misdatos["apellido_sol"]; ?><br>
            <?php 
              
            if ($misdatos["nombre_pac"] != ""){ ?>
              <strong>Paciente: </strong><?php echo $misdatos["cedula_pac"]; ?>
              <strong> - </strong><?php echo $misdatos["nombre_pac"]." ".$misdatos["apellido_pac"]; 
            } ?> 
          </td>
          <td style="width: 30%;">
            <strong>Patologia: </strong> <?php echo $misdatos["patologias"]; ?><br>
            <strong>Requerimientos: </strong> <?php echo $misdatos["requerimientos"]; ?>
          </td>                                                             
          <td style="width: 25%;">
              <strong>Nombre: </strong> <?php echo $misdatos["eliminadopor"]; ?><br>
          </td>                 
          <td style="width: 10%;"  class="w3-center">
            <a href="ListarRegistrosEliminados.php?remove=<?php echo $misdatos['id_solici'].",".$_POST['DatosPaciente']; ?>"><button class="w3-btn w3-blue w3-small ">Eliminar <i class="fa fa-caret-right "></i></button></a> <h6></h6>
            <a href="ListarRegistrosEliminados.php?update=<?php echo $misdatos['id_solici'].",".$_POST['DatosPaciente']; ?>"><button class="w3-btn w3-blue w3-small ">Restaurar <i class="fa fa-caret-right "></i></button></a><h4></h4>                                  
          </td>                    
        </tr> 
        <?php
          }?>       
        </table> 
      </div>             
    </div>    
    <br><br>
<?php require_once('../includes/footer.php'); ?>

</div>

<script src="../js/busquedadatos.js" ></script>
<script src="../js/busquedadatos.js" ></script>
</body>
</html>