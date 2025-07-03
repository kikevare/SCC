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
    $(document).ready(function() {
        xShowMenu();
    });
    </script>

</head>

<body style="background: url('imgs/fondos/r.jpg') no-repeat center top; background-size: cover;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <?php
   $xSys->getMenu();
   /*$dbname ="bdceecc";
     $dbuser="root";
     $dbhost="10.24.2.25";
     $dbpass='4dminMy$ql$';*/
    $dbname = "bdceecc";
    $dbuser = "root";
    $dbhost = "localhost";
    $dbpass = 'root';
     $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
     $sql_todos2 = "SELECT * FROM informacion_sgd where curp_encargado ='$xUsr->xCurpEval' and estatus='1' order by fecha_recibido desc";
     $resultodos2 = mysqli_query($conexion, $sql_todos2);
   ?>
            </td>
        </tr>

        <tr>
            <td>
                <div id="xdvContenedor" class="styContenedor" style="opacity:0.0">
                    <?php $xSys->getNameMod(0, "Inicio");?>
                    <div
                        style="color: black; padding: 80px 3px 10px 10px; width: 100%; text-align: center; border: 0px solid lightblue;">
                        <span style="color: gray; padding: 10px 0 0 0; font-size: 3rem;">Sistema Control
                            Confianza</span>
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
            </td>
        </tr>

        <tr>
            <td>

                

            </td>
        </tr>
    </table>
    <!-- <link rel="stylesheet" type="text/css"z href="css/sweetalert.css">
	<script src="includes/js/sweetalert.min.js"></script>
   <script src="includes/js/acerca.js"></script>
 -->

</body>
<footer>
    <!-- <button  type="button" class="btn btn-secondary">
 <a href="http://10.24.2.25/CHAT/login.php" style="text-decoration:none; color:white; float: right; ">CHAT CONTROL DE CONFIANZA</a>
 </button> -->

    <a href="https://10.24.2.23:5001/#/signin" target="_blank">
        <img src="imgs/4.png" width="150" height="100" style="text-align: center;">
    </a>

</footer>
<?php
  $contador = 0;  while ($filatodos2 = mysqli_fetch_assoc($resultodos2)) {  
$contador=$contador+1;
 }
 if ($contador>=1) {
   
   ?>
   <section></section>
  <section class="alerta">
      <div class="imagen"><img src="imgs/activo.png" alt="" width="40px"></div>
      <div class="texto">Usted Tiene <?php echo " ".$contador  ?> Documento(s) <br> En Espera de Respuesta... </div>
   </section> 
    <?php
   }

   ?>
   <style>
    @keyframes desaparecer {
                            from {
                                transform: translate(0, -1000%);
                                visibility: visible;
                            }

                            to {
                                transform: translate(0, 40%);
                            }
                        }
      .alerta 
      {
         width: 220px;
         height: 100px;
         border-radius: 10px;
         border: none;
         background: white;
         text-align: center;
         margin-top: 110px;
         animation-duration: 10s;
         animation-name: desaparecer;
         animation-iteration-count: 1;
         visibility: hidden;
         margin-left: 10px;
         box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
      }

      .texto
      {
        width: 100%;
        height: 100%;
        font-size: 15px;
        font-family: oswald;
        text-align: center;
      }
   </style>

</html>
<?php
}
else
header("Location: ".$xSys->getServer()."exit.php");
?>
