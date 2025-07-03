<?php 
$dbname = "bdceecc";
$dbuser = "root";
$dbhost = "localhost";
$dbpass = 'root';
      $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);  
      $id_eva = $_REQUEST['id'];
      $upda = "UPDATE poligrafia_evnu SET reexaminacion = '1' WHERE id_evaluacion = '$id_eva'";
      $resed = mysqli_query($conexion, $upda);
                               ?>