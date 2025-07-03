<?php
/* error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); */
session_start();
//-------------------------------------------------------------//
$xPath='';
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/evaluaciones.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xPersona = New Persona();

   //-------- Define el id del modulo y el perfil de acceso -------//
   $xInicio = 0;
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//
   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsxIdxMed     = $xPath."includes/js/evmed/xMedIndex.js?v=".rand();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <title>SCC :: Men&uacute; principal</title>
    <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
    <!-- links css de actualizacion-->
    <?php $xSys->getLinks($xPath,1); ?>
    <!-- scripts js de actualizacion-->
    <?php $xSys->getScripts($xPath,1);  ?>
    <script type="text/javascript" src="<?php echo $jsxIdxMed;?>" />

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
   if( isset($_GET["menu"]) ){
      $xInicio=1;
      $xSys->getNameMod($_GET["menu"]);
      $_SESSION["menu"] = $_GET["menu"];
   }
   else if( isset($_SESSION["menu"]) ){
      $xInicio=0;
      $xSys->getNameMod($_SESSION["menu"]);
   }

         //------------ Recepcion de par�metros de ordenaci�n y b�squeda ------------//
      //-- Inicializa los par�metros...
      $idOrd      = 2;
      $tipoOrd    = "Asc";
      $txtBusca   = "";
      $cmpBusca   = 1;
      //-- Revisa si se ha ejecutado una ordenaci�n...
      if( isset($_POST["id_orden"]) ){

         $idOrd   = $_POST["id_orden"];
         $tipoOrd = $_POST["tp_orden"];
         //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
         $_SESSION["id_orden"] = $idOrd;
         $_SESSION["tipo_orden"] = $tipoOrd;
      }
      //-- Revisa si se ha ejecutado una b�squeda...
      if( isset($_POST["txtBusca"]) && !empty($_POST["txtBusca"]) ){
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
      if( $xInicio == 0 ){
         if( $_SESSION["id_orden"] != "" )   $idOrd      = $_SESSION["id_orden"];
         if( $_SESSION["tipo_orden"] != "" ) $tipoOrd    = $_SESSION["tipo_orden"];
         if( $_SESSION["cmp_busca"] != "" )  $cmpBusca   = $_SESSION["cmp_busca"];
         if( $_SESSION["txt_busca"] != "" )  $txtBusca   = $_SESSION["txt_busca"];
         $xMsj = "&Uacute;ltima b&uacute;squeda realizada";
      }
      else{
         $_SESSION["id_orden"]   = "";
         $_SESSION["tipo_orden"] = "";
         $_SESSION["cmp_busca"]  = "";
         $_SESSION["txt_busca"]  = "";
         $xMsj = "";
      }
      //--------------------------------------------------------------------------//
      $dbname ="bdceecc";
      $dbuser="root";
      $dbhost="10.24.2.25";
      $dbpass='4dminMy$ql$';
      $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
      function obtener_datos ($conexion)
      {
         $sql = "SELECT id_evaluacion, curp_evaluado,fecha_aplicacion,curp_supervisor from poligrafia_evnu where estado='2'";
         $resultado = mysqli_query($conexion,$sql);
         
         while ($fila = mysqli_fetch_assoc($resultado))
         {
         $id_evaluacion = $fila['id_evaluacion'];
         $curp_evaluado = $fila['curp_evaluado'];
         $fecha_aplicacion = $fila['fecha_aplicacion'];
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
            <section class="resultados_fila">
            <div class="resultado_fila_celda"><?php echo $apellidos ?></div>
            <div class="resultado_fila_celda"><?php echo $nombre ?></div>
            <div class="resultado_fila_celda"><?php echo $curp_evaluado ?></div>
            <div class="resultado_fila_celda"><?php echo $tipoe ?></div>
            <div class="resultado_fila_celda"><?php echo $corporacion ?></div>
            <div class="resultado_fila_celda"><?php echo $newDate ?></div>
            <div class="resultado_fila_celda"><?php if ($fila['curp_supervisor']=='LOMJ900927HGRPRS07') {
               echo "LOPEZ MORALES JEISON";
            }else 
            {
               echo "FELIX GARCIA MARICRUZ";
            } ?></div>
            </section>
      <?php   }


      }
   ?>
   <?php
   function obtener_datos_reexa ($conexion)
      {
         $sql = "SELECT id_evaluacion, curp_evaluado,fecha_aplicacion,curp_supervisor from poligrafia_evnu_rex where estado='2'";
         $resultado = mysqli_query($conexion,$sql);
         
         while ($fila = mysqli_fetch_assoc($resultado))
         {
         $id_evaluacion = $fila['id_evaluacion'];
         $curp_evaluado = $fila['curp_evaluado'];
         $fecha_aplicacion = $fila['fecha_aplicacion'];
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
            <section class="resultados_fila">
            <div class="resultado_fila_celda"><?php echo $apellidos ?></div>
            <div class="resultado_fila_celda"><?php echo $nombre ?></div>
            <div class="resultado_fila_celda"><?php echo $curp_evaluado ?></div>
            <div class="resultado_fila_celda"><?php echo $tipoe."/REEXAMINACION" ?></div>
            <div class="resultado_fila_celda"><?php echo $corporacion ?></div>
            <div class="resultado_fila_celda"><?php echo $newDate ?></div>
            <div class="resultado_fila_celda"><?php if ($fila['curp_supervisor']=='LOMJ900927HGRPRS07') {
               echo "LOPEZ MORALES JEISON";
            }else 
            {
               echo "FELIX GARCIA MARICRUZ";
            } ?></div>
            </section>
      <?php   }


      }
   ?>
   <?php   function obtenerjeison ($conexion)
   {
      $sql ="SELECT id_evaluacion from poligrafia_evnu where curp_supervisor='LOMJ900927HGRPRS07' and estado='2'";
      $resultado = mysqli_query($conexion,$sql);
         $contador = 0;
         while ($fila = mysqli_fetch_assoc($resultado))
         {
            $contador=$contador+1;
         }
         echo "Evaluaciones Supervisadas por: LOPEZ MORALES JEISON"." "." "."TOTAL:"." ".$contador;
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
     @import url('https://fonts.googleapis.com/css2?family=Oswald&display=swap');
</style>
                    <body>
                        <section class="contenido">
                            <section class="menu">

                            </section>
                            <section class="resultados">
                               <section class="resultados_encabezado">
                                 <div class="encabezado_lista">Apellidos</div>
                                 <div class="encabezado_lista">Nombre</div>
                                 <div class="encabezado_lista">Curp</div>
                                 <div class="encabezado_lista">Tipo de Evaluacion</div>
                                 <div class="encabezado_lista">Corporacion</div>
                                 <div class="encabezado_lista">Fecha de Evaluacion</div>
                                 <div class="encabezado_lista">Supervisor</div>
                                 
                               </section>
                              <?php echo obtener_datos($conexion); obtener_datos_reexa($conexion)?>
                              <?php echo obtenerjeison($conexion);?>
                            </section>
                            
                        </section>
                    </body>

                    </html>
                    <style>
                     .resultado_fila_celda 
                     {
                        width: 16.67%;
                        height: 100%;
                        border-right: solid 2px black;
                        border-bottom: solid 2px black;
                        font-family: Oswald;
                        font-size: 15px;
                     }
                     .resultados_fila 
                     {
                        width: 90%;
                        height: 30px;
                        display: flex;
                        border-left: solid 2px black;
                     }
                     .encabezado_lista 
                     {
                        width: 16.67%;
                        height: 100%;
                        border-right: solid 2px black;
                        font-family: Oswald;
                        font-size: 18px;
                        font-weight: bold;
                        color: white;

                     }
                     .resultados_encabezado 
                     {
                        width: 90%;
                        height: 35px;
                        margin-top: 20px;
                        background: #EC5656;
                        display: flex;
                        border-left: solid 2px black;
                        border-top: solid 2px black;
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
                        border: solid 2px black;
                        background: url("<?php echo $xPath; ?>imgs/fondopol.jpg");
                        background-size: 100% 100%;
                    }

                    .resultados {
                        width: 1600px;
                        height: 100%;
                        border-radius: 5px;
                        border: solid 2px black;
                        overflow-y: scroll;
                    }
                    </style>
                    <?php
}
else
   header("Location: ".$xPath."exit.php");
?>