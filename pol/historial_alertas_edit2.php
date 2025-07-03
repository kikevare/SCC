<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/evaluaciones.class.php");
   include_once($xPath."includes/catalogos.class.php");
   include($xPath."includes/integracion.class.php");
   include_once($xPath."includes/psicologico.class.php");

   $xSys = New System();
   $xUsr = New Usuario();
   $xCat = New Catalog();

   //-------- Define el id del m�dulo y el perfil de acceso -------//
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsxResultados = $xPath."includes/js/integracion/xresultados.js?v=".rand();
}?>
<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Menu principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script src="alert/dist/sweetalert2.all.min.js"></script>
<script src="alert/dist/sweetalert2.min.js"></script>
<link rel="alert/dist/stylesheet" href="sweetalert2.min.css">
   <script language="javascript" src="<?php echo $jsxResultados;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xShowMenu();
         xCtrl();
      });
   </script>
 </head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
   <?php
   $xSys->getMenu();
   ?>
</td></tr>
<tr><td>
   <?php
   ?>
</td></tr>

<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <br><br>
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      //-- Muestra el nombre del m�dulo actual, tomando la sesI&Oacute;N...
      $xSys->getNameMod($_SESSION["menu"], "Historial de alertas.");
      //--------------------------------------------------------------------------//
      $user_perfil=$_GET["user"];

      //------------------------ Recepcion de par�metros -------------------------//
      
      $id=$_GET['id'];
      $dbname ="bdceecc";
$dbuser="root";
$dbhost="10.24.2.25";
$dbpass='4dminMy$ql$';
/*$dbuser = "root";
                    $dbhost = "localhost";
                    $dbpass = 'root';*/
       $conexion=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
       $sql = "select id_alerta, descripcion,curp_evaluador, fecha from tbnew_alertariesgo where id_evaluacion='".$id."' "; 
       $resultado=mysqli_query($conexion,$sql);
      ?>
     <p id="enca"> Se ha obtenido la(s) siguiente(s) alerta(s) de riesgo de la evaluaci&oacute;n seleccionada:</p>
     <section class="tab_enca">
     <div id="nom"><P id="encab"> DESCRIPCI&Oacute;N</P></div>
        <div id="ap"><P id="encab"> REALIZ&Oacute;</P></div>
        <div id="am"><P id="encab"> FECHA </P></div>
        <div id="cor"><P id="encab"> DEPARTAMENTO</P></div>
        </section>
      <?php  while ($filas=mysqli_fetch_assoc($resultado)) {?>
         <section class="tab_cont">
        <section class="alertas">
            <textarea name="desc" id="alert" cols="30" rows="10" readonly="readonly"><?php echo utf8_decode( $filas['descripcion']) ?> </textarea>
            <div id="rea"><p id="txt"><?php 
            if ("COSD770926HGRRNN19"==$filas['curp_evaluador']) {?>
                DAN MARTIN CORTEZ SANCHEZ.
           <?php }?>
           <?php 
            if ("RIGY871004MGRSRZ07"==$filas['curp_evaluador']) {?>
                YAZMIN ALICIA RIOS GARCIA
           <?php }?>
           <?php 
            if ("ROOR841127MGRMRF08"==$filas['curp_evaluador']) {?>
                MARIA DEL REFUGIO ROMAN ORGANISTA.
           <?php }?><?php 
            if ("SARR850928HGRLYC05"==$filas['curp_evaluador']) {?>
                RICARDO SALMERON REYNOSO.
           <?php }?><?php 
            if ("REAV760607MGRYRR06"==$filas['curp_evaluador']) {?>
                VERONICA REYNA ARAIZA.

           <?php }?><?php 
            if ("SOVL851226MGRLLS09"==$filas['curp_evaluador']) {?>
                LISBET SOLANO VALENTE.
           <?php }?><?php 
            if ("AEAI820916HDFNNS00"==$filas['curp_evaluador']) {?>
                ISAAC ANGEL ANGEL.
           <?php }?><?php 
            if ("AUFI820831HDFRLV01"==$filas['curp_evaluador']) {?>
                IVAN TADEO ARGUELLO FALCON.
           <?php }?><?php 
            if ("FEGM880122MGRLRR12"==$filas['curp_evaluador']) {?>
                MARICRUZ FELIX GARCIA.
           <?php }?><?php 
            if ("CAFN920808HMSSJL09"==$filas['curp_evaluador']) {?>
                NOELL CASTRO FAJARDO.
           <?php }?><?php 
            if ("MAAA870123HGRRVL06"==$filas['curp_evaluador']) {?>
                ALFONSO MARINO AVILA.
           <?php }?>
           <?php 
            if ("VAGE811102HGMGRL01"==$filas['curp_evaluador']) {?>
                ELIZABETH VAZQUEZ GERONIMO.
           <?php }?><?php 
            if ("GOAS851006MGRMRN02"==$filas['curp_evaluador']) {?>
                SANDRA LUZ GOMEZ ARROYO.
           <?php }?><?php 
            if ("LOMJ900927HGRPRS07"==$filas['curp_evaluador']) {?>
                JEISON LOPEZ MORALES.
           <?php }?><?php 
            if ("AECY820421MGRRSL09"==$filas['curp_evaluador']) {?>
                YULIANA PAULINA ARREOLA CASTRO.
           <?php }?><?php 
            if ("VAAG830703MDFZLL05"==$filas['curp_evaluador']) {?>
                GLORIA LIZBETH VAZQUEZ ALVAREZ.
           <?php }?><?php 
            if ("AANA850512MGRVBN04"==$filas['curp_evaluador']) {?>
                ANA LAURA ABARCA NAVA.
           <?php }?><?php 
            if ("JEAM890927MGRSNR02"==$filas['curp_evaluador']) {?>
                MARISELA DE JESUS ANTONIO.
           <?php }?><?php 
            if ("MAMA861016HCMRGR06"==$filas['curp_evaluador']) { 
                echo utf8_decode("ARTURO MARQUEZ MAGAÑA.") ?>    
           <?php }?><?php 
            if ("VEZF850419HNELLR09"==$filas['curp_evaluador']) {?>
                FRANCISCO GABRIEL VELAZQUEZ ZELAYA.
           <?php }?><?php 
            if ("PIAP860629HGRNBD05"==$filas['curp_evaluador']) {?>
                PEDRO PABLO PINEDA ABARCA.
           <?php }?><?php 
            if ("VELM821218MGRG2R02"==$filas['curp_evaluador']) {?>
                MIRIAM MAGALI VEGA LAZARO.
           <?php }?><?php 
            if ("BUCK860720MGRNRN04"==$filas['curp_evaluador']) {?>
                KENIA IRIS BUENO CRUZ.
           <?php }?><?php 
            if ("DOMJ860525HGRMRR02"==$filas['curp_evaluador']) {?>
               JORGE DOMINGUEZ MORALES.
           <?php }?><?php 
            if ("RAOL801104MGRMRZ04"==$filas['curp_evaluador']) {?>
                LIZETH RAMIREZ ORTEGA.
           <?php }?><?php 
            if ("AOGB800402MGRLTN00"==$filas['curp_evaluador']) {?>
                BENITA ALCOCER GATICA.
           <?php }?><?php 
            if ("MOMT830107MGRNNR05"==$filas['curp_evaluador']) {?>
                TRINIDAD MONICO MANZANO.
           <?php }?><?php 
            if ("CXGA871205HGRBRN06"==$filas['curp_evaluador']) {?>
                ANGEL DE JESUS CABRERA GARCIA.
           <?php }?><?php 
            if ("AUHE871116MMCSRR08"==$filas['curp_evaluador']) {?>
                ERIKA ASTUDILLO HERNANDEZ.
           <?php }?><?php 
            if ("CUCG830320MVZRRM07"==$filas['curp_evaluador']) {?>
                GEMIMA CRUZ CRECENCIO.
           <?php }?><?php 
            if ("SAAZ790410MGRNRL03"==$filas['curp_evaluador']) {?>
                ZULY ALEIDA SANTOS ARRIETA.
           <?php }?><?php 
            if ("CAPV890619HGRTRC08"==$filas['curp_evaluador']) {?>
                VICTOR MANUEL CATALAN PEREZ.
           <?php }?><?php 
            if ("FICN870725MGRRLL09"==$filas['curp_evaluador']) {?>
                NELIA FIERROS CELIS.
           <?php }?><?php 
            if ("EAHA891125MGRSRL03"==$filas['curp_evaluador']) {?>
                ALEXIS ESTRADA HERNANDEZ.
           <?php }?><?php 
            if ("GOAA820123HGRNRL05"==$filas['curp_evaluador']) {?>
                ALFONSO GONZALEZ ARRATIA.
           <?php }?><?php 
            if ("AAAE870517MGRBLS07"==$filas['curp_evaluador']) {?>
                ESMERALDA ABRAJAN ALONSO.
           <?php }?><?php 
            if ("TOGF690510HGRRRL07"==$filas['curp_evaluador']) {?>
                FLORENCIO TORRES GUERRERO.
           <?php }?><?php 
            if ("BAGK910624MGRTRR03"==$filas['curp_evaluador']) {?>
                KARINA BAUTISTA GARCIA.
           <?php }?><?php 
            if ("AOFJ801110HGRPGS08"==$filas['curp_evaluador']) {?>
                JESUS DAVID APONTE FIGUEROA.
           <?php }?><?php 
            if ("GAMS910706MGRRRN08"==$filas['curp_evaluador']) {?>
               SANDIBEL GARCIA MARCELO.
           <?php }?><?php 
            if ("VIAB870125MGRCVL07"==$filas['curp_evaluador']) {?>
                BLANCA ALICIA VICTORIA AVILA.
           <?php }?><?php 
            if ("MAFA880925MGRRLB01"==$filas['curp_evaluador']) {?>
                ABIMAEL MARTINEZ FLORES.
           <?php }?><?php 
            if ("FINL760226MGRSVD01"==$filas['curp_evaluador']) {?>
                LIDIA FISTECO NAVARRETE.
           <?php }?><?php 
            if ("PANE880217MGRBVR00"==$filas['curp_evaluador']) {?>
                ERIKA LIZETH PABLO NAVARRETE.
           <?php }?><?php 
            if ("COAC920901HGRCNH00"==$filas['curp_evaluador']) {?>
                CUAUHTEMOC COCTECON ANGEL.
           <?php }?><?php 
            if ("CURT761015MGRRZR02"==$filas['curp_evaluador']) {?>
                TERESA CRUZ RUIZ.
           <?php }?><?php 
            if ("BATM910905MMCRRG07"==$filas['curp_evaluador']) {?>
                MAGALY BARRIOS TORRES.
           <?php }?><?php 
            if ("AURN790731MGRGVL02"==$filas['curp_evaluador']) {?>
                NELIDA AGUILAR RIVERA.
           <?php }?><?php 
            if ("RESC910503MGRYLR04"==$filas['curp_evaluador']) {?>
                CRUZ MARIA REYES SALMERON.
           <?php }?><?php 
            if ("MAAI810923HGRRVD00"==$filas['curp_evaluador']) {?>
                IDAUL MARQUEZ AVILA.
           <?php }?><?php 
            if ("BAHB861219MGRRRR08"==$filas['curp_evaluador']) {?>
                BRENDA BRAVO HERNANDEZ.
           <?php }?><?php 
            if ("OEPR870808HGRRTB04"==$filas['curp_evaluador']) {?>
                JOSE ROBERTO ORBE PATRICIO.
           <?php }?><?php 
            if ("IAAM841106MGRCDR03"==$filas['curp_evaluador']) {?>
                MARIAN CONCEPCION ICAZBALCETA ADAME.
           <?php }?><?php 
            if ("BUBA971224MGRNSR01"==$filas['curp_evaluador']) {?>
                ARACELI BUENAVENTURA BASILIO.
           <?php }?><?php 
            if ("AALA860424MOCPNG01"==$filas['curp_evaluador']) {?>
                MARIA AGUSTINA APARICIO LEON.
           <?php }?><?php 
            if ("SANA711222MGRNRN05"==$filas['curp_evaluador']) {?>
                ANGELICA SANTIAGO NERI.
           <?php }?><?php 
            if ("HEHE880204MGRRRV06"==$filas['curp_evaluador']) {?>
                EVANGELINA HERNANDEZ HERRERA.
           <?php }?><?php 
            if ("ROCA950119MGRSVT07"==$filas['curp_evaluador']) {?>
                ATZINI PAOLA ROSALES COVARRUBIAS.
           <?php }?><?php 
            if ("CAHX850121MMGHRT02"==$filas['curp_evaluador']) {?>
                XITLALY CHAVEZ HEREDIA.
           <?php }?><?php 
            if ("GABF890321HGRRTR00"==$filas['curp_evaluador']) {?>
                FRANCISCO JAVIER GARCIA BAUTISTA.
           <?php }?><?php 
            if ("RACK931128MGRMRR02"==$filas['curp_evaluador']) {?>
                KARLA DENISSE RAMOS DE LA CRUZ.
           <?php }?><?php 
            if ("MOPB870611MGRRCR02"==$filas['curp_evaluador']) {?>
                BERENICE MORALES PACHECO.
           <?php }?><?php 
            if ("LABE881021MGRRRL08"==$filas['curp_evaluador']) {?>
                ELEDI LAURO BERNAL.
           <?php }?>
           <?php 
            if ("GUJS851113MOCTRN05"==$filas['curp_evaluador']) {?>
                SANDRA ESMERALDA GUTIERREZ JUAREZ.
           <?php }?>
         </p></div>
            <div id="fec"><p id="txt"><?php echo $filas['fecha'] ?></p></div>
            <?php
            if ("COSD770926HGRRNN19"==$filas['curp_evaluador']|| "RIGY871004MGRSRZ07"==$filas['curp_evaluador']|| "ROOR841127MGRMRF08"==$filas['curp_evaluador']|| "SARR850928HGRLYC05"==$filas['curp_evaluador']|| "MAAV890507MGRRLR03"==$filas['curp_evaluador']|| "SOVL851226MGRLLS09"==$filas['curp_evaluador']) {
                ?>
                <div id="dep"><p id="txt">INTEGRACION DE RESULTADOS.</p></div>
            <?php } ?>
            <?php
            if ("VAGE811102HGMGRL01"==$filas['curp_evaluador']|| "AEAI820916HDFNNS00"==$filas['curp_evaluador']|| "AUFI820831HDFRLV01"==$filas['curp_evaluador']|| "FEGM880122MGRLRR12"==$filas['curp_evaluador']|| "CAFN920808HMSSJL09"==$filas['curp_evaluador']|| "MAAA870123HGRRVL06"==$filas['curp_evaluador']|| "GOAS851006MGRMRN02"==$filas['curp_evaluador']|| "LOMJ900927HGRPRS07"==$filas['curp_evaluador']|| "AECY820421MGRRSL09"==$filas['curp_evaluador']|| "VAAG830703MDFZLL05"==$filas['curp_evaluador']|| "AANA850512MGRVBN04"==$filas['curp_evaluador']|| "JEAM890927MGRSNR02"==$filas['curp_evaluador']|| "MAMA861016HCMRGR06"==$filas['curp_evaluador']|| "VEZF850419HNELLR09"==$filas['curp_evaluador']|| "GUJS851113MOCTRN05"==$filas['curp_evaluador']) 
            {
                ?>
                <div id="dep"><p id="txt">POLIGRAFIA.</p></div>
            <?php } ?>
            <?php
            if ("PIAP860629HGRNBD05"==$filas['curp_evaluador']|| "VELM821218MGRG2R02"==$filas['curp_evaluador']|| "BUCK860720MGRNRN04"==$filas['curp_evaluador']|| "DOMJ860525HGRMRR02"==$filas['curp_evaluador']|| "RAOL801104MGRMRZ04"==$filas['curp_evaluador']|| "AOGB800402MGRLTN00"==$filas['curp_evaluador']|| "MOMT830107MGRNNR05"==$filas['curp_evaluador']|| "CXGA871205HGRBRN06"==$filas['curp_evaluador']) 
            {
                ?>
                <div id="dep"><p id="txt">QUIMICO.</p></div>
            <?php } ?>
            <?php
            if ("AUHE871116MMCSRR08"==$filas['curp_evaluador']|| "CUCG830320MVZRRM07"==$filas['curp_evaluador']|| "SAAZ790410MGRNRL03"==$filas['curp_evaluador']|| "CAPV890619HGRTRC08"==$filas['curp_evaluador']|| "CAMR821124MGRRLY18"==$filas['curp_evaluador']) 
            {
                ?>
                <div id="dep"><p id="txt">MEDICO.</p></div>
            <?php } ?>
            <?php
            if ("FICN870725MGRRLL09"==$filas['curp_evaluador']|| "EAHA891125MGRSRL03"==$filas['curp_evaluador']|| "GOAA820123HGRNRL05"==$filas['curp_evaluador']|| "AAAE870517MGRBLS07"==$filas['curp_evaluador']|| "TOGF690510HGRRRL07"==$filas['curp_evaluador']|| "BAGK910624MGRTRR03"==$filas['curp_evaluador']|| "AOFJ801110HGRPGS08"==$filas['curp_evaluador']|| "GAMS910706MGRRRN08"==$filas['curp_evaluador']|| "VIAB870125MGRCVL07"==$filas['curp_evaluador']|| "MAFA880925MGRRLB01"==$filas['curp_evaluador']|| "FINL760226MGRSVD01"==$filas['curp_evaluador']|| "PANE880217MGRBVR00"==$filas['curp_evaluador']|| "COAC920901HGRCNH00"==$filas['curp_evaluador']|| "CURT761015MGRRZR02"==$filas['curp_evaluador']
            || "BATM910905MMCRRG07"==$filas['curp_evaluador']|| "AURN790731MGRGVL02"==$filas['curp_evaluador']|| "RESC910503MGRYLR04"==$filas['curp_evaluador']|| "MAAI810923HGRRVD00"==$filas['curp_evaluador']) 
            {
                ?>
                <div id="dep"><p id="txt">ENTORNO SOCIAL.</p></div>
            <?php } ?>
            <?php
            if ("BAHB861219MGRRRR08"==$filas['curp_evaluador']|| "OEPR870808HGRRTB04"==$filas['curp_evaluador']|| "IAAM841106MGRCDR03"==$filas['curp_evaluador']|| "BUBA971224MGRNSR01"==$filas['curp_evaluador']|| "AALA860424MOCPNG01"==$filas['curp_evaluador']|| "SANA711222MGRNRN05"==$filas['curp_evaluador']|| "HEHE880204MGRRRV06"==$filas['curp_evaluador']|| "ROCA950119MGRSVT07"==$filas['curp_evaluador']|| "CAHX850121MMGHRT02"==$filas['curp_evaluador']|| "GABF890321HGRRTR00"==$filas['curp_evaluador']|| "RACK931128MGRMRR02"==$filas['curp_evaluador']|| "MOPB870611MGRRCR02"==$filas['curp_evaluador']|| "LABE881021MGRRRL08"==$filas['curp_evaluador']) 
            {
                ?>
                <div id="dep"><p id="txt">PSICOLOGIA.</p></div>
            <?php } ?>
            
            
        </section></section>
        <?php
      }
      ?>
      <section class="boton">
      <a id="reg" href="historial_alertas2.php"><div id="regresar"><p id="regr"> Regresar</p></div></a></section>
      <style>
    #encab 
    {
        font-weight: bold;
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        margin-top: 5px;
        margin-left: 5px;
    }
    #txt 
    {
        font-weight: bold;
        font-size: 13px;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        margin-top: 15px;
        margin-left: 5px;
        margin-top: 8%;
    }
.tab_enca
    {
        display: flex;
        width: 100%;
        height: auto;
        border: solid 2px black;
        font-weight: bold;
        font: ROBOTO;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        color: white;
        align-items: center;
        font-size: 15px;
    }
#nom 
    {
        width: 25%;
        height: 40px;
        border-right: solid 0.5px black;
        background: rgb(65, 98, 126);
    }
    #ap 
    {
        width: 25%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #am 
    {
        width: 25%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #cor 
    {
        width: 25%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #ev 
    {
        width: 20%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
          .tab_cont 
    {
        display: block;
        width: 100%;
        height: 100%;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        
    }
         #enca 
        {
            font-weight: bold;
        }
         .boton 
         {
            width: 100px;
            height: 50px;
            margin-top: 20px;
         }
         #regr 
        {
            margin-top: 12px;
        }
         #regresar 
        {
            width: 100px;
            height: 50px;
            border: solid 2px red;
            text-decoration: none;
            background: white;
            border-radius: 10%;
            margin-top: 20px;
            margin-left: 10px;
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        }
        #regresar:hover
        {
            cursor: pointer;
            color: white;
            background: red;
            border: solid 2px white;
        }
        #reg {
            color: black;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            width: 100px;
            height: 50px;
            
            
        }
        #reg:hover
        {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
          .alertas
          {
              width: 100%;
              height: 100px;
              border: solid 0.5px black;
              display: flex;
              font-weight: bold;
              
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
            
            background: white;
              
          }
          #alert {
              width: 25%;
              height: 100px;
              border-right: solid 0.5px black;
              text-align: start;
              background: white;
              font-size: 13px;
              font-family: Arial, Helvetica, sans-serif;
              
          }
          #rea 
          {
            width: 25%;
            height: 100px;
              border-right: solid 0.5px black;
          }
          #fec 
          {
            width: 25%;
            height: 100px;
            border-right: solid 0.5px black;
          }
          #dep 
          {
            width: 25%;
            height: 100px;
            border-right: solid 0.5px black;
          }
          #ed 
          {
            width: 20%;
            height: 100px;
            border-right: solid 0.5px black;
          }
      </style>