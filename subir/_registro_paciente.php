<!-- Insercion de Nuevos Registros Datos precargados desde la base de datos -->
<html lang="en">
<head>

<link rel="stylesheet" href="css/stylesheet.css">

<!-- jquery -->
<script src="assets/jquery/jquery.min.js"></script>

<!--select2-->
<link rel="stylesheet" href="assets/select2/css/select2.min.css">
<script src="assets/select2/js/select2.min.js"></script>	
<style>
/* una pequeña animación extra */
@keyframes modal{0%{opacity:0;-webkit-transform:scale3d(.3,.3,.3);transform:scale3d(.3,.3,.3)}50%{opacity:1}}
/* estilo del contenedor padre */
.modal {
position: relative;
max-width: 400px;
z-index: 15;
color: #5A5A5A;
padding: 10px;
font: 13px/140% "Open Sans", Helvetica, Arial, sans-serif;
}
/* estilo del fondo */
#modal-back {
position: fixed;
opacity: 0.8;z-index: 14;
background: #000000;
top: 0;
left: 0;
right: 0;
bottom: 0;
margin: auto;
}
/* estilo de contenedor */
.modal {
top: 50%;
left: 50%;
-webkit-transform:translate(-50%,-50%);
-ms-transform:translate(-50%,-50%);
transform:translate(-50%,-50%);
}
/* estilo de subcontenedor */
#modal-c {
height: 100%;
position: relative;
background: #fff;
-webkit-animation: modal 500ms cubic-bezier(0.215, 0.61, 0.355, 1) 250ms backwards;
animation: modal 500ms cubic-bezier(0.215, 0.61, 0.355, 1) 250ms backwards;
border-radius: 4px;
-webkit-box-shadow: 0 0px 7px rgba(0, 0, 0, 0.5);
box-shadow: 0 0px 7px rgba(0, 0, 0, 0.5);
}
/* estilo de títulos */
.modal h3 {
padding: 15px 0px;
text-align: center;
}
/* estilo de contenido */
.modal span {
display: block;padding: 0px 19px;
}
/* estilo de botones */
#buttons {
position: absolute;
right: 0;
bottom: 0;
padding: 3px 0px;
}
#buttons a{
height: 100%;padding: 7px 15px;
color: #3C6998;
display: inline-block;
text-decoration: none;}
</style>
</head>
<body>
<?php require_once('includes/header.php');?>
<?php require_once('Connections/conexion.php'); ?>


<script language="javascript" ></script>

    <script language="javascript">
    /*  $(document).ready(function(){
        $("#cbx_estado").change(function () {

          $('#cbx_localidad').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
          
          $("#cbx_estado option:selected").each(function () {
            id_estado = $(this).val();
            $.post("includes/getMunicipio.php", { id_estado: id_estado }, function(data){
              $("#cbx_municipio").html(data);
            });            
          });
        })
      });
      */
      $(document).ready(function(){
        $("#cbx_municipio").change(function () {
          $("#cbx_municipio option:selected").each(function () {
            id_municipio = $(this).val();
            $.post("includes/getLocalidad.php", { id_municipio: id_municipio }, function(data){
              $("#cbx_localidad").html(data);
            });            
          });
        })
      });
    </script>

  <script type="text/javascript">
//Inicio de las Funciones para calcular la edad del Paciente

/** Funcion que devuelve true o false dependiendo de si la fecha es correcta.  */
function isValidDate(day,month,year)
{
    var dteDate;
    month=month-1;
    dteDate=new Date(year,month,day); 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}
 
/**
 * Funcion para validar una fecha
 */
function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
 
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        { return true;  }
    }
    return false;
}
 
/**
 * Esta funci?n calcula la edad de una persona y los meses
 */
function calcularEdad()
{
    var fecha=document.getElementById("user_date").value;
    if(validate_fecha(fecha)==true)
    {
        // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-"); var dia = values[2]; var mes = values[1];
        var ano = values[0];
 
        // cogemos los valores actuales
        var fecha_hoy = new Date();  var ahora_ano = fecha_hoy.getYear(); var ahora_mes = fecha_hoy.getMonth()+1;
        var ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < mes ){edad--; }
        if ((mes == ahora_mes) && (ahora_dia < dia)){edad--;}
        if (edad > 1900) {edad -= 1900;}
    if (edad<18){$("#cedula_rep").prop('disabled', false);
            $("#telefono_rep").prop('disabled', false);
            $("#nombre_rep").prop('disabled', false);
            $("#apellido_rep").prop('disabled', false);}

    if (edad>17){$("#cedula_rep").prop('disabled', true);
            $("#telefono_rep").prop('disabled', true);
            $("#nombre_rep").prop('disabled', true);
            $("#apellido_rep").prop('disabled', true);}

     if (edad<0){document.getElementById("div_edad_pac").innerHTML="La Edad no puede ser menor a 0 anos";$("#EnviarFormulario").prop('disabled', true);}
     else{document.getElementById("div_edad_pac").innerHTML="";$("#EnviarFormulario").prop('disabled', false);}
      ;
        // calculamos los meses
        var meses=0;
        if(ahora_mes>mes) meses=ahora_mes-mes;
        if(ahora_mes<mes) meses=12-(mes-ahora_mes);
        if(ahora_mes==mes && dia>ahora_dia)  meses=11;
 
        // calculamos los dias
        var dias=0;
        if(ahora_dia>dia) dias=ahora_dia-dia;
        if(ahora_dia<dia) {
            ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
            dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
                }
 
//      document.getElementById("edad_pac").innerHTML="Tienes "+edad+" a?os, "+meses+" meses y "+dias+" d?as";//para asignar el valor a una etiqueta div
    $('#edad_pac').val(edad+" anos "+meses+" meses "+dias+" dias");// asignamos el valor a un textbox

    
    }else{
    $('#edad_pac').val("La fecha "+fecha+" es incorrecta");// asignamos el valor a un textbox
      //document.getElementById("edad_pac").innerHTML="La fecha "+fecha+" es incorrecta";//para asignar el valor a una etiqueta div
    document.getElementById("div_edad_pac").innerHTML="Debe Ingresar una Fecha Valida / Fecha Superior a => 01-01-1900";$("#EnviarFormulario").prop('disabled', true);
    }
}
</script>
<script>

//funcion para validar los numeros

function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [8,37,39,46];
 
    tecla_especial = false
    for(var i in especiales){
 if(key == especiales[i]){
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
}
</script>

<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();  
$usuario = $_SESSION['MM_Username'];
}

?>
<?php
//Consulta select de los estados    
  /*$query = "SELECT id_estado, estado FROM t_estado ORDER BY estado";
  $resultado=$mysqli->query($query);
  */
  ?>
<?php

// Consulta y verificacion de inicio de sesion 
$colname_ingresado_por = "-1";
if (isset($_SESSION['usuario'])) {
  $colname_ingresado_por = $_SESSION['usuario'];
} ?>

<?php   //***********INICIO DEL CUERPO DEL PROGRAMA******************* ?>

<?php
/* verificar la conexi?n */
if (mysqli_connect_errno()) {
    printf("Conexion fallida: %s\n", mysqli_connect_error());
    exit();}
if ($resultadosolici = mysqli_query($mysqli, "SELECT id_solici FROM solicitud")) {
    /* determinar el n?mero de filas del resultado */
    $row_solici = mysqli_num_rows($resultadosolici);
    $row_solici = $row_solici+ 1; }
?>

<?php
// Variable para asignar la fecha actual
$fecha = date("Y-m-d");
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:245px;margin-top:43px;">

  <!--HEADER-->
  <div id="myTop" class="w3-container w3-top w3-large" style="background:#3385ff;padding:4px 2px">
    <br><br><h4><span id="myIntro" class="w3-hide w3-margin-left w3-text-white">Nueva Solicitud Paciente</span></h4>
  </div>
  
  <header class="w3-container" style="background:#3385ff;padding:12px 15px">
    <h1 class="w3-xxxlarge w3-text-white">Nueva Solicitud Paciente</h1></b>
  </header>
  
  <!-- INICIO DE LA RESTRICCION DE LA PAGINA - SOLO PERSONAL AUTORIZADO 
  ***************************************************************************************************** -->


  <?php 
  //CONSULTAS
  $seleccion = $_GET['seleccion'];
  

//Consulta para la Tabla Paciente
  $ConsultaSolicitud = "SELECT DISTINCT id_solici, numero_solici, requerimientos_solici, edad_pac, fec_nac_pac, cedula_pac, nombre_pac, apellido_pac, sector_pac, telefono1_pac, telefono2_pac, cedula_rep, nombre_rep, apellido_rep, telefono_rep, localidad, municipio, estado, nombre_login, apellido_login, nombre_redsal, observaciones_status
FROM (((((((((solicitud as sol 
INNER JOIN paciente as pac ON pac.id_pac = sol.id_pac1) 
LEFT JOIN union_pac_rep as uni ON uni.id_pac1 = pac.id_pac) 
LEFT JOIN representante as rep ON rep.id_rep = uni.id_rep1) 
INNER JOIN t_localidad as parroq ON parroq.id_localidad = sol.id_localidad1)
INNER JOIN t_municipio as munici ON munici.id_municipio = parroq.id_municipio) 
INNER JOIN t_estado as est ON est.id_estado = munici.id_estado)
INNER JOIN login as log ON log.id_login = sol.id_login)
INNER JOIN redsalud as red ON red.id_redsal = sol.id_redsal1)
LEFT JOIN status as status ON status.id_solici1 = sol.id_solici)
WHERE id_solici = '$seleccion'";

$ResultadoSolicitud = mysqli_query($mysqli , $ConsultaSolicitud); // se ejecuta la consulta
$ver = mysqli_fetch_assoc($ResultadoSolicitud);// se extraen todos los datos del Id seleccionado
  
   ?>

<?php if ($_SESSION['Id_Dep'] == 1 xor $_SESSION['Id_Dep'] == 3 or $_SESSION['Id_Dep'] == 5)
{ ?>  
  <br><br>
  <div class="w3-container w3-content w3-margin-right">
    <div class="w3-col s12 l8">
      <form class="w3-container" method="post" action="ingreso_paciente.php">
      <br>
      <div class="w3-row-padding">
          <div class="w3-half"><p>  
           <label>Fecha de Ingreso</label>   
           <input name="fecha_ingreso" readonly="readonly" type="text" id="fecha_ingreso" value = <?php print ($fecha); ?> class="w3-input w3-border w3-hover-gray"></p></div>
          
          <div class="w3-half"><p>  
           <label>Ingresado Por</label>   
           <input name="Ingresado_por" type="text" id="Ingresado_por" readonly="readonly" class="w3-input w3-border w3-hover-gray" type="text" value="<?php echo($_SESSION['Nombre']." ".$_SESSION['Apellido']) ?>">
           </p></div>
        </div>       
    </div>
  </div>
  <br><br>
  <div class="w3-container w3-content w3-margin-right">
    <div class="w3-card-4 w3-col s12 l8">
      <div class="w3-container w3-teal">
        <h2>Datos del Paciente</h2>
      </div>
      
        <p><br>  
        <label class="w3-margin-left" >C&eacute;dula</label>
        
        <input maxlength="12" placeholder="Cedula del Solicitante" value="<?php echo $ver['cedula_pac'] ?>" name="cedula_pac" style="width: 95%" type="text" id="cedula_pac" onkeyup="javascript:verificar_paciente()" onKeyPress="return numeros(event)" class="w3-input w3-content w3-border w3-hover-gray" type="text"></p>
      
        <div class="w3-row-padding">
          <div class="w3-half"><p>  
           <label>Nombre</label>   
           <input maxlength="30" placeholder="Nombre del Solicitante" value="<?php echo $ver['nombre_pac'] ?>" name="nombre_pac" type="text" id="nombre_pac" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
          <div class="w3-half"><p>  
           <label>Apellido</label>   
          <input maxlength="30" placeholder="Apellido del Solicitante" value="<?php echo $ver['apellido_pac'] ?>" name="apellido_pac" type="text" id="apellido_pac" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
        </div>  
        
        <div class="w3-row-padding">
          <div class="w3-half"><p>  
           <label>Fecha de Nacimiento</label>   
           <input min="1900-01-01" max="<?php echo $fecha; ?>"" type="date" value="<?php echo $ver['fec_nac_pac'] ?>" name="user_date" id="user_date" onkeyup="javascript:calcularEdad()" onclick="javascript:calcularEdad()" required class="w3-input w3-border w3-hover-gray" type="text"></p></div>
          <div class="w3-half"><p>  
           <label>Edad</label>
          <input placeholder="Edad" name="edad_pac" value="<?php echo $ver['edad_pac'] ?>" type="text" id="edad_pac" size="24" readonly="readonly" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
        </div>
        <div class="w3-row-padding">
        <div id="div_edad_pac" style="background: red" ></div>  
        </div>
        
        <div class="w3-row-padding">
          <div class="w3-half"><p>  
           <label>Teléfono 1</label>   
           <input maxlength="11" placeholder="Telefono Nº 1" value="<?php echo $ver['telefono1_pac'] ?>" name="telefono1_pac" type="text" required id="telefono1_pac" onKeyPress="return numeros(event)" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
          <div class="w3-half"><p>  
           <label>Teléfono 2</label>   
          <input maxlength="11" placeholder="Telefono Nº 2" value="<?php echo $ver['telefono2_pac'] ?>" name="telefono2_pac" type="text" id="telefono2_pac" onKeyPress="return numeros(event)" class="w3-input w3-border w3-hover-gray" type="text"></p></div>
        </div>
        <div class="w3-row-padding">
        <div class="w3-row-padding">          
          <div class="w3-half"><p>
            <label>Municipio</label>    
            <select name="cbx_municipio" id="cbx_municipio" required="required" class="w3-select w3-border">
              <option value="" disabled selected>Seleccionar Municipio</option>
                <?php  $queryM = "SELECT id_municipio, municipio FROM t_municipio ORDER BY municipio";
                $resultadoM = $mysqli->query($queryM);  ?> 
                <?php  while ($rowM = $resultadoM->fetch_assoc()) {  ?>
                <option value="<?php echo $rowM['id_municipio']; ?>" > <?php echo $rowM['municipio']; ?></option>
                <?php }    ?> 
          </select></p></div>
        <div class="w3-half"><p>
          <label>Parroquia</label>    
          <select name="cbx_localidad" id="cbx_localidad" required="required" class="w3-select w3-border">
           <option value="" disabled selected>Seleccionar Parroquia</option>
          </select></p></div>
        </div>
        <p>




        <p>
        <label class="w3-margin-left" >Sector</label>

        <input maxlength="80" placeholder="Sector de Residencia" value="<?php echo $ver['sector_pac'] ?>" name="sector_pac" id="sector_pac" style="width: 95%" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"  type="text" class="w3-input w3-border w3-hover-gray w3-content" ></p>      
        
          <br>
    </div>
      
    </div>
  </div>
  <br><br>
  <div class="w3-container w3-content w3-margin-right">
    <div class="w3-card-4 w3-col s12 l8">
      <div class="w3-container w3-indigo">
        <h2>Datos del Representante</h2>
      </div>
      
      <br>
      <div class="w3-row-padding">        
        <input name="activa" id="activa1" onblur="compare()" onclick="cedula_rep.disabled=true, telefono_rep.disabled= true, nombre_rep.disabled=true, apellido_rep.disabled=true" class="w3-check w3-margin-left w3-margin-top" type="radio">
        <label class="w3-margin-left">Activar</label>      <label class="w3-margin-left">Solicitante es Menor de Edad / Embarazo Precoz</label>  <br>  
        <!--<label class="w3-margin-left">Desactivar</label>      
        <input name="activa" id="activa1" onblur="compare()" onclick="cedula_rep.disabled=false, telefono_rep.disabled= false, nombre_rep.disabled=false, apellido_rep.disabled=false" class="w3-check w3-margin-left w3-margin-top" type="radio">
      -->
      </div>
      <div class="w3-row-padding">
          <div class="w3-half"><p>  
           <label>C&eacute;dula</label>   
           <input maxlength="12" placeholder="Cedula del Representante" value="<?php echo $ver['cedula_rep'] ?>" name="cedula_rep" type="text" id="cedula_rep" onKeyPress="return numeros(event)" required class="w3-input w3-border w3-hover-gray"></p></div>
          <div class="w3-half"><p>  
           <label>Teléfono</label>   
          <input maxlength="11" placeholder="Telefono" value="<?php echo $ver['telefono_rep'] ?>" name="telefono_rep" type="text" id="telefono_rep" onKeyPress="return numeros(event)" required class="w3-input w3-border w3-hover-gray"></p></div>
      </div>  
      <div class="w3-row-padding">
          <div class="w3-half"><p>  
           <label>Nombre</label>   
           <input maxlength="30" placeholder="Nombre del Representante" value="<?php echo $ver['nombre_rep'] ?>" name="nombre_rep" type="text" id="nombre_rep" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></p></div>
          <div class="w3-half"><p>  
           <label>Apellido</label>   
          <input maxlength="30" name="apellido_rep" placeholder="Apellido del Representante" value="<?php echo $ver['apellido_rep'] ?>" type="text" id="apellido_rep" required onKeyup="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray"></p></div>
      </div>  
        <br>
      
    </div>
  </div>
  <br><br>
  <div class="w3-container w3-content w3-margin-right">
    <div class="w3-card-4 w3-col s12 l8">
      <div class="w3-container w3-blue-gray">
        <h2>Solicitudes</h2>
      </div>
      
      <br>


      <div class="w3-row-padding">
<!--************************************************************************************************-->
          <div><p> 
          <label class="w3-margin-left">Patologías</label>  
        </p></div>
            <?php 
            // Consulta para seleccionar los elementos de la tabla DONACIONES
            $consulta = "SELECT patologia FROM patologias order by patologia";
            $resultado = mysqli_query($mysqli , $consulta);
            $contador=0;
            ?>     

<div class="w3-row-padding">
  <?php $hola = "holagente"; ?>
<select class="js-example-basic-multiple" required="required" style="width:100%;" name="patologias[]" multiple="multiple">
  <option>  </option>
    <?php 
    while($misdatos = mysqli_fetch_assoc($resultado)){ $contador++;?>
    <option value="<?php echo $misdatos['patologia']; ?>"><?php echo $misdatos['patologia']; ?></option>
    <?php }?>   
</select>
</p>
</div>
 
<!--************************************************************************************************-->

          <div><p> 
          <label class="w3-margin-left">Requerimientos</label>  
        </p></div>
            <?php 
            // Consulta para seleccionar los elementos de la tabla DONACIONES
            $consulta = "SELECT * FROM donaciones";
            $resultado = mysqli_query($mysqli , $consulta);
            $contador=0;
            ?>     

<div class="w3-row-padding">
<select class="js-example-basic-multiple" required style="width:100%;" name="requerimientos[]" multiple="multiple">
  <option>  </option>
    <?php 
    while($misdatos = mysqli_fetch_assoc($resultado)){ $contador++;?>
    <option value="<?php echo $misdatos['nombre_donaci']; ?>"><?php echo $misdatos['nombre_donaci']; ?></option>
    <?php }?>   
</select>
</p>
</div>


 <div class="w3-half"><p> 
            <label>Status</label>    
            <select name="status" id="status" required class="w3-select w3-border">
            <option value="" disabled selected required >Seleccionar Status</option>             
               <?php
                //Consulta para seleccionar la Definicion del Status
                $consultaDefStatus = "SELECT * FROM definicion_status";
                $resultadoDefStatus = mysqli_query($mysqli , $consultaDefStatus);
                $contador=0;
                ?>     
                <?php 
                  while($miDefStatus = mysqli_fetch_assoc($resultadoDefStatus)){ $contador++;?>
                  <option value="<?php echo $miDefStatus['id_defsta']; ?>"><?php echo $miDefStatus['nombre_defsta']; ?></option>
                <?php }?>  
              
          </select></p> 
      
          </div>
<!--************************************************************************************************-->


          <div class="w3-half"><p>  
           <label>Observaciones</label>   
           <textarea maxlength="150" placeholder="Observaciones" id="observaciones" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" class="w3-input w3-border w3-hover-gray" name="observaciones" cols="30" rows="5"></textarea></p></div>
        </div>  
        <br> 
        <div class="w3-center">
        <button name="EnviarFormulario" type="submit" id="EnviarFormulario" class="w3-btn w3-green">Registrar Solicitud</button>
        <button name="Limpiar Formulario" type="reset" id="Limpiar Formulario" class="w3-btn w3-red">Limpiar Formulario</button>
        </div>   
        <br>
      </form>
    </div>
  </div>
</div>
<?php 
}else{//FIN DE LA RESTRICCION DEL REQUERIMIENTO
?>
<div id="modal"> <!-- padre -->
  <div id="modal-back"></div> <!-- fondo -->
  <div class="modal" class="w3-col s5 l5">
      <div id="modal-c" > <!-- subcontenedor -->
       <br>
       <div class="w3-container">
        <div class='w3-content w3-center w3-text-red'><i class='w3-jumbo fa fa-warning'></i></div><br>
           <h2 class="w3-center w3-margin-top">NO TIENE PRIVILEGIOS SUFICIENTES</h2>
               <h2 class="w3-center w3-margin-top">PARA REGISTRAR SOLICITUDES DE PACIENTES</h2>           
       </div>
       <h4 style="font-family: Arial;" class="w3-center w3-margin-top w3-margin-bottom">CONTACTE CON EL ADMINISTRADOR DEL SISTEMA</h4>
       <div class="w3-center w3-margin-top w3-margin-bottom">
           <button name="EnviarFornulario" type="submit" class="w3-btn w3-blue w3-center w3-margin-top w3-margin-bottom"><a id="mclose" href="dashboard.php">Continuar</a></button>
         <br>
       </div>
    </div> <!-- contenedor -->
  </div>    
</div>
<?php 
}
?>

<br><br>
<?php require_once('includes/footer.php'); ?>
</body>
</html>

<script>
     $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
  placeholder: 'Seleccionar Requerimientos unicos...'
});
});

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

// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}

</script>

</body>
</html>