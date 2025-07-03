<?php
session_start();
$xstart = 0;
$xPath = '';
//-------------------------------------------------------------//
$absolute_path = "../controlconfianza/";
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($absolute_path, "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( !isset($_SESSION["admitted_xsice"]) && isset($_POST["txt1"]) && isset($_POST["txt2"]) ){
   include($xPath."includes/xresolve.php");
   $rslt = New Resolve($_POST["txt1"], $_POST["txt2"]);
   if( $rslt->getResult() > 0 ){
      $_SESSION["admitted_xsice"] = true;
      $_SESSION["xlogin_id"] = $rslt->getResult();
      $_SESSION["xroot"] = $absolute_path;
      $xstart = 1;
   }
}
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   $xSys = New System();
   $xUsr = New Usuario();

   if( $xstart == 1 )
      $xSys->xLog($xUsr->xCveUsr, "--", "--", "Acceso");

   header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
   header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Expires" content="0" />
   <meta http-equiv="Last-Modified" content="0" />
   <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
   <meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC</title>
   <link rel="icon" type="image/x-icon" href="imgs/icono.ico" />
   <script language="javascript">history.forward();</script>
</head>
<frameset cols="*">
   <frame name="index" src="inicio.php" noresize>
   <noframes>
      <body>
         <p>Tu navegador no soporta frames</p>
      </body>
   </noframes>
</frameset>
</html>
<?php
}
else{
   if( isset($rslt) ){     
      $rslt->shwError();
   }
   else
   header("Location: ".$xPath."exit.php");
}
?>
