<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/catalogos.class.php");
   $xSys = New System();
   $xCat = New Catalog();
   
   //-- Define los directorios de scripts js y css...

   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxCurp       = $xPath."includes/js/curp.js";
   $jsxDatPer     = $xPath."includes/js/xdatevaluador.js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SICE :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
	<script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxCurp;?>"></script>
   <script language="javascript" src="<?php echo $jsxDatPer;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xCtrl();
      });
   </script>  
   
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td width="100%">
<?php
   $xSys->getMenu();
   ?>
</td></tr>

<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">  
      <?php
      //-- Muestra el t�tulo del m�dulo actual...      
      if( isset($_SESSION["menu"]) ){
         $xSys->getNameMod($_SESSION["menu"], "Nuevo registro");         
      }
      ?>      
      
      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 10pt;">&nbsp; Datos Personales &nbsp;</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td class="styTdNombreCampo" width="200">C.U.R.P.:</td>
               <td class="styTdCampo" width="500">                     
                  <input name="curp" id="txtCurp" size="25" maxlength="18" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span>
                  <div id="dlgInfo" class="dialog" title="Atencion :: Coincidencia encontrada!"></div> 
               </td>
            </tr>            
            <tr>
               <td class="styTdNombreCampo">Nombre:</td>
               <td class="styTdCampo">                     
                  <input name="nombre" id="txtNombre" size="30" maxlength="35" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Apellido Paterno:</td>
               <td class="styTdCampo">                     
                  <input name="a_paterno" id="txtAPaterno" size="30" maxlength="30" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span>
               </td>
            </tr>              
            <tr>
               <td class="styTdNombreCampo">Apellido Materno:</td>
               <td class="styTdCampo">
                  <input name="a_materno" id="txtAMaterno" size="30" maxlength="30" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Fecha de nacimiento:</td>
               <td class="styTdCampo">
                  <input name="fecha_nac" id="txtFechaNac" size="12" value="" class="textread" readonly="true" style="text-align: center;" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>               
            <tr>
               <td class="styTdNombreCampo">Sexo:</td>
               <td class="styTdCampo">
                  <select name="sexo" id="cbSexo" class="select">                     
                     <?php
                     $xCat->shwGenero();                     
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>            
            <tr>
               <td class="styTdNombreCampo">R.F.C.:</td>
               <td class="styTdCampo">                     
                  <input name="rfc" id="txtRfc" size="17" maxlength="13" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>               
            <tr>
               <td class="styTdNombreCampo">C.U.I.P.:</td>
               <td class="styTdCampo">                     
                  <input name="cuip" id="txtCuip" size="25" maxlength="20" value="" class="text" />                  
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Folio I.F.E.:</td>
               <td class="styTdCampo">                     
                  <input name="ife" id="txtIfe" size="22" maxlength="18" value="" class="text" /> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Cartilla Militar:</td>
               <td class="styTdCampo">                     
                  <input name="cartilla" id="txtCartilla" size="15" maxlength="10" value="" class="text" /> 
               </td>
            </tr> 
            <tr>
               <td class="styTdNombreCampo">Entidad Federativa (Nac.):</td>
               <td class="styTdCampo">
                  <select name="entidad" id="cbEntidad" class="select"> 
                     <option value="0">-- Seleccione --</option>                    
                     <?php
                     $xCat->shwEntidad();                     
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>   
            <tr>
               <td class="styTdNombreCampo">Municipio (Nac.):</td>
               <td class="styTdCampo">
                  <select name="mpio_nac" id="cbMpioNac" class="select" style="max-width: 350px;"> 
                     <option value="0">- Vacio -</option>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Localidad (Nac.):</td>
               <td class="styTdCampo">                     
                  <input name="localidad" id="txtLocalidad" size="55" maxlength="200" value="" class="text" /> 
               </td>
            </tr>
         </table>         
      </fieldset>
      <br />
      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 10pt;">&nbsp; Adscripcion &nbsp;</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">            
            <tr>
               <td class="styTdNombreCampo" width="200">area evaluadora:</td>
               <td class="styTdCampo" width="500">
                  <select name="area" id="cbArea" class="select">
                     <option value="0">-- Seleccione --</option>
                     <?php                     
                     $xCat->shwAreaEval();                     
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>           
            <tr>
               <td class="styTdNombreCampo">Tipo de Funciones:</td>
               <td class="styTdCampo">
                  <select name="funcion" id="cbFuncion" class="select">                     
                     <?php       
                     $xCat->shwTipoFuncion(2);
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>   
            <tr>
               <td class="styTdNombreCampo">Categoria:</td>
               <td class="styTdCampo">
                  <select name="categoria" id="cbCategoria" class="select">   
                     <option value="0">-- Seleccione --</option>                  
                     <?php  
                     $xCat->shwCategoria();
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>  
                  <!-- Link Dialog: Agregar Categoria -->
            		<a href="#" id="addCategoria" title="Agregar nueva categoria...">
                     <img src="<?php echo $xPath;?>imgs/add_cat_22.png" alt="Agregar" style="border: none; vertical-align: middle;" />
                  </a>
            		<!-- ui-dialog -->
            		<div id="dlgCategoria" class="dialog" title="Nueva Categoria">
                     <br />
            			<label for="txtCategoria" style="font-size: 12px;">Categoria: </label>
                     <input type="text" name="xcategoria" id="txtCategoria" size="43" maxlength="45" class="text" style="font-size: 14px;" />
            		</div>                
               </td>
            </tr>            
            <tr>
               <td class="styTdNombreCampo">Cargo o Puesto:</td>
               <td class="styTdCampo">                     
                  <input name="cargo" id="txtCargo" size="50" maxlength="250" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">area de adscripcion:</td>
               <td class="styTdCampo">                     
                  <input name="area_ads" id="txtArea" size="60" maxlength="200" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Fecha de ingreso:</td>
               <td class="styTdCampo">
                  <input name="fecha_ing" id="txtFechaIng" size="12" value="" class="textread" readonly="true" style="text-align: center;" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>    
            <tr>
               <td class="styTdNombreCampo">Region de adscripcion:</td>
               <td class="styTdCampo">
                  <select name="region" id="cbRegion" class="select"> 
                     <option value="0">-- Seleccione --</option>                    
                     <?php                     
                     $xCat->shwRegion();                     
                     ?>
                  </select>
               </td>
            </tr>   
            <tr>
               <td class="styTdNombreCampo">Municipio:</td>
               <td class="styTdCampo">
                  <select name="mpio_ads" id="cbMpioAds" class="select" style="max-width: 350px;"> 
                     <option value="0">-- Vacio --</option>
                  </select>
               </td>
            </tr>
         </table>
      </fieldset>
      <br />
      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 10pt;">&nbsp; Domicilio &nbsp;</legend>
         <table class="stytbContenido" border="0" cellpadding="0" cellspacing="0">            
            <tr>
               <td class="styTdNombreCampo" width="200">Nombre de la calle:</td>
               <td class="styTdCampo" width="500">                     
                  <input name="calle" id="txtCalle" size="55" maxlength="60" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">No. exterior:</td>
               <td class="styTdCampo">
                  <input name="num_ext" id="txtNumExt" size="5" maxlength="4" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>    
            <tr>
               <td class="styTdNombreCampo">No. interior:</td>
               <td class="styTdCampo">                     
                  <input name="num_int" id="txtNumInt" size="5" maxlength="4" value="" class="text" />
                  <span style="color: black; font-weight: bold;">*</span>               
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Colonia:</td>
               <td class="styTdCampo">                     
                  <input name="colonia" id="txtColonia" size="60" maxlength="50" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr> 
            <tr>
               <td class="styTdNombreCampo">Ciudad/Localidad:</td>
               <td class="styTdCampo">                     
                  <input name="ciudad" id="txtCiudad" size="60" maxlength="50" value="" class="text" />
                  <span style="color: red; font-weight: bold;">*</span> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Municipio:</td>
               <td class="styTdCampo">
                  <select name="mpio_domi" id="cbMpioDomi" class="select" style="max-width: 350px;"> 
                     <option value="0">-- Seleccione --</option>
                     <?php                     
                     $xCat->shwMunicipio(0, 12);                     
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>            
            <tr>
               <td class="styTdNombreCampo">Telefono fijo:</td>
               <td class="styTdCampo">                     
                  <input name="tel_fijo" id="txtTelFijo" size="15" maxlength="15" value="" class="text" />
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Telefono movil:</td>
               <td class="styTdCampo">                     
                  <input name="tel_movil" id="txtTelMovil" size="15" maxlength="15" value="" class="text" /> 
               </td>
            </tr>
         </table>
      </fieldset>
      <br />
      <fieldset id="fsContenido" style="width: 700px;">
         <legend style="font: normal; font-size: 10pt;">&nbsp; Nivel de Estudios &nbsp;</legend>
         <table class="stytbContenido" border="0" cellpadding="0" cellspacing="0">            
            <tr>
               <td class="styTdNombreCampo" width="200">Nivel de Estudios:</td>
               <td class="styTdCampo" width="500">
                  <select name="nivel_estudios" id="cbNivelEstudios" class="select" style="max-width: 350px;"> 
                     <option value="0">-- Seleccione --</option>
                     <?php                     
                     $xCat->shwNivEstudios();
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr> 
            <tr>
               <td class="styTdNombreCampo">Eficiencia Terminal:</td>
               <td class="styTdCampo">
                  <select name="eficiencia" id="cbEficiencia" class="select" style="max-width: 350px;"> 
                     <option value="0">-- Seleccione --</option>
                     <?php                   
                     $xCat->shwStatEstudios();
                     ?>
                  </select>
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Carrera:</td>
               <td class="styTdCampo">                     
                  <input name="carrera" id="txtCarrera" size="60" maxlength="100" value="" class="text" /> 
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Nomenclatura:</td>
               <td class="styTdCampo">                     
                  <input name="nomenclatura" id="txtNomenclatura" size="10" maxlength="10" value="" class="text" /> 
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Cedula Profesional:</td>
               <td class="styTdCampo">                     
                  <input name="cedula" id="txtCedula" size="10" maxlength="10" value="" class="text" /> 
                  <span style="color: red; font-weight: bold;">*</span>                  
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo">Especialidad:</td>
               <td class="styTdCampo">                     
                  <input name="ne_especialidad" id="txtEspecialidad" size="60" maxlength="100" value="" class="text" />
               </td>
            </tr> 
         </table>
      </fieldset>
      <br />
      <fieldset id="fsBotones" style="width: 700px;">
         <table class="stytbBotones" cellpadding="0" cellspacing="0">
            <tr>
               <td width="30%" align="right">
                  <input type="submit" name="btnAceptar" value="Guardar y continuar" class="stybtnNormal"/>
               </td>
               <td width="40%">&nbsp;</td>
               <td width="30%" align="left">
                  <input type="button" name="btnCancelar" value="Cancelar" onclick="cancelar();" class="stybtnNormal" />
               </td>
            </tr>
         </table>
      </fieldset>
   </div>
   <input type="hidden" name="tp_oper" id="xtp_oper" value="1" />
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