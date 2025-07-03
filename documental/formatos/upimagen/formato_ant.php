<?php
session_start();

//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");

for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";

$ruta= $xPath."Archivo/Fotografias/".$_SESSION["xCurp"]."/".$_SESSION["xCurp"];
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/catalogos.class.php");
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
   $jsAjaxUpload  = $xPath."includes/js/ajaxupload.js";
  
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC ::</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma1;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma2;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma3;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma4;?>" rel="stylesheet" type="text/css" />
   
   <!--  -->
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script> 
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script> 
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
   <script language="javascript" src="<?php echo $jsAjaxUpload;?>"></script> 



   
   <script type="text/javascript">
      $(document).ready(function(){
         xCtrl();    
	
	});
	
  $(function() {
		var id_eval=document.getElementById('ideval').value;
		  // sUBIR IMAGEN PERFIL IZQUIERDO
		  var btn_firma = $('#addImage'), interval;
			new AjaxUpload('#addImage', {
				action: 'uploadFile.php?p=_IZQ_&id_eval='+id_eval,
				onSubmit : function(file , ext){
					if (! (ext && /^(jpg|png|JPG|PNG)$/.test(ext))){
						// extensiones permitidas
						alert('S�lo se permiten Imagenes .jpg o .png');
						// cancela upload
						return false;
					} else {
						$('#loaderAjax').show();
						btn_firma.text('Espere por favor');
						this.disable();
					}
				},
				onComplete: function(file, response){
					btn_firma.text('Cambiar Imagen');
					
					respuesta = $.parseJSON(response);

					if(respuesta.respuesta == 'done'){
						$('#fotografia').removeAttr('scr');
						$('#fotografia').attr('src',respuesta.fileName+ '?rid=' + Math.random());
						$('#loaderAjax').show();
						// alert(respuesta.mensaje);
					}
					else{
						alert(respuesta.mensaje);
					}
						
					$('#loaderAjax').hide();	
					this.enable();	
				}
		});
		 // sUBIR IMAGEN FRENTE
		  var btn_firma2 = $('#addImage2'), interval;
			new AjaxUpload('#addImage2', {
				action: 'uploadFile.php?p=_FRT_&id_eval='+id_eval,
				onSubmit : function(file , ext){
					if (! (ext && /^(jpg|png|JPG|PNG)$/.test(ext))){
						// extensiones permitidas
						alert('S�lo se permiten Imagenes .jpg o .png');
						// cancela upload
						return false;
					} else {
						$('#loaderAjax2').show();
						btn_firma2.text('Espere por favor');
						this.disable();
					}
				},
				onComplete: function(file, response){
					btn_firma2.text('Cambiar Imagen');
					
					respuesta2 = $.parseJSON(response);

					if(respuesta2.respuesta == 'done'){
						$('#fotografia2').removeAttr('scr');
						$('#fotografia2').attr('src',respuesta2.fileName+ '?rid=' + Math.random());
						$('#loaderAjax2').show();
						// alert(respuesta.mensaje);
					}
					else{
						alert(respuesta.mensaje);
					}
						
					$('#loaderAjax2').hide();	
					this.enable();	
				}
		});
		// sUBIR IMAGEN DERECHA
		  var btn_firma3 = $('#addImage3'), interval;
			new AjaxUpload('#addImage3', {
				action: 'uploadFile.php?p=_DER_&id_eval='+id_eval,
				onSubmit : function(file , ext){
					if (! (ext && /^(jpg|png|JPG|PNG)$/.test(ext))){
						// extensiones permitidas
						alert('S�lo se permiten Imagenes .jpg o .png');
						// cancela upload
						return false;
					} else {
						$('#loaderAjax3').show();
						btn_firma3.text('Espere por favor');
						this.disable();
					}
				},
				onComplete: function(file, response){
					btn_firma3.text('Cambiar Imagen');
					
					respuesta3 = $.parseJSON(response);

					if(respuesta3.respuesta == 'done'){
						$('#fotografia3').removeAttr('scr');
						$('#fotografia3').attr('src',respuesta3.fileName+ '?rid=' + Math.random());
						$('#loaderAjax3').show();
						// alert(respuesta.mensaje);
					}
					else{
						alert(respuesta.mensaje);
					}
						
					$('#loaderAjax3').hide();	
					this.enable();	
				}
		});
    });
	  
	  
   </script>
   <style type="text/css">
      .styxBtnOpcion{width: 70px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}      
      #tbPruebas{width: 400px; border-top: 1px solid #cccccb; border-bottom: 1px solid #cccccb; margin-top: 15px;}
      #tbPruebas td{font-family: arial, helvetica, sans-serif; font-size: 10pt; font-weight: bold; color: gray; border-bottom: 1px solid #cccccb; min-height: 25px;}
      .dvDatos{width: 520px; border: 2px double gray; padding: 3px; background-color: #fafafa;}
      .pTitulo{width: 510px; height: 17px; text-align: left; font-family: arial, helveltica, sans-serif; font-size: 10pt; padding: 3px; font-weight: bold; background-color: #488ac7; color: white;}
	  header h1{    text-align: center;} 
	  #wraper{    margin:0 auto;    overflow:hidden;    width:250px;    height:auto;} 
	  .loaderAjax{    display: none;} 
	  #contenedorImagen .fotografia{    margin: 20px auto;    width:120px;    height:120px;    border: 1px solid #ccc;    -moz-border-radius: 8px 8px 8px 8px;    -webkit-border-radius: 8px 8px 8px 8px;    border-radius: 8px 8px 8px 8px;} 
	  #wraper .contentLayout{    text-align: center;}
	  .headerLayout{ font-weight:bold; font-size:14px; color:gray;  }
	  
   </style>   
</head>

<body>
<!-- TABLA PRINCIPAL--->
<!-- TABLA PRINCIPAL--->
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr><td width="100%">
  <?php
  
   ?>
</td></tr>
    <tr>
    	<td align="center">
    	  <br>
    	  <div id="xdvContenedor" class="styContenedor">  
      	  <?php
		  //------------------- Muestra el t�tulo del m�dulo actual ------------------//
		  $xSys->getNameMod($_SESSION["menu"], "Documentos");
		  //--------------------------------------------------------------------------//    
		  
		  //------------------------ Recepcion de par�metros -------------------------//
		  $xPersona = New Persona($_SESSION["xCurp"]);     
		  //--------------------------------------------------------------------------// 
		  
		  $xEsocial = New EntSocial( $_SESSION["xCurp"] );
		  $xEsocial->getDatosEntSocial();
		  ?>    
          <?php  
           $dbname = "bdceecc";
   $dbuser = "root";
   $dbhost = "localhost";
   $dbpass = 'root';
   /* $dbname ="bdceecc";
   $dbuser="root";
   $dbhost="10.24.2.25";
   $dbpass='4dminMy$ql$';*/
   $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        $sql3 = "select nombre, a_paterno, a_materno, id_corporacion, categoria, id_tipo_eval, id_municipio, id_region from tbprog_preliminar where xcurp='" . $xPersona->CURP . "' order by id_prog_preliminar desc";
        $resulta = mysqli_query($conexion, $sql3);
        $fil = mysqli_fetch_assoc($resulta);
        $nombre = $fil['nombre']." ".$fil['a_paterno']." ".$fil['a_materno'];
        $sql7 = "select corporacion from ctcorporacion where id_corporacion='" . $fil['id_corporacion'] . "'";
        $resul3 = mysqli_query($conexion, $sql7);
        $fil4 = mysqli_fetch_assoc($resul3);
        $corporacion = $fil4['corporacion'];
        $sql28 = "select nombre, a_paterno, a_materno from tbdatospersonales where curp = '" . $xUsr->xCurpEval . "'";
        $resul25 = mysqli_query($conexion, $sql28);
        $fil26 = mysqli_fetch_assoc($resul25);
        $nombre_ev = $fil26['nombre']." ".$fil26['a_paterno']." ".$fil26['a_materno'];
        $sql = "select id_evaluacion from tbevaluaciones where curp='" . $xPersona->CURP . "'order by id_evaluacion desc";
        $resultado = mysqli_query($conexion, $sql);
        $filas = mysqli_fetch_assoc($resultado);
        $id = $filas['id_evaluacion'];
        $modulo = "DOCUMENTAL";
        $fecha = date('d-m-y');
        putenv("America/Mexico_City"); 
        date_default_timezone_set("America/Mexico_City");
        $hora=date('H:i:s');
        $fecha_completa=$fecha." ".$hora;
        $query = "INSERT INTO registro_entornosocial (id_evaluacion,nombre_modulo,curp_evaluador, fecha, hora,curp_evaluado,nombre_evaluado,corporacion,nombre_evaluador,fecha_completa) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $sentencia = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($sentencia, "ssssssssss", $id, $modulo,$xUsr->xCurpEval,$fecha,$hora,$xPersona->CURP,$nombre,$corporacion,$nombre_ev,$fecha_completa);
        mysqli_stmt_execute($sentencia);
        $filasafec = mysqli_stmt_affected_rows($sentencia); ?>
          <!--  se recibe la variable para controlar desde que modulo se accesa a esta pantalla
            investigacion de antecedentes o integracion de resultados -->
          <?php      
            $_SESSION["ORIGEN"] = $_GET["mod_origen"];      
          ?>            
          <input type="hidden" value='<?php echo $_SESSION["ORIGEN"]; ?>' id="idModOrigen" name="mod_origen" />      
          <!-- ------------------------------------------------------------------------------------------ -->
          
     	   <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0" style="width: 600px;">
           	<input type="hidden" id="ideval" value="<?php echo $xEsocial->ID_EVAL; ?> ">
            <tr>
            
            	<td style="width: 50%;">
               		<p style="padding-left: 5px; text-align: left;">
                  	CURP: <span style="font-weight: bold;"><?php echo $xPersona->CURP; ?> </span> 
               		</p>
               		<br />
               		<p style="padding-left: 5px; text-align: left;">
                  	NOMBRE: <span style="font-weight: bold;"><?php echo $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE;?> </span> 
               		</p>
            	</td>
                <td id="tdBtns" style="width: 30%; text-align: right;">
                <?php if($_GET["valor"] == null) 
					{
		  ?>        
               <a href="../../ctrl_invdoc.php" class="styxBtnOpcion"  title="Regresar...">
                  <img src="<?php echo $xPath;?>imgs/flecha-hacia-atras.png" alt="Regresar" style="border: none;" />
                  <br/>Regresar
               </a>
               <?php
					}else if($_GET["valor"] ==2)
					{?>
                        <a href="../../../socioeconomico/ctrl_socioe.php" class="styxBtnOpcion" title="Regresar...">
                        <img src="<?php echo $xPath;?>imgs/flecha-hacia-atras.png" alt="Regresar" style="border: none;" />
                        <br/>Regresar
                     </a> 
                    <?php
                    }
					
                    else if($_GET["valor"] ==5)
					{?>
                        <a href="../../../integracion/ctrl_integra.php" class="styxBtnOpcion" title="Regresar...">
                        <img src="<?php echo $xPath;?>imgs/flecha-hacia-atras.png" alt="Regresar" style="border: none;" />
                        <br/>Regresar
                     </a> 
                    <?php
                    }
					?>
            </td>
        	</tr>
         	<tr>
            	<td colspan="3" style="height: 25px; background-color: #488ac7; color: white; font-weight: bold;">DOCUMENTOS VALIDADOS O POR VALIDAR</td>
            </tr>  
            <tr>
            	<td  colspan="2">
			    <form id="fileupload" action="index.php" method="POST" enctype="multipart/form-data">
        		<div class="row fileupload-buttonbar">
           			 <div class="span7" style="width:550px; margin-left:50px ">
                		<!-- The fileinput-button span is used to style the file input field as button -->
                        <?php if($_GET["valor"] !=2) 
					{
		  ?>  
                        <span class="btn btn-info fileinput-button">
                    	<i class="icon-plus icon-white"></i>
                    	<span>Seleccionar PDF...</span>
                    		<input type="file" name="files[]" multiple>
                		</span>
                        <?php
                        }
                        ?>
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
                 <!-- Fotos-->
                
                 <!-- Fin Fotos-->
                 
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
<?php if($_GET["valor"]!=2){?>
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
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" preview="{%=file.name%}">{%=file.name%}</a>
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
<?php } else{?>
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
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" preview="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
    </tr>
{% } %}
</script>
<?php }?>
<!-- GoFTP Free Version End --></body>

</html>
<?php
}
else
   header("Location: ".$xPath."exit.php"); 
?>
