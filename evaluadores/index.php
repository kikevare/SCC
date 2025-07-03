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
   $jsxIdxPer     = $xPath."includes/js/xidxevaluador.js?v=".rand();
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
   <script language="javascript" src="<?php echo $jsxIdxPer;?>"></script>
   <script type="text/javascript">
      var xHoldColor = "";
      var xHoldIdColor = "";

      $(document).ready(function(){
         xShowMenu();
         xGrid();
         xBusqueda();
         xCtrlIdx();
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
<form name="fForm" id="fForm" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="application/x-www-form-urlencoded">
   <br><br>
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"]);
      //--------------------------------------------------------------------------//

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
           <td id="tdBsq" style="width: 15%;" align="left" style="padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
          <!--  B&uacute;squedas:
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
              </select> -->
           </td>
           <!-- <td style="width: 22%;">
                &nbsp;
<input type="text" name="txtBusca" id="xtxtBusca" class="form-control" value="<?php echo htmlentities($txtBusca);?>" />
           </td> -->
           <td width=" 3%" ><span style="font-size: 1.7em; color: green;"><!-- <i name="btnBuscar" id="xbtnBuscar" class="fas fa-search-plus"></i> --></span></td>
           <td style="width: 60%; text-align: right;" id="tdBtns">
               <?php
               if( $xUsr->xInsert == 1 ){
               ?>
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xAgregar" title="Registrar un nuevo evaluador...">
                  <img src="<?php echo $xPath;?>imgs/evaluador_add.png" border="0"/>
                  <br/>Agregar
               </a>
               <?php
               }
               if( $xUsr->xEdit == 1 ){
               ?>
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xModificar" title="Modifica los datos del evaluador seleccionado...">
                  <img src="<?php echo $xPath;?>imgs/evaluador_edit.png" border="0"/>
                  <br/>Modificar
               </a>
               <?php
               }
               if( $xUsr->xDelete == 1 ){
               ?>
             <!--   <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xBaja" title="Dar de baja al evaluador seleccionado...">
                  <img src="<?php echo $xPath;?>imgs/evaluador_del.png" border="0"/>
                  <br/>Baja
               </a> -->
               <?php
               }
               ?>
               <!--
               <a href="#" class="styxBtnOpcion" id="xDetalles" title="Muestra los detalles del elemento seleccionado...">
                  <img src="<?php echo $xPath;?>imgs/usr_audit.png" border="0"/>
                  <br/>Detalles
               </a>
               <div id="dlgDetalles" class="dialog" title="Detalles del elemento"> </div>
               -->
            </td>
         </tr>
      </table>
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
            <th id="col7" style="border-right: 1px solid #000;">AREA</th>
            <th id="col5">CATEGORIA</th>
            <th id="col6">ESPECIALIDAD</th>
       
         </thead>
         <tbody>
            <?php
            $xband = true;
            if( $cmpBusca == 6 ){//-- Validaci�n de la fecha...
               //(dd/mm/aaaa)
               if( !preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $txtBusca) )
                  $xband = false;
               else{
                  $xfecha = $txtBusca;
                  $txtBusca = substr($xfecha, 6, 4)."-";
                  $txtBusca .= substr($xfecha, 3, 2)."-";
                  $txtBusca .= substr($xfecha, 0, 2);
               }
            }

            if( $xband ){
               $last_id = ( isset($_SESSION["xLastID"]) ) ? $_SESSION["xLastID"] : "";
               $Datos = $xPersona->BuscarEVALUADORES($cmpBusca, $txtBusca, $idOrd, $tipoOrd, 2);
               foreach( $Datos As $registro ){
                  $xcolor = ( $registro["STATUS"] == 4 ) ? "color: red;" : "";
                  if( empty($xcolor) )
                     $xcolor = ( $registro["CURP"] == $last_id ) ? "color: #1569c7;" : "";
                  else
                     $xcolor = ( $registro["CURP"] == $last_id ) ? "color: #7e2217;" : $xcolor;
                  echo"<tr id='".$registro["CURP"]."' bgcolor='#ffffff'>";
                     echo"<td class='tdID'>";
                        echo"<input type='radio' name='rbId' id='rb".$registro["CURP"]."' />";
                     echo"</td>";
                     echo"<td align='left'   style='min-width: 90px;  $xcolor'>".$registro["NOMBRE"]."</td>";
                     echo"<td align='left'   style='min-width: 150px;'>";
                        echo"<a href='#' class='toolTipTrigger' style='$xcolor' rel='".$registro["CURP"]."'>".$registro["APELLIDOS"]."</a>";
                     echo"</td>";
                     echo"<td align='center' style='min-width: 100px; $xcolor'>".$registro["CURP"]."</td>";
                     echo"<td align='left'   style='min-width: 120px; $xcolor'>".$registro["CORPORACION"]."</td>";
                     echo"<td align='left'   style='min-width: 90px;  $xcolor'>".$registro["AREA"]."</td>";
                     echo"<td align='left'   style='min-width: 120px; $xcolor'>".$registro["CATEGORIA"]."</td>";
                     echo"<td align='left'   style='min-width: 120px; $xcolor'>".$registro["ESPECIALIDAD"]."</td>";
                  
                  echo"</tr>";
               }
               $xTotal = count($Datos);
               if( $xTotal <= 0 ){
                  $xSys->sinResultados(8);
               }
            }
            else{
               echo"<tr style='background: none;'>
                     <td colspan='15' align='center'>
                        <div style='font-family: sans-serif; font-weight: bold; font-size: 1.1em; color: #f00;'>
                           ERROR: La fecha especificada NO es V&Aacute;LIDA.
                        </div>
                     </td>
                  </tr>";
            }
            ?>
         </tbody>
      </table>
<!-- 
   <div id="dlgFinStatEval" class="dialog" title="Status de Evaluaci&oacute;n :: Concluir">
        <fieldset id="fsContenido" style="width: 98%;">
        <legend></legend>
        <table class="stytbContenido" id="tbEditStatEval" style="width: 100%;">
           <tr>
              <td class="styTdNombreCampo" style="width: 50px;">Hora:</td>
              <td class="styTdCampo">
                 <input type="text" id="txtHoraFin" size="5" value="" maxlength="5" class="txtHora" style="width: 60px; padding: 3px; text-align: center;" />
                 &nbsp;[hh:mm] 00 - 24 hrs.
              </td>
           </tr>
        </table>
        </fieldset>
   </div> -->

   <input type="hidden" name="total_reg" id="xtotalReg" value="<?php echo $xTotal;?>" />
   <input type="hidden" name="id_orden" id="xidOrd" value="<?php echo $idOrd;?>" />
   <input type="hidden" name="tp_orden" id="xtipoOrd" value="<?php echo $tipoOrd;?>" />
</form>
</td></tr>
<?php
$height = ( $xTotal >= 10 ) ? "200px" : "50px";
?>
<tr><td style="height: <?php echo $height;?>; vertical-align: top;">
   <?php
   $xSys->getFooter();
   ?>
</td></tr>
</table>
</body>

</html>
<?php
   //-- Se eliminan algunas variables de sesion...
   unset( $_SESSION["xIdProgPre"] );
   unset( $_SESSION["xTipoEvalProg"] );
}
else
   header("Location: ".$xPath."exit.php");
?>