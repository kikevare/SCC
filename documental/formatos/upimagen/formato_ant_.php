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
   include_once($xPath."includes/entsocial.class.php");
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
   $jsxBsqAnteced = $xPath."includes/js/evesocial/anteced/xbsq_anteced.js";
   /// Js y Css para modulo de subir imagenes
   $cssUpIma1      = $xPath."includes/upimagen/css/bootstrap.min.css";
   $cssUpIma2      = $xPath."includes/upimagen/css/bootstrap-responsive.min.css";
   $cssUpIma3      = $xPath."includes/upimagen/css/bootstrap-image-gallery.min.css";
   $cssUpIma4      = $xPath."includes/upimagen/css/jquery.fileupload-ui.css";
   
   $jsUpIma1      = $xPath."includes/upimagen/js/jquery.min.js";
   $jsUpIma2      = $xPath."includes/upimagen/js/vendor/jquery.ui.widget.js";
   $jsUpIma3      = $xPath."includes/upimagen/js/tmpl.min.js";
   $jsUpIma4      = $xPath."includes/upimagen/js/load-image.min.js";
   $jsUpIma5      = $xPath."includes/upimagen/js/canvas-to-blob.min.js";
   $jsUpIma6      = $xPath."includes/upimagen/js/bootstrap.min.js";
   $jsUpIma7      = $xPath."includes/upimagen/js/bootstrap-image-gallery.min.js";
   $jsUpIma8      = $xPath."includes/upimagen/js/jquery.iframe-transport.js";
   $jsUpIma9      = $xPath."includes/upimagen/js/jquery.fileupload.js";
   $jsUpIma10     = $xPath."includes/upimagen/js/jquery.fileupload-fp.js";
   $jsUpIma11     = $xPath."includes/upimagen/js/jquery.fileupload-ui.js";
   $jsUpIma12     = $xPath."includes/upimagen/js/locale.js";
   $jsUpIma13     = $xPath."includes/upimagen/js/main.js";
  

   
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma1;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma2;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma3;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma4;?>" rel="stylesheet" type="text/css" />
  
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script> 
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script> 
   <script language="javascript" src="<?php echo $jsxBsqAnteced;?>"></script>
   <script language="javascript" src="<?php echo $jsxBsqAnteced;?>"></script>
   <script language="javascript" src="<?php echo $jsUpIma1;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma2;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma3;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma4;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma5;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma6;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma7;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma8;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma9;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma10;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma11;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma12;?>"></script> 
   <script language="javascript" src="<?php echo $jsUpIma13;?>"></script> 



   
   <script type="text/javascript">
      $(document).ready(function(){
         xCtrl();                 
      });
   </script>
   <style type="text/css">
      .styxBtnOpcion{width: 70px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}      
      #tbPruebas{width: 400px; border-top: 1px solid #cccccb; border-bottom: 1px solid #cccccb; margin-top: 15px;}
      #tbPruebas td{font-family: arial, helvetica, sans-serif; font-size: 10pt; font-weight: bold; color: gray; border-bottom: 1px solid #cccccb; min-height: 25px;}
      .dvDatos{width: 520px; border: 2px double gray; padding: 3px; background-color: #fafafa;}
      .pTitulo{width: 510px; height: 17px; text-align: left; font-family: arial, helveltica, sans-serif; font-size: 10pt; padding: 3px; font-weight: bold; background-color: #488ac7; color: white;}
   </style>   
</head>

<body>
<!-- TABLA PRINCIPAL--->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="100%">
   		<?php
   		$xSys->getHeader();
   		?>
		</td>
    </tr>
    <tr>
    	<td align="center">
    	  <br>
    	  <div id="xdvContenedor" class="styContenedor">  
      	  <?php
		  //------------------- Muestra el título del módulo actual ------------------//
		  $xSys->getNameMod($_SESSION["menu"], "Búsqueda de Antecedentes");
		  //--------------------------------------------------------------------------//    
		  
		  //------------------------ Recepcion de parámetros -------------------------//
		  $xPersona = New Persona($_SESSION["xCurp"]);     
		  //--------------------------------------------------------------------------// 
		  
		  //$xEsocial = New EntSocial( $_SESSION["xCurp"] );
		  //$xEsocial->getDatosEntSocial();
		  ?>    
     	   <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0" style="width: 600px;">
           	<tr>
            	<td style="width: 70%;">
               		<p style="padding-left: 5px; text-align: left;">
                  	CURP: <span style="font-weight: bold;"><?php echo $xPersona->CURP;?> </span> 
               		</p>
               		<br />
               		<p style="padding-left: 5px; text-align: left;">
                  	NOMBRE: <span style="font-weight: bold;"><?php echo $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE;?> </span> 
               		</p>
            	</td>
            	<td style="width: 30%; text-align: right;" id="tdBtns">                             
               <a href="#" class="styxBtnOpcion" id="xRegresar_Rep" title="Regresar...">
                  <img src="<?php echo $xPath;?>imgs/back_32.png" alt="Regresar" style="border: none;" />
                  <br/>Regresar
               		</a>                        
           		 </td>
        	</tr>
         	<tr>
            	<td colspan="2" style="height: 25px; background-color: #488ac7; color: white; font-weight: bold;">IMAGENES PARA EL REPORTE DE ANTECEDENTES</td>
            </tr>  
            <tr>
            	<td  colspan="2">
			    <form id="fileupload" action="index.php" method="POST" enctype="multipart/form-data">
        		<div class="row fileupload-buttonbar">
           			 <div class="span7" style="width:550px; margin-left:50px ">
                		<!-- The fileinput-button span is used to style the file input field as button -->
                		<span class="btn btn-success fileinput-button">
                    	<i class="icon-plus icon-white"></i>
                    	<span>Seleccionar Imagenes...</span>
                    		<input type="file" name="files[]" multiple>
                		</span>
               			 <!--
                        <button type="submit" class="btn btn-primary start">
                            <i class="icon-upload icon-white"></i>
                            <span>Empezar Subida</span>
                        </button>
                        <button type="reset" class="btn btn-danger delete">
                            <i class="icon-trash icon-white"></i>
                            <span>Borrar</span>
                        </button>
                        
                        <input type="checkbox" class="toggle">
                        -->
           			  </div>
            
                    <!-- The global progress information 
                    <div class="span5 fileupload-progress fade">-->
                        <!-- The global progress bar 
                        <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="bar" style="width:0%;"></div>
                        </div>-->
                        <!-- The extended global progress information 
                        <div class="progress-extended">&nbsp;</div>
                    </div>-->
        		</div>
       			 <!-- The loading indicator is shown during file processing -->
       			<div class="fileupload-loading"></div>
       			 <br>
       			 <!-- The table listing the files available for upload/download -->
        		<table role="presentation" class="table table-striped">
                	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery">
                	</tbody>
                </table>
    		   </form>
    		   </td>
            </tr>
  		  </table> 
          <br />
         </div> <!-- fin DIV xvdContenedor-->
       </td>
   <tr>
    	<td>
  		 <?php
   			$xSys->getFooter();
  		 ?>
  		</td>
  </tr>
    
  </table>
 
<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Descargar</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Anterior</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Siguiente</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>

            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        <td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
           <!-- <input type="checkbox" name="delete" value="1">-->
        </td>
    </tr>
{% } %}
</script>

<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->
</body>

</html>
<?php
}
else
   header("Location: ".$xPath."exit.php"); 
?>