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
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js"; 
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxCredImpresion  = $xPath."includes/js/evesocial/invdoc/ximpresion.js";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Menú principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />  
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />     
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxCredImpresion;?>"></script>
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
<tr><td width="100%">
   <?php
   $xSys->getHeader();
   ?>
</td></tr>

<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">  
      <?php
      //------------------- Muestra el título del módulo actual ------------------//
      
        if( isset($_SESSION["menu"]) ){  
      
            switch( $_GET["f"] ){
                    
                case "1":
                    $txt = "Cartilla S.M.N.";
                    $clave = "F001";
                    break;
                case "2":
                	$txt = "Comprobante de Estudios";
                	$clave = "F002";
                	break;
                default:
                    break;
            }
	 
         $xSys->getNameMod($_SESSION["menu"], $txt);
      
      }
      //--------------------------------------------------------------------------//
      
      $archivo = "ver_doc_pdf.php?fx=" . $clave;
      ?>
      <div id="dvTituloPdf">
   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
      		<tr style="height: 60px;">
        			<td width="85%" align="left" style="color: gray; font-size: 10pt;">[Documentos] - Vista Previa <?php echo $archivo ; ?> </td>
        			<td id="tdBtns" width="15%" align="right" valign="middle">                  
                  <a href="#" id="xCerrar" style="width: 65px; height: 55px;" title="Cerrar vista previa">
                     <img src="<?php echo $xPath;?>imgs/exit_32.png" border="0"/>
                     <br/>Salir
                  </a> 
      			</td>
        		</tr>
   		</table>
   	</div>
      <div id="dlgWait" style="text-align: center;">Procesando...</div>  
  		     
   	<div id="dvMainPdf">
   		<object data="<?php echo $archivo;?>" type="application/pdf" width="100%" height="600">
   			alt : <a href="<?php echo $archivo;?>"><?php echo $xArchivo; ?>.pdf</a>
   		</object>
   	</div>       
   </div>
   <input type="hidden" name="cont" id="xcont" value="<?php echo $xcont;?>" />
   <input type="hidden" name="formato" id="xformato" value='<?php echo $clave; ?>' />      
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
}
else
   header("Location: ".$xPath."exit.php"); 
?>