//========================
//CREACION DEL OBJETO AJAX
//========================
function objetoAjax(){
    var xmlhttp=false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
           xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
 
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
 
 
//==========================================================
function enviar_personas(){
    divResultado = document.getElementById('resultados');
    nombre = document.getElementById('obj_text').value;
 
    ajax=objetoAjax();
    ajax.open("POST", "accion.php");
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("nombre_pac="+nombre_pac)
}