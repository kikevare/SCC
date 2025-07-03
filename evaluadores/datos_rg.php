<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
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
	<title>SICE :: Men� principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script type="text/javascript">
      $(document).ready(function(){
         $("#msjbAceptar").click(function(){            
            location.href = "datos_edit.php";
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
         $xSys->getNameMod($_SESSION["menu"], "Registro de evaluadores");      
      
      //-- Procesa los datos y ejecuta el proceso para guardarlos en la BD...
      $xPersona = New Persona();
      //Datos personales...
      $xPersona->CURP      = $_POST["curp"];
      $xPersona->NOMBRE    = $_POST["nombre"];
      $xPersona->APATERNO  = $_POST["a_paterno"];
      $xPersona->AMATERNO  = $_POST["a_materno"];
      $xPersona->FECHANAC  = $xSys->ConvertirFecha( $_POST["fecha_nac"], "yyyy-mm-dd" );
      $xPersona->SEXO      = $_POST["sexo"];
      $xPersona->RFC       = $_POST["rfc"];
      $xPersona->CUIP      = ( !empty($_POST["cuip"]) ) ? $_POST["cuip"] : NULL;
      $xPersona->IFE       = ( !empty($_POST["ife"]) ) ? $_POST["ife"] : NULL;
      $xPersona->CARTILLA  = ( !empty($_POST["cartilla"]) ) ? $_POST["cartilla"] : NULL;
      $xPersona->MPIONAC   = $_POST["mpio_nac"];
      $xPersona->EDOCIVIL  = ( !empty($_POST["edocivil"]) ) ? $_POST["edocivil"] : 'NULL';
      $xPersona->LOCALIDAD = ( !empty($_POST["localidad"]) ) ? $_POST["localidad"] : NULL;
      $xPersona->TIPOPER   = 2;
      //Adscripci�n...
      $xPersona->ESPECIALIDAD = $_POST["especialidad"];
      $xPersona->CORPORACION    = $_POST["corporacion"];
      $xPersona->FECHAING     = $xSys->ConvertirFecha( $_POST["fecha_ing"], "yyyy-mm-dd" );
      $xPersona->AREAEVAL     = $_POST["area"];
      $xPersona->TIPOFUNCION  = $_POST["funcion"];
      $xPersona->CATEGORIA    = $_POST["categoria"];
      $xPersona->CARGO        = $_POST["cargo"];
      $xPersona->AREAADSCRIP  = $_POST["area_ads"];
      $xPersona->REGION       = ( !empty($_POST["region"]) ) ? $_POST["region"] : 'NULL';
      $xPersona->MPIOADSCRIP  = ( !empty($_POST["mpio_ads"]) ) ? $_POST["mpio_ads"] : 'NULL';
      //Domicilio...      
      $xPersona->CALLE     = $_POST["calle"];
      $xPersona->NUMEXT    = $_POST["num_ext"];
      $xPersona->NUMINT    = ( !empty($_POST["num_int"]) ) ? $_POST["num_int"] : NULL;
      $xPersona->COLONIA   = $_POST["colonia"];
      $xPersona->CIUDAD    = $_POST["ciudad"];
      $xPersona->MPIODOMI  = $_POST["mpio_domi"];
      $xPersona->CODPOSTAL = 'NULL';
      $xPersona->TELFIJO   = ( !empty($_POST["tel_fijo"]) ) ? $_POST["tel_fijo"] : NULL;
      $xPersona->TELMOVIL  = ( !empty($_POST["tel_movil"]) ) ? $_POST["tel_movil"] : NULL;
      //Nivel de Estudios...
      $xPersona->NIVELEST  = $_POST["nivel_estudios"];
      $xPersona->STATEST   = $_POST["eficiencia"];
      $xPersona->CARRERA   = $_POST["carrera"];
      $xPersona->NOMENCLAT = $_POST["nomenclatura"];
      $xPersona->CEDULA    = $_POST["cedula"];
      $xPersona->ESPEST    =$_POST["ne_especialidad"];
      $xPersona->AP    = ( !empty($_POST["ap"]) ) ? $_POST["ap"] : NULL;

      $xRslt = ( $_POST["tp_oper"] == 1 ) ? $xPersona->Agregar() : $xPersona->Modificar();
      ?>
      <table border="0" width="100%" style="margin-top: 10%;">   
         <tr><td align="center" valign="middle">
         <?php
         if( $xRslt ){
            $xSys->xMensaje("Informacion", 
                           "Los datos del evaluador se guardaron correctamente.", 
                           "Info");
                           
            $xoper = ( $_POST["tp_oper"] == 1 ) ? "Insercion" : "Modificacion";
            $xSys->xLog($xUsr->xCveUsr, "personas", $xPersona->CURP, $xoper);
            
            $_SESSION["xCurp"] = $xPersona->CURP;
         }
         else{
            $xSys->xMensaje("Atencion", "Error: ".$xPersona->xERROR, "error");
         }
         ?>
         </td></tr>
      </table>
      
   </div>
   
   <input type="hidden" name="tp_oper" id="xtp_oper" value="<?php echo $_POST["tp_oper"];?>" />
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