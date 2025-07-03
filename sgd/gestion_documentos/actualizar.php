<?php 
$dbname = "bdceecc";
$dbuser = "root";
$dbhost = "localhost";
$dbpass = 'root';
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);  
$id_eva = $_REQUEST['id'];
$sql_areas = "SELECT id_area FROM areas_dependencias order by id_area desc";
$resul = mysqli_query($conexion, $sql_areas);
$fila_area = mysqli_fetch_assoc($resul);
$id_area = $fila_area['id_area']+1;
$nom_dep = "0";
$query = "INSERT INTO areas_dependencias (id_area, nombre_area, id_dependencia) VALUES (?,?,?)";
$sentencia = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($sentencia, "sss", $id_area, $id_eva, $nom_dep );
mysqli_stmt_execute($sentencia);
$filasafec = mysqli_stmt_affected_rows($sentencia);  ?>