<?php

session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   $xSys = New System();
   $xUsr = New Usuario();

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $cssBootstrap  = $xPath."includes/upimagen/css/bootstrap.min.css";
   $cssBootstrapr = $xPath."includes/upimagen/css/bootstrap-responsive.min.css";
   $cssMenu       = $xPath."css/flatdropdownmenu.css";
   //$jsjQuery      = $xPath."includes/js/jquery.js";
   $jsjQueryB     = $xPath."includes/upimagen/js/jquery.min.js";
   $jsBootstrap   = $xPath."includes/upimagen/js/bootstrap.min.js";
   $jsxMain       = $xPath."includes/js/xmain.js?v=".rand();

   header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
   header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<head>

   <link rel="icon" type="image/x-icon" href="imgs/icono.ico" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SCC :: Men&uacute; principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script type="text/javascript">
      $(document).ready(function(){
         xShowMenu();
      });
   </script>

</head>

<body style="background: url('imgs/fondos/fondo-5.jpg') no-repeat center top; background-size: cover;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
   <?php
   $xSys->getMenu();
   ?>
</td></tr>

<tr><td>
   <div id="xdvContenedor" class="styContenedor" style="opacity:0.0">
      <?php $xSys->getNameMod(0, "Inicio");?>
      <div style="color: black; padding: 80px 3px 10px 10px; width: 100%; text-align: center; border: 0px solid lightblue;">
         <span style="color: gray; padding: 10px 0 0 0; font-size: 3rem;">Sistema Control Confianza</span>
         <?php
         if( $xUsr->xCveUsr == 1 ){
         ?>
         <br />
         <br />
         <?php
         }
         ?>
      </div>
   </div>
</td></tr>

<tr><td>
   <?php
   //$xSys->getFooter();
   ?>
</td></tr>
</table>
<link rel="stylesheet" type="text/css"z href="css/sweetalert.css">
	<script src="includes/js/sweetalert.min.js"></script>
   <script src="includes/js/acerca.js"></script>

</body>

</html>
<?php
}
else
header("Location: ".$xSys->getServer()."exit.php");
?>
