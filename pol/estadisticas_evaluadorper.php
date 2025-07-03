<?php
/* error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); */
session_start();
//-------------------------------------------------------------//
$xPath = '';
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for ($i = 0; $i < $xLEVEL; $i++)  $xPath .= "../";
//-------------------------------------------------------------//
if (isset($_SESSION["admitted_xsice"])) {
    include_once($xPath . "includes/xsystem.php");
    include_once($xPath . "includes/persona.class.php");
    include_once($xPath . "includes/evaluaciones.class.php");
    $xSys = new System();
    $xUsr = new Usuario();
    $xPersona = new Persona();

    //-------- Define el id del modulo y el perfil de acceso -------//
    $xInicio = 0;
    if (isset($_GET["menu"])) {
        $_SESSION["menu"] = $_GET["menu"];
        $xInicio = 1;
    }
    if ($xUsr->xPerfil == 0)  $xUsr->getPerfil($_SESSION["menu"]);
    //--------------------------------------------------------------//
    //-- Define los directorios de scripts js y css...
    $cssPlantilla  = $xPath . "includes/xplantilla/sty_plantilla.css";
    $jsxIdxMed     = $xPath . "includes/js/evmed/xMedIndex.js?v=" . rand();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
        <title>SCC :: Men&uacute; principal</title>
        <link href="<?php echo $cssPlantilla; ?>" rel="stylesheet" type="text/css" />
        <!-- links css de actualizacion-->
        <?php $xSys->getLinks($xPath, 1); ?>
        <!-- scripts js de actualizacion-->
        <?php $xSys->getScripts($xPath, 1);  ?>
        <script type="text/javascript" src="<?php echo $jsxIdxMed; ?>" />

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

            .loader_bg {
                position: fixed;
                z-index: 9999999;
                background: #fff;
                width: 100%;
                height: 100%;
            }

            .loader {
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 10;
                width: 160px;
                height: 100px;
                margin-left: -80px;
                margin-top: -50px;
                border-radius: 5px;
                background: #1e3f57;
                animation: dot1_ 3s cubic-bezier(0.55, 0.3, 0.24, 0.99) infinite;
            }

            .loader:nth-child(2) {
                z-index: 11;
                width: 150px;
                height: 90px;
                margin-top: -45px;
                margin-left: -75px;
                border-radius: 3px;
                background: #3c517d;
                animation-name: dot2_;
            }

            .loader:nth-child(3) {
                z-index: 12;
                width: 40px;
                height: 20px;
                margin-top: 50px;
                margin-left: -20px;
                border-radius: 0 0 5px 5px;
                background: #6bb2cd;
                animation-name: dot3_;
            }

            @keyframes dot1_ {

                3%,
                97% {
                    width: 160px;
                    height: 100px;
                    margin-top: -50px;
                    margin-left: -80px;
                }

                30%,
                36% {
                    width: 80px;
                    height: 120px;
                    margin-top: -60px;
                    margin-left: -40px;
                }

                63%,
                69% {
                    width: 40px;
                    height: 80px;
                    margin-top: -40px;
                    margin-left: -20px;
                }
            }

            @keyframes dot2_ {

                3%,
                97% {
                    height: 90px;
                    width: 150px;
                    margin-left: -75px;
                    margin-top: -45px;
                }

                30%,
                36% {
                    width: 70px;
                    height: 96px;
                    margin-left: -35px;
                    margin-top: -48px;
                }

                63%,
                69% {
                    width: 32px;
                    height: 60px;
                    margin-left: -16px;
                    margin-top: -30px;
                }
            }

            @keyframes dot3_ {

                3%,
                97% {
                    height: 20px;
                    width: 40px;
                    margin-left: -20px;
                    margin-top: 50px;
                }

                30%,
                36% {
                    width: 8px;
                    height: 8px;
                    margin-left: -5px;
                    margin-top: 49px;
                    border-radius: 8px;
                }

                63%,
                69% {
                    width: 16px;
                    height: 4px;
                    margin-left: -8px;
                    margin-top: -37px;
                    border-radius: 10px;
                }
            }
        </style>

    </head>

    <body onload="loaded();">
        <div class="loader_bg">
            <div class="loader"></div>
            <div class="loader"></div>
            <div class="loader"></div>
        </div>
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
                        if (isset($_GET["menu"])) {
                            $xInicio = 1;
                            $xSys->getNameMod($_GET["menu"]);
                            $_SESSION["menu"] = $_GET["menu"];
                        } else if (isset($_SESSION["menu"])) {
                            $xInicio = 0;
                            $xSys->getNameMod($_SESSION["menu"]);
                        }

                        //------------ Recepcion de par�metros de ordenaci�n y b�squeda ------------//
                        //-- Inicializa los par�metros...
                        $idOrd      = 2;
                        $tipoOrd    = "Asc";
                        $txtBusca   = "";
                        $cmpBusca   = 1;
                        //-- Revisa si se ha ejecutado una ordenaci�n...
                        if (isset($_POST["id_orden"])) {

                            $idOrd   = $_POST["id_orden"];
                            $tipoOrd = $_POST["tp_orden"];
                            //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
                            $_SESSION["id_orden"] = $idOrd;
                            $_SESSION["tipo_orden"] = $tipoOrd;
                        }
                        //-- Revisa si se ha ejecutado una b�squeda...
                        if (isset($_POST["txtBusca"]) && !empty($_POST["txtBusca"])) {
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
                        if ($xInicio == 0) {
                            if ($_SESSION["id_orden"] != "")   $idOrd      = $_SESSION["id_orden"];
                            if ($_SESSION["tipo_orden"] != "") $tipoOrd    = $_SESSION["tipo_orden"];
                            if ($_SESSION["cmp_busca"] != "")  $cmpBusca   = $_SESSION["cmp_busca"];
                            if ($_SESSION["txt_busca"] != "")  $txtBusca   = $_SESSION["txt_busca"];
                            $xMsj = "&Uacute;ltima b&uacute;squeda realizada";
                        } else {
                            $_SESSION["id_orden"]   = "";
                            $_SESSION["tipo_orden"] = "";
                            $_SESSION["cmp_busca"]  = "";
                            $_SESSION["txt_busca"]  = "";
                            $xMsj = "";
                        }
                        //--------------------------------------------------------------------------//
                        $dbname = "bdceecc";
                        $dbuser = "root";
                        $dbhost = "10.24.2.25";
                        $dbpass = '4dminMy$ql$';
                        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                        $hoy = date('d/m/Y');
                        $anio = date('Y');
                        
    function obtener_datos_comp ($conexion,$c,$fecha1,$fecha2)
      {
         $sql = "SELECT id_evaluacion, curp_evaluado,fecha_aplicacion,curp_supervisor,id_resultado from poligrafia_evnu where curp_evaluador='$c' and fecha_aplicacion>='$fecha1' and fecha_aplicacion<='$fecha2'";
         $resultado = mysqli_query($conexion,$sql);
         
         while ($fila = mysqli_fetch_assoc($resultado))
         {
         $id_evaluacion = $fila['id_evaluacion'];
         $curp_evaluado = $fila['curp_evaluado'];
         $fecha_aplicacion = $fila['fecha_aplicacion'];
         $resultado_id = $fila['id_resultado'];
         $curp_supervisor = $fila['curp_supervisor'];
         $sql_sup = "SELECT nombre, a_paterno, a_materno FROM tbdatospersonales where curp = '$curp_supervisor'";
         $resultadosup = mysqli_query($conexion, $sql_sup);
         $filasup = mysqli_fetch_assoc($resultadosup);
         $supervisor = $filasup['a_paterno']." ".$filasup['a_materno']." ".$filasup['nombre'];
         $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion from tbprog_preliminar where xcurp='".$curp_evaluado."' order by id_prog_preliminar desc";
         $resultador = mysqli_query($conexion, $sqlr);
         $filar = mysqli_fetch_assoc($resultador);
         $nombre = $filar['nombre'];
         $apellidos = $filar['a_paterno']." ".$filar['a_materno'];
         $id_tip = $filar['id_tipo_eval'];
         $id_corpo = $filar['id_corporacion'];
         $newDate = date("d/m/Y", strtotime($fecha_aplicacion));
         $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
            $resultadocorp = mysqli_query($conexion, $sql2);
            $filacorp = mysqli_fetch_assoc($resultadocorp);
            $corporacion = $filacorp['corporacion'];
            $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
            $resultadoev = mysqli_query($conexion, $sql3);
            $filatip = mysqli_fetch_assoc($resultadoev);
            $tipoe = $filatip['tipo_eval']; ?>
            <section class="resultados_tabla__fila">
            <div class="tabla_fila1"><?php echo $apellidos ?></div>
            <div class="tabla_fila1"><?php echo $nombre ?></div>
            <div class="tabla_fila1"><?php echo $newDate ?></div>
            <div class="tabla_fila1"><?php echo $curp_evaluado ?></div>
            <div class="tabla_fila1"><?php echo $tipoe ?></div>
            <div class="tabla_fila1"><?php echo $supervisor ?></div>
            <div class="tabla_fila1"><?php echo $resultado_id ?></div>
            </section>
      <?php   }


      }
   ?>
                        <!DOCTYPE html>
                        <html lang="en">

                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Document</title>

                        </head>
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Economica:ital,wght@0,400;0,700;1,400;1,700&display=swap');
                        </style>
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Cookie&family=Markazi+Text:wght@400..700&display=swap');
                        </style>
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');

                            .economica-regular {
                                font-family: "Economica", serif;
                                font-weight: 400;
                                font-style: normal;
                            }

                            .economica-bold {
                                font-family: "Economica", serif;
                                font-weight: 700;
                                font-style: normal;
                            }

                            .economica-regular-italic {
                                font-family: "Economica", serif;
                                font-weight: 400;
                                font-style: italic;
                            }

                            .economica-bold-italic {
                                font-family: "Economica", serif;
                                font-weight: 700;
                                font-style: italic;
                            }

                            img {
                                image-rendering: optimizeQuality;
                            }

                            .carga {
                                width: 20%;
                                height: 20%;
                                image-rendering: optimizeQuality;
                                border-radius: 10px;
                            }
                        </style>
                        <script>
                            function loaded() {
                                "use strict";

                                setTimeout(function() {
                                    $('.loader_bg').fadeToggle();
                                }, 1500);

                            }
                        </script>

                        <body>



                            <section class="contenido">
                                <section class="menu">

                                </section>
                                <section class="resultados">
                                    <section class="slider-item1" id="slider-item1">


                                        <div class="resultados_membrete">
                                            <div class="resultados_imagen__izquierda__membrete"><img
                                                    src="<?php echo $xPath; ?>imgs/logo2.jpg" alt="" class="imagen__izquierda">
                                            </div>
                                            <div class="resultados_texto__membrete">
                                                <p class="membrete__texto__titulos">SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL
                                                    DE SEGURIDAD PUBLICA </p>
                                                <p class="membrete__texto__titulos">CENTRO ESTATAL DE EVALUACION Y CONTROL DE
                                                    CONFIANZA</p>
                                            </div>
                                            <div class="resultados_imagen__derecha__membrete"><img
                                                    src="<?php echo $xPath; ?>imgs/logo1.jpg" alt="" class="imagen__derecha">
                                            </div>
                                        </div>
                                        <div class="resultados_inicio">
                                            <div class="resultados_inicio__tx">
                                                <p class="inicio__tx1">A QUIEN CORRESPONDA:</p>
                                                <p class="inicio__tx2">SUPERVISION Y JEFATURA</p>
                                            </div>
                                            <div class="resultados_inicio__vacio"></div>
                                            <div class="resultados_inicio__tx2">
                                                <p class="inicio__txt">FECHA:<?php echo " " . $hoy ?></p>
                                                <p class="inicio__txt2">PERIODO: ENERO</p>
                                            </div>
                                        </div>
                                        <section class="resultados_tabla__encabezados">
                                            <div class="tabla_encabezado1">
                                                <p>APELLIDOS</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>NOMBRE(s)</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>FECHA DE EVALUACION</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>CURP</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>TIPO DE EVALUACION</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>SUPERVISOR</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>RESULTADO</p>
                                            </div>
                                        </section>
                                        
                                        
                                        <?php obtener_datos_comp($conexion,$xUsr->xCurpEval,"2025/01/01","2025/01/31") ?>
                                        

                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                    
                                        <section class="secbotones">
                                        <a href="#slider-item2"><button class="button" type="button">
                                                <span class="label">Siguiente</span>
                                                <span class="icon">
                                                <img src="<?php echo $xPath; ?>imgs/siguiente-boton.png" alt="">
                                                </span>
                                            </button> </a><br><br>
                                        <a href="#" style="width: 300px;">
                                            <button class="container-btn-file" type="button">
                                                <svg
                                                    fill="#fff"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="20"
                                                    height="20"
                                                    viewBox="0 0 50 50">
                                                    <path
                                                        d="M28.8125 .03125L.8125 5.34375C.339844 
    5.433594 0 5.863281 0 6.34375L0 43.65625C0 
    44.136719 .339844 44.566406 .8125 44.65625L28.8125 
    49.96875C28.875 49.980469 28.9375 50 29 50C29.230469 
    50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844 
    30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625 
    .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32 
    6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34 
    29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49 
    43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44 
    13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938 
    21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219 
    22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375 
    15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125 
    28.28125C15.160156 28.054688 15.035156 27.636719 14.90625 
    27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719 
    14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36 
    20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z"></path>
                                                </svg>
                                                Descargar Excel
                                                
                                            </button>

                                        </a></section>
                                    </section>

                                    <section class="slider-item2" id="slider-item2">
                                    <div class="resultados_membrete">
                                            <div class="resultados_imagen__izquierda__membrete"><img
                                                    src="<?php echo $xPath; ?>imgs/logo2.jpg" alt="" class="imagen__izquierda">
                                            </div>
                                            <div class="resultados_texto__membrete">
                                                <p class="membrete__texto__titulos">SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL
                                                    DE SEGURIDAD PUBLICA </p>
                                                <p class="membrete__texto__titulos">CENTRO ESTATAL DE EVALUACION Y CONTROL DE
                                                    CONFIANZA</p>
                                            </div>
                                            <div class="resultados_imagen__derecha__membrete"><img
                                                    src="<?php echo $xPath; ?>imgs/logo1.jpg" alt="" class="imagen__derecha">
                                            </div>
                                        </div>
                                        <div class="resultados_inicio">
                                            <div class="resultados_inicio__tx">
                                                <p class="inicio__tx1">A QUIEN CORRESPONDA:</p>
                                                <p class="inicio__tx2">SUPERVISION Y JEFATURA</p>
                                            </div>
                                            <div class="resultados_inicio__vacio"></div>
                                            <div class="resultados_inicio__tx2">
                                                <p class="inicio__txt">FECHA:<?php echo " " . $hoy ?></p>
                                                <p class="inicio__txt2">PERIODO: FEBRERO</p>
                                            </div>
                                        </div>
                                        <section class="resultados_tabla__encabezados">
                                            <div class="tabla_encabezado1">
                                                <p>APELLIDOS</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>NOMBRE(s)</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>FECHA DE EVALUACION</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>CURP</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>TIPO DE EVALUACION</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>SUPERVISOR</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>RESULTADO</p>
                                            </div>
                                        </section>
                                        <?php obtener_datos_comp($conexion,$xUsr->xCurpEval,"2025/02/01","2025/02/31") ?>
                                        
                                        <section class="secbot">
                                        <a href="#slider-item1"><button class="button2" type="button">
                                                <span class="label">Anterior</span>
                                                <span class="icon">
                                                    <img src="<?php echo $xPath; ?>imgs/hacia-atras.png" alt="">
                                                </span>
                                            </button> </a><br><br>
                                        <a href="#slider-item3"><button class="button" type="button">
                                                <span class="label">Siguiente</span>
                                                <span class="icon">
                                                <img src="<?php echo $xPath; ?>imgs/siguiente-boton.png" alt="">
                                                </span>
                                            </button> </a><br><br>
                                        <a href="#" style="width: 300px;">
                                            <button class="container-btn-file" type="button">
                                                <svg
                                                    fill="#fff"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="20"
                                                    height="20"
                                                    viewBox="0 0 50 50">
                                                    <path
                                                        d="M28.8125 .03125L.8125 5.34375C.339844 
    5.433594 0 5.863281 0 6.34375L0 43.65625C0 
    44.136719 .339844 44.566406 .8125 44.65625L28.8125 
    49.96875C28.875 49.980469 28.9375 50 29 50C29.230469 
    50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844 
    30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625 
    .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32 
    6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34 
    29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49 
    43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44 
    13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938 
    21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219 
    22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375 
    15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125 
    28.28125C15.160156 28.054688 15.035156 27.636719 14.90625 
    27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719 
    14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36 
    20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z"></path>
                                                </svg>
                                                Descargar Excel
                                                
                                            </button>

                                        </a>
</section>

                                    </section>


                                    <section class="slider-item2" id="slider-item3">


                                        <div class="resultados_membrete">
                                            <div class="resultados_imagen__izquierda__membrete"><img
                                                    src="<?php echo $xPath; ?>imgs/logo2.jpg" alt="" class="imagen__izquierda">
                                            </div>
                                            <div class="resultados_texto__membrete">
                                                <p class="membrete__texto__titulos">SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL
                                                    DE SEGURIDAD PUBLICA </p>
                                                <p class="membrete__texto__titulos">CENTRO ESTATAL DE EVALUACION Y CONTROL DE
                                                    CONFIANZA</p>
                                            </div>
                                            <div class="resultados_imagen__derecha__membrete"><img
                                                    src="<?php echo $xPath; ?>imgs/logo1.jpg" alt="" class="imagen__derecha">
                                            </div>
                                        </div>
                                        <div class="resultados_inicio">
                                            <div class="resultados_inicio__tx">
                                                <p class="inicio__tx1">A QUIEN CORRESPONDA:</p>
                                                <p class="inicio__tx2">SUPERVISION Y CONTROL DE CALIDAD</p>
                                            </div>
                                            <div class="resultados_inicio__vacio"></div>
                                            <div class="resultados_inicio__tx2">
                                                <p class="inicio__txt">FECHA:<?php echo " " . $hoy ?></p>
                                                <p class="inicio__txt2">PERIODO: MARZO</p>
                                            </div>
                                        </div>
                                        <section class="resultados_tabla__encabezados">
                                            <div class="tabla_encabezado1">
                                                <p>APELLIDOS</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>NOMBRE(s)</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>FECHA DE EVALUACION</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>CURP</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>TIPO DE EVALUACION</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>SUPERVISOR</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>RESULTADO</p>
                                            </div>
                                        </section>
                                        <?php obtener_datos_comp($conexion,$xUsr->xCurpEval,"2025/03/01","2025/03/31") ?>
                                        
                                        <section class="secbot">
                                        <a href="#slider-item2"><button class="button2" type="button">
                                                <span class="label">Anterior</span>
                                                <span class="icon">
                                                    <img src="<?php echo $xPath; ?>imgs/hacia-atras.png" alt="">
                                                </span>
                                            </button> </a><br><br>
                                        <a href="#slider-item1"><button class="button" type="button">
                                                <span class="label">Siguiente</span>
                                                <span class="icon">
                                                <img src="<?php echo $xPath; ?>imgs/siguiente-boton.png" alt="">
                                                </span>
                                            </button> </a><br><br>
                                        <a href="#" style="width: 300px;">
                                            <button class="container-btn-file" type="button">
                                                <svg
                                                    fill="#fff"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="20"
                                                    height="20"
                                                    viewBox="0 0 50 50">
                                                    <path
                                                        d="M28.8125 .03125L.8125 5.34375C.339844 
    5.433594 0 5.863281 0 6.34375L0 43.65625C0 
    44.136719 .339844 44.566406 .8125 44.65625L28.8125 
    49.96875C28.875 49.980469 28.9375 50 29 50C29.230469 
    50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844 
    30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625 
    .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32 
    6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34 
    29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49 
    43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44 
    13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938 
    21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219 
    22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375 
    15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125 
    28.28125C15.160156 28.054688 15.035156 27.636719 14.90625 
    27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719 
    14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36 
    20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z"></path>
                                                </svg>
                                                
                                                Descargar Excel
                                                
                                            </button>

                                        </a>
</section>

                                    </section>
                                </section>
                            </section>


                        </body>

                        </html>
                        <style>
                            .secbot 
                            {
                            margin-top: 30px;
                              width: 35%;
                              height: 70px;
                              display: flex;  
                            }
                            .secbotones 
                            {
                                margin-top: 30px;
                              width: 25%;
                              height: 70px;
                              display: flex;
                            }
                            .container-btn-file {
                                display: flex;
                                position: relative;
                                justify-content: center;
                                align-items: center;
                                background-color: #307750;
                                color: #fff;
                                border-style: none;
                                padding: 1em 2em;
                                border-radius: 0.5em;
                                overflow: hidden;
                                z-index: 1;
                                box-shadow: 4px 8px 10px -3px rgba(0, 0, 0, 0.356);
                                transition: all 250ms;
                            }

                            

                            .container-btn-file>svg {
                                margin-right: 1em;
                            }

                            .container-btn-file::before {
                                content: "";
                                position: absolute;
                                height: 100%;
                                width: 0;
                                border-radius: 0.5em;
                                background-color: #469b61;
                                z-index: -1;
                                transition: all 350ms;
                            }

                            .container-btn-file:hover::before {
                                width: 100%;
                            }

                            .button {
                                position: relative;
                                font-size: 12px;
                                font-family: oswald;
                                letter-spacing: 2px;
                                height: 45px;
                                padding: 0 3em;
                                border: none;
                                background-color: #3c517d;
                                color: #fff;
                                text-transform: uppercase;
                                overflow: hidden;
                                border-radius: 5px;

                            }

                            .button::before {
                                content: '';
                                display: block;
                                position: absolute;
                                z-index: 0;
                                bottom: 0;
                                left: 0;
                                height: 0px;
                                width: 100%;
                                background: rgb(63, 120, 241);
                                background: linear-gradient(90deg, rgb(33, 118, 228) 20%, rgb(36, 119, 226) 100%);
                                transition: 0.2s;
                            }

                            .button .label {
                                position: relative;
                            }

                            .button .icon {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                height: 4em;
                                width: 4em;
                                position: absolute;
                                top: 4em;
                                right: 0;
                                opacity: 0;
                                transition: 0.4s;
                            }

                            .button:hover::before {
                                height: 100%;
                            }

                            .button:hover .icon {
                                top: 0;
                                opacity: 1;
                            }

                            .button2 {
                                position: relative;
                                font-size: 12px;
                                font-family: oswald;
                                letter-spacing: 2px;
                                height: 45px;
                                padding: 0 3em;
                                border: none;
                                background-color:rgb(131, 2, 2);
                                color: #fff;
                                text-transform: uppercase;
                                overflow: hidden;
                                border-radius: 5px;
                                margin-right: 25px;

                            }

                            .button2::before {
                                content: '';
                                display: block;
                                position: absolute;
                                z-index: 0;
                                bottom: 0;
                                left: 0;
                                height: 0px;
                                width: 100%;
                                background: rgb(243, 24, 24);
                                background: linear-gradient(90deg, rgb(245, 50, 50) 20%, rgb(231, 81, 81) 100%);
                                transition: 0.2s;
                            }

                            .button2 .label {
                                position: relative;
                            }

                            .button2 .icon {
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                height: 4em;
                                width: 4em;
                                position: absolute;
                                top: 4em;
                                right: 0;
                                opacity: 0;
                                transition: 0.4s;
                            }

                            .button2:hover::before {
                                height: 100%;
                            }

                            .button2:hover .icon {
                                top: 0;
                                opacity: 1;
                            }

                            #img__siguiente {
                                width: 40px;
                                height: 40px
                            }

                            .resultados .slider-item1 {
                                flex: 0 0 100%;
                                width: 100%;
                                object-fit: cover;
                                scroll-snap-align: center;


                            }

                            .resultados .slider-item2 {
                                flex: 0 0 100%;
                                width: 100%;
                                object-fit: cover;
                                scroll-snap-align: center;

                            }

                            .resultados_tabla__fila {
                                width: 95%;
                                height: 30px;
                                border: solid 2px black;
                                border-bottom: solid 1px black;
                                border-right: none;
                                display: flex;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            }

                            .tabla_encabezado2 {
                                width: 60px;
                                height: 100%;
                                border-right: solid 2px black;
                                font-family: Oswald;
                                font-size: 15px;
                            }

                            .tabla_encabezado1 {
                                width: 228.57px;
                                height: 100%;
                                border-right: solid 2px black;
                                font-family: Oswald;
                                font-size: 16px;
                            }

                            .tabla_fila2 {
                                width: 60px;
                                height: 100%;
                                border-right: solid 2px black;
                                font-family: "Markazi Text", serif;
                                font-size: 17px;
                            }

                            .tabla_fila1 {
                                width: 228.57px;
                                height: 100%;
                                border-right: solid 2px black;
                                font-family: "Markazi Text", serif;
                                font-size: 17px;
                            }

                            .resultados_tabla__encabezados {
                                width: 95%;
                                height: 30px;
                                border: solid 2px black;
                                border-right: none;
                                display: flex;
                                background: silver;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            }

                            .resultados_inicio__tx2 .inicio__txt {
                                width: 100%;
                                height: 50%;
                                margin: 0;
                                font-family: Oswald;
                                font-size: 15px;
                                display: inline-block;
                            }

                            .resultados_inicio__tx2 .inicio__txt2 {
                                width: 100%;
                                height: 50%;
                                margin: 0;
                                font-family: Oswald;
                                font-size: 15px;
                                display: inline-block;
                            }

                            .resultados_inicio__tx2 {
                                width: 250px;
                                height: 100%;
                            }

                            .resultados_inicio__vacio {
                                width: 1100px;
                                height: 100%;
                            }

                            .resultados_inicio__tx .inicio__tx2 {
                                width: 100%;
                                height: 50%;
                                margin: 0;
                                font-family: "Economica", serif;
                                font-weight: 400;
                                font-style: normal;
                                font-size: 15px;
                                display: inline-block;
                            }

                            .resultados_inicio__tx .inicio__tx1 {
                                width: 100%;
                                height: 50%;
                                margin: 0;
                                font-family: Oswald;
                                font-size: 15px;
                                display: inline-block;
                            }

                            .resultados_inicio__tx {
                                width: 250px;
                                height: 100%;


                            }

                            .resultados_inicio {
                                width: 100%;
                                height: 70px;
                                display: flex;

                            }

                            .membrete__texto__titulos {
                                width: 100%;
                                height: 25%;
                                font-family: Oswald;
                                font-size: 18px;
                            }

                            .resultados_texto__membrete {
                                width: 1230px;
                                height: 100%;
                                display: inline-block;
                            }

                            .imagen__derecha {
                                width: 100%;
                                height: 100%;
                            }

                            .resultados_imagen__derecha__membrete {
                                width: 120px;
                                height: 100%;

                            }

                            .imagen__izquierda {
                                width: 100%;
                                height: 100%;
                            }

                            .resultados_imagen__izquierda__membrete {
                                width: 250px;
                                height: 100%;

                            }

                            .resultados_membrete {
                                width: 99%;
                                height: 70px;
                                display: flex;

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
                                /* border: solid 2px black;*/
                                background: url("<?php echo $xPath; ?>imgs/fondopol3.jpg");
                                background-size: 110% 100%;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            }

                            .resultados {
                                width: 1600px;
                                height: 100%;
                                border-radius: 5px;
                                /* border: solid 2px black;*/
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                background: white;
                                overflow-x: hidden;
                                scroll-snap-type: x mandatory;
                                display: flex;
                                overflow-y: scroll;
                            }
                        </style>
                    <?php
                } else
                    header("Location: " . $xPath . "exit.php");
                    ?>