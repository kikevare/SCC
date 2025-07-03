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
   include_once($xPath."includes/catalogos.class.php");
   include($xPath."includes/integracion.class.php");
   include_once($xPath."includes/psicologico.class.php");

   $xSys = New System();
   $xUsr = New Usuario();
   $xCat = New Catalog();

   //-------- Define el id del m�dulo y el perfil de acceso -------//
   if( isset($_GET["menu"]) ){
      $_SESSION["menu"] = $_GET["menu"];
      $xInicio = 1;
   }
   if( $xUsr->xPerfil == 0 )  $xUsr->getPerfil( $_SESSION["menu"] );
   //--------------------------------------------------------------//

   //-- Define los directorios de scripts js y css...
   $cssPlantilla  = $xPath."includes/xplantilla/sty_plantilla.css";
   $jsxResultados = $xPath."includes/js/integracion/xresultados.js?v=".rand();
}?>
<!DOCTYPE html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<title>SCC :: Menu principal</title>
   <link href="<?php echo $cssPlantilla;?>" rel="stylesheet" type="text/css" />
   <!-- links css de actualizacion-->
   <?php $xSys->getLinks($xPath,1); ?>
   <!-- scripts js de actualizacion-->
   <?php $xSys->getScripts($xPath,1);  ?>
   <script src="alert/dist/sweetalert2.all.min.js"></script>
<script src="alert/dist/sweetalert2.min.js"></script>
<link rel="alert/dist/stylesheet" href="sweetalert2.min.css">
   <script language="javascript" src="<?php echo $jsxResultados;?>"></script>
   <script type="text/javascript">
      $(document).ready(function(){
         xShowMenu();
         xCtrl();
      });
   </script>
 </head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td>
   <?php
   $xSys->getMenu();
   ?>
</td></tr>
<tr><td>
   <?php
   ?>
</td></tr>

<tr><td align="center">
<form name="fForm" id="fForm" method="post" action="#" onsubmit="return validar();" enctype="application/x-www-form-urlencoded">
   <br><br>
      <?php
      //------------------- Muestra el t�tulo del m�dulo actual ------------------//
      //-- Muestra el nombre del m�dulo actual, tomando la sesI&Oacute;N...
      $xSys->getNameMod($_SESSION["menu"], "Historial de alertas.");
      //--------------------------------------------------------------------------//
      $user_perfil=$_GET["user"];

if(isset($_GET["curpev"],$_GET["id_evaluacion"]))
{
    $_SESSION['curp'] = $curp1 = $_GET['curpev'];
    $_SESSION['id_evaluacion'] = $id_evaluacion = $_GET['id_evaluacion'];
    
}
elseif(isset($_SESSION["curp"],$_SESSION['id_evaluacion']))
{
    $curp1 = $_SESSION['curp'];
    $id_evaluacion = $_SESSION['id_evaluacion'];
    
}
      //------------------------ Recepcion de par�metros -------------------------//
      
      $dbname ="bdceecc";
      $dbuser="root";
      $dbhost="10.24.2.25";
      $dbpass='4dminMy$ql$';
      
      /*$dbuser = "root";
                    $dbhost = "localhost";
                    $dbpass = 'root';*/
       $conexion=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
       $sql = "select nombre, a_paterno, a_materno, id_corporacion, id_tipo_eval, fecha from tbprog_preliminar where xcurp='".$curp1."' and asistencia='1'";
       $sql2 = "select id_evaluacion from tbevaluaciones where curp='".$curp1."' ";
       $res=mysqli_query($conexion,$sql2); 
       $resultado=mysqli_query($conexion,$sql); 
      ?>
      <div><p id="enca"> SELECCIONE UNA EVALUACION PARA OBSERVAR LAS ALERTAS DE RIESGO.</p></div>
      <section class="tab_cont"> <section class="tab_enca">
        <div id="nom"><P id="encab"> NOMBRE</P></div>
        <div id="ap"><P id="encab"> APELLIDO PATERNO</P></div>
        <div id="am"><P id="encab"> APELLIDO MATERNO</P></div>
        <div id="cor"><P id="encab"> CORPORACION</P></div>
        <div id="ev"><P id="encab"> TIPO EVALUACION</P></div>
        <div id="fch"><P id="encab"> FECHA</P></div>
        <div id="fch"><P id="encab"> -</P></div>
      </section>
      <?php
           while ($filas=mysqli_fetch_assoc($resultado) and $filas2=mysqli_fetch_assoc($res)) {
               
           ?>
        <section class="result">
        <div id="nom2"><p id="txt"><?php echo $filas['nombre'] ?></p></div>
        <div id="ap2"><p id="txt"><?php echo $filas['a_paterno']  ?></p></div>
        <div id="am2"><p id="txt"><?php echo $filas['a_materno']  ?></p></div>
        <div id="cor2"><p id="txt"><?php if ($filas ['id_corporacion']==1) {
       echo "SSPyPC ESTATAL";
    }
    if ($filas ['id_corporacion']==2) {
        echo "SSPyPC MUNICIPAL";
     }
     if ($filas ['id_corporacion']==3) {
        echo "P.G.J.E";
     }if ($filas ['id_corporacion']==4) {
        echo "F.G.E";
     }if ($filas ['id_corporacion']==5) {
        echo "SEGURIDAD PRIVADA";
     }if ($filas ['id_corporacion']==6) {
        echo "S.E.S.P.";
     }if ($filas ['id_corporacion']==7) {
        echo "SEMAR";
     }if ($filas ['id_corporacion']==8) {
        echo "F.G.E";
     }if ($filas ['id_corporacion']==9) {
        echo "SSP ESTATAL";
     }if ($filas ['id_corporacion']==10) {
        echo "SSP MUNICIPAL";
     }if ($filas ['id_corporacion']==11) {
        echo "PROTECCION CIVIL ESTATAL";
     }if ($filas ['id_corporacion']==12) {
        echo "PROTECCION CIVIL MUNICIPAL";
     }if ($filas ['id_corporacion']==13) {
        echo "PODER JUDICIAL DE LA FEDERACION";
     }if ($filas ['id_corporacion']==14) {
        echo "DSPM";
     }if ($filas ['id_corporacion']==15) {
        echo "IPAE";
     }if ($filas ['id_corporacion']==16) {
        echo "SEFINA";
     }if ($filas ['id_corporacion']==17) {
        echo "REPUVE";
     }
       ?></p></div>
        <div id="ev2"><p id="txt"><?php if ($filas['id_tipo_eval']==1) {
            echo "NUEVO INGRESO";
        }
        if ($filas['id_tipo_eval']==2) {
            echo "PERMANENCIA";
        }
        if ($filas['id_tipo_eval']==3) {
            echo "PROMOCION";
        }
        if ($filas['id_tipo_eval']==4) {
            echo "LICENCIA OFICIAL COLECTIVA 110";
        }
        if ($filas['id_tipo_eval']==5) {
            echo "LICENCIA OFICIAL COLECTIVA 067";
        }
        if ($filas['id_tipo_eval']==6) {
            echo "PERMANENCIA LOC";
        }
        ?></p></div>
        <div id="am2"><p id="txt"><?php echo $filas['fecha']  ?></p></div>
        <?php $sql3="select id_evaluacion from tbnew_alertariesgo where id_evaluacion ='".$filas2['id_evaluacion']."' ";
$resultadosa=mysqli_query($conexion,$sql3); 
while ($filasa=mysqli_fetch_assoc($resultadosa)){
$id_ev=$filasa['id_evaluacion'];
if ($id_ev==$filas2['id_evaluacion']) {
   $contador="Existen Alertas";
   
 }}
 ?>
        
       <div id="fch2"><a id="edit" href="historial_alertas_edit2.php?id=<?php echo $filas2['id_evaluacion']?>"><img src="<?php echo $xPath;?>imgs/edit_hist.png" alt="" width="60px"><?php
       if ($id_ev==$filas2['id_evaluacion']) {
          echo $contador;
       }  ?></a><br></div>
    </section>
</section>
<?php

} ?>

<section class="boton">
      <a id="reg" href="evaluacion.php?id_evaluacion=<?php echo $id_evaluacion ?>&curpev=<?php echo $curp1  ?>"><div id="regresar"><p id="regr"> Regresar</p></div></a></section>
<style>
    .tab_cont 
    {
        display: block; 
        width: 100%;
        height: 100%;
        
    }
    #encab 
    {
        font-weight: bold;
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        margin-top: 5px;
        margin-left: 5px;
    }
    #txt 
    {
        font-weight: bold;
        font-size: 12px;
        font-family: Arial, Helvetica, sans-serif;
        text-align: left;
        margin-top: 15px;
        margin-left: 5px;
    }
    #enca 
        {
            font-weight: bold;
        }
   .boton 
         {
            width: 100px;
            height: 50px;
            margin-top: 20px;
         }
   #regresar 
        {
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
        #regresar:hover
        {
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
        }
        #reg:hover
        {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        #regr 
        {
            margin-top: 12px;
        }
    #editar
    {
        text-decoration: none;
        font-size: 15px;
        text-align: center;
        margin-top: 13px;
        font-weight: bold;
    }
    #edit
    {
        width:  180px;
        height: 36px;
        background-color: white;
        border-radius: 20%;
        border: solid 1px;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-weight: bold;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        text-decoration: none;
        text-align: center;
        margin-left: 2px;
        border: none;
        background: whitesmoke;
        font-size: 11px;
        color: black;
    }
    #edit:hover
    {
        cursor: pointer;
        background: blue;
        border: solid 2px white;
        color: white;
        border-radius: 20%;
        text-decoration: none;
    }
    .result
    {
        display: flex;
        width: 100%;
        height: 100%;
        border: solid 1px black;
        font-weight: bold;
        font: ROBOTO;
        font-size: 13px;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        color: black;
        align-items: center;
    }
    .tab_enca
    {
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
    #nom 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        background: rgb(65, 98, 126);
    }
    #ap 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #am 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #cor 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #ev 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
    }
    #fch 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: rgb(65, 98, 126);
        
    }
    #nom2
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        background: white;
    }
    #ap2 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: white;
    }
    #am2
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: white;
    }
    #cor2 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: white;
    }
    #ev2 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: white;
    }
    #fch2 
    {
        width: 15%;
        height: 40px;
        border-right: solid 0.5px black;
        display: flex;
        background: white;
    }
</style>