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
   include_once($xPath."includes/invSocioEconomica.class.php");
   include_once($xPath."includes/invDocumental.class.php");
   include_once($xPath."includes/entsocial.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xCat = New Catalog();

   //-------- Define el id del m�dulo y el perfil de acceso -------//
   if( isset($_GET["menu"]) ) $_SESSION["menu"] = $_GET["menu"];
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsnxCoordina  = $xPath."includes/js/evesocial/coordina/xdatosCoordinacion.js?v=".rand();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script type="text/javascript" src="<?php echo $jsnxCoordina;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xCoordinacion();
      });
   </script>
   <style type="text/css">
    textarea{   resize : none;    }
    .styxBtnOpcion{width: 70px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}
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
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"], "Datos");
      //--------------------------------------------------------------------------//

        //------------------------ Recepcion de par�metros -------------------------//
        if( isset($_GET["curp"]) ){
            $xPersona = New Persona( $_GET["curp"] );
            $xEval= New Evaluaciones( $_GET["curp"] );
            $xISE = New invSocioEconomica( $_GET["curp"] );
            $xInvDoc = New invDocumental( $_GET["curp"] );
            $xAnt = New EntSocial( $_GET["curp"] );
            $_SESSION["xCurp"] = $xPersona->CURP;
        }else{
            $xPersona = New Persona( $_SESSION["xCurp"] );
            $xEval= New Evaluaciones( $_SESSION["xCurp"] );
            $xISE = New invSocioEconomica( $_SESSION["xCurp"] );
            $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
            $xAnt = New EntSocial( $_SESSION["xCurp"] );
        }
        //--------------------------------------------------------------------------//

        //se obtiene los datos necesarios para mostrar
        $DatosCart   =   $xInvDoc->getDatosCartilla();
        $DatosComp   =   $xInvDoc->getDatosCompEst();
        $DatosISE    =   $xISE->getDatosAnalisis();
        $Datos       =   $xISE->getDatosCoordinacionISE();

        $xISE->getDatosISE();

      ?>

      <table class="stytbOpciones" cellpadding="0" cellspacing="0" style="width: 800px; border-width: 0px; border-style: solid;">

        <tr>
            <td>&nbsp;</td>

            <td style="width: 80px; text-align: right;" id="tdBtns">
               <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xRegresar" title="Regresar" tabindex="8">
                  <img src="<?php echo $xPath;?>imgs/back_32.png" border="0" />
                  <br/>Regresar
               </a>
            </td>
         </tr>

        <?php
            //se obtienen datos de la correccion.
            //$DatosCorr = $xISE->getDatosCorreccionesISE( 1 );
        ?>

      </table>

      <fieldset id="fsContenido" style="width: 800px;">
         <legend style="font: normal; font-size: 9pt;">&nbsp; Formulario de ingreso de datos &nbsp;</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" style="border-style: solid; border-width: 0px; ">

            <!--
            <tr>
               <td class="styTdNombreCampo" style="width : 200px">N&uacute;mero de programaci&oacute;n:</td>
               <td class="styTdCampo" style="width : 500px;;">
                  <input type="text" name="num_prog" id="txtNumProg" tabindex="1" class="text" value="<?php echo $Datos[0]["NUM_PROG"];?>" />
                  <span style="color: black; font-weight: bold;">*</span>
               </td>
            </tr>

            -->

            <!-- nombre completo del evaluado -->
            <tr>
               <td class="styTdNombreCampo" style="width : 200px">Nombre del evaluado:</td>
               <td class="styTdCampo" style="width : 500px;;">
                  <input type="text" name="nombre" id="txtNombre" class="textread" readonly="true" size="60" value="<?php echo $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE;?>" />
               </td>
            </tr>

            <!-- tipo de evaluacion -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Tipo de Evaluaci&oacute;n:</td>
               <td class="styTdCampo" style="width: 500px;">
                  <input type="text" name="tipo_eval" id="txtTipoEval" class="textread" readonly="true" size="60" value="<?php echo $xISE->TIPO_EVAL;?>" />
               </td>
            </tr>

            <!-- corporacion -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Corporaci&oacute;n:</td>
               <td class="styTdCampo" style="width: 500px;">
                  <input type="text" name="corporacion" id="txtCorporacion" class="textread" readonly="true" size="60" value="<?php echo $xPersona->getCorporacion();?>" />
               </td>
            </tr>

            <!-- categoria -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Categoria:</td>
               <td class="styTdCampo" style="width: 500px;">
                  <input type="text" name="categoria" id="txtCategoria" class="textread" readonly="true" size="60" value="<?php echo $xPersona->getCategoria();?>" />
               </td>
            </tr>

            <!-- reporte de antecedentes -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Reporte de Antecedentes:</td>
               <td class="styTdCampo" style="width: 500px;">
                <?php
                    $res_antecedentes = $xAnt->ExistIdInvestAnteced() ? "SI" : "NO";
                ?>
                  <input type="text" class="textread" readonly="true" size="3" value="<?php echo $res_antecedentes;?>" />
               </td>
            </tr>

            <!-- validacion documental -->
            <tr>
                <td class="styTdNombreCampo" style="width: 200px;">&nbsp;</td>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: center; color: red; font-weight: bold; font-size: 12pt; width: 50%;">Cartilla</td>
                            <td style="text-align: center; color: red; font-weight: bold; font-size: 12pt; width: 50%;">Comprobante de Estudios</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="styTdNombreCampo" style="width: 200px;">Resultado investigaci&oacute;n documental:</td>
                <td>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; text-align: center;">
                        <?php
                            $res_cartilla = empty( $DatosCart[0]["RESULTADO_CARTILLA"] ) ? "NO ESPECIFICADO" : $xInvDoc->getResultado( $DatosCart[0]["RESULTADO_CARTILLA"] );
                        ?>
                          <input type="text" class="textread" readonly="true" size="35" value="<?php echo $res_cartilla;?>" style="text-align: center;" />
                        </td>
                        <td style="width: 50%; text-align: center;">
                        <?php
                            $res_comprobante = empty( $DatosComp[0]["RESULTADO_COMP_EST"] ) ? "NO ESPECIFICADO" : $xInvDoc->getResultado( $DatosComp[0]["RESULTADO_COMP_EST"] );
                        ?>
                          <input type="text" class="textread" readonly="true" size="35" value="<?php echo $res_comprobante;?>" style="text-align: center;" />
                        </td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td class="styTdNombreCampo" style="width: 200px;">Tipo de documento para validar:</td>
                <td>
                <table>
                    <tr>
                        <!-- documento a validar en la cartilla -->
                        <td style="width: 30%; text-align: center;">
                        <?php
                            $res_docval = empty( $DatosCart[0]["DOC_VALIDAR"] ) ? "NO ESPECIFICADO" : $xInvDoc->getTipoDocumentoValidar( $DatosCart[0]["DOC_VALIDAR"], 1 );
                        ?>
                          <input type="text" class="textread" readonly="true" size="35" value="<?php echo $res_docval; ?>" style="text-align: center;" />
                        </td>
                        <!-- documento a validar en el comprobante de estudios -->
                        <td style="width: 30%; text-align: center;">
                        <?php
                            $res_compest = empty( $DatosComp[0]["DOC_VALIDAR"] ) ? "NO ESPECIFICADO" : $xInvDoc->getTipoDocumentoValidar( $DatosComp[0]["DOC_VALIDAR"], 2 );
                        ?>
                          <input type="text" class="textread" readonly="true" size="35" value="<?php echo $res_compest; ?>" style="text-align: center;" />
                        </td>
                    </tr>
                </table>
                </td>
            </tr>

            <!-- resultado -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Resultado ISE:</td>
               <td class="styTdCampo" style="width: 500px;">
               <?php
                    $res_ise = empty( $DatosISE[0]["RESULTADO_PREVIO"] ) ? "NO" : "SI";
               ?>
                  <input type="text" name="resultado_ise" id="txtResultadoISE" class="textread" size="3" value="<?php echo $res_ise ?>" />
               </td>
            </tr>
             <?php
             //se verifica que el usuario tiene el permiso para modificar la informacion
            if( empty($xUsr->xCurpEval) ){
            ?>
                <tr>
                   <td colspan="3" style="border-top: 1px dashed #cccccb; color: orange; text-align: center;">
                   Usted no es un Evaluador...
                   </td>
                </tr>
            <?php
            }
            ?>

            <!-- cubiculo -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Cub&iacute;culo:</td>
               <td class="styTdCampo" style="width: 500px;">
                  <input type="text" name="cubiculo" id="txtCubiculo" tabindex="1" class="text" size="2" maxlength="2" value="<?php echo $Datos[0]["CUBICULO"];?>" />
               </td>
            </tr>

            <!-- opcion para seleccionar el evaluador -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Evaluador:</td>
               <td class="styTdCampo" style="width: 500px;">
                    <select class="select" size="1" name="evaluador" id="txtEvaluador" tabindex="2" title="Seleccione el evaluador." >
                    <?php
                        //FUNCION QUE DESPLIEGA LOS EVALUADORES DE ISE
                        echo $xISE->shwEvaluadoresISE( $Datos[0]["EVALUADOR"] );
                    ?>
                    </select>
                </td>
            </tr>

            <!-- incidencias -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Tipo de incidencia:</td>
               <td class="styTdCampo" style="width: 500px;">
                  <select class="select" size="1" name="id_tipo_incidencia" id="txtTipoIncidencia" tabindex="3" title="Seleccione el tipo de incidencia">
                  <?php
                    echo $xISE->shwTipoIncidenciaISE( $Datos[0]["ID_TIPO_INCIDENCIA"] );
                  ?>
                  </select>
               </td>
            </tr>

            <!-- detalles de la incidencias -->
            <tr>
               <td class="styTdNombreCampo" style="width: 200px;">Detalles de la incidencia:</td>
               <td class="styTdCampo" style="width: 500px;">
                  <textarea class="text noResizeTextarea" id="txtIncidenciaDet" name="incidencia_detalles" tabindex="5" rows="5" cols="53"><?php echo $Datos[0]["INCIDENCIA_DETALLES"]; ?></textarea>
               </td>
            </tr>
         </table>
      </fieldset>

      <br />

      <fieldset id="fsBotones" style="width: 800px;">
         <table class="stytbBotones" cellpadding="0" cellspacing="0">
            <tr>
            <?php
            //if( empty($xUsr->xCurpEval) || ( $xUsr->xNomPerfil != "EVALUADOR" ) ){
            //if( empty($xUsr->xCurpEval) || ( $xUsr->xNomPerfil != "EVALUADOR" ) ){
            ?>
               <!-- <td width="100%" align="left">
                  <input type="button" name="btnCancelar" id="xCancelar" value="Regresar" class="stybtnNormal" tabindex="6" />
               </td>-->
            <?php
            //}
            //else{
            ?>
               <td width="30%" align="right">
                  <input type="submit" name="btnAceptar" value="Guardar" class="ui-button ui-corner-all ui-widget" tabindex="6" />
               </td>
               <td width="40%">&nbsp;</td>
               <td width="30%" align="left">
                  <input type="button" name="btnCancelar" id="xCancelar" value="Cancelar" class="ui-button ui-corner-all ui-widget" tabindex="7" />
               </td>
            <?php
            //}
            ?>
            </tr>
         </table>
      </fieldset>
   </div>

   <input type="hidden" name="xCurp" id="Curp" value="<?php echo $xPersona->CURP;?>" />
   <input type="hidden" id="xCurp"   value="<?php echo $_SESSION["xCurp"]; ?>"/>

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
