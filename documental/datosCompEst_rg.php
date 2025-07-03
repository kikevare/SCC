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
	<title>SCC :: Menu principal</title>
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
        $Datos[0]["DEP_EXPIDE"]        = ( isset($_POST["dep_expide"]) ) ? $_POST["dep_expide"]: "NULL";
        $Datos[0]["MUNICIPIO"]         = ( isset($_POST["municipio"]) ) ? $_POST["municipio"]: "NULL";
        $Datos[0]["DATOS_INST"]        = $_POST["datos_inst"];
        $Datos[0]["MATRICULA"]         = $_POST["matricula"];
        $Datos[0]["PRE_ORIGINAL"]      = ( isset($_POST["pre_original"]) ) ? $_POST["pre_original"]: "NULL";
        $Datos[0]["PRE_COPIA"]         = ( isset($_POST["pre_copia"]) ) ? $_POST["pre_copia"]: "NULL"; 
		$Datos[0]["DOC_RESGUARDO"]     = ( isset($_POST["doc_resguardo"]) ) ? $_POST["doc_resguardo"]: "NULL";  
		$Datos[0]["ESCOLARIDAD"]       = ( isset($_POST["escolaridad"]) ) ? $_POST["escolaridad"]: "0";   
		$Datos[0]["CARRERA"]     	   = ( isset($_POST["carrera"]) ) ? $_POST["carrera"]: "";   
		$Datos[0]["EFICIENCIA"]        = ( isset($_POST["eficiencia"]) ) ? $_POST["eficiencia"]: "1";     
		$Datos[0]["ESPECIALIDAD"]      = ( isset($_POST["ne_especialidad"]) ) ? $_POST["ne_especialidad"]: "";   
        $Datos[0]["FECHA_SOL"]         = ( isset($_POST["fecha_sol"]) && !empty($_POST["fecha_sol"]) ) ? "'".$xSys->ConvertirFecha( $_POST["fecha_sol"], "yyyy-mm-dd" )."'" : "NULL"; 
		$Datos[0]["FECHA_RESP"]        = ( isset($_POST["fecha_resp"]) && !empty($_POST["fecha_resp"]) ) ? "'".$xSys->ConvertirFecha( $_POST["fecha_resp"], "yyyy-mm-dd" )."'" : "NULL"; 
        $Datos[0]["NUM_OFICIO_SOL"]    = $_POST["num_oficio_sol"];
        $Datos[0]["NUM_OFICIO_RESP"]   = $_POST["num_oficio_resp"];
        $Datos[0]["RESULTADO_COMP_EST"]= ( isset($_POST["resultado_comp_est"]) ) ? $_POST["resultado_comp_est"]: "NULL"; 
        $Datos[0]["RESULT_OFI"]        = $_POST["result_ofi"];
        $Datos[0]["OBSERVACIONES"]     = $_POST["observaciones"];
        $Datos[0]["ANTECEDENTES"]      = $_POST["antecedentes"];
        $Datos[0]["TRAMITE"]           = $_POST["tramite"];
      
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