let  primero = document.getElementById('primero')
let  segundo = document.getElementById('segundo')
let  final = document.getElementById('final')
let  myTop = document.getElementById("myTop")
let  myIntro = document.getElementById("myIntro")



function mostrarMensaje() {
  primero.style.display = 'block';  
  //llamas a la funcion 2 luego de 3 segundos
  setTimeout(ocultarMensaje,2000);
}

function ocultarMensaje(){       
  segundo.style.display = 'block';
  //llamas a la funcion 3 luego de 3 segundos
  setTimeout(mifuncion3,4000);
}

  function mifuncion3(){          
    primero.style.display = 'none';
    segundo.style.display = 'none';
    final.style.display = 'block';
}

setTimeout(mostrarMensaje,1000);

// Change style of top container on scroll
window.onscroll = function() {myFunction()};
function myFunction() 
{
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) 
    {
        myTop.classList.add("w3-card-4", "w3-animate-opacity");
        myIntro.classList.add("w3-show-inline-block");
    } else {
        myIntro.classList.remove("w3-show-inline-block");
        myTop.classList.remove("w3-card-4", "w3-animate-opacity");
        }
}
