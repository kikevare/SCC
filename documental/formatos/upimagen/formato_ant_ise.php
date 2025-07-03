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
   $jsxBsqAnteced = $xPath."includes/js/evesocial/anteced/xbsq_anteced.js?v=".rand();

   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
  
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
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Nuevo Aspirante</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!--<link href="<?php //echo $cssDialog;?>" rel="stylesheet" type="text/css" />-->
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <link href="<?php echo $cssUpIma1;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma2;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma3;?>" rel="stylesheet" type="text/css" />
   <link href="<?php echo $cssUpIma4;?>" rel="stylesheet" type="text/css" />
<!--
   <script language="javascript" src="<?php //echo $jsxMain;?>"></script>
   <script language="javascript" src="<?php ///echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php //echo $jsjQueryDlg2;?>"></script>

-->
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
        /*
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
      */
		 // sUBIR IMAGEN FRENTE
		  var btn_firma2 = $('#addImage2'), interval;
        /*
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
      */
		// sUBIR IMAGEN DERECHA
		  var btn_firma3 = $('#addImage3'), interval;
        /*
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
      */
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>
   		<?php
   		$xSys->getMenu();
   		?>
		</td>
    </tr>
    <tr>
    	<td align="center">
    	  <br>
    	  <div id="xdvContenedor" class="styContenedor">
      	  <?php
		  //------------------- Muestra el t�tulo del m�dulo actual ------------------//
		  $xSys->getNameMod($_SESSION["menu"], "B&uacute;squeda de Antecedentes=" . $_SESSION["ORIGEN"] );
		  //--------------------------------------------------------------------------//

		  //------------------------ Recepcion de par�metros -------------------------//
		  $xPersona = New Persona($_SESSION["xCurp"]);
		  //--------------------------------------------------------------------------//

		  $xEsocial = New EntSocial( $_SESSION["xCurp"] );
		  $xEsocial->getDatosEntSocial();
          $AntecedLab  = $xEsocial->getAntecedLabSeguridad();
          $DSUIC       = $xEsocial->getDatosConcultaAnteced(1);
          $DIGI        = $xEsocial->getDatosConcultaAnteced(2);
          $DTELE       = $xEsocial->getDatosConcultaAnteced(3);
          $DPG         = $xEsocial->getDatosConcultaAnteced(4);
          $DDH         = $xEsocial->getDatosConcultaAnteced(5);
          $DCE         = $xEsocial->getDatosConcultaAnteced(6);
          $RPV         = $xEsocial->getDatosConcultaAnteced(7);
          $CINT         = $xEsocial->getDatosConcultaAnteced(8);
          $CINS         = $xEsocial->getDatosConcultaAnteced(9);
            $CINB         = $xEsocial->getDatosConcultaAnteced(10);
        $CINN         = $xEsocial->getDatosConcultaAnteced(11); 
        $CINNs         = $xEsocial->getDatosConcultaAnteced(12); 
        $CINNs1         = $xEsocial->getDatosConcultaAnteced(13); 
        $CINNs2         = $xEsocial->getDatosConcultaAnteced(14); 

		  ?>

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
                  	CURP: <span style="font-weight: bold;"><?php echo $xPersona->CURP;?> </span>
               		</p>
               		<br />
               		<p style="padding-left: 5px; text-align: left;">
                  	NOMBRE: <span style="font-weight: bold;"><?php echo $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE;?> </span>
               		</p>
                    <?php
                    if( $AntecedLab[0]["CONTENIDO"] != "" ){
                        $obseva="";
                        foreach($AntecedLab As $requisito){
                                     $obseva .= utf8_decode($requisito["CONTENIDO"]).". ";

                        }
                    ?>
                    <!--<p style="padding-left: 5px; text-align: left;">
                  	OBSERVACIONES: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
               		</p>-->
                    <?php
                    }
                    ?>
            	</td>
                <td style="width: 20%; text-align: center;" >
                &nbsp;
                <!--
               <a href="#" class="styxBtnOpcion" id="xReporte_Ant" title="Formato...">
               <img src="<?php echo $xPath;?>imgs/dat_gral.png" border="0" align="middle" />
                  <br/>Formato de<br/> Antecedentes
               		</a>
                     -->
           		 </td>

            	<!-- <td style="width: 20%; text-align: right;" id="tdBtns">
                    <a href="#" class="ui-button ui-corner-all ui-widget styxBtnOpcion" id="xRegresar_Rep" title="Regresar">
                    <img src="<?php echo $xPath;?>imgs/back_32.png" alt="Regresar" style="border: none;" />
                    <br/>Regresar
                    </a>
                </td> -->
        	</tr>
            <tr>
                <td colspan="3" style="width: 100%; text-align: center;" >
                    <span style="font-weight: bold;">&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width: 100%; text-align: center;" >
                    <span style="font-weight: bold;">PLATAFORMA MEXICO</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width: 100%; text-align: center;" >
                    <span style="font-weight: bold;">&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table border="0" cellpadding="0" cellspacing="0" >
                        <?php
                        if( $AntecedLab[0]["CONTENIDO"] != "" ){
                        ?>
                            <tr>

                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 OBSERVACIONES: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $obseva;?> </span>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 SUIC: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DSUIC[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 SISTEMA DIGISCAN: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DIGI[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 SISTEMA TELESCAN: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DTELE[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php if ($DPG[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 PGJE: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DPG[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($DDH[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 DERECHOS HUMANOS: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DDH[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($DCE[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 CONTRALORIA DEL ESTADO: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DCE[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($RPV[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 REGISTRO PUBLICO DE LA PROPIEDAD: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $RPV[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($CINT[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                      	                 CONSULTA EN INTERNET: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $CINT[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($CINB[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                                    SUBSECRETARIA DEL SISTEMA PENITENCIARIO: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $CINB[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($CINS[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                                    BASES ESTATALES: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $CINS[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($CINS[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                                    REDES SOCIALES: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $CINNs[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($CINN[0]["DES_ANTECEDENTES"]!=""){?>
                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                                    RNPSP: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $CINN[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                        <?php }?>

                            <tr>
                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                                    CONCLUSION: <span style="font-weight: bold;"><?php //echo $DSUIC[0]["DES_ANTECEDENTES"]?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $CINNs2[0]["DES_ANTECEDENTES"];?> </span>
                                </td>
                            </tr>
                     
                    </table>
                </td>
                <?php
            if($DSUIC[0]["ACTUAL"]!="" || $DIGI[0]["ACTUAL"]!="" || $DTELE[0]["ACTUAL"]!="" ||$DPG[0]["ACTUAL"]!=""|| $DDH[0]["ACTUAL"]!="" || $DCE[0]["ACTUAL"]!=""|| $RPV[0]["ACTUAL"]!=""|| $CINS[0]["ACTUAL"]!=""|| $CINB[0]["ACTUAL"]!=""|| $CINN[0]["ACTUAL"]!=""|| $CINT[0]["ACTUAL"]!=""||$CINE[0]["ACTUAL"]!="" ){
            ?>
                <!-- -------------------------------------------------- -->
                <tr>
                <td colspan="3" style="width: 100%; text-align: center;" >
                <br><br>
                    <span style="font-weight: bold;">INFORMACION RELEVANTE DE EVALUACIONES PREVIAS:</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width: 100%; text-align: center;" >
                    <span style="font-weight: bold;">&nbsp;</span>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table border="0" cellpadding="0" cellspacing="0" >
                        <?php
                        if($DSUIC[0]["ACTUAL"]!="" ){
                        ?>
                            <tr>

                                <td style="width: 20%; text-align: center;" >
                                    <p style="padding-left: 5px; text-align: left;">
                                    SUIC: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
               		                </p>
                                </td>
                                <td style="width: 80%; text-align: justify;" >
                                    <span style="font-weight: bold;"><?php echo $DSUIC[0]["ACTUAL"];?> </span>
                                </td>
                            </tr>
                        <?php
                        }
                        if($DIGI[0]["ACTUAL"]!=""){
                            ?>
                                <tr>
    
                                    <td style="width: 20%; text-align: center;" >
                                        <p style="padding-left: 5px; text-align: left;">
                                        SISTEMA DIGISCAN: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                           </p>
                                    </td>
                                    <td style="width: 80%; text-align: justify;" >
                                        <span style="font-weight: bold;"><?php echo $DIGI[0]["ACTUAL"];?> </span>
                                    </td>
                                </tr>
                            <?php
                            }
                            if($DTELE[0]["ACTUAL"]!=""){
                                ?>
                                    <tr>
        
                                        <td style="width: 20%; text-align: center;" >
                                            <p style="padding-left: 5px; text-align: left;">
                                            SISTEMA TELESCAN: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                               </p>
                                        </td>
                                        <td style="width: 80%; text-align: justify;" >
                                            <span style="font-weight: bold;"><?php echo $DTELE[0]["ACTUAL"];?> </span>
                                        </td>
                                    </tr>
                                <?php
                                }
                                if($DPG[0]["ACTUAL"]!=""){
                                    ?>
                                        <tr>
            
                                            <td style="width: 20%; text-align: center;" >
                                                <p style="padding-left: 5px; text-align: left;">
                                                FGE: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                   </p>
                                            </td>
                                            <td style="width: 80%; text-align: justify;" >
                                                <span style="font-weight: bold;"><?php echo $DPG[0]["ACTUAL"];?> </span>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    if($DDH[0]["ACTUAL"]!=""){
                                        ?>
                                            <tr>
                
                                                <td style="width: 00%; text-align: center;" >
                                                    <p style="padding-left: 5px; text-align: left;">
                                                    CODDEHUM GRO: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                       </p>
                                                </td>
                                                <td style="width: 100%; text-align: justify;" >
                                                    <span style="font-weight: bold;"><?php echo $DDH[0]["ACTUAL"];?> </span>
                                                <br>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        if($DCE[0]["ACTUAL"]!=""){
                                            ?>
                                                <tr>
                    
                                                    <td style="width: 20%; text-align: center;" >
                                                        <p style="padding-left: 5px; text-align: left;">
                                                        CONTRALORIA GENERAL DEL ESTADO: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                           </p>
                                                    </td>
                                                    <td style="width: 80%; text-align: justify;" >
                                                        <span style="font-weight: bold;"><?php echo $DCE[0]["ACTUAL"];?> </span>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            if($RPV[0]["ACTUAL"]!=""){
                                                ?>
                                                    <tr>
                        
                                                        <td style="width: 20%; text-align: center;" >
                                                            <p style="padding-left: 5px; text-align: left;">
                                                            REGISTRO PUBLICO DE LA PROPIEDAD Y DEL COMERCIO: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                               </p>
                                                        </td>
                                                        <td style="width: 80%; text-align: justify;" >
                                                            <span style="font-weight: bold;"><?php echo $RPV[0]["ACTUAL"];?> </span>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                if($CINB[0]["ACTUAL"]!=""){
                                                    ?>
                                                        <tr>
                            
                                                            <td style="width: 20%; text-align: center;" >
                                                                <p style="padding-left: 5px; text-align: left;">
                                                                SUBSECRETARIA DEL SISTEMA PENITENCIARIO: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                                   </p>
                                                            </td>
                                                            <td style="width: 80%; text-align: justify;" >
                                                                <span style="font-weight: bold;"><?php echo $CINB[0]["ACTUAL"];?> </span>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    if($CINN[0]["ACTUAL"]!=""){
                                                        ?>
                                                            <tr>
                                
                                                                <td style="width: 20%; text-align: center;" >
                                                                    <p style="padding-left: 5px; text-align: left;">
                                                                    RNPSP: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                                       </p>
                                                                </td>
                                                                <td style="width: 80%; text-align: justify;" >
                                                                    <span style="font-weight: bold;"><?php echo $CINN[0]["ACTUAL"];?> </span>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        if($CINT[0]["ACTUAL"]!=""){
                                                            ?>
                                                                <tr>
                                    
                                                                    <td style="width: 20%; text-align: center;" >
                                                                        <p style="padding-left: 5px; text-align: left;">
                                                                        CONSULTA EN INTERNET: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                                           </p>
                                                                    </td>
                                                                    <td style="width: 80%; text-align: justify;" >
                                                                        <span style="font-weight: bold;"><?php echo $CINT[0]["ACTUAL"];?> </span>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            if($CINE[0]["ACTUAL"]!=""){
                                                                ?>
                                                                    <tr>
                                        
                                                                        <td style="width: 20%; text-align: center;" >
                                                                            <p style="padding-left: 5px; text-align: left;">
                                                                            REDES SOCIALES: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                                                                               </p>
                                                                        </td>
                                                                        <td style="width: 80%; text-align: justify;" >
                                                                            <span style="font-weight: bold;"><?php echo $CINE[0]["ACTUAL"];?> </span>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                                </table>
                </td>
            </tr>
               <?php
  }
               ?> 
            <!--
                <td style="width: 50%;">
                    <p style="padding-left: 5px; text-align: left;">
                  	OBSERVACIONES: <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
               		</p>
                </td>
                <td style="width: 20%; text-align: center;" >
                    <span style="font-weight: bold;"><?php //echo $obseva;?> </span>
                </td>
                <td>
                </td>
            -->
            </tr>
         	<tr>
            	<td colspan="3" style="height: 25px; background-color: #488ac7; color: white; font-weight: bold;">IMAGENES PARA EL REPORTE DE ANTECEDENTES</td>
            </tr>
            <tr>
            <td  colspan="2">
			    <form id="fileupload" action="index.php" method="POST" enctype="multipart/form-data">
        		<div class="row fileupload-buttonbar">
           			 <div class="span7" style="width:550px; margin-left:50px ">
                		<!-- The fileinput-button span is used to style the file input field as button -->
                	<!-- 	<span class="btn btn-success fileinput-button">
                    	<i class="icon-plus icon-white"></i> -->
                    	<!-- <span>Seleccionar Imagenes...</span>
                    		<input type="file" name="files[]" multiple>
                		</span> -->
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
            <tr>
            	<td align="center" colspan="3" style="height: 25px; background-color: #488ac7; color: white; font-weight: bold;">FOTOS DEL ELEMENTO</td>
            </tr>  
            <tr>
            <td>
            <div id="wraper">
                	<header class="headerLayout">
                    	PERFIL IZQUIERDO
                	</header>
                	<section class="contentLayout" id="contentLayout">
                        <?php
						$ruta_izq=$ruta."_IZQ_".$xEsocial->ID_EVAL.".jpg";
						if(is_file($ruta_izq))
						$image_name= $ruta_izq;
						else
						$image_name= "images/nofoto.jpg";
						?>
                		<div id="contenedorImagen">
                           <img id="fotografia" class="fotografia"  src="<?php echo $image_name; ?>?rid=<?php echo rand(5, 1000); ?>" />
                   		<!--<img id="fotografia" class="fotografia" src=>            -->
                    	</div>
                     <!--
                    	<button class="boton" id="addImage">Seleccionar</button>
                       -->
                    	<div class="loaderAjax" id="loaderAjax">
                    		<img src="images/default-loader.gif">
                     		<span>Publicando Fotograf�a...</span>
                    	</div>
                 	</section>
                 </div>
            </td>
            <td>
            <div id="wraper">
                	<header class="headerLayout">
                    	FRENTE
                	</header>
                	<section class="contentLayout" id="contentLayout">
                        <?php
						$ruta_frt=$ruta."_FRT_".$xEsocial->ID_EVAL.".jpg";
						if(is_file($ruta_frt))
						$image_name= $ruta_frt;
						else
						$image_name= "images/nofoto.jpg";
						?>
                		<div id="contenedorImagen">
                           <img id="fotografia2" class="fotografia"  src="<?php echo $image_name; ?>?rid=<?php echo rand(5, 1000); ?>" />
                   		<!--<img id="fotografia" class="fotografia" src=>-->
                    	</div>
                       <!--
                    	<button class="boton" id="addImage2">Seleccionar</button>
                       -->
                    	<div class="loaderAjax" id="loaderAjax2">
                    		<img src="images/default-loader.gif">
                     		<span>Publicando Fotograf�a...</span>
                    	</div>
                 	</section>
                 </div>
            </td>
            <td>
            <div id="wraper">
                	<header class="headerLayout">
                    	PERFIL DERECHO
                	</header>
                	<section class="contentLayout" id="contentLayout">
                        <?php
						$ruta_der=$ruta."_DER_".$xEsocial->ID_EVAL.".jpg";
						if(is_file($ruta_der))
						$image_name= $ruta_der;
						else
						$image_name= "images/nofoto.jpg";
						?>
                		<div id="contenedorImagen">
                           <img id="fotografia3" class="fotografia"  src="<?php echo $image_name; ?>?rid=<?php echo rand(5, 1000); ?>" />
                   		<!--<img id="fotografia" class="fotografia" src=>-->
                    	</div>
                       <!--
                    	<button class="boton" id="addImage3">Seleccionar</button>
                       -->
                    	<div class="loaderAjax" id="loaderAjax3">
                    		<img src="images/default-loader.gif">
                     		<span>Publicando Fotograf�a...</span>
                    	</div>
                 	</section>
                 </div>
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
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" preview="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
            <td colspan="2"></td>
        {% } %}
        
    </tr>
{% } %}
</script>

</body>

</html>
<?php
}
else
   header("Location: ".$xPath."exit.php");
?>
