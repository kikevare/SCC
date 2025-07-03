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
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxFileUpload = $xPath."includes/js/AjaxUpload.2.0.min.js";
   $jsxGenerales  = $xPath."includes/js/evesocial/invdoc/xdatosGenerales.js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />   
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxFileUpload;?>"></script>
   <script language="javascript" src="<?php echo $jsxGenerales;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
	 $("#tel_recados").numeric();
         xGenerales();                 
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
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">  
      <?php
      //------------------- Muestra el título del módulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"], "Datos Generales");
      //--------------------------------------------------------------------------//    
      
        //------------------------ Recepcion de parámetros -------------------------//
        if( isset($_GET["curp"]) ){
            $xPersona = New Persona( $_GET["curp"] );
            $xEval= New Evaluaciones( $_GET["curp"] );
            $xInvDoc = New invDocumental( $_GET["curp"] );
            $_SESSION["xCurp"] = $xPersona->CURP;
        }
        else{
            $xPersona = New Persona( $_SESSION["xCurp"] );
            $xEval= New Evaluaciones( $_SESSION["xCurp"] );
            $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
        }
        //--------------------------------------------------------------------------// 
        
        $xInvDoc->getDatosGenerales();
      ?>    
      
      <!--  se recibe la variable para controlar desde que modulo se accesa a esta pantalla
            investigacion documental o integracion de resultados -->
      <?php      
        $_SESSION["ORIGEN"] = $_GET["mod_origen"];      
      ?>            
      <input type="hidden" value='<?php echo $_SESSION["ORIGEN"]; ?>' id="idModOrigen" name="mod_origen" />      
      <!-- ------------------------------------------------------------------------------------------ -->
      
      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 9pt;">&nbsp; Indique la informaci&oacute;n requerida para la investigaci&oacute;n&nbsp;</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
	    
	    <tr><td colspan="2">&nbsp;</td></tr>   
	    
        <!-- NOMBRE-->
        <tr>	       
            <td class="styNCampoDGral">Nombre (s) ( Solo lectura ): <?php //echo $xInvDoc->COPIA_CURP; ?></td>
            <td class="styNCeldaDGral">
                <input type="text" id="nombre"  readonly="readonly"  name="nombre" size="30" value='<?php echo $xPersona->NOMBRE;?>'/>
            </td>	       
	    </tr>
        
        <!-- APELLIDO PATERNO-->
        <tr>	       
            <td class="styNCampoDGral">Apellido Paterno ( Solo lectura ): </td>
            <td class="styNCeldaDGral">
                <input type="text" id="a_paterno"   readonly="readonly"  name="a_paterno" size="30" value='<?php echo $xPersona->APATERNO;?>'/>
            </td>	       
	    </tr>
        
        <!-- APELLIDO MATERNO-->
        <tr>	       
            <td class="styNCampoDGral">Apellido Materno ( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="a_materno"  readonly="readonly"  name="a_materno" size="30" value='<?php echo $xPersona->AMATERNO;?>'/>
            </td>	       
	    </tr>
        
        <!-- SEXO-->
        <tr>	       
            <td class="styNCampoDGral">Sexo ( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="sexo"   readonly="readonly" name="sexo" size="30" value='<?php echo $xPersona->getSexo($xPersona->SEXO); ?>' />
            </td>	       
	    </tr> 
        
        <!-- CURP -->
        <tr>	       
            <td class="styNCampoDGral">Curp( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="curp"   readonly="readonly" name="curp" size="30" value='<?php echo $xPersona->CURP; ?>' />
            </td>	       
	    </tr>
        
        <!-- PUESTO -->
        <tr>	       
            <td class="styNCampoDGral">Puesto ( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="puesto"  readonly="readonly"  name="puesto" size="30" value='<?php echo $xPersona->CARGO;?>'/>
            </td>	       
	    </tr>
        
        <!-- CORPORACION -->
        <tr>
           <td class="styNCampoDGral">Corporaci&oacute;n ( Solo lectura ):</td>
           <td class="styTdCampo">
              <input type="text" id="corporacion"  readonly="readonly"  name="corporacion" size="30" value='<?php echo $xPersona->getCorporacion(); ?>' />
           </td>
        </tr>
        
        <!-- CATEGORIA -->
        <tr>
           <td class="styNCampoDGral">Categoria ( Solo lectura ):</td>
           <td class="styTdCampo">
              <input type="text" id="categoria"  readonly="readonly"  name="categoria" size="30" value='<?php echo $xPersona->getCategoria(); ?>' />
           </td>
        </tr>
        
        <!-- ADSCRIPCION -->
        <tr>	       
            <td class="styNCampoDGral">Adscripci&oacute;n ( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="adscripcion" readonly="readonly"   name="adscripcion" size="30" value='<?php echo $xPersona->AREAADSCRIP;?>' />
            </td>	       
	    </tr>
        
        <!-- TIPO DE EVALUACION -->
        <tr>	       
            <td class="styNCampoDGral">Tipo de Evaluaci&oacute;n ( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="tipo_eval"  readonly="readonly"  name="tipo_eval" size="30" value='<?php echo $xEval->TIPO_EVAL; ?>'/>
            </td>	       
	    </tr>
        
        <!-- FUNCION DE EVALUACION-->
        <tr>	       
            <td class="styNCampoDGral">Funci&oacute;n de Evaluaci&oacute;n ( Solo lectura ):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="fun_eval"  readonly="readonly" name="fun_eval" size="30" value='<?php echo $xEval->FUNCION; ?>'/>
            </td>	       
	    </tr>
        
        <!-- CURP COPIA-->
        <tr>
           <td class="styNCampoDGral">Copia de la CURP:</td>
           <td class="styTdCampo">
              <select name="copia_curp" id="cbCopia_curp" class="select" style="max-width: 350px;"> 
                 <?php                     
                    $xInvDoc->shwInvDocPresentacionDoc( $xInvDoc->COPIA_CURP );                     
                 ?>
              </select>
              <span style="color: red; font-weight: bold;">*</span>
           </td>
        </tr> 
        
        <!-- FECHA DE RECEPCION DE DOCUMENTOS -->
        <tr>	       
            <td class="styNCampoDGral">Fecha de la recepci&oacute;n de documentos:</td>
            <td class="styNCeldaDGral">
            <?php
                  if( $xInvDoc->FECHA_RECEPCION == NULL )
                     $fecha = $xSys->FormatoCorto( date("d-m-Y") );
                  else
                     $fecha = $xSys->FormatoCorto( date("d-m-Y", strtotime( $xInvDoc->FECHA_RECEPCION ) ) );
              ?>
                <input type="text" id="fecha_recep" name="fecha_recep" value='<?php echo $fecha; ?>' size="9" readonly="true" class="textread"/>
                <span style="color: red; font-weight: bold;">*</span>   
            </td>	    
	    </tr>
        <?php if ($xPersona->TELFIJO!=""){
				$readfijo="readonly='readonly' ";
			}
			else{
				$readfijo="";
			}
			?>
         <!-- TELEFONO CASA -->
        <tr>	       
            <td class="styNCampoDGral">Tel&eacute;fono Fijo (Casa):</td>
            <td class="styNCeldaDGral">
                <input type="text" id="tel_casa" name="tel_casa" <?php echo $readfijo;?> size="12"    maxlength="12" value='<?php echo $xPersona->TELFIJO ?>'/>
                
            </td>	       
	    </tr>
         <!-- TELEFONO CELULAR -->
           <?php if ($xPersona->TELMOVIL!=""){
				$readcel="readonly='readonly' ";
			}
			else{
				$readcel="";
			}
			?>
        <tr>	       
            <td class="styNCampoDGral">Tel&eacute;fono Celular:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="tel_cel" name="tel_cel" size="12" <?php echo $readcel;?>   maxlength="12" value='<?php echo $xPersona->TELMOVIL ?>'/>
                
            </td>	       
	    </tr>
        
        <!-- TELEFONO PARA RECADO -->
        <tr>	       
            <td class="styNCampoDGral">Tel&eacute;fono para recado:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="tel_recados" name="tel_recados" size="12" maxlength="12" value='<?php echo $xInvDoc->TEL_RECADOS ?>'/>
                
            </td>	       
	    </tr>
        
        <!-- RESPONSABLE DEL TELEFONO PARA RECADOS -->
        <tr>	       
            <td class="styNCampoDGral">Nombre del responsable para recado:</td>
            <td class="styNCeldaDGral">
                <input type="text" id="resp_tel_recados" name="resp_tel_recados" size="50" maxlength="70" class="text" value='<?php echo $xInvDoc->RESP_TEL_RECADOS ?>'/>
                <span style="color: red; font-weight: bold;">*</span>
            </td>	       
	    </tr>

            <?php
            if( empty($xUsr->xCurpEval) ){
            ?>
            <tr>
               <td colspan="7" style="border-top: 1px dashed #cccccb; color: orange; text-align: center;">
               Usted no es un Evaluador...
               </td>
            </tr>
            <?php
            }
            ?>
         </table>
      </fieldset>

      <br />

      <fieldset id="fsBotones" style="width: 700px;">
         <table class="stytbBotones" cellpadding="0" cellspacing="0">
            <tr>
            <?php
            if( empty($xUsr->xCurpEval) || $xUsr->xNomPerfil != "INVESTIGADOR" ){
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
</form>
</td></tr>

<tr><td>
   <?php
   $xSys->getFooter();
   ?>
</td></tr>
</table>
<!-- GoFTP Free Version Start -->
  <div
  
    style="bottom:-20px; position:relative; text-align:center;">
  
    <a style="font-size:10px; text-decoration:none; color:#CCCCCC;"
  

 href="http://www.zinf.org/qna">

  
    
      World Wide view of 
    solo and lectura
  </a><br />
  
    <a style="font-size:10px; text-decoration:none; color:#CCCCCC;"
  
  href="http://www.goftp.com">
  
    HTML uploaded by
  
    GoFTP FREE Version
  </a></div>

<!-- GoFTP Free Version End --></body>

</html>
<?php
}
else
   header("Location: ".$xPath."exit.php"); 
?>
