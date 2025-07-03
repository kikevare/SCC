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
   $jsxCoordina   = $xPath."includes/js/evesocial/socioe/xctrl_coord.js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Evaluaci&oacute;n Socio-Economica</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />       
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>   
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxFileUpload;?>"></script>
   <script language="javascript" src="<?php echo $jsxCoordina;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xCtrlEvalSocioE();                 
      });
   </script>  
   <style type="text/css">
      .styLink{ color: #272; color: !important; }
      .stytbDatosPer{ width: 700px; border-top: 0px solid #cccccb; border-bottom: 1px solid #cccccb; margin: 5px 0 0 0; }
      .stytbDatosPer td{ font-size: 9pt; padding: 5px 3px 5px 3px; }  
      .styxBtnOpcion{width: 70px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}
      .styTitExamen{text-align: center; font-weight: bold; font-size: 13pt; border-top: 1px solid #cccccb; border-bottom: 1px solid #cccccb; padding: 10px 0 10px 0; }
      .styTdExamen{ padding: 7px 0 5px 0; text-align: center; }
      .styPrevio{text-shadow: !important; color: darkorange; font-family: sans-serif; font-size: 10pt; font-weight: bolder}
      .styEstablece{text-shadow: !important; color: green; cursor: pointer; font-family: sans-serif; font-size: 10pt; font-weight: bolder}
      .styRestablece{text-shadow: !important; color: #614; cursor: pointer; font-family: sans-serif; font-size: 10pt; font-weight: bolder}
      .styObserva{ font-family: sans-serif; font-size: 8pt; font-weight: bolder; color: #8A0829; cursor: pointer; }
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
        if( isset($_GET["curp"] ) ){
         $xPersona = New Persona($_GET["curp"]);
         $xISE = New invSocioEconomica( $_GET["curp"] );
         $_SESSION["xCurp"] = $xPersona->CURP;
        }
        else{
         $xPersona = New Persona($_SESSION["xCurp"]);
         $xISE = New invSocioEconomica( $_SESSION["xCurp"] );
        }
        //--------------------------------------------------------------------------// 
      
        $xfoto = $xPersona->getFoto();
        if( !empty($xfoto) )
          $xfoto = $xPath.$xfoto;
        else      
          $xfoto = $xPath."imgs/sin_foto.png";
        
        $Datos = $xISE->getDatosISE();
        $DatosResPrevio = $xISE->getDatosAnalisis();
      
        ?>    
      
      <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0" style="width: 700px;">
         <tr>
            <td width="50%" align="right" id="tdBtns">               
               <a href="#" class="styxBtnOpcion" id="xRegresar" title="Regresar...">
                  <img src="<?php echo $xPath;?>imgs/back_32.png" border="0" />
                  <br/>Regresar <?php //echo $_GET["curp"]; ?>
               </a>                        
            </td>
         </tr>
      </table>       
      <table border="0" class="stytbDatosPer" cellpadding="0" cellspacing="0">
         <tr> 
            <td rowspan="7" width="15%" align="center" style="border-right: 1px dotted #cccccb;">
               <div style="width: 90px; height: 110px; border: 1px dashed gray;" title="Sin fotograf�a...">
                  <img src="<?php echo $xfoto; ?>" width="85" height="105" />
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
            <td width="10%" align="left" style="font-weight: bold;">F. INGRESO:</td>
            <?php 
            $f_ing = ( !empty($xPersona->FECHAING) ) ? $xSys->FormatoCorto( date("d-m-Y", strtotime($xPersona->FECHAING)) ) : "--";
            ?>
            <td width="30%" align="left"><?php echo $f_ing;?></td>
         </tr>         
      </table>  

        <?php        
        //se comprueba si existe el registro en la tabla de evaluacion socioeconomica.
        if( !$xISE->ExistIdDatosISE() ){
            $xBanderaEval = 1;
        ?>
            <div id="dlgEval" class="dialog" title="Evaluaci�n Socio-Economica :: Investigaci&oacute;n Socio-Econ&oacute;mica">
                <fieldset id="fsContenido" style="width: 99%;">
                <legend style="font: normal; font-size: 8pt;">&nbsp; [ Advertencia ] &nbsp;</legend>
                    <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
                       <tr>       
                           <td class="styTdNombreCampo">Aun no se ha iniciado el proceso de evaluaci&oacute;n para este elemento.</td>
                        </tr>                           
                    </table>
                </fieldset>
            </div>
        <?php        
        }        
        ?>
        
        <?php        
        //se comprueba si el usuario es el que lleva el proceso de la evaluacion.
        if( ( $xUsr->xCurpEval != $DatosResPrevio[0]["CURP_EVAL"] ) && !empty( $DatosResPrevio[0]["CURP_EVAL"] ) ) {
            $xBanderaUsr = 1;
        ?>
            <div id="dlgUsr" class="dialog" title="Evaluaci�n Socio-Economica :: Investigaci&oacute;n Socio-Econ&oacute;mica">
                <fieldset id="fsContenido" style="width: 99%;">
                <legend style="font: normal; font-size: 8pt;">&nbsp; [ Advertencia ] &nbsp;</legend>
                    <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
                       <tr>       
                           <td class="styTdNombreCampo">Esta evaluaci&oacute;n le corresponde a otro evaluador.</td>
                        </tr>                           
                    </table>
                </fieldset>
            </div>
        <?php        
        }        
        ?>

      
      <br />      
      <table id="xMenu" cellpadding="0" cellspacing="0" style="width: 460px; border-bottom: 1px solid #cccccb;" border="0">
         <thead style="">            
            <th class="styTitExamen" colspan="3">.:: MEN&Uacute; ::. </th>            
         </thead>
         <tbody>
            
            <?php if( $xISE->ExisteCorreccionEval( $xUsr->xCurpEval ) )
                { 
            ?>
            <tr>
                <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: red; color: #fff; font-size: 14px; font-weight: bolder; text-align: center;" colspan="3">
                    Esta evaluaci&oacute;n tiene una correcci&oacute;n pendiente.
                </td>
            </tr>
            <?php 
                }                                     
            ?>
            
            <!-- ----------- AVISO DE NUEVAS CORRECCIONES ------------------------ -->
            
            <?php
                //CONTROL DE ENTREGA EXPEDIENTE. 
                if( $xISE->existeCorrEvalISE( $xUsr->xCurpEval, 1 ) ){
            ?>        
            <tr>
                <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: #013ADF; color: #fff; font-size: 14px; font-weight: bolder; text-align: center;" colspan="3">
                    Existe una correcci&oacute;n pendiente en el Reporte y An&aacute;lisis (Nueva versi&oacute;n).
                </td>
            </tr>  
            
            <?php                        
                }                          
            
                //CONTROL DE ENTREGA EXPEDIENTE. 
                if( $xISE->existeCorrEvalISE( $xUsr->xCurpEval, 2 ) )
                { 
            ?>
            <tr>
                <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: #013ADF; color: #fff; font-size: 14px; font-weight: bolder; text-align: center;" colspan="3">
                    Existe una correcci&oacute;n pendiente en el Control de Entrega del Expediente.
                </td>
            </tr>
            <?php 
                }                                     
            
            
                //MATRIZ DE ASOCIACION 
                if( $xISE->existeCorrEvalISE( $xUsr->xCurpEval, 3 ) )
                { 
            ?>
            <tr>
                <td style="height: 10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="background-color: #01DF01; color: #fff; font-size: 14px; font-weight: bolder; text-align: center;" colspan="3">
                    Existe una correcci&oacute;n pendiente en la Matriz de Asociaci&oacute;n.
                </td>
            </tr>
            <?php 
                }                                     
            ?>
            
             <tr>                   
                <!-- reporte y analisis version anterior-->
                <td class="styTdExamen">            
                  <a href="#" id="xRepAnalisis" style="width: 220px; height: 50px;" title="Datos del Reporte y An&aacute;lisis (Versi&oacute;n anterior)..." >
                     <img src="<?php echo $xPath;?>imgs/rep_analisis.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Reporte y An&aacute;lisis (Versi&oacute;n anterior)</div>
                  </a>
                </td>             
    	    
                        
                <!-- control de entrega de expediente -->
                <td class="styTdExamen">            
                  <a href="#" id="xCtrlEntExp" style="width: 220px; height: 50px;" title="Control de Entrega del Expediente..." >
                     <img src="<?php echo $xPath;?>imgs/ctrl_exp.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Control de Entrega del Expediente</div>
                  </a>
                </td> 
                                
            </tr>
            <tr>
                <!-- reporte y analisis nueva version -->
                <td class="styTdExamen">            
                  <a href="#" id="nxRepAnalisis" style="width: 220px; height: 50px;" title="Datos del Reporte y An&aacute;lisis (Versi&oacute;n nueva)..." >
                     <img src="<?php echo $xPath;?>imgs/rep_analisis.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left; color: red;">Reporte y An&aacute;lisis (Versi&oacute;n nueva)</div>
                  </a>
                </td>   
                
                <!-- matriz ise-->
                <td class="styTdExamen">            
                  <a href="#" id="xMatriz" style="width: 220px; height: 50px;" title="Matriz de Asociaci&oacute;n..." >
                     <img src="<?php echo $xPath;?>imgs/matriz_ise.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Matriz de Asociaci&oacute;n</div>
                  </a>
                </td>                 
                <td class="styTdExamen">            
                  <a href="#" id="xtrabajo" style="width: 220px; height: 50px;" title="Matriz de Asociaci&oacute;n..." >
                     <img src="<?php echo $xPath;?>imgs/rpt_list.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Trabajo de investigacion </div>
                  </a>
                </td>    
    	    </tr>            

            <tr>
                <!-- reporte de antecedentes -->
                <td class="styTdExamen" colspan="2">
                  <a href="#" id='xBusqAnt' style="width: 220px; height: 50px;" title="B&uacute;sq. de Antecedentes..." >
                     <img src="<?php echo $xPath;?>imgs/rep_anteced.png" border="0" align="middle" /> 
                     <div style="width: 150px; float: right; padding: 5px 2px 3px 10px; text-align: left;">Reporte de Antecedentes <span style="color: red;">(Solo consulta)</span></div>
                  </a>
                </td>
            </tr>
            
            <!-- OBSERVACIONES DELA CARTILLA -->
            <tr>            
               <td class="styTdExamen" style="text-align: center;" colspan="2">
                  <span id="xObCartilla" class="styObserva" title="Click para ver las observaciones sobre la Cartilla SMN">
                    VER OBSERVACIONES CARTILLA
                  </span>  
                  <div id="dlgObCartilla" style="text-align: center;" title="Investigaci&oacute;n Socioecon&oacute;mica"></div>                  
               </td>
            </tr>
            
            
            <!-- OBSERVACIONES DEL COMPROBANTE DE ESTUDIOS -->
            <tr>            
               <td class="styTdExamen" style="text-align: center;" colspan="2">
                  <span id="xObCompEst" class="styObserva" title="Click para ver las observaciones sobre el Comprobante de Estudios">
                    VER OBSERVACIONES COMPROBANTE DE ESTUDIOS
                  </span>  
                  <div id="dlgObCompEst" style="text-align: center;" title="Investigaci&oacute;n Socioecon&oacute;mica"></div>                  
               </td>
            </tr>
                        
            <!-- opcion para seleccionar el supervisor-revisor -->
            <tr>
                <td style="text-align: center; padding-top: 4px;" colspan="2">
                    <span style="font-size: 12px;">SELECCIONE EL SUPERVISOR:</span>&nbsp;
                    <?php 
                        if( $xISE->ExistIdDatosAnalisis() > 0){
                            $sup_dis = "";
                            $title = "";
                        }else{
                            $sup_dis = "disabled";
                            $title = "title='Necesita registrar el Reporte y An&aacute;lisis'";
                        }
                    ?> 
                    <select class="select" size="1" name="evaluadores" id="xEvaluadores" <?php echo $sup_dis . " " . $title; ?> >
                    <?php
                        echo $xISE->shwEvaluadoresISE( $DatosResPrevio[0]["CURP_SUPERVISOR"] );
                    ?>                    
                    </select>
                </td>            
            </tr>
            <!-- opcion para seleccionar la fecha de evaluacion -->
            <?php 
                if( $DatosResPrevio[0]["FECHA_EVALUACION"] != "" ){
                    $fecha_eval = $xSys->FormatoCorto( date("d-m-Y", strtotime( $DatosResPrevio[0]["FECHA_EVALUACION"] ) ) );
                }                       
            ?>
            <tr>
                <td style="text-align: center; padding-top: 4px; padding-bottom: 4px;" colspan="2">
                    <span style="font-size: 12px;">SELECCIONE LA FECHA DE EVALUACI&Oacute;N:</span>&nbsp;
                    <?php
                    if( $xISE->ExistIdDatosAnalisis() > 0){                        
                    ?>
                    <input type="text" class="textread" size="12" name="fecha_eval" id="xFechaEval" 
                    value="<?php echo $fecha_eval; ?>" readonly="true" />
                    <?php
                    }else{
                    ?>
                    <input type="text" class="textread" size="12" readonly="true" disabled="true" <?php echo $title; ?> />
                    <?php    
                    }
                    ?>
                </td>            
            </tr>
            
            <!-- RESULTADO PREVIO -->
            <tr>
            
               <td class="styTdExamen" style="font-size: 10pt; text-align: center;" colspan="2">
                  RESULTADO PREVIO <?php //echo $DatosResPrevio[0]["RESULTADO_PREVIO"]; ?>:
                    <?php
                    
                            if( $xUsr->xNomPerfil == "INVESTIGADOR" || $xUsr->xNomPerfil == "SUPERVISOR" ){		    
                                $Resultado = $xISE->getResultadoPrevio( $DatosResPrevio[0]["RESULTADO_PREVIO"] );
                                if( empty($Resultado) ){
                                    $Resultado = "NO ESPECIFICADO";
                                } 
                                echo "<span class='styPrevio' title='Resultado previo de la Evaluaci&oacute;n'>" . $Resultado . "</span>";
                        }
    	       
                    ?>
               </td>
            </tr>
            
            <!-- resultado final -->
            <tr>
               <td class="styTdExamen" style="font-size: 10pt; text-align: center;" colspan="2">
                  RESULTADO FINAL :&nbsp; 
                  <?php
                        
                      if( $xUsr->xResult == 1 ){
                         
                         $Result = $xISE->getResultadoISE();
                         if( empty( $Result[0] ) ){
                               echo "<span id='xEstableceRes' class='styEstablece' title='Establecer el resultado final de la evaluaci&oacute;n...'>EVALUAR</span>";
                            
                         }else{
            	               echo "<span style='font-weight: bold; color: red;'>".$Result[0]."</span>";
                         }
                         
                      }else{
                            echo "<span style='font-weight: bold;'>NO AUTORIZADO PARA VER RESULTADO</span>";
                      } 
            
                   ?>
                   
               </td>
            </tr>            
            
            <tr>            
                <td colspan="3">                
                    <!-- dialogo para mostrar el restablecimiento del resultado -->
                    <div id="dlgRestableceRes" class="dialog" title="Evaluaci�n Socioecon&oacute;mica :: Opci&oacute;n de Supervisor">
                        <fieldset id="fsContenido" style="width: 99%;">
                        <legend style="font: normal; font-size: 8pt;">&nbsp;[Evaluaci�n Socioecon&oacute;mica] &nbsp;</legend>
                            <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
                                <tr>       
                                   <td class="styTdNombreCampo">Confirme que desea liberar el resultado ...</td>                 
                
                                </tr>                          
                            </table>
                        </fieldset>
                    </div>                
                </td>            
            </tr>
            
            <tr>
        
                <td colspan="3" style="text-align: center;">     
           
<?php
    //instrucciones para liberar el resultado
    if( !empty( $Result[0] ) ){
        echo "<span id='xRestableceRes' class='styRestablece' title='Liberar el resultado de la evaluaci&oacute;n...'>LIBERAR RESULTADO</span>";
    }
?>           
        
                </td>
        
            </tr>
            
         </tbody>
      </table>
      
      <!-- esta capa permite mostrar el dialogo para establecer el resultado -->
      <div id="dlgDatosInt" style="text-align: center;" title="Establecer el Resultado de la Evaluaci&oacute;n"></div>
      
      <!--
      antenota
      -->
      <table cellpadding="0" cellspacing="0" border="0" style="width: 400px; border-bottom: 1px solid #cccccb;">
         <tr style="height: 25px;">
            <td style="width: 100px; text-align: left;">
               <?php
               if( !empty( $xUsr->xCurpEval ) ){
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
            <td style="width: 300px; text-align: center;">
               <?php
               if( $xISE->getAnteNotas() ){
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

         <table id="tbFormatos" cellpadding="0" cellspacing="0" border="0">
         
            <tr>
                <td colspan="3" style="height: 25px; background-color: #488ac7; color: white; font-weight: bold;">FORMATOS DE EVALUACION</td>
            </tr>
            
            <!--  reporte y analisis vieja version -->
            <tr>
                <td style="width: 50px; text-align: center;">&nbsp;  </td>
                <td style="width: 400px; text-align: left;">
                    Reporte y An&aacute;lisis (Vieja versi&oacute;n
                </td>
                <td style="width: 50px; text-align: center;">
                <?php 
                if( $xISE->ExistIdDatosAnalisis() > 0){
                ?> 
                    <a href="#" id="xRepAnalisisPDF" title="Reporte y An&aacute;lisis (Vieja versi&oacute;n)">Ver</a>
                <?php
                }else{
                ?>
                <span style='font-size: 7pt;'>Sin datos</span>
                <?php
                }
                ?>
                </td>
            </tr>	 
            
            <!--  reporte y analisis nueva version  -->
            <tr>
                <td style="width: 50px; text-align: center;">&nbsp;  </td>
                <td style="width: 400px; text-align: left; color: red;">
                    Reporte y An&aacute;lisis (Nueva versi&oacute;n)
                </td>
                <td style="width: 50px; text-align: center;">
                <?php 
                if( $xISE->ExistIdDatosAnalisis() > 0){
                ?> 
                    <a href="#" id="nxRepAnalisisPDF" title="Reporte y An&aacute;lisis (Nueva versi&oacute;n)">Ver</a>
                <?php
                }else{
                ?>
                <span style='font-size: 7pt;'>Sin datos</span>
                <?php
                }
                ?>
                </td>
            </tr> 
            
            <!--  control de entrega de expediente  -->
            <tr>
                <td style="width: 50px; text-align: center;">&nbsp;</td>
                <td style="width: 400px; text-align: left;">
                    Control de Entrega del Expediente
                </td>
                <td style="width: 50px; text-align: center;">
                <?php 
                if( $xISE->ExistIdDatosCtrlEntExp() > 0){
                ?>                
                    <a href="#" id="xCtrlEntExpPDF" title="Control de Entrega del Expediente">Ver</a>                
                <?php
                }else{
                ?>
                    <span style='font-size: 7pt;'>Sin datos</span>                
                <?php
                }
                ?>
                </td> 
            </tr>  
            <!--  matriz-ise  -->
            <tr>
                <td style="width: 50px; text-align: center;">&nbsp;</td>
                <td style="width: 400px; text-align: left;">
                    Matriz de Asociaci&oacute;n
                </td>
                <td style="width: 50px; text-align: center;">
            <?php
                        
            if( $xISE->getTotalRegMatrizIse() > 0){
            
            ?>                
                    <a href="#" id="xMatrizIsePDF" title="Matriz de Asociaci&oacute;n">Ver</a>                                       
            <?php
            
            }else{                                      
            
            ?>                
                    <span style='font-size: 7pt;'>Sin datos</span>                                             
            <?php
                
            }
            
            ?>
                </td> 
            </tr> 
	    
	 </table>
      <?php
      //}
      ?>
      <!-- ---------------------------------------------------------------------------------------------------------------------------- -->
         
   </div>

    <input type="hidden" name="bandera_eval" id="xBanderaEval" value="<?php echo $xBanderaEval; ?>" />
    <input type="hidden" name="bandera_usr" id="xBanderaUsr" value="<?php echo $xBanderaUsr; ?>" />
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