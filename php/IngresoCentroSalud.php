<?php include '../Connections/conexion.php';?>

<?php 
  echo "<br> Tipo Requerimiento: ".$TipoCentro = $_POST['TipoCentro'];
  echo "<br>  Centro de Salud: ".$centroSalud = $_POST['centroSalud'];
  echo "<br>  parroquia: ".$parroquia = $_POST['parroquia'];
  echo "<br> <br> <br> ";

    // Verificar si la Patologia Existe para no insertarla nuevamente

$verificar = $conexion -> prepare("SELECT * FROM redsalud where nombre_redsal = '$centroSalud'");

//$verificar->bindParam(':nombre_redsal', $centroSalud);
$verificar->execute();
$ver = $verificar -> fetchColumn();

echo "la cantidad de registros es: ".$ver."<br>";


if ($ver == 0 ) 
{       echo "No hay registros coincidentes: <br>";
    $consulta = $conexion->  prepare("INSERT INTO redsalud (nombre_redsal, id_tiporedsal, id_localidades2)VALUES (?,?,?);");
    if ($consulta -> execute([$centroSalud, $TipoCentro, $parroquia]))
          {echo "<br>Datos guardados correctamente";
            header("Location: centroDeSalud.php");
          }else {
                echo "<br>Datos no almacenados correctamente";
                }

                //print_r ($consulta-> fetchAll());            
}


?>
  
