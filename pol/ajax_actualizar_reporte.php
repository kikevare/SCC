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
$upda = "UPDATE reporte_poli set evaluaciones_anteriores='$evan' , trayectoria_laboral = '$tray', situacion_patrimonial='$situa', analisis_tecnico='$anatec', conclusion='$sintesis', admision='$admi', observacion='$observa'  where id_evaluacion = '$id_evaluacion' ";
$resed = mysqli_query($conexion, $upda);

?>