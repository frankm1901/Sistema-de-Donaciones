let donaciones = document.getElementById('donaciones')
let redsalud = document.getElementById('redsalud')
let selectStatus = document.getElementById('status') 
    selectStatus.addEventListener('click', cambiarDpto);

let redsaludDiv = document.getElementById('redsaludDiv')
let departamentoDiv = document.getElementById('departamentoDiv')
let donacionesDiv = document.getElementById('donacionesDiv')
let costoDiv = document.getElementById('costoDiv')

let ingresoStatus = document.getElementById('ingresoStatus')
let identificador = document.getElementById('identificador')

function cambiarDpto(){  
  if(selectStatus.value == 9){     
    redsaludDiv.style.display = 'block'    
    donacionesDiv.style.display = 'block'
    costoDiv.style.display = 'block'    
    redsalud.removeAttribute('disabled', '');
    donaciones.removeAttribute('disabled', '');
    costo.removeAttribute('disabled', '');
  }else if(selectStatus.value == 7){      
      redsaludDiv.style.display = 'block'
      costoDiv.style.display = 'block'
      donacionesDiv.style.display = 'none'
      redsalud.removeAttribute('disabled', ''); 
      donaciones.setAttribute('disabled', '');       
      costo.removeAttribute('disabled', ''); 
    }else{
      redsaludDiv.style.display = 'none'    
      donacionesDiv.style.display = 'none'  
      costoDiv.style.display = 'none'
      donaciones.setAttribute('disabled', '');    
      redsalud.setAttribute('disabled', '');
      costo.setAttribute('disabled', '');
      departamento.setAttribute('disabled', '');
    }  
  if(selectStatus.value == 6){ 
    departamentoDiv.style.display = 'block'               
    departamento.removeAttribute('disabled', '');
    costo.setAttribute('disabled', '');
  }else{departamentoDiv.style.display = 'none'   
      }      
}

if (identificador.value = 'si'){
  ingresoStatus.style.display = 'none'
}