<!DOCTYPE html>
     <html>
     <head>
     	<title></title>
     </head>

    <link rel="stylesheet" href="css/stylesheet.css">

<!-- jquery -->
<script src="assets/jquery/jquery.min.js"></script>

<!--select2-->
<link rel="stylesheet" href="assets/select2/css/select2.min.css">
<script src="assets/select2/js/select2.min.js"></script>	

     <body>

<?php include ('../Connections/conexion.php'); ?>

 <div><p> 
          <label class="w3-margin-left">Requerimientos</label>  
        </p></div>
            <?php 
            // Consulta para seleccionar los elementos de la tabla DONACIONES
            $consulta = "SELECT * FROM donaciones";
            $resultado = mysqli_query($mysqli , $consulta);
            $contador=0;
            ?>     

<div class="w3-row-padding">
<select class="js-example-basic-multiple" required style="width:100%;" id="requerimientos" name="requerimientos[]" multiple="multiple">
  <option>  </option>
    <?php 
    while($misdatos = mysqli_fetch_assoc($resultado)){ $contador++;?>
    <option value="<?php echo $misdatos['nombre_donaci']; ?>"><?php echo $misdatos['nombre_donaci']; ?></option>
    <?php }?>   
</select>
</p>
</div>


</body>
<script>
     $(document).ready(function() {
    $('.js-example-basic-multiple').select2({
  placeholder: 'Seleccionar requerimientos...'
});
});

 </script>
     
     </html>