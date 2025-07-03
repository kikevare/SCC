<?php 
$dbname = "bdceecc";
$dbuser = "root";
$dbhost = "localhost";
$dbpass = 'root';
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);  
       $sqlar = "SELECT * from areas_dependencias ";
       $resultadoar = mysqli_query($conexion, $sqlar);
       while ($filaar = mysqli_fetch_assoc($resultadoar)) {   ?> <option
       value="<?php echo $filaar['nombre_area'] ?> ">
       <?php echo $filaar['nombre_area'] ?> </option><?php  } ?>