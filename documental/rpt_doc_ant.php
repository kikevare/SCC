<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/evaluaciones.class.php");
   $xSys = New System();
   $xUsr = New Usuario(); 
   $xPersona = New Persona();
   
   //-------- Define el id del m�dulo y el perfil de acceso -------//
   $xInicio = 0;
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];         
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//
   
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsxIdxInvDoc  = $xPath."includes/js/evesocial/invdoc/xInvdocrpt.js";
   
   
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
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxIdxInvDoc;?>"></script>
   <script type="text/javascript">
      var xHoldColor = "";
      var xHoldIdColor = ""; 
   
      $(document).ready(function(){
         xShowMenu();
         xGrid();
         xBusquedaR();
         xCtrlIdx();
      });
   </script> 
   
   <style type="text/css">
      .styxBtnOpcion{width: 65px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}
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
<form name="fForm" id="fForm" method="post" action="" enctype="application/x-www-form-urlencoded">
<div id="xdvContenedor" class="styContenedor">
   <?php
   //-- Muestra el t�tulo del m�dulo actual...
   if( isset($_GET["menu"]) ){
      $xInicio=1;  
      $xSys->getNameMod($_GET["menu"]);
      $_SESSION["menu"] = $_GET["menu"];
   }
   else if( isset($_SESSION["menu"]) ){
      $xInicio=0;
      $xSys->getNameMod($_SESSION["menu"]);
   }
      
         //------------ Recepcion de par�metros de ordenaci�n y b�squeda ------------//
      //-- Inicializa los par�metros...
      $idOrd      = 2;      
      $tipoOrd    = "Asc";
      $txtBusca   = "";
      $cmpBusca   = 1;      
      //-- Revisa si se ha ejecutado una ordenaci�n...
      if( isset($_POST["id_orden"]) ){
         
         $idOrd   = $_POST["id_orden"];         
         $tipoOrd = $_POST["tp_orden"];
         //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
         $_SESSION["id_orden"] = $idOrd;
         $_SESSION["tipo_orden"] = $tipoOrd;
      }
      //-- Revisa si se ha ejecutado una b�squeda...
      if( isset($_POST["txtBusca"]) && !empty($_POST["txtBusca"]) ){
         $cmpBusca = $_POST["cbCampo"];
         $txtBusca = $_POST["txtBusca"];            
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_busca"] = $cmpBusca;
         $_SESSION["txt_busca"] = $txtBusca;            
      }
      /*
      Si el m�dulo no ha sido invocado desde el men� principal,
      entonces revisa si existen datos en las variables de sesi�n
      de alguna b�squeda u ordenaci�n.
      */
      if( $xInicio == 0 ){
         if( $_SESSION["id_orden"] != "" )   $idOrd      = $_SESSION["id_orden"]; 
         if( $_SESSION["tipo_orden"] != "" ) $tipoOrd    = $_SESSION["tipo_orden"];
         if( $_SESSION["cmp_busca"] != "" )  $cmpBusca   = $_SESSION["cmp_busca"];
         if( $_SESSION["txt_busca"] != "" )  $txtBusca   = $_SESSION["txt_busca"];
         $xMsj = "�ltima b�squeda realizada...";
      }
      else{         
         $_SESSION["id_orden"]   = "";
         $_SESSION["tipo_orden"] = "";
         $_SESSION["cmp_busca"]  = "";
         $_SESSION["txt_busca"]  = "";
         $xMsj = "";
      }
      //--------------------------------------------------------------------------//
   ?> 
   
   <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0">
         <tr>
            <td id="tdBsq" width="50%" align="left" style="padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">      
              <!-- B�squedas:<br />              
               <select name="cbCampo" id="xcbCampo" style="color: #565051;">
                  <?php/*
                  $noticias = simplexml_load_file("_camposbuscar.xml");
                  foreach( $noticias->campo as $noticia ){
                     if( $cmpBusca == $noticia->valor )
                        echo"<option value='".$noticia->valor."' selected>".$noticia->descrip."</option>";
                     else
                        echo"<option value='".$noticia->valor."'>".$noticia->descrip."</option>";
                  }*/
                  ?>                  
               </select> &nbsp;&nbsp;
               <input type="text" name="txtBusca" id="xtxtBusca" size="30" value="<?php echo htmlentities($txtBusca);?>" />               
               <input type="button" name="btnBuscar" id="xbtnBuscar" value="->" style="width: 30px;" />  -->                
            </td>
            <td width="50%" align="right" id="tdBtns">
                <a href="#" class="styxBtnOpcion" id="xRegresar" title="Regresar...">
                  <img src="<?php echo $xPath;?>imgs/back_32.png" border="0" />
                  <br/>Regresar
               </a> 
               <a href="#" class="styxBtnOpcion" id="xExcel" title="Exportar a Excel...">
                  <img src="<?php echo $xPath;?>imgs/excel.png" border="0" />
                  <br/>Excel
               </a>  
            </td>
         </tr>
      </table>
       <div style="width: 99%;">
         <div id="dvxMsj" class="styxMsjGrid"> <?php echo $xMsj;?> </div>
         <div id="dvxTotal" class="styTotalResult"> </div>
      </div>
      <table id="xGrid" class="styGrid" cellpadding="0" cellspacing="0">         
         <thead>
            <th>&nbsp;</th>
            <th id="col1">NOMBRE</th>
            <th id="col2">APELLIDOS</th>
            <th id="col3">CURP</th>
            <th id="col4">CORPORACI�N</th>
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
                  echo"<td class='tdID'>";
                     echo"<input type='radio' name='rbId' id='rb".$registro["CURP"]."' />";
                  echo"</td>";
                  echo"<td align='left'   style='min-width: 90px;'>".$registro["NOMBRE"]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>";
                     echo"<a href='#' class='toolTipTrigger' rel='".$registro["CURP"]."'>".$registro["APELLIDOS"]."</a>";
                  echo"</td>";
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
                           No existen resultados para la b�squeda...
                        </div>                     
                     </td>
                  </tr>";
            }   
            ?>   
         </tbody>
      </table>
      <?php 
      //-- Paginaci�n de resultados...
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