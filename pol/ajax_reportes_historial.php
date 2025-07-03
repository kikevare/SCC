<?php    
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for ($i = 0; $i < $xLEVEL; $i++)  $xPath .= "../";
$id = $_REQUEST['id_evaluacion'];
                        
                        $dbname ="bdceecc";
                        $dbuser="root";
                        $dbhost="10.24.2.25";
                        $dbpass='4dminMy$ql$';
                        $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                        $sql_curp = "select curp from tbevaluaciones where id_evaluacion = '$id'";
                        $resultado = mysqli_query($conexion, $sql_curp);
                        $fila = mysqli_fetch_assoc($resultado);
                        $curp = $fila['curp'];
                        $sql3 = "select nombre, a_paterno, a_materno, id_corporacion, categoria, id_tipo_eval, id_municipio, id_region from tbprog_preliminar where xcurp='" . $curp . "' order by id_prog_preliminar desc";
                        $resulta = mysqli_query($conexion, $sql3);
                        $fil = mysqli_fetch_assoc($resulta);
                        $sql4 = "select fecha_nac, id_genero, cuip, rfc from tbdatospersonales where curp='" . $curp . "'";
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
                        $sql31 = "select fecha_aplica, evaluaciones_anteriores, trayectoria_laboral, observacion,situacion_patrimonial, analisis_tecnico,conclusion, admision from tbevpoligrafica where id_evaluacion = '" . $id . "'";
                        $resul28 = mysqli_query($conexion, $sql31);
                        $fil29 = mysqli_fetch_assoc($resul28);
                        $sql_n = "select evaluaciones_anteriores, trayectoria_laboral, observacion,situacion_patrimonial, analisis_tecnico,conclusion, admision from reporte_poli where id_evaluacion = '" . $id . "'";
                        $resulnr = mysqli_query($conexion, $sql_n);
                        $filnr = mysqli_fetch_assoc($resulnr);
                        $sql_ne = "select evaluaciones_anteriores, trayectoria_laboral, observacion,situacion_patrimonial, analisis_tecnico,conclusion, admision from reporte_pol_rex where id_evaluacion = '" . $id . "'";
                        $resulnre = mysqli_query($conexion, $sql_ne);
                        $filne = mysqli_fetch_assoc($resulnre);

                        $sql32 = "select evaluaciones_anterioresr, trayectoria_laboralr, observacionr,situacion_patrimonialr, analisis_tecnicor,conclusionr, admisionr from tbevpoligrafica where id_evaluacion = '" . $id . "'";
                        $resul29 = mysqli_query($conexion, $sql32);
                        $fil30 = mysqli_fetch_assoc($resul29);
                        $sql7 = "select corporacion from ctcorporacion where id_corporacion='" . $fil['id_corporacion'] . "'";
                        $resul3 = mysqli_query($conexion, $sql7);
                        $fil4 = mysqli_fetch_assoc($resul3);
                        $sql8 = "select tipo_eval from cttipoevaluacion where id_tipo_eval='" . $fil['id_tipo_eval'] . "'";
                        $resul4 = mysqli_query($conexion, $sql8);
                        $fil5 = mysqli_fetch_assoc($resul4);
                        $rfc = $fil1['rfc'];
                        $sql30 = "select cargo, id_municipio from tbadscripcion where curp = '" . $curp . "'";
                        $resul27 = mysqli_query($conexion, $sql30);
                        $fil28 = mysqli_fetch_assoc($resul27);
                        ?>




<section class="visor">
                                
<section class="hoja4">
                            <div class="encabezado">
                                <div id="logo1"><img src="<?php echo $xPath; ?>imgs/logo2.jpg" alt="" width="200px"
                                        height="90px"></div>
                                <div id="text1">
                                    <p> <?php echo utf8_decode("SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL DE SEGURIDAD PÚBLICA <br>
    CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO <br> DEPARTAMENTO DE POLIGRAFIA "); ?>
                                    </p>
                                </div>
                                <div id="logo2"><img src="<?php echo $xPath; ?>imgs/logo1.jpg" alt="" width="100px"
                                        height="90px"></div>
                            </div>
                            <section class="dat_pol">
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">TIPO DE EVALUACION:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $fil5['tipo_eval'] ?> </p>
                                    </div>
                                    <div id="d_pol_a">
                                        <p id="txtp2">FECHA DE EVALUACION:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $fil29['fecha_aplica'] ?><?php echo $filnr['fecha_aplicacion'] ?> </p>
                                    </div>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">NOMBRE:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso">
                                            <?php echo $fil['a_paterno'] . " " . $fil['a_materno'] . " " . $fil['nombre']; ?>
                                        </p>
                                    </div>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">SEXO:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $fil2['genero'] ?> </p>
                                    </div>
                                    <div id="d_pol_a">
                                        <p id="txtp2">EDAD:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $annos . "   " . utf8_decode("AÑOS"); ?> </p>
                                    </div>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">RFC:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $rfc ?> </p>
                                    </div>
                                    <div id="d_pol_a">
                                        <p id="txtp2">CURP:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $curp ?> </p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">DEPENDENCIA:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso"><?php echo $fil4['corporacion']; ?></p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">CATEGORIA DE MANDO:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso"><?php echo $fil['categoria'] ?></p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">PUESTO ESPECIFICO:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso"><?php echo $fil28['cargo']; ?></p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a4">ESTE REPORTE ES ESTRICTAMENTE CONFIDENCIAL</div>
                                    </p>
                                </div>
                                </p>
                                </div>
                            </section>
                            <section class="info_pol">
                                <div id="info_pol_e">
                                    <p id="txtp">EVALUACIONES ANTERIORES:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo utf8_encode($fil29['evaluaciones_anteriores']); ?> <?php echo utf8_encode($filnr['evaluaciones_anteriores']); ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">TRAYECTORIA LABORAL:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil29['trayectoria_laboral']; ?><?php echo $filnr['trayectoria_laboral']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">OBSERVACION:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil29['observacion']; ?><?php echo $filnr['observacion']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">SITUACION PATRIMONIAL:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil29['situacion_patrimonial']; ?><?php echo $filnr['situacion_patrimonial']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">ANALISIS TECNICO:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil29['analisis_tecnico']; ?><?php echo $filnr['analisis_tecnico']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">ADMISION:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil29['admision']; ?><?php echo $filnr['admision']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">SINTESIS TECNICA:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $filnr['conclusion']; ?></p>
                                </div>
                            </section>
                            <section class="fir_pol">
                                <div id="fi_1">
                                    <p id="txtp">ELABORO:</p>
                                </div>
                                <div id="fi_2"></div>
                                <div id="fi_1">
                                    <p id="txtp">REVISO:</p>
                                </div>
                                <div id="fi_2"></div>
                                <div id="fi_1">
                                    <p id="txtp">AUTORIZO:</p>
                                </div>
                                <div id="fi_12">AP 03</div>
                            </section>
                            <br><br>
                        </section>
                        <?php //-------------------------------------------- comienza resultados de poligrafia reexaminacion---------------------------------------------------------------------------------->
                            ?>
                        <?php if ($fil30['evaluaciones_anterioresr'] != null||$filne['evaluaciones_anterioresr'] != null) { ?>
                        <section class="hoja4">
                            <div class="encabezado">
                                <div id="logo1"><img src="<?php echo $xPath; ?>imgs/logo2.jpg" alt="" width="200px"
                                        height="90px"></div>
                                <div id="text1">
                                    <p> <?php echo utf8_decode("SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL DE SEGURIDAD PÚBLICA <br>
    CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO <br> DEPARTAMENTO DE POLIGRAFIA REEXAMINACION "); ?>
                                    </p>
                                </div>
                                <div id="logo2"><img src="<?php echo $xPath; ?>imgs/logo1.jpg" alt="" width="100px"
                                        height="90px"></div>
                            </div>
                            <section class="dat_pol">
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">TIPO DE EVALUACION:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $fil5['tipo_eval'] ?> </p>
                                    </div>
                                    <div id="d_pol_a">
                                        <p id="txtp2">FECHA DE EVALUACION:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $filas['fecha_reg'] ?><?php echo $filne['fecha_aplicacion'] ?> </p>
                                    </div>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">NOMBRE:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso">
                                            <?php echo $fil['a_paterno'] . " " . $fil['a_materno'] . " " . $fil['nombre']; ?>
                                        </p>
                                    </div>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">SEXO:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $fil2['genero'] ?> </p>
                                    </div>
                                    <div id="d_pol_a">
                                        <p id="txtp2">EDAD:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $annos . "   " . utf8_decode("AÑOS"); ?> </p>
                                    </div>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">RFC:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $rfc ?> </p>
                                    </div>
                                    <div id="d_pol_a">
                                        <p id="txtp2">CURP:</p>
                                    </div>
                                    <div id="d_pol_a2">
                                        <p id="txtso"><?php echo $xPersona->CURP ?> </p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">DEPENDENCIA:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso"><?php echo $fil4['corporacion']; ?></p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">CATEGORIA DE MANDO:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso"><?php echo $fil['categoria'] ?></p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a">
                                        <p id="txtp">PUESTO ESPECIFICO:</p>
                                    </div>
                                    <div id="d_pol_a3">
                                        <p id="txtso"><?php echo $fil28['cargo']; ?></p>
                                    </div>
                                    </p>
                                </div>
                                <div id="d_pol">
                                    <div id="d_pol_a4">ESTE REPORTE ES ESTRICTAMENTE CONFIDENCIAL</div>
                                    </p>
                                </div>
                                </p>
                                </div>
                            </section>
                            <section class="info_pol">
                                <div id="info_pol_e">
                                    <p id="txtp">EVALUACIONES ANTERIORES:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['evaluaciones_anterioresr']; ?><?php echo utf8_encode($filne['evaluaciones_anteriores']); ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">TRAYECTORIA LABORAL:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['trayectoria_laboralr'] ; ?><?php echo $filne['trayectoria_laboral']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">OBSERVACION:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['observacionr']; ?><?php echo $filne['observacion']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">SITUACION PATRIMONIAL:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['situacion_patrimonialr']; ?><?php echo $filne['situacion_patrimonial']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">ANALISIS TECNICO:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['analisis_tecnicor']; ?><?php echo $filne['analisis_tecnico']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">ADMISION:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['admisionr']; ?><?php echo $filne['admision']; ?></p>
                                </div>
                                <div id="info_pol_e">
                                    <p id="txtp">SINTESIS TECNICA:</p>
                                </div>
                                <div id="info_pol_r">
                                    <p id="txtso2"><?php echo $fil30['conclusionr']; ?><?php echo $filne['conclusion']; ?></p>
                                </div>
                            </section>
                            <section class="fir_pol">
                                <div id="fi_1">
                                    <p id="txtp">ELABORO:</p>
                                </div>
                                <div id="fi_2"></div>
                                <div id="fi_1">
                                    <p id="txtp">REVISO:</p>
                                </div>
                                <div id="fi_2"></div>
                                <div id="fi_1">
                                    <p id="txtp">AUTORIZO:</p>
                                </div>
                                <div id="fi_12">AP 03</div>
                            </section>
                            <br><br>
                        </section>
                        <?php } ?>
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
                    </style>