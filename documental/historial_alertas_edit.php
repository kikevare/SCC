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
                    $xSys->getNameMod($_SESSION["menu"], "Historial de alertas.");
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
                    $dbname = "bdceecc";
                    $dbuser = "root";
                    $dbhost = "localhost";
                    $dbpass = 'root';
                    $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                    $sql = "select id_alerta, descripcion,curp_evaluador, fecha from tbnew_alertariesgo where id_evaluacion='" . $id . "' ";
                    $resultado = mysqli_query($conexion, $sql);
                    ?>
                    <p id="enca"> Se han encontrado la(s) siguiente(s) alertas de riesgo de la evaluaci&oacute;n seleccionada:</p>
                    <section class="tab_enca">
                        <div id="nom">
                            <P id="encab"> DESCRIPCI&Oacute;N</P>
                        </div>
                        <div id="ap">
                            <P id="encab"> REALIZ&Oacute;</P>
                        </div>
                        <div id="am">
                            <P id="encab"> FECHA </P>
                        </div>
                        <div id="cor">
                            <P id="encab"> DEPARTAMENTO</P>
                        </div>
                        <div id="ev">
                            <P id="encab"> -</P>
                        </div>
                    </section>
                    <?php while ($filas = mysqli_fetch_assoc($resultado)) { ?>
                        <section class="tab_cont">
                            <section class="alertas">
                                <textarea name="desc" id="alert" cols="30" rows="10" readonly="readonly"><?php echo $filas['descripcion'] ?> </textarea>
                                <div id="rea">
                                    <p id="txt"><?php echo $filas['curp_evaluador'] ?></p>
                                </div>
                                <div id="fec">
                                    <p id="txt"><?php echo $filas['fecha'] ?></p>
                                </div>
                                <?php
                                if ("COSD770926HGRRNN19" == $filas['curp_evaluador'] || "RIGY871004MGRSRZ07" == $filas['curp_evaluador'] || "ROOR841127MGRMRF08" == $filas['curp_evaluador'] || "SARR850928HGRLYC05" == $filas['curp_evaluador'] || "MAAV890507MGRRLR03" == $filas['curp_evaluador'] || "SOVL851226MGRLLS09" == $filas['curp_evaluador']) {
                                ?>
                                    <div id="dep">
                                        <p id="txt">INTEGRACION DE RESULTADOS.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                if ("VAGE811102HGMGRL01" == $filas['curp_evaluador'] || "AEAI820916HDFNNS00" == $filas['curp_evaluador'] || "AUFI820831HDFRLV01" == $filas['curp_evaluador'] || "FEGM880122MGRLRR12" == $filas['curp_evaluador'] || "CAFN920808HMSSJL09" == $filas['curp_evaluador'] || "MAAA870123HGRRVL06" == $filas['curp_evaluador'] || "GOAS851006MGRMRN02" == $filas['curp_evaluador'] || "LOMJ900927HGRPRS07" == $filas['curp_evaluador'] || "AECY820421MGRRSL09" == $filas['curp_evaluador'] || "VAAG830703MDFZLL05" == $filas['curp_evaluador'] || "AANA850512MGRVBN04" == $filas['curp_evaluador'] || "JEAM890927MGRSNR02" == $filas['curp_evaluador'] || "MAMA861016HCMRGR06" == $filas['curp_evaluador'] || "VEZF850419HNELLR09" == $filas['curp_evaluador']) {
                                ?>
                                    <div id="dep">
                                        <p id="txt">POLIGRAFIA.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                if ("PIAP860629HGRNBD05" == $filas['curp_evaluador'] || "VELM821218MGRG2R02" == $filas['curp_evaluador'] || "BUCK860720MGRNRN04" == $filas['curp_evaluador'] || "DOMJ860525HGRMRR02" == $filas['curp_evaluador'] || "RAOL801104MGRMRZ04" == $filas['curp_evaluador'] || "AOGB800402MGRLTN00" == $filas['curp_evaluador'] || "MOMT830107MGRNNR05" == $filas['curp_evaluador'] || "CXGA871205HGRBRN06" == $filas['curp_evaluador']) {
                                ?>
                                    <div id="dep">
                                        <p id="txt">QUIMICO.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                if ("AUHE871116MMCSRR08" == $filas['curp_evaluador'] || "CUCG830320MVZRRM07" == $filas['curp_evaluador'] || "SAAZ790410MGRNRL03" == $filas['curp_evaluador'] || "CAPV890619HGRTRC08" == $filas['curp_evaluador']) {
                                ?>
                                    <div id="dep">
                                        <p id="txt">MEDICO.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                if (
                                    "FICN870725MGRRLL09" == $filas['curp_evaluador'] || "EAHA891125MGRSRL03" == $filas['curp_evaluador'] || "GOAA820123HGRNRL05" == $filas['curp_evaluador'] || "AAAE870517MGRBLS07" == $filas['curp_evaluador'] || "TOGF690510HGRRRL07" == $filas['curp_evaluador'] || "BAGK910624MGRTRR03" == $filas['curp_evaluador'] || "AOFJ801110HGRPGS08" == $filas['curp_evaluador'] || "GAMS910706MGRRRN08" == $filas['curp_evaluador'] || "VIAB870125MGRCVL07" == $filas['curp_evaluador'] || "MAFA880925MGRRLB01" == $filas['curp_evaluador'] || "FINL760226MGRSVD01" == $filas['curp_evaluador'] || "PANE880217MGRBVR00" == $filas['curp_evaluador'] || "COAC920901HGRCNH00" == $filas['curp_evaluador'] || "CURT761015MGRRZR02" == $filas['curp_evaluador']
                                    || "BATM910905MMCRRG07" == $filas['curp_evaluador'] || "AURN790731MGRGVL02" == $filas['curp_evaluador'] || "RESC910503MGRYLR04" == $filas['curp_evaluador'] || "MAAI810923HGRRVD00" == $filas['curp_evaluador']
                                ) {
                                ?>
                                    <div id="dep">
                                        <p id="txt">ENTORNO SOCIAL.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                if ("BAHB861219MGRRRR08" == $filas['curp_evaluador'] || "OEPR870808HGRRTB04" == $filas['curp_evaluador'] || "IAAM841106MGRCDR03" == $filas['curp_evaluador'] || "BUBA971224MGRNSR01" == $filas['curp_evaluador'] || "AALA860424MOCPNG01" == $filas['curp_evaluador'] || "SANA711222MGRNRN05" == $filas['curp_evaluador'] || "HEHE880204MGRRRV06" == $filas['curp_evaluador'] || "ROCA950119MGRSVT07" == $filas['curp_evaluador'] || "CAHX850121MMGHRT02" == $filas['curp_evaluador'] || "GABF890321HGRRTR00" == $filas['curp_evaluador'] || "RACK931128MGRMRR02" == $filas['curp_evaluador'] || "MOPB870611MGRRCR02" == $filas['curp_evaluador'] || "LABE881021MGRRRL08" == $filas['curp_evaluador']) {
                                ?>
                                    <div id="dep">
                                        <p id="txt">PSICOLOGIA.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                if ($xUsr->xCurpEval == $filas['curp_evaluador']) {
                                ?>
                                    <div id="ed"> <a id="edit" href="historial_alertas_cambio.php?id=<?php echo $filas['id_alerta'] ?>">
                                            <p id="editar"> <img src="<?php echo $xPath; ?>imgs/edtr.png" alt="" width="37px"></p>
                                        </a></div>
                                <?php } ?>
                            </section>
                        </section>
                    <?php
                    }
                    ?>
                    <section class="boton">
                        <a id="reg" href="historial_alertas.php">
                            <div id="regresar">
                                <p id="regr"> Regresar</p>
                            </div>
                        </a>
                    </section>
                    <style>
                        #encab {
                            font-weight: bold;
                            font-size: 12px;
                            font-family: Arial, Helvetica, sans-serif;
                            text-align: left;
                            margin-top: 5px;
                            margin-left: 5px;
                        }

                        #txt {
                            font-weight: bold;
                            font-size: 12px;
                            font-family: Arial, Helvetica, sans-serif;
                            text-align: center;
                            margin-top: 15px;
                            margin-left: 5px;
                        }

                        .tab_enca {
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

                        #nom {
                            width: 20%;
                            height: 40px;
                            border-right: solid 0.5px black;
                            background: #01579B;
                        }

                        #ap {
                            width: 20%;
                            height: 40px;
                            border-right: solid 0.5px black;
                            display: flex;
                            background: #01579B;
                        }

                        #am {
                            width: 20%;
                            height: 40px;
                            border-right: solid 0.5px black;
                            display: flex;
                            background: #01579B;
                        }

                        #cor {
                            width: 20%;
                            height: 40px;
                            border-right: solid 0.5px black;
                            display: flex;
                            background: #01579B;
                        }

                        #ev {
                            width: 20%;
                            height: 40px;
                            border-right: solid 0.5px black;
                            display: flex;
                            background: #01579B;
                        }

                        .tab_cont {
                            display: block;
                            width: 100%;
                            height: 100%;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;

                        }

                        #enca {
                            font-weight: bold;
                        }

                        .boton {
                            width: 100px;
                            height: 50px;
                            margin-top: 20px;
                        }

                        #regr {
                            margin-top: 12px;
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

                        .alertas {
                            width: 100%;
                            height: 50px;
                            border: solid 1px black;
                            display: flex;
                            font-weight: bold;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;

                            background: white;

                        }

                        #alert {
                            width: 20%;
                            height: auto;
                            border: none;
                            text-align: justify;
                            background: white;
                        }

                        #rea {
                            width: 20%;
                            height: auto;
                            border: solid 0.5px;
                        }

                        #fec {
                            width: 20%;
                            height: auto;
                            border: solid 0.5px;
                        }

                        #dep {
                            width: 20%;
                            height: auto;
                            border: solid 0.5px;
                        }

                        #ed {
                            width: 20%;
                            height: auto;
                            border: solid 0.5px;
                        }
                    </style>