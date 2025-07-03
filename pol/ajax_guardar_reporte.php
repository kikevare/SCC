<?php
$dbname = "bdceecc";
 $dbuser = "root";
 $dbhost = "localhost";
 $dbpass = 'root';
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$evan = $_REQUEST['evan'];
$tray = $_REQUEST['tray'];
$admi = $_REQUEST['admi'];
$observa = $_REQUEST['observa'];
$situa = $_REQUEST['situa'];
$anatec = $_REQUEST['anatec'];
$sintesis = $_REQUEST['sintesis'];
$id_evaluacion = $_REQUEST['id_evaluacion'];
$query = "INSERT INTO reporte_poli (id_evaluacion, evaluaciones_anteriores, trayectoria_laboral, situacion_patrimonial, analisis_tecnico, conclusion, admision, observacion, curp_evaluador, curp_supervisor) VALUES (?,?,?,?,?,?,?,?,?,?)";
                              $sentencia = mysqli_prepare($conexion, $query);
                              mysqli_stmt_bind_param($sentencia, "ssssssssss", $id_evaluacion, $evan , $tray , $situa, $anatec,$sintesis,$admi,$observa,$supervisor, $evaluador);
                              mysqli_stmt_execute($sentencia);
                              $filasafec = mysqli_stmt_affected_rows($sentencia); 
?>