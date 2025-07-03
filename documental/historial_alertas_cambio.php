<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for ($i = 0; $i < $xLEVEL; $i++)  $xPath .= "../";
//-------------------------------------------------------------//
if (isset($_SESSION["admitted_xsice"])) {
    include_once($xPath . "includes/xsystem.php");
    include_once($xPath . "includes/persona.class.php");
    include_once($xPath . "includes/evaluaciones.class.php");
    include_once($xPath . "includes/catalogos.class.php");
    include($xPath . "includes/integracion.class.php");
    include_once($xPath . "includes/psicologico.class.php");

    $xSys = new System();
    $xUsr = new Usuario();
    $xCat = new Catalog();

    //-------- Define el id del m�dulo y el perfil de acceso -------//
    if (isset($_GET["menu"])) {
        $_SESSION["menu"] = $_GET["menu"];
        $xInicio = 1;
    }
    if ($xUsr->xPerfil == 0)  $xUsr->getPerfil($_SESSION["menu"]);
    //--------------------------------------------------------------//

    //-- Define los directorios de scripts js y css...
    $cssPlantilla  = $xPath . "includes/xplantilla/sty_plantilla.css";
    $jsxResultados = $xPath . "includes/js/integracion/xresultados.js?v=" . rand();
} ?>
<!DOCTYPE html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title>SCC :: Menu principal</title>
    <link href="<?php echo $cssPlantilla; ?>" rel="stylesheet" type="text/css" />
    <!-- links css de actualizacion-->
    <?php $xSys->getLinks($xPath, 1); ?>
    <!-- scripts js de actualizacion-->
    <?php $xSys->getScripts($xPath, 1);  ?>
    <script src="alert/dist/sweetalert2.all.min.js"></script>
    <script src="alert/dist/sweetalert2.min.js"></script>
    <link rel="alert/dist/stylesheet" href="sweetalert2.min.css">
    <script language="javascript" src="<?php echo $jsxResultados; ?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            xShowMenu();
            xCtrl();
        });
    </script>
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
            <td>
                <?php
                ?>
            </td>
        </tr>

        <tr>
            <td align="center">
                <form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
                    <br><br>
                    <?php
                    //------------------- Muestra el t�tulo del m�dulo actual ------------------//
                    //-- Muestra el nombre del m�dulo actual, tomando la sesI&Oacute;N...
                    $xSys->getNameMod($_SESSION["menu"], "Editar Alerta.");
                    //--------------------------------------------------------------------------//
                    $user_perfil = $_GET["user"];

                    //------------------------ Recepcion de par�metros -------------------------//
                    if (isset($_GET["curp"])) {
                        $xPersona = new Persona($_GET["curp"]);
                        $_SESSION["xCurp"] = $xPersona->CURP;
                    } else
                        $xPersona = new Persona($_SESSION["xCurp"]);

                    $xEval = new Evaluaciones($xPersona->CURP);
                    //---------------------------------------------------CURP_EVAL-----------------------//
                    $xRMN = new Integracion($xPersona->CURP);
                    $DATA = $xRMN->getDatosInte();
                    $Datos = $xEval->getResultadoFinalEval();
                    $xPsico = new Psicologico($xPersona->CURP);
                    $xPsico->getDatosPsico();
                    $xMed = new Evaluaciones($_SESSION["xCurp"]);
                    $xMed->getResultadoFinalEval();
                    $xMed->getDatosMed();
                    $id = $_GET['id'];
                    $fecha_actual = date('Y-m-d');
                    $dbname = "bdceecc";
                    $dbuser = "root";
                    $dbhost = "localhost";
                    $dbpass = 'root';
                    $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                    $sql = "select id_alerta, descripcion, fecha from tbnew_alertariesgo where id_alerta='" . $id . "' ";
                    $resultado = mysqli_query($conexion, $sql);
                    $filas = mysqli_fetch_assoc($resultado);
                    ?>
                    <p id="enca"> EDITAR ALERTA DE RIESGO:</p>
                    <section class="alertas">
                        <div><textarea name="aler" id="al" cols="30" rows="10"><?php echo $filas['descripcion'] ?></textarea>
                    </section>
                    <?php
                    if (isset($_POST['guardar'])) {
                        $descripcion = $_POST['aler'];
                        $sql = "update tbnew_alertariesgo  set descripcion='" . $descripcion . "', fecha='" . $fecha_actual . "' where id_alerta='" . $id . "'";
                        $resed = mysqli_query($conexion, $sql);
                        if ($resed) {
                            echo "<script languaje='JavaScript'>
            alert('La alerta de riesgo se ha actualizado correctamente...');
            window.history.go(-1);
            </script>";
                        } else {
                            echo "<script languaje='JavaScript'>
            alert('La alerta no ha podido actualizarse...');
            window.history.back();
            </script>";
                        }
                    } ?>
                    <form class="form_e" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <section class="botones">
                            <div> <button name="guardar" id="guar">Guardar</button></div>
                            <a id="reg" href="historial_alertas.php">
                                <div id="regresar">
                                    <p id="regr"> Regresar</p>
                                </div>
                            </a>
                        </section>
                    </form>
                    <style>
                        #enca {
                            font-weight: bold;
                        }

                        #regr {
                            margin-top: 12px;
                        }

                        .botones {
                            width: 700px;
                            height: 100px;
                            display: flex;
                        }

                        .alertas {
                            width: 700px;
                            height: 200px;
                            display: flex;
                            border: solid 1px;
                        }

                        #al {
                            width: 700px;
                            height: 200px;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            text-align: justify;
                            font-size: 17px;
                        }

                        #guar {
                            width: 100px;
                            height: 50px;
                            background: white;
                            font-weight: bold;
                            border: solid 2px blue;
                            border-radius: 10%;
                            margin-left: 250px;
                            margin-top: 20px;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                        }

                        #guar:hover {
                            cursor: pointer;
                            color: white;
                            background: blue;
                            border: solid 2px white;
                        }

                        #regresar {
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

                        #regresar:hover {
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

                        #reg:hover {
                            color: white;
                            text-decoration: none;
                            font-weight: bold;
                        }
                    </style>