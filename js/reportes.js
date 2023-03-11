//Seccion para el despliegue de las Opciones segun el caso
let mostrarResueltos = document.getElementById('mostrarResueltos')
let mostrarNoResueltos = document.getElementById('mostrarNoResueltos')

//Seccion de las opciones a desplegar
let resueltos = document.getElementById('resueltos')
let noResueltos = document.getElementById('noResueltos')

//Seccion de los casos No Resuelto
let operadosPorCentrosDeSalud = document.getElementById('operadosPorCentrosDeSalud')
let operadosDetalladosPorPatologias = document.getElementById('operadosDetalladosPorPatologias')
let listadoCentrosDeSaludTodos = document.getElementById('listadoCentrosDeSaludTodos')
let listadoCentrosDeSalud = document.getElementById('listadoCentrosDeSalud') //Desplega el Select del centro de Salud
let resueltosDetallados = document.getElementById('resueltosDetallados')

//Seccion de los casos Resuelto
let noOperadosDetalladosPorPatologias = document.getElementById('noOperadosDetalladosPorPatologias')
let pendientesDetallados = document.getElementById('pendientesDetallados')
let pendientesDetalladosRequerimientos = document.getElementById('pendientesDetalladosRequerimientos')
let listadoRequerimientos = document.getElementById('listadoRequerimientos')
let operadosPorCentroDeSalud = document.getElementById('operadosPorCentroDeSalud')
let analiticaCentroDeSalud = document.getElementById('analiticaCentroDeSalud')

// Seccion asignada a cada uno de los Select
let sectionPatologias = document.getElementById('sectionPatologias')
let sectionRequerimiento = document.getElementById('sectionRequerimiento')
let sectionCentroDeSalud = document.getElementById('sectionCentroDeSalud')


//Escuchar los eventos de las opciones seleccionadas
mostrarResueltos.addEventListener('click', sectionResueltos)
mostrarNoResueltos.addEventListener('click', sectionNoResueltos)

//Seccion de los Resueltos
operadosPorCentrosDeSalud.addEventListener('click', desactivar)
operadosDetalladosPorPatologias.addEventListener('click', desactivar)
listadoCentrosDeSaludTodos.addEventListener('click', desactivar)
listadoCentrosDeSalud.addEventListener('click', activarCentroDeSalud)  // Desplega el Select de Centros de Salud
resueltosDetallados.addEventListener('click', desactivar)
operadosPorCentroDeSalud.addEventListener('click', desactivar)
analiticaCentroDeSalud.addEventListener('click', activarCentroDeSalud)


//Seccion de los No Resueltos
noOperadosDetalladosPorPatologias.addEventListener('click', desactivar)
pendientesDetallados.addEventListener('click', activarRequerimientos)
pendientesDetalladosRequerimientos.addEventListener('click', desactivar)
listadoRequerimientos.addEventListener('click', activarRequerimientos)


function prueba(){
  alert('hola mundo')
}

function sectionResueltos(){
  resueltos.style.display = 'block'
  noResueltos.style.display = 'none'  
}

function sectionNoResueltos(){
  resueltos.style.display = 'none'
  noResueltos.style.display = 'block'
  desactivar()
}
 
function desactivar(){
  sectionPatologias.style.display =  'none';
  patologias.disabled =  false;  
  sectionRequerimiento.style.display =  'none';
  requerimientos.disabled = false;  
  sectionCentroDeSalud.style.display =  'none';
  centroDeSalud.disabled =  false;
}
 

function activarPatologia(){
  sectionPatologias.style.display =  'block';
  patologias.disabled =  false;
  
  sectionRequerimiento.style.display =  'none';
  requerimientos.disabled = true;
  
  sectionCentroDeSalud.style.display =  'none';
  centroDeSalud.disabled =  true;
}

function activarRequerimientos(){
  sectionPatologias.style.display =  'none';
  patologias.disabled =  true;
  
  sectionRequerimiento.style.display =  'block';
  requerimientos.disabled = false;
  
  sectionCentroDeSalud.style.display =  'none';
  centroDeSalud.disabled =  true;
}

function activarCentroDeSalud(){   
  sectionCentroDeSalud.style.display =  'block';
  centroDeSalud.disabled =  false;
}

function validateFechaRequer() {  
  if(document.getElementById('RequerFechaInicio').value <= document.getElementById('RequerFechaFinal').value)     
    {document.Requerimientos.BotonRequerimientos.disabled=false;    
    document.getElementById("div_fecha_requer").innerHTML=""; }
  else    
    {document.Requerimientos.BotonRequerimientos.disabled=true;
    document.getElementById("div_fecha_requer").innerHTML="Error - Fecha Errada o Fecha Inicial mayor a la Fecha Final";
    }    
  }


  function validateFecha() {  
  if(document.getElementById('FechaInicio').value <= document.getElementById('FechaFinal').value)     
    {document.Solicitudes.BotonRequerimientos2.disabled=false;    
    document.getElementById("div_fecha").innerHTML=""; }
  else    
    {document.Solicitudes.BotonRequerimientos2.disabled=true;
    document.getElementById("div_fecha").innerHTML="Error - Fecha Errada o Fecha Inicial mayor a la Fecha Final";
    }
  }