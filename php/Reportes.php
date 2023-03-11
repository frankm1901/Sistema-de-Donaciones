<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes</title>
  <link rel="stylesheet" href="../assets/select2/css/select2.min.css">

  <script src="../assets/jquery/jquery.min.js"></script>
  <script src="../assets/select2/js/select2.min.js"></script>      

  <style>
  #sectionPatologias, #sectionRequerimiento, #sectionCentroDeSalud, #resueltos, #noResueltos  {
    display : none;    
  } 
</style>

</head>
<body>
  
<?php require_once('../Connections/conexion.php'); ?>
<?php require_once('../includes/header.php'); ?>

<?php $fecha = date("Y-m-d"); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">
  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Generar Reportes</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <b><h1 class="w3-xxxlarge w3-text-white">Generar Reportes</h1></b>
  </header>
  <br>
  <!-- ******************************************************************************************************************* -->
  <div class="w3-container w3-content w3-margin-right" id="Layer1">
    <div class="w3-col s12 l10">
      <form name="Requerimientos" target="_blank" method="post" action="VerReportesRequerimientos.php">
        <div class="w3-card-4 w3-col s12 l11">
          <div class="w3-container w3-teal">
            <h2>Reporte Detallado</h2>
          </div>        
          
          <div class="w3-row-padding">
            <div class="w3-col w3-half" >
              <input class="w3-check w3-margin-top" type="radio" id="mostrarResueltos" name="mostrar" > 
              <label class="w3-margin-left" for = "mostrarResueltos">Casos Resueltos </label>                               
            </div>

            <div class="w3-col w3-half" >              
              <input class="w3-check w3-margin-top" type="radio"  id="mostrarNoResueltos" name="mostrar" > 
              <label class="w3-margin-left" for = "mostrarNoResueltos">Casos No Resueltos</label>                               
            </div>
            
            <div class="w3-col w3-container" >   
              <hr><hr> <!-- Dos lineas divisorias para separar las  opciones -->
            </div>

              <!--INICIO DE LOS INPUT DE LOS CASOS RESUELTOS -->           
            <section id="resueltos">
              <div cla ss="w3-col w3-container" >
                <input class="w3-check  w3-margin-top" type="radio" value = "1" id = "operadosPorCentrosDeSalud" name="detalle"  > 
                <label class="w3-margin-left" checked for = "operadosPorCentrosDeSalud" >Centros de Salud Detallados </label>                 
              </div>  
              <div cla ss="w3-col w3-container" >
                <input class="w3-check  w3-margin-top" type="radio" value = "2"  id = "resueltosDetallados" name="detalle"  > 
                <label class="w3-margin-left" checked for = "resueltosDetallados" >Analitica por Centros de Salud con Requerimientos</label>                 
              </div>              
              <div class="w3-col w3-container" >              
                <input class="w3-check w3-margin-top" type="radio" value = "3" id="operadosDetalladosPorPatologias" name="detalle" > 
                <label class="w3-margin-left" for = "operadosDetalladosPorPatologias">Por Patologias (Resueltos) </label>                               
              </div>
              <div class="w3-col w3-container" >            
                <input class="w3-check  w3-margin-top" type="radio" value = "4" id = "operadosPorCentroDeSalud" name="detalle" > 
                <label class="w3-margin-left" for = "operadosPorCentroDeSalud">Centros de Salud (Operaciones Resueltas)</label>                 
              </div>
              <div class="w3-col w3-container" >            
                <input class="w3-check  w3-margin-top" type="radio" value = "5" id = "listadoCentrosDeSaludTodos" name="detalle" > 
                <label class="w3-margin-left" for = "listadoCentrosDeSaludTodos">Centros de Salud Resueltos (Cantidad)</label>                 
              </div>    
              <div cla ss="w3-col w3-container" >
                <input class="w3-check  w3-margin-top" type="radio" value = "6"  id = "analiticaCentroDeSalud" name="detalle"  > 
                <label class="w3-margin-left" checked for = "analiticaCentroDeSalud" >Analitica por Centros de Salud Seleccionado con Requerimientos</label>                 
              </div>       
            </section>            

            <!--INICIO DE LOS INPUT DE LOS CASOS NO RESUELTOS -->           
            <section id="noResueltos">
               <div class="w3-col w3-container" >            
                <input class="w3-check  w3-margin-top" type="radio" value = "11" id = "listadoRequerimientos" name="detalle"> 
                <label class="w3-margin-left" for = "listadoRequerimientos">Reporte de Requerimientos (Pendientes)</label>                           
              </div>            
              <div class="w3-col w3-container" >
                <input class="w3-check w3-margin-top" type="radio" value = "12" id = "noOperadosDetalladosPorPatologias" name="detalle"> 
                <label class="w3-margin-left" for = "noOperadosDetalladosPorPatologias">No Resueltos por Patologias</label>                               
              </div>                            
              <div cla ss="w3-col w3-container" >
                <input class="w3-check  w3-margin-top" type="radio" value = "13" id = "pendientesDetallados" name="detalle"  > 
                <label class="w3-margin-left" checked for = "pendientesDetallados" >Analitica de Casos Pendientes sin Atender</label>                 
              </div>
              <div cla ss="w3-col w3-container" >
                <input class="w3-check  w3-margin-top" type="radio" value = "14" id = "pendientesDetalladosRequerimientos" name="detalle"  > 
                <label class="w3-margin-left" checked for = "pendientesDetalladosRequerimientos" >Analitica de Requerimientos sin Atender</label>                 
              </div>              
            </section>    

            <section>
              <div class="w3-col w3-container w3-center" >
                <label class="w3-margin-left" ><strong>Filtrar por: </strong></label>                                 
                <label class="w3-margin-left" for = "Despacho">Despacho</label>                                 
                <input class="w3-check w3-margin-top" type="radio" id="Despacho" value = "DESPACHO" name="departamento" > 
                
                <label class="w3-margin-left" for = "Sedezul">Sedezul </label>                               
                <input class="w3-check w3-margin-top" type="radio" id="Sedezul"  value = "SEDEZUL" name="departamento" > 

                <label class="w3-margin-left" for = "SignoVital">Signo Vital </label>                               
                <input class="w3-check w3-margin-top" type="radio" id="SignoVital"  value = "SIGNO VITAL" name="departamento" > 
              
                <label class="w3-margin-left" for = "Todos">Todos </label>                               
                <input class="w3-check w3-margin-top" type="radio" id="Todos"  value = "TODOS" name="departamento" checked > 
              </div>
            </section>
          </div>
            
          <!-- INICIO DEL AREA DE SELECT -->
          <div class="w3-col w3-container" >
            <section id="sectionRequerimiento" >
              <p>
              <select class="js-example-basic-multipleRequerimientos" disabled required  style="width:100%;" disabled = "disabled" id="requerimientos" name="requerimientos" >
                <option>  </option>
                  <?php 
                  $donacionesSql = $conexion -> prepare("SELECT * FROM donaciones order by nombre_donaci;");
                  $donacionesSql -> execute();      
                  $verDonaciones = $donacionesSql -> fetchAll();
                  foreach ($verDonaciones as $verDon)
                    {?>
                      <option ><?php echo $verDon['nombre_donaci']; ?></option>
                  <?php }?>   
                </select>
              </P>
            </section>
              
              <section id="sectionCentroDeSalud" >
                <p>
                  <select class="js-example-basic-multipleCentroDeSalud"  required style="width:100%;"  id="centroDeSalud" name="centroDeSalud" >
                    <option>  </option>
                    <?php 
                      $centroDeSaludSql = $conexion -> prepare("SELECT nombre_redsal from status 
                                                                INNER JOIN solicitud on id_solici = id_solici1
                                                                inner join redsalud on id_redsal = id_redsal2
                                                                WHERE activo = 'activo' and id_redsal2 != 333
                                                                GROUP BY nombre_redsal ORDER BY nombre_redsal asc;");
                      $centroDeSaludSql -> execute();      
                      $centroDeSalud = $centroDeSaludSql -> fetchAll();
                      foreach ($centroDeSalud as $red)
                        {?>
                          <option value="<?php echo $red['nombre_redsal']; ?>" ><?php echo $red['nombre_redsal']; ?></option>
                    <?php }?>   
                  </select>      
                </p>
              </section>
            </div>

            <div class="w3-col w3-container" style="width:50%">
              <p>  
                <label class="w3-margin-left">Fecha Inicio</label>
                <input min="2022-01-01" max="<?php echo $fecha; ?>" class="w3-input w3-border w3-hover-gray" value = '2022-01-01' onkeyup="validateFechaRequer()" onclick="validateFechaRequer()"  name="RequerFechaInicio" type="date" id="RequerFechaInicio"  required >
              </p>
            </div>
            <div class="w3-col w3-container" style="width:50%">
              <p>  
                <label class="w3-margin-left">Fecha Final</label>   
                <input min="2018-11-25" max="<?php echo $fecha; ?>" value = "<?php echo date('Y-m-d');  ?>" class="w3-input w3-border w3-hover-gray" onkeyup="validateFechaRequer()" onclick="validateFechaRequer()" required name="RequerFechaFinal" type="date" id="RequerFechaFinal" >
              </p>
            </div>            
          </div>
        </div>
        <div class="w3-row-padding w3-center">
            <br>
            <button name="BotonRequerimientos" type="submit" id="BotonRequerimientos" class="w3-btn w3-blue" >Generar Reporte</button>
        </div>  
      </div>
    </form>    
  </div>
</div>

  <br><br>
  
<br><br><br>
<?php require_once('../includes/footer.php'); ?>

<script>
$(document).ready(function() {
  $('.js-example-basic-multiple').select2({
    placeholder: 'Seleccionar Patologias...'
  });
  $('.js-example-basic-multipleRequerimientos').select2({
    placeholder: 'Seleccionar Requerimientos...'
  });
  $('.js-example-basic-multipleCentroDeSalud').select2({
    placeholder: 'Seleccionar Centro de Salud...'
  });
});
</script>

<script src = "../js/reportes.js" ></script>
<script src="../js/scroll.js"></script>
</body>
</html>
