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
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxFileUpload = $xPath."includes/js/AjaxUpload.2.0.min.js";
   $jsxInvDoc     = $xPath."includes/js/evesocial/invdoc/xctrl_invdoc.js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Evaluaci&oacute;n M&eacute;dica</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxFileUpload;?>"></script>
   <script language="javascript" src="<?php echo $jsxInvDoc;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xCtrlIdEvalInvDoc();                 
      });
   </script>  
   <style type="text/css">
      .styLink{ color: #272; color: !important; }
      .stytbDatosPer{ width: 700px; border-top: 0px solid #cccccb; border-bottom: 1px solid #cccccb; margin: 5px 0 0 0; }
      .stytbDatosPer td{ font-size: 9pt; padding: 5px 3px 5px 3px; }  
      .styxBtnOpcion{width: 70px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}
      .styTitExamen{text-align: center; font-weight: bold; font-size: 13pt; border-top: 1px solid #cccccb; border-bottom: 1px solid #cccccb; padding: 10px 0 10px 0; }
      .styTdExamen{ padding: 7px 0 5px 0; text-align: center; }
      .styEstablece{text-shadow: !important; color: #854; cursor: pointer; font-family: sans-serif; font-size: 10pt; font-weight: bolder}
      #tbFormatos{width: 400px; border-top: 1px solid #cccccb; border-bottom: 1px solid #cccccb; margin-top: 15px;}
      #tbFormatos td{font-family: arial, helvetica, sans-serif; font-size: 8pt; font-weight: bold; color: gray; border-bottom: 1px solid #cccccb; min-height: 25px;}
   </style> 
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td width="100%">
   <?php
   $xSys->getHeader();
   ?>
</td></tr>

<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" enctype="application/x-www-form-urlencoded">
   <div id="xdvContenedor" class="styContenedor">  
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"], "Aplicaci�n");
      //--------------------------------------------------------------------------//    
      
      //------------------------ Recepcion de par�metros -------------------------//
      if( isset($_GET["curp"]) ){
         $xPersona = New Persona($_GET["curp"]);
         $xInvDoc = New invDocumental( $_GET["curp"] );
         $_SESSION["xCurp"] = $xPersona->CURP;
         //echo $_GET["curp"];
      }
      else{
         $xPersona = New Persona($_SESSION["xCurp"]);
         $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
         //echo " session" . $_SESSION["xCurp"];
      }
      //--------------------------------------------------------------------------// 
      
      $xInvDoc->ExistIdDatosGenerales();
      $xInvDoc->getDatosGenerales();
      
      ?>    
      
      <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0" style="width: 700px;">
         <tr>
            <td width="50%" align="right" id="tdBtns">               
               <a href="#" class="styxBtnOpcion" id="xRegresar" title="Regresar...">
                  <img src="<?php echo $xPath;?>imgs/back_32.png" border="0" />
                  <br/>Regresar <?php echo $xInvDoc->RESULTADO_COMP_EST; ?>
               </a>                        
            </td>
         </tr>
      </table>       
      <table border="0" class="stytbDatosPer" cellpadding="0" cellspacing="0">
         <tr> 
            <td rowspan="7" width="15%" align="center" style="border-right: 1px dotted #cccccb;">
               <div style="width: 90px; height: 110px; border: 1px dashed gray;" title="Sin fotograf�a...">
                  <img src="../../imgs/sin_foto.png" width="85" height="105" />
               </div>
            </td> 
         </tr>         
         <tr>
            <td width="10%" align="left" style="font-weight: bold; padding-left: 15px;">CURP: </td>
            <td width="30%" align="left"><?php echo $xPersona->CURP;?> </td>
            <td width="10%" align="left" style="font-weight: bold;">CORPORACI�N: </td>
            <td width="30%" align="left"><?php echo $xPersona->getCorporacion();?> </td>
         </tr>
         <tr>
            <td width="10%" align="left" style="font-weight: bold; padding-left: 15px;">NOMBRE: </td>
            <td width="35%" align="left"><?php echo $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE;?> </td>
            <td width="10%" align="left" style="font-weight: bold;">ESPECIALIDAD: </td>
            <td width="30%" align="left"><?php echo $xPersona->getEspecialidad()?> </td>
            
         </tr>
         <tr>
            <td width="10%" align="left" style="font-weight: bold; padding-left: 15px;">SEXO: </td>
            <td width="30%" align="left"><?php echo $xPersona->getSexo();?> </td>
            <td width="10%" align="left" style="font-weight: bold;">CATEGORIA: </td>
            <td width="30%" align="left"><?php echo $xPersona->getCategoria();?> </td>
         </tr>
         <tr>
            <td width="10%" align="left" style="font-weight: bold; padding-left: 15px;">EDAD: </td>
            <td width="30%" align="left"><?php echo $xPersona->EDAD;?> A�os </td>            
            <td width="10%" align="left" style="font-weight: bold;">F. INGRESO</td>
            <td width="30%" align="left"><?php echo $xSys->FormatoCorto( date("d-m-Y", strtotime($xPersona->FECHAING)) );?></td>
         </tr>         
      </table>  

      
      <br />      
      <table id="xMenu" cellpadding="0" cellspacing="0" style="width: 400px; border-bottom: 1px solid #cccccb;" border="0">
         <thead style="">            
            <th class="styTitExamen" colspan="2">.:: OPCIONES ::. <?php //echo $xInvDoc->CURP_EVAL; ?> </th>            
         </thead>
         <tbody>
	 
            <tr>
            
                <!-- datos generales -->
                <td class="styTdExamen">
                  <a href="#" id='xDatosDoc' style="width: 220px; height: 50px;" title="Datos Generales..." >
                     <img src="<?php echo $xPath;?>imgs/dat_gral.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Datos de la Generales</div>
                  </a>
                </td>
          
            </tr>  
                      
            <tr> 
                
                <!-- Cartilla -->
                <td class="styTdExamen">            
                  <a href="#" id="xCartilla" style="width: 220px; height: 50px;" title="Datos de la Cartilla..." >
                     <img src="<?php echo $xPath;?>imgs/dat_gral.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Cartilla</div>
                  </a>
                </td>
                
            </tr>
            
            <tr>    
                        
                <!-- comprobante de Estudios -->
                <td class="styTdExamen">            
                  <a href="#" id="xCompEst" style="width: 220px; height: 50px;" title="Datos del Comprobante de Estudios..." >
                     <img src="<?php echo $xPath;?>imgs/dat_gral.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Comprobante de Estudios</div>
                  </a>
                </td>
                
    	    </tr>
    	    
            <!-- RESULTADO CARTILLA -->
            <tr>
            
               <td class="styTdExamen" align="center" style="font-size: 10pt;" colspan="2">
                  RESULTADO CARTILLA :
                    <?php
			$x = $xInvDoc->getDatosCartilla();
                        if( $xUsr->xNomPerfil == "INVESTIGADOR" || $xUsr->xNomPerfil == "SUPERVISOR"){
                            $Result = $xInvDoc->getResultado( $xInvDoc->RESULTADO_CARTILLA ); 
                            echo "<span class='styEstablece' title='RESULTADO DE LA INVESTIGACI�N DE LA CARTILLA'>" . $Result . "</span>";
                        }
    	       
                    ?>
               </td>
            </tr>
            
            <!-- RESULTADO COMPROBANTE DE ESTUDIOS -->
            <tr>
            
               <td class="styTdExamen" align="center" style="font-size: 10pt;" colspan="2">
                  RESULTADO COMPROBANTE DE ESTUDIOS :
                    <?php
			$x = $xInvDoc->getDatosCompEst();
                        if( $xUsr->xNomPerfil == "INVESTIGADOR" || $xUsr->xNomPerfil == "SUPERVISOR" ){		    
                          $Result = $xInvDoc->getResultado( $xInvDoc->RESULTADO_COMP_EST ); 
                            echo "<span class='styEstablece' title='RESULTADO DE LA INVESTIGACI�N DEL COMPROBANTE DE ESTUDIOS'>" . $Result . "</span>";
                        }
    	       
                    ?>
               </td>
            </tr>
            
         </tbody>
      </table>
      
      <div id="dlgDatosMed" style="text-align: center;" title="Establecer el Resultado de la Evaluaci&oacute;n"></div>
      
      <!--
      antenota
      -->
      <table cellpadding="0" cellspacing="0" border="0" style="width: 400px; border-bottom: 1px solid #cccccb;">
         <tr style="height: 25px;">
            <td style="width: 100px; text-align: left;">
               <?php
               if( !empty( $xUsr->xCurpEval ) && !$xInvDoc->getAnteNota( $xUsr->xCurpEval ) ){
               ?>
                  <a href="#" id="xAntenota" title="Agregar nueva Ante-Nota...">Alerta de Riesgo</a>  
                  <div id="dlgAntenota" title="Ante-Nota del Evaluado"> </div>
               <?php
               
               }
               else{
                
               ?>  
                  <span style="font-family: arial, helvetica, sans-serif; font-size: 9pt; font-weight: bold; color: gray;">Ante-Nota</span>
               <?php
               }
               ?>  
            </td>
            <td style="width: 300px; text-align: left;">
               <?php
               if( $xInvDoc->getAnteNotas() ){
               ?>
                  <a href="#" id="xAntenotas" title="Ver Ante-Notas..." style="color: #f87217;">
                     <img src="<?php echo $xPath?>imgs/warning_22.png" style="vertical-align: middle; border: 0;" alt="Alerta" />
                     Existen Ante-Notas...
                  </a> 
                  <div id="dlgAntenotas" title="Ante-Notas del Evaluado"> </div>
               <?php
               
               }
               else
                  echo "&nbsp;";
                  
               ?>
            </td>
            <td style="width: 100px; text-align: right;">
               <a href="#" id="xHistorial" title="Ver Historial de evaluaciones...">Historial</a> 
               <div id="dlgHistorial" title="Historial de Evaluaciones"> </div>           
            </td>
         </tr>
      </table>
      
      <!-------------------------------------------------------------------------------------------------------------------------------- --> 

      <?php
      
      if(  $xInvDoc->ExistIdDatosGenerales() && ( $xUsr->xNomPerfil == "INVESTIGADOR" || $xUsr->xNomPerfil == "SUPERVISOR" ) ){
         $rta_exped = $xPath."Archivo/DeptoESocial/invdoc/Expedientes/".$_SESSION["xCurp"]."/";
      ?>
         <table id="tbFormatos" cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td colspan="3" style="height: 25px; background-color: #488ac7; color: white; font-weight: bold;">FORMATOS DE EVALUACION</td>
            </tr>
            <!--  Cartilla    -->
            <tr>
	       <td id="tdMsj01" style="width: 50px; text-align: center;">&nbsp;  </td>
               <td id="tdFormato1" style="width: 400px; text-align: left;">
               <?php
               if( file_exists($rta_exped.$_SESSION["xCurp"]."_F001.jpg") ){
                  echo '<a href="#" onclick="impresion(\'1\' , \'01\')" title="Cartilla S.M.N. escaneada">Cartilla S.M.N.</a>';
               }
               else{
		          echo 'Cartilla S.M.N.';
               }               
               ?>
               </td>
               <td style="width: 50px; text-align: center;">
                  <a href="#" id="xF01" title="Cartilla S.M.N.">Archivar</a>
               </td>
            </tr>
	    
            <!--  Comprobante de Estudios   -->
            <tr>
	       <td id="tdMsj02" style="width: 50px; text-align: center;">&nbsp;</td>
               <td id="tdFormato2" style="width: 400px; text-align: left;">
               <?php
               if( file_exists($rta_exped.$_SESSION["xCurp"]."_F002.jpg") ){
                  echo '<a href="#" onclick="impresion(\'2\' , \'02\')" title="Comprobante de Estudios escaneado">Comprobante de Estudios</a>';
               }else{
                    echo "Comprobante de Estudios";
               }
               ?>
               </td>
               <td style="width: 50px; text-align: center;">
                  <a href="#" id="xF02" title="Comprobante de Estudios">Archivar</a>
               </td>
            </tr>

	    
	    <!--  FORMATO DE INVESTIGACION DOCUMENTAL  -->
            <tr>
	       <td style="width: 50px; text-align: center;">&nbsp;  </td>
               <td style="width: 400px; text-align: left;">
		          Formato de Investigaci&oacute;n Documental
               </td>
               <td style="width: 50px; text-align: center;">
                  <a href="#" id="xForInvDoc" title="Formato de Investigaci&oacute;n Documental">Ver</a>
               </td>
            </tr>
	    
	    
	 </table>
      <?php
      }
      ?>
      <!-- ---------------------------------------------------------------------------------------------------------------------------- -->
         
   </div>

   <input type="hidden" name="Id" id="xId" value="<?php echo $xPersona->CURP;?>" />
   <input type="hidden" name="xCurpUsr" id="xCurpUsr" value="<?php echo $xUsr->xCurpEval;?>" />
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