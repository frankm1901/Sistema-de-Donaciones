<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
</head>
<body>
<?php require_once('../Connections/conexion.php'); ?>
<!-- !PAGE CONTENT! -->
<div class="w3-main">
<div>
<?php 

//********************Inicio para el Reporte de Cantidad de Solicitudes Ingresadas**********************************
// Recibimos las variables mediante el methodo POST y es asignada a una variable
$FechaInicio = $_POST['RequerFechaInicio'];
$FechaFinal = $_POST['RequerFechaFinal'];
isset($_POST['requerimientos']) ? $requerimientos = $_POST['requerimientos'] : $requerimientos = null;
isset($_POST['detalle']) 	? $detalle = $_POST['detalle']	: header("Location: Reportes.php"); 

$departamento = $_POST['departamento'];
$_POST['detalle'];

if($detalle == 12){
  if (!isset($_POST['patologias'])){      
    $mensaje = 'Casos No Resueltos por Patologias';
    $todos = true;
  }else{
    $mensaje = 'Casos No Resueltos porPatologias (Segun Seleccion)';
    $patologias = $_POST['patologias'];  
    $todos= false;
  }
}
?>
</div>
  <div class=" w3-container w3-responsive w3-center" id="Layer3">
    <br>
    <center> <img class=" w3-image" src="../assets/img/membreteReportes.png" alt="" ></center>
       
    <?php
    switch ($detalle) {  
      case 1:?>  
        <strong class="w3-center" ><big>Reporte por Centros de Salud Detallados</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border  w3-card-4">
          <tr class="w3-teal">                                  
            <td colspan="2" style="width: 90%;" class="w3-teal">Centro Asistencial</td>
            <td style="width: 10%;" class="w3-teal">Cantidad</td>          
          </tr>              
            <?php           
            $verCentroSaludSql = $conexion ->prepare("SELECT count(nombre_redsal) as cantidad, nombre_redsal 
                                                      FROM status      
                                                      INNER JOIN solicitud ON id_solici = id_solici1                                                      
                                                      INNER JOIN redsalud ON id_redsal = id_redsal2
                                                      WHERE (id_redsal2 != 333 and id_defsta1 = 9 AND activo = 'activo') and asignado = '$departamento'
                                                      GROUP BY nombre_redsal
                                                      ORDER BY nombre_redsal asc;");            
              echo "<br>: Dpro ".$departamento;
            if ($departamento == 'TODOS'){  
              $verCentroSaludSql = $conexion ->prepare("SELECT count(nombre_redsal) as cantidad, nombre_redsal 
                                                      FROM status      
                                                      INNER JOIN solicitud ON id_solici = id_solici1                                                      
                                                      INNER JOIN redsalud ON id_redsal = id_redsal2
                                                      WHERE (id_redsal2 != 333 and id_defsta1 = 9 AND activo = 'activo')
                                                      GROUP BY nombre_redsal
                                                      ORDER BY nombre_redsal asc;");
            }            
            $verCentroSaludSql -> execute();
            $verCentroSalud = $verCentroSaludSql -> fetchAll();                                              
            $total = 0;
            $centroDeSalud;                                                     
                    
            foreach ($verCentroSalud as $verCent){                    
              $centroDeSalud = $verCent['nombre_redsal']
                ?>
                <tr>
                  <td colspan="3";> <strong><?php echo $centroDeSalud; ?></strong></td>
                </tr>
                  <?php                             
                  if ($departamento == 'TODOS'){          
                  $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, requerimientosaprobados, nombre_redsal 
                                                            FROM status
                                                            INNER JOIN solicitud ON id_solici = id_solici1
                                                            INNER JOIN redsalud ON id_redsal = id_redsal2
                                                            WHERE (id_redsal2 != 333 and id_defsta1 = 9 and nombre_redsal = '$centroDeSalud' and activo = 'activo')
                                                            GROUP BY nombre_redsal, requerimientosaprobados
                                                            ORDER BY cantidad desc, requerimientosaprobados asc;");
                  }else{
                    $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, requerimientosaprobados, nombre_redsal 
                                                            FROM status
                                                            INNER JOIN solicitud ON id_solici = id_solici1
                                                            INNER JOIN redsalud ON id_redsal = id_redsal2
                                                            WHERE (id_redsal2 != 333 and id_defsta1 = 9 and nombre_redsal = '$centroDeSalud' and activo = 'activo') and asignado = '$departamento'
                                                            GROUP BY nombre_redsal, requerimientosaprobados
                                                            ORDER BY cantidad desc, requerimientosaprobados asc;");
                  }                                             
                  $ConsultaSolicitud -> execute();
                  $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();                          
                  $centroDeSalud;     

                  foreach ($ConsulSolicitud as $ConSol)
                    { $t = 0; 
                      $total+= $ConSol["cantidad"];                              
                      $t = $total?>
                      <tr>                              
                        <td colspan="2";><?php echo " - ".$ConSol["requerimientosaprobados"]; ?></td>
                        <td class="w3-center"><?php echo $ConSol["cantidad"]; ?> </td>    
                      </tr>    <?php  
                    }                                                          
            }?>

            <tr>
              <td colspan="4" style="text-align: right;" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
            </tr>        
        </table>
        <br><br>
        <?php
      break;      
      case 2: ?>    
        <strong class="w3-center" ><big>Reporte Analitica por Centros de Salud con Requerimientos</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border  w3-card-4">
          <?php            
          if ($departamento == 'TODOS'){  
            $verCentroSaludSql = $conexion ->prepare("SELECT count(nombre_redsal) as cantidad, nombre_redsal 
                                                    FROM status    
                                                    INNER JOIN solicitud ON id_solici = id_solici1                                                              
                                                    INNER JOIN redsalud ON id_redsal = id_redsal2
                                                    WHERE (id_redsal2 != 333 and id_defsta1 = 9) and activo = 'activo'
                                                    GROUP BY nombre_redsal
                                                    ORDER BY nombre_redsal asc;");

          }else{
            $verCentroSaludSql = $conexion ->prepare("SELECT count(nombre_redsal) as cantidad, nombre_redsal 
                                                      FROM status    
                                                      INNER JOIN solicitud ON id_solici = id_solici1                                                              
                                                      INNER JOIN redsalud ON id_redsal = id_redsal2
                                                      WHERE (id_redsal2 != 333 and id_defsta1 = 9 AND asignado = '$departamento') and activo = 'activo'
                                                      GROUP BY nombre_redsal
                                                      ORDER BY nombre_redsal asc;");
          }                                            
          $verCentroSaludSql -> execute();
          $verCentroSalud = $verCentroSaludSql -> fetchAll();                                              
          $total = 0;
          $centroDeSalud;             

          foreach ($verCentroSalud as $verCent){
            $centroDeSalud = $verCent['nombre_redsal']
            ?>
            <tr>
              <td colspan="4" class="w3-teal"> <strong><?php echo $centroDeSalud; ?></strong></td>
            </tr>
            <tr>
              <td colspan="1" style="width: 50%;" ><strong> Datos del Solicitante </strong></td>
              <td colspan="1" style="width: 20%;" ><strong> Patologias </strong></td>
              <td colspan="1" style="width: 20%;" ><strong>Requerimientos</strong></td>
              <td colspan="1" style="width: 10%;" ><strong>Fecha</strong></td>
            </tr>
            <?php                               
            if ($departamento == 'TODOS'){                
              $ConsultaSolicitud = $conexion ->prepare("SELECT fecha_status, id_solici, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal 
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE (id_defsta1 = 9 and nombre_redsal = '$centroDeSalud') and activo = 'activo'
                                                        GROUP BY id_solici, fecha_status, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal
                                                        ORDER BY cedula_sol asc;");
            }else{
              $ConsultaSolicitud = $conexion ->prepare("SELECT fecha_status, id_solici, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal 
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE (id_defsta1 = 9 and nombre_redsal = '$centroDeSalud' and asignado = '$departamento') and activo = 'activo'
                                                        GROUP BY id_solici, fecha_status, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal
                                                        ORDER BY cedula_sol asc;");
            }
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();                                              
            $centroDeSalud;                                 
            
            foreach ($ConsulSolicitud as $ConSol){  
              $total+= 1;  ?>
              <tr>                              
                <td style="width: 50%;">  <?php echo "<strong> Cedula Sol: </strong>".$ConSol["cedula_sol"]; ?> 
                                          <?php echo "<strong>  Nombre y Apellido: </strong>".$ConSol["nombre_sol"]. " ".$ConSol["apellido_sol"]."<br>"; 

                                          if ($ConSol["nombre_pac"]!= "") {?>
                                              <?php 
                                              echo "<strong>Cedula Pac: </strong>".$ConSol["cedula_pac"]; 
                                              echo "<strong>Nombre y Apellido: </strong>".$ConSol["nombre_pac"]." ".$ConSol["apellido_pac"]; }?></td>
                <td style="width: 20%;"><?php echo $ConSol["patologias"]; ?></td>                              
                <td style="width: 20%;"><?php echo $ConSol["requerimientosaprobados"]; ?></td>
                <td style="width: 10%;"><?php echo $ConSol["fecha_status"]; ?></td>                                                               
              </tr>    <?php  
            } 
          } ?>

          <tr>
            <td colspan="3" ></td>
            <td colspan="3" ></td>
          </tr>
          <tr>
            <td colspan="3" style="text-align: right;" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
          </tr>        
        </table>
      <br><br>
      <?php
      break;    
      case 3:?>    
        <strong class="w3-center" ><big>Casos resueltos por Patologias</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border w3-card-4">
          <tr class="w3-teal">                  
            <td width="85%" class="w3-teal">Patologias</td>                          
            <td width="15%" class="w3-teal w3-center">Cantidad</td>          
          </tr>    
            <?php 
            if ($departamento == 'TODOS'){     
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(patologias) AS CANTIDAD, patologias
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE  id_defsta1 = 9 and activo = 'activo'
                                                        GROUP BY patologias
                                                        ORDER BY patologias ASC, CANTIDAD DESC;");
            }else{
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(patologias) AS CANTIDAD, patologias
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE  id_defsta1 = 9 and asignado = '$departamento' and activo = 'activo'
                                                        GROUP BY patologias
                                                        ORDER BY patologias ASC, CANTIDAD DESC;");
            }                                                        
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();                    
            $total = 0;
            
            foreach ($ConsulSolicitud as $ConSol){ 
              $total+= $ConSol["cantidad"];  ?>
              <tr>    
                <td><?php echo $ConSol["patologias"]; ?></td>                
                <td class="w3-center"><?php echo $ConSol["cantidad"]; ?></td>              
              </tr>
                <?php  
            } ?>
            <tr>
              <td colspan="2" class="w3-align-right " ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
            </tr>        
        </table>
        <br><br>
          <?php
      break;
      case 4:  ?>    
        <strong class="w3-center" ><big>REPORTE OPERADOS POR CENTROS DE SALUD</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border w3-card-4">
          <tr class="w3-teal">                  
            <td width="35%" class="w3-teal w3-center ">Centro de Salud</td>     
            <td width="5%" class="w3-teal w3-center">Cantidad</td>        
          </tr>    
            <?php  
            if ($departamento == 'TODOS'){  
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, nombre_redsal
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE (id_redsal2 != 333 AND requerimientosaprobados LIKE '%OPERACIÓN%') and activo = 'activo'
                                                        GROUP BY nombre_redsal
                                                        ORDER BY nombre_redsal asc;");
            }else{
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, nombre_redsal
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE (id_redsal2 != 333 AND requerimientosaprobados LIKE '%OPERACIÓN%' AND asignado = '$departamento') and activo = 'activo'
                                                        GROUP BY nombre_redsal
                                                        ORDER BY nombre_redsal asc;");
            }
            
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();  
            $total = 0;
            
            foreach ($ConsulSolicitud as $ConSol){   
              $cantidad = $ConSol['cantidad'];
              $nombre_redsal = $ConSol['nombre_redsal'];      
              $total += $cantidad;
              ?>
              <tr>                                  
                <td><?php echo $nombre_redsal; ?></td>   
                <td class="w3-center"><?php echo $cantidad; ?></td>
              </tr>    
                <?php 
            } ?>                            
                  
            <tr>
              <td colspan="4" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
            </tr>        
        </table>
        <br><br>
      <?php
      break;
      case 5:  ?>    
        <strong class="w3-center" ><big>REPORTE POR CENTROS DE SALUD <br>(Casos Atendidos)</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border w3-card-4">
          <tr class="w3-teal">                              
            <td width="35%" class="w3-teal">Centro de Salud</td>   
            <td width="5%" class="w3-teal">Cantidad</td>                    
          </tr>    
            <?php            
            if ($departamento == 'TODOS'){  
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, nombre_redsal 
                                                        FROM status
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        INNER JOIN solicitud on id_solici = id_solici1
                                                        WHERE (id_redsal2 != 333 and id_defsta1 = 9) and activo = 'activo'
                                                        GROUP BY nombre_redsal
                                                        ORDER BY nombre_redsal ASC;");
            }else{
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, nombre_redsal 
                                                        FROM status
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        INNER JOIN solicitud on id_solici = id_solici1
                                                        WHERE (id_redsal2 != 333 and id_defsta1 = 9 and asignado = '$departamento') and activo = 'activo'
                                                        GROUP BY nombre_redsal
                                                        ORDER BY nombre_redsal ASC;");
            }  
            
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();  
            $total = 0;
            
            foreach ($ConsulSolicitud as $ConSol){   
              $cantidad = $ConSol['cantidad'];                                                   
              $nombre_redsal = $ConSol['nombre_redsal'];      
              $total += $cantidad;  
              ?>
              <tr>                                
                <td><?php echo $nombre_redsal; ?></td>   
                <td class="w3-center" ><?php echo $cantidad; ?></td>         
              </tr>    
                  <?php 
            } ?>
            
            <tr>
              <td colspan="4" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
            </tr>        
        </table>    
        <br><br>
        <?php
      break;
      case 6:?>  
        <strong class="w3-center" ><big>Reporte Analitica por Centros de Salud con Requerimientos</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border  w3-card-4">
          <?php            
          $centroDeSalud = $_POST['centroDeSalud'];
          if ($departamento == 'TODOS'){  
            $verCentroSaludSql = $conexion ->prepare("SELECT count(nombre_redsal) as cantidad, nombre_redsal 
                                                    FROM status    
                                                    INNER JOIN solicitud ON id_solici = id_solici1                                                              
                                                    INNER JOIN redsalud ON id_redsal = id_redsal2
                                                    WHERE (id_redsal2 != 333 and id_defsta1 = 9 and nombre_redsal = '$centroDeSalud') and activo = 'activo'
                                                    GROUP BY nombre_redsal
                                                    ORDER BY nombre_redsal asc;");

          }else{
            $verCentroSaludSql = $conexion ->prepare("SELECT count(nombre_redsal) as cantidad, nombre_redsal 
                                                      FROM status    
                                                      INNER JOIN solicitud ON id_solici = id_solici1                                                              
                                                      INNER JOIN redsalud ON id_redsal = id_redsal2
                                                      WHERE (id_redsal2 != 333 and id_defsta1 = 9 AND asignado = '$departamento' and nombre_redsal = '$centroDeSalud') and activo = 'activo'
                                                      GROUP BY nombre_redsal
                                                      ORDER BY nombre_redsal asc;");
          }                                            
          $verCentroSaludSql -> execute();
          $verCentroSalud = $verCentroSaludSql -> fetchAll();                                              
          $total = 0;
          $centroDeSalud;             

          foreach ($verCentroSalud as $verCent){
            $centroDeSalud = $verCent['nombre_redsal']
            ?>
            <tr>
              <td colspan="4" class="w3-teal"> <strong><?php echo $centroDeSalud; ?></strong></td>
            </tr>
            <tr>
              <td colspan="1" style="width: 50%;" ><strong> Datos del Solicitante </strong></td>
              <td colspan="1" style="width: 20%;" ><strong> Patologias </strong></td>
              <td colspan="1" style="width: 20%;" ><strong>Requerimientos</strong></td>
              <td colspan="1" style="width: 10%;" ><strong>Fecha</strong></td>
            </tr>
            <?php                               
            if ($departamento == 'TODOS'){                
              $ConsultaSolicitud = $conexion ->prepare("SELECT fecha_status, id_solici, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal 
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE (id_defsta1 = 9 and nombre_redsal = '$centroDeSalud') and activo = 'activo'
                                                        GROUP BY id_solici, fecha_status, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal
                                                        ORDER BY cedula_sol asc;");
            }else{
              $ConsultaSolicitud = $conexion ->prepare("SELECT fecha_status, id_solici, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal 
                                                        FROM status
                                                        INNER JOIN solicitud ON id_solici = id_solici1
                                                        INNER JOIN redsalud ON id_redsal = id_redsal2
                                                        WHERE (id_defsta1 = 9 and nombre_redsal = '$centroDeSalud' and asignado = '$departamento') and activo = 'activo'
                                                        GROUP BY id_solici, fecha_status, cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientosaprobados, nombre_redsal
                                                        ORDER BY cedula_sol asc;");
            }
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();                                              
            $centroDeSalud;                                 
            
            foreach ($ConsulSolicitud as $ConSol){  
              $total+= 1;  ?>
              <tr>                              
                <td style="width: 50%;">  <?php echo "<strong> Cedula Sol: </strong>".$ConSol["cedula_sol"]; ?> 
                                          <?php echo "<strong>  Nombre y Apellido: </strong>".$ConSol["nombre_sol"]. " ".$ConSol["apellido_sol"]."<br>"; 

                                          if ($ConSol["nombre_pac"]!= "") {?>
                                              <?php 
                                              echo "<strong>Cedula Pac: </strong>".$ConSol["cedula_pac"]; 
                                              echo "<strong>Nombre y Apellido: </strong>".$ConSol["nombre_pac"]." ".$ConSol["apellido_pac"]; }?></td>
                <td style="width: 20%;"><?php echo $ConSol["patologias"]; ?></td>                              
                <td style="width: 20%;"><?php echo $ConSol["requerimientosaprobados"]; ?></td>
                <td style="width: 10%;"><?php echo $ConSol["fecha_status"]; ?></td>                                                               
              </tr>    <?php  
            } 
          } ?>

          <tr>
            <td colspan="3" ></td>
            <td colspan="3" ></td>
          </tr>
          <tr>
            <td colspan="3" style="text-align: right;" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
          </tr>        
        </table>
      <br><br>
      <?php
      break;    
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
        ///////***************************************************************** */
      case 11:               
        ?>    
        <strong class="w3-center" ><big>Reporte de Requerimientos (Pendientes)</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1"  class="w3-table-all w3-hoverable w3-border  w3-card-4">
          <tr class="w3-teal">                  
            <td width="30%" class="w3-teal">Patologias</td>  
            <td width="5%" class="w3-teal">Cant.</td>        
          </tr>    
            <?php 
            
            if ($departamento == 'TODOS'){   
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(requerimientos) AS cantidad, requerimientos 
                                                        from solicitud 
                                                        INNER JOIN status ON id_solici1 = id_solici
                                                        where id_redsal1 = 333 and activo = 'activo'
                                                        group by requerimientos
                                                        order by requerimientos asc;");
            }else{
              $ConsultaSolicitud = $conexion ->prepare("SELECT COUNT(requerimientos) AS cantidad, requerimientos 
                                                        from solicitud 
                                                        INNER JOIN status ON id_solici1 = id_solici
                                                        where activo = 'activo' AND (id_redsal1 = 333 AND asignado = '$departamento') 
                                                        group by requerimientos
                                                        order by requerimientos asc;");
            }
            
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();  
            $total = 0;

            foreach ($ConsulSolicitud as $ConSol){ 
              $cantidad = $ConSol['cantidad'];
              $requerimientos = $ConSol['requerimientos'];
              $total += $cantidad;?>
                    
              <tr>    
                <td><?php echo $requerimientos; ?></td>     
                <td class="w3-center"><?php echo $cantidad; ?></td>
              </tr> <?php 
            } ?>
            <tr>
              <td colspan="4" ><strong ><h4>Total Casos por Atender: <?php echo " ". $total;?></h4> </strong></td>
            </tr>        
        </table> 
        <br><br>
        <?php
      break;
      case 12:?>    
        <strong class="w3-center" ><big><?php echo $mensaje; ?></big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border w3-card-4">
          <tr class="w3-teal">                  
            <td width="85%" class="w3-teal">Patologias</td>        
            <td width="15%" class="w3-teal w3-center">Cantidad</td>          
          </tr>    
            <?php                        
            if ($todos){ 
              $ConsultaSolicitud = $conexion ->prepare("SELECT count(patologias) as cantidad, patologias from solicitud 
                                                        where id_redsal1 = 333 AND activo = 'activo' 
                                                        group by patologias
                                                        order by patologias ASC;");
              $ConsultaSolicitud -> execute();
              $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();      
              $cant = 0;
              foreach ($ConsulSolicitud as $ConSol){ ?>
                <tr>    
                  <td><?php echo $ConSol['patologias']; ?></td>
                  <td><?php echo $ConSol['cantidad']; ?></td>                                                                         
                </tr>  
                  <?php
                $cant += $ConSol['cantidad'];
              }
            } ?>                  
          <tr>
            <td colspan="2" class = "w3-center" ><strong ><h4>Total Casos por Atender: <?php echo $cant;?></h4> </strong></td>
          </tr>        
        </table>
        <br><br>
        <?php
      break;    
      case 13: ?>    
        <strong class="w3-center" ><big>Reporte Analitica Casos Pendientes sin Atender</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        
        <table border="1" class="w3-table-all w3-hoverable w3-border  w3-card-4">            
          <tr>
            <td colspan="5" style="width: 100%;" class="w3-teal" ><strong> Datos de las Solicitudes </strong></td>
          </tr>
          <tr>
            <td colspan="1" style="width: 3%;" class="w3-teal" ><strong> N° </strong></td> -->
            <td colspan="1" style="width: 57%;" class="w3-teal" ><strong> Nombre y Apellido </strong></td>
            <td colspan="1" style="width: 20%;" class="w3-teal" ><strong> Patologias</strong></td>
            <td colspan="1" style="width: 20%;" class="w3-teal" ><strong> Requerimientos</strong></td>
          </tr>
            <?php                   
            $ConsultaSolicitud = $conexion ->prepare("SELECT cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientos
                                                      from solicitud 
                                                      where activo != 'inactivo' AND id_redsal1 = 333  
                                                      order by nombre_sol asc;");
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();                                              
            $centroDeSalud;                                 
            $total = 0; $i = 0;
            
            foreach ($ConsulSolicitud as $ConSol){ 
              $total+= 1;  $i++;?>
              <tr>                              
                <td>  <?php echo $i; ?>  </td>
                <td colspan="1" style="width: 50%;" >                    
                  <?php                                                     
                  echo "<strong>  Solicitante: </strong>".$ConSol["nombre_sol"]. " ".$ConSol   ["apellido_sol"]; 
                  if ($ConSol["cedula_sol"] != 0){
                    echo "<strong> Cedula: </strong>".$ConSol["cedula_sol"];
                  } 
                      
                  if ($ConSol["nombre_pac"]!= "") {
                    echo "<strong><br>   Paciente: </strong>".$ConSol["nombre_pac"]." ".$ConSol["apellido_pac"];                     
                    if ($ConSol["cedula_pac"]!= 0)
                        echo "<strong> Cédula: </strong>".$ConSol["cedula_pac"]; 
                    } ?>  </td>
                <td style="width: 20%;"><?php echo $ConSol["patologias"]; ?></td>                              
                <td style="width: 20%;"><?php echo $ConSol["requerimientos"]; ?></td>
              </tr>    <?php  
            } ?>
          <tr>
            <td colspan="4" ></td>
            <td colspan="4" ></td>
          </tr>
          <tr>
            <td colspan="5" class="w3-center" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
          </tr>        
        </table>
        <br><br>
        <?php
      break;            
      case 14: ?>   
        <strong class="w3-center" ><big>Reporte Analitica Requerimientos Pendientes por Atender</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>            
        <table border="1" class="w3-table-all w3-hoverable w3-border  w3-card-4">            
          <tr>
            <td colspan="5" style="width: 100%;" class="w3-teal" ><strong> Datos de las Solicitudes </strong></td>
          </tr>
          <tr>
            <td colspan="1" style="width: 2%;" class="w3-teal" ><strong> N°</strong></td>
            <td colspan="1" style="width: 30%;" class="w3-teal" ><strong> Requerimientos</strong></td>
            <td colspan="3" style="width: 68%;" class="w3-teal" ><strong> Nombre y Apellido </strong></td>
          </tr>
            <?php                   
            $ConsultaSolicitud = $conexion ->prepare("SELECT cedula_sol, nombre_sol, apellido_sol, cedula_pac, nombre_pac, apellido_pac, patologias, requerimientos
                                                      from solicitud 
                                                      where activo != 'inactivo' AND id_redsal1 = 333 
                                                      order by requerimientos asc;");
            $ConsultaSolicitud -> execute();
            $ConsulSolicitud = $ConsultaSolicitud -> fetchAll();                                              
            
            $centroDeSalud;                                 
            $total = 0; $i = 0;
            foreach ($ConsulSolicitud as $ConSol){ 
              $total+= 1;  $i++;?>
              <tr>                                                                      
                <td style="width: 2%;"> <?php echo $i; ?> </td>
                <td style="width: 30%;"><?php echo $ConSol["requerimientos"]; ?></td>                   
                <td colspan="3" style="width: 68%;" >                  
                  <?php 
                    echo "<strong>  Solicitante: </strong>".$ConSol["nombre_sol"]. " ".$ConSol   ["apellido_sol"];
                    if ($ConSol["cedula_sol"]!= 0) {
                        echo "<strong> Cédula: </strong>".$ConSol["cedula_sol"];
                    }   
                    
                    if ($ConSol["nombre_pac"]!= "") {
                        echo "<strong><br>Paciente: </strong>".$ConSol["nombre_pac"]." ".$ConSol["apellido_pac"];
                    }
                    
                    if ($ConSol["cedula_pac"]!=0){ 
                        echo "<strong> Cédula: </strong>".$ConSol["cedula_pac"]; 
                    }?>
                  </td>
                </tr>    <?php  
              } ?>
          <tr>
            <td colspan="5" ><br></td>
          </tr>
          <tr>
            <td colspan="5" class="w3-center" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $total;?></h4> </strong></td>
          </tr>        
        </table>
        <br><br>
        <?php
      break;        
      case 'Por Asignar':  
        //EXTRAEMOS EL CENTRO DE SALUD A CONSULTAR PARA COLOCARLO EN EL TITULO
        $centroDeSalud = $_POST['centroDeSalud'];
        $centroDeSaludSql = $conexion ->prepare("SELECT nombre_redsal FROM redsalud WHERE id_redsal = '$centroDeSalud';");
        $centroDeSaludSql -> execute();
        $verCentro = $centroDeSaludSql -> fetchAll(); 

        foreach($verCentro as $nombre){
          $centroSalud = $nombre['nombre_redsal'];
        }?>                

        <strong class="w3-center" ><big>Reporte por Centro de Salud (RESUELTOS)</big></strong><br>
        <strong class="w3-center" >Cuadro Resumen ( <?php echo $FechaInicio; ?> - <?php echo $FechaFinal; ?> )</strong>      
        <strong class="w3-center" ><br>Centro de Salud: <?php echo $centroSalud; ?> </strong>     
        <?php 
        $centroDeSalud = $_POST['centroDeSalud'];
        //EXTRAEMOS LOS DATOS SOLICITADOS
        $ConsultacentroDeSalud = $conexion ->prepare("SELECT COUNT(nombre_redsal) AS CANTIDAD, requerimientosaprobados, nombre_redsal 
                                                      FROM status              
                                                      INNER JOIN solicitud ON id_solici = id_solici1                                                    
                                                      INNER JOIN redsalud ON id_redsal = id_redsal2
                                                      WHERE (id_redsal2 = '$centroDeSalud' AND id_defsta1 = 9) and activo = 'activo'
                                                      GROUP BY nombre_redsal, requerimientosaprobados
                                                      ORDER BY CANTIDAD desc;");
        $ConsultacentroDeSalud -> execute();
        $centroDeSalud = $ConsultacentroDeSalud -> fetchAll();  
        ?>                            

        <table border="1" class="w3-table-all w3-hoverable w3-border w3-card-4">
          <tr class="w3-teal">                  
            <!-- <td width="20%" class="w3-teal">Patologias</td> -->
            <td width="20%" class="w3-teal">Requerimientos</td>        
            <td width="15%" class="w3-teal">Cantidad</td>
          </tr>    
            <?php                                         
            $totalCasos = 0;
            foreach ($centroDeSalud as $centro){ 
              $totalCasos += $centro['cantidad'];  ?>
              <tr>                    
                <td><?php echo $centro['requerimientosaprobados']; ?></td>
                <td class="w3-center"><?php echo $centro['cantidad']; ?></td>
              </tr>                         
                <?php    
            } ?>
            
            <tr>
              <td colspan="4" ><strong ><h4>Total Casos Atendidos: <?php echo " ". $totalCasos;?></h4> </strong></td>
            </tr>        
        </table>
        <br><br>
        <?php
      break;                  
      } ?>        
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
</body>
</html>