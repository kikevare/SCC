<?php
$dbname = "bdceecc";
$dbuser = "root";
$dbhost = "localhost";
$dbpass = 'root';
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$id_eva = $_REQUEST['id'];
$lib = null;
$upda = "UPDATE poligrafia_evnu SET reexaminacion = '$lib' WHERE id_evaluacion = '$id_eva'";
$resed = mysqli_query($conexion, $upda);
