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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="<?php echo $cssPlantilla; ?>" rel="stylesheet" type="text/css" />
        <!-- links css de actualizacion-->
        <?php $xSys->getLinks($xPath, 1); ?>
        <!-- scripts js de actualizacion-->
        <?php $xSys->getScripts($xPath, 1);  ?>
        <script type="text/javascript" src="<?php echo $jsxIdxMed; ?>">

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
<style type="text/css">
            /* .styxBtnOpcion{width: 65px; font-size: 8pt; font-weight: bold; font-family: arial, helvetica, sans-serif;} */
            
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
    <script>
                            function loaded() {
                                "use strict";

                                setTimeout(function() {
                                    $('.loader_bg').fadeToggle();
                                }, 1500);

                            }
                        </script>
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
                        ?> <?php
                            $xSys->getFooter();
                            $dbname = "bdceecc";
                            $dbuser = "root";
                            $dbhost = "localhost";
                            $dbpass = 'root';
                            /*$dbname = "bdceecc";
                            $dbuser = "root";
                            $dbhost = "10.24.2.25";
                            $dbpass = '4dminMy$ql$';*/
                            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                            $sql_modal = "SELECT id_evaluacion,curp_evaluado from poligrafia_evnu where reexaminacion='0' order by curp_evaluado asc";
                            $resultado_modal = mysqli_query($conexion, $sql_modal);
                            function obtener_nombre($conexion, $curp)
                            {
                                $sql = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp ='$curp'";
                                $resultado = mysqli_query($conexion, $sql);
                                $fila = mysqli_fetch_assoc($resultado);
                                $nombre = $fila['nombre'] . " " . $fila['a_paterno'] . " " . $fila['a_materno'];
                                echo $nombre;
                            }
                            ?>
                            
                        <div id="modal_rex" class="modalmask">
                            <div class="modalbox movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <div class="encabezado_modal">
                                    <p class="texto_encabezado_modal">LISTADO DE ELEMENTOS SOLICITADOS PARA REEXAMINACION DE POLIGRAFIA.</p>
                                </div>
                                <section class="evaluados_informacion">
                                    <section class="fila_m">
                                        <?php
                                        while ($fila_modal = mysqli_fetch_assoc($resultado_modal)) {
                                            $id_evaluacion = $fila_modal['id_evaluacion'];
                                            $curp_ev = $fila_modal['curp_evaluado'];
                                            $sql2_modal = "SELECT id_evaluacion from tbprogramacion1 where id_evaluacion='$id_evaluacion' and id_nomb_eval='9'";
                                            $resultado2_modal = mysqli_query($conexion, $sql2_modal);
                                            $fila2_modal = mysqli_fetch_assoc($resultado2_modal);
                                            $id_ev2_modal = $fila2_modal['id_evaluacion'];
                                            $xPersona = new Persona($curp_ev);
                                            $xfoto = $xPersona->getFoto();
                                            if (!empty($xfoto))
                                                $xfoto = $xPath . $xfoto;
                                            else
                                                $xfoto = $xPath . "imgs/sin_foto.png"; ?>


                                            <div class="carta" id="registro<?php echo $id_evaluacion ?>">
                                                <div class="frente_carta">
                                                    <img id="foto" src="<?php echo $xfoto; ?>">
                                                    <p class="txt_encabezado">NOMBRE:</p>
                                                    <p class="txt_tex"><?php obtener_nombre($conexion, $curp_ev) ?></p>

                                                    <p class="txt_encabezado">CURP:</p>
                                                    <p class="txt_tex"><?php echo $curp_ev ?></p>

                                                    <div id="<?php echo $id_evaluacion ?>" class="barra"> Notificar </div>
                                                    <div id="<?php echo $id_evaluacion ?>" class="barra2"> Cancelar </div>


                                                </div>
                                            </div>
                                        <?php  }
                                        ?>
                                        <script>
                                            $(document).ready(function() {
                                                $(".barra").click(function() {
                                                    var id = $(this).attr("id");
                                                    var dataString = 'id=' + id;
                                                    url = "actualizar.php";
                                                    $.ajax({
                                                        type: "POST",
                                                        url: url,
                                                        data: dataString,
                                                        success: function(data) {
                                                            $("#registro" + id).hide();
                                                            $('#resp').html(data);
                                                        }
                                                    })
                                                })
                                            })
                                        </script>
                                        <script>
                                            $(document).ready(function() {
                                                $(".barra2").click(function() {
                                                    var id = $(this).attr("id");
                                                    var dataString = 'id=' + id;
                                                    url = "ajax_quitar_reexa.php";
                                                    $.ajax({
                                                        type: "POST",
                                                        url: url,
                                                        data: dataString,
                                                        success: function(data) {
                                                            $("#registro" + id).hide();
                                                            $('#resp').html(data);
                                                        }
                                                    })
                                                })
                                            })
                                        </script>
                                    </section>
                                </section>

                            </div>


                        </div>
                        <style>
                            #asignar {
                                width: 100px;
                                height: 25px;
                                font-family: oswald;
                                font-size: 14px;
                                font-weight: bold;
                                background: #3943B7;
                                color: white;
                                border-radius: 5px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                border: none;
                                text-decoration: none;
                                margin-top: -10px;
                                margin-bottom: 5px;

                            }

                            #asignar:hover {
                                scale: 1.1;
                            }

                            .barra {
                                font-family: oswald;
                                font-size: 14px;
                                font-weight: bold;
                                background: #109C00;
                                color: white;
                                width: 100px;
                                height: 25px;
                                border-radius: 5px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                border: none;

                            }

                            .barra:hover {
                                cursor: pointer;
                                scale: 1.1;
                            }
                            .barra2 {
                                font-family: oswald;
                                font-size: 14px;
                                font-weight: bold;
                                background:rgba(153, 3, 3, 0.73);
                                color: white;
                                width: 100px;
                                height: 25px;
                                border-radius: 5px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                border: none;

                            }

                            .barra2:hover {
                                cursor: pointer;
                                scale: 1.1;
                            }

                            .txt_tex {
                                width: 99%;
                                height: 20px;
                                text-align: center;
                                font-family: arima;
                                font-size: 12px;


                            }

                            .txt_tex2 {
                                width: 99%;
                                height: 20px;
                                text-align: center;
                                font-family: arima;
                                font-size: 13px;


                            }

                            .txt_encabezado {
                                width: 100%;
                                height: 20px;
                                text-align: center;
                                font-family: oswald;
                                font-size: 13px;
                                font-weight: bold;

                                margin-bottom: -3px;

                            }

                            .txt_encabezado2 {
                                width: 100%;
                                height: 20px;
                                text-align: center;
                                font-family: oswald;
                                font-size: 14px;
                                font-weight: bold;

                                margin-bottom: -3px;

                            }

                            #foto {
                                width: 168px;
                                height: 140px;
                                border-radius: 5px;
                                image-rendering: auto;
                                margin-left: -4px;
                                z-index: -2;
                            }

                            #foto2 {
                                width: 190px;
                                height: 140px;
                                border-radius: 5px;
                                image-rendering: auto;
                                margin-left: -4px;
                                z-index: -2;

                            }

                            .frente_carta {
                                width: 165px;
                                height: 165px;

                            }

                            .evaluados_informacion {
                                width: 100%;
                                height: 100%;
                                border: solid 2px black;
                            }

                            .carta {
                                width: 165px;
                                height: 310px;
                                border: solid 2px black;
                                border-radius: 5px;
                                overflow: hidden;
                                transition: 1s;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                margin-bottom: 15px;
                            }

                            @keyframes entrar {
                                0% {
                                    opacity: 0;
                                    transform: translateX(-250px);
                                }

                                100% {
                                    opacity: 1;
                                    transform: translateX(0);
                                }
                            }

                            @keyframes entrar2 {
                                0% {
                                    opacity: 0;
                                    transform: translateX(-250px);
                                }

                                100% {
                                    opacity: 1;
                                    transform: translateX(0);
                                }
                            }

                            .carta2 {
                                width: 190px;
                                height: 450px;
                                border: solid 4px #296192;
                                background: white;
                                border-radius: 10px;
                                overflow: hidden;
                                transition: 1.5s;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                margin-bottom: 15px;
                                
                            }

                            .carta3 {
                                width: 190px;
                                height: 450px;
                                border: solid 4px rgb(122, 2, 2);
                                background: white;
                                border-radius: 10px;
                                overflow: hidden;
                                transition: 1.5s;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                margin-bottom: 15px;
                                
                            }

                            .carta:hover {
                                border: none;
                                /*border: solid 2px blue;*/
                                margin-bottom: 15px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                transform: translateY(-12px);
                            }

                            .carta3:hover {
                                border: none;
                                /*border: solid 2px blue;*/
                                margin-bottom: 15px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                transform: translateY(-12px);
                                cursor: pointer;
                            }

                            .btnasignar {
                                width: 70px;
                                height: 25px;
                                font-size: 14px;
                                font-family: Oswald;
                                background: #109C00;
                                color: white;
                                border-radius: 5px;
                            }

                            .btnasignar:hover {
                                cursor: pointer;
                                scale: 1.1;
                            }

                            .carta2:hover {
                                border: none;
                                /*border: solid 2px blue;*/
                                margin-bottom: 15px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                cursor: pointer;
                                transform: translateY(-12px);
                            }

                            .carta2:hover img {
                                scale: 1.03;
                            }

                            .carta3:hover img {
                                scale: 1.03;
                            }

                            .fila_m {
                                width: 900px;
                                height: 95%;
                                display: grid;
                                grid-template-columns: repeat(5, 1fr);
                                grid-gap: 10px;
                                margin-top: 15px;
                                margin-bottom: 15px;
                            }

                            .fila_m2 {
                                width: 1500px;
                                height: 100%;
                                display: grid;
                                grid-template-columns: repeat(7, 1fr);
                                grid-gap: 10px;
                                margin-top: 15px;
                                margin-bottom: 15px;
                               
                            }

                            .slider_estadistica {
                                width: 1500px;
                                height: 100px;
                                display: grid;
                                grid-template-columns: repeat(7, 1fr);
                                grid-gap: 10px;
                                border: solid 2px black;
                                background: white;
                                border-radius: 10px;
                            }

                            .encabezado_modal {
                                width: 70%;
                                height: 40px;

                            }

                            .texto_encabezado_modal {
                                font-family: oswald;
                                font-size: 16px;
                                font-weight: bold;
                            }

                            .modalmask {
                                position: fixed;
                                font-family: Arial, sans-serif;
                                top: 0;
                                right: 0;
                                bottom: 0;
                                left: 0;
                                background: rgba(0, 0, 0, 0.8);
                                z-index: 99999;
                                opacity: 0;
                                -webkit-transition: opacity 400ms ease-in;
                                -moz-transition: opacity 400ms ease-in;
                                transition: opacity 400ms ease-in;
                                pointer-events: none;
                            }

                            .modalmask:target {
                                opacity: 1;
                                pointer-events: auto;
                            }

                            .modalbox2 {
                                width: 1100px;
                                position: relative;
                                padding: 5px 20px 13px 20px;
                                background: #fff;
                                border-radius: 5px;
                                -webkit-transition: all 500ms ease-in;
                                -moz-transition: all 500ms ease-in;
                                transition: all 500ms ease-in;
                                max-height: 600px;
                                overflow-y: scroll;

                            }

                            .modalbox {
                                width: 1100px;
                                position: relative;
                                padding: 5px 20px 13px 20px;
                                background: #fff;
                                border-radius: 3px;
                                -webkit-transition: all 500ms ease-in;
                                -moz-transition: all 500ms ease-in;
                                transition: all 500ms ease-in;
                                max-height: 600px;
                                overflow-y: scroll;

                            }

                            .movedown {
                                margin: 0 auto;
                            }

                            .modalmask:target .movedown {
                                margin: 10% auto;
                            }

                            .close {
                                background: red;
                                color: #FFFFFF;
                                line-height: 25px;
                                position: absolute;
                                right: 1px;
                                text-align: center;
                                top: 1px;
                                width: 24px;
                                text-decoration: none;
                                font-weight: bold;
                                border-radius: 3px;

                            }

                            .close:hover {
                                background: #FAAC58;
                                color: #222;
                            }
                        </style>
                        <?php
                        function eval_pendientesjefa($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,curp_supervisor,fecha_aplicacion from poligrafia_evnu where estado='3'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contadorjei = 0;
                            $contadormari = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_r = $filar['fecha'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_supervisor'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                        ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_e ?></p>

                                        <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div> <?php
if ($csup == "FEGM880122MGRLRR12") {
                                    $contadormari = $contadormari + 1 ?>
                                    <style>
                                        #FEGM880122MGRLRR12 {

                                            background: khaki;


                                        }
                                    </style>
                            <?php }
                             ?>

                        <?php }
                        } ?>

                        <?php


function eval_pendientesjefa_reexa($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,curp_supervisor,fecha_aplicacion from poligrafia_evnu_rex where estado='3'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contadorjei = 0;
                            $contadormari = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_r = $filar['fecha'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_supervisor'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                        ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_er ?></p>
                                        <a href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div> <?php
if ($csup == "FEGM880122MGRLRR12") {
                                    $contadormari = $contadormari + 1 ?>
                                    <style>
                                        #FEGM880122MGRLRR12 {

                                            background: khaki;


                                        }
                                    </style>
                            <?php }
                             ?>

                        <?php }
                        } 

                        function evalensup_jefa($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,curp_supervisor, fecha_aplicacion from poligrafia_evnu where estado='2'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contadorjei = 0;
                            $contadormari = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_r = $filar['fecha'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_supervisor'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                        ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_e ?></p>

                                        <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div>

                                <?php
                                if ($csup == "LOMJ900927HGRPRS07") {
                                    $contadorjei = $contadorjei + 1; ?>
                                    <style>
                                        #LOMJ900927HGRPRS07 {

                                            background: mediumaquamarine;

                                        }
                                    </style>


                                <?php }
                                if ($csup == "FEGM880122MGRLRR12") {
                                    $contadormari = $contadormari + 1 ?>
                                    <style>
                                        #FEGM880122MGRLRR12 {

                                            background: khaki;


                                        }
                                    </style>
                            <?php }
                            } ?>
                            
                            <?php

                        function evalensup_jefa_reexa($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $conjei = 0;
                            $conmar = 0;
                            $sqljei ="select * from poligrafia_evnu where curp_supervisor = 'LOMJ900927HGRPRS07' and estado='2'";
                            $resultadocj = mysqli_query($conexion, $sqljei);
                            while ($filaje = mysqli_fetch_assoc($resultadocj)) {
                                $conjei = $conjei+1;
                            }
                            $sqlmar ="select * from poligrafia_evnu where curp_supervisor = 'FEGM880122MGRLRR12' and estado='2'";
                            $resultadomar = mysqli_query($conexion, $sqlmar);
                            while ($filamar = mysqli_fetch_assoc($resultadomar)) {
                                $conmar = $conmar+1;
                            }

                            $sql = "SELECT curp_evaluado,curp_supervisor, fecha_aplicacion from poligrafia_evnu_rex where estado='2'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contadorjei = 0;
                            $contadormari = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_r = $filar['fecha'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_supervisor'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                        ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_er ?></p>

                                        <a href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div>

                                <?php
                                if ($csup == "LOMJ900927HGRPRS07") {
                                    $contadorjei = $contadorjei + 1; ?>
                                    <style>
                                        #LOMJ900927HGRPRS07 {

                                            background: mediumaquamarine;

                                        }
                                    </style>


                                <?php }
                                if ($csup == "FEGM880122MGRLRR12") {
                                    $contadormari = $contadormari + 1 ?>
                                    <style>
                                        #FEGM880122MGRLRR12 {

                                            background: khaki;


                                        }
                                    </style>
                            <?php }
                            } ?>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">Jeison Lopez Morales</p>
                                    <div id="cuadro_color2">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contadorjei+$conjei ?></p>
                                    </div>
                                </div>
                                <div style="display: flex;">
                                    <p style="font-size: 15px; font-family: oswald;">Maricruz Felix Garcia</p>
                                    <div id="cuadro_color">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contadormari+$conmar ?></p>
                                    </div>
                                </div>
                            </section>
                            <?php }
                             }

                        function evalsupervisores($conexion, $xPath, $curp_evaluadorb)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,curp_supervisor from poligrafia_evnu where curp_supervisor='$curp_evaluadorb' and estado='2'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contadorjei = 0;
                            $contadormari = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_r = $filar['fecha'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_supervisor'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor, fecha_aplicacion from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                            ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila_ev['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_e ?></p>

                                        <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div>

                                <?php
                                if ($csup == "LOMJ900927HGRPRS07") {
                                    $contadorjei = $contadorjei + 1; ?>

                                    <style>
                                        #LOMJ900927HGRPRS07 {

                                            background: mediumaquamarine;

                                        }
                                    </style>


                                <?php }
                                if ($csup == "FEGM880122MGRLRR12") {
                                    $contadormari = $contadormari + 1 ?>

                                    <style>
                                        #FEGM880122MGRLRR12 {

                                            background: khaki;


                                        }
                                    </style>
                                <?php }
                            }
                            

                             }
                                                   
function evalsupervisores_reexa($conexion, $xPath, $curp_evaluadorb)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,curp_supervisor from poligrafia_evnu_rex where curp_supervisor='$curp_evaluadorb' and estado='2'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contadorjei = 0;
                            $contadormari = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_r = $filar['fecha'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_supervisor'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor, fecha_aplicacion from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                            ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila_ev['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_er ?></p>

                                        <a href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div>

                                <?php
                                if ($csup == "LOMJ900927HGRPRS07") {
                                    $contadorjei = $contadorjei + 1; ?>

                                    <style>
                                        #LOMJ900927HGRPRS07 {

                                            background: mediumaquamarine;

                                        }
                                    </style>


                                <?php }
                                if ($csup == "FEGM880122MGRLRR12") {
                                    $contadormari = $contadormari + 1 ?>

                                    <style>
                                        #FEGM880122MGRLRR12 {

                                            background: khaki;


                                        }
                                    </style>
                                <?php }
                            }
                            if ($csup == "LOMJ900927HGRPRS07") { ?>
                                <section class="supervisores">
                                    <div style="display: flex; margin-top: 20px;">
                                        <p style="font-size: 15px; font-family: oswald;">Jeison Lopez Morales</p>
                                        <div id="cuadro_color2">
                                            <p style="font-family: oswald; font-size: 13px;"><?php echo $contadorjei ?></p>
                                        </div>
                                    </div>

                                </section>

                            <?php    }
                            if ($csup == "FEGM880122MGRLRR12") { ?>

                                <section class="supervisores">
                                    <div style="display: flex;">
                                        <p style="font-size: 15px; font-family: oswald;">Maricruz Felix Garcia</p>
                                        <div id="cuadro_color">
                                            <p style="font-family: oswald; font-size: 13px;"><?php echo $contadormari ?></p>
                                        </div>
                                    </div>
                                </section>
                            <?php    } ?>

                            <?php }


                        function evalseg($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $sql_resultados = "SELECT id_prog_preliminar, id_nomb_eval from tbprogramacion1 where fecha='$hoy' and id_nomb_eval ='7' or fecha='$hoy' and id_nomb_eval ='9'";
                            $resultados = mysqli_query($conexion, $sql_resultados);
                            $contador = 0;
                            while ($filaresultados = mysqli_fetch_assoc($resultados)) {
                                $contador = $contador + 1;
                                $id_pre = $filaresultados['id_prog_preliminar'];
                                $id_nomb = $filaresultados['id_nomb_eval'];
                                $sql_dapre = "SELECT xcurp,nombre,a_paterno,a_materno,id_tipo_eval,id_corporacion from tbprog_preliminar where id_prog_preliminar = '$id_pre'";
                                $resultado_pre = mysqli_query($conexion, $sql_dapre);
                                $fila_pre = mysqli_fetch_assoc($resultado_pre);
                                $curp_uso = $fila_pre['xcurp'];
                                $nombre = $fila_pre['nombre'];
                                $apellidos = $fila_pre['a_paterno'] . " " . $fila_pre['a_materno'];
                                $xPersona = new Persona($curp_uso);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $id_tip = $fila_pre['id_tipo_eval'];
                                $id_corpo = $fila_pre['id_corporacion'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_uso . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];

                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                                if ($id_nomb == '7') { ?>
                                    <div class="carta2">
                                        <div class="frente_carta2">
                                           <a href="historial.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>"> <img id="foto2" src="<?php echo $xfoto; ?>"></a>
                                            <p class="txt_encabezado2">NOMBRE:</p>
                                            <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                            <p class="txt_encabezado2">CURP:</p>
                                            <p class="txt_tex2"><?php echo $curp_uso ?></p>
                                            <p class="txt_encabezado2">CORPORACION:</p>
                                            <p class="txt_tex2"><?php echo $corporacion ?></p>

                                            <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                            <p class="txt_tex2"><?php echo $tipoe ?></p>
                                            <p class="txt_encabezado2">EVALUADOR:</p>
                                            <p class="txt_tex2"><?php echo $nombre_e ?></p>

                                            <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>">
                                                <div class="btnasignar"> Asignar </div>
                                            </a>


                                        </div>
                                    </div>






                                <?php } else { ?>
                                    <div class="carta3">
                                        <div class="frente_carta2">
                                           <a href="historial.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>"> <img id="foto2" src="<?php echo $xfoto; ?>"></a>
                                            <p class="txt_encabezado2">NOMBRE:</p>
                                            <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                            <p class="txt_encabezado2">CURP:</p>
                                            <p class="txt_tex2"><?php echo $curp_uso ?></p>
                                            <p class="txt_encabezado2">CORPORACION:</p>
                                            <p class="txt_tex2"><?php echo $corporacion ?></p>

                                            <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                            <p class="txt_tex2"><?php echo $tipoe ?></p>
                                            <p class="txt_encabezado2">EVALUADOR:</p>
                                            <p class="txt_tex2"><?php echo $nombre_er ?></p>

                                            <a href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>">
                                                <div class="btnasignar"> Asignar </div>
                                            </a>


                                        </div>
                                    </div>
                                <?php     }
                            }
                        }




                        function evalenev($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,fecha_aplicacion,curp_evaluador from poligrafia_evnu where estado='1'";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $curp_evaluador = $fila['curp_evaluador'];
                                $fecha_evaluacion = $fila['fecha_aplicacion'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_evaluador'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sqlev = "SELECT curp_evaluador, curp_supervisor, fecha_aplicacion from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                                ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila_ev['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_e ?></p>

                                        <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div>
                                <style>
                                    #VAGE811102HGMGRL01 {
                                        background: lightcoral;
                                        border-color: white;
                                    }

                                    #JEAM890927MGRSNR02 {
                                        background: lightsalmon;
                                        border-color: white;
                                    }

                                    #MAAA870123HGRRVL06 {
                                        background: aquamarine;
                                        border-color: white;
                                    }

                                    #AANA850512MGRVBN04 {
                                        background: lightpink;
                                        border-color: white;
                                    }

                                    #AECY820421MGRRSL09 {
                                        background: lightgreen;
                                        border-color: white;
                                    }

                                    #VEZF850419HNELLR09 {
                                        background-color: lightgoldenrodyellow;
                                        border-color: white;
                                    }

                                    #ROLM980228HGRJPN07 {
                                        background: rgb(203, 149, 240);
                                        border-color: white;
                                    }
                                </style>
                        <?php


                            }
                        }  ?>
<?php
function eval_reex($conexion, $xPath)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado,fecha_aplicacion,curp_evaluador from poligrafia_evnu_rex where estado='1'";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $curp_evaluador = $fila['curp_evaluador'];
                                $fecha_evaluacion = $fila['fecha_aplicacion'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $csup = $fila['curp_evaluador'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $sqlev = "SELECT curp_evaluador, curp_supervisor, fecha_aplicacion from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                                ?>
                                <div class="carta2" id="<?php echo $csup ?>">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila_ev['fecha_aplicacion'])); echo $newDate ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_er ?></p>

                                        <a href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Revisar </div>
                                        </a>


                                    </div>
                                </div>
                                <style>
                                    #VAGE811102HGMGRL01 {
                                        background: lightcoral;
                                        border-color: white;
                                    }

                                    #JEAM890927MGRSNR02 {
                                        background: lightsalmon;
                                        border-color: white;
                                    }

                                    #MAAA870123HGRRVL06 {
                                        background: aquamarine;
                                        border-color: white;
                                    }

                                    #AANA850512MGRVBN04 {
                                        background: lightpink;
                                        border-color: white;
                                    }

                                    #AECY820421MGRRSL09 {
                                        background: lightgreen;
                                        border-color: white;
                                    }

                                    #VEZF850419HNELLR09 {
                                        background-color: lightgoldenrodyellow;
                                        border-color: white;
                                    }

                                    #ROLM980228HGRJPN07 {
                                        background: rgb(203, 149, 240);
                                        border-color: white;
                                    }
                                </style>
                        <?php


                            }
                        }  ?>





                        <?php
                        function totalvg($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'VAGE811102HGMGRL01' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'VAGE811102HGMGRL01' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            } 
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            } ?>
                            <style>
                                #cuadro_colorvg {
                                    background: lightcoral;
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">ELIZABETH VAZQUEZ GERONIMO</p>
                                    <div id="cuadro_colorvg">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>
                        
                        <?php
                        function totaljeam($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'JEAM890927MGRSNR02' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'JEAM890927MGRSNR02' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            }
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            } ?>
                            <style>
                                #cuadro_colorjeam {
                                    background: lightsalmon;
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">MARISELA DE JESUS ANTONIO </p>
                                    <div id="cuadro_colorjeam">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>

                        <?php
                        function totalmaa($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'MAAA870123HGRRVL06' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            } 
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'MAAA870123HGRRVL06' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            }
                            ?>
                            <style>
                                #cuadro_colormaa {
                                    background: aquamarine;
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">ALFONSO MARINO AVILA </p>
                                    <div id="cuadro_colormaa">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>

                        <?php
                        function totalaana($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'AANA850512MGRVBN04' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            } 
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'AANA850512MGRVBN04' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            }
                            
                            ?>
                            <style>
                                #cuadro_coloraana {
                                    background: lightpink;
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">ANA LAURA ABARCA NAVA </p>
                                    <div id="cuadro_coloraana">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>
                       

                        <?php
                        function totalyul($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'AECY820421MGRRSL09' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            } 
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'AECY820421MGRRSL09' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            }?>
                            <style>
                                #cuadro_coloryul {
                                    background: lightgreen;
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">YULIANA PAULINA ARREOLA CASTRO </p>
                                    <div id="cuadro_coloryul">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>


                        <?php
                        function totalvez($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'VEZF850419HNELLR09' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            } 
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'VEZF850419HNELLR09' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            }
                            
                            ?>
                            <style>
                                #cuadro_colorvez {
                                    background: lightgoldenrodyellow;
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">FRANCISCO GABRIEL VELAZQUEZ ZELAYA </p>
                                    <div id="cuadro_colorvez">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>


                        <?php
                        function totalrol($conexion)
                        {
                            $sql = "SELECT id_evaluacion from poligrafia_evnu where curp_evaluador = 'ROLM980228HGRJPN07' and estado = '1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $contador = $contador + 1;
                            } 
                            
                            $sql2 = "SELECT id_evaluacion from poligrafia_evnu_rex where curp_evaluador = 'ROLM980228HGRJPN07' and estado = '1' ";
                            $resultado2 = mysqli_query($conexion, $sql2);
                            $contador2 = 0;
                            while ($fila2 = mysqli_fetch_assoc($resultado2)) {
                                $contador2 = $contador2 + 1;
                            }
                            ?>
                            <style>
                                #cuadro_colorrol {
                                    background: rgb(203, 149, 240);
                                    width: 30px;
                                    height: 25px;
                                    border: solid 1px black;
                                    border-radius: 10px;
                                    margin-left: 10px;
                                }
                            </style>
                            <section class="supervisores">
                                <div style="display: flex; margin-top: 20px;">
                                    <p style="font-size: 15px; font-family: oswald;">JOSE MANUEL ROJAS LOPEZ </p>
                                    <div id="cuadro_colorrol">
                                        <p style="font-family: oswald; font-size: 13px;"><?php echo $contador+$contador2 ?></p>
                                    </div>
                                </div>

                            </section>


                        <?php   }
                        ?>

                        <?php
                        function eval_diaevrexpendientes($conexion, $xPath, $curp_usuario)
                        {
                            //and fecha_aplicacion = '$hoy'
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado from poligrafia_evnu_rex where curp_evaluador = '$curp_usuario' and estado='1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion, fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_e = $filar['fecha'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $rexaminacion = $tipoe . "/" . " " . "REEXA";
                                echo  "<section class='filapen'>";
                                echo "<div id='enc_tab21p'> $nombre </div>";
                                echo "<div id='enc_tab21p'> $apellidos  </div>";
                                echo "<div id='enc_tab21p'> $fecha_e  </div>";
                                echo "<div id='enc_tab21p'> $corporacion  </div>";
                                echo "<div id='enc_tab21p'> $rexaminacion  </div>"; ?>
                                <div id='enc_tab21p'> <a
                                        href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo  $curp_eval ?>"><img
                                            src="<?php echo $xPath; ?>imgs/asig.png" width="40px" height="100%"></a> </div>


                            <?php

                                echo "</section>";
                            }
                        }


                        function eval_diaevpendientes($conexion, $xPath, $curp_usuario)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado, fecha_aplicacion from poligrafia_evnu where curp_evaluador = '$curp_usuario' and estado='1'";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                echo  "<section class='filapev'>";
                                echo "<div id='enc_tab21ev'> $nombre </div>";
                                echo "<div id='enc_tab21ev'> $apellidos  </div>";
                                echo "<div id='enc_tab21ev'> $fecha_aplicacion  </div>";
                                echo "<div id='enc_tab21ev'> $corporacion  </div>";
                                echo "<div id='enc_tab21ev'> $tipoe  </div>"; ?>
                                <div id='enc_tab21ev'> <a
                                        href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo  $curp_eval ?>"><img
                                            src="<?php echo $xPath; ?>imgs/asig.png" width="40px" height="100%"></a> </div>


                        <?php

                                echo "</section>";
                            }
                        }

                        ?>
                        <?php
                        function sup_evaluaciones($conexion, $xPath, $curp_usuario)
                        {
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado, fecha_aplicacion from poligrafia_evnu where curp_evaluador = '$curp_usuario' and estado='1'";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                {
                                    $xfoto = $xPath . $xfoto;
                                }
                                else{ 
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                }
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];

                        ?>

                                <div class="carta2">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">FECHA:</p>
                                        <p class="txt_tex2"><?php echo  $fecha_aplicacion ?></p>

                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_e ?></p>

                                        <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Evaluar </div>
                                        </a>


                                    </div>
                                </div>


                        <?php


                            }
                        }

                        ?>
                        <?php
                        function sup_diaevrexpendientes($conexion, $xPath, $curp_usuario)
                        {
                            //and fecha_aplicacion = '$hoy'
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp_evaluado from poligrafia_evnu_rex where curp_evaluador = '$curp_usuario' and estado='1' ";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $sqlr = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion, fecha from tbprog_preliminar where xcurp='" . $fila['curp_evaluado'] . "' order by id_prog_preliminar desc";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                $curp_eval = $fila['curp_evaluado'];
                                $xPersona = new Persona($curp_eval);
                                $xfoto = $xPersona->getFoto();
                                if (!empty($xfoto))
                                    $xfoto = $xPath . $xfoto;
                                else
                                    $xfoto = $xPath . "imgs/sin_foto.png";
                                $nombre = $filar['nombre'];
                                $apellidos = $filar['a_paterno'] . " " . $filar['a_materno'];
                                $id_tip = $filar['id_tipo_eval'];
                                $id_corpo = $filar['id_corporacion'];
                                $fecha_e = $filar['fecha'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_eval . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];

                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

                                $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id'";
                                $resultado_evr = mysqli_query($conexion, $sqlevr);
                                $fila_evr = mysqli_fetch_assoc($resultado_evr);
                                $evaluadorex = $fila_evr['curp_evaluador'];

                                $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
                                $resultado_evalr = mysqli_query($conexion, $sqlevalr);
                                $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
                                $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
                        ?>

                                <div class="carta3">
                                    <div class="frente_carta2">
                                        <img id="foto2" src="<?php echo $xfoto; ?>">
                                        <p class="txt_encabezado2">NOMBRE:</p>
                                        <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

                                        <p class="txt_encabezado2">CURP:</p>
                                        <p class="txt_tex2"><?php echo $curp_eval ?></p>
                                        <p class="txt_encabezado2">CORPORACION:</p>
                                        <p class="txt_tex2"><?php echo $corporacion ?></p>

                                        <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
                                        <p class="txt_tex2"><?php echo $tipoe ?></p>
                                        <p class="txt_encabezado2">EVALUADOR:</p>
                                        <p class="txt_tex2"><?php echo $nombre_er ?></p>

                                        <a href="reexa.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_eval ?>">
                                            <div class="btnasignar"> Asignar </div>
                                        </a>


                                    </div>
                                </div>

                        <?php
                            }
                        } ?>
                        <?php
                        function liberados($conexion, $xPath)
                        {
                            $contador = 0;
                            $hoy = date('Y/m/d');
                            $sql = "SELECT curp, fecha from liberados_pol where estado = '1' or estado='9'";
                            $res_lib = mysqli_query($conexion, $sql);
                            while ($fila_lib = mysqli_fetch_assoc($res_lib)) {
                                $contador = $contador + 1;
                                $curp_lib = $fila_lib['curp'];
                                $fecha_d = $fila_lib['fecha'];
                                $sql_elib = "SELECT xcurp,nombre,a_paterno,a_materno,id_tipo_eval,id_corporacion from tbprog_preliminar where xcurp ='$curp_lib' order by id_prog_preliminar desc";
                                $resultadolib = mysqli_query($conexion, $sql_elib);
                                $fila_liberados = mysqli_fetch_assoc($resultadolib);
                                $curp_uso = $fila_liberados['xcurp'];
                                $nombre = $fila_liberados['nombre'];
                                $apellidos = $fila_liberados['a_paterno'] . " " . $fila_liberados['a_materno'];
                                $id_tip = $fila_liberados['id_tipo_eval'];
                                $id_corpo = $fila_liberados['id_corporacion'];
                                $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                                $resultadocorp = mysqli_query($conexion, $sql2);
                                $filacorp = mysqli_fetch_assoc($resultadocorp);
                                $corporacion = $filacorp['corporacion'];
                                $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                                $resultadoev = mysqli_query($conexion, $sql3);
                                $filatip = mysqli_fetch_assoc($resultadoev);
                                $tipoe = $filatip['tipo_eval'];
                                $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_uso . "' order by id_evaluacion desc";
                                $resultadoid = mysqli_query($conexion, $sql4);
                                $filaid = mysqli_fetch_assoc($resultadoid);
                                $id = $filaid['id_evaluacion'];
                                echo  "<section class='fila1'>";
                                echo "<div id='enc_tab2'> $nombre </div>";
                                echo "<div id='enc_tab2'> $apellidos  </div>";
                                echo "<div id='enc_tab2'> $fecha_d  </div>";
                                echo "<div id='enc_tab2'> $corporacion  </div>";
                                echo "<div id='enc_tab2'> $tipoe  </div>"; ?>
                                <div id='enc_tab2'><?php echo  $curp_uso ?> </div>
                                <div id='enc_tab2'>
                                    <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>"><img
                                            id="img_log" src="<?php echo $xPath; ?>imgs/asig.png" width="40px" height="100%"
                                            style="border: solid 0.5px black; background: white; border-radius: 15px"></a>
                                </div>

                                <div id='enc_tab2'> <a href="ver.php?curpev=<?php echo $_SESSION['curpuso'] ?>"><img id="img_log"
                                            src="<?php echo $xPath; ?>imgs/hist2.png" width="40px" height="100%"
                                            style="border: solid 0.5px black; background: white; border-radius: 15px"></a> </div>

                        <?php

                                echo "</section>";
                            }
                            echo "Total de Evaluaciones: " . $contador;
                        } ?>

                        <script>
                            $(document).ready(function() {
                                $(".buscar").click(function() {
                                    var datju = $("#nombre").val();
                                    var dataString = 'datju=' + datju;
                                    url = "ajax_buscar.php";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: dataString,
                                        beforeSend: function() {
                                            $("#fila_m2").html("<img src='<?php echo $xPath; ?>imgs/crg.gif' width='200px' height='200px'/>");
                                        },
                                        success: function(data) {
                                            $("#fila_m2").html(data);
                                        },
                                        error: function() {

                                            alert("No hay informacion para mostrar...");
                                        }
                                    })
                                })
                            })
                        </script>
<?php if ($xUsr->xCurpEval == " "||$xUsr->xCurpEval == "0") { ?>
    <style>
        #menu2 
        {
            visibility: hidden;
        }
        .bt_mn 
        {
            visibility: hidden;
        }
    </style>
    <?php } ?>

                        <section class="contenido">
                            <?php if ($xUsr->xCurpEval == "GOAS851006MGRMRN02" || $xUsr->xCurpEval == "LOMJ900927HGRPRS07" || $xUsr->xCurpEval == "FEGM880122MGRLRR12") {  ?>
                                <section class="menu">
                                    <br><br><br>
                                    <?php if ($xUsr->xCurpEval == "GOAS851006MGRMRN02") {   ?>
                                        <div class="enc"><br> MENU </div>
                                        <a href="#slider-item2"><button id="boton_menu" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/buscar.png" alt="" width="35px" height="90%"
                                                    style="margin-right: 10px;">Busqueda de Evaluados </button></a>
                                        <a href="estadisticas.php" target="_parent"> <button id="boton_menu" type="button"> <img
                                                    src="<?php echo $xPath; ?>imgs/analitica.png" alt="" width="35px"
                                                    height="90%" style="margin-right: 10px;">Estadisticas de Evaluacion </button></a>
                                        <a href="#slider-item6"> <button id="boton_menu" type="button"><img
                                        src="<?php echo $xPath; ?>imgs/firma.png" alt="" width="35px" height="90%" style="margin-right: 10px;">Liberacion de Evaluaciones  </button></a>
                                        <a href="#slider-item1"><button id="boton_menu" name="formato" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/metodo.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -35px; margin-right: 5px;">Evaluaciones del Dia </button></a>
                                        <a href="#slider-item7"><button id="boton_menu" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/plazo.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -20px;">Pendientes de Revision</button></a>
                                        <a href="#slider-item3"><button id="boton_menu" name="evsup" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/toma-de-decisiones.png" alt="" width="40px"
                                                    height="98%" style="margin-right: 5px;">Expedientes en Supervision</button></a>
                                        <a href="#slider-item4"><button id="boton_menu" name="evev" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/usurio.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -12px;">Expedientes con Evaluador</button></a>
                                    
                                        <a href="#modal_rex"><button id="boton_menu" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/intercambiar.png" alt="" width="30px" height="90%"
                                                    style="margin-left: 10px;"> Pendientes de Notificacion a Reexa.</button></a>
                                                    <a href="#slider-item8"><button id="boton_menu" name="evev" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/esperar.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -12px; margin-right: 5px;">Reexaminaciones en Espera de Fecha</button></a>
                                    <?php }
                                    if ($xUsr->xCurpEval == "LOMJ900927HGRPRS07" || $xUsr->xCurpEval == "FEGM880122MGRLRR12") {  ?>
                                        <br><br><br>
                                        <div class="enc" id="menu2"><br> MENU </div>
                                        <a href="#slider-item2"><button id="boton_menu" class="bt_mn" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/buscar.png" alt="" width="35px" height="90%"
                                                    style="margin-right: 10px;">Busqueda de Evaluaciones </button></a>
                                                    <a href="estadisticas.php" target="_parent"> <button class="bt_mn" id="boton_menu" type="button"> <img
                                                    src="<?php echo $xPath; ?>imgs/analitica.png" alt="" width="35px"
                                                    height="90%" style="margin-right: 10px;">Estadisticas de Evaluacion </button></a>
                                                    <a href="#slider-item1"><button class="bt_mn" id="boton_menu" name="formato" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/metodo.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -35px; margin-right: 7px;">Evaluaciones del Dia </button></a>
                                                    <a href="#slider-item3"><button class="bt_mn" id="boton_menu" name="evsup" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/toma-de-decisiones.png" alt="" width="40px"
                                                    height="98%" style="margin-right: 5px;">Expedientes por Supervisar</button></a>
                                                    <a href="#slider-item4"><button class="bt_mn" id="boton_menu" name="evev" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/usurio.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -12px; margin-right: 5px;">Expedientes con Evaluador</button></a>
                                        <a href="#slider-item5"><button class="bt_mn" id="boton_menu" type="button"><img
                                                    src="<?php echo $xPath; ?>imgs/pruebas.png" alt="" width="35px" height="90%"
                                                    style="margin-left: -25px; margin-right: 5px;">Modulo de Evaluador</button></a>
                                    <?php   }  ?>
                                    <div class="enc2"><br> </div>
                                </section>
                                <section class="datos">
                                    <section class="informacion">
                                    <section class="slider-item1" id="slider-item2">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Busqueda de Evaluaciones.</p>
                                            <br><input id="nombre" placeholder=" Busqueda" type="text" style="width: 220px; height: 30px; font-family: Oswald; font-size: 14px; border-radius: 10px;"><button class="buscar" type="button" style=" margin-left: 10px; width: 100px; height: 30px; font-size: 13px; font-family: Oswald; border-radius: 10px; border: none; background:rgb(24, 209, 3);">Buscar</button>
                                            <section class="fila_m2" id="fila_m2">

                                            </section>
                                            <div id="resul"></div>
                                        </section>
                                        
                                        <section class="slider-item1" id="slider-item1">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluados del Dia.</p>
                                            <section class="fila_m2">

                                                <?php evalseg($conexion, $xPath) ?>
                                            </section>
                                        </section>
                                        
                                        <section class="slider-item1" id="slider-item3">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluaciones en Supervision.</p>
                                            <section class="fila_m2">

                                                <?php if ($xUsr->xCurpEval == 'GOAS851006MGRMRN02') {
                                                    evalensup_jefa($conexion, $xPath);
                                                    evalensup_jefa_reexa($conexion, $xPath);
                                                } else {
                                                    evalsupervisores($conexion, $xPath, $xUsr->xCurpEval);
                                                    evalsupervisores_reexa($conexion, $xPath, $xUsr->xCurpEval);
                                                } ?>

                                            </section>

                                        </section>
                                        <section class="slider-item1" id="slider-item4">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluaciones en Evaluacion.</p>
                                            <section class="slider_estadistica">
                                                <?php totalvg($conexion) ?>
                                                <?php totaljeam($conexion) ?>
                                                <?php totalmaa($conexion) ?>
                                                <?php totalaana($conexion) ?>
                                                <?php totalyul($conexion) ?>
                                                <?php totalvez($conexion) ?>
                                                <?php totalrol($conexion) ?>
                                            </section>
                                            <section class="fila_m2">

                                                <?php evalenev($conexion, $xPath) ?>
                                                <?php eval_reex($conexion, $xPath) ?>
                                                

                                            </section>

                                        </section>
                                        <section class="slider-item1" id="slider-item5">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluaciones Asignadas.</p>
                                            <section class="fila_m2">

                                                <?php sup_evaluaciones($conexion, $xPath, $xUsr->xCurpEval) ?>
                                                <?php sup_diaevrexpendientes($conexion, $xPath, $xUsr->xCurpEval) ?>

                                            </section>

                                        </section>
                                        <section class="slider-item1" id="slider-item6">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluaciones Liberadas.</p>


                                            <section class="enc_tabla">
                                                <div id="enc_tab">Apellidos</div>
                                                <div id="enc_tab">Nombre(s)</div>
                                                <div id="enc_tab">Fecha de Evaluacion</div>
                                                <div id="enc_tab">Dependencia</div>
                                                <div id="enc_tab">Tipo Evaluacion</div>
                                                <div id="enc_tab">Curp</div>
                                                <div id="enc_tab">Revisar</div>
                                                <div id="enc_tab">Historial</div>
                                            </section>
                                            <?php liberados($conexion, $xPath); ?> <br>
                                            <a href="liberacion.php" style="width: 300px;">
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
                                                    Descargar Documento

                                                </button>

                                            </a>
                                        </section>
                                        <section class="slider-item1" id="slider-item7">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluaciones Pendientes de Revision.</p>
                                            <section class="fila_m2">

                                                <?php eval_pendientesjefa($conexion, $xPath) ?>
                                                <?php eval_pendientesjefa_reexa($conexion, $xPath) ?>


                                            </section>

                                        </section>

                                        <section class="slider-item1" id="slider-item8">
                                            <p id="px1" style="font-family: oswald; font-size: 18px;">Evaluaciones Pendientes de Fecha Para Reexaminacion.</p>
                                            <section class="fila_m2">

                                                <?php $sql = "SELECT id_evaluacion,curp_evaluado from poligrafia_evnu where reexaminacion='1' order by curp_evaluado asc";
      $resultado = mysqli_query($conexion,$sql);
      function obtener_nombre2($conexion,$curp)
      {
         $sql ="SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp ='$curp'";
         $resultado = mysqli_query($conexion,$sql);
         $fila = mysqli_fetch_assoc($resultado);
         $nombre = $fila['nombre']." ".$fila['a_paterno']." ".$fila['a_materno'];
         echo $nombre;
      } while ($fila = mysqli_fetch_assoc($resultado)) {
        $id_evaluacion2 = $fila['id_evaluacion'];
        $curp_ev2 = $fila['curp_evaluado'];
       $sql2="SELECT id_evaluacion from tbprogramacion1 where id_evaluacion='$id_evaluacion2' and id_nomb_eval='9'";
        $resultado2 = mysqli_query($conexion,$sql2);
        $fila2 = mysqli_fetch_assoc($resultado2);
        $id_ev2 = $fila2['id_evaluacion'];
        $xPersona = new Persona($curp_ev2);
        $xfoto = $xPersona->getFoto();
                            if (!empty($xfoto))
                                $xfoto = $xPath . $xfoto;
                            else
                                $xfoto = $xPath . "imgs/sin_foto.png";?>
                                

        <div class="carta" id="registro<?php  echo $id_evaluacion ?>">
           <div class="frente_carta">
           <img id="foto" src="<?php echo $xfoto;?>">
           <p class="txt_encabezado">NOMBRE:</p>
           <p class="txt_tex" ><?php  obtener_nombre2($conexion,$curp_ev2) ?></p>
           
         <p class="txt_encabezado">CURP:</p>
           <p class="txt_tex"><?php  echo $curp_ev2 ?></p>

           </div>
     </div> 
               <?php }
         ?>                                  


                                            </section>

                                        </section>
                                        
                                      
                                    </section>

                                </section>






                            <?php   } else { ?>
                                <section class="menu">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="enc"><br> MENU </div>

                                    <a href="estadisticas.php"><button id="boton_menu" name="estadistica" type="button">Estadisticas de Evaluacion <img
                                                src="<?php echo $xPath; ?>imgs/analitica.png" alt="" width="35px"
                                                height="90%"></button></a>
                                    <div class="infografia">
                                        <p style="font-family: oswald; font-size: 15px; color: white;">Infografia</p>
                                        <div class="infografia_ma">
                                            <div></div>
                                            <p>Elementos de Reexaminacion Pendientes.</p>
                                        </div>
                                        <div class="infografia_ma2">
                                            <div></div>
                                            <p>Elementos en Evaluacion Pendientes.</p>
                                        </div>

                                    </div>
                        
                                    <div class="enc2"><br> </div>
                                </section>
                                <section class="datos" id="t_datos">
                                    <p style="font-family: oswald; font-size: 18px;">Evaluaciones Asignadas del Dia.</p>
                                    <section class="enc_tabla1">
                                        <div id="enc_tab">Nombre(s)</div>
                                        <div id="enc_tab">Apellidos</div>
                                        <div id="enc_tab">Fecha de Evaluacion</div>
                                        <div id="enc_tab">Categoria</div>
                                        <div id="enc_tab">Tipo Evaluacion</div>
                                        <div id="enc_tab">Evaluar</div>

                                    </section>
                                    <section class="informacion2">
                                        <?php //eval_diaev($conexion,$xPath,$xUsr->xCurpEval) 
                                        ?>
                                        <?php //eval_diaevrex($conexion,$xPath,$xUsr->xCurpEval) 
                                        ?>
                                        <?php eval_diaevrexpendientes($conexion, $xPath, $xUsr->xCurpEval) ?>
                                        <?php eval_diaevpendientes($conexion, $xPath, $xUsr->xCurpEval) ?>


                                    </section>
                                </section>



                            <?php   } ?>
                        </section>


                        <script type="text/javascript">
                            var obj_contain = document.getElementById('contain');
                            var obj_loadingMessage = document.getElementById('loadingMessage');

                            function loading() {
                                var images = document.images;
                                for (var i = 0; i < images.length; i++) {
                                    var image = images[i];
                                    if (image.complete) {
                                        if ((i + 1) == images.length) {
                                            obj_loadingMessage.style.display = 'none';
                                            obj_contain.style.display = 'block';
                                        }
                                    } else {
                                        setTimeout(loading, 30);
                                        return false;
                                    }
                                }
                            }
                            obj_contain.style.display = 'none';
                            obj_loadingMessage.style.display = 'block';
                            loading();
                        </script>
                         <style>
                            @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
                            @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&display=swap');
                            @import url('https://fonts.googleapis.com/css2?family=Arima:wght@100..700&display=swap');

                            #filapendiente {
                                background: #C62403;
                                color: white;
                            }

                            #cuadro_color {
                                width: 30px;
                                height: 25px;
                                background: khaki;
                                border: solid 1px black;
                                border-radius: 10px;
                                margin-left: 10px;
                            }

                            #cuadro_color2 {
                                width: 30px;
                                height: 25px;
                                background: mediumaquamarine;
                                border: solid 1px black;
                                border-radius: 10px;
                                margin-left: 10px;

                            }

                            * {
                                scrollbar-width: none;
                            }

                            #img_log:hover {
                                background: lightgreen;
                                scale: 0.95;
                            }

                            .arima {
                                font-family: "Arima", system-ui;
                                font-optical-sizing: auto;
                                font-weight: 400;
                                font-style: normal;
                            }

                            #px2 {
                                display: none;
                            }

                            #px3 {
                                display: none;
                            }

                            #px4 {
                                display: none;
                            }

                            .contenido {
                                width: 1900px;
                                height: 750px;
                                display: flex;
                            }

                            .menu {
                                width: 300px;
                                height: 100%;
                                border: solid 2px black;
                                display: inline-block;
                                border-radius: 15px;
                                font-family: oswald;
                                font-size: 14px;
                                background: url("<?php echo $xPath; ?>imgs/fnea.jpg");
                                background-size: contain;
                                overflow-y: hidden;
                            }


                            #boton_menu {
                                width: 100%;
                                height: 40px;
                                border: solid 2px black;
                                border-radius: 5px;
                                margin-top: 5px;
                                font-family: oswald;
                                font-size: 15px;
                                background: black;
                                color: white;
                                z-index: -2;
                                opacity: 0.7;
                                /*border-bottom: solid 0.2px silver;*/
                            }

                            #boton_menu:hover {
                                background: white;
                                cursor: pointer;
                                background: whitesmoke;
                                transition: 1s;
                                color: black;
                                border: none;
                                opacity: 1;

                            }

                            #buscador {
                                display: none;
                                width: 100%;
                                height: 30px;
                                font-family: oswald;
                                font-size: 15px;
                            }

                            .enc {
                                width: 100%;
                                height: 80px;
                                font-family: oswald;
                                font-size: 14px;
                                color: white;
                                z-index: -2;
                            }

                            .enc2 {
                                width: 100%;
                                height: 80px;
                                font-family: oswald;
                                font-size: 14px;
                                color: white;
                                margin-top: 5px;
                            }

                            .datos {
                                width: 1600px;
                                height: 100%;
                                border: solid 2px black;
                                border-radius: 15px;
                            }

                            .datos2 {
                                width: 1600px;
                                height: 100%;
                                border: solid 2px black;
                                border-radius: 15px;
                                background: red;
                                display: none;
                            }

                            .enc_tabla {
                                width: 1500px;
                                height: 35px;
                                border: solid 2px black;
                                border-right: none;
                                display: flex;
                                margin-bottom: -3px;

                            }

                            .enc_tabla1 {
                                width: 1100px;
                                height: 35px;
                                border: solid 2px black;
                                border-right: none;
                                display: flex;
                                margin-bottom: -3px;

                            }

                            #enc_tab {
                                width: 187.5px;
                                height: 100%;
                                background: #296192;
                                border-right: solid 2px black;
                                font-family: oswald;
                                font-size: 16px;
                                color: white;
                            }

                            #enc_tab2 {
                                width: 187.5px;
                                height: 100%;
                                border-right: solid 1px black;
                                border-bottom: solid 2px black;
                                border-left: solid 1px black;
                                font-family: "Arima", system-ui;
                                font-size: 14px;
                                color: black;
                            }

                            #enc_tab21 {
                                width: 187.5px;
                                height: 100%;
                                border-right: solid 2px black;
                                border-bottom: solid 2px black;
                                font-family: "Arima", system-ui;
                                font-size: 14px;
                                color: black;
                            }

                            #enc_tab21sr {
                                width: 187.5px;
                                height: 100%;
                                border-right: solid 2px black;
                                border-bottom: solid 2px black;
                                font-family: "Arima", system-ui;
                                font-size: 14px;
                                color: black;
                            }

                            #enc_tab21p {
                                width: 187.5px;
                                height: 100%;
                                border-right: solid 2px black;
                                border-bottom: solid 2px black;
                                font-family: "Arima", system-ui;
                                font-size: 14px;
                                background: #C62403;
                                color: white;
                            }

                            #enc_tab21ev {
                                width: 187.5px;
                                height: 100%;
                                border-right: solid 2px black;
                                border-bottom: solid 2px black;
                                font-family: "Arima", system-ui;
                                font-size: 14px;
                                background: #F8F4A6;
                                color: black;
                            }

                            .informacion {
                                width: 1500px;
                                max-height: 720px;
                                overflow-x: hidden;
                                scroll-snap-type: x mandatory;
                                display: flex;
                                overflow-y: scroll;
                            
                            }

                            .informacion3 {
                                width: 1500px;
                                max-height: 600px;
                                display: none;

                            }

                            .informacion4 {
                                width: 1500px;
                                max-height: 600px;
                                display: none;

                            }

                            .informacion2 {
                                width: 1100px;
                                max-height: 600px;
                                display: inline-block;
                                overflow-y: scroll;

                            }

                            .informacion2::-webkit-scrollbar {
                                display: none;
                            }

                            .fila {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;

                            }

                            .fila:hover {
                                background: #F8F4A6;
                            }

                            .fila1:hover {
                                background: #F8F4A6;
                            }

                            .filapev {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;

                            }

                            .filapen {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;


                            }

                            .filar {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;

                            }

                            .filasr {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;

                            }

                            .fila1 {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;



                            }


                            .fila3 {
                                width: 100%;
                                height: 30px;
                                display: flex;
                                border-left: solid 1px black;
                                border-right: solid 1px black;

                            }

                            .fila3:hover {
                                background: #F8F4A6;
                            }

                            .informacion .slider-item1 {
                                flex: 0 0 100%;
                                width: 100%;
                                object-fit: cover;
                                scroll-snap-align: center;


                            }

                            input::placeholder {
                                font-weight: 900;
                                font-family: 'Font Awesome 6 Free';
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

                            .infografia {
                                            width: 100%;
                                            height: 110px;
                                            border: solid 1px white;
                                            margin-top: 15px;

                                        }

                                        .infografia p {
                                            color: white;
                                            font-size: 14px;
                                            font-family: oswald;
                                            margin-left: 5px;

                                        }

                                        .infografia_ma {
                                            display: flex;
                                        }

                                        .infografia_ma div {
                                            width: 20px;
                                            height: 20px;
                                            background: #C62403;
                                            border-radius: 5px;
                                            margin-left: 5px;
                                        }

                                        .infografia_ma2 {
                                            display: flex;
                                        }

                                        .infografia_ma2 div {
                                            width: 20px;
                                            height: 20px;
                                            background: #F8F4A6;
                                            border-radius: 5px;
                                            margin-left: 5px;
                                        }
                        </style>
                        <script>
                            $(document).ready(function() {
                                var pageRefresh = 1000;
                                setInterval(function() {
                                    refresh();
                                }, pageRefresh);
                            });

                            function refresh() {
                                $('#t_datos').load(location.href + " #t_datos");
                                $('#Contador').load(location.href + " #Contador");
                            }
                        </script>
    </body>

    </html>
    <?php ?>
<?php
} else
    header("Location: " . $xPath . "exit.php");
?>