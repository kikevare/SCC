<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - 2;
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");   
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/evaluaciones.class.php");
   $xSys = New System();
   $xUsr = New Usuario();  
   $xPersona = New Persona();
   
   //-------- Define el id del módulo y el perfil de acceso -------//
   $xInicio = 0;
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];         
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//
   
   //-- Define los directorios de scripts js y css...
  
   
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Menú principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" /> 
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />          
 
   
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td width="100%">
   <?php
   $xSys->getHeader();
   ?>
</td></tr>


<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="application/x-www-form-urlencoded">   
   <div id="xdvContenedor" class="styContenedor" style="overflow: auto;">
      <?php
      //------------------- Muestra el título del módulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"]);
      //--------------------------------------------------------------------------//
         
      //------------ Recepcion de parámetros de ordenación y búsqueda ------------//
      //-- Inicializa los parámetros...
      $idOrd      = 2;      
      $tipoOrd    = "Asc";
      $txtBuscar   = "";
      $cmpBuscar   = 1;      
      //-- Revisa si se ha ejecutado una ordenación...
      if( isset($_POST["id_orden"]) ){
         
         $idOrd   = $_POST["id_orden"];         
         $tipoOrd = $_POST["tp_orden"];
         //-- Se guardan los parámetros de ordenación en variables de sesión...
         $_SESSION["id_orden"] = $idOrd;
         $_SESSION["tipo_orden"] = $tipoOrd;
      }
      //-- Revisa si se ha ejecutado una búsqueda por campos...
      if( isset($_POST["cbCampor"])  ){
         $cmpBuscar = $_POST["cbCampor"];
                    
         //-- Se guardan los parámetros de búsqueda en variables de sesión...
         $_SESSION["cmp_buscar"] = $cmpBuscar;
                     
      }
      /*//-- Revisa si se ha ejecutado una búsqueda por campos...
      if( isset($_POST["txtBuscar"]) && !empty($_POST["txtBuscar"]) ){
         $cmpBuscar = $_POST["cbCampor"];
         $txtBuscar = $_POST["txtBuscar"];            
         //-- Se guardan los parámetros de búsqueda en variables de sesión...
         $_SESSION["cmp_buscar"] = $cmpBuscar;
         $_SESSION["txt_buscar"] = $txtBuscar;            
      }*/
      //-- Revisa si se ha ejecutado una búsqueda por fecha...
      if( isset($_POST["txtFecha1"]) && !empty($_POST["txtFecha1"]) ){         
         $txtFecha1 = $xSys->ConvertirFecha($_POST["txtFecha1"], "yyyy-mm-dd");
         //-- Se guardan los parámetros de búsqueda en variables de sesión...
         $_SESSION["txt_fecha1"] = $txtFecha1;
      }
      //-- Revisa si se ha ejecutado una búsqueda por fecha...
      if( isset($_POST["txtFecha2"]) && !empty($_POST["txtFecha2"]) ){         
         $txtFecha2 = $xSys->ConvertirFecha($_POST["txtFecha2"], "yyyy-mm-dd");
         //-- Se guardan los parámetros de búsqueda en variables de sesión...
         $_SESSION["txt_fecha2"] = $txtFecha2;
      }
      /*
      Si el módulo no ha sido invocado desde el menú principal,
      entonces revisa si existen datos en las variables de sesión
      de alguna búsqueda u ordenación.
      */
      if( $xInicio == 0 ){
         if( $_SESSION["id_orden"] != "" )   $idOrd      = $_SESSION["id_orden"]; 
         if( $_SESSION["tipo_orden"] != "" ) $tipoOrd    = $_SESSION["tipo_orden"];
         if( $_SESSION["cmp_buscar"] != "" )  $cmpBuscar   = $_SESSION["cmp_buscar"];
         if( $_SESSION["txt_buscar"] != "" )  $txtBuscar   = $_SESSION["txt_buscar"];
         if( $_SESSION["txt_fecha1"] != "" )  $txtFecha   = $_SESSION["txt_fecha1"];
         if( $_SESSION["txt_fecha2"] != "" )  $txtFecha2   = $_SESSION["txt_fecha2"];
         $xMsj = "Última búsqueda realizada...";
      }
      else{         
         $_SESSION["id_orden"]   = "";
         $_SESSION["tipo_orden"] = "";
         $_SESSION["cmp_buscar"]  = "";
         $_SESSION["txt_buscar"]  = "";
         $_SESSION["txt_fecha1"]  = "";
         $_SESSION["txt_fecha2"]  = "";
         $xMsj = "";
      }
      //--------------------------------------------------------------------------//
      header("Content-type: application/vnd.ms-excel"); 
	  header("Content-Disposition: attachment; filename=Reporte_" . date("Y-m-d") . ".xls");
      ?> 
      <table id="xGrid" class="styGrid" cellpadding="0" cellspacing="0">         
         <thead>
            <th id="col1">NOMBRE</th>
            <th id="col2">APELLIDOS</th>
            <th id="col3">CURP</th>
            <th id="col4">CORPORACIÓN</th>
            <th id="col5">CATEGORIA</th>
            <th id="col6">DOC CARTILLA</th>
            <th id="col7">RESULTADO CARTILLA</th>
            <th id="col8">DOC ESTUDIO</th>
            <th id="col9" style="border-right: 1px solid #000;">RESULTADO ESTUDIO.</th>
         </thead>
         <tbody>         
            <?php
            $xEval = New Evaluaciones();
            $Datos = $xEval->BusRptDoc($cmpBuscar, $txtBuscar, $idOrdr, $tipoOrdr, 1, $_SESSION["txt_fecha1"], $_SESSION["txt_fecha2"]);            
            foreach( $Datos As $registro ){
               echo"<tr id='".$registro["CURP"]."' bgcolor='#ffffff'>";
                  echo"<td align='left'   style='min-width: 90px;'>".$registro["NOMBRE"]."</td>";
                  echo"<td align='center' style='min-width: 100px;'>".$registro["APELLIDOS"]."</a>";
                  echo"<td align='center' style='min-width: 100px;'>".$registro["CURP"]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>".$registro["CORPORACION"]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>".$registro["CATEGORIA"]."</td>";
                  echo"<td align='left'   style='min-width: 75px;'>".$registro["DOC_CAR"]."</td>";
                  echo"<td align='left'   style='min-width: 70px;'>".$registro["CARTILLA"]."</td>";
                  echo"<td align='left'   style='min-width: 80px;'>".$registro["DOC_DOC"]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>".$registro["ESTUDIOS"]."</td>";
               echo"</tr>"; 
            }
            $xTotal = count($Datos);
            if( $xTotal <= 0 ){
               echo"<tr style='background: none;'>
                     <td colspan='15' align='center'>
                        <div style='font-family: sans-serif; font-weight: normal; font-size: 8pt; color: #ff0000;'>
                           No existen resultados para la búsqueda...
                        </div>                     
                     </td>
                  </tr>";
            }   
            ?>   
         </tbody>
      </table>
      <?php 
      //-- Paginación de resultados...
      ?>     
   </div>
   
   <input type="hidden" name="total_reg" id="xtotalReg" value="<?php echo $xTotal;?>" />   
   <input type="hidden" name="id_orden" id="xidOrd" value="<?php echo $idOrd;?>" />
   <input type="hidden" name="tp_orden" id="xtipoOrd" value="<?php echo $tipoOrd;?>" />   
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