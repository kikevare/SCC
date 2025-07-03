<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   include_once($xPath."includes/xsystem.php");
   $xSys = New System();
   $xUsr = New Usuario(); 
   
   /*
   F001 - Cartilla S.M.N.
   F002 - Comprobante de Estudios
   F003 - Formato de Investigacion documental
   
   */
    switch( $_GET["clave"] ){
      
        case "cartilla":
            $clave = "F001";
            break;
      
        case "comp_est":
            $clave = "F002";
            break;
      
        case "for_inv_doc":
            $clave = "F003";
            break;    
      
        default:
            break;
         
   }	 
   
   $uploaddir = $xPath."Archivo/DeptoESocial/invdoc/Expedientes/".$_SESSION["xCurp"]."/";
   $uploadfile = $uploaddir . $_SESSION["xCurp"]."_".$clave.".jpg";
   
   if( !is_dir($uploaddir) ){
	 //Si la carpeta de la persona no existe, entonces la crea...
	 if( !mkdir($uploaddir, 0777) ){
	     echo "No se pudo crear la carpeta...";
	     exit(); 
	 }
   }
   
   if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
      $xSys->xLog($xUsr->xCveUsr, "expediente", $_SESSION["xCurp"], "Asignación");
      echo "1";
   }else{
     echo "Error en la carga de la imagen...";
   }
 
 //echo $uploadfile;
?>