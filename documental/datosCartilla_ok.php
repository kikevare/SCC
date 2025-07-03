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
   
   //-------- Define el id del módulo y el perfil de acceso -------//
   if( isset($_GET["menu"]) ) $_SESSION["menu"] = $_GET["menu"];
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//
   
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css"; 
   $cssEditor     = $xPath."includes/js/cleditor/jquery.cleditor.css";  
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxFileUpload = $xPath."includes/js/AjaxUpload.2.0.min.js";
   $jsxEditor	  = $xPath."includes/js/tiny_mce/tiny_mce.js";
   $jsxCartilla   = $xPath."includes/js/evesocial/invdoc/xdatosCartilla.js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />   
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
  
   <script language="javascript" src="<?php echo $jsxEditor;?>"></script>
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
 
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxFileUpload;?>"></script>
   <script language="javascript" src="<?php echo $jsxCartilla;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
        xCartilla();
           
                            
      });
   </script>   
    <script type="text/javascript">
    tinyMCE.init({        
         mode : "textareas",        
		 theme : "advanced",       
		  plugins :"table,inlinepopups,preview,print,paste,template",       
		       theme_advanced_buttons1 : "bold,justifyfull",   
			   theme_advanced_buttons2 :"",        
			   theme_advanced_buttons3 : "",
			   theme_advanced_buttons4 :"",  
			   theme_advanced_toolbar_location : "top",        
			   theme_advanced_toolbar_align : "left",        
			   theme_advanced_statusbar_location : "bottom",
			   theme_advanced_resizing : true,        
			   content_css : "../../includes/js/tiny_mce/css/content.css",        
			   template_replace_values : {username : "Some User",staffid : "991234"    
   }});   
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
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">  
      <?php
      //------------------- Muestra el título del módulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"], "Cartilla");
      //--------------------------------------------------------------------------//    
      
        //------------------------ Recepcion de parámetros -------------------------//
        if( isset($_GET["curp"]) ){
            $xPersona = New Persona($_GET["curp"]);
            $xInvDoc = New invDocumental( $_GET["curp"] );
            $_SESSION["xCurp"] = $xPersona->CURP;
        }
        else{
            $xPersona = New Persona($_SESSION["xCurp"]);
            $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
        }
        //--------------------------------------------------------------------------// 
      
      $Datos = $xInvDoc->getDatosCartilla();

      ?>    
      
      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 9pt;">&nbsp; Datos requeridos <?php //echo $xInvDoc->LASTIDEVAL; ?></legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
	    
	    <tr><td colspan="2">&nbsp;</td></tr>   
        
        <!-- TIPO DE DOCUMENTO PARA VALIDAR-->
        <tr>
           <td class="styNCampoDGral">Tipo de documento para validar:</td>
           <td class="styTdCampo">
              <select name="doc_validar" id="cbDocValidar" class="select"> 
                 <option value="0">-- Seleccione --</option>                    
                 <?php                     
                    $xInvDoc->shwInvDocValidarCartilla( $Datos[0]["DOC_VALIDAR"] );                     
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>
       
        <?php
        
            if( $Datos[0]["DOC_VALIDAR"] == 6 ){
                $xTd = "display: block;";             
            }else{
                $xTd = "display: none;";
            }
        ?>
        
        <!-- OTRO DOCUMENTO -->
        <tr>	       
            <td class="styNCampoDGral" style="<?php echo $xTd; ?>" id="td_otro_doc1">Otro Documento:</td>
            <td class="styNCeldaDGral" style="<?php echo $xTd; ?>" id="td_otro_doc2">
                <input type="text" id="otro_doc" name="otro_doc" size="50" maxlength="100" value='<?php echo $Datos[0]["OTRO_DOC"];?>' />
                <span style="color: black; font-weight: bold;">*</span>
            </td>	       
	    </tr>
        
        <!-- DEPENDENCIA QUE EXPIDE-->
        <tr>
           <td class="styNCampoDGral">Zona Militar que exp&iacute;de:</td>
           <td class="styTdCampo">
              <select name="dep_expide" id="cbDepExpide" class="select"> 
              <?php 
			  if( empty($Datos[0]["DEP_EXPIDE"]) )
			  ?>
			  	<option value="0">-- Seleccione --</option> 
			                       
                 <?php                     
                    $xInvDoc->shwInvDepExpCartilla( $Datos[0]["DEP_EXPIDE"] );                     
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
              <!--
               <a href="#" id="addZona" title="Agregar Zona Militar...">
                  <img src= "../../../imgs/add_cat_22.png" alt="Agregar" style="border: none; vertical-align: middle;" />
               </a> 
               <div id="dlgZona" class="dialog" title="Nueva Zona">
                  <br />
         			<label for="txtZona" style="font-size: 12px;">Zona Militar: </label>
                  <input type="text" name="xzona" id="txtZona" size="45" maxlength="55" class="text" style="font-size: 14px;" />
         		</div> 
                 -->         
           </td>
        </tr>     
        
        <tr>
        <?php                     
            $xDatos=$xInvDoc->getZona($Datos[0]["DEP_EXPIDE"])                     
        ?>   
             
        <!-- ENTIDAD -->
        <tr>
           <td class="styNCampoDGral">Entidad de Instituci&oacute;n que expide:</td>
           <td class="styTdCampo">
              <input type="text" id="entidad" name="entidad" size="60" readonly="true" value='<?php echo $xDatos["ENTIDAD"];?>' />
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>         
        
        <!-- MUNICIPIO -->
        <tr>
           <td class="styNCampoDGral">Municipio de la Instituci&oacute;n que expide:</td>
           <td class="styTdCampo">
              <input type="text" id="municipio" name="municipio" size="60" readonly="true" value='<?php echo $xDatos["MUNICIPIO"];?>' />
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr>
        
        <!-- DATOS DE LA INSTITUCION
        <tr>	       
            <td class="styNCampoDGral">Datos de la Instituci&oacute;n:</td>
            <td class="styNCeldaDGral">
                <textarea id="datos_inst" name="datos_inst" cols="35" rows="3" ><?php echo $Datos[0]["DATOS_INST"];?></textarea>
                <span style="color: red; font-weight: bold;">*</span>
            </td>	       
	    </tr>
        -->
        <!-- MATRICULA-->
        <tr>	       
            <td class="styNCampoDGral">Matricula:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="matricula" name="matricula" size="20" value='<?php echo $xPersona->CARTILLA;?>' />
                <span style="color: red; font-weight: bold;">*</span>
            </td>	       
	    </tr>
        
        <!-- AÑO
        <tr>	       
            <td class="styNCampoDGral">Año:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="year" name="year" size="5" maxlength="4" value='<?php echo $Datos[0]["YEAR"]; ?>' class="entero" />
                <span style="color: black; font-weight: bold;">*</span>
            </td>	       
	    </tr>-->
        
        <!-- CLASE -->
        <tr>	       
            <td class="styNCampoDGral">Clase:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="clase" name="clase" size="5" maxlength="4" value='<?php echo $Datos[0]["CLASE"]; ?>'  />
                <span style="color: black; font-weight: bold;">*</span>
            </td>	       
	    </tr>
        
        <!-- PRESENTACION DEL DOCUMENTO ORIGINAL-->
        <tr>
           <td class="styNCampoDGral">Presentaci&oacute;n en Original:</td>
           <td class="styTdCampo">
              <select name="pre_original" id="cbPresentacionOriginal" class="select"> 
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
              <select name="doc_resguardo" id="cbDocResguardo" class="select"> 
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
           <td class="styNCampoDGral">Presentaci&oacute;n en Copia:</td>
           <td class="styTdCampo">
              <select name="pre_copia" id="cbPresentacionCopia" class="select"> 
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
                <input type="text" id="fecha_sol" name="fecha_sol" size="12" class="textread" readonly="true" value='<?php echo $fecha_sol; ?>'/>
             
            </td>	       
	    </tr>
        
        <!-- NUMERO DE OFICIO DE SOLICIUD -->
        <tr>	       
            <td class="styNCampoDGral">N&uacute;mero de oficio de solicitud:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="num_oficio_sol" name="num_oficio_sol" size="22" maxlength="22" value='<?php echo $Datos[0]["NUM_OFICIO_SOL"];?>'  />
                
            </td>	       
	    </tr>

        <!-- FECHA DE RESPUESTA -->
        <tr>	       
            <td class="styNCampoDGral">Fecha de Respuesta:</td>
            <?php
                    $fecha_resp = ( !empty($Datos[0]["FECHA_RESP"]) ) ? $xSys->FormatoCorto( date("d-m-Y", strtotime($Datos[0]["FECHA_RESP"])) ) : "";
				 
              ?>
            <td class="styNCeldaDGral">
                <input type="text" id="fecha_resp" name="fecha_resp" size="12" class="textread" readonly="true" value='<?php echo $fecha_resp; ?>'/>
               
            </td>	       
	    </tr>
        
        <!-- NUMERO DE OFICIO DE RESPUESTA -->
        <tr>	       
            <td class="styNCampoDGral">N&uacute;mero de oficio de respuesta:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="num_oficio_resp" name="num_oficio_resp" size="22" maxlength="22" value='<?php echo $Datos[0]["NUM_OFICIO_RESP"];?>'  />
                
            </td>	       
	    </tr>
        
        <!-- RESULTADO-->
        <tr>
           <td class="styNCampoDGral">Resultado:</td>
           <td class="styTdCampo">
              <select name="resultado_cartilla" id="cbResultadoCartilla" class="select"> 
                 <option value="0">-- Seleccione --</option>                    
                 <?php                     
                    $xInvDoc->shwInvDocResultado( $Datos[0]["RESULTADO_CARTILLA"] );                     
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr> 
        
        <!-- OBSERVACIONES -->
        <tr>	       
            <td class="styNCampoDGral">Observaciones:</td>
            <td class="styNCeldaDGral">
                <textarea  id="observaciones" name="observaciones" cols="65" rows="8" ><?php echo $Datos[0]["OBSERVACIONES"];?></textarea>
                <span style="color: black; font-weight: bold;">*</span>
            </td>	       
	    </tr>
        
        <!-- ANTECEDENTES DEL RESULTADO -->
        <tr>	       
            <td class="styNCampoDGral">Antecedentes del Resultado:</td>
            <td class="styNCeldaDGral">
                <textarea  id="antecedentes" name="antecedentes" cols="65" rows="10" ><?php echo $Datos[0]["ANTECEDENTES"];?></textarea>
                <span style="color: black; font-weight: bold;">*</span>
            </td>	       
	    </tr>
        
        <!-- TRÁMITE Y SEGUIMIENTO -->
        <tr>
           <td class="styNCampoDGral">Trámite y seguimiento:</td>
           <td class="styTdCampo">                     
              <input name="tramite" id="txtTramite" size="70" maxlength="90" value="<?php echo $Datos[0]["TRAMITE"];?>" class="text" />
              <span style="color: black; font-weight: bold;">*</span>
           </td>
        </tr> 
        
         </table>
      </fieldset>

      <br />
      <?php
      if(  $xInvDoc->ExistIdCartilla() ){
      ?>        
      <table class="stytbOpciones" style="width: 600px;" cellpadding="0" cellspacing="0" border="0">
         <tr>
            <td id="tdMsjLoad" style="width: 320px; text-align: right;"> &nbsp; </td>
            <td id="tdBtns" style="width: 180px; text-align: right;">
               <a href="#" id="xFormato" style="width: 75px; height: 45px; font-size: 7pt;" title="Vista previa del formato...">
                  <img src="<?php echo $xPath;?>imgs/print_pdf.png" border="0" />
                  <br />Formato                   
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
            if( empty($xUsr->xCurpEval) && ( $xUsr->xNomPerfil != "INVESTIGADOR" ) || ( !$xInvDoc->ExistIdDatosGenerales() ) ){
            ?>
               <td width="100%" align="left">
                  <input type="button" name="btnCancelar" id="xCancelar" value="Regresar"class="stybtnNormal" />
               </td>
            <?php
            }
            else{
            ?>               
               <td width="30%" align="right">
                  <input type="submit" name="btnAceptar" value="Guardar" class="stybtnNormal"/>
               </td>
               <td width="40%">&nbsp;</td>
               <td width="30%" align="left">
                  <input type="button" name="btnCancelar" id="xCancelar" value="Cancelar"class="stybtnNormal" />
               </td>
            <?php
            }
            ?>
            </tr>
         </table>
      </fieldset>   
   </div>  
   <input type="hidden" name="mpio" id="id_mpio" value="" />   
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