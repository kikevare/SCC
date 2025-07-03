<?php
/* error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); */
session_start();
//-------------------------------------------------------------//
$xPath='';
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/evaluaciones.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xPersona = New Persona();

   //-------- Define el id del modulo y el perfil de acceso -------//
   $xInicio = 0;
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsxIdxMed     = $xPath."includes/js/evmed/xMedIndex.js?v=".rand();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title>SCC :: Men&uacute; principal</title>
    <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
    <!-- links css de actualizacion-->
    <?php $xSys->getLinks($xPath,1); ?>
    <!-- scripts js de actualizacion-->
    <?php $xSys->getScripts($xPath,1);  ?>
    <script type="text/javascript" src="<?php echo $jsxIdxMed;?>" />

    </script>

    <script type="text/javascript">
    var xHoldColor = "";
    var xHoldIdColor = "";

    $(document).ready(function() {
        xShowMenu();
        xGrid();
        xBusqueda();
        xCtrlIdEvalMed();
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>


    <style type="text/css">
    /* .styxBtnOpcion{width: 65px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;} */
    .styxBtnOpcion {
        width: 70px;
        font-size: 8pt;
        font-weight: normal;
        font-family: arial, helvetica, sans-serif;
        color: white;
        border-radius: 20px;
        background: #ebebea;
    }
    </style>

</head>

<body>
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
                <form name="fForm" id="fForm" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>"
                    enctype="application/x-www-form-urlencoded">
                    <br><br>
                    <?php
   //-- Muestra el titulo del modulo actual...
   if( isset($_GET["menu"]) ){
      $xInicio=1;
      $xSys->getNameMod($_GET["menu"]);
      $_SESSION["menu"] = $_GET["menu"];
   }
   else if( isset($_SESSION["menu"]) ){
      $xInicio=0;
      $xSys->getNameMod($_SESSION["menu"]);
   }

         //------------ Recepcion de par�metros de ordenaci�n y b�squeda ------------//
      //-- Inicializa los par�metros...
      $idOrd      = 2;
      $tipoOrd    = "Asc";
      $txtBusca   = "";
      $cmpBusca   = 1;
      //-- Revisa si se ha ejecutado una ordenaci�n...
      if( isset($_POST["id_orden"]) ){

         $idOrd   = $_POST["id_orden"];
         $tipoOrd = $_POST["tp_orden"];
         //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
         $_SESSION["id_orden"] = $idOrd;
         $_SESSION["tipo_orden"] = $tipoOrd;
      }
      //-- Revisa si se ha ejecutado una b�squeda...
      if( isset($_POST["txtBusca"]) && !empty($_POST["txtBusca"]) ){
         $cmpBusca = $_POST["cbCampo"];
         $txtBusca = $_POST["txtBusca"];
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_busca"] = $cmpBusca;
         $_SESSION["txt_busca"] = $txtBusca;
      }
      /*
      Si el m�dulo no ha sido invocado desde el men� principal,
      entonces revisa si existen datos en las variables de sesi�n
      de alguna b�squeda u ordenaci�n.
      */
      if( $xInicio == 0 ){
         if( $_SESSION["id_orden"] != "" )   $idOrd      = $_SESSION["id_orden"];
         if( $_SESSION["tipo_orden"] != "" ) $tipoOrd    = $_SESSION["tipo_orden"];
         if( $_SESSION["cmp_busca"] != "" )  $cmpBusca   = $_SESSION["cmp_busca"];
         if( $_SESSION["txt_busca"] != "" )  $txtBusca   = $_SESSION["txt_busca"];
         $xMsj = "&Uacute;ltima b&uacute;squeda realizada";
      }
      else{
         $_SESSION["id_orden"]   = "";
         $_SESSION["tipo_orden"] = "";
         $_SESSION["cmp_busca"]  = "";
         $_SESSION["txt_busca"]  = "";
         $xMsj = "";
      }
      //--------------------------------------------------------------------------//
   ?>
                    <!DOCTYPE html>
                    <html lang="en">

                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Document</title>
                    </head>
<style>
     @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
</style>
                    <body>
                        <section class="contenido">
                            <section class="menu">

                            </section>
                            <section class="resultados">
                                <?php if ( $xUsr->xCurpEval=='GOAS851006MGRMRN02'||$xUsr->xCurpEval=='FEGM880122MGRLRR12'||$xUsr->xCurpEval=='LOMJ900927HGRPRS07') {  ?>
                                 <div class="tarjeta_evpersonal">
                                    <div class="tarjeta_imagen">
                                    <img src="<?php echo $xPath;?>imgs/5097637.jpg">
                                    </div>
                                    <div class="tarjeta_descripcion">
                                    <p class="tarjeta_texto_descripcion">Estadisticas de Supervisor</p>
                                    <a href="estadisticas_supervisor.php" target="_parent"><button class="boton_descripcion" type="button">Ir</button></a>
                                    </div>
                                </div>
                                 <div class="tarjeta_evpersonal">
                                    <div class="tarjeta_imagen">
                                    <img src="<?php echo $xPath;?>imgs/3659193.jpg">
                                    </div>
                                    <div class="tarjeta_descripcion">
                                    <p class="tarjeta_texto_descripcion">Estadisticas Trimestrales </p>
                                    <button class="boton_descripcion"> Ir </button>
                                    </div>
                                </div>
                                <div class="tarjeta_evpersonal">
                                    <div class="tarjeta_imagen">
                                    <img src="<?php echo $xPath;?>imgs/3156627.jpg">
                                    </div>
                                    <div class="tarjeta_descripcion">
                                    <p class="tarjeta_texto_descripcion">Estadistica Mensual por Evaluador</p>
                                    <a href="estadisticas_mensualesev.php" target="_parent"> <button class="boton_descripcion" type="button">Ir</button></a>
                                    </div>
                                </div>
                                <div class="tarjeta_evpersonal">
                                    <div class="tarjeta_imagen">
                                    <img src="<?php echo $xPath;?>imgs/Statistics.jpg">
                                    </div>
                                    <div class="tarjeta_descripcion">
                                    <p class="tarjeta_texto_descripcion">Estadisticas Generales</p>
                                    <button class="boton_descripcion">Ir</button>
                                    </div>
                                </div>
                                <?php }else {  ?>
                                 <div class="tarjeta_evpersonal">
                                    <div class="tarjeta_imagen">
                                    <img src="<?php echo $xPath;?>imgs/5097637.jpg">
                                    </div>
                                    <div class="tarjeta_descripcion">
                                    <p class="tarjeta_texto_descripcion">Estadistica Personal</p>
                                    <a href="estadisticas_evaluadorper.php" target="_parent"><button class="boton_descripcion" type="button">Ir</button></a>
                                    </div>
                                </div>
                                <?php     } ?>
                            </section>

                        </section>
                    </body>

                    </html>
                    <style>
                     @keyframes bordes {
                     from 
                        {
                           border: solid 4px black;

                        }
                        20%
                        {
                           border-top: solid 4px #EC5656 ;
                        } 
                        40% 
                        {
                           border-right:solid 4px #EC5656;
                        }
                        60%
                        {
                           border-bottom:solid 4px #EC5656 ;
                        }
                        80%
                        {
                           border-left:solid 4px #EC5656 ;
                        }
                        100% 
                        {
                           border:solid 4px #EC5656 ;
                        }
                        
                     }
                     @keyframes aparecer {
                        from {
                           
                           transform: rotate3d(0,1,0, 360deg);
                        }
                        to 
                        {
                           
                        }
                     }
                     .boton_descripcion
                     {
                        width: 150px;
                        height: 30px;
                        border-radius: 10px;
                        background: white;
                        font-size: 15px;
                        font-family: Oswald;
                        border: none;
                        transition: 1s;
                     }
                     .boton_descripcion:hover
                     {
                        cursor: pointer;
                        background: #EC5656;
                        color: white;
                        transition: 1s;
                     }
                     .tarjeta_texto_descripcion 
                     {
                        font-size: 18px;
                        color: white;
                        font-family: Oswald;
                     }
                     .tarjeta_evpersonal 
                     {
                        width: 350px;
                        height: 320px;
                        border: solid 4px black;
                        border-radius: 20px;
                        margin-left: 10px;
                        margin-top: 120px;
                        display: inline-block;
                        transition: 1.2s;
                        background: white;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                        background: black;
                        overflow: hidden;
                        
                     }
                     .tarjeta_evpersonal:hover
                     {
                        transform: translateY(-20px);
                        transition: 1s;
                        cursor: pointer;
                        animation: bordes;
                        animation-duration: 8s;
                        animation-iteration-count: infinite;
                       /* box-shadow: -2px 10px 20px -6px rgb(76,190,240);*/
                     }
                     .tarjeta_descripcion 
                     {
                        width: 100%;
                        height: 82px;
                        border-bottom-left-radius: 20px;
                        border-bottom-right-radius: 20px;
                        

                     }
                     .tarjeta_imagen 
                     {
                        width: 100%;
                        height: 230px;
                        overflow: hidden;
                        
                     }
                     .tarjeta_imagen img 
                     {
                        width: 100%;
                        height: 100%;
                        border-top-left-radius: 20px;
                        border-top-right-radius: 20px;
                        transition: 1s;
                        
                     }
                     
                     .tarjeta_evpersonal:hover img 
                     {
                        -webkit-transform:scale(1.1);transform:scale(1.1);
                        transition: 1s;
                     }
                    .contenido {
                        width: 1890px;
                        height: 700px;
                        display: flex;
                    }

                    .menu {
                        width: 390px;
                        height: 100%;
                        border-radius: 5px;
                        border: solid 2px black;
                        background: url("<?php echo $xPath; ?>imgs/FONDO_POL.jpg");
                        background-size: 135%;
                        
                    }

                    .resultados {
                        width: 1600px;
                        height: 100%;
                        border-radius: 5px;
                        border: solid 2px black;
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);
                        grid-gap: 20px;
                    }
                    </style>
                    <?php
}
else
   header("Location: ".$xPath."exit.php");
?>