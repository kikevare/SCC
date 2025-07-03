<?php
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
}
$dbname = "bdceecc";
$dbuser = "root";
$dbhost = "localhost";
$dbpass = 'root';
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$datju = $_REQUEST['datju'];
list($apaterno, $amaterno, $nom) = explode(' ', $datju);
$sql_dapre = "SELECT xcurp,nombre,a_paterno,a_materno,id_tipo_eval,id_corporacion,id_prog_preliminar,fecha  from tbprog_preliminar  where a_paterno like '$apaterno%' and a_materno like'$amaterno%' and nombre like '$nom%' group by xcurp order by xcurp desc";
$resultado_pre = mysqli_query($conexion, $sql_dapre);
$contador = 0;
while ($fila_pre = mysqli_fetch_assoc($resultado_pre)) {
    $id_propre = $fila_pre['id_prog_preliminar'];
    $sql_resultados = "SELECT id_prog_preliminar, fecha from tbprogramacion1 where id_prog_preliminar='$id_propre' order by fecha desc";
    $resultados = mysqli_query($conexion, $sql_resultados);
    $filaresultados = mysqli_fetch_assoc($resultados);
    $contador = $contador + 1;
    $id_pre = $filaresultados['id_prog_preliminar'];
    $fecha = $fila_pre['fecha'];
    $curp_uso = $fila_pre['xcurp'];
    $xPersona = new Persona($curp_uso);
    $xfoto = $xPersona->getFoto();
    if (!empty($xfoto))
        $xfoto = $xPath . $xfoto;
    else
        $xfoto = $xPath . "imgs/sin_foto.png";
    $nombre = $fila_pre['nombre'];
    $apellidos = $fila_pre['a_paterno'] . " " . $fila_pre['a_materno'];
    $id_tip = $fila_pre['id_tipo_eval'];
    $id_corpo = $fila_pre['id_corporacion'];
    $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
    $resultadocorp = mysqli_query($conexion, $sql2);
    $filacorp = mysqli_fetch_assoc($resultadocorp);
    $corporacion = $filacorp['corporacion'];
    $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
    $resultadoev = mysqli_query($conexion, $sql3);
    $filatip = mysqli_fetch_assoc($resultadoev);
    $tipoe = $filatip['tipo_eval'];
    $sql4 = "SELECT id_evaluacion from tbevaluaciones where curp = '" . $curp_uso . "' order by id_evaluacion desc";
    $resultadoid = mysqli_query($conexion, $sql4);
    $filaid = mysqli_fetch_assoc($resultadoid);
    $id = $filaid['id_evaluacion'];
    $sqlev = "SELECT curp_evaluador, curp_supervisor, fecha_aplicacion from poligrafia_evnu where id_evaluacion = '$id'";
    $resultado_ev = mysqli_query($conexion, $sqlev);
    $fila_ev = mysqli_fetch_assoc($resultado_ev);
    $evaluador = $fila_ev['curp_evaluador'];

    $sqleval = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluador'";
    $resultado_eval = mysqli_query($conexion, $sqleval);
    $fila_evalu = mysqli_fetch_assoc($resultado_eval);
    $nombre_e = $fila_evalu['nombre'] . " " . $fila_evalu['a_paterno'] . " " . $fila_evalu['a_materno'];

    $sqlevr = "SELECT curp_evaluador, curp_supervisor from poligrafia_evnu where id_evaluacion = '$id'";
    $resultado_evr = mysqli_query($conexion, $sqlevr);
    $fila_evr = mysqli_fetch_assoc($resultado_evr);
    $evaluadorex = $fila_evr['curp_evaluador'];
    $sqlevalr = "SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$evaluadorex'";
    $resultado_evalr = mysqli_query($conexion, $sqlevalr);
    $fila_evalur = mysqli_fetch_assoc($resultado_evalr);
    $nombre_er = $fila_evalur['nombre'] . " " . $fila_evalur['a_paterno'] . " " . $fila_evalur['a_materno'];
?>
    <div class="carta2">
        <div class="frente_carta2">
           <a href="historial.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>"><img id="foto2" src="<?php echo $xfoto; ?>"></a>
            <p class="txt_encabezado2">NOMBRE:</p>
            <p class="txt_tex2"><?php echo  $apellidos . " " . $nombre ?></p>

            <p class="txt_encabezado2">FECHA DE EVALUACION:</p>
            <p class="txt_tex2"><?php $newDate = date("d/m/Y", strtotime($fila_ev['fecha_aplicacion'] )); echo $newDate ?></p>
            <p class="txt_encabezado2">CORPORACION:</p>
            <p class="txt_tex2"><?php echo $corporacion ?></p>

            <p class="txt_encabezado2">TIPO DE EVALUACION:</p>
            <p class="txt_tex2"><?php echo $tipoe ?></p>
            <p class="txt_encabezado2">EVALUADOR:</p>
            <p class="txt_tex2"><?php echo $nombre_e ?></p>

            <a href="evaluacion.php?id_evaluacion=<?php echo $id ?>&curpev=<?php echo $curp_uso ?>">
                <div class="btnasignar"> Revisar </div>
            </a>


        </div>
    </div>
<?php  }


?>