let patologias = document.getElementById('patologias')
let patologia = document.getElementById('patologia')
let EnviarPatologia = document.getElementById('EnviarPatologia')

patologias.addEventListener('change', activar)



function activar(){    
    let valor = patologias.options[patologias.selectedIndex].text;
    console.log(valor)
    patologia.value = valor
    EnviarPatologia.removeAttribute('disabled');
    patologia.removeAttribute('disabled');

  }