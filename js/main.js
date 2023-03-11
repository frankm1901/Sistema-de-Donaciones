$(buscar_datos());
function buscar_datos(){
    $.ajax({
        url: 'php/buscarcliente.php',
        type: 'POST',
        datatype: 'html',
        data: {consulta: consulta},        
    })
    .done(function(respuesta){
        $("#datos").html(respuesta);        
    })
    .fail(function(){
        console.log("error");
    })
}