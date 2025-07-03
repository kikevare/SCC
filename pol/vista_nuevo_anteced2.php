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
    
    $curpevaluado = $_GET['curpev'];
    $xSys = new System();
    $xUsr = new Usuario();
    $xCat = new Catalog();
    $xPersona = new Persona($curpevaluado);
    

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
?>
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
    <style type="text/css">
    .styxBtnOpcion {
        width: 65px;
        font-size: 8pt;
        font-weight: bold;
        font-family: arial, helvetica, sans-serif;
    }

    .tbDatos {
        width: auto;
        border: 2px solid #cccccb;
        border-collapse: collapse;
    }

    .tbDatos td {}

    .tdNombreCampo {
        border-bottom: 1px solid #cccccb;
        background-color: #e5e6e4;
        font-family: "arial", sans-serif, serif;
        font-size: 9pt;
        color: #595454;
        text-align: center;
        padding: 3px 2px 3px 2px;
    }

    .tdValorCampo {
        font-family: "arial", sans-serif, serif;
        font-size: 9pt;
        font-weight: bold;
        color: #463e3f;
        text-align: center;
        padding: 3px;
        min-height: 18px;
        height: 18px;
    }

    .stytbResultados {
        width: 99%;
        border-spacing: 0;
    }

    .stytbResultados th {
        background-color: #2b547e;
        color: white;
        font-family: Arial, sans-serif;
        font-size: 9pt;
        height: 25px;
        border: 1px solid #153e7e;
    }

    .stytbResultados td {
        min-height: 30px;
        padding: 3px 1px 3px 1px;
        font-family: Arial, sans-serif;
        font-size: 9pt;
        border-bottom: 1px dotted #153e7e;
        text-align: center;
    }

    .stypCampo {
        width: 350px;
        min-height: 12px;
        border-left: 2px double gray;
        border-top: 2px double gray;
        border-right: 1px solid #cccccb;
        border-bottom: 1px solid #cccccb;
        background-color: #ebebea;
        padding: 3px;
    }

    .styLnk {
        font-family: arial, sans-serif, serif;
        font-size: 10pt;
        font-weight: bold;
        color: blue;
    }

    #pAnte-Notas {
        background-color: #e5e6e4;
        border: 1px dotted #cccccb;
        margin: 10px 8px 5px 0;
        padding: 5px 7px 5px 0;
        text-align: right;
    }

    #pAnte-Notas a {
        font-size: 11pt;
    }

    .tbDetallesEval {
        border-collapse: collapse;
        table-layout: auto;
        width: 99%;
    }

    .tbDetallesEval tr:nth-child(even) {
        background-color: #f0f1f0;
    }

    .tbDetallesEval td {
        border-bottom: 1px dotted #d7d7d7;
        color: #646060;
        padding: 7px 5px 7px 5px;
    }

    .tdTituloDetallesEval {
        background-color: #488ac7;
        border-top: 1px dotted gray;
        border-bottom: 1px dotted gray;
        font-size: 10pt;
        font-weight: bold;
        text-align: center;
    }

    .tdNombreDato {
        font-weight: bold;
        min-width: 100px;
        text-align: left;
    }

    .tdContenidoDato {
        font-size: 9pt;
        text-align: left;
        min-width: 200px;
    }
    </style>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&display=swap');

    .oswald {
        font-family: "Oswald", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
    }

    .barlow-thin {
        font-family: "Barlow", sans-serif;
        font-weight: 100;
        font-style: normal;
    }
    </style>
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
                <form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();"
                    enctype="application/x-www-form-urlencoded">
                    <br><br>
                    <?php
                        //------------------- Muestra el t�tulo del m�dulo actual ------------------//
                        //-- Muestra el nombre del m�dulo actual, tomando la sesI&Oacute;N...
                        $xSys->getNameMod($_SESSION["menu"], "Vista Previa");
                        //--------------------------------------------------------------------------//
                        $user_perfil = $_GET["user"];

                        //------------------------ Recepcion de par�metros -------------------------//
                        if (isset($_GET["curp"])) {
                            $xPersona = new Persona($_GET["curp"]);
                            $_SESSION["xCurp"] = $xPersona->CURP;
                            

    $xInvDoc = New invDocumental(  $_SESSION["xCurp"]  );
                        } else
                            $xPersona = new Persona($curpevaluado);

                        $xEval = new Evaluaciones($curpevaluado);
                        //---------------------------------------------------CURP_EVAL-----------------------//
                        $xRMN = new Integracion($curpevaluado);
                        $DATA = $xRMN->getDatosInte();
                        $Datos = $xEval->getResultadoFinalEval();
                        $xPsico = new Psicologico($curpevaluado);
                        $xPsico->getDatosPsico();
                        $xMed = new Evaluaciones($curpevaluado);
                        $xMed->getResultadoFinalEval();
                        $xMed->getDatosMed();


                        if ($Datos != false)
                            $Resultado = $Datos;
                        /*$dbname = "bdceecc";
                        $dbuser = "root";
                        $dbhost = "localhost";
                        $dbpass = 'root';*/
                        $dbname ="bdceecc";
                        $dbuser="root";
                        $dbhost="10.24.2.25";
                        $dbpass='4dminMy$ql$';
                        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                        $sql = "select id_evaluacion, fecha_reg from tbevaluaciones where curp='" . $curpevaluado . "'order by id_evaluacion desc";
                        $resultado = mysqli_query($conexion, $sql);
                        $filas = mysqli_fetch_assoc($resultado);
                        $id = $filas['id_evaluacion'];
                        $sql2 = "select folio_toxi from tbevtoxi where id_evaluacion='" . $id . "'";
                        $resultad = mysqli_query($conexion, $sql2);
                        $fila = mysqli_fetch_assoc($resultad);
                        $sql3 = "select nombre, a_paterno, a_materno, id_corporacion, categoria, id_tipo_eval, id_municipio, id_region from tbprog_preliminar where xcurp='" .$curpevaluado . "' order by id_prog_preliminar desc";
                        $resulta = mysqli_query($conexion, $sql3);
                        $fil = mysqli_fetch_assoc($resulta);
                        $sql4 = "select fecha_nac, id_genero, cuip, rfc from tbdatospersonales where curp='" . $curpevaluado . "'";
                        $result = mysqli_query($conexion, $sql4);
                        $fil1 = mysqli_fetch_assoc($result);
                        $fech = $fil1['fecha_nac'];
                       /* $cumpleanos = new DateTime("$fech");
                        $hoy = new DateTime();
                        $annos = $hoy->diff($cumpleanos);*/
                        $annos = date('Y')-$fech;
                        $sql5 = "select genero from ctgenero where id_genero='" . $fil1['id_genero'] . "'";
                        $resul = mysqli_query($conexion, $sql5);
                        $fil2 = mysqli_fetch_assoc($resul);
                        $sql6 = "select tipo_muestra, marihuana, cocaina, anfetaminas, barbituricos, benzodiacepinas, opiaceos, metodo, curp_evaluador from tbcualitativa where id_evaluacion='" . $id . "'";
                        $resuls = mysqli_query($conexion, $sql6);
                        $fil3 = mysqli_fetch_assoc($resuls);
                        $sql7 = "select corporacion from ctcorporacion where id_corporacion='" . $fil['id_corporacion'] . "'";
                        $resul3 = mysqli_query($conexion, $sql7);
                        $fil4 = mysqli_fetch_assoc($resul3);
                        $sql8 = "select tipo_eval from cttipoevaluacion where id_tipo_eval='" . $fil['id_tipo_eval'] . "'";
                        $resul4 = mysqli_query($conexion, $sql8);
                        $fil5 = mysqli_fetch_assoc($resul4);
                        $sql9 = " select supervisor from tbresponsabletox";
                        $resul5 = mysqli_query($conexion, $sql9);
                        $fil6 = mysqli_fetch_assoc($resul5);
                        $sql10 = "select nombre, a_paterno, a_materno from tbdatospersonales where curp = '" . $fil3['curp_evaluador'] . "'";
                        $resul6 = mysqli_query($conexion, $sql10);
                        $fil7 = mysqli_fetch_assoc($resul6);
                        $sql11 = "select municipio, id_entidad from ctmunicipio where id_municipio ='" . $fil['id_municipio'] . "'";
                        $resul7 = mysqli_query($conexion, $sql11);
                        $fil8 = mysqli_fetch_assoc($resul7);
                        $sql12 = "select region from ctregion where id_region ='" . $fil['id_region'] . "'";
                        $resul8 = mysqli_query($conexion, $sql12);
                        $fil9 = mysqli_fetch_assoc($resul8);
                        $sql13 = "select entidad from ctentidad where id_entidad = '" . $fil8['id_entidad'] . "'";
                        $resul9 = mysqli_query($conexion, $sql13);
                        $fil10 = mysqli_fetch_assoc($resul9);
                        $sql16 = "select rr_uno, rr_dos, rr_tres, rr_cuatro, rr_cinco, diag_uno, diag_dos, diag_tres, diag_cuatro, diag_cinco from tbestlabactfisdiagresrec where id_evaluacion = '" . $id . "'";
                        $resul12 = mysqli_query($conexion, $sql16);
                        $fil13 = mysqli_fetch_assoc($resul12);
                        $sql14 = "select id_resultado from tbevmedico where id_evaluacion = '" . $id . "'";
                        $resul10 = mysqli_query($conexion, $sql14);
                        $fil11 = mysqli_fetch_assoc($resul10);
                        $sql15 = "select resultado from ctresultado where id_resultado = '" . $fil11['id_resultado'] . "'";
                        $resul11 = mysqli_query($conexion, $sql15);
                        $fil12 = mysqli_fetch_assoc($resul11);
                        $sql17 = "select observaciones from tbindiceverexpcli where id_evaluacion = '" . $id . "'";
                        $resul13 = mysqli_query($conexion, $sql17);
                        $fil14 = mysqli_fetch_assoc($resul13);
                        $sql18 = "select apnp_tatuajes from tbantnopatologicos where id_evaluacion = '" . $id . "'";
                        $resul14 = mysqli_query($conexion, $sql18);
                        $fil15 = mysqli_fetch_assoc($resul14);
                        $sql19 = "select piel_mucosas_faeneras from tbexploracionfisica where id_evaluacion = '" . $id . "'";
                        $resul15 = mysqli_query($conexion, $sql19);
                        $fil16 = mysqli_fetch_assoc($resul15);
                        $sql18 = "select apnp_tatuajes from tbantnopatologicos where id_evaluacion = '" . $id . "'";
                        $resul14 = mysqli_query($conexion, $sql18);
                        $fil15 = mysqli_fetch_assoc($resul14);
                        $sql19 = "select piel_mucosas_faeneras from tbexploracionfisica where id_evaluacion = '" . $id . "'";
                        $resul15 = mysqli_query($conexion, $sql19);
                        $fil16 = mysqli_fetch_assoc($resul15);
                        $sql19 = "select nocomple_justificacion from tbevmedico where id_evaluacion = '" . $id . "'";
                        $resul16 = mysqli_query($conexion, $sql19);
                        $fil17 = mysqli_fetch_assoc($resul16);
                        $sql20 = "select id_nivelestudios from tbnivelestudios where curp = '" . $xPersona->CURP . "'";
                        $resul17 = mysqli_query($conexion, $sql20);
                        $fil18 = mysqli_fetch_assoc($resul17);
                        $sql21 = "select nivelestudios from ctnivelestudios where id_nivelestudios = '" . $fil18['id_nivelestudios'] . "'";
                        $resul18 = mysqli_query($conexion, $sql21);
                        $fil19 = mysqli_fetch_assoc($resul18);
                        $sql22 = "select id_resultado_previo, justificacion,analisis,curp_evaluador, curp_supervisor from tbanalisis where id_evaluacion = '" . $id . "'";
                        $resul19 = mysqli_query($conexion, $sql22);
                        $fil20 = mysqli_fetch_assoc($resul19);
                        $sql23 = "select resultado from ctresultadoinvsoceco where id_resultado = '" . $fil20['id_resultado_previo'] . "'";
                        $resul20 = mysqli_query($conexion, $sql23);
                        $fil59 = mysqli_fetch_assoc($resul20);
                        $sql24 = "select nombre, a_paterno, a_materno from tbdatospersonales where curp = '" . $fil20['curp_evaluador'] . "'";
                        $resul21 = mysqli_query($conexion, $sql24);
                        $fil21 = mysqli_fetch_assoc($resul21);
                        $sql25 = "select n_cedula from tbnivelestudios where curp = '" . $fil20['curp_evaluador'] . "'";
                        $resul22 = mysqli_query($conexion, $sql25);
                        $fil22 = mysqli_fetch_assoc($resul22);
                        $sql26 = "select nombre, a_paterno, a_materno from tbdatospersonales where curp = '" . $fil20['curp_supervisor'] . "'";
                        $resul23 = mysqli_query($conexion, $sql26);
                        $fil23 = mysqli_fetch_assoc($resul23);
                        $sql27 = "select n_cedula from tbnivelestudios where curp = '" . $fil20['curp_supervisor'] . "'";
                        $resul23 = mysqli_query($conexion, $sql27);
                        $fil24 = mysqli_fetch_assoc($resul23);
                        $sql27 = "select curp_titular from ctareaseval where id_area = '4'";
                        $resul24 = mysqli_query($conexion, $sql27);
                        $fil25 = mysqli_fetch_assoc($resul24);
                        $sql28 = "select nombre, a_paterno, a_materno from tbdatospersonales where curp = '" . $fil25['curp_titular'] . "'";
                        $resul25 = mysqli_query($conexion, $sql28);
                        $fil26 = mysqli_fetch_assoc($resul25);
                        $sql29 = "select n_cedula from tbnivelestudios where curp = '" . $fil25['curp_titular'] . "'";
                        $resul26 = mysqli_query($conexion, $sql29);
                        $fil27 = mysqli_fetch_assoc($resul26);
                        $sql30 = "select cargo, id_municipio from tbadscripcion where curp = '" . $xPersona->CURP . "'";
                        $resul27 = mysqli_query($conexion, $sql30);
                        $fil28 = mysqli_fetch_assoc($resul27);
                        $sql33 = "select municipio from ctmunicipio where id_municipio ='" . $fil28['id_municipio'] . "'";
                        $resul30 = mysqli_query($conexion, $sql33);
                        $fil31 = mysqli_fetch_assoc($resul30);
                        $sql31 = "select evaluaciones_anteriores, trayectoria_laboral, observacion,situacion_patrimonial, analisis_tecnico,conclusion, admision from tbevpoligrafica where id_evaluacion = '" . $id . "'";
                        $resul28 = mysqli_query($conexion, $sql31);
                        $fil29 = mysqli_fetch_assoc($resul28);
                        $sql32 = "select evaluaciones_anterioresr, trayectoria_laboralr, observacionr,situacion_patrimonialr, analisis_tecnicor,conclusionr, admisionr from tbevpoligrafica where id_evaluacion = '" . $id . "'";
                        $resul29 = mysqli_query($conexion, $sql32);
                        $fil30 = mysqli_fetch_assoc($resul29);
                        $sql34 = "select fecha, observaciones from tbinvestanteced where id_evaluacion ='" . $id . "'";
                        $resul31 = mysqli_query($conexion, $sql34);
                        $fil32 = mysqli_fetch_assoc($resul31);
                        $fecha = $fil32['fecha'];
                        $mesn = $fecha[5].$fecha[6];
                        if ($mesn=='01') {
                            $meslargo = $fecha[8].$fecha[9]." ".  "DE ENERO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }
                        if ($mesn=='02') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE FEBRERO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='03') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE MARZO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='04') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE ABRIL DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='05') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE MAYO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='06') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE JUNIO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='07') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE JULIO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='08') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE AGOSTO DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='09') {
                            $meslargo = $fecha[8].$fecha[9]." "."DE SEPTIEMBRE DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='10') {
                            $meslargo = $fecha[8].$fecha[9]." ". "DE OCTUBRE DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='11') {
                            $meslargo = $fecha[8].$fecha[9]." ". "DE NOVIEMBRE DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }if ($mesn=='12') {
                            $meslargo = $fecha[8].$fecha[9]." ". "DE DICIEMBRE DEL"." ".$fecha[0].$fecha[1].$fecha[2].$fecha[3];
                        }
                        
                        $sql35 = "select des_antecedentes,des_actual, id_quienconsulta from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=1";
                        $resul32 = mysqli_query($conexion, $sql35);
                        $fil33 = mysqli_fetch_assoc($resul32);
                        $fil33['des_antecedentes'];
                        $sql53 = "select quienconsulta from ctquienconsulta where id_quienconsulta ='" . $fil33['id_quienconsulta'] . "'";
                        $resul50 = mysqli_query($conexion, $sql53);
                        $fil53 = mysqli_fetch_assoc($resul50);
                        $sql36 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=2";
                        $resul33 = mysqli_query($conexion, $sql36);
                        $fil34 = mysqli_fetch_assoc($resul33);
                        $sql37 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=3";
                        $resul34 = mysqli_query($conexion, $sql37);
                        $fil35 = mysqli_fetch_assoc($resul34);
                        $sql38 = "select des_antecedentes,des_actual,id_quienconsulta from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=4";
                        $resul35 = mysqli_query($conexion, $sql38);
                        $fil36 = mysqli_fetch_assoc($resul35);

                        $sql39 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=5";
                        $resul35 = mysqli_query($conexion, $sql39);
                        $fil37 = mysqli_fetch_assoc($resul35);

                        $sql40 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=6";
                        $resul36 = mysqli_query($conexion, $sql40);
                        $fil38 = mysqli_fetch_assoc($resul36);

                        $sql41 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=7";
                        $resul37 = mysqli_query($conexion, $sql41);
                        $fil39 = mysqli_fetch_assoc($resul37);

                        $sql41 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=8";
                        $resul38 = mysqli_query($conexion, $sql41);
                        $fil40 = mysqli_fetch_assoc($resul38);

                        $sql42 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=9";
                        $resul39 = mysqli_query($conexion, $sql42);
                        $fil41 = mysqli_fetch_assoc($resul39);

                        $sql43 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=10";
                        $resul40 = mysqli_query($conexion, $sql43);
                        $fil42 = mysqli_fetch_assoc($resul40);

                        $sql44 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=11";
                        $resul41 = mysqli_query($conexion, $sql44);
                        $fil43 = mysqli_fetch_assoc($resul41);

                        $sql45 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=12";
                        $resul42 = mysqli_query($conexion, $sql45);
                        $fil44 = mysqli_fetch_assoc($resul42);

                        $sql46 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=13";
                        $resul43 = mysqli_query($conexion, $sql46);
                        $fil45 = mysqli_fetch_assoc($resul43);

                        $sql47 = "select des_antecedentes,des_actual from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=14";
                        $resul44 = mysqli_query($conexion, $sql47);
                        $fil46 = mysqli_fetch_assoc($resul44);

                        $sql48 = "select des_antecedentes, des_actual, id_quienconsulta from tbantecedentes where id_evaluacion ='" . $id . "' and id_consulta=15";
                        $resul45 = mysqli_query($conexion, $sql48);
                        $fil47 = mysqli_fetch_assoc($resul45);

                        $sql49 = "select quienconsulta from ctquienconsulta where id_quienconsulta ='" . $fil36['id_quienconsulta'] . "'";
                        $resul46 = mysqli_query($conexion, $sql49);
                        $fil48 = mysqli_fetch_assoc($resul46);

                        $sql50 = "select id_documentacion from tbdocumentacion where curp ='" . $xPersona->CURP . "' order by id_evaluacion desc";
                        $resul47 = mysqli_query($conexion, $sql50);
                        $fil49 = mysqli_fetch_assoc($resul47);

                        $sql51 = "select observaciones from tbvalidarcartilla where id_documentacion ='" . $fil49['id_documentacion'] . "'";
                        $resul48 = mysqli_query($conexion, $sql51);
                        $fil50 = mysqli_fetch_assoc($resul48);
                        $obsercar=$fil50['observaciones'];

                        $sql52 = "select observaciones from tbvalidarestudios where id_documentacion ='" . $fil49['id_documentacion'] . "'";
                        $resul49 = mysqli_query($conexion, $sql52);
                        $fil51 = mysqli_fetch_assoc($resul49);
                        $obseres=$fil51['observaciones'];

                        $sql53 = "select * from tbhojas where id_evaluacion ='" . $id . "'";
                        $resul50 = mysqli_query($conexion, $sql53);
                        $fil52 = mysqli_fetch_assoc($resul50);
                        
                        $sql54 = "select * from tbevpsico where id_evaluacion ='" . $id . "'";
                        $resul51 = mysqli_query($conexion, $sql54);
                        $fil54 = mysqli_fetch_assoc($resul51);

                        $sql55 = "select * from ctresultado where id_resultado ='" . $fil54['id_resultado'] . "'";
                        $resul52 = mysqli_query($conexion, $sql55);
                        $fil55 = mysqli_fetch_assoc($resul52);
                        











                        $xfoto = $xPersona->getFoto();
                        if (!empty($xfoto))
                            $xfoto = $xPath . $xfoto;
                        else
                            $xfoto = $xPath . "imgs/sin_foto.png";
                        
                        
                        ?>
                    <table border="0" class="stytbOpciones" cellpadding="0" cellspacing="0" style="width: 100%;">
                        <tr>
                            <td width="50%" align="center" id="tdBtns">
                                <a href="reexa.php?curpev=<?php echo $curpevaluado ?>&id_evaluacion=<?php echo $id ?>" id="" class="btn btn-dark" role="button" data-toggle="tooltip"
                                    data-placement="top" title="Regresar">
                                    <span style="font-size: 0.8em; color: white;">
                                        <i class="fas fa-step-backward"></i>&nbsp;<h7>Regresar</h7>
                                    </span>
                                </a>
                            </td>
                        </tr>
                    </table>

                    <section class="visor">
                        <?php echo " <script type='text/javascript'>
    document.addEventListener('contextmenu', function(event){
        event.preventDefault();
    }, false);
    document.addEventListener('copy', function(event){

      event.clipboardData.setData('text/plain', 'AVISO DE CONFIDENCIALIDAD Y PROHIBICION DE COPIA. La divulgacion no autorizada de esta informacion puede causar daños irreparables y sera considerada una violacion a la confidencialidad y privacidad. Cualquier persona que viole esta prohibicion sera sancionada de acuerdo con la legislacion vigente, incluyendo pero no limitandose a multas, daños y prejuicios y otras penas establecidas por la Ley Federal de proteccion de datos e informacion. PROHIBIDA LA COPIA, PEGADO, REPRODUCCION, DISTRIBUCION O MODIFICACION SIN AUTORIZACION EXPRESA. ADVERTENCIA: Esta informacion es confidencial y solo para uso interno. Queda estrictamente prohibida la divulgacion de informacion con terceros sin autorizacion.');
      event.preventDefault();
  }, false);
</script>" ?>
                        <section class="hoja5">
                            <div class="encabezado">
                                <div id="logo1"><img src="<?php echo $xPath; ?>imgs/logo2.jpg" alt="" width="200px"
                                        height="90px"></div>
                                <div id="text1">
                                    <p> <?php echo utf8_decode("SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL DE SEGURIDAD PÚBLICA <br>
    CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO <br> INVESTIGACIÓN SOCIOECONOMICA "); ?>
                                    </p>
                                </div>
                                <div id="logo2"><img src="<?php echo $xPath; ?>imgs/logo1.jpg" alt="" width="100px"
                                        height="90px"></div>
                            </div>
                            <div class="encabeza">
                                <p id="txt21"><?php echo utf8_decode("INFORME DE INVESTIGACIÓN DE ANTECEDENTES");  ?>
                                </p>
                            </div>
                            <section class="dat_iden">
                                <div id="tit_inv">
                                    <?php echo utf8_decode("DATOS DE IDENTIFICACIÓN");  ?>
                                </div>
                                <section class="esp_if">
                                    <div id="inf_ant">
                                        <div id="i_ant">
                                            <p id="txtp">NOMBRE DEL EVALUADO:</p>
                                            <p id="txtso">
                                                <?php echo $fil['a_paterno'] . " " . $fil['a_materno'] . " " . $fil['nombre']; ?>
                                            </p>
                                        </div>
                                        <div id="i_ant">
                                            <p id="txtp"> CORPORACION:</p>
                                            <p id="txtso"><?php echo $fil4['corporacion']; ?></p>
                                        </div>
                                        <div id="i_ant">
                                            <p id="txtp">ADSCRIPCION:</p>
                                            <p id="txtso"><?php echo $fil31['municipio'] ?></p>
                                        </div>
                                        <div id="i_ant">
                                            <p id="txtp">CATEGORIA:</p>
                                            <p id="txtso"><?php echo $fil['categoria'] ?></p>
                                        </div>
                                        <div id="i_ant">
                                            <p id="txtp">MOTIVO DE EVALUACION:</p>
                                            <p id="txtso"><?php echo $fil5['tipo_eval'] ?></p>
                                        </div>
                                        <div id="i_ant">
                                            <p id="txtp">FECHA DE INVESTIGACION:</p>
                                            <p id="txtso"><?php echo $meslargo ?></p>
                                        </div>
                                    </div>
                                    <div id="fot"><img id="imagen_ele" src="<?php echo $xfoto; ?>"
                                            alt="FOTOGRAFIA DEL ELEMENTO"></div>

                                </section>
                                <div id="obs_ant">
                                    <p id="txtp">OBSERVACIONES:</p>
                                    <p id="txtso"><?php echo $fil32['observaciones']; ?></p>
                                </div>
                            </section>
                            <section class="tabla_datosant">
                                <div id="enca_ant">
                                    <div id="ena1">
                                        <p id="txtp"> APLICATIVOS
                                            DE CONSULTA </p>
                                    </div>
                                    <div id="ena2">
                                        <p id="txtant"> REPORTE DE RIESGO O HALLAZGOS RELEVANTES </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> PLATAFORMA
                                            MEXICO (SUIC) </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil33['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> BCC (ANTES DIGISCAN) </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil34['des_antecedentes'];  ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> TELSCAN </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil35['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> RNPSP </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil43['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> CONSULTA EN INTERNET </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil40['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> REDES SOCIALES </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil44['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant">
                                    <div id="ena1">
                                        <p id="txtp"> APLICATIVOS
                                            DE CONSULTA </p>
                                    </div>
                                    <div id="ena2">
                                        <p id="txtant"> AMPLIACION DE INFORMACION </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> FGE GRO</p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil36['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> CODDEHUM GRO </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil37['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> SECRETARIA DE CONTRALORIA Y TRANSPARENCIA GUBERNAMENTAL GUERRERO
                                        </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil38['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> REGISTRO PUBLICO DE LA PROPIEDAD EN EL ESTADO
                                            DE GUERRERO</p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil39['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> DEPENDENCIAS FORANEAS </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil41['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> SUBSECRETARIA DEL SISTEMA PENITENCIARIO </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil42['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> REDES SOCIALES </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil44['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> VINCULOS FAMILIARES, SOCIALES Y LABORALES </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil47['des_antecedentes']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant">
                                    <div id="ena1">
                                        <p id="txtp"> APLICATIVOS
                                            DE CONSULTA </p>
                                    </div>
                                    <div id="ena2">
                                        <p id="txtant"> INFORMACION RELEVANTE DE EVALUACIONES PREVIAS </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> PLATAFORMA
                                            MEXICO (SUIC) </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil33['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> DIGISCAN </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil34['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> TELSCAN </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil35['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> RNPSP </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil43['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> CONSULTA EN INTERNET </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo utf8_encode($fil40['des_actual']);  ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> REDES SOCIALES </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo utf8_encode($fil44['des_actual']) ; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> FGE GRO</p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil36['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> CODDEHUM GRO </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil37['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> SECRETARIA DE CONTRALORIA Y TRANSPARENCIA GUBERNAMENTAL GUERRERO
                                        </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil38['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> REGISTRO PUBLICO DE LA PROPIEDAD EN EL ESTADO
                                            DE GUERRERO</p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil39['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> DEPENDENCIAS FORANEAS </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil41['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> SUBSECRETARIA DEL SISTEMA PENITENCIARIO </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil42['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> REDES SOCIALES </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo $fil44['des_actual']; ?> </p>
                                    </div>
                                </div>
                                <div id="enca_ant2">
                                    <div id="ena3">
                                        <p id="txtant"> VINCULOS FAMILIARES, SOCIALES Y LABORALES </p>
                                    </div>
                                    <div id="ena4">
                                        <p id="txtant2"> <?php echo utf8_encode($fil47['des_actual']) ; ?> </p>
                                    </div>
                                </div>
                            </section>
                            <section class="indice_delic">
                                <div id="ind_e">
                                    <p id="txtant">INDICES DELICTIVOS</p>
                                </div>
                                <div id="ind_b">
                                    <p id="txtant2"><?php echo $fil45['des_actual']; ?></p>
                                </div>

                            </section>
                            <section class="indice_delic">
                                <div id="ind_e">
                                    <p id="txtant">VALIDACION DE DOCUMENTOS</p>
                                </div>
                                <div id="ind_b2">
                                    <?php echo "OBSERVACIONES DE CARTILLA:".utf8_decode($obsercar) ?><br><?php echo "OBSERVACIONES DE COMPROBANTE DE ESTUDIOS:".utf8_decode($obseres)?>
                                </div>

                            </section>
                            <section class="indice_delic">
                                <div id="ind_e">
                                    <p id="txtant">CONCLUSION</p>
                                </div>
                                <div id="ind_b">
                                    <p id="txtant2"><?php echo $fil46['des_antecedentes'] ?></p>
                                </div>
                            </section>
                            <section class="fir_antec">
                                <div id="ela">
                                    <div id="por_ela">ELABORO:</div>
                                    <div id="por_ela2"><?php echo "LIC."." ". $fil53['quienconsulta'] ?><br>
                                        INVESTIGADOR DE ANTECEDENTES</div>
                                </div>
                                <div id="ela">
                                    <div id="por_ela">SUPERVISO:</div>
                                    <div id="por_ela2">LIC. BLANCA ALICIA VICTORIA AVILA <br> RESPONSABLE DEL AREA DE
                                        INVESTIGACION DE ANTECEDENTES</div>
                                </div>
                            </section>
                        </section>
                    </section>
                    <style>
                    #t_re2 {
                        width: 45%;
                        height: 30px;
                        text-align: center;
                        font-family: barlow;
                        font-size: 14px;

                    }

                    #t_re {
                        width: 45%;
                        height: 30px;
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        background: silver;
                        border-right: solid 2px black;
                    }

                    .diag {
                        width: 100%;
                        height: auto;
                        border: solid 2px black;
                        display: flex;
                    }

                    .res_psi {
                        margin-top: 20px;
                        width: 90%;
                        height: auto;
                        display: inline-block;
                        margin-bottom: 20px;
                    }

                    #inf_psi {
                        width: 100%;
                        height: auto;
                        border-bottom: solid 2px black;
                        border-top: solid 2px black;
                        border-right: solid 2px black;
                        text-align: start;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #rell {
                        width: 100%;
                        height: auto;
                        border-bottom: 2px black;
                        border-right: none;
                        display: inline-block;
                    }

                    .informacion {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        border-right: none;
                        display: inline-block;
                        margin-top: 10px;
                    }

                    #criterio {
                        width: 12.5%;
                        height: 30px;
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        border-top: solid 2px black;
                        border-right: solid 2px black;
                    }

                    #cri3 {
                        width: 100%;
                        height: 30px;
                        display: flex;
                        background: white;

                    }

                    #cri2 {
                        width: 100%;
                        height: 30px;
                        display: flex;
                        background: silver;

                    }

                    #cri {
                        width: 100%;
                        height: 30px;
                        background: silver;
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        border-right: solid 2px black;
                    }

                    .criterios {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        border-right: none;
                        display: inline-block;
                    }

                    #por_ela2 {
                        width: 60%;
                        height: 100%;
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;


                    }

                    #por_ela {
                        width: 100%;
                        height: 30px;
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        background: silver;


                    }

                    #ela {
                        width: 50%;
                        height: 100%;
                        border-right: solid 2px black;
                        display: inline-block;
                    }

                    .fir_antec {
                        width: 90%;
                        height: 100px;
                        border: solid 2px black;
                        margin-top: 10px;
                        display: flex;
                        border-right: none;
                        margin-bottom: 30px;
                    }

                    #ind_b {
                        width: 100%;
                        height: auto;
                    }

                    #ind_b2 {
                        width: 100%;
                        height: auto;
                        text-align: justify;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #ind_e {
                        width: 100%;
                        height: auto;
                        background: silver;
                        border-bottom: solid 2px black;
                    }

                    .indice_delic {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        margin-bottom: 10px;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    #txtant2 {
                        text-align: justify;
                        font-family: barlow;
                        font-size: 14px;
                        margin-left: 20px;
                        margin-right: 20px;

                    }

                    #txtant {
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        height: auto;
                        overflow-wrap: break-word;

                    }

                    #ena4 {
                        width: 80%;
                        height: auto;
                    }

                    #ena3 {
                        width: 20%;
                        height: auto;
                        border-right: solid 2px black;
                    }

                    #ena2 {
                        width: 80%;
                        height: 100%;
                    }

                    #ena1 {
                        width: 20%;
                        height: 100%;
                        border-right: solid 2px black;
                    }

                    #enca_ant2 {
                        width: 100%;
                        height: auto;
                        display: flex;
                        border-bottom: solid 2px black;
                    }

                    #enca_ant {
                        width: 100%;
                        height: auto;
                        background: silver;
                        display: flex;
                        border-bottom: solid 2px black;
                    }

                    .tabla_datosant {
                        width: 90%;
                        height: auto;
                        margin-top: 10px;
                        border: solid 2px black;
                        display: inline-block;
                        margin-bottom: 10px;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;

                    }

                    #obs_ant {
                        width: 100%;
                        height: auto;
                        display: flex;
                        text-align: justify;
                    }

                    #imagen_ele {
                        width: 95%;
                        height: 120px;
                        border-radius: 5px;
                        margin-top: 5px;
                    }

                    #fot {
                        width: 15%;
                        height: 130px;
                        border-bottom: solid 2px black;
                    }

                    #i_ant {
                        width: 100%;
                        height: 21.7px;
                        border-right: solid 2px black;
                        border-bottom: solid 2px black;
                        display: flex;
                    }

                    #inf_ant {
                        width: 85%;
                        height: 130px;
                        display: inline-block;
                    }

                    .esp_if {
                        width: 100%;
                        display: flex;
                        height: 130px;

                    }


                    #tit_inv {
                        width: 100%;
                        height: 30px;
                        background: silver;
                        font-family: oswald;
                        font-size: 14px;
                        border-bottom: solid 2px black;
                    }

                    .dat_iden {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        display: inline-block;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    .hoja5 {
                        width: 1100px;
                        height: auto;
                        background: white;
                        margin-top: 20px;
                        display: inline-block;
                        margin-bottom: 5px;
                    }

                    #fi_2 {
                        width: 16.6%;
                        height: 100%;
                        border-right: solid 2px black;

                    }

                    #fi_1 {
                        width: 16.6%;
                        height: 100%;
                        border-right: solid 2px black;
                        background: silver;
                    }

                    #fi_12 {
                        width: 16.6%;
                        height: 100%;


                    }

                    .fir_pol {
                        width: 90%;
                        height: 30px;
                        border: solid 2px black;
                        display: flex;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    #info_pol_r {
                        width: 100%;
                        height: auto;
                        border-bottom: solid 2px black;
                    }

                    #info_pol_e {
                        width: 100%;
                        height: 30px;
                    }

                    .info_pol {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        border-top: none;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                        display: inline-block;
                    }

                    #d_pol_a4 {
                        width: 100%;
                        height: 100%;
                        border-right: solid 2px black;
                        display: inline-block;
                        background: silver;
                        align-items: center;
                        font-family: oswald;
                        font-size: 14px;
                    }

                    #d_pol_a3 {
                        width: 100%;
                        height: 100%;
                        border-right: solid 2px black;
                        display: flex;
                    }

                    #d_pol_a2 {
                        width: 30%;
                        height: 100%;
                        border-right: solid 2px black;
                        display: flex;
                    }

                    #d_pol_a {
                        width: 40%;
                        height: 100%;
                        border-right: solid 2px black;
                        display: flex;
                        background: silver;
                    }

                    #d_pol {
                        width: 100%;
                        height: 22.4px;
                        border-bottom: solid 2px black;
                        display: flex;
                    }

                    .dat_pol {
                        width: 90%;
                        height: 180px;
                        border: solid 2px black;
                        border-right: none;
                        display: inline-block;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    .hoja4 {
                        width: 1100px;
                        height: auto;
                        background: white;
                        margin-top: 20px;
                        display: inline-block;
                        margin-bottom: 5px;
                    }

                    #nom_iv2 {
                        width: 95%;
                        height: 50px;
                        font-family: barlow;
                        font-size: 14px;
                        border-top: solid 2px black;

                    }

                    #nom_iv {
                        width: 100%;
                        height: 50px;
                        font-family: oswald;
                        font-size: 14px;


                    }

                    #ar_f2 {
                        width: 33.39%;
                        height: 100%;
                        display: inline-block;
                    }

                    #ar_f {
                        width: 33.39%;
                        border-right: solid 2px black;
                        height: 100%;
                        display: inline-block;
                    }

                    .responsables {
                        width: 90%;
                        height: 110px;
                        border: solid 2px black;
                        border-top: 0;
                        display: flex;
                    }

                    #dat_tec {
                        width: 100%;
                        height: auto;
                        display: flex;

                    }

                    #dat_tec_ana {
                        width: 100%;
                        height: auto;
                        display: inline-block;

                    }


                    .sintesis_tec {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        border-top: 0;
                        display: inline-block;

                    }

                    .res_pre {
                        width: 90%;
                        height: 30px;
                        border: solid 2px black;
                        border-top: 0;
                        display: inline-block;

                    }

                    #txtso22 {
                        font-family: barlow;
                        font-size: 14px;
                        margin-left: 40px;
                        margin-right: 20px;
                        text-align: justify;
                    }

                    #txtso2 {
                        font-family: barlow;
                        font-size: 14px;
                        margin-left: 40px;
                        margin-right: 20px;
                        text-align: justify;
                    }

                    #txtso {
                        font-family: barlow;
                        font-size: 14px;
                        margin-left: 5px;
                        margin-right: 5px;
                    }

                    #dat_socie {
                        width: 50%;
                        height: 30px;
                        display: flex;
                    }

                    #fila_soc {
                        width: 100%;
                        height: 25px;

                        display: flex;
                    }

                    .dat_personales {
                        width: 90%;
                        height: 75px;
                        border: solid 2px black;
                        display: inline-block;
                    }

                    .hoja3 {
                        width: 1100px;
                        height: auto;
                        background: white;
                        margin-top: 20px;
                        display: inline-block;
                        margin-bottom: 5px;
                    }

                    .dra {
                        width: 100%;
                        height: auto;
                        font-family: oswald;
                        font-size: 14px;
                        display: inline-block;
                    }

                    .nom_fi {
                        width: 100%;
                        height: 30px;
                        background: silver;
                        border-bottom: solid 2px black;
                        font-family: oswald;
                        font-size: 14px;
                        display: inline-block;
                    }

                    #txtm2 {
                        font-family: barlow;
                        font-size: 14px;
                        text-align: left;
                        margin-left: 5px;
                    }

                    .fila_med {
                        width: 100%;
                        height: auto;
                        border-bottom: solid 2px black;
                        display: flex;
                    }

                    #e3 {
                        width: 30%;
                        height: auto;
                        border-right: solid 2px;
                        align-items: center;
                        justify-content: center;
                    }

                    #e4 {
                        width: 70%;
                        height: 100%;
                    }

                    #txtm {
                        font-family: oswald;
                        font-size: 14px;
                        text-align: center;
                        margin-top: 5px;
                    }

                    #encab_med {
                        width: 100%;
                        height: 40px;
                        border-bottom: solid 2px black;
                        display: flex;
                    }

                    #e1 {
                        width: 30%;
                        height: 100%;
                        border-right: solid 2px;
                        background: silver;
                    }

                    #e2 {
                        width: 70%;
                        height: 100%;
                        background: silver;

                    }

                    .tabla_resultados {
                        width: 90%;
                        height: auto;
                        border: solid 2px black;
                        display: inline-block;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    #corp_n {
                        width: 90%;
                        height: 23px;
                        border-bottom: solid 2px black;
                        margin-left: 10px;
                        font-family: barlow;
                        font-size: 14px;
                        text-align: left;
                    }

                    #corp_med {
                        width: 90%;
                        height: 25px;

                        margin-right: 10px;
                        display: flex;
                    }

                    #cor_reg {
                        width: 100%;
                        height: 25px;
                        display: flex;
                    }

                    #div_cat {
                        width: 88%;
                        height: 23px;
                        border-bottom: solid 2px black;
                        margin-left: 10px;
                        font-family: barlow;
                        font-size: 14px;
                        text-align: left;
                    }

                    #cat {
                        width: 100%;
                        height: 25px;
                        display: flex;
                    }

                    .dat_med {
                        width: 90%;
                        height: 100px;
                        margin-top: 20px;
                        display: inline-block;
                    }

                    #cod_cu1 {
                        width: 4%;
                        height: 100%;
                        border: solid 2px black;
                        margin-left: 7px;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #cod_cu {
                        width: 4%;
                        height: 100%;
                        border: solid 2px black;
                        border-left: 0;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #rfc {
                        width: 100%;
                        height: 30px;
                        display: flex;
                    }

                    #cuip {
                        width: 100%;
                        height: 30px;
                        margin-bottom: 10px;
                        display: flex;
                    }

                    .cu_rf {
                        width: 90%;
                        height: 70px;
                        margin-top: 10px;
                        display: inline-block;


                    }

                    #anio {
                        width: 50%;
                        height: 25px;
                        border-bottom: solid 2px black;
                        margin-left: 5px;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #edad {
                        width: 200px;
                        height: 100%;

                        display: flex;
                    }

                    #sep {
                        width: 650px;
                        height: 100%;

                    }

                    #m {
                        width: 30px;
                        height: 25px;
                        border: solid 1px black;
                        font-family: oswald;
                        font-size: 14px;
                        text-align: center;
                    }

                    #f {
                        width: 30px;
                        height: 25px;
                        border: solid 1px black;
                        font-family: oswald;
                        font-size: 14px;
                        text-align: center;
                        margin-left: 20px;
                    }

                    .dat_per {
                        width: 90%;
                        height: 30px;
                        margin-top: 10px;
                        display: flex;
                    }

                    .dat {
                        width: 90%;
                        height: 30px;
                        display: flex;

                        margin-top: -25px;
                    }

                    #nom3 {
                        width: 300px;
                        height: 25px;
                        font-family: barlow;
                        font-size: 14px;

                    }

                    #nom2 {
                        width: 300px;
                        height: 25px;
                        border-bottom: solid 2px black;
                        font-family: barlow;
                        font-size: 14px;

                    }

                    #nom {
                        width: 100px;
                        height: 25px;

                    }

                    .dat_nom {
                        width: 90%;
                        height: 50px;
                        display: flex;
                    }

                    #circulo1 {
                        width: 50px;
                        height: 20px;
                        border-radius: 50%;
                        border: solid 2px black;
                        margin-left: 30px;

                    }

                    #txtp2 {
                        font-family: oswald;
                        font-size: 14px;
                        text-align: left;
                        margin-left: 1px;
                    }

                    #circulo2 {
                        width: 50px;
                        height: 20px;
                        border-radius: 50%;
                        border: solid 2px black;
                        margin-left: 30px;

                    }

                    #circulo3 {
                        width: 50px;
                        height: 20px;
                        border-radius: 50%;
                        border: solid 2px black;
                        margin-left: 30px;

                    }

                    #circulo4 {
                        width: 50px;
                        height: 20px;
                        border-radius: 50%;
                        border: solid 2px black;
                        margin-left: 30px;

                    }

                    #ev_r {
                        width: 25%;
                        height: 40px;

                        display: flex;
                    }

                    #reseva {
                        width: 100%;
                        height: 40px;
                        display: flex;
                    }

                    .encabeza {
                        width: 100%;
                        height: 40px;
                        margin-top: 1px;

                        margin-bottom: 5px;
                    }

                    #txtp {
                        font-family: oswald;
                        font-size: 14px;
                        text-align: left;
                        margin-left: 40px;
                    }

                    #nomeva {
                        width: 100%;
                        height: 30px;

                    }

                    .tipev {
                        width: 90%;
                        height: 70px;

                        display: inline-block;
                    }


                    #txt21 {
                        text-align: center;
                        font-family: oswald;
                        font-size: 16px;
                    }

                    .hoja2 {
                        width: 1100px;
                        height: auto;
                        background: white;
                        margin-top: 20px;
                        display: inline-block;
                        margin-bottom: 5px;
                    }

                    #txid {
                        font-family: oswald;
                        font-size: 14px;
                        text-align: right;
                    }

                    #textf {
                        font-family: barlow;
                        font-size: 10px;
                        text-align: left;
                        margin-left: 30px;
                    }

                    .foot {
                        width: 90%;
                        height: 90px;
                    }

                    #ced {
                        width: 80%;
                        height: 30px;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #nom_sup {
                        width: 80%;
                        height: 25px;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #tit {
                        width: 100%;
                        height: 50px;

                    }

                    #afirma {
                        width: 50%;
                        height: 2px;
                        background: black;
                    }

                    #supervisor {
                        width: 50%;
                        height: 100%;
                        display: inline-block;
                        font-family: oswald;
                        font-size: 14px;

                    }

                    .firmas {
                        width: 100%;
                        height: 120px;
                        display: flex;
                    }

                    #metod {
                        width: 155px;
                        font-family: oswald;
                        font-size: 14px;
                    }

                    #meto {
                        width: 645px;
                        text-align: left;
                        margin-left: 0px;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    #met {
                        width: 800px;
                        height: auto;
                        display: flex;
                        margin-top: 20px;
                    }

                    #texto {
                        margin-top: 8px;
                    }

                    #fi1 {
                        width: 50%;
                        height: 100%;
                        font-family: oswald;
                        font-size: 14px;
                        border-right: solid 2px black;

                    }

                    #fi2 {
                        width: 50%;
                        height: 100%;
                        font-family: barlow;
                        font-size: 14px;


                    }

                    #fi11 {
                        width: 50%;
                        height: 100%;
                        font-family: oswald;
                        font-size: 14px;
                    }

                    #fila_re {
                        width: 100%;
                        height: 42.85px;
                        border-bottom: solid 2px black;
                        display: flex;
                    }

                    .tabla_res {
                        width: 620px;
                        height: 300px;
                        border: solid 2px black;
                        display: inline-block;
                        border-bottom: 0;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    .enca_pru {
                        width: 100%;
                        height: 80px;
                        display: inline-block;
                    }

                    #muestra {
                        width: 100%;
                        height: auto;
                        display: flex;
                    }

                    #tx5 {
                        text-align: left;
                        font-family: oswald;
                        font-size: 14px;
                    }

                    #tx6 {
                        margin-left: 10px;
                        font-family: barlow;
                        font-size: 14px;
                    }

                    .datos_ev {
                        width: 750px;
                        height: 150px;
                        display: inline-block;
                    }

                    #sexo1 {
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        width: 20%;
                        border-right: solid 2px black;
                    }

                    #sexo2 {
                        text-align: center;
                        font-family: barlow;
                        font-size: 14px;
                        width: 20%;

                    }

                    #edad2 {
                        text-align: center;
                        font-family: barlow;
                        font-size: 14px;
                        width: 30%;
                        border-right: solid 2px black;
                    }

                    #edad1 {
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        width: 30%;
                        border-right: solid 2px black;
                    }

                    #fila2_nombre {
                        width: 100%;
                        height: 50%;
                        display: flex;
                    }

                    #nom_nombre {
                        text-align: center;
                        font-family: barlow;
                        font-size: 14px;
                        width: 70%;
                    }

                    #tit_nombre {
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                        width: 30%;
                        border-right: solid 2px black;
                    }

                    #fila1_nombre {
                        width: 100%;
                        height: 50%;
                        border-bottom: solid 2px black;
                        display: flex;
                    }

                    .tabla_nombre {
                        width: 850px;
                        height: 45px;
                        border: solid 2px black;
                        margin-top: 20px;
                        display: inline-block;
                        margin-bottom: 15px;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                    }

                    #tx {
                        text-align: center;
                        font-family: oswald;
                        font-size: 14px;
                    }

                    #tx2 {
                        text-align: center;
                        font-family: oswald;
                        font-size: 20px;
                    }

                    #tx3 {
                        text-align: right;
                        font-family: barlow;
                        font-size: 14px;

                    }

                    #tx4 {
                        text-align: center;
                        font-family: barlow;
                        font-size: 16px;

                    }

                    .encabeza2 {
                        width: 1000px;
                        height: 150px;
                        display: inline-block;

                        margin-top: 10px;
                    }

                    #logo1 {
                        width: 210px;
                        height: 100%;

                    }

                    #logo2 {
                        width: 210px;
                        height: 100%;
                        margin-left: 20px;

                    }

                    #text1 {
                        text-align: center;
                        font-family: oswald;
                        width: 500px;
                        height: 100%;
                        margin-left: 15px;
                        margin-right: 30px;
                        font-size: 18px;

                    }

                    .encabezado {
                        width: 1000px;
                        height: 120px;
                        display: flex;

                        margin-top: 20px;
                    }

                    .hoja1 {
                        width: 1100px;
                        height: 1200px;
                        background: white;
                        margin-top: 20px;
                        display: inline-block;
                        margin-bottom: 5px;
                    }

                    .visor {
                        width: 1900px;
                        height: 650px;
                        border: outset 2px black;
                        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                        background: rgb(50, 54, 52);
                        overflow-y: scroll;

                    }

                    *::selection {
                        background: none;
                    }

                    *::-moz-selection {
                        background: none;
                    }
                    </style>
                    <?php
                } else
                    header("Location: " . $xPath . "exit.php");
                    ?>