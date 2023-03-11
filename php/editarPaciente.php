<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once('../includes/header.php');?>	
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta charset="utf-8">

<link rel="stylesheet" href="css/spinner.css">
<link rel="stylesheet" type="text/css" href="../css/modal.css">
<link rel="stylesheet" href="../css/stylesheet.css">
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">
<link rel="stylesheet" href="../css/stylesheet.css">
<link rel="stylesheet" href="../assets/select2/css/select2.min.css">

</head>
<body>
<?php require_once('../includes/header.php');?>
<?php require_once('../Connections/conexion.php'); ?>

<!--******************* I N I C I O   D E L    S I S T E M A *********************************-->
<!-- INICIO DEL CUERPO DEL SISTEMA -->
<div class="w3-main" style="margin-left:245px;margin-top:23px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Editar Solicitud</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff; padding:2px 20px">
    <h1 class="w3-xxxlarge w3-text-white">Editar Solicitud</h1></b>
  </header>
  
  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO 
  ***************************************************************************************************** -->
<div class="w3-container w3-content w3-margin-right">
  <div class="w3-col s12 l8">
    <!------------------- I N I C I O   D E L   F O R M ----------------------------------------->
    <form class="w3-container" method="post" action="actualizarPaciente.php">          
      <p>  
      <?php
      // Variable para asignar la fecha actual
      $fechaSistema = date("Y-m-d");  
      $seleccion = $_GET['seleccion'];
      ?>          
  </div>
</div>

      <?php 
      //SE REALIZA UNA CONSULTA A LA BD CON LA FINALIDAD DE EXTRAER LOS DATOS DE LOS SOLICITANTES
      $consultarSolicitud =  $conexion -> prepare ("SELECT *  FROM solicitud 
      inner join recepcion on idrecepcion = idrecepcion1
      inner join localidades on id_localidades = id_localidades1   where id_solici = $seleccion;");
      $consultarSolicitud -> execute();
      $verConsultarSolicitud = $consultarSolicitud -> fetchAll();
      // ASIGNAMOS LOS DATOS EXTRAIDOS A LAS VARIABLES
      foreach ($verConsultarSolicitud as $verSolicitud) {      
      ?> 
      <!-- ********************  INICIO DE LOS DATOS DEL SOLICITANTE **************************** -->
      <div class="w3-container w3-content w3-margin-right">        
        <div class="w3-card-4 w3-col s12 l8">        
          <div class="w3-container w3-teal">
            <h2>Datos del Solicitante</h2>
          </div>          
          <input value =  "<?php echo $seleccion; ?>" name="seleccion" type="hidden" id="seleccion" readonly="readonly" class="w3-input w3-border w3-hover-gray">
          <div class="w3-row-padding">                                                  
            <div class="w3-row-padding">
              </p>                        
              <div class="w3-half">  
                <label>Nombre</label>                               
                <input maxlength="30" value =  "<?php echo $verSolicitud['nombre_sol']; ?>"     placeholder="Nombre del Solicitante" name="nombre_sol" type="text" id="nombre_sol" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text">
              </div>
              <div class="w3-half">       
                <label>Apellido</label>   
                <input maxlength="30" value =  "<?php echo $verSolicitud['apellido_sol'];  ?>"    placeholder="Apellido del Solicitante" name="apellido_sol" type="text" id="apellido_sol" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text">
              </div>  
            </div>

            <div class="w3-row-padding">
              </p>
              <div class="w3-half">  
                <label>Cédula</label>   
                <?php if ($verSolicitud['cedula_sol'] == 0){$verSolicitud['cedula_sol']='';}  ?>
                <input  maxlength="12" value =  "<?php echo $verSolicitud['cedula_sol']; ?>"    placeholder="Cedula del Solicitante" name="cedula_sol" type="text" id="cedula_sol" onKeyPress="return validarCedula(event)"  class="w3-input w3-border w3-hover-gray">                            
              </div>
              <div class="w3-half">       
                <label>Teléfonos</label>   
                <?php if ($verSolicitud['telefono_sol'] == null){$verSolicitud['telefono_sol'] = ''; } ?>
                <input maxlength="50" value =  "<?php echo $verSolicitud['telefono_sol']; ?>"    placeholder="Telefonos" name="telefono_sol" type="text" id="telefono_sol" onKeyPress="return validarTelefonos(event)" class="w3-input w3-border w3-hover-gray" type="text">
              </div>  
            </div>
          </div>

          <div class="w3-row-padding">
            <div class="w3-half"> 
              <label>Fecha de Nacimiento</label>   
              <?php// if ($verSolicitud['fec_nac_sol'] == null){$verSolicitud['fec_nac_sol'] = ''; };?>
              <input min="1900-01-01" max="<?php echo $fechaSistema; ?>" value =  "<?php echo $verSolicitud['fec_nac_sol'];?>"    type="date" name="user_date" id="user_date" class="w3-input w3-border w3-hover-gray" type="text">
            </div>
            <div class="w3-half">  
              <label>Edad</label>
              <input placeholder="Edad" name="edad_sol" type="text" id="edad_sol" size="24" readonly="readonly" class="w3-input w3-border w3-hover-gray" type="text">
            </div>          
          
            <div class="w3-row-padding">
              <div id="div_edad_sol" style="background: red" >
              </div>  
            </div>
            <div class="w3-row-padding">                      
              <label>Municipio</label>    <br>
              <select style="width: 100%" name="parroquia" required="required" id="parroquia" class="w3-select w3-border js-example-basic-multiple-localidad">                    
                <option value="<?php echo $verSolicitud['id_localidades'];?>" > <?php echo $verSolicitud['name_municipio']." --- ".$verSolicitud['name_parroquia']; ?></option>
                  <!-- <option value="" disabled selected>Seleccionar Municipio</option>  -->
                  <?php  
                  $queryM = $conexion ->prepare("SELECT id_localidades, id_parroquia, name_parroquia, name_municipio FROM localidades ORDER BY name_municipio, name_parroquia desc;");
                  $queryM -> execute();
                  $verMunicipio = $queryM -> fetchAll();
                  
                  foreach ($verMunicipio as $rowM){ ?>
                    <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                    <?php 
                  } ?> 
              </select>
            </div>
            <div class="w3-row-padding">                      
              <label>Ciudad / Pueblo / Sector</label>    
              <input maxlength="80" value =  "<?php echo $verSolicitud['sector_sol']; ?>" placeholder="Sector Pueblo o Ciudad de Residencia" name="sector_sol" id="sector_sol" style="width: 100%" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  type="text" class="w3-input w3-border w3-hover-gray" >
            </div>
            <br>  
          </div>        
        </div>  

        <!-- ********************  INICIO DE LOS DATOS DEL SOLICITANTE **************************** -->
        <div class="w3-container w3-content w3-margin-right">
          <br> 
          <div class="w3-card-4 w3-col s12 l8">
            <div class="w3-container w3-indigo">
              <h2>Datos del Paciente</h2>
            </div>       
            <div class="w3-row-padding">
              <br>
              <?php 
              if (!isset($verSolicitud['nombre_pac'])) { 
                    $verSolicitud['vinculofamiliar']='';  $verSolicitud['cedula_pac']='';     $verSolicitud['nombre_pac']='';
                    $verSolicitud['apellido_pac']='';     $verSolicitud['telefono_pac']='';   $verSolicitud['fec_nac_pac']=''; 
                    $verSolicitud['edad_pac']='';         $verSolicitud['sector_pac']='';
              } 
              if ($verSolicitud['cedula_pac'] == 0){
                $verSolicitud['cedula_pac']='';
              }?>

              <label>Vinculo Familiar del Solicitante con el Paciente  -  Herman@, Hij@, Ti@ etc</label>   
              <input  maxlength="30" value = "<?php echo $verSolicitud['vinculofamiliar']; ?>" placeholder="Vinculo con el Solicitante" name="vinculo_pac" type="text" id="vinculo_pac" onKeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  class="w3-input w3-border w3-hover-gray">            
            </div>
            <div class="w3-row-padding">                    
              <div class="w3-half">
                <label>Cédula Paciente</label>   
                <input  maxlength="12" value = "<?php echo $verSolicitud['cedula_pac']; ?>" placeholder="Cedula del Paciente" name="cedula_pac" type="text" id="cedula_pac" onKeyPress="return validarCedula(event)"  class="w3-input w3-border w3-hover-gray">
              </div>
              <div class="w3-half"> 
                <label>Teléfono Paciente</label>   
                <input  maxlength="25" placeholder="Telefono" value = "<?php echo $verSolicitud['telefono_pac']; ?>" name="telefono_pac" type="text" id="telefono_pac" onKeyPress="return validarTelefonos(event)"  class="w3-input w3-border w3-hover-gray">
                  </div>
              </div>  
              <div class="w3-row-padding">
                <div class="w3-half">  
                  <label>Nombre Paciente</label>   
                  <input  maxlength="30" placeholder="Nombre del Paciente" value = "<?php echo $verSolicitud['nombre_pac']; ?>" name="nombre_pac" type="text" id="nombre_pac"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray">
                </div>
                <div class="w3-half">
                  <label>Apellido Paciente</label>   
                  <input  maxlength="30" name="apellido_pac" placeholder="Apellido del Paciente" value = "<?php echo $verSolicitud['apellido_pac']; ?>" type="text" id="apellido_pac"  onKeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray">                        
                </div>
              </div> 
              <div class="w3-row-padding">
                <div class="w3-half"> 
                  <label>Fecha de Nacimiento del Paciente</label>   
                  <?php// if ($verSolicitud['fec_nac_pac'] == null){$verSolicitud['fec_nac_pac'] = '2022-01-01'; };?>
                  <input min="1900-01-01" max="<?php echo $fechaSistema; ?>" value = "<?php echo $verSolicitud['fec_nac_pac']; ?>" type="date" name="user_date_pac" id="user_date_pac" onkeyup="javascript:calcularEdadPac()"   class="w3-input w3-border w3-hover-gray" type="text">
                </div>
                <div class="w3-half">  
                  <label>Edad del Paciente</label>
                  <input placeholder="Edad" name="edad_pac" type="text" id="edad_pac" size="24" readonly="readonly" class="w3-input w3-border w3-hover-gray" type="text">
                </div>          
                <div class="w3-row-padding">
                  <div id="div_edad_pac" style="background: red" >
                  </div>                          
                </div>
                <div class="w3-row-padding">                      
                  <label>Municipio</label>   <br> 
                  <select style="width: 100%" name="parroquiaPaciente" id="parroquiaPaciente" class="w3-select w3-border js-example-basic-multiple-localidad">
                      <?php 
                      echo "<br>La localidad es: ".$locRepre = $verSolicitud["id_localidadespac"];                                      
                      $localidadRepresentante = $conexion ->prepare("SELECT id_localidades, id_parroquia, name_parroquia, name_municipio FROM localidades where id_localidades = $locRepre;");
                      $localidadRepresentante -> execute();
                      $localRepresentante = $localidadRepresentante -> fetchAll();
                      
                      foreach ($localRepresentante as $localRep){ ?>
                        <option value="<?php echo $localRep['id_localidades'];?>" > <?php echo $localRep['name_municipio']." --- ".$localRep['name_parroquia']; ?></option>
                        <?php 
                      } 
                      
                      foreach ($verMunicipio as $rowM){ ?>
                      <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                      <?php 
                    } ?> 
                  </select>
                </div>
                <div class="w3-row-padding">                      
                    <label>Ciudad / Pueblo / Sector</label>                    
                    <input maxlength="80" placeholder="Sector Pueblo o Ciudad de Residencia" value = "<?php echo $verSolicitud['sector_pac']; ?>" name="sectorPaciente" id="sectorPaciente" style="width: 100%" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  type="text" class="w3-input w3-border w3-hover-gray" >
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
                      <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "si" <?php if ($verSolicitud['informemedico'] == 'si')echo 'checked'; ?> id="informemedico" name="informemedico"  ></td>
                    <td class = "w3-center"><label class="w3-margin-left" for = "copiacedula">Copia C.I. </label><br>
                      <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "si" <?php if ($verSolicitud['copiacedula'] == 'si')echo 'checked'; ?> id="copiacedula" name="copiacedula" > </td>
                    <td class = "w3-center"><label class="w3-margin-left" for = "cartasolicitud">Carta de Solicitud </label><br>
                      <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "si" <?php if ($verSolicitud['cartadesolicitud'] == 'si')echo 'checked'; ?> id="cartasolicitud" name="cartasolicitud"> </td>
                    <td class = "w3-center"><label class="w3-margin-left" for = "presupuesto">Presupuesto</label><br>
                      <input class="w3-check w3-margin-left w3-margin-top" type="checkbox" value = "si" <?php if ($verSolicitud['presupuesto'] == 'si')echo 'checked'; ?> id="presupuesto" name="presupuesto"> </td>
                  </tr>
              </table>
            </div>
            <div class="w3-row-padding">
              <div class="w3-half">
                <label>Fecha de la solicitud - Gira</label>                   
                <input min="2022-01-01" max="<?php echo $fechaSistema; ?>" name = "fechagira" value = "<?php echo $verSolicitud['fecha_recibido_solicitud']; ?>" required = "required" 
                        name="fechaSolicitante" type="date" id="fechaSolicitante" require = 'required'  class="w3-input w3-border w3-hover-gray">
                <br>
              </div>
            <div class="w3-half"> 
              <label>Fecha de Recibido - S.S.Z. </label>                         
              <input min="2022-01-01" max="<?php echo $fechaSistema; ?>" name = "fechasrs" required = "required" value = "<?php echo $verSolicitud['fecha_recibido_srs']; ?>" name="fechaRecibidoSRS" type="date" id="fechaRecibidoSRS" require  = 'required' class="w3-input w3-border w3-hover-gray">
            </div>                 
          </div>
          <div class="w3-row-padding">
            <div> 
              <label class="w3-margin-left">Patologías</label>  
            </div>  
          </div>                  
          <div class="w3-row-padding">
            <select name="patologias[]" style="width: 100%;" multiple="multiple" id="patologias" class="w3-select w3-border js-example-basic-multiple-patologias" required="required">                  
              <option value="<?php echo "PRUEBAss"; ?>"><?php echo "PRUEBAss"; ?>
                <?php  
                // Consulta para seleccionar los elementos de la tabla DONACIONES
                $consulta = $conexion -> prepare("SELECT patologia FROM patologias order by idpat;");
                $consulta -> execute();
                $resultado = $consulta -> fetchAll();  

                foreach($resultado as $result){ ?>
                    <option value="<?php echo $result['patologia']; ?>"><?php echo $result['patologia']; ?></option>
                    <?php 
                }?>           
            </select>    
          </div>
          <!-- INGRESO PARA LOS REQUERIMIENTOS -->
          <div>
            <label class="w3-margin-left">Requerimientos</label>                                
          </div>    
          <div class="w3-row-padding">
            <select class="js-example-basic-multipleEditar" required style="width:100%;" id="requerimientos" name="requerimientos[]" multiple="multiple">
              <?php 
              //Consulta para seleccionar los elementos de la tabla DONACIONES                              
              $donacionSql = $conexion ->prepare("SELECT * FROM donaciones order by id_donaci, id_tipdon1 asc;");
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
            <label > Medio de Recepción:</label>                    
          </div>
          <div class="w3-row-padding">
            <select name="recepcion" id="recepcion" required class="w3-select w3-border">     
              //Consulta para seleccionar la Definicion del Status
              <option value="<?php echo $verSolicitud['idrecepcion']; ?>"> <?php echo $verSolicitud['recepcion']; ?></option>
                <?php
                  //Consulta para seleccionar la Definicion del Status
                  $statusSql = $conexion -> prepare ("SELECT recepcion FROM recepcion ORDER BY idrecepcion;");
                  $statusSql -> execute();
                  $verStatus = $statusSql -> fetchAll();
                  
                  foreach ($verStatus as $status)
                    { 
                  ?>                          
                  <option value="<?php echo $status['recepcion']; ?>"><?php echo $status['recepcion']; ?></option>
              <?php   } 
              ?>                            
            </select>   
          </div>            
          <div class="w3-row-padding">
            <div class="w3-row-padding">                      
              <label>Lugar de Recepcion Parroquia o Municipio</label>                              
              <select style="width:100%;" name="lugar_recep" id="lugar_recep" class="w3-select w3-border js-example-basic-multiple-localidad">                                  
                <?php 
                $locRecepcion = $verSolicitud["id_localidadrecepcion"];
                
                $localidadRecepcion = $conexion ->prepare("SELECT id_localidades, id_parroquia, name_parroquia, name_municipio FROM localidades where id_localidades = $locRecepcion;");

                $localidadRecepcion -> execute();
                $localRecepcion = $localidadRecepcion -> fetchAll();
                foreach ($localRecepcion as $verMun)
                { ?>
                    <option value="<?php echo $verMun['id_localidades'];?>" > <?php echo $verMun['name_municipio']." --- ".$verMun['name_parroquia']; ?></option>
                    <?php 
                } 

                //var_dump ($verMunicipio);
                ?>
                <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                <?php 
                foreach ($verMunicipio as $rowM)
                  { ?>
                      <option value="<?php echo $rowM['id_localidades'];?>" > <?php echo $rowM['name_municipio']." --- ".$rowM['name_parroquia']; ?></option>
                  <?php }    ?> 
              </select>
            </div>
                    
            <div class="w3-half">  
              <label>Firmado por el Gobernador</label>
              <select name = "firmado" id= "firmado" class="w3-select w3-border" >
                <option value= "<?php echo $verSolicitud['firmado'];?>" ><?php echo $verSolicitud['firmado'];?></option>    
                <option value= "NO" >NO</option>    
                <option value= "SI" >SI</option> 
              </select>
            </div>    
            <div class="w3-half">  
              <label>Observaciones</label>   
              <textarea maxlength="100" placeholder="Observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" name="observaciones" cols="30" rows="5"><?php echo $verSolicitud['observaciones'];?></textarea>
            </div>                 
            <br>     
            <div class="w3-row-padding w3-center ">
              <br> 
              <button name="EnviarFormulario" type="submit" id="EnviarFormulario" class="w3-btn w3-green">Actualizar Datos</button>
              <!-- <button name="Limpiar Formulario" type="reset" id="limpiarFormulario" class="w3-btn w3-red">Limpiar Formulario</button>   -->
            </div>   
            <br>            
          </div>
        </div>
        </p>
      </form>
    </div>
  </div>
  <?php 
} ?>

<br><br>

<?php require_once('../includes/footer.php'); ?>

<script src="../assets/jquery/jquery.min.js"></script>
<script src="../assets/select2/js/select2.min.js"></script>	
<style type="text/css" src="../css/modal.css"></style>
<script src="../js/registroPaciente.js" ></script>
<script src="../js/validarNumeros.js" ></script>

</body>
</html>