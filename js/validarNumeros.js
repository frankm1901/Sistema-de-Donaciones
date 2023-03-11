function validarCosto(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789$bs.,";
  tecla_especial = false
 
  if(letras.indexOf(tecla)==-1 && !tecla_especial)
  return false;
}

function validarCedula(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789";
  tecla_especial = false
 
  if(letras.indexOf(tecla)==-1 && !tecla_especial)
  return false;
}

function validarTelefonos(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789,";
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

function activar(){
  document.getElementById('cedulaPaciente').disabled = false;
}