<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/invDocumental.class.php");
   $xSys = New System();   
   $xUsr = New Usuario(); 
   
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";   
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

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
            location.href = "ctrl_invdoc.php";
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
      if( isset($_SESSION["menu"]) ){
         $xSys->getNameMod($_SESSION["menu"], "Comprobante de Estudios");
         $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
        }      
      
        //-- Procesa los datos y ejecuta el proceso para guardarlos en la BD...
        //Datos...
        //$xInvDoc->getDatosGenerales();

        $xInvDoc->CURP_EVAL            = $xUsr->xCurpEval;
        //$xInvDoc->CURP       	       = $_POST["curp"];        
        
        $Datos[0]["DOC_VALIDAR"]       = $_POST["doc_validar"];
        $Datos[0]["OTRO_DOC"]          = $_POST["otro_doc"];
        $Datos[0]["DEP_EXPIDE"]        = $_POST["dep_expide"];
        $Datos[0]["MUNICIPIO"]         = $_POST["municipio"];
        $Datos[0]["DATOS_INST"]        = $_POST["datos_inst"];
        $Datos[0]["MATRICULA"]         = $_POST["matricula"];
        $Datos[0]["PRE_ORIGINAL"]      = $_POST["pre_original"];
        $Datos[0]["PRE_COPIA"]         = $_POST["pre_copia"]; 
		$Datos[0]["DOC_RESGUARDO"]     = $_POST["doc_resguardo"];
		   
		$Datos[0]["ESCOLARIDAD"]       = $_POST["escolaridad"];   
		$Datos[0]["CARRERA"]     	   = $_POST["carrera"];   
		$Datos[0]["EFICIENCIA"]        = $_POST["eficiencia"];   
		$Datos[0]["ESPECIALIDAD"]      = $_POST["ne_especialidad"]; 
		  
        $Datos[0]["FECHA_SOL"]         = ( !empty($_POST["fecha_sol"]) ) ? "'".$xSys->ConvertirFecha( $_POST["fecha_sol"], "yyyy-mm-dd" )."'" : "NULL"; 
		
		$Datos[0]["FECHA_RESP"]        = ( !empty($_POST["fecha_resp"]) ) ? "'".$xSys->ConvertirFecha( $_POST["fecha_resp"], "yyyy-mm-dd" )."'" : "NULL"; 
        $Datos[0]["NUM_OFICIO_SOL"]    = $_POST["num_oficio_sol"];
        
        $Datos[0]["NUM_OFICIO_RESP"]   = $_POST["num_oficio_resp"];
        $Datos[0]["RESULTADO_COMP_EST"]= $_POST["resultado_comp_est"];
        $Datos[0]["OBSERVACIONES"]     = $_POST["observaciones"];
        $Datos[0]["ANTECEDENTES"]     = $_POST["antecedentes"];
      
      if( $xInvDoc->ExistIdCompEst() ){
         $xRslt = $xInvDoc->editDatosCompEst( $Datos );
         $xOper = "Modificacion";
      }
      else{
         $xRslt = $xInvDoc->addDatosCompEst( $Datos );
         $xOper = "Insercion";
      }
      ?>
      <table border="0" width="100%" style="margin-top: 10%;">   
         <tr><td align="center" valign="middle">
         <?php
         if( $xRslt ){
            $xSys->xMensaje("Informacion", 
                           "Los Datos del Comprobante del Estudios se almacenaron correctamente.", 
                           "Info");
            $xSys->xLog($xUsr->xCveUsr, "InvDocEstudios", $xInvDoc->LASTIDEVAL, $xOper);            
         }
         else
            $xSys->xMensaje("Atencion", "Error: ".$xInvDoc->xERROR, "error");         
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