function activar(){     
    document.getElementById('Requerimiento').value = document.getElementById('requerimientos').value;
    document.getElementById('EnviarRequerimiento').removeAttribute('disabled');
    document.getElementById('Requerimiento').removeAttribute('disabled');
  }