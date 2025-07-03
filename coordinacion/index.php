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
   include_once($xPath."includes/invSocioEconomica.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xPersona = New Persona();
   $xISE = New invSocioEconomica();

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
   $jsxIdxCoordina= $xPath."includes/js/evesocial/coordina/xCoordinaIndex.js?v=".rand();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Men&uacute; principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script type="text/javascript" src="<?php echo $jsxIdxCoordina;?>"></script>
   <script type="text/javascript">
      var xHoldColor = "";
      var xHoldIdColor = "";

      $(document).ready(function(){
         xShowMenu();
         xGrid();
         xBusqueda();
         xCoordinacion();

      });
   </script>

   <style type="text/css">
      #tbxEval{ width: 90%; }
      #tbxEval td{ padding: 3px; text-align: center; vertical-align: middle; }
      #tbxEval td label{ font-family: arial, sans-serif; font-size: 11pt; margin-left: 4px; cursor: pointer; vertical-align: middle; }
      #tbxEval .txtHora{ text-align: center; font-family: arial, sans-serif; font-size: 12pt; width: 60px; height: 18px; }
      .styxBtnOpcion{ width: 65px; font-size: 8pt; font-family: arial, helvetica, sans-serif; }
      .text{ height: 14px; font-size: 11pt; padding: 3px; }
      #dvMenuRpt{ width: auto; /*height: 45px;*/ text-align: left; position: absolute; border: 1px solid #cccccc; border-left: 3px solid #cccccc; border-bottom: 2px solid #cccccc; background-color: #ebebea; z-index: 99; }
      .ulMenuRpt{ width: 100%; }
      .ulMenuRpt li{ list-style: none; padding: 1px 1px 1px 1px; border-bottom: 1px solid #d5d5d4; }
      .ulMenuRpt li a{ padding: 5px 4px 5px 2px; display: block; font-family: arial, sans-serif, serif; font-size: 8pt; font-weight: normal; text-decoration: none; color: #342826; /*border: 1px dashed;*/ }
      .ulMenuRpt li a:hover{ /*text-decoration: underline;*/ color: #1528c7; background-color: #dddddc; }
      .tbStatEval{ width: 100%; border-top: 1px solid #cccccb; border-bottom: 1px solid #cccccb; border-collapse: collapse; /*margin-top: 10px; margin: 10px;*/ }
      .tbStatEval td{ text-align: center; font-family: arial, sans-serif, serif; font-size: 9pt; font-weight: bold; padding: 3px; color: gray; }
      .tbStatEval td a{ font-size: 9pt; text-decoration: none; }
      .tbStatEval td a:hover{ font-size: 9pt; text-decoration: underline; }
   </style>

</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
   <?php
   $xSys->getMenu();
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
         $xMsj = "&Uacute;ltima b&uacute;squeda realizada";
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
           <td id="tdBsq" align="left" style="width: 15%; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
             B&uacute;squedas:<br />
             <select name="cbCampo" id="xcbCampo" class="form-control">
                 <?php
                 $noticias = simplexml_load_file("_camposbuscar.xml");
                 foreach( $noticias->campo as $noticia ){
                    if( $cmpBusca == $noticia->valor )
                       echo"<option value='".$noticia->valor."' selected>".$noticia->descrip."</option>";
                    else
                       echo"<option value='".$noticia->valor."'>".$noticia->descrip."</option>";
                 }
                 ?>
              </select>
            </td>
             <td style="width: 22%;" >
                 &nbsp;
              <input type="text" name="txtBusca" id="xtxtBusca" class="form-control" value="<?php echo htmlentities($txtBusca);?>" />
           </td>
           <td style="width: 3%;">
              <td width=" 3%" ><span style="font-size: 1.7em; color: green;"><i name="btnBuscar" id="xbtnBuscar" class="fas fa-search-plus"></i></span></td>
           </td>
            <td width="60%" align="right" id="tdBtns">
              <!--
               <a href="#" class="styxBtnOpcion" id="xRptBase" title="Reporte diario...">
                  <img src="<?php //echo $xPath;?>imgs/excel.png" style="border-width: 0px; border-style: solid; width: 32px; height: 32px;" />
                  <br/>Reporte
               </a>
               -->
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xRptStatEval" title="Reporte del Status de evaluaci&oacute;n de los elementos">
                  <img src="<?php echo $xPath;?>imgs/excel.png" style="width: 32px; height: 32px; border: none;" />
                  <br/>Reportes
               </a>
               <div id="dvMenuRpt" style="display: none;">
                  <ul class="ulMenuRpt">
                     <li><a href="#" id="lnkRptListDiario">Reporte Coordinaci&oacute;n ISE</a></li>
                     <li><a href="#" id="lnkRptListGeneral">Reporte General</a></li>

                  </ul>
               </div>


               <?php
               if( $xUsr->xInsert == 1 ){
               ?>
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xDatos" title="Datos del evaluado">
                  <img src="<?php echo $xPath;?>imgs/add_48.png" style="border-width: 0px; border-style: solid; width: 32px; height: 32px;" />
                  <br/>Datos
               </a>
               <?php
               }
               ?>

                <!-- programacion de evaluaciones -->
                <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xProgramacion" title="Programaci&oacute;n General de Evaluaciones">
                  <img src="<?php echo $xPath;?>imgs/prog_eval.png" border="0"/>
                  <br/>Program.
                </a>
                &nbsp;
            </td>
         </tr>
      </table>

      <!-- lista de alertas en ventana emergente -->
      <div id="dlgLista" style="text-align: center;" title="Lista de evaluaciones con correcci&oacute;n pendiente"></div>

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
            <th id="col4">CORPORACI&Oacute;N</th>
            <th id="col5">CATEGORIA</th>
            <th id="col6">MOTIVO EVAL.</th>
         </thead>
         <tbody>
            <?php
            $xEval = New Evaluaciones();
            $Datos = $xEval->BuscarPersonas($cmpBusca, $txtBusca, $idOrd, $tipoOrd);
            foreach( $Datos As $registro ){
               echo"<tr id='".$registro[CURP]."' bgcolor='#ffffff'>";
                  echo"<td class='tdID'>";
                     echo"<input type='radio' name='rbId' id='rb".$registro[CURP]."' />";
                  echo"</td>";
                  echo"<td align='left'   style='min-width: 90px;'>".$registro[NOMBRE]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>";
                     echo"<a href='#' class='toolTipTrigger' rel='".$registro[CURP]."'>".$registro["APELLIDOS"]."</a>";
                  echo"</td>";
                  echo"<td align='center' style='min-width: 100px;'>".$registro[CURP]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>".$registro[CORPORACION]."</td>";
                  echo"<td align='left'   style='min-width: 100px;'>".$registro[CATEGORIA]."</td>";
                  echo"<td align='left'   style='min-width: 80px;'>".$registro[MOTIVO_EVAL]."</td>";
               echo"</tr>";
            }
            $xTotal = count($Datos);
            if( $xTotal <= 0 ){
               $xSys->sinResultados(7);
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
