<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - 2;
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");   
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/catalogos.class.php");
   include_once($xPath."includes/invDocumental.class.php");
   $xSys = New System();
   $xCat = New Catalog();
   $xUsr = New Usuario(); 
   $xInvDoc = New invDocumental();
   
   //-------- Define el id del m�dulo y el perfil de acceso -------//
   $xInicio = 0;
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];         
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//
   
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $cssDialog     = $xPath."includes/js/dialog/css/smoothness/jquery-ui-1.8.16.custom.css";
   $jsjQuery      = $xPath."includes/js/jquery.js";
   $jsjQueryDlg1  = $xPath."includes/js/dialog/js/jquery-1.6.2.min.js";
   $jsjQueryDlg2  = $xPath."includes/js/dialog/js/jquery-ui-1.8.16.custom.min.js";
   $jsxMain       = $xPath."includes/js/xmain.js";
   $jsxRptDoc     = $xPath."includes/js/evesocial/invdoc/xInvdocrpt.js";
   
   
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Men� principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" /> 
   <link href="<?php echo $cssDialog;?>" rel="stylesheet" type="text/css" />          
   <script language="javascript" src="<?php echo $jsjQuery;?>"></script>
   <script language="javascript" src="<?php echo $jsxMain;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg1;?>"></script>
   <script language="javascript" src="<?php echo $jsjQueryDlg2;?>"></script>
   <script language="javascript" src="<?php echo $jsxRptDoc;?>"></script>
   <script type="text/javascript">      
      var xHoldColor = "";
      var xHoldIdColor = ""; 
      $(document).ready(function(){
         xShowMenu();
         xGrid();
         xCtrlIdx();
         xBusquedaR();
      });
   </script> 
   
   <style type="text/css">
      .styxBtnOpcion{width: 70px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;}
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
<form name="fForm" id="fForm" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" enctype="application/x-www-form-urlencoded">   
   <div id="xdvContenedor" class="styContenedor">
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      $xSys->getNameMod($_SESSION["menu"]);
      //--------------------------------------------------------------------------//
         
      //------------ Recepcion de par�metros de ordenaci�n y b�squeda ------------//
      //-- Inicializa los par�metros...
      $idOrdr      = 2;      
      $tipoOrdr    = "Asc";
      $txtBuscar   = "";
      $cmpBuscar   = 1;//TIPO DOCUMENTO
      $cmpBuscarf  = 1;//fecha recepcion
      $cmpBuscard  = 1;//fecha solicitud y respuesta
      $cmpBuscarS  = 0;//sexo
      $cmpBuscar2  = 8;//NIVEL ESTUDIO
      $cmpBuscar3  = 0; //DOCUMENTO ESTUDIO
      $cmpBuscar4  = 0; //ESCUELA
      $cmpBuscar5  = 0; //RESULTADO ESTUDIO
      $cmpBuscar6  = 0; //DOCUMENTO CARTILLA
      $cmpBuscar7  = 0; //DEPENDENCIA CARTILLA
      $cmpBuscar8  = 0; //RESULTADO CARTILLA
      
      //-- Revisa si se ha ejecutado una ordenaci�n...
      if( isset($_POST["id_ordenr"]) ){
         
         $idOrdr   = $_POST["id_ordenr"];         
         $tipoOrdr = $_POST["tp_ordenr"];
         //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
         $_SESSION["id_ordenr"] = $idOrdr;
         $_SESSION["tipo_ordenr"] = $tipoOrdr;
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos TIPO DOCUMENTO
      if( isset($_POST["cbCampor"])  ){
         $cmpBuscar = $_POST["cbCampor"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar"] = $cmpBuscar;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos SEXO...
      if( isset($_POST["cbCamporS"])  ){
         $cmpBuscarS = $_POST["cbCamporS"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscarS"] = $cmpBuscarS;             
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos FECHA RECEPCION
      if( isset($_POST["cbCamporf"])  ){
         $cmpBuscarf = $_POST["cbCamporf"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscarf"] = $cmpBuscarf;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos FECHAS SOLICITUD Y RESPUESTA
      if( isset($_POST["cbCampord"])  ){
         $cmpBuscard = $_POST["cbCampord"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscard"] = $cmpBuscard;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor2"])  ){
         $cmpBuscar2 = $_POST["cbCampor2"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar2"] = $cmpBuscar2;
                     
      }
      
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor3"])  ){
         $cmpBuscar3 = $_POST["cbCampor3"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar3"] = $cmpBuscar3;
                     
      }
      
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor4"])  ){
         $cmpBuscar4 = $_POST["cbCampor4"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar4"] = $cmpBuscar4;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor5"])  ){
         $cmpBuscar5 = $_POST["cbCampor5"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar5"] = $cmpBuscar5;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos
      if( isset($_POST["cbCampor6"])  ){
         $cmpBuscar6 = $_POST["cbCampor6"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar6"] = $cmpBuscar6;
                     
      }
      
      //-- Revisa si se ha ejecutado una b�squeda por campos
      if( isset($_POST["cbCampor7"])  ){
         $cmpBuscar7 = $_POST["cbCampor7"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar7"] = $cmpBuscar7;          
      }
       //-- Revisa si se ha ejecutado una b�squeda por campos
      if( isset($_POST["cbCampor8"])  ){
         $cmpBuscar8 = $_POST["cbCampor8"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar8"] = $cmpBuscar8;          
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["txtBuscar"]) && !empty($_POST["txtBuscar"]) ){
         //$cmpBuscar3 = $_POST["cbCampor3"];
         $txtBuscar = $_POST["txtBuscar"];            
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         //$_SESSION["cmp_buscar3"] = $cmpBuscar3;
         $_SESSION["txt_buscar"] = $txtBuscar;            
      }
      //-- Revisa si se ha ejecutado una b�squeda por fecha...
      if( isset($_POST["txtFecha1"]) && !empty($_POST["txtFecha1"]) ){         
         $txtFecha1 = $xSys->ConvertirFecha($_POST["txtFecha1"], "yyyy-mm-dd");
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["txt_fecha1"] = $txtFecha1;
      }
      //-- Revisa si se ha ejecutado una b�squeda por fecha...
      if( isset($_POST["txtFecha2"]) && !empty($_POST["txtFecha2"]) ){         
         $txtFecha2 = $xSys->ConvertirFecha($_POST["txtFecha2"], "yyyy-mm-dd");
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["txt_fecha2"] = $txtFecha2;
      }
      /*
      Si el m�dulo no ha sido invocado desde el men� principal,
      entonces revisa si existen datos en las variables de sesi�n
      de alguna b�squeda u ordenaci�n.
      */
      if( $xInicio == 0 ){
         if( $_SESSION["id_ordenr"]     != "" )   $idOrdr       = $_SESSION["id_ordenr"]; 
         if( $_SESSION["tipo_ordenr"]   != "" ) $tipoOrdr       = $_SESSION["tipo_ordenr"];
         if( $_SESSION["cmp_buscar"]    != "" )  $cmpBuscar     = $_SESSION["cmp_buscar"];//TIPO DOCUMENTO
         if( $_SESSION["cmp_buscarS"]   != "" ) $cmpBuscarS     = $_SESSION["cmp_buscarS"];//SEXO
         if( $_SESSION["cmp_buscarf"]   != "" ) $cmpBuscarf     = $_SESSION["cmp_buscarf"];//RECEPCION
         if( $_SESSION["cmp_buscard"]   != "" ) $cmpBuscard     = $_SESSION["cmp_buscard"];//SOLICITUD Y RESPUESTA
         if( $_SESSION["cmp_buscar2"]   != "" ) $cmpBuscar2     = $_SESSION["cmp_buscar2"];//NIVEL DE ESTUDIO
         if( $_SESSION["cmp_buscar3"]   != "" ) $cmpBuscar3     = $_SESSION["cmp_buscar3"];//DOCUMENTO ESTUDIO
         if( $_SESSION["cmp_buscar4"]   != "" ) $cmpBuscar4     = $_SESSION["cmp_buscar4"];//ESCUELA
         if( $_SESSION["cmp_buscar5"]   != "" ) $cmpBuscar5     = $_SESSION["cmp_buscar5"];//RESULTADO ESTUDIO
         if( $_SESSION["cmp_buscar6"]   != "" ) $cmpBuscar6     = $_SESSION["cmp_buscar6"];//RESULTADO ESTUDIO
         if( $_SESSION["cmp_buscar7"]   != "" ) $cmpBuscar7     = $_SESSION["cmp_buscar7"];//RESULTADO ESTUDIO
         if( $_SESSION["cmp_buscar8"]   != "" ) $cmpBuscar8     = $_SESSION["cmp_buscar8"];//RESULTADO ESTUDIO
         if( $_SESSION["txt_buscar"]    != "" )  $txtBuscar     = $_SESSION["txt_buscar"];
         if( $_SESSION["txt_fecha1"]    != "" )  $txtFecha      = $_SESSION["txt_fecha1"];//FECHA INICIA
         if( $_SESSION["txt_fecha2"]    != "" )  $txtFecha2     = $_SESSION["txt_fecha2"];//FECHA TERMINA
         $xMsj = "�ltima b�squeda realizada...";
      }
      else{         
         $_SESSION["id_ordenr"]   = "";
         $_SESSION["tipo_ordenr"] = "";
         $_SESSION["cmp_buscar"]  = "";//TIPO DOCUMENTO
         $_SESSION["cmp_buscarS"] = "";//SEXO
         $_SESSION["cmp_buscarf"] = "";//RECEPCION
         $_SESSION["cmp_buscard"] = "";//SOLICITUD Y RESPUESTA
         $_SESSION["cmp_buscar2"] = "";//NIVEL DE ESTUDIO
         $_SESSION["cmp_buscar3"] = "";//DOCUMENTO ESTUDIO
         $_SESSION["cmp_buscar4"] = "";//ESCUELA
         $_SESSION["cmp_buscar5"] = "";//RESULTADO ESTUDIO
         $_SESSION["cmp_buscar6"] = "";//RESULTADO ESTUDIO
         $_SESSION["cmp_buscar7"] = "";//RESULTADO ESTUDIO
         $_SESSION["cmp_buscar8"] = "";//RESULTADO ESTUDIO
         $_SESSION["txt_buscar"]  = "";
         $_SESSION["txt_fecha1"]  = "";//FECHA INICIA
         $_SESSION["txt_fecha2"]  = "";//FECHA TERMINA
         $xMsj = "";
      }
      //--------------------------------------------------------------------------//
      ?> 
      
      <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0">
         <tr>
            <td style="width: 50%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">      
               Documento:<br />              
               <select name="cbCampor" id="xcbCampor" style="color: #565051;">
                  <?php
                      $noticias = simplexml_load_file("_camposbuscarD.xml");
                      foreach( $noticias->campo as $noticia ){
                         if( $cmpBuscar == $noticia->valor )
                            echo"<option value='".$noticia->valor."' selected>".$noticia->descrip."</option>";
                         else
                            echo"<option value='".$noticia->valor."'>".$noticia->descrip."</option>";
                      }
                  ?>  
               </select>
               
            </td>
            <td id="tdBsq" style="width: 25%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">   
                <a href="#" class="styxBtnOpcion" id="xbtnBuscar" title="Buscar..." style="margin-left: 15px;">
                  <img src="<?php echo $xPath?>imgs/buscar_16.png" alt="buscar" style="border: none;" />
                  <br/>Buscar
               </a>
               <a href="#" class="styxBtnOpcion" id="xbtnClear" title="Limpiar par�metros de b�squeda..." style="margin-left: 5px;">
                  <img src="<?php echo $xPath?>imgs/refresh_16.png" alt="buscar" style="border: none;" />
                  <br/>Limpiar
               </a>                 
            </td>
            <td style="width: 25%; text-align: right;" id="tdBtns">
                   <a href="#" class="styxBtnOpcion" id="xExcel" title="Exportar a Excel...">
                      <img src="<?php echo $xPath;?>imgs/excel.png" border="0" />
                      <br/>Excel
                   </a>    
                   <a href="#" class="styxBtnOpcion" id="xRegresar" title="Regresar...">
                      <img src="<?php echo $xPath;?>imgs/back_32.png" border="0" />
                      <br/>Regresar
                   </a>                    
                </td>
         </tr>         
      </table>
      <div>
            <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0">
             <tr>
                <?php 
                if( $cmpBuscar == 1){
                ?>
                    <td style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;"> 
                        Busqueda por fechas<br />
                        <select name="cbCamporf" id="xcbCamporf" style="color: #565051;">
                          <?php
                          $noticias1 = simplexml_load_file("_camposbuscarR.xml");
                          foreach( $noticias1->campo as $noticia1 ){
                             if( $cmpBuscarf == $noticia1->valor )
                                echo"<option value='".$noticia1->valor."' selected>".$noticia1->descrip."</option>";
                             else
                                echo"<option value='".$noticia1->valor."'>".$noticia1->descrip."</option>";
                          }
                          ?>                  
                       </select> &nbsp;&nbsp;
                    </td>
                <?php 
                }
                else if ( $cmpBuscar != 1){
                ?>
                    <td style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;"> 
                        Busqueda por fechas<br />  
                        <select name="cbCampord" id="xcbCampord" style="color: #565051;">
                          <?php
                          $noticias1 = simplexml_load_file("_camposbuscarF.xml");
                          foreach( $noticias1->campo as $noticia1 ){
                             if( $cmpBuscard == $noticia1->valor )
                                echo"<option value='".$noticia1->valor."' selected>".$noticia1->descrip."</option>";
                             else
                                echo"<option value='".$noticia1->valor."'>".$noticia1->descrip."</option>";
                          }
                          ?>                  
                       </select> &nbsp;&nbsp;
                    </td>    
                <?php
                }   
                ?>
                <td style="width: 40%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;"> 
                   <br />
                   <?php
                   $xfecha1 = ( !empty($txtFecha1) )  ? $xSys->FormatoCorto( date("d-m-Y", strtotime($txtFecha1)) ) : "";
                   ?>
                   <input type="text" name="txtFecha1" id="txtFecha1" size="13" value="<?php echo htmlentities($xfecha1);?>" readonly="true" class="textread" style="margin-left: 15px; text-align: center;" />
                   <?php
                   $xfecha2 = ( !empty($txtFecha2) )  ? $xSys->FormatoCorto( date("d-m-Y", strtotime($txtFecha2)) ) : "";
                   ?>
                   <input type="text" name="txtFecha2" id="txtFecha2" size="13" value="<?php echo htmlentities($xfecha2);?>" readonly="true" class="textread" style="margin-left: 15px; text-align: center;" />
                </td>
   
                <td style="width: 45%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;"> 
                    Sexo<br />
                    <select name="cbCamporS" id="xcbCamporS" style="color: #565051;">
                          <option value="0">-- Sexo --</option>
                             <?php                     
                             $xCat->shwGenero($cmpBuscarS);    
                             ?>
                       </select>  &nbsp;&nbsp;
                </td>
             </tr> 
          </table>
      </div>
      <div id="xdCer" style="width: 99%;">
          <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0">
             <tr>
                <td style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">      
                   Nivel de estudio:<br />              
                   <select name="cbCampor2" id="xcbCampor2" style="color: #565051; max-width: 150px;">
                      <option value=" ">-- Seleccione --</option>
                         <?php                     
                         $xCat->shwNivEstudios($cmpBuscar2);    
                         ?>
                   </select>  &nbsp;&nbsp;
                </td> 
                <td style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
                    Certificado:<br />
                    <select name="cbCampor3" id="xcbCampor3" style="color: #565051; max-width: 150px;">
                        <option value="0">-- Seleccione --</option>
                          <?php
                            $xInvDoc->shwInvDocValidarEstudios($cmpBuscar3);  
                          ?>                  
                    </select> &nbsp;&nbsp;                
                </td>
                <td style="width: 25%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
                    Dependencia:<br />
                    <select name="cbCampor4" id="xcbCampor4" style="color: #565051; max-width: 250px;">
                        <option value="0">-- Seleccione --</option>
                          <?php
                            $xInvDoc->shwInvDepExpCompEst($cmpBuscar4);
                          ?>                  
                    </select> &nbsp;&nbsp;                
                </td>
                <td  style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
                    Resultado estudio:<br/>  
                    <select name="cbCampor5" id="xcbCampor5" style="color: #565051;">
                        <option value="0">-- Seleccione --</option>
                          <?php
                            $xInvDoc->shwInvDocResultado($cmpBuscar5);  
                          ?>                  
                    </select> &nbsp;&nbsp;
                    <!--<input type="text" name="txtBuscar" id="xtxtBuscar" size="30" value="<?php //echo htmlentities($txtBuscar);?>" /> -->
                </td>
             </tr>    
          </table>
      </div>
      <div id="xdCar" style="width: 99%;">
          <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0">
             <tr>
                <td style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">      
                   Cartilla:<br />              
                   <select name="cbCampor6" id="xcbCampor6" style="color: #565051; max-width: 150px;">
                      <option value="0">-- Seleccione --</option>
                         <?php                     
                         $xInvDoc->shwInvDocValidarCartilla($cmpBuscar6); 
                         ?>
                   </select>
                   
                </td>
                <td  style="width: 40%; text-align: center; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
                    Dependencia:<br /> 
                    <select name="cbCampor7" id="xcbCampor7" style="color: #565051; max-width: 300px;">
                        <option value="0">-- Seleccione --</option>
                          <?php
                            $xInvDoc->shwInvDepExpCartilla($cmpBuscar7);
                          ?>                  
                    </select> &nbsp;&nbsp;
                    <!--<input type="text" name="txtBuscar" id="xtxtBuscar" size="30" value="<?php //echo htmlentities($txtBuscar);?>" /> -->
                </td>
                <td  style="width: 15%; text-align: left; padding: 0 5px 0 5px; font-family: sans-serif; font-size: 9pt;">
                    Resultado cartilla:<br /> 
                    <select name="cbCampor8" id="xcbCampor8" style="color: #565051;">
                        <option value="0">-- Seleccione --</option>
                          <?php
                            $xInvDoc->shwInvDocResultado($cmpBuscar8);
                          ?>                  
                    </select> &nbsp;&nbsp;
                    <!--<input type="text" name="txtBuscar" id="xtxtBuscar" size="30" value="<?php //echo htmlentities($txtBuscar);?>" /> -->
                </td>
             </tr>       
          </table>
      </div>
      <div style="width: 99%;">
         <div id="dvxMsj" class="styxMsjGrid"> <?php echo $xMsj;?> </div>
         <div id="dvxTotal" class="styTotalResult"> </div>
      </div>
      <div style="width: 99%; max-height: 600px; border: 2px double gray; overflow: auto;">
          <table id="xGrid" class="styGrid" cellpadding="0" cellspacing="0">         
             <thead>
                <th id="col1">NO</th>
                <th id="col2">NOMBRE</th>
                <th id="col3">SEXO</th>
                <th id="col4">CURP</th>
                <th id="col5">PUESTO O CATEGORIA</th>
                <th id="col6">CORPORACION</th>
                <th id="col7">MUNICIPIO</th>
                <th id="col8">ESTATUS</th>
                <th id="col9">FECHA DE EVALUACION</th>
                <th id="col10">ESCOLARIDAD</th>
                
                <th id="col11">DATOS DE LA INSTITUCION</th>
                <th id="col12">LUGAR DE EXPEDICION</th>
                <th id="col13">ESTADO</th>
                <th id="col14">DEPENDENCIA</th>
                <th id="col15">DOCUMENTO A VALIDAR</th>
                <th id="col16">FECHA DE SOLICITUD</th>
                <th id="col17">NUMERO DE OFICIO</th>
                <th id="col18">FECHA DE RESPUESTA</th>
                <th id="col19">NUMERO DE OFICIO</th>
                <th id="col20">RESULTADO</th>
                <!--<th id="col21">REPORTE</th>-->
                <th id="col22">OBSERVACIONES</th>
             
                <th id="col23">DOCUMENTO A VALIDAR</th>
                <th id="col24">MATRICULA</th>
                <th id="col25">CLASE</th>
                <th id="col26">ZONA MILITAR</th>
                <th id="col27">FECHA DE SOLICITUD</th>
                <th id="col28">NUMERO DE OFICIO</th>
                <th id="col29">FECHA DE RESPUESTA</th>
                <th id="col30">NUMERO DE OFICIO</th>
                <th id="col31">RESULTADO</th>
                <!--<th id="col32">REPORTE</th>-->
                <th id="col33" tyle="border-right: 1px solid #000;">OBSERVACIONES</th>
             <tbody>         
                <?php
                
                $Datos = $xInvDoc->BusRptDoc($cmpBuscar, $cmpBuscarS, $cmpBuscarf, $cmpBuscard, $cmpBuscar2, $cmpBuscar3, $cmpBuscar4, $cmpBuscar5,$cmpBuscar6,$cmpBuscar7,$cmpBuscar8, $txtBuscar, $idOrdr, $tipoOrdr, 1, $_SESSION["txt_fecha1"], $_SESSION["txt_fecha2"]);            
                $i=1;
                foreach( $Datos As $registro ){
                   echo"<tr id='".$registro["CURP"]."' bgcolor='#ffffff'>";
                      echo"<td align='center'   style='min-width: 90px;'>".$i++."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["APELLIDOS"]." ".$registro["NOMBRE"]."</td>";
                      if($registro["GENERO"]==1)
                        $Genero="H";
                      else 
                        $Genero="M";
					       echo"<td align='center'   style='min-width: 100px;'>".$Genero."</td>";
                      echo"<td align='center' style='min-width: 100px;'>".$registro["CURP"]."</td>";
                      if($registro["ID_CORPORACION"]==2)
                        $municipio=$registro["MUNICIPIO"];
                      else
                        $municipio=$registro["CORPORACION"];
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["CATEGORIA"]."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["CORPORACION"]."</td>";
					       echo"<td align='left'   style='min-width: 100px;'>".$registro["MUNICIPIO"]."</td>";
					       echo"<td align='left'   style='min-width: 100px;'>".$registro["TIPO_EVAL"]."</td>";
                      if(empty($registro["FECHA_RECEPCION"]))
                        $fecha_eval="";
                      else
                        $fecha_eval=date("d/m/Y",strtotime($registro["FECHA_RECEPCION"]));
					       echo"<td align='left'   style='min-width: 100px;'>".$fecha_eval."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["NIVELESTUDIOS"]."</td>";
                      
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["DATOS_INSTITUCION"]."</td>";
					       echo"<td align='left'   style='min-width: 100px;'>".$registro["MPIO_STDIO"]."</td>";
					       echo"<td align='left'   style='min-width: 100px;'>".$registro["ENTI_STDIO"]."</td>";
					       echo"<td align='left'   style='min-width: 100px;'>".$registro["DEPEN_STDIO"]."</td>";
                      /*if($registro["C_EST_ORI"]==1)
                        $entregaestori="ORIGINAL";
                      else
                        $entregaestori="";
                      
                      if($registro["C_EST_COP"]==1)
                        $entregaestcop="COPIA";
                      else
                        $entregaestcop="";*/
                      $entregaestori="";
                      $entregaestcop="";
                      if($registro["DEJO_EST"]==1 && $registro["C_EST_ORI"]==1)
                        $entregaestori="ORIGINAL";
                      else
                        $entregaestcop="COPIA"; 
                                                
                      if($registro["ID_STDIO"]!= 7)
                        echo"<td align='left'   style='min-width: 100px;'>".$registro["DOC_STDIO"]." ".$entregaestori." ". $entregaestcop."</td>";
                      else
                        echo"<td align='left'   style='min-width: 100px;'>".$registro["OTRO_STDIO"]." ".$entregaestori." ". $entregaestcop."</td>";
                      if(empty($registro["FECHA_SOL_STDIO"]))
                        $fecha_est_sol="";
                      else
                        $fecha_est_sol=date("d/m/Y",strtotime($registro["FECHA_SOL_STDIO"]));
                      echo"<td align='left'   style='min-width: 100px;'>".$fecha_est_sol."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["NUM_SOL_STDIO"]."</td>";
                      if(empty($registro["FECHA_RESP_STDIO"]))
                        $fecha_est_res="";
                      else
                        $fecha_est_res=date("d/m/Y",strtotime($registro["FECHA_RESP_STDIO"]));
                      echo"<td align='left'   style='min-width: 100px;'>".$fecha_est_res."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["NUM_RESP_STDIO"]."</td>";
                      if(empty($registro["RES_OFI_STDIO"]))
                        echo"<td align='left'   style='min-width: 100px;'>".$registro["STDIO_RESUL"]."</td>";
                      else
                        echo"<td align='left'   style='min-width: 100px;'>".$registro["RES_OFI_STDIO"]."</td>";  
                      //echo"<td align='left'   style='min-width: 100px;'></td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["OBSERVA_STDIO"]."</td>";
                      //echo"<td align='left'   style='min-width: 100px;'>".$registro["MUNICIPIO"]."</td>";
                      
                      //echo"<td align='left'   style='min-width: 100px;'>".$registro["ESPECIALIDAD"]."</td>";
                      
                      //echo"<td align='left'   style='min-width: 100px;'>".$registro["AREA"]."</td>";
                      //echo"<td align='left'   style='min-width: 100px;'>".$registro["TIPO_EVAL"]."</td>";
                      //----------------------------------------------------------------------------------------
                      
                      /*if($registro["CAR_ORI"]==1)
                        $entregacarori="ORIGINAL";
                      else
                        $entregacarori="";
                      
                      if($registro["CAR_COP"]==1)
                        $entregacarcop="COPIA";
                      else
                        $entregacarcop="";*/
                      $entregacarori="";
                      $entregacarcop="";
                      if( $registro["DEJO_CAR"]==1 && $registro["CAR_ORI"]==1 )
                        $entregacarori="ORIGINAL";
                      else
                        $entregacarcop="COPIA"; 
                        
                      if($registro["ID_CAR"]!=6)
                        echo"<td align='left'   style='min-width: 100px;'>".$entregacarcop." ".$registro["DOC_CAR"]." ".$entregacarori."</td>";
                      else
                        echo"<td align='left'   style='min-width: 100px;'>".$entregacarcop." ".$registro["OTRO_CAR"]." ".$entregacarori."</td>";
                      echo"<td align='center'   style='min-width: 100px;'>".$registro["MAT_CARTILLA"]."</td>";
                      echo"<td align='center'   style='min-width: 100px;'>".$registro["CAR_CLASE"]."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["DEPEN_CAR"]."</td>";
                      //echo"<td align='left'   style='min-width: 100px;'>".$registro["MPIO_CAR"]."</td>";
                      //echo"<td align='left'   style='min-width: 100px;'>".$registro["ENTI_CAR"]."</td>";
                      if(empty($registro["FECHA_SOL_CAR"]))
                        $fecha_car_sol="";
                      else
                        $fecha_car_sol=date("d/m/Y",strtotime($registro["FECHA_SOL_CAR"]));
                      echo"<td align='left'   style='min-width: 100px;'>".$fecha_car_sol."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["NUM_SOL_CAR"]."</td>";
                      if(empty($registro["FECHA_RESP_CAR"]))
                        $fecha_car_res="";
                      else
                        $fecha_car_res=date("d/m/Y",strtotime($registro["FECHA_RESP_CAR"]));
                      echo"<td align='left'   style='min-width: 100px;'>".$fecha_car_res."</td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["NUM_RESP_CAR"]."</td>";
                      if(empty($registro["RES_OFI_CAR"]))
                        echo"<td align='left'   style='min-width: 100px;'>".$registro["CAR_RESUL"]."</td>";
					       else
                        echo"<td align='left'   style='min-width: 100px;'>".$registro["RES_OFI_CAR"]."</td>";
                      //echo"<td align='left'   style='min-width: 100px;'></td>";
                      echo"<td align='left'   style='min-width: 100px;'>".$registro["OBSERVA_CAR"]."</td>";
                      
                      
                   echo"</tr>"; 
                }
                $xTotal = count($Datos);
                if( $xTotal <= 0 ){
                   echo"<tr style='background: none;'>
                         <td colspan='35' align='left'>
                            <div style='font-family: sans-serif; font-weight: normal; font-size: 8pt; color: #ff0000;'>
                               No existen resultados para la b�squeda...
                            </div>                     
                         </td>
                      </tr>";
                }   
                ?>   
             </tbody>
          </table>
      </div>    
   </div>
   
   <input type="hidden" name="total_reg" id="xtotalReg" value="<?php echo $xTotal;?>" />   
   <input type="hidden" name="id_orden" id="xidOrd" value="<?php echo $idOrd;?>" />
   <input type="hidden" name="tp_orden" id="xtipoOrd" value="<?php echo $tipoOrd;?>" />   
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