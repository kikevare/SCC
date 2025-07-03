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
   $jsxIdxInvDoc  = $xPath."includes/js/evesocial/invdoc/xInvDocIndex.js?v=".rand();


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
   <script language="javascript" src="<?php echo $jsxIdxInvDoc;?>"></script>
   <script type="text/javascript">
      var xHoldColor = "";
      var xHoldIdColor = "";

      $(document).ready(function(){
         xShowMenu();
         xGrid();
         xBusqueda();
         xCtrlEvalInvSoc();

      });
   </script>

   <style type="text/css">
      .styxBtnOpcion{width: 65px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}
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
               <td width=" 3%" ><span style="font-size: 28px; color: blue;"><i name="btnBuscar" id="xbtnBuscar" class="fas fa-search-plus"></i></span></td>
            </td>
            <td style="width: 60%;" align="right" id="tdBtns">
               <?php
               if( $xUsr->xInsert == 1 ){
               ?>
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xEvaluar" title="Evaluaci&oacute;n M&eacute;dica">
                  <img src="<?php echo $xPath;?>imgs/result_eval.png" border="0"/>
                  <br/>Evaluar
               </a>
               <?php
               }
               ?>

	      

            <!--    <a href="#" class="styxBtnOpcion" id="xFor" title="Formatos de Ex&aacute;men M&eacute;dico...">
                  <img src="<?php echo $xPath;?>imgs/dat_gral.png" border="0" />
                  <br/>Formatos
               </a> -->
	       
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xReportes" title="Generador de Reportes Documental">
                  <img src="<?php echo $xPath;?>imgs/excel.png" border="0" />
                  <br />Reportes
               </a>


               <!--<a href="#" class="styxBtnOpcion" id="xDetalles" title="Muestra los detalles del elemento seleccionado...">
                  <img src="<?php //echo $xPath;?>imgs/usr_audit.png" border="0"/>
                  <br/>Detalles
               </a>
               <div id="dlgDetalles" class="dialog" title="Detalles del elemento"> </div>-->

               <?php
               //if( $xUsr->xInsert == 1 || $xUsr->xEdit ){
               ?>
               <!-- <a href="#" class="styxBtnOpcion" style="margin-left: 20px;" id="xEvalua" title="Ir al control de evaluaciones...">
                  <img src="<?php //echo $xPath;?>imgs/usr_eval.png" border="0"/>
                  <br/>Evaluac.
               </a>-->
               <?php
               //}
               ?>
                 <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xProgramacion" title="Programaci&oacute;n General de Evaluaciones">
                  <img src="<?php echo $xPath;?>imgs/prog_eval.png" border="0"/>
                  <br/>Program.
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
