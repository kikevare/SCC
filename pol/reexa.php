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
                            $dbname = "bdceecc";
                            $dbuser = "root";
                            $dbhost = "localhost";
                            $dbpass = 'root';
                            /*$dbname = "bdceecc";
                            $dbuser = "root";
                            $dbhost = "10.24.2.25";
                            $dbpass = '4dminMy$ql$';*/
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
                            $sqlev2 = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id_evaluacion'";
                            $resultado_ev2 = mysqli_query($conexion, $sqlev2);
                            $fila_ev2 = mysqli_fetch_assoc($resultado_ev2);
                            $sql_resultado = "SELECT obs_supervisor,descrip_resultado, id_resultado, id_resultado_loc,observaciones, delitos_admision, delitos_deteccion, drogas_admision, drogas_deteccion, delincuencia_admision, delincuencia_deteccion, informacion_admision, informacion_deteccion, beneficios_admision, beneficios_deteccion, otros_admision, otros_deteccion, alcohol_admision, alcohol_deteccion, actividades_admision, actividades_deteccion from poligrafia_evnu_rex where id_evaluacion = '" . $id_evaluacion . "'";
                            $resultado_res = mysqli_query($conexion, $sql_resultado);
                            $fila_resultado = mysqli_fetch_assoc($resultado_res);
                            $sql_reporte = "SELECT evaluaciones_anteriores,trayectoria_laboral,situacion_patrimonial,analisis_tecnico,conclusion,admision,observacion  from  reporte_pol_rex where id_evaluacion = '$id_evaluacion'";
                            $resultado_reporte = mysqli_query($conexion, $sql_reporte);
                            $fila_reporte = mysqli_fetch_assoc($resultado_reporte);
                            $sql_indice = "SELECT reporte,hojagra,datosgen,proteccion,autorizacion,autorizacion_areas,antecedentes,entrevista,serie,hojacomen,alerta,revision,apeva,total,hojapreg from  indice_polnu_rex where id_evaluacion = '$id_evaluacion'";
                            $resultado_indice = mysqli_query($conexion, $sql_indice);
                            $fila_indice = mysqli_fetch_assoc($resultado_indice);
                            $sql_his = "select * from reporte_polhis_rexa where id_evaluacion = '$id_evaluacion'";
                            $resultado_his = mysqli_query($conexion, $sql_his);
                            function estadoevaluacion($id_evaluacion, $conexion)
                        {
                            $sql = "SELECT estado from poligrafia_evnu_rex where id_evaluacion='$id_evaluacion'";
                            $resultado = mysqli_query($conexion, $sql);
                            $fila = mysqli_fetch_assoc($resultado);
                            $estado = $fila['estado'];
                            if ($estado == '1') {
                                echo "La evaluacion se encuentra con el Evaluador";
                            }
                            if ($estado == '2') {
                                echo "La evaluacion esta en proceso de Supervision";
                            }
                            if ($estado == '4') {
                                echo "La evaluacion ha sido finalizada...";
                            }
                        }
                            function historial_reporte($id_evaluacion, $conexion)
                            {
                                $sql = "select * from reporte_polhis_rexa where id_evaluacion = '$id_evaluacion'";
                                $resultado = mysqli_query($conexion, $sql);
                                $contador = 0;
                                while ($fila = mysqli_fetch_assoc($resultado)) {
                            ?>

                                <option value="<?php echo $fila['id_historial'] ?>" selected="selected">
                                    <?php echo  $contador = $contador + 1 ?></option>
                            <?php   }
                            }
                            function solicita($curp, $conexion)
                            {
                                $sql1 = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$curp'";
                                $resultado_n = mysqli_query($conexion, $sql1);
                                $oficio_r = mysqli_fetch_assoc($resultado_n);
                                $nombre = $oficio_r['nombre'] . " " . $oficio_r['a_paterno'] . " " . $oficio_r['a_materno'];
                                echo $nombre;
                            }
                            function obtener_ev($id_evaluacion, $conexion)
                            {
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id_evaluacion'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $evaluador = $fila_ev['curp_evaluador'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];
                                echo $nombre;
                            }
                            function obtener_sup($id_evaluacion, $conexion)
                            {
                                $sqlev = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu_rex where id_evaluacion = '$id_evaluacion'";
                                $resultado_ev = mysqli_query($conexion, $sqlev);
                                $fila_ev = mysqli_fetch_assoc($resultado_ev);
                                $supervisor = $fila_ev['curp_supervisor'];

                                $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$supervisor'";
                                $resultado_eval = mysqli_query($conexion, $sqleval);
                                $fila_evalu = mysqli_fetch_assoc($resultado_eval);
                                $nombre = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];
                                echo $nombre;
                            }
                            function obtener_alertas($conexion, $id_evaluacion, $xPath)
                            {
                                $sql_alertas = "SELECT id_alerta, id_evaluacion, descripcion, curp_evaluador from tbnew_alertariesgo where id_evaluacion='$id_evaluacion'";
                                $resultado_alerta = mysqli_query($conexion, $sql_alertas); ?>
                            <style>
                                .alertas_riesgo {
                                    width: 1300px;
                                    height: 90%;
                                    margin-left: 10px;
                                    margin-top: 10px;
                                    display: grid;
                                    grid-template-columns: repeat(4, 1fr);
                                    grid-gap: 20px;

                                }

                                #alerta_r {
                                    width: 600px;
                                    height: 300px;
                                    font-size: 18px;
                                    font-family: oswald;
                                    color: black;
                                    margin-left: 300px;
                                    margin-top: 100px;
                                    position: relative;
                                }

                                .alerta_des {
                                    width: 100%;
                                    height: 85%;
                                    font-family: arima;
                                    font-size: 13px;
                                    font-weight: bold;
                                    overflow-y: scroll;
                                    color: white;
                                }

                                .departamento {
                                    font-family: oswald;
                                    font-size: 13px;
                                    color: white;
                                    border-top: solid 1px silver;
                                }

                                .alerta_des::-webkit-scrollbar {
                                    display: none;
                                }
                            </style>

                            <section class="alertas_riesgo">
                                <?php if (empty($resultado_alerta)) { ?>
                                    <div id="alerta_r">
                                        <img src="<?php echo $xPath; ?>imgs/icono_al.png" width="120px">
                                        <p> El evaluado no tiene alertas de riesgo...</p>
                                    </div>
                                    <?php    } else {
                                    while ($fila_alerta = mysqli_fetch_assoc($resultado_alerta)) {
                                        $sql_evalarea = " SELECT curp_evaluador from tbnew_alertariesgo where id_alerta='" . $fila_alerta['id_alerta'] . "' ";
                                        $resultado_evalarea = mysqli_query($conexion, $sql_evalarea);
                                        $fila_evalarea = mysqli_fetch_assoc($resultado_evalarea);
                                        $curp_ea = $fila_evalarea['curp_evaluador'];
                                        $sql_departamento = " SELECT id_area from tbevaluadores where curp_evaluador='$curp_ea'";
                                        $resultado_departamento = mysqli_query($conexion, $sql_departamento);
                                        $fila_departamento = mysqli_fetch_assoc($resultado_departamento);
                                        $id_dep = $fila_departamento['id_area'];
                                        $sql_area = "SELECT area_eval from ctareaseval where id_area = '$id_dep'";
                                        $resultado_area = mysqli_query($conexion, $sql_area);
                                        $fila_area = mysqli_fetch_assoc($resultado_area);
                                        $nombre_area = $fila_area['area_eval']; ?>
                                        <div class="tarjeta_alerta<?php echo $id_dep ?>">
                                            <div class="card3">
                                                <div class="alerta_des">
                                                    <p
                                                        style="text-align: center; width: 90%; height: 100%; margin-left: 5px; margin-top: 5px; margin-right: 5px;">
                                                        <?php echo utf8_decode($fila_alerta['descripcion'])  ?></p>
                                                </div>
                                                <div class="departamento">
                                                    <p style="text-align: center; margin-top: 10px"><?php echo $nombre_area ?></p>
                                                </div>
                                            </div>
                                        </div>


                                        <?php if ($id_dep == 1) { ?>
                                            <style>
                                                .tarjeta_alerta1 {
                                                    width: 230px;
                                                    height: 300px;
                                                    border-radius: 15px;
                                                    transform: scale(0.9);
                                                    display: inline-block;
                                                    background: #fff7f7;
                                                    color: black;
                                                    background-image: linear-gradient(163deg, #033865 0%, #fff7f7 100%);
                                                    /*background: linear-gradient(1deg, #033865 0%, #fff7f7 22%);*/
                                                    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                                    transition: all 1.5s;
                                                }

                                                .tarjeta_alerta1:hover {
                                                    cursor: pointer;
                                                    position: relative;
                                                    width: 400px;
                                                    transition: 1.5s;
                                                    box-shadow: 0px 0px 30px 1px #033865;
                                                    transform: skew(0deg);

                                                }
                                            </style>
                                        <?php   }  ?>
                                        <?php if ($id_dep == 2) { ?>
                                            <style>
                                                .tarjeta_alerta2 {
                                                    width: 230px;
                                                    height: 300px;
                                                    border-radius: 15px;
                                                    transform: scale(0.9);
                                                    display: inline-block;
                                                    background: #fff7f7;
                                                    background-image: linear-gradient(163deg, #310365 0%, #fff7f7 100%);
                                                    /* background: linear-gradient(1deg, #310365 0%, #fff7f7 22%);*/
                                                    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                                    transition: all 1.5s;

                                                }

                                                .tarjeta_alerta2:hover {
                                                    cursor: pointer;
                                                    transform: skew(0deg);
                                                    position: relative;
                                                    width: 400px;
                                                    transition: 1.5s;
                                                    box-shadow: 0px 0px 30px 1px #310365;

                                                }
                                            </style>
                                        <?php   }  ?>
                                        <?php if ($id_dep == 3) { ?>
                                            <style>
                                                .tarjeta_alerta3 {
                                                    width: 230px;
                                                    height: 300px;
                                                    border-radius: 15px;
                                                    transform: scale(0.9);
                                                    display: inline-block;
                                                    background: #fff7f7;
                                                    background-image: linear-gradient(163deg, #b40242 0%, #fff7f7 100%);
                                                    /* background: linear-gradient(1deg, #b40242 0%, #fff7f7 22%);*/
                                                    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                                    transition: all 1.5s;

                                                }

                                                .tarjeta_alerta3:hover {
                                                    cursor: pointer;
                                                    transform: skew(0deg);
                                                    position: relative;
                                                    width: 400px;
                                                    transition: 1.5s;
                                                    box-shadow: 0px 0px 30px 1px #b40242;

                                                }
                                            </style>
                                        <?php   }  ?>
                                        <?php if ($id_dep == 4) { ?>
                                            <style>
                                                .tarjeta_alerta4 {
                                                    width: 230px;
                                                    height: 300px;
                                                    border-radius: 15px;
                                                    transform: scale(0.9);
                                                    display: inline-block;
                                                    background: #fff7f7;
                                                    background-image: linear-gradient(163deg, #717601 0%, #fff7f7 100%);
                                                    /*background: linear-gradient(1deg, #717601 0%, #fff7f7 23%);*/
                                                    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                                    transition: all 1.5s;

                                                }

                                                .tarjeta_alerta4:hover {
                                                    cursor: pointer;
                                                    transform: skew(0deg);
                                                    position: relative;
                                                    width: 400px;
                                                    transition: 1.5s;
                                                    box-shadow: 0px 0px 30px 1px #717601;

                                                }
                                            </style>
                                        <?php   }  ?>

                                        <?php if ($id_dep == 7) { ?>
                                            <style>
                                                .tarjeta_alerta7 {
                                                    width: 230px;
                                                    height: 300px;
                                                    border-radius: 15px;
                                                    transform: scale(0.9);
                                                    display: inline-block;
                                                    background: #fff7f7;
                                                    background-image: linear-gradient(163deg, #0b7103 0%, #fff7f7 100%);
                                                    /*background: linear-gradient(1deg, #0b7103 0%, #fff7f7 23%);*/
                                                    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                                    transition: all 1.5s;

                                                }

                                                .tarjeta_alerta7:hover {
                                                    cursor: pointer;
                                                    transform: skew(0deg);
                                                    position: relative;
                                                    width: 400px;
                                                    transition: 1.5s;
                                                    box-shadow: 0px 0px 30px 1px #0b7103;

                                                }
                                            </style>
                                        <?php   }  ?>

                                        <?php if ($id_dep == 5) {  ?>
                                            <style>
                                                .tarjeta_alerta5 {
                                                    width: 230px;
                                                    height: 300px;
                                                    border-radius: 15px;
                                                    display: inline-block;
                                                    background: #650603;
                                                    background-image: linear-gradient(163deg, #650603 0%, #fff7f7 100%);
                                                    /* background: linear-gradient(1deg, #650603 0%, #ffffff 23%);*/
                                                    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                                                    transform: scale(0.9);
                                                    transition: all 1.5s;

                                                }

                                                .tarjeta_alerta5:hover {
                                                    cursor: pointer;
                                                    border: none;
                                                    position: relative;
                                                    width: 400px;
                                                    transition: 1.5s;
                                                    box-shadow: 0px 0px 30px 1px #650603;
                                                    transform: skew(0deg);


                                                }
                                            </style>

                                <?php  }
                                    }
                                } ?>

                            </section> <?php  } ?>


                        <script>
                            tinymce.init({
                                selector: '#obs',
                                max_height: 300,
                                resize: false,
                                plugins: [

                                    // Core editing features
                                    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link',
                                    'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                                    // Your account includes a free trial of TinyMCE premium features
                                    // Try the most popular premium features until Nov 26, 2024:
                                    'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed',
                                    'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable',
                                    'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments',
                                    'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography',
                                    'inlinecss', 'markdown',
                                    // Early access to document converters
                                    'importword', 'exportword', 'exportpdf'

                                ],
                                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                                tinycomments_mode: 'embedded',
                                tinycomments_author: 'Author name',
                                mergetags_list: [{
                                        value: 'First.Name',
                                        title: 'First Name'
                                    },
                                    {
                                        value: 'Email',
                                        title: 'Email'
                                    },
                                ],
                                ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                                    'See docs to implement AI Assistant')),
                                exportpdf_converter_options: {
                                    'format': 'Letter',
                                    'margin_top': '1in',
                                    'margin_right': '1in',
                                    'margin_bottom': '1in',
                                    'margin_left': '1in'
                                },
                                exportword_converter_options: {
                                    'document': {
                                        'size': 'Letter'
                                    }
                                },
                                importword_converter_options: {
                                    'formatting': {
                                        'styles': 'inline',
                                        'resets': 'inline',
                                        'defaults': 'inline',
                                    }
                                },
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea2',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea3',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea4',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea5',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea6',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>
                        <script>
                            tinymce.init({
                                content_css: "/mycontent.css",
                                language: 'es_MX',
                                selector: '#txtarea7',
                                height: 300,
                                fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                fontsize: '6pt',

                                menubar: false,
                                setup: function(editor) {
                                    editor.on('change', function() {
                                        tinymce.triggerSave();
                                    });
                                },
                                plugins: [
                                    'print preview anchor ',
                                    'searchreplace visualblocks advcode fullscreen',
                                    'paste tinycomments',
                                    'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                    'wordcount formatpainter permanentpen pageembed checklist casechange'

                                ],
                                toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                toolbar_drawer: 'sliding',
                                permanentpen_properties: {
                                    fontname: 'helvetica,sans-serif,arial',
                                    forecolor: '#FF0000',
                                    fontsize: '6pt',
                                    hilitecolor: '',
                                    bold: true,
                                    italic: false,
                                    strikethrough: false,
                                    underline: false
                                },
                                tinycomments_mode: 'embedded',
                                tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                powerpaste_allow_local_images: true,
                                powerpaste_word_import: 'prompt',
                                powerpaste_html_import: 'prompt',
                                spellchecker_language: 'es',
                                spellchecker_dialog: true,
                                browser_spellcheck: true,
                                content_css: [
                                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                    '//www.tinymce.com/css/codepen.min.css'
                                ]
                            });
                        </script>

                        <div id="modal1" class="modalmask">
                            <div class="modalbox movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <p id="tx_info">Alerta de riesgo:</p>
                                <div id="are_insert1">
                                    <p> Realizo: </p> <input name="area_in" type="text"
                                        value="<?php echo solicita($xUsr->xCurpEval, $conexion) ?>"
                                        style="font-family: arima; font-size: 14px; font-weight: bold;" readonly>
                                </div>
                                <div>
                                    <p>Descripcion: </p>
                                </div>
                                <div>
                                    <textarea name="alerta" id=""
                                        style="width: 100%; font-family: arima; font-size: 13px; height: 100px"></textarea>
                                </div>
                                <br><button type="submit" name="guardar_modal" id="b_modal1">Guardar</button>
                            </div>

                        </div>
                        <div id="modal2" class="modalmask">
                            <div class="modalbox movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <p style="font-family: oswald; font-size: 16px">Evaluador:</p>
                                <select name="evaluador_1" id=""
                                    style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                    <option value="">-SELECCIONE-</option>
                                    <option value="AECY820421MGRRSL09">YULIANA PAULINA ARREOLA CASTRO</option>
                                    <option value="AANA850512MGRVBN04">ANA LAURA ABARCA NAVA</option>
                                    <option value="MAAA870123HGRRVL06">ALFONSO MARINO AVILA</option>
                                    <option value="VAGE811102HGMGRL01">ELIZABETH VAZQUEZ GERONIMO</option>
                                    <option value="JEAM890927MGRSNR02">MARISELA DE JESUS ANTONIO</option>
                                    <option value="ROLM980228HGRJPN07">JOSE MANUEL ROJAS LOPEZ</option>
                                    <option value="AUFI820831HDFRLV01">IVAN TADEO ARGUELLO FALCON</option>
                                    <option value="VEZF850419HNELLR09">FRANCISCO GABRIEL VELAZQUEZ ZELAYA</option>
                                    <option value="GOAS851006MGRMRN02">SANDRA LUZ GOMEZ ARROYO</option>
                                    <option value="LOMJ900927HGRPRS07">JEISON LOPEZ MORALES</option>
                                    <option value="FEGM880122MGRLRR12">MARICRUZ FELIX GARCIA</option>
                                </select>
                                <p style="font-family: oswald; font-size: 16px">Supervisor:</p>
                                <select name="supe_1" id=""
                                    style="font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
                                    <option value="">-SELECCIONE-</option>
                                    <option value="FEGM880122MGRLRR12">MARICRUZ FELIX GARCIA</option>
                                    <option value="LOMJ900927HGRPRS07">JEISON LOPEZ MORALES</option>
                                    <option value="GOAS851006MGRMRN02">SANDRA LUZ GOMEZ ARROYO</option>
                                </select>
                                <br><br><button type="submit" name="guardar_modal2" id="b_modal1">Guardar</button>
                            </div>

                        </div>
                        <div id="modal3" class="modalmask">
                            <div class="modalbox2 movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <?php $contador = 0;
                                while ($fila_his = mysqli_fetch_assoc($resultado_his)) {
                                    $contador = $contador + 1;  ?>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_t<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_tl<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_ta<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_to<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_ts<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_tat<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <script>
                                        tinymce.init({
                                            content_css: "/mycontent.css",
                                            language: 'es_MX',
                                            selector: '#txtarea_tc<?php echo $contador ?>',
                                            height: 300,
                                            fontsize_formats: "5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt ",
                                            fontsize: '6pt',

                                            menubar: false,
                                            plugins: [
                                                'print preview anchor ',
                                                'searchreplace visualblocks advcode fullscreen',
                                                'paste tinycomments',
                                                'insertdatetime media table contextmenu powerpaste  a11ychecker linkchecker mediaembed',
                                                'wordcount formatpainter permanentpen pageembed checklist casechange'

                                            ],
                                            toolbar: ' fontselect fontsizeselect| bold italic    |formatpainter permanentpen forecolor backcolor  | alignleft aligncenter alignright alignjustify | addcomment showcomments| casechange |bullist numlist outdent indent |  link image | advcode spellchecker a11ycheck | code | checklist | styleselect ',
                                            toolbar_drawer: 'sliding',
                                            permanentpen_properties: {
                                                fontname: 'helvetica,sans-serif,arial',
                                                forecolor: '#FF0000',
                                                fontsize: '6pt',
                                                hilitecolor: '',
                                                bold: true,
                                                italic: false,
                                                strikethrough: false,
                                                underline: false
                                            },
                                            tinycomments_mode: 'embedded',
                                            tinycomments_author: '<?php echo solicita($xUsr->xCurpEval, $conexion); ?>',
                                            table_toolbar: "tableprops cellprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
                                            powerpaste_allow_local_images: true,
                                            powerpaste_word_import: 'prompt',
                                            powerpaste_html_import: 'prompt',
                                            spellchecker_language: 'es',
                                            spellchecker_dialog: true,
                                            browser_spellcheck: true,
                                            content_css: [
                                                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                                                '//www.tinymce.com/css/codepen.min.css'
                                            ]
                                        });
                                    </script>
                                    <section class="hoja">
                                        <section class="membrete">
                                            <div class="imagen_mem"><img src="<?php echo $xPath; ?>imgs/NEscudo.png" alt=""
                                                    width="240px" height="100%" style="margin-left: 5px;">
                                            </div>
                                            <div class="titulo_mem">CENTRO ESTATAL DE EVALUACION Y CONTROL DE
                                                CONFIANZA DEL ESTADO DE GUERRERO</div>
                                            <div class="imagen_mem"><img src="<?php echo $xPath; ?>imgs/secretariado.jpg" alt=""
                                                    width="240px" height="100%" style="margin-left: 5px;"></div>
                                        </section>
                                        <section class="tabla_datosdoc">
                                            <div id="filas_datos">
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Motivo de Evaluacion</p>

                                                <p
                                                    style="width: 30%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $tipoe ?></p>
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Fecha de Evaluacion</p>

                                                <p
                                                    style="width: 20%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $fila['fecha'] ?></p>
                                            </div>

                                            <div id="filas_datos">
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Nombre</p>

                                                <p
                                                    style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $fila['nombre'] . " " . $fila['a_paterno'] . " " . $fila['a_materno'] ?>
                                                </p>
                                            </div>
                                            <div id="filas_datos">
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    RFC</p>

                                                <p
                                                    style="width: 30%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $fila4['rfc'] ?></p>
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Edad</p>

                                                <p
                                                    style="width: 20%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $edad . " " . utf8_decode("años") ?></p>
                                            </div>
                                            <div id="filas_datos">
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Dependencia</p>

                                                <p
                                                    style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $corporacion ?></p>
                                            </div>
                                            <div id="filas_datos">
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Categoria</p>

                                                <p
                                                    style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $fila['categoria'] ?></p>
                                            </div>
                                            <div id="filas_datos">
                                                <p
                                                    style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Cargo Especifico</p>

                                                <p
                                                    style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                    <?php echo $fila['categoria'] ?></p>
                                            </div>
                                            <div id="filas_datos">
                                                <p
                                                    style="width: 100%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                    Este reporte es estrictamente confidencial</p>
                                            </div>
                                        </section>
                                        <section class="inforep">
                                            <p
                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                Evaluaciones Anteriores</p>
                                            <textarea
                                                id="txtarea_t<?php echo $contador ?>"><?php echo $fila_his['evaluaciones_anteriores'] ?></textarea>
                                        </section>
                                        <section class="inforep">
                                            <p
                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                Trayectoria Laboral</p>
                                            <textarea
                                                id="txtarea_tl<?php echo $contador ?>"><?php echo $fila_his['trayectoria_laboral'] ?></textarea>
                                        </section>
                                        <?php if ($fila6['admision'] != "" || $fila6['admision'] != null) { ?>
                                            <section class="inforep">
                                                <p
                                                    style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                    Admision</p>
                                                <textarea
                                                    id="txtarea_ta<?php echo $contador ?>"><?php echo $fila_his['admision'] ?> </textarea>
                                            </section>
                                        <?php } ?>
                                        <?php if ($fila6['observacion'] != "" || $fila6['observacion'] != null) { ?>
                                            <section class="inforep">
                                                <p
                                                    style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                    Observacion</p>
                                                <textarea
                                                    id="txtarea_to<?php echo $contador ?>"><?php echo $fila_his['observacion'] ?></textarea>
                                            </section>
                                        <?php } ?>

                                        <section class="inforep">
                                            <p
                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                Situacion Patrimonial</p>
                                            <textarea
                                                id="txtarea_ts<?php echo $contador ?>"><?php echo $fila_his['situacion_patrimonial'] ?></textarea>
                                        </section>
                                        <section class="inforep">
                                            <p
                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                Analisis Tecnico</p>
                                            <textarea
                                                id="txtarea_tat<?php echo $contador ?>"><?php echo $fila_fis['analisis_tecnico'] ?></textarea>
                                        </section>
                                        <section class="inforep">
                                            <p
                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                SINTESIS TECNICA:</p>
                                            <textarea
                                                id="txtarea_tc<?php echo $contador ?>"><?php echo $fila_his['conclusion'] ?></textarea>
                                        </section>
                                    </section>
                                    <p style="font-family: oswald; font-size: 17px">Siguiente Hoja de Correcciones.</p>
                                <?php  } ?>
                            </div>

                        </div>

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
                                /* background: url("<?php echo $xPath; ?>imgs/fnea.jpg");*/
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
                                --c: #FF0000;
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
                                border-radius: 5px;
                                margin-top: 5px;
                                font-family: oswald;
                                font-size: 15px;
                                background: black;
                                color: white;
                                z-index: -2;
                                opacity: 0.9;
                            }

                            #boton_menu2 {
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
                                opacity: 0.9;
                            }

                            #boton_menu3 {
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
                                opacity: 0.9;
                            }

                            #boton_menu:hover {
                                background: white;
                                cursor: pointer;
                                background: #AD0000;
                                transition: 1s;
                                color: white;
                                border: none;
                                opacity: 1;

                            }

                            #boton_menu2:hover {
                                background: white;
                                cursor: pointer;
                                background: #AD0000;
                                transition: 1s;
                                color: white;
                                border: none;
                                opacity: 1;

                            }

                            #boton_menu3:hover {
                                background: white;
                                cursor: pointer;
                                background: #AD0000;
                                transition: 1s;
                                color: white;
                                border: none;
                                opacity: 1;

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
                                background: url("<?php echo $xPath; ?>imgs/Departamentop.png");
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
                                background: #FF0000;
                                background: linear-gradient(0deg, #FF0000 0%, #000000 5%);
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
                                border-bottom: double 8px #FF0000;
                                border-left: double 8px white;
                                border-right: double 8px #FF0000;
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
                                background: linear-gradient(to right, white, #FF0000);
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
                                background: #FF0000;
                                background: linear-gradient(90deg, #FF0000 0%, #fff7f7 90%);
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
                                background: #AD0000;
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
                                background: #AD0000;
                                color: white;
                                transition: 1s;
                                cursor: pointer;

                            }
                        </style>
                        <div class="id_eval" id="<?php echo $id_evaluacion ?>" style="display: none;"></div>
                        <script>
                            $(document).ready(function() {
                                $("#guardar_reporte").click(function() {
                                    var evan = $('#txtarea2').val();
                                    var tray = $("#txtarea").val();
                                    var admi = $("#txtarea3").val();
                                    var observa = $("#txtarea7").val();
                                    var situa = $("#txtarea4").val();
                                    var anatec = $("#txtarea5").val();
                                    var sintesis = $("#txtarea6").val();
                                    var id_evaluacion = $(".id_eval").attr("id");


                                    url = "ajax_guardar_reporte_reexa.php";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: {
                                            evan: evan,
                                            id_evaluacion: id_evaluacion,
                                            tray: tray,
                                            admi: admi,
                                            observa: observa,
                                            situa: situa,
                                            anatec: anatec,
                                            sintesis: sintesis
                                        },
                                        success: function(data) {
                                            alert("El reporte se ha generado con exito...");
                                        }
                                    })
                                })
                            })
                        </script>
                        <script>
                            $(document).ready(function() {
                                $("#actualizar_reporte").click(function() {
                                    var evan = $('#txtarea2').val();
                                    var tray = $("#txtarea").val();
                                    var admi = $("#txtarea3").val();
                                    var observa = $("#txtarea7").val();
                                    var situa = $("#txtarea4").val();
                                    var anatec = $("#txtarea5").val();
                                    var sintesis = $("#txtarea6").val();
                                    var id_evaluacion = $(".id_eval").attr("id");

                                    url = "ajax_actualizar_reporte_reexa.php";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: {
                                            evan: evan,
                                            id_evaluacion: id_evaluacion,
                                            tray: tray,
                                            admi: admi,
                                            observa: observa,
                                            situa: situa,
                                            anatec: anatec,
                                            sintesis: sintesis
                                        },
                                        success: function(data) {
                                            alert("Los cambios se han realizado con exito...");
                                        }
                                    })
                                })
                            })
                        </script>
                        <script>
                            $(document).ready(function() {
                                $("#guardar_historial").click(function() {
                                    var evan = $('#txtarea2').val();
                                    var tray = $("#txtarea").val();
                                    var admi = $("#txtarea3").val();
                                    var observa = $("#txtarea7").val();
                                    var situa = $("#txtarea4").val();
                                    var anatec = $("#txtarea5").val();
                                    var sintesis = $("#txtarea6").val();
                                    var id_evaluacion = $(".id_eval").attr("id");


                                    url = "ajax_guardar_historial_reexa.php";
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: {
                                            evan: evan,
                                            id_evaluacion: id_evaluacion,
                                            tray: tray,
                                            admi: admi,
                                            observa: observa,
                                            situa: situa,
                                            anatec: anatec,
                                            sintesis: sintesis
                                        },
                                        success: function(data) {
                                            alert("Se ha generado el historial con exito...");
                                        }
                                    })
                                })
                            })
                        </script>
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
                                    <br>
                                    <br>
                                    <div class="enc"><br> <?php echo "MENU" ?> </div>
                                    <button id="boton_menu" name="resul"> Agregar Resultado <img
                                            src="<?php echo $xPath; ?>imgs/agregar-tarea.png" alt="" width="40px" height="95%"
                                            style="margin-left: 5px;"></button>
                                    <button id="boton_menu2" name="indice"> Indice de Hojas <img
                                            src="<?php echo $xPath; ?>imgs/lista-de-quehaceres.png" alt="" width="40px"
                                            height="95%"></button>
                                    <button id="boton_menu3" name="reporte"> Reporte <img
                                            src="<?php echo $xPath; ?>imgs/inmigracion.png" alt="" width="40px" height="95%">
                                    </button>
                                    <button id="boton_menu" name="documentos">Documentos <img
                                            src="<?php echo $xPath; ?>imgs/documento-de-word.png" alt="" width="40px"
                                            height="95%" style="margin-left: 2px;"> </button>
                                    <?php if ($xUsr->xCurpEval == "GOAS851006MGRMRN02" || $xUsr->xCurpEval == "") { ?>
                                        <button id="boton_menu" name="ensup">Enviar a Supervisor <img
                                                src="<?php echo $xPath; ?>imgs/flecha.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                        <button id="boton_menu" name="enev"> Enviar a Evaluador <img
                                                src="<?php echo $xPath; ?>imgs/flecharoja.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                        <button id="boton_menu" name="finev">Finalizar Evaluacion <img
                                                src="<?php echo $xPath; ?>imgs/terminado_pol.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                        <button id="boton_menu" name="alertas"> Alertas de Riesgo <img
                                                src="<?php echo $xPath; ?>imgs/aleries.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>



                                    <?php   }
                                    if ($xUsr->xCurpEval == "LOMJ900927HGRPRS07" || $xUsr->xCurpEval == "FEGM880122MGRLRR12") { ?>
                                        <button id="boton_menu" name="enjef">Enviar a Jefe de Area <img
                                                src="<?php echo $xPath; ?>imgs/flechazul.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                        <button id="boton_menu" name="enev" class="bt_mn"> Enviar a Evaluador <img
                                                src="<?php echo $xPath; ?>imgs/flecharoja.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                        <button id="boton_menu" name="alertas" class="bt_mn"> Alertas de Riesgo <img
                                                src="<?php echo $xPath; ?>imgs/aleries.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                    <?php }
                                    if ($xUsr->xCurpEval !== "LOMJ900927HGRPRS07" && $xUsr->xCurpEval !== "FEGM880122MGRLRR12" && $xUsr->xCurpEval !== "GOAS851006MGRMRN02" && $xUsr->xCurpEval !== "") { ?>
                                        <button id="boton_menu" name="ensup" class="bt_mn">Enviar a Supervisor <img
                                                src="<?php echo $xPath; ?>imgs/flecha.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                        <button id="boton_menu" name="" class="bt_mn"> Alertas de Riesgo <img
                                                src="<?php echo $xPath; ?>imgs/aleries.png" alt="" width="40px" height="95%"
                                                style="margin-left: 2px;"> </button>
                                    <?php   } ?>

                                    <a href="index.php" target="_parent"><button id="boton_menu" type="button"> Regresar <img
                                                src="<?php echo $xPath; ?>imgs/flecha-haci.png" alt="" width="30px" height="90%"
                                                style="margin-left: 10px;"></button></a>
                                    <div class="enc2"><br> </div>
                                </div>
                            </section>
                            <section class="datos">
                                <section class="infoev">

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
                                    <div id="texto"><?php echo "EVALUADOR: " ?></div>
                                    <div id="texto"><?php echo obtener_ev($id_evaluacion, $conexion) ?></div>
                                    <div id="separador"></div>
                                    <div id="texto"><?php echo "SUPERVISOR: " ?></div>
                                    <div id="texto"><?php echo obtener_sup($id_evaluacion, $conexion)  ?></div>



                                    <a href="#modal1" id="xAlerta" title="Agregar nueva Alerta de Riesgo">Agregar Alerta</a>
                                    <a id="hist" href="historial_alertas2.php?curpev=<?php echo $curp1 ?>"
                                        style="color: red;"> Historial de Alertas</a>
                                    <br> <a href="vista_nuevo_anteced2.php?curpev=<?php echo $curp1 ?>" style=" font-size: 12px; color: white; text-decoration: none;">Informe de investigacion de antecedentes</a>
                                    <br>
                                    <a href="evaluacion.php?id_evaluacion=<?php echo $id_evaluacion ?>&curpev=<?php echo $curp1 ?>">Ir a Evaluacion Previa</a>
                                    <p style="font-family: Oswald; font-size: 16px; color:rgb(224, 17, 17);"><?php estadoevaluacion($id_evaluacion, $conexion) ?></p>
                                </section>
                                <style>
                                    .asignar_elementos {
                                        width: 80%;
                                        height: 70%;
                                        background-image: linear-gradient(163deg, #FF0000 0%, #fff7f7 100%);
                                        border-radius: 20px;
                                        transition: all .3s;
                                        margin-top: 50px;
                                    }

                                    .card2 {

                                        width: 100%;
                                        height: 100%;
                                        background-color: black;
                                        transition: all .2s;

                                    }

                                    .card2:hover {
                                        transform: scale(0.995);
                                        border-radius: 20px;
                                    }

                                    .card3 {

                                        width: 100%;
                                        height: 100%;
                                        background-color: black;
                                        transition: all .2s;
                                        border-radius: 15px;


                                    }

                                    .card3:hover {
                                        transform: scale(0.985);
                                        border-radius: 20px;
                                        border: none;
                                    }

                                    .asignar_elementos:hover {
                                        box-shadow: 0px 0px 30px 1px #FF0000;
                                    }
                                </style>
                                <?php if ($xUsr->xCurpEval == "GOAS851006MGRMRN02" || $xUsr->xCurpEval == "LOMJ900927HGRPRS07" || $xUsr->xCurpEval == "FEGM880122MGRLRR12") {  ?>
                                    <section class="asignar_evaluador">
                                        <section class="asignar_elementos">
                                            <div class="card2">
                                                <br>
                                                <p> Evaluador: </p>
                                                <img style="width: 40px; height: 40px; border-radius: 10px; margin-left: -20px; margin-right: 5px; background: black;"
                                                    src="<?php echo $xPath; ?>imgs/empresario.png" alt=""><select
                                                    name="evaluador" id="">
                                                    <?php if ($fila_ev2) { ?>
                                                        <option value="<?php echo obtener_ev($id_evaluacion, $conexion)  ?>">
                                                            <?php echo obtener_ev($id_evaluacion, $conexion)  ?></option>

                                                    <?php  } else { ?>

                                                        <option value="">-SELECCIONE-</option>
                                                        <option value="AECY820421MGRRSL09">YULIANA PAULINA ARREOLA CASTRO</option>
                                                        <option value="AANA850512MGRVBN04">ANA LAURA ABARCA NAVA</option>
                                                        <option value="MAAA870123HGRRVL06">ALFONSO MARINO AVILA</option>
                                                        <option value="VAGE811102HGMGRL01">ELIZABETH VAZQUEZ GERONIMO</option>
                                                        <option value="JEAM890927MGRSNR02">MARISELA DE JESUS ANTONIO</option>
                                                        <option value="ROLM980228HGRJPN07">JOSE MANUEL ROJAS LOPEZ</option>
                                                        <option value="AUFI820831HDFRLV01">IVAN TADEO ARGUELLO FALCON</option>
                                                        <option value="VEZF850419HNELLR09">FRANCISCO GABRIEL VELAZQUEZ ZELAYA
                                                        </option>
                                                        <option value="GOAS851006MGRMRN02">SANDRA LUZ GOMEZ ARROYO</option>
                                                        <option value="LOMJ900927HGRPRS07">JEISON LOPEZ MORALES</option>
                                    <option value="FEGM880122MGRLRR12">MARICRUZ FELIX GARCIA</option>
                                                    <?php   } ?>
                                                </select>
                                                <p> Supervisor: </p>
                                                <img style="width: 40px; height: 40px; border-radius: 10px; margin-left: -20px; margin-right: 5px; background: black;"
                                                    src="<?php echo $xPath; ?>imgs/empresario.png" alt=""><select name="supe"
                                                    id="">
                                                    <?php if ($fila_ev2) { ?>
                                                        <option value="<?php echo obtener_sup($id_evaluacion, $conexion)  ?>">
                                                            <?php echo obtener_sup($id_evaluacion, $conexion)  ?></option>
                                                    <?php  } else { ?>

                                                        <option value="">-SELECCIONE-</option>
                                                        <option value="FEGM880122MGRLRR12">MARICRUZ FELIX GARCIA</option>
                                                        <option value="LOMJ900927HGRPRS07">JEISON LOPEZ MORALES</option>
                                                        <option value="GOAS851006MGRMRN02">SANDRA LUZ GOMEZ ARROYO</option>
                                                    <?php   } ?>
                                                </select>
                                                <style>
                                                    #llevar {
                                                        width: 100px;
                                                        height: 30px;
                                                        border: solid 1px black;
                                                        border-radius: 5px;
                                                        font-family: oswald;
                                                        font-size: 15px;
                                                        color: black;
                                                    }

                                                    #llevar:hover {
                                                        background: #2b547e;
                                                        cursor: pointer;
                                                        transition: 1s;
                                                        color: white;
                                                    }

                                                    .button {
                                                        -moz-appearance: none;
                                                        -webkit-appearance: none;
                                                        appearance: none;
                                                        border: none;
                                                        background: none;
                                                        color: #0f1923;
                                                        cursor: pointer;
                                                        position: relative;
                                                        padding: 8px;
                                                        margin-bottom: 20px;
                                                        text-transform: uppercase;
                                                        font-weight: bold;
                                                        font-size: 12px;
                                                        transition: all .15s ease;
                                                    }

                                                    .button::before,
                                                    .button::after {
                                                        content: '';
                                                        display: block;
                                                        position: absolute;
                                                        right: 0;
                                                        left: 0;
                                                        height: calc(50% - 5px);
                                                        border: 1px solid #7D8082;
                                                        transition: all .15s ease;
                                                    }

                                                    .button::before {
                                                        top: 0;
                                                        border-bottom-width: 0;
                                                    }

                                                    .button::after {
                                                        bottom: 0;
                                                        border-top-width: 0;
                                                    }

                                                    .button:active,
                                                    .button:focus {
                                                        outline: none;
                                                    }

                                                    .button:active::before,
                                                    .button:active::after {
                                                        right: 3px;
                                                        left: 3px;
                                                    }

                                                    .button:active::before {
                                                        top: 3px;
                                                    }

                                                    .button:active::after {
                                                        bottom: 3px;
                                                    }

                                                    .button_lg {
                                                        position: relative;
                                                        display: block;
                                                        padding: 10px 20px;
                                                        color: #fff;
                                                        background-color: white;
                                                        overflow: hidden;
                                                        box-shadow: inset 0px 0px 0px 1px transparent;
                                                    }

                                                    .button_lg::before {
                                                        content: '';
                                                        display: block;
                                                        position: absolute;
                                                        top: 0;
                                                        left: 0;
                                                        width: 2px;
                                                        height: 2px;
                                                        background-color: #033865;
                                                    }

                                                    .button_lg::after {
                                                        content: '';
                                                        display: block;
                                                        position: absolute;
                                                        right: 0;
                                                        bottom: 0;
                                                        width: 4px;
                                                        height: 4px;
                                                        background-color: #AD0000;
                                                        transition: all .2s ease;
                                                    }

                                                    .button_sl {
                                                        display: block;
                                                        position: absolute;
                                                        top: 0;
                                                        bottom: -1px;
                                                        left: -8px;
                                                        width: 0;
                                                        background-color: #AD0000;
                                                        transform: skew(-15deg);
                                                        transition: all .2s ease;
                                                    }

                                                    .button_text {
                                                        position: relative;
                                                        color: black;
                                                        font-weight: bold;
                                                    }

                                                    .button:hover {
                                                        color: #AD0000;
                                                    }

                                                    .button:hover .button_sl {
                                                        width: calc(100% + 15px);
                                                    }

                                                    .button:hover .button_lg::after {
                                                        background-color: #fff;
                                                    }
                                                </style>
                                                <br><br><?php if ($fila_ev2) { ?>
                                                    <div style="width: 170px; margin-top: 20px;">
                                                        <a href="#modal2"
                                                            style="text-decoration: none; font-weight: lighter; font-size: 11px;">
                                                            <div class="button"><span class="button_lg">
                                                                    <span class="button_sl"></span>
                                                                    <span class="button_text">Modificar<img
                                                                            style="width: 30px; margin-left: 5px; margin-right: 2px;"
                                                                            src="<?php echo $xPath; ?>imgs/intercambiar.png"
                                                                            alt=""></span>
                                                                </span></div>
                                                    </div>
                                                    </a><?php  } else { ?><p> Encargado de Asignacion:</p>
                                                    <img style="width: 40px; height: 40px; border-radius: 10px; margin-left: -20px; margin-right: 2px; background: black;"
                                                        src="<?php echo $xPath; ?>imgs/7910573.png" alt=""> <input type="text"
                                                        readonly
                                                        value="<?php echo solicita($xUsr->xCurpEval, $conexion)  ?>"><br><br>
                                                    <button class="button" name="asignar">
                                                        <span class="button_lg">
                                                            <span class="button_sl"></span>
                                                            <span class="button_text">Asignar<img
                                                                    style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                                    src="<?php echo $xPath; ?>imgs/comp.png" alt=""></span>
                                                        </span>
                                                    </button> <button class="button" name="asignar">
                                                        <span class="button_lg">
                                                            <span class="button_sl"></span>
                                                            <span class="button_text">Desasignar<img
                                                                    style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                                    src="<?php echo $xPath; ?>imgs/comp.png" alt=""></span>
                                                        </span>
                                                    </button><?php   } ?>
                                            </div>
                                        </section>
                                    </section><?php  } else {
                                                echo obtener_alertas($conexion, $id_evaluacion, $xPath);
                                            } ?>
                                <?php if (isset($_POST['resul'])) { ?>
                                    <section class="eval_resultado">
                                        <section class="result_ad">
                                            <p
                                                style="width: 100%; font-family: oswald; font-size: 18px; margin-top: 10px; color: white;">
                                                Resultado de
                                                Evaluacion</p>
                                            <div id="rubro_res">Resultado: <select name="resultadories" id="">
                                                    <?php if ($fila_resultado['id_resultado'] !== " ") { ?>
                                                        <option value="<?php echo $fila_resultado['id_resultado'] ?> ">
                                                            <?php echo $fila_resultado['id_resultado'] ?></option>
                                                    <?php  } else { ?>

                                                        <option value=" ">-Seleccione-</option>
                                                        <option value="RIESGO BAJO(NDI/NSR)">RIESGO BAJO(NDI/NSR)</option>
                                                        <option value="RIESGO BAJO(EES)">RIESGO BAJO(EES)</option>
                                                        <option value="RIESGO BAJO (OSS3)">RIESGO BAJO (OSS3)</option>
                                                        <option value="RIESGO MEDIO (INFO)">RIESGO MEDIO (INFO)</option>
                                                        <option value="RIESGO MEDIO (RES-TEC)">RIESGO MEDIO (RES-TEC)</option>
                                                        <option value="RIESGO ALTO ADMISION">RIESGO ALTO ADMISION</option>
                                                        <option value="RIESGO ALTO (DI)">RIESGO ALTO (DI)</option>
                                                        <option value="REEXAMINACION">REEXAMINACION</option>
                                                        <option value="RIESGO ALTO (ESS)">RIESGO ALTO (ESS)</option>
                                                        <option value="RIESGO ALTO (OSS3)">RIESGO ALTO (OSS3)</option>
                                                        <option value="SIN RESULTADO">SIN RESULTADO</option>
                                                    <?php  } ?>


                                                </select></div>
                                            <div id="rubro_res">Aanlisis Numerico: <input type="text" name="analisis_numerico"
                                                    value="<?php echo $fila_resultado['descrip_resultado'] ?>"></div>
                                            <div id="rubro_res">Utilizacion de Mapas: <select name="map" id="">
                                                    <?php if ($fila_resultado['descrip_resultado'] == " ") { ?>
                                                        <option value=" ">-Seleccione-</option>
                                                        <option value="Durante Estrevista">Durante Estrevista</option>
                                                        <option value="En Revision">En Revision</option>
                                                        <option value="No Utilizo">No Utilizo</option>
                                                    <?php  } else { ?>
                                                        <option value="<?php echo $fila_resultado['obs_supervisor'] ?> ">
                                                            <?php echo $fila_resultado['obs_supervisor'] ?></option>
                                                    <?php  } ?>
                                                </select> </div>
                                            <div id="rubro_res">Resultado Tecnico: <select name="resultado_tecnico" id="">
                                                    <?php if ($fila_resultado['id_resultado_loc'] == " ") { ?>
                                                        <option value=" ">-Seleccione-</option>
                                                        <option value="DI/SR">DI/SR</option>
                                                        <option value="NDI/NSR">NDI/NSR</option>
                                                        <option value="INC">INC</option>
                                                        <option value="CANCELADO">CANCELADO</option>
                                                        <option value="NP">NP</option>
                                                        <option value="SIN RESULTADO TECNICO">SIN RESULTADO TECNICO</option>
                                                    <?php  } else { ?>
                                                        <option value="<?php echo $fila_resultado['id_resultado_loc'] ?> ">
                                                            <?php echo $fila_resultado['id_resultado_loc'] ?></option>
                                                    <?php  } ?>
                                                </select></div>
                                        </section>
                                        <section class="tabla_listado">
                                            <section class="enc_listado">
                                                <div id="enc_listado">Elementos</div>
                                                <div id="enc_listado">Admision</div>
                                                <div id="enc_listado">Deteccion Tecnica</div>
                                            </section>
                                            <section class="opciones_res">
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Delitos</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="delitos_ad" id="chk"
                                                            value="1" <?php if ($fila_resultado['delitos_admision'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="delitos_de" id="chk"
                                                            value="1" <?php if ($fila_resultado['delitos_deteccion'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Drogas</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="drogas_ad" id="chk"
                                                            value="1" <?php if ($fila_resultado['drogas_admision'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="drogas_de" id="chk"
                                                            value="1" <?php if ($fila_resultado['drogas_deteccion'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Delincuencia Organizada</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="delincuencia_ad"
                                                            id="chk" value="1"
                                                            <?php if ($fila_resultado['delincuencia_admision'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="delincuencia_de"
                                                            id="chk" value="1"
                                                            <?php if ($fila_resultado['delincuencia_deteccion'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Informacion Confidencial</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="informacion_ad"
                                                            id="chk" value="1"
                                                            <?php if ($fila_resultado['informacion_admision'] == '1') { ?> checked
                                                            <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="informacion_de"
                                                            id="chk" value="1"
                                                            <?php if ($fila_resultado['informacion_deteccion'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Beneficios Ilicitos</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="beneficios_ad" id="chk"
                                                            value="1"
                                                            <?php if ($fila_resultado['beneficios_admision'] == '1') { ?> checked
                                                            <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="beneficios_de" id="chk"
                                                            value="1"
                                                            <?php if ($fila_resultado['beneficios_deteccion'] == '1') { ?> checked
                                                            <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Otros</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="otros_ad" id="chk"
                                                            value="1" <?php if ($fila_resultado['otros_admision'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="otros_de" id="chk"
                                                            value="1" <?php if ($fila_resultado['otros_deteccion'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Alcohol</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="alcohol_ad" id="chk"
                                                            value="1" <?php if ($fila_resultado['alcohol_admision'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="alcohol_de" id="chk"
                                                            value="1" <?php if ($fila_resultado['alcohol_admision'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                                <section class="opciones_resp">
                                                    <div id="opciones_resp">Actividades Delictivas</div>
                                                    <div id="opciones_resp"><input type="checkbox" name="actividades_ad"
                                                            id="chk" value="1"
                                                            <?php if ($fila_resultado['actividades_admision'] == '1') { ?> checked
                                                            <?php  } ?>></div>
                                                    <div id="opciones_resp"><input type="checkbox" name="actividades_de"
                                                            id="chk" value="1"
                                                            <?php if ($fila_resultado['actividades_deteccion'] == '1') { ?>
                                                            checked <?php  } ?>></div>
                                                </section>
                                            </section>
                                            <div style="font-family: arima; font-size: 16px; font-weight: bold; color: white;">
                                                Observaciones:
                                                <textarea name="obs"
                                                    id="obs"><?php echo $fila_resultado['observaciones'] ?></textarea>
                                            </div>
                                            <button id="bt_g" name="guardar_resultadoev" >Guardar</button>

                                        </section>

                                    </section>
                                    <style>
                                        .asignar_evaluador {
                                            display: none;
                                        }

                                        .alertas_riesgo {
                                            display: none;
                                        }
                                    </style>

                                <?php   } ?>
                                <?php if (isset($_POST['guardar_resultadoev'])) {
                                    $upda = "UPDATE poligrafia_evnu_rex set fecha_resultado='" . $hoy . "' , id_resultado = '" . $_POST['resultadories'] . "', id_resultado_loc = '" . $_POST['resultado_tecnico'] . "', descrip_resultado = '" . $_POST['analisis_numerico'] . "',
                               actividades_admision = '" . $_POST['actividades_ad'] . "', actividades_deteccion = '" . $_POST['actividades_de'] . "',  alcohol_admision = '" . $_POST['alcohol_ad'] . "', alcohol_deteccion = '" . $_POST['alcohol_de'] . "', 
                               observaciones = '" . $_POST['obs'] . "', otros_admision = '" . $_POST['otros_ad'] . "', otros_deteccion = '" . $_POST['otros_de'] . "', beneficios_admision = '" . $_POST['beneficios_ad'] . "', beneficios_deteccion = '" . $_POST['beneficios_de'] . "',
                            informacion_admision = '" . $_POST['informacion_ad'] . "', informacion_deteccion = '" . $_POST['informacion_de'] . "', delincuencia_admision = '" . $_POST['delincuencia_ad'] . "', delincuencia_deteccion = '" . $_POST['delincuencia_de'] . "', drogas_admision = '" . $_POST['drogas_ad'] . "', drogas_deteccion = '" . $_POST['drogas_de'] . "',
                            delitos_admision = '" . $_POST['delitos_ad'] . "', delitos_deteccion = '" . $_POST['delitos_de'] . "', obs_supervisor = '" . $_POST['map'] . "' where id_evaluacion = '$id_evaluacion' ";
                                    $resed = mysqli_query($conexion, $upda);
                                    if ($resed) {
                                        echo "<script languaje='JavaScript'>
               alert('Se agregaron los datos de manera correcta...');
               </script>";
                                    } else {
                                        echo "<script languaje='JavaScript'>
               alert('Los datos no han podido actualizarse...');
               </script>";
                                    }
                                } ?>

                                <?php if (isset($_POST['indice'])) { ?>

                                    <section class="indice_in">
                                        <section class="asignar_elementos">
                                            <div class="card2">
                                                <br>
                                                <p
                                                    style="width: 100%; font-family: oswald; font-size: 18px; margin-top: 10px; color: white;">
                                                    Indice
                                                    de Expediente</p>
                                                <section class="fila_indice">
                                                    <div id="fila_indice">Reporte: <input type="text" id="uno" name="ireporte"
                                                            oninput="sumar(this.value);" value="<?php echo $fila_indice['reporte'] ?>">
                                                        Hoja de Calificacion de Graficos: <input type="text" id="dos" name="ihojagra"
                                                            oninput="sumar(this.value);" value="<?php echo $fila_indice['hojagra'] ?>">
                                                        Hoja de Preguntas: <input type="text" name="ihojapre"
                                                            oninput="sumar(this.value);" value="<?php echo $fila_indice['hojapreg'] ?>">
                                                    </div>
                                                    <div id="fila_indice">Datos Generales: <input type="text" name="idatos"
                                                            oninput="sumar(this.value);" value="<?php echo $fila_indice['datosgen'] ?>">
                                                        Proteccion de Datos: <input type="text" name="iprotec"
                                                            oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['proteccion'] ?>"> Autorizacion de examen:
                                                        <input type="text" name="iautorizacionex" oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['autorizacion'] ?>">
                                                    </div>
                                                    <div id="fila_indice">Autorizacion de Areas: <input type="text"
                                                            name="iautorizacionar" oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['autorizacion_areas'] ?>"> Antecedentes
                                                        Personales: <input type="text" name="iantecedentes" oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['antecedentes'] ?>"> Entrevista: <input
                                                            type="text" name="ientrevista" oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['entrevista'] ?>"></div>
                                                    <div id="fila_indice">Serie de Graficos: <input type="text" name="iserie"
                                                            oninput="sumar(this.value);" value="<?php echo $fila_indice['serie'] ?>">
                                                        Hoja de Comentarios: <input type="text" name="ihojaco"
                                                            oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['hojacomen'] ?>"> Alerta de Riesgo: <input
                                                            type="text" name="ialerta" oninput="sumar(this.value);"
                                                            value="<?php echo $fila_indice['alerta'] ?>"></div>
                                                    <div id="fila_indice">Revision de Antecedentes: <input type="text" name="irevision"
                                                            oninput="sumar(this.value);" value="<?php echo $fila_indice['revision'] ?>">
                                                        AP de Evaluador: <input type="text" name="ieval"
                                                            value="<?php echo $fila_indice['apeva'] ?>"> Total de Hojas: <span
                                                            id="total"><?php echo $fila_indice['total'] ?></span></div>
                                                    <?php if ($fila_indice) { ?>
                                                        <button class="button" name="cambios_indice">
                                                            <span class="button_lg">
                                                                <span class="button_sl"></span>
                                                                <span class="button_text">Actualizar<img
                                                                        style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                                        src="<?php echo $xPath; ?>imgs/comp.png" alt=""></span>
                                                            </span>
                                                        </button>
                                                    <?php   } else {  ?>
                                                        <button class="button" name="guardar_indice">
                                                            <span class="button_lg">
                                                                <span class="button_sl"></span>
                                                                <span class="button_text">Guardar<img
                                                                        style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                                        src="<?php echo $xPath; ?>imgs/comp.png" alt=""></span>
                                                            </span>
                                                        </button>
                                                    <?php   } ?>
                                                </section>
                                            </div>
                                        </section>
                                    </section>
                                    <script>
                                        function sumar(valor) {
                                            var total = 0;
                                            valor = parseInt(valor);
                                            total = document.getElementById('total').innerHTML;
                                            total = (total == null || total == undefined || total == "") ? 0 : total;
                                            total = (parseInt(total) + parseInt(valor));

                                            document.getElementById('total').innerHTML = total;
                                        }
                                    </script>
                                    <style>
                                        #fila_indice input {
                                            margin-left: 5px;
                                            width: 8%;
                                            height: 20px;
                                            text-align: center;
                                            font-family: arima;
                                            font-size: 14px;
                                            margin-right: 20px;
                                        }

                                        #fila_indice {
                                            width: 100%;
                                            height: 30px;
                                            display: flex;
                                            margin-bottom: 10px;
                                            font-family: oswald;
                                            font-size: 16px;
                                            color: white;
                                            border-bottom: solid 1px black;

                                        }

                                        .fila_indice {
                                            width: 60%;
                                            height: 70%;
                                            display: inline-block;
                                            margin-top: 30px;

                                        }

                                        .indice_in {
                                            width: 1300px;
                                            height: 700px;
                                            margin-top: 5px;
                                        }

                                        .asignar_evaluador {
                                            display: none;
                                        }

                                        .eval_resultado {
                                            display: none;
                                        }

                                        .in_reporte {
                                            display: none;

                                        }

                                        .alertas_riesgo {
                                            display: none;
                                        }
                                    </style>
                                <?php   } ?>


                                <?php if (isset($_POST['reporte'])) { ?>
                                    <style>
                                        .asignar_evaluador {
                                            display: none;
                                        }

                                        .eval_resultado {
                                            display: none;
                                        }

                                        .alertas_riesgo {
                                            display: none;
                                        }

                                        .in_reporte {
                                            width: 1300px;
                                            max-height: 99%;

                                            margin-left: 20px;
                                            overflow-y: scroll;

                                        }

                                        .rubros_reporte {
                                            max-width: 100%;
                                            max-height: 400px;
                                            margin-bottom: 30px;
                                            display: inline-block;

                                        }

                                        #txtarea {
                                            width: 100%;
                                            height: 100%;

                                        }
                                    </style>

                                    <section class="in_reporte">
                                        <p
                                            style="width: 100%; font-family: oswald; font-size: 18px; margin-top: 10px; color: white;">
                                            Reporte
                                            de Evaluacion:</p>
                                        <section class="rubros_reporte">
                                            <br>
                                            <p style="font-family: oswald; font-size: 16px; color: white;">Evaluaciones
                                                Anteriores: </p><textarea name="ev_ant"
                                                id="txtarea2"><?php echo $fila_reporte['evaluaciones_anteriores'] ?></textarea>
                                        </section>
                                        <section class="rubros_reporte">
                                            <p style="font-family: oswald; font-size: 16px; margin-top: 5px; color: white; ">
                                                Trayecto Laboral: </p><textarea name="tray"
                                                id="txtarea"><?php echo $fila_reporte['trayectoria_laboral'] ?></textarea>
                                        </section>
                                        <section class="rubros_reporte">
                                            <p style="font-family: oswald; font-size: 16px; margin-top: 10px; color: white; ">
                                                Admision: </p><textarea name="admision"
                                                id="txtarea3"><?php echo $fila_reporte['admision'] ?></textarea>
                                        </section>
                                        <section class="rubros_reporte">
                                            <p style="font-family: oswald; font-size: 16px; margin-top: 10px; color: white;">
                                                Observacion: </p><textarea name="observacion"
                                                id="txtarea7"><?php echo $fila_reporte['observacion'] ?></textarea>
                                        </section>
                                        <section class="rubros_reporte">
                                            <p style="font-family: oswald; font-size: 16px; margin-top: 10px; color: white;">
                                                Situacion
                                                Patrimonial: </p><textarea name="situacion"
                                                id="txtarea4"><?php echo $fila_reporte['situacion_patrimonial'] ?></textarea>
                                        </section>
                                        <section class="rubros_reporte">
                                            <p style="font-family: oswald; font-size: 16px; margin-top: 10px; color: white;">
                                                Analisis Tecnico: </p><textarea name="analisitec"
                                                id="txtarea5"><?php echo $fila_reporte['analisis_tecnico'] ?></textarea>
                                        </section>
                                        <section class="rubros_reporte">
                                            <p style="font-family: oswald; font-size: 16px; margin-top: 10px; color: white;">
                                                Sintesis Tecnica: </p><textarea name="conclusion"
                                                id="txtarea6"><?php echo $fila_reporte['conclusion'] ?></textarea>
                                        </section>
                                        <br>
                                        <?php if ($fila_reporte) { ?>
                                            <button class="button" id="actualizar_reporte" type="button">
                                                <span class="button_lg">
                                                    <span class="button_sl"></span>
                                                    <span class="button_text">Actualizar<img
                                                            style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                            src="<?php echo $xPath; ?>imgs/comp.png" alt=""></span>
                                                </span>
                                            </button>
                                            <button class="button" id="guardar_historial" type="button">
                                                <span class="button_lg">
                                                    <span class="button_sl"></span>
                                                    <span class="button_text">Historial<img
                                                            style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                            src="<?php echo $xPath; ?>imgs/informacion1.png" alt=""></span>
                                                </span>
                                            </button>

                                            <a href="#modal3">
                                                <img style="width: 40px; height: 40px; border-radius: 10px; margin-left: 10px; margin-right: 5px; background: white;"
                                                    src="<?php echo $xPath; ?>imgs/procesando.png" alt=""></a>
                                        <?php   } else {  ?>
                                            <button class="button" id="guardar_reporte" type="button">
                                                <span class="button_lg">
                                                    <span class="button_sl"></span>
                                                    <span class="button_text">Guardar<img
                                                            style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                            src="<?php echo $xPath; ?>imgs/comp.png" alt=""></span>
                                                </span>
                                            </button>
                                            <button class="button" id="guardar_historial" type="button">
                                                <span class="button_lg">
                                                    <span class="button_sl"></span>
                                                    <span class="button_text">Historial<img
                                                            style="width: 20px; height: 20px; border-radius: 10px; margin-left: 5px; margin-right: 2px;"
                                                            src="<?php echo $xPath; ?>imgs/informacion1.png" alt=""></span>
                                                </span>
                                            </button>

                                            <a href="#modal3">
                                                <img style="width: 40px; height: 40px; border-radius: 10px; margin-left: 10px; margin-right: 5px; background: white;"
                                                    src="<?php echo $xPath; ?>imgs/procesando.png" alt=""></a>

                                        <?php    } ?>


                                    </section>
                                <?php }  ?>
                                
                                <?php if (isset($_POST['documentos'])) { ?>
                                    <style>
                                        .alertas_riesgo {
                                            display: none;
                                        }

                                        .asignar_evaluador {
                                            display: none;
                                        }

                                        .in_reporte {
                                            display: none;
                                        }

                                        .documentos_l {
                                            width: 1300px;
                                            height: 97%;
                                            margin-left: 10px;
                                            margin-top: 5px;
                                        }

                                        #container-main {
                                            margin: 40px auto;
                                            width: 100%;
                                            min-width: 320px;
                                            max-width: 1100px;
                                            height: 90%;
                                            overflow-y: scroll;
                                        }

                                        #container-main h1 {
                                            font-size: 40px;
                                            text-shadow: 4px 4px 5px #16a085;
                                        }

                                        .accordion-container {
                                            width: 100%;
                                            margin: 0 0 20px;
                                            clear: both;
                                        }

                                        .accordion-titulo {
                                            position: relative;
                                            display: block;
                                            padding: 20px;
                                            font-size: 16px;
                                            font-weight: 300;
                                            background: #7F0000;
                                            color: #fff;
                                            text-decoration: none;
                                        }

                                        .accordion-titulo.open {
                                            background: #7F4444;
                                            color: #fff;
                                        }

                                        .accordion-titulo:hover {
                                            background: #570000;
                                            color: white;
                                            text-decoration: none;
                                        }

                                        .accordion-titulo span.toggle-icon:before {
                                            content: "+";
                                        }

                                        .accordion-titulo.open span.toggle-icon:before {
                                            content: "-";
                                        }

                                        .accordion-titulo span.toggle-icon {
                                            position: absolute;
                                            top: 10px;
                                            right: 20px;
                                            font-size: 28px;
                                            font-weight: bold;
                                        }

                                        .accordion-content {
                                            display: none;
                                            padding: 20px;
                                            overflow: auto;
                                            background: #222;
                                        }

                                        .accordion-content p {
                                            margin: 0;
                                        }




                                        @media (max-width: 767px) {
                                            .accordion-content {
                                                padding: 10px 0;
                                            }
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

                                        .indice__tabla {
                                            width: 80%;
                                            height: auto;

                                            display: flex;
                                        }

                                        .indice__tabla--formatos {
                                            width: 25%;
                                            display: inline-block;
                                            height: auto;

                                        }

                                        .indice__tabla--formatos P {
                                            height: 30px;
                                            font-family: oswald;
                                            font-size: 13px;
                                            text-align: left;
                                        }

                                        .indice__tabla--no {
                                            width: 25%;
                                            display: inline-block;
                                            height: auto;

                                        }

                                        .indice__tabla--no div {
                                            width: 50px;
                                            height: 30px;
                                            border: solid 1px black;
                                            font-family: arima;
                                            font-size: 12px;
                                        }

                                        .indice__tabla--si {
                                            width: 25%;
                                            display: inline-block;
                                            height: auto;

                                        }

                                        .indice__tabla--si div {
                                            width: 50px;
                                            height: 30px;
                                            border: solid 1px black;
                                            font-family: arima;
                                            font-size: 13px;
                                        }

                                        .indice__tabla--hojas {
                                            width: 25%;
                                            display: inline-block;
                                            height: auto;
                                        }

                                        .indice__tabla--hojas div {
                                            width: 50px;
                                            height: 30px;
                                            border: solid 1px black;
                                            font-family: arima;
                                            font-size: 12px;
                                        }

                                        .indice__encabezados {
                                            width: 80%;
                                            height: 30px;
                                            display: flex;
                                        }

                                        .indice__encabezados p {
                                            width: 25%;
                                            height: 30px;
                                            font-family: oswald;
                                            font-size: 15px;
                                        }
                                    </style>
                                    <?php
                                    $sql = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,categoria,fecha from tbprog_preliminar where xcurp = '" . $curp1 . "' order by id_prog_preliminar desc";
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
                                    $sql4 = "SELECT rfc,id_genero,fecha_nac from tbdatospersonales where curp = '" . $curp1 . "'";
                                    $resultado4 = mysqli_query($conexion, $sql4);
                                    $fila4 = mysqli_fetch_assoc($resultado4);
                                    $sql5 = "SELECT genero from ctgenero where id_genero = '" . $fila4['id_genero'] . "'";
                                    $resultado5 = mysqli_query($conexion, $sql5);
                                    $fila5 = mysqli_fetch_assoc($resultado5);
                                    $hoy = date('Y-m-d');
                                    $edad = $hoy - $fila4['fecha_nac'];
                                    $sql_rep = "SELECT evaluaciones_anteriores,trayectoria_laboral,situacion_patrimonial,analisis_tecnico,conclusion,admision,observacion from reporte_pol_rex where id_evaluacion = '$id_evaluacion'";
                                    $resultado6 = mysqli_query($conexion, $sql_rep);
                                    $fila6 = mysqli_fetch_assoc($resultado6);
                                    $sql7 = "SELECT reporte,hojagra,datosgen,hojapreg,proteccion,autorizacion,autorizacion_areas,antecedentes,entrevista,serie,hojacomen,alerta,revision,apeva,total from indice_polnu_rex where id_evaluacion='$id_evaluacion'";
                                    $resultado7 = mysqli_query($conexion, $sql7);
                                    $fila7 = mysqli_fetch_assoc($resultado7);
                                    ?>

                                    <div id="container-main">
                                        <div class="accordion-container">
                                            <a href="#" class="accordion-titulo">Formatos Iniciales<span
                                                    class="toggle-icon"></span></a>
                                            <div class="accordion-content">
                                                <embed src="areas_poli1.php" type="application/pdf" width="100%" height="550px">

                                            </div>
                                        </div>

                                        <div class="accordion-container">
                                            <a href="#" class="accordion-titulo">Formato de Suspension & Cancelacion<span
                                                    class="toggle-icon"></span></a>
                                            <div class="accordion-content">
                                                <embed src="formato_cancelacion.php" type="application/pdf" width="100%"
                                                    height="500px">

                                            </div>
                                        </div>
                                        <div class="accordion-container">
                                            <a href="#" class="accordion-titulo">Reporte de Evaluacion<span
                                                    class="toggle-icon"></span></a>
                                            <div class="accordion-content">
                                                <section class="hoja">
                                                    <section class="membrete">
                                                        <div class="imagen_mem"><img src="<?php echo $xPath; ?>imgs/NEscudo.png"
                                                                alt="" width="240px" height="100%" style="margin-left: 5px;">
                                                        </div>
                                                        <div class="titulo_mem">CENTRO ESTATAL DE EVALUACION Y CONTROL DE
                                                            CONFIANZA DEL ESTADO DE GUERRERO</div>
                                                        <div class="imagen_mem"><img
                                                                src="<?php echo $xPath; ?>imgs/secretariado.jpg" alt=""
                                                                width="240px" height="100%" style="margin-left: 5px;"></div>
                                                    </section>
                                                    <section class="tabla_datosdoc">
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Motivo de Evaluacion</p>

                                                            <p
                                                                style="width: 30%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $tipoe ?></p>
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Fecha de Evaluacion</p>

                                                            <p
                                                                style="width: 20%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['fecha'] ?></p>
                                                        </div>

                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Nombre</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['nombre'] . " " . $fila['a_paterno'] . " " . $fila['a_materno'] ?>
                                                            </p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                RFC</p>

                                                            <p
                                                                style="width: 30%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila4['rfc'] ?></p>
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Edad</p>

                                                            <p
                                                                style="width: 20%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $edad . " " . utf8_decode("años") ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Dependencia</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $corporacion ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Categoria</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['categoria'] ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Cargo Especifico</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['categoria'] ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 100%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Este reporte es estrictamente confidencial</p>
                                                        </div>
                                                    </section>
                                                    <section class="inforep">
                                                        <p
                                                            style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                            Evaluaciones Anteriores</p>
                                                        <p><?php echo $fila6['evaluaciones_anteriores'] ?></p>
                                                    </section>
                                                    <section class="inforep">
                                                        <p
                                                            style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                            Trayectoria Laboral</p>
                                                        <p><?php echo $fila6['trayectoria_laboral'] ?></p>
                                                    </section>
                                                    <?php if ($fila6['admision'] != "" || $fila6['admision'] != null) { ?>
                                                        <section class="inforep">
                                                            <p
                                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                                Admision</p>
                                                            <p><?php echo $fila6['admision'] ?></p>
                                                        </section>
                                                    <?php } ?>
                                                    <?php if ($fila6['observacion'] != "" || $fila6['observacion'] != null) { ?>
                                                        <section class="inforep">
                                                            <p
                                                                style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                                Observacion</p>
                                                            <p><?php echo $fila6['observacion'] ?></p>
                                                        </section>
                                                    <?php } ?>

                                                    <section class="inforep">
                                                        <p
                                                            style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                            Situacion Patrimonial</p>
                                                        <p><?php echo $fila6['situacion_patrimonial'] ?></p>
                                                    </section>
                                                    <section class="inforep">
                                                        <p
                                                            style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                            Analisis Tecnico</p>
                                                        <p><?php echo $fila6['analisis_tecnico'] ?></p>
                                                    </section>
                                                    <section class="inforep">
                                                        <p
                                                            style="width: 100%; height: 30px; background: silver; font-family: oswald; font-size: 14px;">
                                                            SINTESIS TECNICA</p>
                                                        <p><?php echo $fila6['conclusion'] ?></p>
                                                    </section>
                                                    <br>
                                                </section>
                                                <a href="reporte_rex.php">Descargar</a>
                                            </div>
                                        </div>

                                        <div class="accordion-container">
                                            <a href="#" class="accordion-titulo">Formato de Indice<span
                                                    class="toggle-icon"></span></a>
                                            <div class="accordion-content">

                                                <section class="hoja">
                                                    <section class="membrete">
                                                        <div class="imagen_mem"><img src="<?php echo $xPath; ?>imgs/NEscudo.png"
                                                                alt="" width="240px" height="100%" style="margin-left: 5px;">
                                                        </div>
                                                        <div class="titulo_mem">CENTRO ESTATAL DE EVALUACION Y CONTROL DE
                                                            CONFIANZA DEL ESTADO DE GUERRERO</div>
                                                        <div class="imagen_mem"><img
                                                                src="<?php echo $xPath; ?>imgs/secretariado.jpg" alt=""
                                                                width="240px" height="100%" style="margin-left: 5px;"></div>
                                                    </section>
                                                    <section class="tabla_datosdoc">
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Motivo de Evaluacion</p>

                                                            <p
                                                                style="width: 30%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $tipoe ?></p>
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Fecha de Evaluacion</p>

                                                            <p
                                                                style="width: 20%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['fecha'] ?></p>
                                                        </div>

                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Nombre</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['nombre'] . " " . $fila['a_paterno'] . " " . $fila['a_materno'] ?>
                                                            </p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                RFC</p>

                                                            <p
                                                                style="width: 30%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila4['rfc'] ?></p>
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Edad</p>

                                                            <p
                                                                style="width: 20%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $edad . " " . utf8_decode("años") ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Dependencia</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $corporacion ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Categoria</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['categoria'] ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 20%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Cargo Especifico</p>

                                                            <p
                                                                style="width: 40%; height: 100%;font-family: arima; font-size: 12px; margin-left: 5px;">
                                                                <?php echo $fila['categoria'] ?></p>
                                                        </div>
                                                        <div id="filas_datos">
                                                            <p
                                                                style="width: 100%; height: 100%; background: silver; font-family: oswald; font-size: 14px;">
                                                                Este reporte es estrictamente confidencial</p>
                                                        </div>
                                                    </section>
                                                    <section class="indice__encabezados">
                                                        <p>FORMATOS DE EVALUACION</p>
                                                        <p>SI</p>
                                                        <p>NO</p>
                                                        <p>No. HOJAS</p>

                                                    </section>
                                                    <section class="indice__tabla">
                                                        <div class="indice__tabla--formatos">
                                                            <p>1.-REPORTE</p>
                                                            <p>2.-HOJA DE CALIFICACION DE GRAFICOS</p>
                                                            <p>3.-HOJA DE PREGUNTAS</p>
                                                            <p>4.-DATOS GENERALES</p>
                                                            <p>5.-PROTECCION DE DATOS</p>
                                                            <p>6.-AUTORIZACION DE EXAMEN</p>
                                                            <p>7.-AUTORIZACION DE AREAS</p>
                                                            <p>8.-ANTECEDENTES PERSONALES</p>
                                                            <p>9.-ENTREVISTA</p>
                                                            <p>10.-SERIE DE GRAFICOS</p>
                                                            <p>11.-HOJA DE COMENTARIOS</p>
                                                            <p>12.-ALERTA DE RIESGO</p>
                                                            <p>13.-REVISION DE ANTECEDENTES</p>
                                                        </div>
                                                        <div class="indice__tabla--si">
                                                            <div><?php if ($fila7['reporte'] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7['hojagra'] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["hojapreg"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["datosgen"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["proteccion"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["autorizacion"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["autorizacion_areas"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["antecedentes"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["entrevista"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["serie"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["hojacomen"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["alerta"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["revision"] >= 1) {
                                                                        echo "X";
                                                                    } ?></div>
                                                        </div>
                                                        <div class="indice__tabla--no">
                                                            <div><?php if ($fila7['reporte'] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7['hojagra'] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["hojapreg"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["datosgen"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["proteccion"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["autorizacion"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["autorizacion_areas"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["antecedentes"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["entrevista"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["serie"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["hojacomen"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["alerta"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                            <div><?php if ($fila7["revision"] == 0) {
                                                                        echo "X";
                                                                    } ?></div>
                                                        </div>
                                                        <div class="indice__tabla--hojas">
                                                            <div><?php echo $fila7['reporte'] ?></div>
                                                            <div><?php echo $fila7['hojagra'] ?></div>
                                                            <div><?php echo $fila7["hojapreg"]; ?></div>
                                                            <div><?php echo $fila7["datosgen"]; ?></div>
                                                            <div><?php echo $fila7["proteccion"]; ?></div>
                                                            <div><?php echo $fila7["autorizacion"]; ?></div>
                                                            <div><?php echo $fila7["autorizacion_areas"]; ?></div>
                                                            <div><?php echo $fila7["antecedentes"]; ?></div>
                                                            <div><?php echo $fila7["entrevista"]; ?></div>
                                                            <div><?php echo $fila7["serie"]; ?></div>
                                                            <div><?php echo $fila7["hojacomen"]; ?></div>
                                                            <div><?php echo $fila7["alerta"]; ?></div>
                                                            <div><?php echo $fila7["revision"]; ?></div>
                                                        </div>
                                                    </section>
                                                    <br>
                                                </section>
                                                <a href="indice_rex.php">Descargar</a>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                            <script>
                                $(".accordion-titulo").click(function() {

                                    var contenido = $(this).next(".accordion-content");

                                    if (contenido.css("display") == "none") { //open		
                                        contenido.slideDown(250);
                                        $(this).addClass("open");
                                    } else { //close		
                                        contenido.slideUp(250);
                                        $(this).removeClass("open");
                                    }

                                });
                            </script>
                        <?php }  ?>
                        <?php if (isset($_POST['alertas'])) { ?>
                            <style>
                                .asignar_evaluador {
                                    display: none;
                                }
                            </style>
                        <?php obtener_alertas($conexion, $id_evaluacion, $xPath);
                        }  ?>
                        </section>
                        </section>
                        <?php if (isset($_POST['guardar_indice'])) {
                            $totalhojas = $_POST['ireporte'] + $_POST['ihojagra'] + $_POST['idatos'] + $_POST['iprotec'] + $_POST['iautorizacionex'] + $_POST['iautorizacionar'] + $_POST['iantecedentes'] + $_POST['ientrevista'] + $_POST['iserie'] + $_POST['ihojaco'] + $_POST['ialerta'] + $_POST['irevision'] + $_POST['ihojapre'];
                            $query = "INSERT INTO indice_polnu_rex (id_evaluacion, curp_evaluador, curp_supervisor,reporte,hojagra,datosgen,proteccion,autorizacion,autorizacion_areas,antecedentes,entrevista,serie,hojacomen,alerta,revision,apeva,total,hojapreg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $sentencia = mysqli_prepare($conexion, $query);
                            mysqli_stmt_bind_param($sentencia, "sssiiiiiiiiiiiiiii", $id_evaluacion, $xUsr->xCurpEval, $supervisor, $_POST['ireporte'], $_POST['ihojagra'], $_POST['idatos'], $_POST['iprotec'], $_POST['iautorizacionex'], $_POST['iautorizacionar'], $_POST['iantecedentes'], $_POST['ientrevista'], $_POST['iserie'], $_POST['ihojaco'], $_POST['ialerta'], $_POST['irevision'], $_POST['ieval'], $totalhojas, $_POST['ihojapre']);
                            mysqli_stmt_execute($sentencia);
                            $filasafec = mysqli_stmt_affected_rows($sentencia);
                            if ($filasafec == 1) { ?>
                                <script languaje='JavaScript'>
                                    alert('El indice ha sido generado con exito...');
                                </script>
                        <?php    } else {
                                echo "<script languaje='JavaScript'>
                     alert('Problema al guardar, ya existe un reporte con la evaluacion seleccionada');
                     </script>";
                            }
                        } ?>
                        <?php if (isset($_POST['cambios_indice'])) {
                            $totalhojas = $_POST['ireporte'] + $_POST['ihojagra'] + $_POST['idatos'] + $_POST['iprotec'] + $_POST['iautorizacionex'] + $_POST['iautorizacionar'] + $_POST['iantecedentes'] + $_POST['ientrevista'] + $_POST['iserie'] + $_POST['ihojaco'] + $_POST['ialerta'] + $_POST['irevision'] + $_POST['ihojapre'];
                            $upda = "UPDATE indice_polnu_rex set reporte = '" . $_POST['ireporte'] . "', hojagra = '" . $_POST['ihojagra'] . "', datosgen = '" . $_POST['idatos'] . "', proteccion='" . $_POST['iprotec'] . "',autorizacion='" . $_POST['iautorizacionex'] . "', autorizacion_areas ='" . $_POST['iautorizacionar'] . "', antecedentes ='" . $_POST['iautorizacionar'] . "', entrevista = '" . $_POST['iantecedentes'] . "', entrevista='" . $_POST['ientrevista'] . "', serie='" . $_POST['iserie'] . "', hojacomen='" . $_POST['ihojaco'] . "', alerta='" . $_POST['ialerta'] . "', revision='" . $_POST['irevision'] . "', hojapreg='" . $_POST['ihojapre'] . "', total='$totalhojas' where id_evaluacion = '$id_evaluacion' ";
                            $resed = mysqli_query($conexion, $upda);
                            if ($resed) {
                                echo "<script languaje='JavaScript'>
        alert('Se actualizaron los datos de manera correcta...');
        </script>";
                            } else {
                                echo "<script languaje='JavaScript'>
        alert('Los datos no han podido actualizarse...');
        </script>";
                            }
                        } ?>


                        
                        
                        <?php if (isset($_POST['asignar'])) {

                            $rn = " ";
                            $rs = " ";
                            $estado_ev = "1";
                            $query = "INSERT INTO poligrafia_evnu_rex (curp_evaluador,id_resultado,fecha_aplicacion,fecha_resultado,obs_supervisor,id_resultado_loc,descrip_resultado,curp_supervisor,estado,fecha_finalizado,observaciones,delitos_admision,delitos_deteccion,drogas_admision,delincuencia_admision,drogas_deteccion,delincuencia_deteccion,informacion_admision,informacion_deteccion,beneficios_admision,beneficios_deteccion,otros_admision,otros_deteccion,alcohol_admision,alcohol_deteccion,actividades_admision,actividades_deteccion,curp_evaluado,id_evaluacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            $sentencia = mysqli_prepare($conexion, $query);
                            mysqli_stmt_bind_param($sentencia, "sssssssssssssssssssssssssssss", $_POST['evaluador'], $rn, $hoy, $rs, $rs, $rs, $rs, $_POST['supe'], $estado_ev, $rs, $rs, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $rn, $curp1, $id_evaluacion);
                            mysqli_stmt_execute($sentencia);
                            $filasafec = mysqli_stmt_affected_rows($sentencia);
                            if ($filasafec == 1) { ?>
                                <script languaje='JavaScript'>
                                    alert('Se ha asignado la evaluacion con exito');
                                </script>
                        <?php    } else {
                                echo "<script languaje='JavaScript'>
                     alert('La informacion no ha podido agregarse');
                     </script>";
                            }
                        } ?>
                        <?php if (isset($_POST['desasignar'])) {

$upda = "UPDATE poligrafia_evnu_rex set curp_evaluador='', curp_supervisor='' where id_evaluacion = '$id_evaluacion'";
                            $resed = mysqli_query($conexion, $upda); ?>
                            <script languaje='JavaScript'>
                            alert('La evaluacion ha sido desasignada...'); 
                        </script>
<?php } ?>
                        <?php if (isset($_POST['finev'])) {
                            $estado_lib = '1';
                            $reexa = '1';
                            $upda = "UPDATE poligrafia_evnu_rex set estado='4' where id_evaluacion = '$id_evaluacion'";
                            $resed = mysqli_query($conexion, $upda);
                            $query = "INSERT INTO liberados_pol (id_evaluacion,curp,estado,fecha,rexa) VALUES (?,?,?,?,?)";
                            $sentencia = mysqli_prepare($conexion, $query);
                            mysqli_stmt_bind_param($sentencia, "sssss", $id_evaluacion, $curp1, $estado_lib, $hoy,$reexa);
                            mysqli_stmt_execute($sentencia);
                            if ($filasafec == 1) { ?>
                                <script languaje='JavaScript'>
                                    alert('Se ha Liberado la Evaluacion');
                                </script>
                        <?php    } else {
                                echo "<script languaje='JavaScript'>
                         alert('La evaluacion ya ha sido liberada');
                         </script>";
                            }
                        } ?>

                        <?php if (isset($_POST['enjef'])) {
                            $upda = "UPDATE poligrafia_evnu_rex set estado='3' where id_evaluacion = '$id_evaluacion'";
                            $resed = mysqli_query($conexion, $upda);
                            if ($resed) {
                                echo "<script languaje='JavaScript'>
        alert('Se ha enviado la evaluacion al jefe de area...');
        </script>";
                            } else {
                                echo "<script languaje='JavaScript'>
        alert('No ha podido enviarse la evaluacion...');
        </script>";
                            }
                        } ?>
                        <?php if (isset($_POST['ensup'])) {
                            $upda = "UPDATE poligrafia_evnu_rex set estado='2' where id_evaluacion = '$id_evaluacion'";
                            $resed = mysqli_query($conexion, $upda);
                            if ($resed) {
                                echo "<script languaje='JavaScript'>
        alert('Se ha enviado la evaluacion al supervisor...');
        </script>";
                            } else {
                                echo "<script languaje='JavaScript'>
        alert('No ha podido enviarse la evaluacion...');
        </script>";
                            }
                        } ?>
                        <?php if (isset($_POST['enev'])) {
                            $upda = "UPDATE poligrafia_evnu_rex set estado='1' where id_evaluacion = '$id_evaluacion'";
                            $resed = mysqli_query($conexion, $upda);
                            if ($resed) {
                                echo "<script languaje='JavaScript'>
        alert('Se ha enviado la evaluacion al evaluador...');
        </script>";
                            } else {
                                echo "<script languaje='JavaScript'>
        alert('No ha podido enviarse la evaluacion...');
        </script>";
                            }
                        }


                        if (isset($_POST['guardar_modal'])) {
                            $fecha_ac =  date('Y-m-d');
                            date_default_timezone_set("America/Mexico_City");
                            $hora = date('H:i:s'); //date('H:i:s');


                            $stat = 1;
                            $des = utf8_encode($_POST['alerta']);
                            $curpe = $xUsr->xCurpEval;
                            $query = "INSERT INTO  tbnew_alertariesgo (descripcion,fecha,hora,id_evaluacion,curp_evaluador,stat) VALUES ('$des' ,'$fecha_ac','$hora','$id_evaluacion','$curpe','$stat')";
                            $sentencia = mysqli_prepare($conexion, $query);
                            mysqli_stmt_execute($sentencia);
                            $filasafec = mysqli_stmt_affected_rows($sentencia);
                            if ($filasafec == 1) {
                                echo "<script languaje='JavaScript'>
                            alert('La alerta de riesgo se ha agregado de manera correcta...');
                            </script>";
                            } else {
                                echo "<script languaje='JavaScript'>
                            alert('La alerta de riesgo no ha podido agregarse...');
                            </script>";
                            }
                        }
                        if (isset($_POST['guardar_modal2'])) {
                            $supnu = $_POST['supe_1'];
                            $evnu = $_POST['evaluador_1'];
                            $upda = "UPDATE poligrafia_evnu_rex set curp_evaluador = '$evnu', curp_supervisor='$supnu' where id_evaluacion='$id_evaluacion' ";
                            $resed = mysqli_query($conexion, $upda);
                            if ($resed) {
                                echo "<script languaje='JavaScript'>
               alert('Se ha actualizado correctamente...');
               </script>";
                            } else {
                                echo "<script languaje='JavaScript'>
               alert('Los datos no han podido actualizarse...');
               </script>";
                            }
                        } ?>

    </body>
    <script>

    </script>

    </html>
    <?php ?>
<?php

} else
    header("Location: " . $xPath . "exit.php");
?>