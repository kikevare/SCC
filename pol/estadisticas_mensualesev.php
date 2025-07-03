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
                        function obtener_datos_permanencia($conexion, $curp_evaluador, $mes)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where curp_evaluador='$curp_evaluador' and fecha_aplicacion>='2025/$mes/01' and fecha_aplicacion<='2025/$mes/31'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='2' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                        ?>

                            <?php   }
                            echo $contador;
                        }
                        function suma_permanencia($conexion, $mes)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where fecha_aplicacion>='2025/$mes/01' and fecha_aplicacion<='2025/$mes/31'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='2' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                        <?php   }
                            echo $contador;
                        }
                        ?>

                        <?php function obtener_datos_nuevoingreso($conexion, $curp_evaluador, $mes)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where curp_evaluador='$curp_evaluador' and fecha_aplicacion>='2025/$mes/01' and fecha_aplicacion<='2025/$mes/31'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='1' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                        ?>
                            <?php   }
                            echo $contador;
                        }
                        function suma_nuevoingreso($conexion, $mes)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where fecha_aplicacion>='2025/$mes/01' and fecha_aplicacion<='2025/$mes/31'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='1' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }


                        function suma_RB_NI($conexion, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='RIESGO BAJO(NDI/NSR)' or fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and  id_resultado ='RIESGO BAJO(EES)' or fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO BAJO (OSS3)'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?> 

                            <?php   }
                            echo $contador;
                        }

                        function obtener_RB_NI($conexion, $curp_evaluador, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where curp_evaluador='$curp_evaluador' and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='RIESGO BAJO(NDI/NSR)' or curp_evaluador ='$curp_evaluador'  and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO BAJO(EES)' or  curp_evaluador='$curp_evaluador'  and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO BAJO (OSS3)'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }

                        function obtener_RM_NI($conexion, $curp_evaluador, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where curp_evaluador='$curp_evaluador' and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='RIESGO MEDIO (INFO)' or curp_evaluador ='$curp_evaluador'  and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO MEDIO (RES-TEC)'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }
                        function suma_RM_NI($conexion, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='RIESGO MEDIO (INFO)' or fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO MEDIO (RES-TEC)'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }

                        function obtener_RA_NI($conexion, $curp_evaluador, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where curp_evaluador='$curp_evaluador' and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='RIESGO ALTO ADMISION' or curp_evaluador ='$curp_evaluador'  and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO ALTO (DI)' or  curp_evaluador='$curp_evaluador'  and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO ALTO (ESS)'or  curp_evaluador='$curp_evaluador'  and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO ALTO (OSS3)'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }

                        function suma_RA_NI($conexion, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='RIESGO ALTO ADMISION' or fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO ALTO (DI)' or  fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO ALTO (ESS)'or  fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado ='RIESGO ALTO (OSS3)'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }


                        function obtener_RE_NI($conexion, $curp_evaluador, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where curp_evaluador='$curp_evaluador' and fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='REEXAMINACION'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                            <?php   }
                            echo $contador;
                        }
                        function suma_RE_NI($conexion, $fecha_inicio, $fecha_final, $tipo)
                        {
                            $sql = "SELECT id_evaluacion, curp_evaluado from poligrafia_evnu where fecha_aplicacion>='$fecha_inicio' and fecha_aplicacion<='$fecha_final' and id_resultado='REEXAMINACION'";
                            $resultado = mysqli_query($conexion, $sql);
                            $contador = 0;
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                $id_evaluacion = $fila['id_evaluacion'];
                                $curp_evaluado = $fila['curp_evaluado'];
                                $fecha_aplicacion = $fila['fecha_aplicacion'];
                                $sqlr = "SELECT xcurp from tbprog_preliminar where xcurp='" . $curp_evaluado . "' and id_tipo_eval='$tipo' order by id_prog_preliminar desc ";
                                $resultador = mysqli_query($conexion, $sqlr);
                                $filar = mysqli_fetch_assoc($resultador);
                                if ($curp_evaluado == $filar['xcurp']) {
                                    $contador = $contador + 1;
                                }
                            ?>

                        <?php   }
                            echo $contador;
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
                                                <p class="inicio__tx2">SUPERVISION Y CONTROL DE CALIDAD</p>
                                            </div>
                                            <div class="resultados_inicio__vacio"></div>
                                            <div class="resultados_inicio__tx2">
                                                <p class="inicio__txt">FECHA:<?php echo " " . $hoy ?></p>
                                                <p class="inicio__txt2">PERIODO: ENERO</p>
                                            </div>
                                        </div>
                                        <section class="resultados_tabla__encabezados">
                                            <div class="tabla_encabezado1">
                                                <p>Supervisores</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluadores</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluaciones de Permanencia</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RB</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RM</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RA</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>REEX</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluaciones de Nuevo Ingreso</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RB</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RM</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RA</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>REEX</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>VAZQUEZ GERONIMO ELIZABETH</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "VAGE811102HGMGRL01", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "VAGE811102HGMGRL01", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VAGE811102HGMGRL01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>DE JESUS ANTONIO MARISELA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "JEAM890927MGRSNR02", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "JEAM890927MGRSNR02", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "JEAM890927MGRSNR02", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>

                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>MARINO AVILA ALFONSO</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "MAAA870123HGRRVL06", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "MAAA870123HGRRVL06", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "MAAA870123HGRRVL06", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ARGUELLO FALCON IVAN</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AUFI820831HDFRLV01", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AUFI820831HDFRLV01", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AUFI820831HDFRLV01", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>FELIX GARCIA MARICRUZ</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ABARCA NAVA ANA LAURA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AANA850512MGRVBN04", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AANA850512MGRVBN04", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AANA850512MGRVBN04", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ARREOLA CASTRO YULIANA PAULINA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AECY820421MGRRSL09", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AECY820421MGRRSL09", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AECY820421MGRRSL09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>VELAZQUEZ ZELAYA FRANCISCO</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "VEZF850419HNELLR09", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "VEZF850419HNELLR09", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VEZF850419HNELLR09", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ROJAS LOPEZ JOSE MANUEL</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "ROLM980228HGRJPN07", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "ROLM980228HGRJPN07", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "ROLM980228HGRJPN07", "2025/01/01", "2025/01/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>LOPEZ MORALES JEISON</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b>TOTALES:</b></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b><?php suma_permanencia($conexion, "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RB_NI($conexion, "2025/01/01", "2025/01/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RM_NI($conexion, "2025/01/01", "2025/01/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RA_NI($conexion, "2025/01/01", "2025/01/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RE_NI($conexion, "2025/01/01", "2025/01/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b><?php suma_nuevoingreso($conexion, "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RB_NI($conexion, "2025/01/01", "2025/01/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RM_NI($conexion, "2025/01/01", "2025/01/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RA_NI($conexion, "2025/01/01", "2025/01/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RE_NI($conexion, "2025/01/01", "2025/01/31", "01") ?></b></p>
                                            </div>
                                        </section>
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
                                                <p class="inicio__tx2">SUPERVISION Y CONTROL DE CALIDAD</p>
                                            </div>
                                            <div class="resultados_inicio__vacio"></div>
                                            <div class="resultados_inicio__tx2">
                                                <p class="inicio__txt">FECHA:<?php echo " " . $hoy ?></p>
                                                <p class="inicio__txt2">PERIODO: FEBRERO</p>
                                            </div>
                                        </div>
                                        <section class="resultados_tabla__encabezados">
                                            <div class="tabla_encabezado1">
                                                <p>Supervisores</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluadores</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluaciones de Permanencia</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RB</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RM</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RA</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>REEX</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluaciones de Nuevo Ingreso</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RB</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RM</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RA</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>REEX</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>VAZQUEZ GERONIMO ELIZABETH</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "VAGE811102HGMGRL01", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "VAGE811102HGMGRL01", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VAGE811102HGMGRL01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>DE JESUS ANTONIO MARISELA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "JEAM890927MGRSNR02", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "JEAM890927MGRSNR02", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "JEAM890927MGRSNR02", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>

                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>MARINO AVILA ALFONSO</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "MAAA870123HGRRVL06", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "MAAA870123HGRRVL06", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "MAAA870123HGRRVL06", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ARGUELLO FALCON IVAN</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AUFI820831HDFRLV01", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AUFI820831HDFRLV01", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AUFI820831HDFRLV01", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>FELIX GARCIA MARICRUZ</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ABARCA NAVA ANA LAURA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AANA850512MGRVBN04", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AANA850512MGRVBN04", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AANA850512MGRVBN04", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ARREOLA CASTRO YULIANA PAULINA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AECY820421MGRRSL09", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AECY820421MGRRSL09", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AECY820421MGRRSL09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>VELAZQUEZ ZELAYA FRANCISCO</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "VEZF850419HNELLR09", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "VEZF850419HNELLR09", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VEZF850419HNELLR09", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p> ROJAS LOPEZ JOSE MANUEL</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "ROLM980228HGRJPN07", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "ROLM980228HGRJPN07", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "ROLM980228HGRJPN07", "2025/02/01", "2025/02/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>LOPEZ MORALES JEISON</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b>TOTALES:</b></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b><?php suma_permanencia($conexion, "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RB_NI($conexion, "2025/02/01", "2025/02/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RM_NI($conexion, "2025/02/01", "2025/02/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RA_NI($conexion, "2025/02/01", "2025/02/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RE_NI($conexion, "2025/02/01", "2025/02/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b><?php suma_nuevoingreso($conexion, "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RB_NI($conexion, "2025/02/01", "2025/02/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RM_NI($conexion, "2025/02/01", "2025/02/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RA_NI($conexion, "2025/02/01", "2025/02/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RE_NI($conexion, "2025/02/01", "2025/02/31", "01") ?></b></p>
                                            </div>
                                        </section>
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
                                                <p>Supervisores</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluadores</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluaciones de Permanencia</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RB</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RM</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RA</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>REEX</p>
                                            </div>
                                            <div class="tabla_encabezado1">
                                                <p>Evaluaciones de Nuevo Ingreso</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RB</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RM</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>RA</p>
                                            </div>
                                            <div class="tabla_encabezado2">
                                                <p>REEX</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>VAZQUEZ GERONIMO ELIZABETH</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "VAGE811102HGMGRL01", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "VAGE811102HGMGRL01", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VAGE811102HGMGRL01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>DE JESUS ANTONIO MARISELA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "JEAM890927MGRSNR02", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "JEAM890927MGRSNR02", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "JEAM890927MGRSNR02", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>

                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>MARINO AVILA ALFONSO</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "MAAA870123HGRRVL06", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "MAAA870123HGRRVL06", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "MAAA870123HGRRVL06", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ARGUELLO FALCON IVAN</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AUFI820831HDFRLV01", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AUFI820831HDFRLV01", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AUFI820831HDFRLV01", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>JEISON LOPEZ MORALES</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>FELIX GARCIA MARICRUZ</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ABARCA NAVA ANA LAURA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AANA850512MGRVBN04", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AANA850512MGRVBN04", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AANA850512MGRVBN04", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>ARREOLA CASTRO YULIANA PAULINA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "AECY820421MGRRSL09", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "AECY820421MGRRSL09", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "AECY820421MGRRSL09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>VELAZQUEZ ZELAYA FRANCISCO</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "VEZF850419HNELLR09", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "VEZF850419HNELLR09", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "VEZF850419HNELLR09", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p> ROJAS LOPEZ JOSE MANUEL</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_permanencia($conexion, "ROLM980228HGRJPN07", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "02") ?></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><?php obtener_datos_nuevoingreso($conexion, "ROLM980228HGRJPN07", "03") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RB_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RM_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RA_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><?php obtener_RE_NI($conexion, "ROLM980228HGRJPN07", "2025/03/01", "2025/03/31", "01") ?></p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p>MARICRUZ FELIX GARCIA</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>LOPEZ MORALES JEISON</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p>0</p>
                                            </div>
                                        </section>
                                        <section class="resultados_tabla__fila">
                                            <div class="tabla_fila1">
                                                <p></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b>TOTALES:</b></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b><?php suma_permanencia($conexion, "03") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RB_NI($conexion, "2025/03/01", "2025/03/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RM_NI($conexion, "2025/03/01", "2025/03/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RA_NI($conexion, "2025/03/01", "2025/03/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RE_NI($conexion, "2025/03/01", "2025/03/31", "02") ?></b></p>
                                            </div>
                                            <div class="tabla_fila1">
                                                <p><b><?php suma_nuevoingreso($conexion, "03") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RB_NI($conexion, "2025/03/01", "2025/03/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RM_NI($conexion, "2025/03/01", "2025/03/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RA_NI($conexion, "2025/03/01", "2025/03/31", "01") ?></b></p>
                                            </div>
                                            <div class="tabla_fila2">
                                                <p><b><?php suma_RE_NI($conexion, "2025/03/01", "2025/03/31", "01") ?></b></p>
                                            </div>
                                        </section>
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
                                width: 250px;
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
                                width: 250px;
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
                            }
                        </style>
                    <?php
                } else
                    header("Location: " . $xPath . "exit.php");
                    ?>