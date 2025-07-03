<?php  
   session_start();
   $_SESSION["id_orden"]   = 2;
   $_SESSION["tipo_orden"] = "Asc";
   $_SESSION["cmp_busca"]  = 3;
   $_SESSION["txt_busca"]  = $_POST["curp"];
?>