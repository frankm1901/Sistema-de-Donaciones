// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");
var overlayBg = document.getElementById("myOverlay");

let fechaNacimiento = document.getElementById('user_date')
    fechaNacimiento.addEventListener('onclick', verificarFechaNacimiento)
    fechaNacimiento.addEventListener('keyup', verificarFechaNacimiento)
    fechaNacimiento.addEventListener('change', verificarFechaNacimiento)
    
let fechaNacimientoPaciente = document.getElementById('user_date_pac')
    fechaNacimientoPaciente.addEventListener('onclick', verificarFechaNacimiento)
    fechaNacimientoPaciente.addEventListener('keyup', verificarFechaNacimiento)
    fechaNacimientoPaciente.addEventListener('change', verificarFechaNacimiento)

    
let edadSol = document.getElementById('edad_sol')    
let edadPac = document.getElementById('edad_pac')  
   
let fechaNac
let opcionFechaNac = false;

let divEdadSol = document.getElementById("div_edad_sol")
let divEdadPac = document.getElementById("div_edad_pac")

let limpiarFormulario = document.getElementById('limpiarFormulario')
let EnviarFormulario = document.getElementById('EnviarFormulario')

verificarFechaNacimiento(fechaNacimiento.value);
verificarFechaNacimiento(fechaNacimientoPaciente.value);

function cambiarCuerpo(){
  alert("Cambio de Cuerpo")
}

function verificarFechaNacimiento(){  
    if (fechaNacimiento.value != ''){
      fechaNac = fechaNacimiento.value
      opcionFechaNac = true
      calcularEdad(fechaNac)
    }  

    if (fechaNacimientoPaciente.value != ''){
      fechaNac = fechaNacimientoPaciente.value
      opcionFechaNac = false
      calcularEdad(fechaNac)
    }  
  }    

/** Funcion que devuelve true o false dependiendo de si la fecha es correcta.  */
function isValidDate(day,month,year){
    var dteDate;
    month=month-1;
    dteDate=new Date(year,month,day); 
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}
 
/* Funcion para validar una fecha */
function validate_fecha(fecha){
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");
    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        { return true;  }
    }
    return false;
}
 
/* Esta funci?n calcula la edad de una persona y los meses */
function calcularEdad(fechaNac){
  let fecha = fechaNac

  if(validate_fecha(fecha)==true){
        // Si la fecha es correcta, calculamos la edad
    let values=fecha.split("-"); let dia = values[2]; let mes = values[1]; let ano = values[0];
 
    // cogemos los valores actuales
    let fecha_hoy = new Date();  var ahora_ano = fecha_hoy.getYear(); var ahora_mes = fecha_hoy.getMonth()+1;
    let ahora_dia = fecha_hoy.getDate();
 
        // realizamos el calculo
    let edad = (ahora_ano + 1900) - ano; 
    if ( ahora_mes < mes ){edad--; }
    if ((mes == ahora_mes) && (ahora_dia < dia)){edad--;}
    if (edad > 1900) {edad -= 1900;}
    
    // calculamos los meses
    let meses=0;
    if(ahora_mes>mes) meses=ahora_mes-mes;
    if(ahora_mes<mes) meses=12-(mes-ahora_mes);
    if(ahora_mes==mes && dia>ahora_dia)  meses=11;
 
    // calculamos los dias
    let dias=0;
    if(ahora_dia>dia) dias=ahora_dia-dia;
    if(ahora_dia<dia) { 
      --meses;
      ultimoDiaMes=new Date(ahora_ano, ahora_mes, 0);
      dias=ultimoDiaMes.getDate()-(dia-ahora_dia);
    }
    //calculamos el ano si es bisiesto
    bisiesto = (ano % 4);
    
    if (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12){
      if (dia > ahora_dia ){dias = dias+1;}
    }else {
      if (mes == 4 || mes == 6 || mes == 9 || mes == 11){
        if (dia > ahora_dia ){dias = dias;}
      }
    }                

    if (mes==2){
      if (bisiesto==0){
        if (dia <= ahora_dia ){dias = dias;}
        if (dia > ahora_dia ){--dias;}        
      }else {       
        if (dia <= ahora_dia ){dias = dias;}
        else(dias= dias-2)
      }      
    }

    if (opcionFechaNac){
      if (edad<0){
        divEdadSol.innerHTML="La Edad no puede ser menor a 0 anoss";        
        $('#edad_pac').val('');
      }else{
        divEdadSol.innerHTML="";                
        $('#edad_sol').val(edad+" Años "+meses+" meses "+dias+" dias");// asignamos el valor a un textbox
      };
    }            
    if (opcionFechaNac == false){        
      if (edad<0){
        divEdadPac.innerHTML = "La Edad no puede ser menor a 0 anosss";          
        edadPac.value = ''
      }else{          
        divEdadPac.innerHTML="";
        edadPac.value = (edad+" Años "+meses+" meses "+dias+" dias");// asignamos el valor a un textbox
      };
    }    
  }  
  if(validate_fecha(fecha)==false){    
    if(opcionFechaNac){      
      edadSol.value = ("La fecha "+fecha+" es incorrecta");// asignamos el valor a un textbox            
      divEdadSol.innerHTML="Debe Ingresar una Fecha Valida / Fecha Superior a => 01-01-1900";$
    }
    if (!opcionFechaNac){
      edadSol.value = ("Laaaaa fecha "+fecha+" es incorrecta");// asignamos el valor a un textbox              
      divEdadPac.innerHTML="Debe Ingresar una Fecha Valida / Fecha Superior a => 01-01-1900";$
    }
  }
}



// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  let mySidebar = document.getElementById("mySidebar");
  let overlayBg = document.getElementById("myOverlay");

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

$(document).ready(function() {
  $('.js-example-basic-multiple').select2({
  placeholder: 'Seleccionar Requerimientos.'
  });
  $('.js-example-basic-multiple-localidad').select2({
    placeholder: 'Seleccionar Parroquia y Municipio...'
  });
  $('.js-example-basic-multiple-patologias').select2({
    placeholder: 'Seleccionar Patologias...'
  });
  $('.js-example-basic-multipleEditar').select2({    
    placeholder: 'Seleccionar Requerimiento...'
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

limpiarFormulario.addEventListener('click',  _ => {window.location.href = 'registro_paciente.php';})    

    