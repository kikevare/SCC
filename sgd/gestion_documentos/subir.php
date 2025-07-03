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
      $xSys->getNameMod($_SESSION["menu"], "Gestion de Documentos");
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
          $nom=$_GET['nom'];
          $fac = $_GET['fac'];
      ?>
                        <div id="modal1" class="modalmask">
                            <div class="modalbox movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <p id="tx_info">Agregar Nueva Dependencia:</p>
                                <div id="are_insert1">
                                    <p> Nombre de Dependencia: </p> <input name="area_in" type="text">
                                </div>
                                <button type="submit" name="b_gmodal1" id="b_modal1">Guardar</button>
                            </div>

                        </div>
                        
                        <div id="modal3" class="modalmask">
                            <div class="modalbox movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <section class="crear">
                                    <p id="tx_info">Crear Folio de Envio</p>
                                </section>
                                <section class="crear_ex">
                                    <form method="POST">
                                        <input type="submit" name="crear" value="Crear Folio" id="crear">
                                    </form>
                                    
                                    <form action="" method="POST" enctype="multipart/form-data" id="for">
                                        <input multiple type="file" name="image" id="arc" />
                                        <input type="submit" value="Subir Archivo" id="ace" />
                                    </form>
                                </section>
                                
                            </div>

                        </div>
                        <div>
                            
                            <?php 
                            
                if (isset($_POST['crear2'])) {
                    if (!file_exists('./Archivos/Acuse/' . $nom . '/')) {
                        mkdir('./Archivos/Acuse/' . $nom . '/', 0777, true);
                        
                    } else {
                        echo "<script languaje='JavaScript'>
                    alert('El expediente digital ya existe...');
                    </script>";
                    }
                }
                ?>
                            <?php
                if (isset($_FILES['image2'])) {

                    $errors = array();
                    $file_name = $_FILES['image2']['name'];
                    $file_size = $_FILES['image2']['size'];
                    $file_tmp = $_FILES['image2']['tmp_name'];
                    $file_type = $_FILES['image2']['type'];
                    $file_ext = strtolower(end(explode('.', $_FILES['image2']['name'])));

                    $expensions = array("jpeg", "jpg", "png", "pdf");

                    if (in_array($file_ext, $expensions) === false) {
                        $errors[] = "El formato del archivo no es permitido, solo PDF e Imagenes.";
                    }

                    if ($file_size > 10000000) {
                        $errors[] = 'El tamaño del archivo debe ser maximo 10 MB';
                    }

                    if (empty($errors) == true) {
                        move_uploaded_file($file_tmp, './Archivos/Acuse/' . $nom . '/' . $nom.$file_name);
                        echo "<script languaje='JavaScript'>
         alert('El Archivo se subio con exito al Expediente Digital...');
         </script>";
                    
                    } else {
                        echo "<script languaje='JavaScript'>
         alert('El archivo no pudo subirse al expediente, es demasiado pesado o no es un formato compatible');
         </script>";
                    }
                }
                $contador=0;
                ?>
                        </div>
                        
                        <?php 

                        
    $dbname = "bdceecc";
    $dbuser = "root";
    $dbhost = "localhost";
    $dbpass = 'root';
    /* $dbname ="bdceecc";
     $dbuser="root";
     $dbhost="10.24.2.25";
     $dbpass='4dminMy$ql$';*/
     
          $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
          $sql_folio = "SELECT numero_oficio,n_fila FROM informacion_sgd where curp_usuario = '$xUsr->xCurpEval' order by n_fila desc";
          $resulfolio = mysqli_query($conexion, $sql_folio);
          $folio_fila = mysqli_fetch_assoc($resulfolio);
          $sql_espera = "SELECT * FROM informacion_sgd where curp_usuario ='$xUsr->xCurpEval' and estatus='1'";
          $resulespera = mysqli_query($conexion, $sql_espera);
          $sql_todos = "SELECT * FROM informacion_sgd";
          $resultodos = mysqli_query($conexion, $sql_todos);
          $fecha = date('d-m-y');
          $sql = "select * from registro_entornosocial where curp_evaluador != '0' and fecha ='$fecha' order by fecha_completa desc limit 2";
          $res = mysqli_query($conexion, $sql); 
          $sql2 = "select * from registro_entornosocial where curp_evaluador != '0' and fecha ='$fecha' order by fecha_completa desc";
          $resu = mysqli_query($conexion, $sql2); 
          $fec_hoy = date('d-m-y');
          $sql3 = "select * from contexto_corporacion where id_corporacion = '1'";
          $resultado = mysqli_query($conexion, $sql3); 
          $sql10 = "select nombre, a_paterno, a_materno from tbdatospersonales where curp = '" . $xUsr->xCurpEval . "'";
         $resul6 = mysqli_query($conexion, $sql10);
         $fil7 = mysqli_fetch_assoc($resul6);
         $nom_eval = $fil7['a_paterno']." ".$fil7['a_materno']." ".$fil7['nombre'];
          $fecha_hoy = $fec_hoy;
                        $mesn = $fecha_hoy[3].$fecha_hoy[4];
                        if ($mesn=='01') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." ".  "DE ENERO DEL"." ".date('Y');
                        }
                        if ($mesn=='02') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE FEBRERO DEL"." ".date('Y');
                        }if ($mesn=='03') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE MARZO DEL"." ".date('Y');
                        }if ($mesn=='04') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE ABRIL DEL"." ".date('Y');
                        }if ($mesn=='05') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE MAYO DEL"." ".date('Y');
                        }if ($mesn=='06') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE JUNIO DEL"." ".date('Y');
                        }if ($mesn=='07') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE JULIO DEL"." ".date('Y');
                        }if ($mesn=='08') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE AGOSTO DEL"." ".date('Y');
                        }if ($mesn=='09') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." "."DE SEPTIEMBRE DEL"." ".date('Y');
                        }if ($mesn=='10') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." ". "DE OCTUBRE DEL"." ".date('Y');
                        }if ($mesn=='11') {
                            $meslargo = $fecha_hoy[0].$fecha_hoy[1]." ". "DE NOVIEMBRE DEL"." ".date('Y');
                        }if ($mesn=='12') {
                            $meslargo = $fecha_hoy[0].$$fecha_hoy[1]." ". "DE DICIEMBRE DEL"." ".date('Y');
                        }
                        $carpeta=$folio_fila['numero_oficio']."_"."solicitud";
                        function imagen_proceso($stat,$xPath)
                        {
                            if ($stat==1) { ?>
                        <img src="<?php echo $xPath;?>imgs/tiempo-restante.png" alt="" width="50px"
                            style="margin-right: 7px; margin-left: 2px; margin-top: 10px;"><br>
                        <p style="font-family: oswald; font-size: 14px; margin-top: 10px;">En espera de Respuesta</p>
                        <?php   }
                              if ($stat==2) { ?>
                        <img src="<?php echo $xPath;?>imgs/proceso.png" alt="" width="50px"
                            style="margin-right: 7px; margin-left: 2px; margin-top: 15px; margin-bottom: 5px;"><br>
                        <p style="font-family: oswald; font-size: 14px;">En Proceso de Validacion</p>
                        <?php   }
                                if ($stat==3) { ?>
                        <img src="<?php echo $xPath;?>imgs/comprobado.png" alt="" width="40px"
                            style="margin-right: 7px; margin-left: 2px; margin-top: 10px;"><br>
                        <p style="font-family: oswald; font-size: 14px;">Proceso Concluido</p>
                        <?php   }
                        }
                        function documento_solicitud ($folio_soli, $xPath)
                        {
                            
                            if (file_exists('Archivos/Oficio_solicitud/' . $folio_soli . '/'))
                            { 
                                $ruta = './Archivos/Oficio_solicitud/' . $folio_soli . '/';
                        if (is_dir($ruta)) {
                            $gestor = opendir($ruta);
                            while (($archivo = readdir($gestor)) !== false) {
                                
                                $rutacompleta = $ruta . "/" . $archivo;
                                
                                if ($archivo != "." && $archivo != "..") {

                                    if (is_dir($rutacompleta)) { ?>
                        <div class="mostrar_archivos">
                            <div id="nombre"><?php echo "-->", $archivo ?></div>
                        </div>
                        <?php } else { ?>
                        <a href="<?php echo $rutacompleta ?>"><img src="<?php echo $xPath;?>imgs/pdf_loge.png" alt=""
                                width="45px" style="margin-right: 7px; margin-left: 2px; margin-top: 10px;"></a><p style="font-family: oswald; font-size: 14px; margin-top: 5px">Documento Enviado</p>
                        <?php   }
 }
  }
   }
                        } }

                        function documento_respuesta ($folio_soli, $xPath)
                        {
                            if (file_exists('Archivos/Oficio_respuesta/' . $folio_soli . '/'))
                            { 
                                $ruta = './Archivos/Oficio_respuesta/' . $folio_soli . '/';
                        if (is_dir($ruta)) {
                            $gestor = opendir($ruta);
                            while (($archivo = readdir($gestor)) !== false) {
                                
                                $rutacompleta = $ruta . "/" . $archivo;
                                
                                if ($archivo != "." && $archivo != "..") {

                                    if (is_dir($rutacompleta)) { ?>
                        <?php } else { ?>
                        <a href="<?php echo $rutacompleta ?>"><img src="<?php echo $xPath;?>imgs/pdf_loge.png" alt=""
                                width="45px" style="margin-right: 7px; margin-left: 2px; margin-top: 10px;"></a><p style="font-family: oswald; font-size: 14px; margin-top: 5px">Documento Enviado</p>
                        <?php   }
 }
  }
   }
                        }else 
                    { ?>
                        <img src="<?php echo $xPath;?>imgs/archivo.gif" alt="" width="65px"
                            style="margin-right: 7px; margin-left: 7px; margin-top: 10px;"> <br>
                        <p style="font-family: oswald; font-size: 14px;">En espera de Respuesta</p>
                        <?php   } }
        function documento_acuse ($folio_soli, $xPath)
        {
            if (file_exists('Archivos/Acuse/' . $folio_soli. '/'))
            { 
                $ruta = './Archivos/Acuse/' . $folio_soli . '/';
        if (is_dir($ruta)) {
            $gestor = opendir($ruta);
            while (($archivo = readdir($gestor)) !== false) {
                
                $rutacompleta = $ruta . "/" . $archivo;
                
                if ($archivo != "." && $archivo != "..") {

                    if (is_dir($rutacompleta)) { ?>
                        <?php } else { ?>
                        <a href="<?php echo $rutacompleta ?>"><img src="<?php echo $xPath;?>imgs/pdf_loge.png" alt=""
                                width="45px" style="margin-right: 7px; margin-left: 5px; margin-top: 10px;"></a><p style="font-family: oswald; font-size: 14px; margin-top: 5px">Documento Enviado</p>

                        <?php   }
}
}
}
        }else 
    { ?>
                        <a id="sub" href="index.php?nom=<?php echo $folio_soli ?> "><img src="<?php echo $xPath;?>imgs/archivo.png" alt="" width="60px"
                                style="margin-right: 7px; margin-left: 10px; margin-top: 10px;"></a><br>
                        <p style="font-family: oswald; font-size: 14px; margin-top: 5px">Subir Acuse de Oficio</p>
                        <?php   } }                
          
?>

<div id="modal2" class="modalmask">
                            <div class="modalbox movedown">
                                <a href="#close" title="Close" class="close">X</a>
                                <p id="tx_info">Agregar Nueva Area:</p>
                                <div id="are_insert1">
                                    <p> Nombre de Area: </p> <input name="area_inde" type="text">
                                </div>
                                <div id="are_insert1">
                                    <p> Dependencia: </p> <select name="area_indea" id="">
                                        <option value="0">--Seleccione--</option><?php $sqla = "SELECT * from dependencias_sgd ";
                                        $resultadoa = mysqli_query($conexion, $sqla);
                                            while ($filaa = mysqli_fetch_assoc($resultadoa)) {   ?> <option
                                            value="<?php echo $filaa['id_dependencia'] ?> ">
                                            <?php echo $filaa['dependencia'] ?> </option><?php  } ?>
                                    </select>
                                </div>
                                <input type="submit" name="b_gmodal2" id="b_modal1" value="Guardar">
                            </div>

                        </div>
                        <style>
                        @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
                        @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Oswald&display=swap');

                        #sub:hover {
                            cursor: pointer;
                        }

                        .all_content {
                            max-width: 100%;
                            min-width: 100%;
                            height: 800px;
                            border: solid 2px black;
                            display: flex;
                        }

                        .menu {
                            width: 250px;
                            border-right: solid 2px black;
                            height: 800px;
                            display: inline-block;
                            background: white;
                            border-bottom: solid 2px black;
                            border-radius: 5px;
                        }

                        #prese {
                            width: 100%;
                            height: 70px;
                            border-bottom: solid 2px black;
                            display: flex;
                            background: rgb(184, 52, 25);
                        }

                        #text_prese {
                            width: 50%;
                            height: 100%;
                            margin-left: 5px;
                            font-family: oswald;
                            font-size: 40px;
                            color: white;
                        }

                        #lista {
                            width: 100%;
                            height: 50px;


                        }

                        #b_menu {
                            font-family: oswald;
                            font-size: 16px;
                            color: black;
                            width: 100%;
                            height: 100%;
                            border: 0;
                            background: white;
                            border-bottom: solid 2px black;
                        }

                        #b_menu:hover {
                            background: rgb(184, 52, 25);
                            color: white;
                            cursor: pointer;
                            border-radius: 20px;
                            border-bottom: 0;
                            transition: 1s;
                        }

                        #nuevo_d {
                            width: 100%;
                            height: 800px;
                            display: inline-block;
                        }

                        #tx_info {
                            width: 100%;
                            height: 30px;
                            font-family: oswald;
                            font-size: 20px;
                        }

                        #separador {
                            width: 30%;
                            height: 7px;
                            background: #760707;
                            background: linear-gradient(90deg, #760707 0%, #fff7f7 90%);
                            padding-top: 0;
                            margin-top: -10px;
                            border-radius: 10px;
                            margin-bottom: 20px;
                        }

                        #separador2 {
                            width: 30%;
                            height: 7px;
                            background: #760707;
                            background: linear-gradient(90deg, #fff7f7 0%, #760707 90%);
                            padding-top: 0;
                            margin-top: -5px;
                            border-radius: 10px;
                            margin-bottom: 10px;
                        }


                        #cap {
                            width: 60%;
                            height: 30px;
                            display: flex;
                            margin-bottom: 30px;
                            animation-duration: 2s;
                            animation-name: animLogo;
                            animation-iteration-count: 1;

                        }

                        #cap input {
                            width: 30%;
                            height: 100%;
                            font-family: barlow;
                            font-size: 14px;
                            border: none;
                            border-bottom: solid 1px black;
                            border-radius: 10px;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                        }

                        #cap select {
                            background: white;
                            border-radius: 10px;
                            font-family: barlow;
                            font-size: 15px;
                            width: 220px;
                            text-align: left;
                        }

                        #cap img:hover {
                            cursor: pointer;
                        }

                        #tx_if {
                            font-family: oswald;
                            font-size: 18px;
                            width: 40%;
                            height: 100%;
                            text-align: right;
                            margin-right: 10px;
                        }

                        #b_env {
                            width: 100px;
                            height: 40px;
                            font-family: oswald;
                            font-size: 16px;
                            border: none;
                            background: white;
                            border-radius: 10px;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            margin-bottom: 25px;
                            animation-duration: 2s;
                            animation-name: animLogo;
                            animation-iteration-count: 1;

                        }

                        #b_env2 {
                            width: 50px;
                            height: 40px;
                            font-family: oswald;
                            font-size: 16px;
                            border: none;
                            background: white;
                            border-radius: 10px;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            margin-bottom: 25px;
                            animation-duration: 2s;
                            animation-name: animLogo;
                            animation-iteration-count: 1;

                        }

                        #b_env:hover {
                            background: rgb(184, 52, 25);
                            color: white;
                            transition: 1s;
                            cursor: pointer;
                        }

                        @keyframes animLogo {
                            from {
                                transform: translate(0, -200%);
                            }

                            to {
                                transform: translate(0, 0);
                            }
                        }
                        #termina 
                        {
                            width: 100px;
                            height: 40px;
                            margin-top: 15px;
                            background: white;
                            border-radius: 10px;
                            font-size: 16px;
                            font-family: oswald;
                        }
                        #termina:hover 
                        {
                            background: red;
                            color: white;
                            cursor: pointer;
                            transition: 1s;
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

                        #are_insert1 {
                            width: 80%;
                            height: auto;
                            display: flex;
                        }

                        #are_insert1 p {
                            width: 60%;
                            height: 40px;
                            font-family: oswald;
                            font-size: 16px;

                        }

                        #are_insert1 input {
                            width: 50%;
                            height: 25px;
                            font-family: barlow;
                            font-size: 13px;

                        }

                        #are_insert1 select {
                            width: 50%;
                            height: 25px;
                            font-family: barlow;
                            font-size: 13px;
                            background: white;
                            border: solid 1px black;
                            border-radius: 5px;
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

                        #form {
                            display: flex;
                            width: 100%;
                            height: 70px;
                            border: solid 2px black;
                        }
                        .crear 
                        {
                            width: 1600px;
                            height: 400px;
                           
                        }

                        .crear_ex input  {
                            background: white;
                            border: none;
                            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
                            font-family: oswald;
                            font-size: 18px;
                            max-width: 220px;
                            border-radius: 10px;
                            height: 30px;

                        }

                        .crear_ex input:hover {
                            background: rgb(184, 52, 25);
                            color: white;
                            transition: 1s;
                            cursor: pointer;
                        }

                        #titulo {
                            width: 100%;
                            height: 80px;
                            display: inline-block;
                        }
                        </style>

                        <section class="all_content">
                            <section class="menu">
                                <div id="prese">
                                    <p id="text_prese">SGD</p><img src="<?php echo $xPath;?>imgs/CORREO.png" alt="">
                                </div>
                               <a style="text-decoration: none; width: 100%; height: 40px; border-bottom: solid 2px black; color: red;" href="index.php"> <div id="lista" style="border-bottom: solid 2px black;"><img
                                            src="<?php echo $xPath;?>imgs/puerta-abierta.png" alt="" width="35px"
                                            style="margin-right: 10px; margin-left: -10px; ">Regresar
                                </div></a>
                               

                            </section>
                            <div >
                                
                                <section class="crear">
                                    <p id="tx_info">Crear Folio de Acuse</p>
                                    <div id="separador"></div>
                                <section class="crear_ex">
                                    <form method="POST">
                                        <input type="submit" name="crear2" value="Crear Folio" id="crear">
                                    </form>
                                    
                                    <form action="" method="POST" enctype="multipart/form-data" id="for">
                                        <input multiple type="file" name="image2" id="arc" />
                                        <input type="submit" value="Subir Archivo" id="ace" />
                                    </form>
                                    <button name="terminar" id="termina">Terminar</button>
                                </section>
                                </section>
                            </div>
                            <?php 
                            if (isset ($_POST['terminar'])) {
                                $sql_up = "UPDATE informacion_sgd set estatus=3 where numero_oficio = '$fac'";
                                $resed = mysqli_query($conexion, $sql_up);
                        if ($resed) {
                            echo "<script languaje='JavaScript'>
            alert('El proceso a terminado...');
            
            </script>";
                        } else {
                            echo "<script languaje='JavaScript'>
            alert('no ha podido culminar el proceso');
            
            </script>";
                        }
                            }
                if (isset($_POST['crear'])) {
                    if (!file_exists('./Archivos/Oficio_solicitud/' . $carpeta . '/')) {
                        mkdir('./Archivos/Oficio_solicitud/' . $carpeta . '/', 0777, true);
                        
                    } else {
                        echo "<script languaje='JavaScript'>
                    alert('El expediente digital ya existe...');
                    </script>";
                    }
                }
                ?>
                            <?php
                if (isset($_FILES['image'])) {

                    $errors = array();
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

                    $expensions = array("jpeg", "jpg", "png", "pdf");

                    if (in_array($file_ext, $expensions) === false) {
                        $errors[] = "El formato del archivo no es permitido, solo PDF e Imagenes.";
                    }

                    if ($file_size > 10000000) {
                        $errors[] = 'El tamaño del archivo debe ser maximo 10 MB';
                    }

                    if (empty($errors) == true) {
                        move_uploaded_file($file_tmp, './Archivos/Oficio_solicitud/' . $carpeta . '/' . $carpeta.$file_name);
                        echo "<script languaje='JavaScript'>
         alert('El Archivo se subio con exito al Expediente Digital...');
         </script>";
                    
                    } else {
                        echo "<script languaje='JavaScript'>
         alert('El archivo no pudo subirse al expediente, es demasiado pesado o no es un formato compatible');
         </script>";
                    }
                }
                $contador=0;
                ?>


                            <?php
                            if (isset($_POST['b_gmodal2'])) {
                                $sql_areas = "SELECT id_area FROM areas_dependencias order by id_area desc";
                                $resul = mysqli_query($conexion, $sql_areas);
                                $fila_area = mysqli_fetch_assoc($resul);
                                $id_area = $fila_area['id_area']+1;
                                $nom_area = $_POST['area_inde'];
                                $nom_dep = $_POST['area_indea'];
                                $query = "INSERT INTO areas_dependencias (id_area, nombre_area, id_dependencia) VALUES (?,?,?)";
                                $sentencia = mysqli_prepare($conexion, $query);
                                mysqli_stmt_bind_param($sentencia, "sss", $id_area, $nom_area, $nom_dep );
                                mysqli_stmt_execute($sentencia);
                                $filasafec = mysqli_stmt_affected_rows($sentencia); 
                                if ($filasafec == 1) {?>

                            <?php    } else {
                                    echo "<script languaje='JavaScript'>
                             alert('no');
                             window.reload;
                             </script>";
                                }
                            }
                            if (isset($_POST['b_gmodal1'])) {
                                $sql_dependencias = "SELECT id_dependencia FROM dependencias_sgd order by id_dependencia desc";
                                $resul = mysqli_query($conexion, $sql_dependencias);
                                $fila_dependencias = mysqli_fetch_assoc($resul);
                                $id_dep = $fila_dependencias['id_dependencia']+1;
                                $nom_dependencia = $_POST['area_in'];
                                $query = "INSERT INTO dependencias_sgd (dependencia, id_dependencia) VALUES (?,?)";
                                $sentencia = mysqli_prepare($conexion, $query);
                                mysqli_stmt_bind_param($sentencia, "ss", $nom_dependencia, $id_dep );
                                mysqli_stmt_execute($sentencia);
                                $filasafec = mysqli_stmt_affected_rows($sentencia); 
                                if ($filasafec == 1) {?>

                            <?php    } else {
                                    echo "<script languaje='JavaScript'>
                             alert('no');
                             window.reload;
                             </script>";
                                }
                            }
                            if (isset($_POST['nuevo'])) {
                                  ?>

                            <section id="nuevo_d">
                                <p id="tx_info">Captura de Informacion</p>
                                <div id="separador"></div>
                                <div id="cap">
                                    <p id="tx_if">Numero de Oficio:</p><input type="text" name="oficio">
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Fecha Recibido:</p><input type="date" name="fechare">
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Fecha de Oficio:</p><input type="date" name="fechaofi">
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Dependencia:</p><select name="dependencia" id="">
                                        <option value="0">--Seleccione--</option><?php $sqlde = "SELECT * from dependencias_sgd ";
                                        $resultado = mysqli_query($conexion, $sqlde);
                                            while ($filade = mysqli_fetch_assoc($resultado)) {   ?>
                                        <option value="<?php echo $filade['dependencia'] ?>">
                                            <?php echo $filade['dependencia'] ?></option>
                                        <?php } ?>
                                    </select><a href="#modal1"><img src="<?php echo $xPath;?>imgs/agregar-contacto.png"
                                            alt="" width="30px" style="margin-right: 7px; margin-left: 22px;"></a>
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Area:</p><select name="area_depe" id="">
                                        <option value="0">--Seleccione--</option><?php $sqlar = "SELECT * from areas_dependencias ";
                                        $resultadoar = mysqli_query($conexion, $sqlar);
                                            while ($filaar = mysqli_fetch_assoc($resultadoar)) {   ?> <option
                                            value="<?php echo $filaar['nombre_area'] ?> ">
                                            <?php echo $filaar['nombre_area'] ?> </option><?php  } ?>
                                    </select><a href="#modal2"><img src="<?php echo $xPath;?>imgs/agregar-contacto.png"
                                            alt="" width="30px" style="margin-right: 7px; margin-left: 22px;"></a>
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Asunto:</p><input type="text" name="asunto">
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Area de Asignacion:</p><select name="area_asig" id="">
                                        <option value="0">--Seleccione--</option>
                                        <?php $sqlasig = "SELECT area_eval from ctareaseval";
                                        $resultadoasig = mysqli_query($conexion, $sqlasig);
                                            while ($filasig = mysqli_fetch_assoc($resultadoasig)) {   ?> <option
                                            value="<?php echo $filasig['area_eval'] ?> ">
                                            <?php echo $filasig['area_eval'] ?> </option><?php  } ?>
                                    </select>
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Encargado del Area Asignada:</p><select name="responsable" id="">
                                        <option value="0">--Seleccione--</option>
                                        <option value="COSD770926HGRRNN19">Dan Martin Cortez Sanchez</option>
                                        <option value="MAFA880925MGRRLB01">Abimael Martinez Flores</option>
                                        <option value="GOAS851006MGRMRN02">Sandra Luz Gómez Arroyo</option>
                                        <option value="MAAO740116MMSRLL03">Olga Lidia Martínez Álvarez</option>
                                        <option value="DOMJ860525HGRMRR02">Jorge Domínguez Morales</option>
                                        <option value="OECD830628MGRRRL05">Dulce María Ortega Cruz</option>
                                        <option value="CUCG830320MVZRRM07">Gemima Cruz Crecencio</option>
                                        <option value="HEBA870430MGRRZR09">Aurea Hernandez Baza </option>
                                    </select>
                                </div>
                                <div id="cap">
                                    <p id="tx_if">Fecha de Asignacion:</p><input type="date" name="fechasig">
                                </div>

                                <button id="b_env" name="b_guardar"
                                    onClick=" window.location.href='#modal3'">Enviar</button>
                                <div id="separador2"></div>
                            </section>


                            <?php }
                            
                          if (isset($_POST['b_guardar'])) { ?>

                            <?php $estatus=1;
                            $nfila = $folio_fila['n_fila']+1;
                            $query = "INSERT INTO informacion_sgd (fecha_recibido, fecha_oficio,dependencia,area_dependencia,asunto,area_c3,fecha_asignacion,estatus,curp_usuario,numero_oficio,n_fila,curp_encargado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                                $sentencia = mysqli_prepare($conexion, $query);
                                mysqli_stmt_bind_param($sentencia, "ssssssssssss", $_POST['fechare'],$_POST['fechaofi'],$_POST['dependencia'],$_POST['area_depe'],$_POST['asunto'],$_POST['area_asig'],$_POST['fechasig'],$estatus,$xUsr->xCurpEval,$_POST['oficio'],$nfila,$_POST['responsable'] );
                                mysqli_stmt_execute($sentencia);
                                $filasafec = mysqli_stmt_affected_rows($sentencia); 
                                if ($filasafec == 1) {?>
                            <script languaje='JavaScript'>
                            alert('La informacion del documento ha sido agregada con exito');
                            </script>
                            <?php    } else {
                                    echo "<script languaje='JavaScript'>
                             alert('no');
                             </script>";
                                } 
                                
                                  }
                            if (isset($_POST['espera'])) {?>
                            <section id="res_all">
                                <section id="titulo">
                                    <p id="tx_info">Documentacion en espera de Respuesta</p>
                                    <div id="separador"></div>
                                </section>
                                <section id="tabla">


                                    <section id="encabezados">
                                        <div id="e_tabla">Numero de Oficio</div>
                                        <div id="e_tabla">Fecha Recibido</div>
                                        <div id="e_tabla">Fecha de Oficio</div>
                                        <div id="e_tabla">Fecha de Asignacion</div>
                                        <div id="e_tabla">Dependencia</div>
                                        <div id="e_tabla">Area</div>
                                        <div id="e_tabla">Asunto</div>
                                        <div id="e_tabla">Area de Asignacion</div>
                                        <div id="e_tabla">status</div>
                                    </section>
                                    <?php  while ($filaes = mysqli_fetch_assoc($resulespera)) {  ?>
                                    <section id="resultados">
                                        <div id="f_resultados"><?php  echo $filaes['numero_oficio']  ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['fecha_recibido']   ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['fecha_oficio']   ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['fecha_asignacion']   ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['dependencia']   ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['area_dependencia']   ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['asunto']   ?></div>
                                        <div id="f_resultados"><?php  echo $filaes['area_c3']   ?></div>
                                        <div id="f_resultados"><?php  imagen_proceso($filaes['estatus'],$xPath)    ?>
                                        </div>
                                    </section><?php   } ?>
                                </section>
                            </section>
                            <?php   } if (isset($_POST['bandeja'])) {?>
                            <section id="res_all">
                                <section id="titulo">
                                    <p id="tx_info">Toda la Documentacion Enviada</p>
                                    <div id="separador"></div>
                                </section>
                                <section id="tabla">


                                    <section id="encabezados">
                                        <div id="e_tabla2">Numero de Oficio</div>
                                        <div id="e_tabla2">Fecha Recibido</div>
                                        <div id="e_tabla2">Fecha de Oficio</div>
                                        <div id="e_tabla2">Fecha de Asignacion</div>
                                        <div id="e_tabla2">Dependencia</div>
                                        <div id="e_tabla2">Area</div>
                                        <div id="e_tabla2">Asunto</div>
                                        <div id="e_tabla2">Area de Asignacion</div>
                                        <div id="e_tabla2">Oficio de Solicitud</div>
                                        <div id="e_tabla2">Oficio de Respuesta</div>
                                        <div id="e_tabla2">Acuse de Oficio</div>
                                        <div id="e_tabla2">status</div>
                                    </section>
                                    <?php  while ($filatodos = mysqli_fetch_assoc($resultodos)) {  ?>
                                    <section id="resultados">
                                        <div id="f_resultados21"><b><?php  echo $filatodos['numero_oficio']  ?></b></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['fecha_recibido']   ?></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['fecha_oficio']   ?></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['fecha_asignacion']   ?></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['dependencia']   ?></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['area_dependencia']   ?></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['asunto']   ?></div>
                                        <div id="f_resultados2"><?php  echo $filatodos['area_c3']   ?></div>
                                        <div id="f_resultados2"><?php if ($carpeta=$filatodos['numero_oficio']."_"."solicitud") {
                                            echo documento_solicitud($carpeta,$xPath);
                                        }     ?>
                                        </div>
                                        <div id="f_resultados2"><?php if ($carpeta=$filatodos['numero_oficio']."_"."solicitud") { echo documento_respuesta($carpeta,$xPath); } ?>
                                        </div>
                                        <div id="f_resultados2"><?php if ($carpeta=$filatodos['numero_oficio']."_"."solicitud") {  echo documento_acuse($carpeta,$xPath); }   ?></div>
                                        <div id="f_resultados2">
                                            <?php  imagen_proceso($filatodos['estatus'],$xPath)    ?></div>
                                    </section><?php   } ?>
                                </section>
                            </section>
                            <?php   } ?>
                        </section>

                        <?php 
}
else
   header("Location: ".$xPath."exit.php");
?>
                        <style>
                        @keyframes aparecer {
                            from {
                                transform: translate(0, 200%);
                            }

                            50% {
                                transform: translate(0, 50%);
                            }

                            to {
                                transform: translate(0, 0);
                            }
                        }

                        @keyframes filas {
                            from {
                                transform: translate(-500%, 0);
                            }

                            to {
                                transform: translate(0, 0);
                            }
                        }

                        #res_all {
                            width: 100%;
                            height: 800px;
                            display: inline-block;
                        }

                        #encabezados {
                            display: flex;
                            width: 95%;
                            height: 50px;
                            border: solid 2px black;
                            border-right: 0;
                            animation-duration: 2s;
                            animation-name: animLogo;
                            animation-iteration-count: 1;
                        }

                        #e_tabla {
                            width: 11.11%;
                            height: 100%;
                            font-family: oswald;
                            font-family: 16px;
                            border-right: solid 2px black;
                            background: rgb(184, 52, 25);
                            color: white;

                        }

                        #e_tabla2 {
                            width: 8.333%;
                            height: 100%;
                            font-family: oswald;
                            font-family: 14px;
                            border-right: solid 2px black;
                            background: rgb(184, 52, 25);
                            color: white;

                        }

                        #resultados {
                            display: flex;
                            width: 95%;
                            max-height: 700px;

                            border-left: solid 2px black;
                        }

                        #f_resultados {
                            width: 11.11%;
                            height: auto;
                            font-family: barlow;
                            font-family: 14px;
                            border-right: solid 2px black;
                            border-bottom: solid 2px black;
                            background: white;
                            color: black;
                            animation-duration: 2s;
                            animation-name: filas;
                            animation-iteration-count: 1;

                        }

                        #f_resultados2 {
                            width: 8.333%;
                            height: auto;
                            font-family: barlow;
                            font-family: 10px;
                            border-right: solid 2px black;
                            border-bottom: solid 2px black;
                            text-align: center;
                            background: white;
                            color: black;
                            animation-duration: 2s;
                            animation-name: aparecer;
                            animation-iteration-count: 1;

                        }
                        #f_resultados21 {
                            width: 8.333%;
                            height: auto;
                            font-family: barlow;
                            font-family: 10px;
                            border-right: solid 2px black;
                            border-bottom: solid 2px black;
                            text-align: center;
                            background: rgb(184, 52, 25);
                            color: white;
                            animation-duration: 2s;
                            animation-name: aparecer;
                            animation-iteration-count: 1;

                        }

                        #tabla {
                            width: 100%;
                            max-height: 600px;
                            overflow-y: scroll;

                        }
                        </style>