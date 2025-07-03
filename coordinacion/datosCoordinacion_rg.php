<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/invSocioEconomica.class.php");
   
   $xSys = New System();
   $xbd  = New MySQL();
   $xUsr = New Usuario(); 
   
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";   
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Men� principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script type="text/javascript">
      $(document).ready(function(){
         $("#msjbAceptar").click(function(){
            location.href = "datosCoordinacion.php";
         });
      });
   </script> 
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
        //-- Muestra el t�tulo del m�dulo actual...      
        if( isset($_SESSION["menu"]) )
         $xSys->getNameMod($_SESSION["menu"], "Datos");
        
        
        //-- Procesa los datos y ejecuta el proceso para guardarlos en la BD...
        $xISE= New invSocioEconomica( $_SESSION["xCurp"] );
        //Datos personales...
        $xISE->CURP_EVAL                    =   $xUsr->xCurpEval;   
        
        $Datos[0]["EVALUADOR"]              =   $_POST["evaluador"];
        $Datos[0]["CUBICULO"]               =   $_POST["cubiculo"];
        $Datos[0]["ID_TIPO_INCIDENCIA"]     =  ($_POST["id_tipo_incidencia"] != 0 ) ? $_POST["id_tipo_incidencia"]: "NULL";
        $Datos[0]["INCIDENCIA_DETALLES"]    =   $_POST["incidencia_detalles"];                
                

        //se verifica si ya existe el registro de la tabla tbisecoordinacion, si existe lo actualiza. Si no existe lo crea.
        if( $xISE->ExistIdDatosCoordinacionISE() ){
            $xRslt = $xISE->editDatosCoordinacionISE( $Datos );
            $xOper = "Modificacion";                        
        }else{
            $xRslt = $xISE->addDatosCoordinacionISE( $Datos );
            $xOper = "Insercion";
        }             
        
        
    ?>
    <table border="0" width="100%" style="margin-top: 10%;">   
        <tr><td align="center" valign="middle">
        <?php
        if( $xRslt ){
            $xSys->xMensaje("Informacion", 
                       "Los datos de la Coordinacion ISE se guardaron correctamente.", 
                       "Info");
            $xSys->xLog($xUsr->xCveUsr, "ISE-Coordinacion", $xISE->LASTIDEVAL, $xOper);            
        }else{
            $xSys->xMensaje("Atencion", "Error: ".$xISE->xERROR, "error");
        }        
        ?>
        </td></tr>
    </table>
      
   </div>
   
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