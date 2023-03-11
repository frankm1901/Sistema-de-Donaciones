<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php require_once('../includes/header.php');?>	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">
<!-- CSS -->
<link rel="stylesheet" href="css/spinner.css">
<link rel="stylesheet" type="text/css" href="../css/modal.css">
<link rel="stylesheet" href="../css/stylesheet.css">
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="../css/parpadea.css">

</head>
<body id="cuerpo">
<!--*************************************************************************************************-->
<!--************************** I N I C I O   D E L    S I S T E M A *********************************-->
<?php require_once('../includes/header.php');?>
<?php require_once('../Connections/conexion.php'); ?>

<!-- INICIO DEL CUERPO DEL PROGRAMA ! -->
<div class="w3-main" style="margin-left:245px;margin-top:23px;">
  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Registrar Solicitud</span></h4>
  </div>
  
<header class="w3-container" style="background:#3385ff; padding:2px 20px">
  <h1 class="w3-xxxlarge w3-text-white">Registrar Solicitud</h1></b>
</header>
  
<div class="w3-container w3-content w3-margin-right">
  <div class="w3-col s12 l8">
    <!------------------- I N I C I O   D E L   F O R M ----------------------------------------->
    <form class="w3-container" method="post" action="ingreso_paciente.php">          
      <p>  
      <?php
      // Variable para asignar la fecha actual
      $fechaSistema = date("Y-m-d");  
      ?>
             
    </div>
</div>
        <?php 
        if (!isset($_POST['cedulaSolicitante'])){$_POST['cedulaSolicitante']= '';}
        if (!isset($_POST['cedulaPaciente'])){$_POST['cedulaPaciente']= '';}

        $cedulaSolicitante = $_POST['cedulaSolicitante'];
        if ($cedulaSolicitante == 0){$cedulaSolicitante = null;}
        if ($_POST['cedulaSolicitante'])
        {
          //VERIFICAMOS SI LA CEDULA DEL SOLICITANTE SE ENCUENTRA REGISTRADO EN LA TABLA LISTADO

          $contarCedulaSolicitante = $conexion -> prepare ("SELECT count(*) FROM ver_listado WHERE cedula = $cedulaSolicitante;");
          $contarCedulaSolicitante -> execute();
          $contar = $contarCedulaSolicitante -> fetchAll();

          foreach ($contar as $row){
            $cantidad = $row[0];    
          }
          //CONDICIONAMOS EN CASO DE NO EXISTIR DATOS DEL SOLICITANTE EN LA TABLA LISTADO E INICIALIZAMOS LAS VARIABLES
          // PARA QUE NO DE ERRORES AL NO HABER DATOS 
            if ($cantidad == 0)
            {
              $cedula = $_POST['cedulaSolicitante'];   
              $nombres = null;   
              $apellidos = null;     
              $fechaNacimiento = null; 
              $telefonos = null;   
              $parroquia = null;   
              $sector = null;                    
              ?>
          
              <div class="w3-container w3-content w3-margin-right">    
                <div><h4>NO HAY REGISTROS COINCIDENTES EN LA BASE DE DATOS</h4>    
                </div>
              </div>  
            <?php
            }else
            {       
              //SE REALIZA UNA CONSULTA A LA BD CON LA FINALIDAD DE EXTRAER LOS DATOS DEL SOLICITANTES
              $consultarCedulaSolicitante =  $conexion -> prepare ("select * from ver_listado where cedula = $cedulaSolicitante;");
              $consultarCedulaSolicitante -> execute();
              $verCedulaSolicitante = $consultarCedulaSolicitante -> fetchAll();
                // ASIGNAMOS LOS DATOS EXTRAIDOS A LAS VARIABLES
                foreach ($verCedulaSolicitante as $verCedula) {      
                  $cedula = $verCedula['cedula'];   
                  $nombres = $verCedula['nombres'];   
                  $apellidos = $verCedula['apellidos'];     
                  $fechaNacimiento = $verCedula['fecha_nacimiento']; 
                  $telefonos = $verCedula['telefonos'];   
                  $parroquia = $verCedula['parroquia'];   
                  $sector = $verCedula['sector'];     
                  if ($sector = 'null'){$sector = '';}
                }
            }
        }else{
          $cedula = null;   
          $nombres = null;   
          $apellidos = null;     
          $fechaNacimiento = null; 
          $telefonos = null;   
          $parroquia = null;   
          $sector = null;               
        }?>    
      <!-- ********************  INICIO DE LOS DATOS DEL SOLICITANTE **************************** -->  
      <?php ///VERIFICAMOS SI EL NUMERO DE CEDULA INGRESADO POSEE DIVERSAS SOLICITUDES
          $contarRegistros = $conexion -> prepare ("SELECT count(*) as cantidad, requerimientos, patologias 
                                                    FROM solicitud 
                                                    WHERE activo != 'inactivo' and ((cast (cedula_sol as varchar) = '$cedulaPac') or cast ((cedula_sol as varchar) = '$cedulaPac'))
                                                    GROUP BY requerimientos, patologias
                                                    ORDER BY cantidad desc;");
          $contarRegistros -> execute();
          $contarReg = $contarRegistros -> fetchAll();
          $cantidad = null;
          foreach ($contarReg as $cant){
            $cantidad = $cant['cantidad'];
          }

          if ($cantidad){
            ?>
            <div class="w3-responsive " align="center" id="Layer2">    
              <span class='parpadea text'> <strong><h2> Registros de Solicitudes anteriores</h2></strong></span>
              <table style="width:100%" > 
                <tr >
                  <td>Cantidad</td>
                  <td>Requerimientos</td>
                  <td>Patologias</td>
                </tr>
                <?php
                foreach ($contarReg as $mostrar){
                  $cantidad = $mostrar[0];  
                  if ($mostrar[0] > 0){ ?>
                    <tr>
                      <td style="text-align: center;" w3-center ><span class='text'><h5><?php echo $cantidad;?> </h5></span></td>                
                      <td><span class='text'><h3><?php echo $mostrar['requerimientos'];?></h3></span></td>
                      <td><span class='text'><h3><?php echo $mostrar['patologias'];?> </h3> </span> </td>
                    </tr>
                        
                    <script> document.body.style.backgroundColor = '#A2D9CE'; </script>                 
                    <?php 
                    }
                  }?>
                  </table>    
                  <br>  
              
          </div> 
          <?php } ?>

  <div class="w3-container w3-content w3-margin-right">
    <div class="w3-card-4 w3-col s12 l8">        
      <div class="w3-container w3-teal">
        <h2>Datos del Solicitante</h2>
      </div>                       
      <div class="w3-row-padding">                                                  
        <div class="w3-row-padding">
          </p>                        
          <div class="w3-half">  
            <label>Nombre</label>   
            <input maxlength="30" value = "<?php echo $nombres; ?>"  placeholder="Nombre del Solicitante" name="nombre_sol" type="text" id="nombre_sol" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text">
          </div>
          <div class="w3-half">       
            <label>Apellido</label>   
            <input maxlength="30" value = "<?php echo $apellidos; ?>" placeholder="Apellido del Solicitante" name="apellido_sol" type="text" id="apellido_sol" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text">
          </div>  
        </div>

        <div class="w3-row-padding">
          </p>
          <div class="w3-half">  
            <label>Cédula</label>                               
            <input  maxlength="12" value = "<?php echo $cedula; ?>" placeholder="Cedula del Solicitante" name="cedula_sol" type="text" id="cedula_sol" onKeyPress="return validarCedula(event)"  class="w3-input w3-border w3-hover-gray">                            
          </div>
          <div class="w3-half">       
            <label>Teléfonos</label>   
            <input maxlength="45" required="required" value = "<?php echo $telefonos; ?>" placeholder="Telefonos" name="telefono_sol" type="text" id="telefono_sol" onKeyPress="return validarTelefonos(event)" class="w3-input w3-border w3-hover-gray" type="text">
          </div>  
        </div>
      </div>

      <div class="w3-row-padding">
        <div class="w3-half"> 
          <label>Fecha de Nacimiento</label>   
          <input min="1900-01-01" max="<?php echo $fechaSistema; ?>" value = "<?php echo $fechaNacimiento; ?>" type="date" name="user_date" id="user_date"  class="w3-input w3-border w3-hover-gray" type="text">
        </div>
        <div class="w3-half">  
          <label>Edad</label>
          <input placeholder="Edad" name="edad_sol" type="text" id="edad_sol" size="80" readonly="readonly" class="w3-input w3-border w3-hover-gray" type="text">
        </div>       

        <div class="w3-row-padding">
          <div id="div_edad_sol" style="background: red" >
        </div>  
      </div>

      <div class="w3-row-padding">                      
        <label>Municipio</label>    <br>
        <select name="parroquia" style="width: 100%" required="required" id="parroquia" class="w3-select js-example-basic-multiple-localidad">
          <option value="" disabled selected>Seleccionar Municipio</option> -->
            <?php  
                $queryM = $conexion ->prepare("SELECT id_localidades, id_parroquia, name_parroquia, name_municipio FROM localidades ORDER BY name_municipio, name_parroquia desc;");
                $queryM -> execute();
                $verMunicipio = $queryM -> fetchAll();
                //var_dump ($verMunicipio);

                foreach ($verMunicipio as $rowM)
                    { ?>
                        <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                    <?php }    ?> 
        </select>
      </div>
      <div class="w3-row-padding">                      
        <label>Ciudad / Pueblo / Sector</label>                    
        <input maxlength="80" value = "<?php echo $sector; ?>" placeholder="Sector Pueblo o Ciudad de Residencia" name="sector_sol" id="sector_sol" style="width: 95%" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  type="text" class="w3-input w3-border w3-hover-gray" >
      </div>
      <br>  
    </div>        
  </div>
  <!--Inicio para el Ingreso de los Datos del Representante
  ***********************************************************-->
  <?php 
  if ($_POST['cedulaPaciente'])
  {
    //VERIFICAMOS SI LA CEDULA DEL SOLICITANTE SE ENCUENTRA REGISTRADO EN LA TABLA LISTADO
    $cedulaPaciente = $_POST['cedulaPaciente'];
    
    if ($cedulaPaciente == 0){$cedulaPaciente = null;}
    $contarPaciente = $conexion -> prepare ("SELECT count(*) FROM ver_listado WHERE cedula = $cedulaPaciente;");
    $contarPaciente -> execute();
    $contarPac = $contarPaciente -> fetchAll();

    foreach ($contarPac as $pac){
      $cantPac = $pac[0];        
    }
    //CONDICIONAMOS EN CASO DE NO EXISTIR DATOS DEL SOLICITANTE EN LA TABLA LISTADO E INICIALIZAMOS LAS VARIABLES
    // PARA QUE NO DE ERRORES AL NO HABER DATOS 
    if ($cantPac == 0){
      $cedulaPac = $_POST['cedulaPaciente'];   
    }else
      {
        ?>
        <?php 
        //SE REALIZA UNA CONSULTA A LA BD CON LA FINALIDAD DE EXTRAER LOS DATOS DE LOS SOLICITANTES
        $consultarCedulaPaciente =  $conexion -> prepare ("select * from ver_listado where cedula = $cedulaPaciente;");
        $consultarCedulaPaciente -> execute();
        $verCedulaPaciente = $consultarCedulaPaciente -> fetchAll();
          // ASIGNAMOS LOS DATOS EXTRAIDOS A LAS VARIABLES
          foreach ($verCedulaPaciente as $verPac) {      
            $cedulaPac = $verPac['cedula'];   
            $nombresPac = $verPac['nombres'];   
            $apellidosPac = $verPac['apellidos'];     
            $fechaNacimientoPac = $verPac['fecha_nacimiento']; 
            $telefonosPac = $verPac['telefonos'];   
            $parroquiaPac = $verPac['parroquia'];   
            $sectorPac = $verPac['sector'];     
            if ($sectorPac = 'null'){$sectorPac = null;}
          }
      }
  }else{
    $cedulaPac = null;   
    $nombresPac = null;   
    $apellidosPac = null;     
    $fechaNacimientoPac = null; 
    $telefonosPac = null;   
    $parroquiaPac = null;   
    $sectorPac = null;
  }  
      $contarRegistrosPacientes = $conexion -> prepare ("SELECT count(*) as cantidad, requerimientos, patologias 
                                                FROM solicitud 
                                                WHERE activo != 'inactivo' and cedula_sol = $cedulaPac or cedula_pac = $cedulaPac
                                                GROUP BY requerimientos, patologias
                                                ORDER BY cantidad desc;");
      $contarRegistrosPacientes -> execute();
      $contarRegPac = $contarRegistrosPacientes -> fetchAll();
      $cantidadPac = null;
          foreach ($contarRegPac as $cantPac){
            $cantidadPac = $cantPac['cantidad'];
          }

          if ($cantidadPac){
            ?>
            <div class="w3-container w3-content w3-margin-right">  
              <span class='parpadea text'> <strong><h2> Registros de Solicitudes anterioresSSS</h2></strong></span>
              <table style="width:100%" > 
                <tr >
                  <td>Cantidad</td>
                  <td>Requerimientos</td>
                  <td>Patologias</td>
                </tr>
                <?php
                foreach ($contarRegPac as $mostrarPac){
                  $cantidad = $mostrarPac[0];  
                  if ($mostrarPac[0] > 0){ ?>
                    <tr>
                      <td style="text-align: center;" w3-center ><span class='text'><h5><?php echo $cantidad;?> </h5></span></td>                
                      <td><span class='text'><h3><?php echo $mostrarPac['requerimientos'];?></h3></span></td>
                      <td><span class='text'><h3><?php echo $mostrarPac['patologias'];?> </h3> </span> </td>
                    </tr>
                        
                    <script> document.body.style.backgroundColor = '#A2D9CE'; </script>                 
                    <?php 
                    }
                  }?>
                  </table>    
                  <br>  
              
          </div> 
          <?php } ?>

  <div class="w3-container w3-content w3-margin-right">
    <br>
    <div class="w3-card-4 w3-col s12 l8">
      <div class="w3-container w3-indigo">
        <h2>Datos del Paciente</h2>
      </div>       
      <div class="w3-row-padding">
        <br>
        <label>Vinculo Familiar del Solicitante con el Paciente  -  Herman@, Hij@, Ti@ etc</label>   
        <input  maxlength="30" placeholder="Vinculo con el Solicitante" name="vinculo_pac" type="text" id="vinculo_pac" onKeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  class="w3-input w3-border w3-hover-gray">            
      </div>
      <div class="w3-row-padding">                    
        <div class="w3-half">
          <label>Cédula Paciente</label>   
          <input  maxlength="12" value = "<?php echo $cedulaPac; ?>" placeholder="Cedula del Paciente" name="cedula_pac" type="text" id="cedula_pac"  onKeyPress="return validarCedula(event)"  class="w3-input w3-border w3-hover-gray">
        </div>
        <div class="w3-half"> 
          <label>Teléfono Paciente</label>   
          <input  maxlength="45" value = "<?php echo $telefonosPac; ?>" placeholder="Telefono" name="telefono_pac" type="text" id="telefono_pac" onKeyPress="return validarTelefonos(event)"  class="w3-input w3-border w3-hover-gray">
        </div>
      </div>  
        <div class="w3-row-padding">
          <div class="w3-half">  
            <label>Nombre Paciente</label>   
            <input  maxlength="30" value = "<?php echo $nombresPac ?>" placeholder="Nombre del Paciente" name="nombre_pac" type="text" id="nombre_pac"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray">
          </div>
          <div class="w3-half">
            <label>Apellido Paciente</label>   
            <input  maxlength="30" value = "<?php echo $apellidosPac ?>" name="apellido_pac" placeholder="Apellido del Paciente" type="text" id="apellido_pac"  onKeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray">                        
          </div>
        </div> 

        <div class="w3-row-padding">
          <div class="w3-half"> 
            <label>Fecha de Nacimiento del Paciente</label>   
            <input min="1900-01-01" value = "<?php echo $fechaNacimientoPac; ?>" max="<?php echo $fechaSistema; ?>"" type="date" name="user_date_pac" id="user_date_pac" class="w3-input w3-border w3-hover-gray" type="text">
          </div>
        <div class="w3-half">  
          <label>Edad del Paciente</label>
          <input placeholder="Edad" name="edad_pac" type="text" id="edad_pac" size="80" readonly="readonly" class="w3-input w3-border w3-hover-gray" type="text">
        </div>          
        <div class="w3-row-padding">
          <div id="div_edad_pac" style="background: red" >
          </div>                          
        </div>
        <div class="w3-row-padding">                      
          <label>Municipio</label>   <br> 
          <select  style="width: 95%" name="parroquiaPaciente" id="parroquiaPaciente" class="w3-select w3-border js-example-basic-multiple-localidad">
            <option value="" disabled selected>Seleccionar Municipio</option>
              <?php  
              foreach ($verMunicipio as $rowM){ ?>
                <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                <?php 
              } ?> 
          </select>
        </div>
        <div class="w3-row-padding">                      
          <label>Ciudad / Pueblo / Sector</label>                    
          <input maxlength="80" placeholder="Sector Pueblo o Ciudad de Residencia" name="sectorPaciente" id="sectorPaciente" style="width: 95%" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  type="text" class="w3-input w3-border w3-hover-gray" >
        </div>
        <br>  
      </div>        
    </div>
  </div>
</div>  
<br>
<!--************************************************************************************************-->
<!-- INICIO DEL AREA PARA LA DESCRIPCION DE LA SOLICITUD -->

  <div class="w3-container w3-content w3-margin-right">
    <div class="w3-card-4 w3-col s12 l8">
      <div class="w3-container w3-blue-gray">
        <h2>Solicitudes</h2>
      </div>            
      <div class="w3-row-padding" > 
        <table class="w3-table">
          <th colspan = '4'  ><center><big>Documentos Consignados</big></center></th>
            <tr>
              <td class = "w3-center"><label class="w3-margin-left" for = "informemedico">Informe Médico </label><br>                                                  
                <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "im" id="informemedico" name="informemedico"  ></td>
              <td class = "w3-center"><label class="w3-margin-left" for = "copiacedula">Copia C.I. </label><br>
                <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "ci" id="copiacedula" name="copiacedula" > </td>
              <td class = "w3-center"><label class="w3-margin-left" for = "cartasolicitud">Carta de Solicitud </label><br>
                <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "cs" id="cartasolicitud" name="cartasolicitud"> </td>
              <td class = "w3-center"><label class="w3-margin-left" for = "presupuesto">Presupuesto</label><br>
                <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "p" id="presupuesto" name="presupuesto"> </td>
            </tr>
          </table>
      </div>
      <br>
      <div class="w3-row-padding">
        <div class="w3-half">
          <label>Fecha de la solicitud - Gira</label>   
          <input min="2022-01-01" max="<?php echo $fechaSistema; ?>" required = "required" name="fechaSolicitante" type="date" id="fechaSolicitante" require = 'required'  class="w3-input w3-border w3-hover-gray">
          <br>
        </div>
        <div class="w3-half"> 
          <label>Fecha de Recibido - S.S.Z. </label>                         
          <input min="2022-01-01" max="<?php echo $fechaSistema; ?>" required = "required" name="fechaRecibidoSRS" type="date" id="fechaRecibidoSRS" require  = 'required' class="w3-input w3-border w3-hover-gray">
        </div>                
      </div>
      <!-- INGRESO PARA LAS PATOLOGIAS -->
      <div class="w3-row-padding">
        <div> 
          <label class="w3-margin-left">Patologías</label>  
        </div>  
      </div>                  
      <div class="w3-row-padding w3-center">
        <select class="js-example-basic-multiple-patologias" required="required" style="width:97%;" name="patologias[]" multiple="multiple">
          <option> </option>
            <?php 
            // Consulta para seleccionar los elementos de la tabla DONACIONES
            $consulta = $conexion -> prepare("SELECT patologia FROM patologias order by patologia;");
            $consulta -> execute();
            $resultado = $consulta -> fetchAll();                                                                                           
            foreach($resultado as $result)
              { ?>
                <option value="<?php echo $result['patologia']; ?>"><?php echo $result['patologia']; ?>                        </option>
                  <?php 
              }?>           
        </select>    
      </div>
      <!-- INGRESO PARA LOS REQUERIMIENTOS -->
      <div>
        <label class="w3-margin-left">Requerimientos</label>                                
      </div>    
      <div class="w3-row-padding w3-center">
        <select class="js-example-basic-multiple" required style="width:97%;" id="requerimientos" name="requerimientos[]" multiple="multiple">
          <option>  </option>
            <?php 
            // Consulta para seleccionar los elementos de la tabla DONACIONES                              
            $donacionSql = $conexion ->prepare("SELECT * FROM donaciones;");
            $donacionSql ->execute();
            $verDonacion = $donacionSql ->fetchAll();

            foreach($verDonacion as $verDonaci)
              {?>
                <option value="<?php echo $verDonaci['nombre_donaci']; ?>"><?php echo $verDonaci['nombre_donaci']; ?></option>
                <?php   
              }?>   
        </select>
      </div>
      <!-- INGRESO PARA LAS CONSIDERACIONES DE LA SOLICITUD -->
      <div class="w3-row-padding">                
        <label class="w3-margin-left"> Medio de Recepción:</label>                    
      </div>
      <div class="w3-row-padding w3-center">
        <select name="recepcion" id="recepcion" style="width:97%" required = required class="w3-select w3-border">
          <option value="" disabled selected required >Seleccionar Medio de Recepción: </option>             
            <?php       
              $sqlRecepcion = $conexion ->prepare("SELECT * FROM recepcion;");
              $sqlRecepcion -> execute();
              $verRecepcion = $sqlRecepcion -> fetchAll();
              foreach ($verRecepcion as $status)
                { ?>                          
                      <option value="<?php echo $status['idrecepcion']; ?>"><?php echo $status['recepcion']; ?></option>
        <?php   } 
            ?>  
                          
        </select>   
      </div>            
      <div class="w3-row-padding">
        <div class="w3-row-padding">                      
          <label class="w3-margin-left">Lugar de Recepcion Parroquia o Municipio</label>    
          <select style="width: 95%" name="lugar_recep" require id="lugar_recep" class="w3-select w3-border js-example-basic-multiple-localidad">
            <option value="" disabled selected>Seleccionar Parroquia o Municipio de Recepcion</option>
              <?php  
              $queryM = $conexion ->prepare("SELECT id_localidades, id_parroquia, name_parroquia, name_municipio FROM localidades ORDER BY name_municipio, name_parroquia desc;");
              $queryM -> execute();
              $verMunicipio = $queryM -> fetchAll();
              //var_dump ($verMunicipio);

              foreach ($verMunicipio as $rowM)
                { ?>
                    <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
          <?php }    ?> 
          </select>
        </div>
        <div class="w3-half">  
          <label class="w3-margin-left">Firmado por el Gobernador</label>
          <select name = "firmado" id= "firmado" class="w3-select w3-border" >
            <option value= "NO" >NO</option>    
            <option value= "SI" >SI</option> 
          </select>
        </div>    
        <div class="w3-half">  
          <label>Observaciones</label>   
          <textarea maxlength="100" placeholder="Observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" name="observaciones" cols="30" rows="5"></textarea>
        </div>                 
        <br>     
        <div class="w3-row-padding w3-center ">
          <br> 
          <button name="EnviarFormulario" type="submit" id="EnviarFormulario" class="w3-btn w3-green">Registrar Solicitud</button>
          <button name="Limpiar Formulario" type="reset" id="limpiarFormulario" class="w3-btn w3-red">Limpiar Formulario</button>      
        </div>   
        <br>            
      </div>
    </div>
    </p>
    </form>
  </div>
</div>

<br><br>

<?php require_once('../includes/footer.php'); ?>

<script src="../assets/jquery/jquery.min.js"></script>
<script src="../assets/select2/js/select2.min.js"></script>	
<style type="text/css" src="../css/modal.css"></style>
<script src="../js/registroPaciente.js"></script>
<script src="../js/validarNumeros.js" ></script>
</body>
</html>