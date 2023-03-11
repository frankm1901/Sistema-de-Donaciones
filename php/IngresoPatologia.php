<?php include '../Connections/conexion.php';?>

<?php  
 echo $Patologia = $_POST['patologia'];
 echo "<br><br><br>";


  // Verificar si la Patologia Existe para no insertarla nuevamente

$verificar = $conexion -> prepare("SELECT * FROM patologias where patologia = :Patologia;");

$verificar->bindParam(':Patologia', $Patologia);
$verificar->execute();

$ver = $verificar -> fetchAll();

foreach ($ver as $dato){
  echo "<br> EL datos es: ".$dato['1'];

}

if ($ver == NULL ) 
{  echo "<br><br><br><br>Entro Aca Aca Aca Aca Aca Aca <br><br><br>";

        $consulta =  $conexion -> prepare("INSERT INTO patologias (patologia)values (?);");
        if ($consulta -> execute ([$Patologia]))
            {echo "<br><br><br>Patologia insertada con exito";
            }else {
                    echo "<br><br><br>Error al insertar la Patologia";
                  };
  
}else {echo "<br><br><br>entro en el else por que hay registros coincidentes";}
header("Location: Patologias.php");
?>
  
