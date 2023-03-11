<?php 
/* DATABASE CONFIGURATION */
/*

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'sisdossz');



$Server = DB_USERNAME;
$Username = DB_USERNAME;
$Password = DB_PASSWORD;
$Database = DB_DATABASE;
*/

$Server = '192.168.1.12';
$Username = 'SSZulia';
$Password = 'Ssz2022.-';
$Database = 'sisdo';



  try 
    {
      //Conexion a PostgreSql
      $conexion = new PDO('pgsql:host='.$Server.'; port=5432; dbname='.$Database, $Username, $Password);   
      //echo 'Connection Exitoso'; 
      
      //Conexion a MySql
      //$conexion = new PDO('mysql:host='.DB_SERVER.'; dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));       
     // return $conexion;        
    }
    catch (PDOException $error) 
      {
        echo 'Connection failed: '. $error-> getMessage(); 
        echo "<br><br> Error en  la conexion ";
      }
?>

