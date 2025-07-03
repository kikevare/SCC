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
   include_once($xPath."includes/programacion.class.php");
   include_once($xPath."includes/catalogos.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xCat = New Catalog();

   //-------- Define el id del m�dulo y el perfil de acceso -------//
   if( isset($_GET["menu"]) ) $_SESSION["menu"] = $_GET["menu"];
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsxCtrlEval   = $xPath."includes/js/evesocial/socioe/xctrlhis.js?v=".rand();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title>SCC :: Menu principal</title>
    <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
    <!-- links css de actualizacion-->
    <?php $xSys->getLinks($xPath,1); ?>
    <!-- scripts js de actualizacion-->
    <?php $xSys->getScripts($xPath,1);  ?>
    <script type="text/javascript" src="<?php echo $jsxCtrlEval;?>"></script>
    <script type="text/javascript">
    var xHoldColor = "";
    var xHoldIdColor = "";

    $(document).ready(function() {
        xShowMenu();
        xGrid();
        xCtrlEval();
    });
    </script>

    <style type="text/css">
    .stytbDatosPer {
        width: 850px;
        border-top: 1px solid #cccccb;
        border-bottom: 1px solid #cccccb;
        margin: 5px 0 0 0;
    }

    .stytbDatosPer td {
        font-size: 9pt;
        padding: 5px 3px 5px 3px;
    }

    .styxBtnOpcion {
        width: 70px;
        font-size: 8pt;
        font-weight: normal;
        font-family: arial, helvetica, sans-serif;
    }

    .stytbResultados {
        width: 670px;
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

    #tbxEval {
        width: 90%;
    }

    #tbxEval td {
        padding: 3px;
        text-align: center;
        vertical-align: middle;
    }

    #tbxEval td label {
        font-family: arial, sans-serif;
        font-size: 11pt;
        margin-left: 4px;
        cursor: pointer;
        vertical-align: middle;
    }

    #tbxEval .txtHora {
        text-align: center;
        font-family: arial, sans-serif;
        font-size: 12pt;
        width: 60px;
        height: 18px;
    }

    .tbStatEval {
        width: 100%;
        border-top: 1px solid #cccccb;
        border-bottom: 1px solid #cccccb;
        border-collapse: collapse;
        /*margin-top: 10px;*/
        margin-bottom: 8px;
    }

    .tbStatEval td {
        text-align: center;
        font-family: arial, sans-serif, serif;
        font-size: 8pt;
        font-weight: bold;
        padding: 3px;
        color: gray;
    }

    .tbStatEval td a {
        font-size: 8pt;
        text-decoration: none;
    }

    .tbStatEval td a:hover {
        font-size: 8pt;
        text-decoration: underline;
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
                <form name="fForm" id="fForm" method="post" action="" enctype="application/x-www-form-urlencoded">
                    <div id="xdvContenedor" class="styContenedor">
                        <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      //-- Muestra el nombre del m�dulo actual, tomando la sesi�n...
      $xSys->getNameMod($_SESSION["menu"], "Generar Oficios");
      //--------------------------------------------------------------------------//

      //------------------------ Recepcion de par�metros -------------------------//
      if( isset($_GET["curp"]) ){
         $xPersona = New Persona($_GET["curp"]);
         $_SESSION["xCurp"] = $xPersona->CURP;
      }
      else
         $xPersona = New Persona($_SESSION["xCurp"]);

      $idOrd      = 3;
      $tipoOrd    = "Desc";
      //--------------------------------------------------------------------------//

      $bandDlg = false;
      $xProg = New Programacion();
      //-- Si el llamado de este m�dulo fu� a partir del m�dulo de captura de elementos y siguiendo el proceso normal...
      $prog_vigente = $xProg->getLastIdProgVigente($_SESSION["xCurp"]);
      if( (isset($_SESSION["xIdProgPre"]) && $_SESSION["xIdProgPre"] != -1) || $prog_vigente > 0 ){
         if( $prog_vigente > 0 ){
            $xDat = $xProg->getDatPersonaProg($prog_vigente);
            $_SESSION["xIdProgPre"] =  $prog_vigente;
            $_SESSION["xTipoEvalProg"] = $xDat["ID_TP_EVAL"];
         }
         $bandDlg = true;
      }
      //-- Si el llamado fu� por que se encontr� una coincidencia de algun elemento ya registrado...
      else if( isset($_GET["id_prog_pre"]) ){
         $xDat = $xProg->getDatPersonaProg($_GET["id_prog_pre"]);
         $_SESSION["xIdProgPre"]= $_GET["id_prog_pre"];
         $_SESSION["xTipoEvalProg"] = $xDat["ID_TP_EVAL"];
         $bandDlg = true;
      }
      else{
         /*
         $Rslt = $xProg->chkProgPreliminar($xPersona->NOMBRE." ".$xPersona->APATERNO." ".$xPersona->AMATERNO);
         if( $Rslt["RESULT"] != 0 ){
            $_SESSION["xIdProgPre"] = $Rslt["ID_PROG"];
            $_SESSION["xTipoEvalProg"] = $Rslt["TP_EVAL"];
         }
         else{
         */
            $_SESSION["xIdProgPre"] = -1;
            $_SESSION["xTipoEvalProg"] = -1;
         //}
      }
      /*
      $xProg = New Programacion();
      //-- Si el llamado de este m�dulo no fu� por el proceso definido de la programaci�n,
      //-- entonces se marcan los datos de la sesi�n para que no se pueda registrar una nueva evaluaci�n...
      $prog_vigente = $xProg->getLastIdProgVigente($_SESSION["xCurp"]);
      if( !isset($_SESSION["xIdProgPre"]) && $prog_vigente == 0 ){
         $_SESSION["xIdProgPre"]= -1;
         $_SESSION["xTipoEvalProg"] = -1;
      }
      else if( $prog_vigente > 0 ){
         $xDat = $xProg->getDatPersonaProg($prog_vigente);
         $_SESSION["xIdProgPre"]= $prog_vigente;
         $_SESSION["xTipoEvalProg"] = $xDat["ID_TP_EVAL"];
      }
      */

      //foto
      $xfoto = $xPersona->getFoto();
       if( !empty($xfoto) )
          $xfoto = $xPath.$xfoto;
       else
          $xfoto = $xPath."imgs/sin_foto.png";  
        $fecha = date('m/Y');
        $id_of = $_GET['id_of'];
        $dbname = "bdceecc";
    $dbuser = "root";
    $dbhost = "localhost";
    $dbpass = 'root';
     /*$dbname ="bdceecc";
     $dbuser="root";
     $dbhost="10.24.2.25";
     $dbpass='4dminMy$ql$';*/

          $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
          $sql = "SELECT n_conse FROM registro_oficios order by n_conse desc";
          $resulnofi = mysqli_query($conexion, $sql);
          $oficio_r = mysqli_fetch_assoc($resulnofi);
          $n_conse = $oficio_r['n_conse']+1;
          $numero_oficio = "CEEYCC/".$n_conse."/".$fecha;
          function solicita($curp,$conexion)
          {
            $sql1="SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$curp'";
            $resultado_n = mysqli_query($conexion, $sql1);
            $oficio_r = mysqli_fetch_assoc($resultado_n);
            $nombre = $oficio_r['nombre']." ".$oficio_r['a_paterno']." ".$oficio_r['a_materno'];
            echo $nombre;
          }
          function datos($conexion,$xPath)
                                {
                                    $sql2 = "SELECT * from registro_oficios order by n_conse asc";
                                    $resultado = mysqli_query($conexion, $sql2);
                                    while($fila_res = mysqli_fetch_assoc($resultado)){ ?>
                                    <section class="fila">
                                    <div id="columna2"><?php echo $fila_res['numero_oficio']     ?></div>
                                    <div id="columna2"><?php echo $fila_res['fecha']     ?></div>
                                    <div id="columna2"><?php echo $fila_res['asunto']     ?></div>
                                    <div id="columna2"><?php echo $fila_res['area']     ?></div>
                                    <div id="columna2"><?php echo $fila_res['dependencia']     ?></div>
                                    <div id="columna2"><?php echo $fila_res['area_dep']     ?></div>
                                    <div id="columna2"><?php echo $fila_res['solicitante']     ?></div>
                                    <div id="columna2"><?php if ($fila_res['cancelado']==null||empty($fila_res['cancelado'])||$fila_res['cancelado']=="") {?>
                                   <a href="cancelar.php?id=<?php echo $fila_res['numero_oficio']    ?>"><img src="<?php echo $xPath;?>imgs/archivocan.png" alt="" width="45px" style="margin-top: 5px;"></a>
                                    <?php } if ($fila_res['cancelado'] == '1' ) {  ?>
                                        <img src="<?php echo $xPath;?>imgs/cancelado.png" alt="" width="45px" style="margin-top: 5px;">
                                        <?php  }     ?></div>
                                    <div id="columna2"><?php echo $fila_res['motivo_cancelado']     ?></div>
                                    </section>

                                    <?php     } }
      ?>
                        <style>
                        @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
                        @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&display=swap');

                        @keyframes aparecer {
                            from {
                                transform: translate(0, -200%);
                            }

                            50% {
                                transform: translate(0, 50%);
                            }

                            to {
                                transform: translate(0, 0);
                            }
                        }

                        .menu {
                            width: 320px;
                            height: 100%;
                            border-right: solid 2px black;
                            display: inline-block;
                        }

                        .contenido {
                            width: 1900px;
                            height: 802px;
                            border: solid 2px black;
                            display: flex;
                        }

                        .ti_menu {
                            width: 100%;
                            height: 70px;
                            border-bottom: solid 2px black;
                            background: #2b547e;
                            display: flex;
                            color: white;
                            font-size: 40px;
                            font-family: oswald;
                        }

                        .opcion {
                            width: 100%;
                            height: 50px;
                            border-bottom: solid 2px black;
                            display: flex;
                            font-size: 40px;
                            font-family: oswald;
                        }

                        #b_gen {
                            width: 100%;
                            display: flex;
                            border: none;
                            background: white;
                        }

                        .tx_m {
                            width: 60%;
                            height: 50%;
                            text-align: left;
                            font-size: 18px;
                            font-family: oswald;
                            margin-top: 7px;
                            margin-left: 30px;
                        }

                        #b_gen:hover {
                            background: #2b547e;
                            color: white;
                            border-radius: 50px;
                            cursor: pointer;
                            transition: 1s;

                        }

                        .datos_gen {
                            width: 100%;
                            height: 100%;
                            display: inline-block;
                        }

                        .tit_t {
                            width: 100%;
                            font-size: 20px;
                            font-family: oswald;

                        }

                        #separador {
                            width: 40%;
                            height: 7px;
                            background: #2b547e;
                            background: linear-gradient(90deg, #2b547e 0%, #fff7f7 90%);
                            padding-top: 0;
                            margin-top: -10px;
                            border-radius: 10px;
                            margin-bottom: 20px;
                        }

                        #info_rellenar {
                            width: 100%;
                            height: 40px;
                            display: inline-block;
                            font-family: oswald;
                            font-size: 18px;
                            animation: aparecer;
                            animation-duration: 3s;
                            animation-iteration-count: 1;

                        }

                        #info_rellenar input {
                            font-family: barlow;
                            font-size: 15px;
                            border-radius: 5px;
                            width: 270px;
                        }

                        #info_rellenar select {
                            font-family: barlow;
                            font-size: 15px;
                            height: 80%;
                            width: 270px;
                        }

                        #separador2 {
                            width: 40%;
                            height: 7px;
                            background: #2b547e;
                            background: linear-gradient(90deg, #fff7f7 0%, #2b547e 90%);
                            padding-top: 0;
                            margin-top: 10px;
                            border-radius: 10px;
                            margin-bottom: 10px;
                        }

                        #b_guar {
                            margin-top: 30px;
                            width: 120px;
                            height: 40px;
                            border: none;
                            background: white;
                            font-family: oswald;
                            font-size: 16px;
                            border-radius: 10px;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            animation: aparecer;
                            animation-duration: 3s;
                            animation-iteration-count: 1;
                        }
                        #tare 
                        {
                            animation: aparecer;
                            animation-duration: 3s;
                            animation-iteration-count: 1;
                        }

                        #b_guar:hover {
                            background: #2b547e;
                            color: white;
                            transition: 1s;
                            cursor: pointer;
                        }
                        #link:hover
                        {
                            background: #2b547e;
                            color: white;
                            border-radius: 50px;
                        }
                        </style>
                        <section class="contenido">
                            <section class="menu">
                                <div class="ti_menu"> OFFICE-GEN <img src="<?php echo $xPath;?>imgs/carp1.png" alt=""
                                        style="margin-left: 10px;"></div>
                                <div class="opcion">
                                        <a id="link" href="index.php" style="width: 100%; font-family: oswald; font-size: 15px; text-decoration: none;">Regresar<img
                                            src="<?php echo $xPath;?>imgs/puerta-abierta.png" alt="" width="40px">
                                    </a></div>
                            </section>
                            <section class="todo">
                            <p class="tit_t"> Motivo de Cancelacion </p>
                                <div id="separador"></div>
                            <textarea name="cancelar" id="tare" style="width: 700px; height: 500px; font-family: oswald; font-size: 14px;"></textarea>
                                <br><button name="guardar" id="b_guar"> Guardar</button>
                            </section>
<style>
.todo 
{
    width: 100%;
    height: 100%;
    display: inline-block;
}
</style>




                            <?php  if (isset($_POST['guardar'])) {
                                $motivo = $_POST['cancelar'];
                                $sql_up = "UPDATE registro_oficios set cancelado='1', motivo_cancelado='$motivo' where numero_oficio = '$id_of'";
                                $resed = mysqli_query($conexion, $sql_up);
                        if ($resed) {
                            echo "<script languaje='JavaScript'>
            alert('El Oficio ha Sido Cancelado...');
            
            </script>";
                        } else {
                            echo "<script languaje='JavaScript'>
            alert('no ha podido culminar el proceso');
            
            </script>";
                        }
                            } ?>

                        </section>
                        <?php 
}
else
   header("Location: ".$xPath."exit.php");
?>