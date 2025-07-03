<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/catalogos.class.php");
   include_once($xPath."includes/invDocumental.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xCat = New Catalog();

   //-------- Define el id del m�dulo y el perfil de acceso -------//
   if( isset($_GET["menu"]) ) $_SESSION["menu"] = $_GET["menu"];
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
  /*  $cssEditor     = $xPath."includes/js/cleditor/jquery.cleditor.css"; */
/*
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxFileUpload = $xPath."includes/js/AjaxUpload.2.0.min.js";
   */
  /*  $jsxEditor	  = $xPath."includes/js/tiny_mce/tiny_mce.js"; */
   $jsxCompEst    = $xPath."includes/js/evesocial/invdoc/xdatosCompEst.js?v=".rand();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssEditor;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script language="javascript" src="<?php echo $jsxEditor;?>"></script>
   <script language="javascript" src="<?php echo $jsxCompEst;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xCompEst();
      });
   </script>
   
   <script src="../../../includes/tinymce5.7/tinymce.min.js" referrerpolicy="origin"></script> 

<script>
   tinymce.init({
      content_css : "/mycontent.css",
     language: 'es_MX',
 selector: 'textarea',
 height: 400,
 fontsize_formats:
   "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
   fontsize: '6pt',
   
 menubar: true,
   plugins: [
   'print preview anchor ',
   'searchreplace visualblocks advcode fullscreen',
   'paste tinycomments',
   'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
   'wordcount formatpainter permanentpen pageembed checklist casechange'
   
 ],
 toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
 toolbar_drawer: 'sliding',
 permanentpen_properties: {
     fontname: 'helvetica,sans-serif,arial',
   forecolor: '#FF0000',
   fontsize: '6pt',
   hilitecolor: '',
   bold: true,
   italic: false,
   strikethrough: false,
   underline: false
 },
 tinycomments_mode: 'embedded',
     tinycomments_author: 'Supervisor',
 table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
 powerpaste_allow_local_images: true,
 powerpaste_word_import: 'prompt',
 powerpaste_html_import: 'prompt',
 spellchecker_language: 'es',
 spellchecker_dialog: true,
 browser_spellcheck: true,
 content_css: [
   '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
   '//www.tinymce.com/css/codepen.min.css']
});
 </script>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
   <?php
   $xSys->getMenu();
   ?>
</td></tr>

<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"], "Comprobante de Estudios");
      //--------------------------------------------------------------------------//

      //------------------------ Recepcion de par�metros -------------------------//
      if( isset($_GET["curp"]) ){
         $xPersona = New Persona($_GET["curp"]);
         $xInvDoc = New invDocumental( $_SESSION["curp"] );
         $_SESSION["xCurp"] = $xPersona->CURP;
      }
      else{
         $xPersona = New Persona($_SESSION["xCurp"]);
         $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
      }
      //--------------------------------------------------------------------------//

      $xInvDoc->getDatosGenerales();
      $Datos = $xInvDoc->getDatosCompEst();
      ?>

      <!--  se recibe la variable para controlar desde que modulo se accesa a esta pantalla
            investigacion documental o integracion de resultados -->
      <?php
        $_SESSION["ORIGEN"] = $_GET["mod_origen"];
      ?>
      <input type="hidden" value='<?php echo $_SESSION["ORIGEN"]; ?>' id="idModOrigen" name="mod_origen" />
      <!-- ------------------------------------------------------------------------------------------ -->

      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 9pt;">&nbsp; Datos requeridos</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">

	    <tr><td colspan="2">&nbsp;</td></tr>

        <!-- TIPO DE DOCUMENTO PARA VALIDAR-->
        <tr>
           <td class="styNCampoDGral">Tipo de documento para validar:<? echo $Datos[0]["FECHA_RESP"]; ?></td>
           <td class="styTdCampo">
              <select name="doc_validar" id="cbDocValidar" class="select">
                 <option value="0">-- Seleccione --</option>
                 <?php
                    $xInvDoc->shwInvDocValidarEstudios( $Datos[0]["DOC_VALIDAR"] );
                 ?>
              </select>
              <span style="color: redk; font-weight: bold;">*</span>
           </td>
        </tr>

         <?php

            if( $Datos[0]["DOC_VALIDAR"] == 7 ){
                $xTd = "";
            }else{
                $xTd = "display: none;";
            }
        ?>

        <!-- OTRO DOCUMENTO -->
        <tr id="trOtroDoc" style="<?php echo $xTd; ?>">
            <td class="styNCampoDGral">Otro Documento:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="otro_doc" name="otro_doc" size="50" maxlength="100" value='<?php echo $Datos[0]["OTRO_DOC"];?>' class="text" />
                <span style="color: black; font-weight: bold;">*</span>
            </td>
	    </tr>

        <!-- INSTITUCION QUE EXPIDE-->

        <?php

           if( $Datos[0]["DOC_VALIDAR"] == 8 ){
                  $Disa = 'disabled="disabled"';
           }else{

                $Disa = "";
           }

           if( $Datos[0]["DOC_VALIDAR"] == 9 ){
                  $Disan = 'disabled="disabled"';
           }else{

                $Disan = "";
           }
        ?>

        <tr id="trInsDoc" >
           <td class="styNCampoDGral">Instituci&oacute;n que exp&iacute;de:</td>
           <td class="styTdCampo">
              <select name="dep_expide" id="cbDependencia" style="max-width: 450px;" class="select" <?php echo $Disa; echo $Disan; ?> >
              <?php
			  if( empty($Datos[0]["DEP_EXPIDE"]) )
			  ?>
			  	<option value="0">-- Seleccione --</option>

                 <?php
                    $xInvDoc->shwInvDepExpCompEst( $Datos[0]["DEP_EXPIDE"] );
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
               <a href="#" id="addInstitucion" title="Agregar Institucion...">
                  <img src= "../../../imgs/add_cat_22.png" alt="Agregar" style="border: none; vertical-align: middle;" />
               </a>
               <div id="dlgInstitucion" class="dialog" title="Nueva Institucion">

                  <br />
         			<label for="txtInstitucion" style="font-size: 12px;">Instituci�n: </label>
                  <input type="text" name="xInstitucion" id="txtInstitucion" size="45" maxlength="55" class="text" style="font-size: 14px;" />
         		</div>
           </td>
        </tr>

        <!-- DATOS DE LA INSTITUCION-->
        <tr>
            <td class="styNCampoDGral">Datos de la Instituci&oacute;n:</td>
            <td class="styNCeldaDGral">
                <input type="text"  <?php echo $Disa; echo $Disan; ?> id="datos_int" name="datos_inst" size="60" value='<?php echo $Datos[0]["DATOS_INST"]; ?>' class="text" />
                <span style="color: black; font-weight: bold;">*</span>
            </td>
	    </tr>

        <!-- ENTIDAD -->
        <tr>
           <td class="styNCampoDGral">Entidad de la Instituci&oacute;n que expide:</td>
           <td class="styTdCampo">
              <select name="entidad" id="cbEntidad" class="select"  <?php echo $Disa; echo $Disan; ?>>
                 <option value="0">-- Seleccione --</option>
                 <?php
                    $xCat->shwEntidad( $xInvDoc->getIdEntidad( $Datos[0]["MUNICIPIO"] ) );
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>

        <!-- MUNICIPIO -->
        <tr>
           <td class="styNCampoDGral">Municipio de la Instituci&oacute;n que expide:</td>
           <td class="styTdCampo">
              <select name="municipio" id="cbMpio" class="select" style="max-width: 350px;"  <?php echo $Disa; echo $Disan;  ?>>
              <?php
                if( $Datos[0]["MUNICIPIO"] != '' ){

              ?><option value="0">-- Seleccione --</option><?php
                    $xCat->shwMunicipio( $Datos[0]["MUNICIPIO"], $xInvDoc->getIdEntidad( $Datos[0]["MUNICIPIO"] ) );

                }else{
              ?>
                    <option value="0">-- Vac&iacute;o --</option>
              <?php

              }

              ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>

        <!-- ESCOLARIDAD
        <tr>
               <td class="styTdNombreCampo" width="200">Nivel de Estudios:</td>
               <td class="styTdCampo" width="400">
                  <select name="nivel_estudios" id="cbNivelEstudios" class="select" style="max-width: 350px;">
                     <?php
                     //$xCat->shwNivEstudios($xPersona->NIVELEST);
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>
    <td class="styNCeldaDGral">
            <input type="text" id="escolaridad" readonly="readonly" name="escolaridad" size="30" value='<?php //echo $xPersona->getNivEstudios( $xPersona->NIVELEST );?>'/>
        </td>
    -->



    <tr id="trEscDoc">
        <td class="styNCampoDGral">Escolaridad:</td>

        <td class="styNCeldaDGral" width="400">
              <select name="escolaridad" id="cbEscolaridad" class="select" style="max-width: 350px;" <?php echo $Disa ?>>
                 <?php
                 $xCat->shwNivEstudios($xPersona->NIVELEST);
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>

    </tr>


    <!-- EFICIENCIA TERMINAL -->
    <tr id="trEfiDoc">
           <td class="styNCampoDGral" width="200">Eficiencia Terminal:</td>
           <td class="styNCeldaDGral">
              <select name="eficiencia" id="cbEficiencia"  class="select" style="max-width: 350px;" <?php echo $Disa ?>>
                  <?php
                  $xCat->shwStatEstudios($xPersona->STATEST);
                 ?>
              </select>

           </td>
        </tr>
    <!-- CARRERA -->
    <tr>
           <td class="styNCampoDGral">Carrera:</td>
           <td class="styTdCampo">
              <input name="carrera" id="txtCarrera" <?php echo $Disa ?> size="60" maxlength="100" value="<?php echo $xPersona->CARRERA;?>" class="text" />
              <span style="color: black; font-weight: bold;">*</span>
           </td>
        </tr>

        <!-- ESPECIALIDAD -->
        <tr>
           <td class="styNCampoDGral">Especialidad:</td>
           <td class="styTdCampo">
              <input name="ne_especialidad" id="txtEspecialidadE" <?php echo $Disa ?> size="60" maxlength="100" value="<?php echo $xPersona->ESPEST;?>" class="text" />
              <span style="color: black; font-weight: bold;">*</span>
           </td>
        </tr>

        <!-- PRESENTACION DEL DOCUMENTO ORIGINAL-->
        <tr>
           <td class="styNCampoDGral">Presentaci&oacute;n en Original :</td>
           <td class="styTdCampo">
              <select name="pre_original" id="cbPresentacionOriginal" class="select" <?php echo $Disa; echo $Disan; ?>>
                 <option value="0">-- Seleccione --</option>
                 <?php
                    $xInvDoc->shwInvDocPresentacionDoc( $Datos[0]["PRE_ORIGINAL"] );
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>

         <!-- DOCUMENTO EN RESGUARDO-->
        <tr>
           <td class="styNCampoDGral">Documento en Resguardo:</td>
           <td class="styTdCampo">
              <select name="doc_resguardo" id="cbDocResguardo" class="select" <?php echo $Disa; echo $Disan; ?>>
                 <option value="0">-- Seleccione --</option>
                 <?php
                    $xInvDoc->shwInvDocPresentacionDoc( $Datos[0]["DOC_RESGUARDO"] );
                 ?>
              </select>
               <span style="color: red; font-weight: bold;">*</span>

           </td>
        </tr>

        <!-- PRESENTACION DEL DOCUMENTO COPIA -->
        <tr>
           <td class="styNCampoDGral">Presentaci&oacute;n en Copia :</td>
           <td class="styTdCampo">
              <select name="pre_copia" id="cbPresentacionCopia" class="select" <?php echo $Disa; echo $Disan; ?>>
                 <option value="0">-- Seleccione --</option>
                 <?php
                    $xInvDoc->shwInvDocPresentacionDoc( $Datos[0]["PRE_COPIA"] );
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>

        <!-- FECHA SOLICIUD -->
        <tr>
            <td class="styNCampoDGral">Fecha de Solicitud:</td>



            <?php
			$fecha_sol = ( !empty($Datos[0]["FECHA_SOL"]) ) ? $xSys->FormatoCorto( date("d-m-Y", strtotime($Datos[0]["FECHA_SOL"])) ) : "";

              ?>
            <td class="styNCeldaDGral">
                <input type="text" id="fecha_sol" <?php echo $Disa; echo $Disan; ?> name="fecha_sol" size="15" class="textread" readonly="true" value='<?php echo $fecha_sol; ?>'/>

            </td>
	    </tr>

        <!-- NUMERO DE OFICIO DE SOLICIUD -->
        <tr>
            <td class="styNCampoDGral">N&uacute;mero de oficio de solicitud:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="num_oficio_sol" name="num_oficio_sol" size="30" maxlength="30" value='<?php echo $Datos[0]["NUM_OFICIO_SOL"]; ?>' class="text"  />

            </td>
	    </tr>

        <!-- FECHA DE RESPUESTA -->
        <tr>
            <td class="styNCampoDGral">Fecha de Respuesta:</td>
            <?php

				  $fecha_resp = ( !empty($Datos[0]["FECHA_RESP"]) ) ? $xSys->FormatoCorto( date("d-m-Y", strtotime($Datos[0]["FECHA_RESP"])) ) : "";

              ?>
            <td class="styNCeldaDGral">
                <input type="text" id="fecha_resp" <?php echo $Disa; echo $Disan; ?> name="fecha_resp" size="15" class="textread" readonly="true" value='<?php echo $fecha_resp; ?>'/>

            </td>
	    </tr>

        <!-- NUMERO DE OFICIO DE RESPUESTA -->
        <tr>
            <td class="styNCampoDGral">N&uacute;mero de oficio de respuesta:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="num_oficio_resp" name="num_oficio_resp" size="30" maxlength="30" value='<?php echo $Datos[0]["NUM_OFICIO_RESP"]; ?>' class="text" />

            </td>
	    </tr>

        <!-- RESULTADO-->

        <tr id="trResDoc" >
           <td class="styNCampoDGral">Resultado:</td>
           <td class="styTdCampo">
              <select name="resultado_comp_est" id="cbResultadoDoc" class="select" <?php echo $Disa; echo $Disan; ?>>
                 <option value="0">-- Seleccione --</option>
                 <?php
                    $xInvDoc->shwInvDocResultado( $Datos[0]["RESULTADO_COMP_EST"] );
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>
        <!-- RESULTADO EMITIDO POR LA DEPENDENCIA -->
        <tr>
            <td class="styNCampoDGral">Resultado oficial:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="result_ofi" name="result_ofi" size="45" maxlength="45" value='<?php echo $Datos[0]["RESULT_OFI"];?>' class="text"  />

            </td>
	    </tr>

        <!-- OBSERVACIONES -->
        <tr>
            <td class="styNCampoDGral">Observaciones:</td>
            <td class="styNCeldaDGral">
                <textarea id="observaciones" name="observaciones" cols="65" style='text-align:justify;font-size:11.0pt;font-family:"Calibri","serif";mso-bidi-font-family:
  Arial'rows="5" ><?php echo $Datos[0]["OBSERVACIONES"]; ?></textarea>
                <span style="color: black; font-weight: bold;">*</span>
            </td>
	    </tr>

        <!-- ANTECEDENTES DEL RESULTADO -->
        <tr>
            <td class="styNCampoDGral">Antecedentes del Resultado:</td>
            <td class="styNCeldaDGral">
                <textarea  id="antecedentes" name="antecedentes"style='text-align:justify;font-size:11.0pt;font-family:"Calibri","serif";mso-bidi-font-family:
  Arial' cols="65" rows="10" ><?php echo $Datos[0]["ANTECEDENTES"];?></textarea>
                <span style="color: black; font-weight: bold;">*</span>
            </td>
	    </tr>

        <!-- TR�MITE Y SEGUIMIENTO -->
        <tr>
           <td class="styNCampoDGral">Tr&aacute;mite y seguimiento:</td>
           <td class="styTdCampo">
              <input name="tramite" id="txtTramite" size="70" maxlength="90" value="<?php echo $Datos[0]["TRAMITE"];?>" class="text" />
              <span style="color: black; font-weight: bold;">*</span>
           </td>
        </tr>

         </table>
      </fieldset>

      <br />
      <?php
      if(  $xInvDoc->ExistIdCompEst() ){
      ?>
      <table class="stytbOpciones" style="width: 600px;" cellpadding="0" cellspacing="0" border="0">
         <tr>
            <td id="tdMsjLoad" style="width: 320px; text-align: right;"> &nbsp; </td>
            <td id="tdBtns" style="width: 180px; text-align: right;">
               <a href="#" id="xFormato" class="ui-button ui-corner-all ui-widget styxBtnOpcion" title="Vista previa del formato">
                  <img src="<?php echo $xPath;?>imgs/print_pdf.png" border="0" />
                  <br />Formato
               </a>
            </td>
            <td id="tdBtns2" style="width: 180px; text-align: right;">
               <a href="#" id="xFormatoWord" class="ui-button ui-corner-all ui-widget styxBtnOpcion" title="Vista previa del formato">
                  <img src="<?php echo $xPath;?>imgs/word.png" border="0" />
                  <br />Word
               </a>
            </td>
         </tr>
      </table>
      <?php
      }
      ?>
      <br />

      <fieldset id="fsBotones" style="width: 700px;">
         <table class="stytbBotones" cellpadding="0" cellspacing="0">
            <tr>
            <?php
            if( empty($xUsr->xCurpEval) || ( $xUsr->xNomPerfil != "INVESTIGADOR" ) || ( !$xInvDoc->ExistIdDatosGenerales() ) ){
            ?>
               <td width="100%" align="left">
                  <input type="button" name="btnCancelar" id="xCancelar" value="Regresar" class="ui-button ui-corner-all ui-widget" />
               </td>
            <?php
            }
            else{
            ?>
               <td width="30%" align="right">
                  <input type="submit" name="btnAceptar" value="Guardar" class="ui-button ui-corner-all ui-widget" />
               </td>
               <td width="40%">&nbsp;</td>
               <td width="30%" align="left">
                  <input type="button" name="btnCancelar" id="xCancelar" value="Regresar" class="ui-button ui-corner-all ui-widget" />
               </td>
            <?php
            }
            ?>
            </tr>
         </table>
      </fieldset>
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
