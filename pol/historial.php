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
        <script src="../../includes/tinymce5.7/tinymce.min.js" referrerpolicy="origin"></script>
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
                            /*$dbname = "bdceecc";
    $dbuser = "root";
    $dbhost = "localhost";
    $dbpass = 'root';*/
                            $dbname = "bdceecc";
                            $dbuser = "root";
                            $dbhost = "10.24.2.25";
                            $dbpass = '4dminMy$ql$';
                            $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                            $hoy = date('Y/m/d');
                            $curp1 = "";
                            $id_evaluacion = "";
                            if (isset($_GET["curpev"], $_GET["id_evaluacion"])) {
                                $_SESSION['curp'] = $curp1 = $_GET['curpev'];
                                $_SESSION['id_evaluacion'] = $id_evaluacion = $_GET['id_evaluacion'];
                            } elseif (isset($_SESSION["curp"], $_SESSION['id_evaluacion'])) {
                                $curp1 = $_SESSION['curp'];
                                $id_evaluacion = $_SESSION['id_evaluacion'];
                            }

                            //$curp2=$_SESSION['curpuso']; 
                            $xPersona = new Persona($curp1);
                            $xfoto = $xPersona->getFoto();
                            if (!empty($xfoto))
                                $xfoto = $xPath . $xfoto;
                            else
                                $xfoto = $xPath . "imgs/sin_foto.png";

                            $sql = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion from tbprog_preliminar where xcurp = '" . $curp1 . "' order by id_prog_preliminar desc";
                            $resultado = mysqli_query($conexion, $sql);
                            $fila = mysqli_fetch_assoc($resultado);
                            $id_corpo = $fila['id_corporacion'];
                            $id_tip = $fila['id_tipo_eval'];
                            $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
                            $resultadocorp = mysqli_query($conexion, $sql2);
                            $filacorp = mysqli_fetch_assoc($resultadocorp);
                            $corporacion = $filacorp['corporacion'];
                            $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
                            $resultadoev = mysqli_query($conexion, $sql3);
                            $filatip = mysqli_fetch_assoc($resultadoev);
                            $tipoe = $filatip['tipo_eval'];
                            $sql_id_reportes = "select id_evaluacion, fecha_reg from tbevaluaciones where curp='$curp1'";
                            $resultado_rep = mysqli_query($conexion, $sql_id_reportes);

                            ?>
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
                            @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&display=swap');
                            @import url('https://fonts.googleapis.com/css2?family=Arima:wght@100..700&display=swap');

                            body {
                                background: white;
                            }

                            .hoja {
                                width: 100%;
                                height: auto;
                                border: solid 2px black;
                                background-color: white;
                                margin-bottom: 10px;
                            }

                            .membrete {
                                width: 100%;
                                height: 50px;
                                display: flex;
                            }

                            .imagen_mem {
                                width: 30%;
                                height: 100%;

                            }

                            .titulo_mem {
                                width: 40%;
                                height: 100%;
                                font-family: oswald;
                                font-size: 14px;


                            }

                            .tabla1 {
                                width: 85%;
                                height: 500px;
                                border: solid 2px black;
                            }

                            #tbr_1 {
                                width: 100%;
                                height: 50px;
                                border-bottom: solid 2px black;
                                display: flex;
                                font-family: oswald;
                                font-size: 16px;
                            }

                            .tabla_datosdoc {
                                width: 80%;
                                height: 215px;
                                border: solid 2px black;
                                margin-top: 20px;
                            }

                            #filas_datos {
                                width: 100%;
                                height: 30px;
                                display: flex;
                            }

                            .inforep {
                                width: 80%;
                                height: auto;
                                border: solid 2px black;
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


                            .modalbox {
                                width: 400px;
                                position: relative;
                                padding: 5px 20px 13px 20px;
                                background: #fff;
                                border-radius: 3px;
                                -webkit-transition: all 500ms ease-in;
                                -moz-transition: all 500ms ease-in;
                                transition: all 500ms ease-in;

                            }

                            .modalbox2 {
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

                            #b_modal1 {
                                width: 90px;
                                height: 30px;
                                background: white;
                                font-family: oswald;
                                font-size: 14px;
                                border: none;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                border-radius: 10px;
                            }

                            #b_modal1:hover {
                                background: rgb(184, 52, 25);
                                color: white;
                                transition: 1s;
                                cursor: pointer;

                            }

                            .arima {
                                font-family: "Arima", system-ui;
                                font-optical-sizing: auto;
                                font-weight: 400;
                                font-style: normal;
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
                                z-index: 2;
                                background-color: #000;
                            }

                            .container::after {
                                content: "";
                                border-radius: 15px;
                                position: absolute;
                                inset: 0;
                                z-index: -2;
                                backdrop-filter: blur(1em) brightness(6);
                                background-image: radial-gradient(circle at 50% 50%,
                                        #0000 0,
                                        #0000 2px,
                                        hsl(0 0 4%) 2px);
                                background-size: 8px 8px;
                            }

                            .container {
                                border-radius: 15px;
                                position: relative;
                                width: 100%;
                                height: 100%;
                                --c: rgba(59, 247, 100, 0.88);
                                background-color: #000;
                                background-image: radial-gradient(4px 100px at 0px 235px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 235px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 117.5px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 252px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 252px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 126px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 150px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 150px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 75px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 253px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 253px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 126.5px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 204px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 204px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 102px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 134px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 134px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 67px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 179px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 179px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 89.5px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 299px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 299px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 149.5px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 215px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 215px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 107.5px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 281px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 281px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 140.5px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 158px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 158px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 79px, var(--c) 100%, #0000 150%),
                                    radial-gradient(4px 100px at 0px 210px, var(--c), #0000),
                                    radial-gradient(4px 100px at 300px 210px, var(--c), #0000),
                                    radial-gradient(1.5px 1.5px at 150px 105px, var(--c) 100%, #0000 150%);
                                background-size:
                                    300px 235px,
                                    300px 235px,
                                    300px 235px,
                                    300px 252px,
                                    300px 252px,
                                    300px 252px,
                                    300px 150px,
                                    300px 150px,
                                    300px 150px,
                                    300px 253px,
                                    300px 253px,
                                    300px 253px,
                                    300px 204px,
                                    300px 204px,
                                    300px 204px,
                                    300px 134px,
                                    300px 134px,
                                    300px 134px,
                                    300px 179px,
                                    300px 179px,
                                    300px 179px,
                                    300px 299px,
                                    300px 299px,
                                    300px 299px,
                                    300px 215px,
                                    300px 215px,
                                    300px 215px,
                                    300px 281px,
                                    300px 281px,
                                    300px 281px,
                                    300px 158px,
                                    300px 158px,
                                    300px 158px,
                                    300px 210px,
                                    300px 210px,
                                    300px 210px;
                                animation: hi 150s linear infinite;
                            }

                            @keyframes hi {
                                0% {
                                    background-position:
                                        0px 220px,
                                        3px 220px,
                                        151.5px 337.5px,
                                        25px 24px,
                                        28px 24px,
                                        176.5px 150px,
                                        50px 16px,
                                        53px 16px,
                                        201.5px 91px,
                                        75px 224px,
                                        78px 224px,
                                        226.5px 350.5px,
                                        100px 19px,
                                        103px 19px,
                                        251.5px 121px,
                                        125px 120px,
                                        128px 120px,
                                        276.5px 187px,
                                        150px 31px,
                                        153px 31px,
                                        301.5px 120.5px,
                                        175px 235px,
                                        178px 235px,
                                        326.5px 384.5px,
                                        200px 121px,
                                        203px 121px,
                                        351.5px 228.5px,
                                        225px 224px,
                                        228px 224px,
                                        376.5px 364.5px,
                                        250px 26px,
                                        253px 26px,
                                        401.5px 105px,
                                        275px 75px,
                                        278px 75px,
                                        426.5px 180px;
                                }

                                to {
                                    background-position:
                                        0px 6800px,
                                        3px 6800px,
                                        151.5px 6917.5px,
                                        25px 13632px,
                                        28px 13632px,
                                        176.5px 13758px,
                                        50px 5416px,
                                        53px 5416px,
                                        201.5px 5491px,
                                        75px 17175px,
                                        78px 17175px,
                                        226.5px 17301.5px,
                                        100px 5119px,
                                        103px 5119px,
                                        251.5px 5221px,
                                        125px 8428px,
                                        128px 8428px,
                                        276.5px 8495px,
                                        150px 9876px,
                                        153px 9876px,
                                        301.5px 9965.5px,
                                        175px 13391px,
                                        178px 13391px,
                                        326.5px 13540.5px,
                                        200px 14741px,
                                        203px 14741px,
                                        351.5px 14848.5px,
                                        225px 18770px,
                                        228px 18770px,
                                        376.5px 18910.5px,
                                        250px 5082px,
                                        253px 5082px,
                                        401.5px 5161px,
                                        275px 6375px,
                                        278px 6375px,
                                        426.5px 6480px;
                                }
                            }

                            #boton_menu {
                                width: 100%;
                                height: 40px;
                                border: solid 2px black;
                                border-radius: 15px;
                                margin-top: 5px;
                                font-family: oswald;
                                font-size: 15px;
                                background: white;
                            }

                            #boton_menu2 {
                                width: 100%;
                                height: 40px;
                                border: solid 2px black;
                                border-radius: 15px;
                                margin-top: 5px;
                                font-family: oswald;
                                font-size: 15px;
                                background: white;
                            }

                            #boton_menu3 {
                                width: 100%;
                                height: 40px;
                                border: solid 2px black;
                                border-radius: 15px;
                                margin-top: 5px;
                                font-family: oswald;
                                font-size: 15px;
                                background: white;
                            }

                            #boton_menu:hover {
                                background: white;
                                cursor: pointer;
                                background: #AD0000;
                                transition: 1s;
                                color: white;

                            }

                            #boton_menu2:hover {
                                background: white;
                                cursor: pointer;
                                background: #AD0000;
                                transition: 1s;
                                color: white;

                            }

                            #boton_menu3:hover {
                                background: white;
                                cursor: pointer;
                                background: #AD0000;
                                transition: 1s;
                                color: white;

                            }

                            .enc {
                                width: 100%;
                                height: 80px;
                                font-family: oswald;
                                font-size: 14px;
                                color: white;

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
                                display: flex;
                                background: black;
                                background-size: 1600px 750px;

                            }

                            .enc_tabla {
                                width: 1500px;
                                height: 35px;
                                border: solid 2px black;
                                border-right: none;
                                display: flex;
                                margin-bottom: -2px;

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
                                border-right: solid 2px black;
                                border-bottom: solid 2px black;
                                font-family: "Arima", system-ui;
                                font-size: 14px;
                                color: black;
                            }

                            .informacion {
                                width: 1500px;
                                max-height: 600px;
                                display: inline-block;
                                border-left: solid 2px black;
                            }

                            .fila {
                                width: 100%;
                                height: 30px;
                                display: flex;

                            }

                            .infoev {
                                width: 270px;
                                height: 100%;
                                border-right: solid 2px white;
                                border-left: solid 2px white;
                                border-radius: 15px;
                                background: rgba(59, 247, 100, 0.88);
                                background: linear-gradient(0deg, rgba(59, 247, 100, 0.88) 0%, #000000 5%);
                            }

                            #imagen_f {
                                width: 150px;
                                height: 150px;
                                margin-top: 30px;

                            }

                            #imagen_f img {
                                display: block;
                                max-width: 100%;
                            }

                            #foto {
                                width: 150px;
                                height: 150px;
                                border-radius: 15px;
                                border-top: double 8px white;
                                border-bottom: double 8px rgba(59, 247, 100, 0.88);
                                border-left: double 8px white;
                                border-right: double 8px rgba(59, 247, 100, 0.88);
                            }

                            #texto {
                                width: 100%;
                                height: 30px;
                                font-family: oswald;
                                font-size: 14px;
                                color: white;
                            }

                            #separador {
                                width: 80%;
                                height: 3px;
                                background: linear-gradient(to right, white, rgba(59, 247, 100, 0.88));
                                margin-bottom: 10px;
                            }

                            .asignar_evaluador {
                                width: 1300px;
                                height: 100%;
                                display: block;
                            }

                            .asignar_evaluador p {
                                margin-top: 30px;
                                font-family: oswald;
                                font-size: 18px;
                                color: white;
                            }

                            .asignar_evaluador select {
                                font-family: oswald;
                                font-size: 16px;
                                background: white;
                                border-radius: 5px;
                            }

                            .asignar_evaluador input {
                                font-family: oswald;
                                font-size: 16px;
                                width: 250px;
                                border-radius: 5px;
                                text-align: center;
                            }

                            #bot_asig {
                                width: 120px;
                                height: 30px;
                                background: white;
                                border: none;
                                font-family: oswald;
                                font-size: 16px;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                border-radius: 5px;
                            }

                            #bot_asig:hover {
                                background: #296192;
                                color: white;
                                cursor: pointer;
                                transition: 1s;
                            }

                            .eval_resultado {
                                width: 1300px;
                                height: 100%;
                                border-radius: 15px;
                                margin-left: 10px;
                                display: inline-block;

                            }

                            #rubro_res {
                                width: 600px;
                                height: 32px;
                                border-bottom: solid 2px black;
                                font-family: "Arima", system-ui;
                                font-weight: bold;
                                font-size: 15px;
                                border-radius: 2px;
                                margin-bottom: 10px;
                                color: white;
                            }

                            #rubro_res input {
                                width: 250px;
                                height: 90%;
                                font-family: oswald;
                                font-size: 13px;
                                margin-left: 5px;
                                border-radius: 5px;
                                border: none;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;

                            }

                            #rubro_res option {
                                font-family: arima;
                                font-size: 14px;
                            }

                            #rubro_res input:focus {
                                border: solid 2px lightskyblue;
                                box-shadow: -3px 8px 0px -5px rgba(170, 209, 227, 0.23);
                                outline: none;
                            }

                            #separador2 {
                                width: 40%;
                                height: 7px;
                                background: rgba(59, 247, 100, 0.88);
                                background: linear-gradient(90deg, rgba(59, 247, 100, 0.88) 0%, #fff7f7 90%);
                                padding-top: 0;
                                margin-top: -10px;
                                border-radius: 10px;
                                margin-bottom: 20px;
                            }

                            .tabla_listado {
                                width: 700px;
                                height: 350px;
                                margin-top: 15px;
                            }

                            .enc_listado {
                                width: 100%;
                                height: 25px;
                                background: rgba(59, 247, 100, 0.88);
                                display: flex;
                            }

                            #enc_listado {
                                width: 33.333%;
                                height: 30px;
                                border-right: solid 2px whitesmoke;
                                color: white;
                                font-family: oswald;
                                font-size: 15px;
                            }

                            .opciones_res {
                                width: 100%;
                                height: 210px;
                                display: inline-block;
                                margin-bottom: 20px;
                            }

                            .opciones_resp {
                                width: 100%;
                                height: 25px;
                                border-bottom: solid 2px silver;
                                display: flex;
                            }

                            #opciones_resp {
                                width: 33.333%;
                                height: 100%;
                                font-family: arima;
                                font-size: 15px;
                                font-weight: bold;
                                color: white;

                            }

                            #chk {
                                width: 20px;
                                height: 100%;
                            }

                            #bt_g {
                                width: 110px;
                                height: 30px;
                                font-family: oswald;
                                font-size: 16px;
                                border: none;
                                box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                border-radius: 5px;
                            }

                            #bt_g:hover {
                                background: rgba(59, 247, 100, 0.88);
                                color: white;
                                transition: 1s;
                                cursor: pointer;

                            }
                        </style>
                        <?php if ($xUsr->xCurpEval == " " || $xUsr->xCurpEval == "0") { ?>
                            <style>
                                #menu2 {
                                    visibility: hidden;
                                }

                                .bt_mn {
                                    display: none;
                                }
                            </style>
                        <?php } ?>
                        <section class="contenido">

                            <section class="menu">
                                <div class="container">
                                    <div class="histor">
                                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                        <p> Historial de Evaluaciones Realizadas.</p>
                                    </div>
                                </div>
                            </section>
                            <section class="datos">
                                <section class="infoev">
                                    <br><br><br>
                                    <div id="imagen_f"> <img id="foto" src="<?php echo $xfoto; ?>"></div><br>
                                    <div id="texto"><?php echo "NOMBRE(S): " ?></div>
                                    <div id="texto"><?php echo $fila['nombre'] ?></div>
                                    <div id="separador"></div>
                                    <div id="texto"><?php echo "APELLIDOS: " ?></div>
                                    <div id="texto"><?php echo $fila['a_paterno'] . " " . $fila['a_materno'] ?></div>
                                    <div id="separador"></div>
                                    <div id="texto"><?php echo "CORPORACION: " ?></div>
                                    <div id="texto"><?php echo $corporacion ?></div>
                                    <div id="separador"></div>
                                    <div id="texto"><?php echo "TIPO DE EVALUACION: " ?></div>
                                    <div id="texto"><?php echo $tipoe ?></div>
                                    <div id="separador"></div>




                                </section>
                                <section class="todo">
                                    <section class="fila_m2">
                                        <?php while ($fila_id_rep = mysqli_fetch_assoc($resultado_rep)) { ?>
                                            <div class="carta" id="<?php echo $fila_id_rep['id_evaluacion'] ?>">
                                                <img src="<?php echo $xPath; ?>imgs/fondpd.jpg" alt="" class="img_re">
                                                <p id="txen">FECHA DE EVALUACION:<br><?php echo $fila_id_rep['fecha_reg'] ?></p>

                                            </div>
                                        <?php   } ?>
                                    </section>
                                    <section class="doc_inf" id="doc_inf">

                                    </section>
                                    <script>
                                            $(document).ready(function() {
                                                $(".carta").click(function() {
                                                    var id_evaluacion = $(this).attr("id");
                                                    var dataString = 'id_evaluacion=' + id_evaluacion;
                                                    url = "ajax_reportes_historial.php";
                                                    $.ajax({
                                                        type: "POST",
                                                        url: url,
                                                        data: dataString,
                                                        success: function(data) {
                                                            $('#doc_inf').html(data);
                                                        }
                                                    })
                                                })
                                            })
                                        </script>
                                    <style>
                                        .doc_inf 
                                        {
                                            width: 1300px;
                                            height: 650px;
                                        }
                                        
                                        .todo {
                                            width: 100%;
                                            display: inline-block;
                                            height: 100%;
                                            overflow-y: hidden;
                                        }

                                        .visor {
                                            width: 1300px;
                                            height: 550px;
                                            border: outset 2px black;
                                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                            background: rgb(50, 54, 52);
                                            overflow-y: scroll;

                                        }

                                        #txen {
                                            font-family: Oswald;
                                            font-size: 12px;
                                            color: white;
                                            width: 100%;
                                            height: 20px;
                                            border-bottom: -30px;
                                        }

                                        .img_re {
                                            width: 100%;
                                            height: 65px;
                                            border-top-left-radius: 10px;
                                            border-top-right-radius: 10px;
                                        }

                                        .carta {
                                            width: 200px;
                                            height: 110px;
                                            display: inline-block;
                                            border: solid 2px white;
                                            margin-left: 10px;
                                            border-radius: 10px;
                                            overflow: hidden;
                                            cursor: pointer;
                                        }
                                        
                                        

                                        

                                        .histor {
                                            width: 101%;
                                            height: 100%;
                                            background: black;
                                            opacity: 0.8;
                                        }

                                        .histor p {
                                            width: 100%;
                                            height: 50px;
                                            font-family: Oswald;
                                            font-size: 25px;
                                            color: white;
                                            opacity: 1;
                                        }

                                        .fila_m2 {
                                            width: 1300px;
                                            height: 20%;
                                            display: grid;
                                            grid-template-columns: repeat(7, 1fr);
                                            grid-gap: 10px;
                                            margin-top: 15px;
                                            margin-bottom: 15px;
                                            overflow-y: scroll;

                                        }
                                    </style>
                                </section>
                            </section>
    </body>
    <script>

    </script>

    </html>
    <?php ?>
<?php

} else
    header("Location: " . $xPath . "exit.php");
?>