<?php session_start(); ?>
<!DOCTYPE html>
     <html>
     <head>
     	<title></title>
     </head>

    <link rel="stylesheet" href="css/stylesheet.css">

<!-- jquery -->
<script src="assets/jquery/jquery.min.js"></script>
<script >
    
function activarButton() {  

    if(document.getElementById('patologias').value)     
    {document.solicitud.EnviarFormulario.disabled=false; }
  else    
    {document.solicitud.EnviarFormulario.disabled=true;         
    }  
   
  };

</script>

<!--select2-->
<link rel="stylesheet" href="assets/select2/css/select2.min.css">
<script src="assets/select2/js/select2.min.js"></script>	

     <body>

<?php include ('../Connections/conexion.php'); ?>
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
<select class="js-example-basic-multiple" required="required" id="patologias" onclick="activarButton()" onclick="EnviarFormulario.disabled=true " style="width:100%;" name="patologias[]" multiple="multiple">
  <option>  </option>
    <?php 
    while($misdatos = mysqli_fetch_assoc($resultado)){ $contador++;?>
    <option value="<?php echo $misdatos['patologia']; ?>"><?php echo $misdatos['patologia']; ?></option>
    <?php }?>   
</select>
</p>
</div>

</body>
<script>
     $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
  placeholder: 'Seleccionar Patologias...'
});
});

 </script>
     
     </html>