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
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Status Eliminados</span></h4>
  </div>
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Status Eliminados</h1></b>
  </header>
  <br>
  <?php
  include '../Connections/conexion.php';
  $nivelUsuario = $_SESSION['Id_NivUsu'];
  if ($_GET){    
    if (isset ($_GET['remove'])){      
      $remove = $_GET['remove'];
      $datos = explode(",", $remove);
      $remove = $datos[0];
      $_POST['DatosPaciente'] = $dato  = $datos[1];      
      $deleteSql = $conexion -> prepare("DELETE FROM STATUS WHERE id_status = '$remove';");
      if(!$deleteSql -> execute()){
        echo "Error al Eliminar Status<br>Consulte con el Departamento de O.T.I.C. Area de Desarrollo Web";
      }
    }else if (isset ($_GET['update'])){
          $update = $_GET['update'];       
          $datos = explode(",",$update);
          $update = $datos['0'];
          $_POST['DatosPaciente'] = $dato = $datos['1'];
          $updateSql = $conexion -> prepare("UPDATE status SET activa = 'SI' where id_status = '$update';");            
          
          if(!$updateSql -> execute()){
            echo "<center>";
            echo "Error al Eliminar Status<br>Consulte con el Departamento de O.T.I.C. <br>Area de Desarrollo<br>";
            print_r($updateSql->errorInfo());            
            echo "</center>";
          }
    }            
  }

    
  if (!isset($_POST['DatosPaciente'])){
    $consulta = $conexion ->prepare("SELECT nombre_sol, apellido_sol, cedula_sol, patologias, requerimientos, cedula_pac, nombre_pac, apellido_pac, id_status, id_defsta1, id_solici, observaciones_status, fecha_status, nombre_redsal, nombre_defsta, nombre_login, asignado, nombre_redsal, id_redsal2, requerimientosaprobados, id_status
                                  from status
                                  inner Join solicitud on id_solici = id_solici1
                                  inner JOIN definicion_status on id_defsta = id_defsta1
                                  inner join redsalud on id_redsal = id_redsal2 
                                  WHERE activa = 'NO'
                                  order by id_solici asc LIMIT 50 OFFSET 0;");  
    $DatosPaciente = "";$_POST['DatosPaciente']="";
  }else{
    $DatosPaciente = $_POST['DatosPaciente'];
    $consulta = $conexion ->prepare("SELECT nombre_sol, apellido_sol, cedula_sol, patologias, requerimientos, cedula_pac, nombre_pac, apellido_pac, id_status, id_defsta1, id_solici, observaciones_status, fecha_status, nombre_redsal, nombre_defsta, nombre_login, asignado, nombre_redsal, id_redsal2, requerimientosaprobados, id_status
                                    from status
                                    inner Join solicitud on id_solici = id_solici1
                                    inner JOIN definicion_status on id_defsta = id_defsta1
                                    inner join redsalud on id_redsal = id_redsal2 
                                    WHERE (nombre_sol LIKE '%$DatosPaciente%'   or apellido_sol LIKE '%$DatosPaciente%' or nombre_pac LIKE '%$DatosPaciente%'   or apellido_pac LIKE '%$DatosPaciente%' OR cast (cedula_sol as varchar) LIKE '%$DatosPaciente%' or cast (cedula_pac as varchar) LIKE '%$DatosPaciente%') and activo = 'activo' and activa = 'NO'
                                    order by id_solici asc LIMIT 50 OFFSET 0;");        
  } ?>

  <div class="" id="Layer1">          
    <form id="FormBuscarPaciente" name="FormBuscarPaciente" method="post" action="ListarStatusEliminados.php">
      <div class="w3-responsive w3-row">
        <table class="w3-table w3-content w3-margin-center">
          <tr>
            <td style="width:85%"><input required = "required" name="DatosPaciente" maxlength="15" id="DatosPaciente" type="text" placeholder="Ingrese Datos del Status Eliminado a Buscar"  value="<?php echo $DatosPaciente; ?>" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" required class="w3-input w3-border w3-hover-gray"></td>
            <td style="width:15%"><button name="submit" type="submit" class="w3-margin-left w3-btn w3-green" ><b>Buscar</b></button></label></td>                
          </tr>                   
        </table>
      </div>
    </form>
  </div>

  <div class="w3-responsive" align="center" id="Layer2">
    <table border="" class="w3-card-4 w3-table-all w3-hoverable" style="width:98%"> 
      <tr>
          <td class="w3-teal" colspan="11" style="width: 50%;"><div class="w3-center"><h3>Datos de la Solicitud</h3></div></td>                     
      </tr>      
      <tr>
        <td colspan="5" class="w3-center w3-gray"><b>Datos del Solicitante</b></td>          
        <td colspan="5" class="w3-center w3-gray"><b>Status Eliminado</b></td>          
        <td colspan="1" class="w3-center w3-gray"><b>Accion</b></td>                   
      </tr>  
      <?php 
        
      $consulta -> execute();
      $busqueda = $consulta-> fetchALL();            

      foreach($busqueda as $misdatos){ 
        if ($misdatos['nombre_pac'] == 'null'){ 
          $misdatos['nombre_pac'] = '';    $misdatos['apellido_pac'] = '';   $misdatos['cedula_pac'] = '';
          $misdatos['telefono_pac'] = ''; 
        }                                                  
        if ($misdatos['cedula_sol'] == 0){$misdatos['cedula_sol']='';} 
        if ($misdatos['cedula_pac'] == 0){$misdatos['cedula_pac']='';}  ?>      
        <tr>
          <td colspan="5" class="w3-margin-left"> <?php echo "<strong>N° </strong>".$misdatos["id_solici"]." <br><strong>Cédula:</strong> ".$misdatos["cedula_sol"]." <strong> Nombre y Apellido: </strong> ".$misdatos["nombre_sol"]." ".$misdatos["apellido_sol"]."<br>"; echo "<strong>Patologias:</strong> ".$misdatos["patologias"]." <strong>Requerimientos:</strong> ".$misdatos["requerimientos"]; ?></td>                    
          <td colspan="5" class="w3-margin-left"> <?php echo "<strong>Observaciones: </strong>".$misdatos["observaciones_status"]." <strong>Fecha Status: </strong> ".$misdatos["fecha_status"]." <strong>Status: </strong>".$misdatos["nombre_defsta"] ." <strong>Por: </strong> ".$misdatos["nombre_login"]."<strong> Dpto Asignado: </strong> ".$misdatos["asignado"]."<strong> Centro de Salud: </strong>".$misdatos["nombre_redsal"]." <strong>Requerimiento Aprobado: </strong> ".$misdatos["requerimientosaprobados"]; ?> </td>                                              
          <td colspan="1"  class="w3-center">
              <a href="ListarStatusEliminados.php?remove=<?php echo $misdatos['id_status'].",".$_POST['DatosPaciente']; ?>"><button class="w3-btn w3-blue w3-small ">Eliminar <i class="fa fa-caret-right "></i></button></a> <h6></h6>
              <a href="ListarStatusEliminados.php?update=<?php echo $misdatos['id_status'].",".$_POST['DatosPaciente']; ?>"><button class="w3-btn w3-blue w3-small ">Restaurar <i class="fa fa-caret-right "></i></button></a><h4></h4>                                  
          </td>                    
        </tr> 
        <?php
      }?>       
    </table> 
  </div>       

  <!-- FIN DEL IF CONDICIONAL DE LA VALIDACION DE QUE LOS CAMPOS SE HALLAN ENVIADOS -->

  </div>
  <br><br>
  <?php require_once('../includes/footer.php'); ?>
</div>

<script src="../js/scroll.js" ></script>
</body>
</html>