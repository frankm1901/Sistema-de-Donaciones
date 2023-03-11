<?php include '../Connections/conexion.php';?>

<?php 
  echo "<br> Tipo Requerimiento: ".$TipoReq = $_POST['TipoReq'];
  echo "<br>  Requerimiento: ".$requerimiento = $_POST['Requerimiento'];
  echo "<br> <br> <br> ";

  
  echo "<br>****************************<br><br>";

  // Verificar si la Patologia Existe para no insertarla nuevamente

$verificar = $conexion -> prepare("SELECT * FROM donaciones where nombre_donaci = :requerimiento;");

$verificar->bindParam(':requerimiento', $requerimiento);
$verificar->execute();
$ver = $verificar -> fetchColumn();

echo "la cantidad de registros es: ".$ver."<br>";


if ($ver == 0 ) 
{       echo "No hay registros coincidentes: <br>";
    $consulta = $conexion->  prepare("INSERT INTO donaciones (nombre_donaci, id_tipdon1)VALUES (?,?);");
    if ($consulta -> execute([$requerimiento, $TipoReq]))
          {echo "<br>Datos guardados correctamente";
          }else {
                echo "<br>Datos no almacenados correctamente";
                }

                //print_r ($consulta-> fetchAll());            
}

header("Location: Requerimiento.php");
?>
  
