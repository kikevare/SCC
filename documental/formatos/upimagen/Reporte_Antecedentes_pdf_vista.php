<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   $xSys = New System();

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsxCredVista  = $xPath."includes/js/evpsico/xiniciales.js?v=".rand();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Men&uacute; principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script language="javascript" src="<?php echo $jsxCredVista;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xCtrl();
      });
   </script>

   <style type="text/css">
   #dvMainPdf{
      width: 96%;
      border: 2px groove #153e7e;
   }
   #dvTituloPdf{
      width: 98%;
      height: 60px;
      border-bottom: 1px solid #cccccb;
      margin: 0px 0 10px 0;
   }
   .bCerrar{
      padding: 5px 15px 5px 15px;
   }
   </style>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
   <?php
   $xSys->getMenu();
   $archivo = 'Reporte_Antecedentes_pdf.php';
   ?>
</td></tr>
<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" enctype="application/x-www-form-urlencoded">
      <div id="dvTituloPdf">
   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      		<tr style="height: 60px;">
        			<td width="85%" align="left" style="color: gray; font-size: 10pt;">[Formatos] - Reporte Antecedentes</td>
        			<td id="tdBtns" width="15%" align="right" valign="middle">
                  <!-- <a href="#" id="xRegresar" class="ui-button ui-corner-all ui-widget" style="font-size: 0.8em;" title="Cerrar">
                     <img src="<?php echo $xPath;?>imgs/exit_32.png" border="0"/>
                     <br/>Salir
                  </a> -->
      			  </td>
        		</tr>
   		</table>
   	</div>

    <div id="dlgWait" style="text-align: center;">Procesando...</div>

   	<div id="dvMainPdf">
   		<object data="<?php echo $archivo;?>" type="application/pdf" width="100%" height="600">
   			alt : <a href="<?php echo $archivo;?>"><?php echo $archivo; ?>.pdf</a>
   		</object>
   	</div>
   <input type="hidden" name="cont" id="xcont" value="<?php echo $xcont;?>" />
   <input type="hidden" name="xf" id="xf" value='<?php echo $_GET["f"]; ?>' />
   <input type="hidden" name="formato" id="xformato" value='<?php echo $xArchivo; ?>' />
</form>
</td></tr>

<tr><td>
   <?php
   $xSys->getFooter();
   ?>
</td></tr>
</table>
</body>

</html>
<?php
}else
   header("Location: ".$xPath."exit.php");
?>
