<?php

    session_start();
    //-------------------------------------------------------------//
    $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
    for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
    //-------------------------------------------------------------//
    include_once($xPath."includes/xsystem.php");
    include_once($xPath."includes/persona.class.php");  
    include_once($xPath."includes/medico.class.php"); 
    require($xPath.'includes/fpdf16/pdf.php');
    include_once($xPath."includes/poligrafia.class.php");
    $xUsr = New Usuario();

	$pdf = New PDF('P','mm','Letter');
	//$pdf->SetAutoPageBreak(false);  
    
    //encabezado del documento
   $xSys = New System();
    //$xMed = New Medico( $_SESSION["xCurp"] );
    //$xEval = New Evaluaciones( $_SESSION["xCurp"] );
    //$xMed->getDatosMed();
    $dbname ="bdceecc";
    $dbuser="root";
    $dbhost="10.24.2.25";
    $dbpass='4dminMy$ql$';
   $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if(isset($_GET["curpev"],$_GET["id_evaluacion"]))
{
   $_SESSION['curp'] = $curp1 = $_GET['curpev'];
   $_SESSION['id_evaluacion'] = $id_evaluacion = $_GET['id_evaluacion'];
   $xPersona = New Persona($curp1);
   $_SESSION["xCurp"] = $xPersona->CURP;
   
}
elseif(isset($_SESSION["curp"],$_SESSION['id_evaluacion']))
{
   $curp1 = $_SESSION['curp'];
   $id_evaluacion = $_SESSION['id_evaluacion']; 
   $xPersona = New Persona($_SESSION["xCurp"]);
   $xPsico = New Poligrafico($_SESSION["xCurp"]);
  
}
function solicita($curp,$conexion,$pdf)
          {
            $sql1="SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp='$curp'";
            $resultado_n = mysqli_query($conexion, $sql1);
            $oficio_r = mysqli_fetch_assoc($resultado_n);
            $nombre = $oficio_r['nombre']." ".$oficio_r['a_paterno']." ".$oficio_r['a_materno'];
            $pdf->Cell(0, 5,"Lic.  ".$nombre, 0, 0, "L");
          }
          $sql = "SELECT nombre,a_paterno,a_materno,rfc,fecha_nac from tbdatospersonales where curp='$curp1' ";
          $resultado = mysqli_query($conexion, $sql);
          $fila = mysqli_fetch_assoc($resultado);
          $nombre_largo = $fila['a_paterno']." ".$fila['a_materno']." ".$fila['nombre'];        

    // inicio  costado,inicio arriba, termina costado, ancho 
    //encabezado del documento
    $y=12;
    
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
    $pdf->Image($xPath."imgs/mem_2024.jpg", 15, 8, 198, 30);
    $pdf->SetFont("Arial", "B", "11");
    $pdf->SetXY(24,$y);
    $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE"), 0, 0, "C");
    $y=$y+5;
    $pdf->SetXY(29,$y);
    $pdf->Cell(0, 5, utf8_decode("CONFIANZA DEL ESTADO DE GUERRERO"), 0, 0, "C");
/*
    $pdf->SetY(20);
    $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
    $pdf->SetY(24);
    $pdf->Cell(0, 5, "", 0, 0, "C");
*/
    $pdf->SetFont("Arial", "BU", "10");
    $y=$y+6;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, utf8_decode("ÁREA DE POLIGRAFIA"), 0, 0, "C");

    $y=$y+10;
    $pdf->SetFont("Arial", "B", "9.5");
    $pdf->SetY($y);
    
    $pdf->Cell(0, 5, utf8_decode("FORMATO DE SUSPENSIÓN"), 0, 0, "C");
   
    $y+=9; 
   
     //datos personales
     $xfecha = date('d') .' de '. $xSys->NomMesLargo( date("m") ) .' de '. date('Y');

  //datos personales
  $pdf->SetFont("Arial", "B", "10");

  $pdf->SetXY(140,$y);
  $pdf->Cell(12, 5, "Fecha: ".$xfecha, "bottom", 0, "L");
  $pdf->SetFont("Arial", "", "10");
  $pdf->Cell(12, 5, "______________________", 0, 0, "L");
  
  $y+=6;
  $pdf->SetFont("Arial", "B", "10");
  $pdf->SetXY(19,$y);
  $pdf->Cell(12,10,utf8_decode("Lugar de aplicacion: Chilpancingo, Guerrero"),0,0,"L");
  $pdf->SetXY(52,$y);
  $pdf->SetFont("Arial", "", "9");
  $pdf->Cell(12,10,utf8_decode("_________________________________________________________________________________"),0,0,"L");
  $y+=9;
  $pdf->SetXY(40,$y);
  $pdf->Cell(12,10,utf8_decode($fila['a_paterno']),0,0,"L");
  $pdf->SetXY(105,$y);
  $pdf->Cell(12,10,utf8_decode($fila['a_materno']),0,0,"L");
  $pdf->SetXY(155,$y);
  $pdf->Cell(12,10,utf8_decode($fila['nombre']),0,0,"L");
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("______________________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetFont("Arial", "B", "9");
  $pdf->SetXY(35,$y);
  $pdf->Cell(12,10,utf8_decode("Apellido paterno"),0,0,"L");
  $pdf->SetXY(95,$y);
  $pdf->Cell(12,10,utf8_decode("Apellido materno"),0,0,"L");
  $pdf->SetXY(160,$y);
  $pdf->Cell(12,10,utf8_decode("Nombre(s)"),0,0,"L");
  $y+=10;
  $pdf->SetXY(15,$y);
  $pdf->SetFont("Arial", "B", "9");

  $pdf->Cell(12,10,utf8_decode("A QUIEN CORRESPONDA"),0,0,"L");
  $y+=8;
  $pdf->SetXY(15,$y);
  $pdf->SetFont("Arial", "", "9");
  $pdf->Cell(12,10,utf8_decode("POR MEDIO DE LA PRESENTE, EXPRESO LOS MOTIVOS POR LOS CUALES NO CONTINUARE CON EL PROCESO"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->SetFont("Arial", "", "9");
  $pdf->Cell(12,10,utf8_decode("DE EVALUACIÓN."),0,0,"L");
  
  $y+=8;
  $pdf->SetXY(15,$y);
  $pdf->SetFont("Arial", "B", "9");

  $pdf->Cell(12,10,utf8_decode("EN MI CALIDAD DE:".$xPsico->TIPO_EVAL." , PERTENECIENTE A ".$xPersona->getCorporacion($xPersona->CORPORACION)),0,0,"L");
  $y+=5;
  $pdf->SetFont("Arial", "", "10");
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");
  $y+=5;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("_____________________________________________________________________________________________"),0,0,"L");


   $y+=16;
  $pdf->SetXY(15,$y);
  $pdf->SetFont("Arial", "", "9.5");
  $pdf->MultiCell(186,5,utf8_decode("POR ASI CONVENIR A MIS INTERESES, RENUNCIO A LOS BENEFICIOS QUE ESTAS ACTIVIDADES CONCEDEN. UNA VEZ FIRMADO EL PRESENTE, EXIMO DE TODA RESPONSABILIDAD AL PERSONAL QUE INTEGRA EL CENTRO ESTATAL DE EVALUACION Y CONTROL DE CONFIANZA SOBRE MI EVALUACION TANTO DE CARACTER ADMINISTRATUIVO COMO LEGAL."),0,"J");

  $y+=25;
  
  $y+=18;
  $pdf->SetXY(15,$y);
  // $pdf->Cell(12,10,utf8_decode($nombre_completo),0,0,"L");
  $pdf->Cell(12,10,utf8_decode("____________________________"),0,0,"L");
  $pdf->SetXY(80,$y);
  $pdf->Cell(12,10,utf8_decode("____________________________"),0,0,"L");
  $pdf->Rect(160,183,30,20);
  $y+=5;
  $pdf->SetFont("Arial", "B", "10");
  $pdf->SetXY(34,$y);
  $pdf->Cell(12,10,utf8_decode("NOMBRE"),0,0,"L");
  $pdf->SetXY(99,$y);
  $pdf->Cell(12,10,utf8_decode("FIRMA"),0,0,"L");
  $pdf->SetXY(155,$y+1);
  $pdf->MultiCell(42,5,utf8_decode("HUELLA DEDO INDICE DERECHO"),0,"C");
  
  $pdf->SetFont("Arial", "", "10");
  $y+=22;
  $pdf->SetXY(15,$y);
  $pdf->Cell(12,10,utf8_decode("____________________________"),0,0,"L");
  $pdf->SetXY(80,$y);
  $pdf->Cell(12,10,utf8_decode("____________________________"),0,0,"L");
  $pdf->SetXY(144,$y);
  $pdf->Cell(12,10,utf8_decode("____________________________"),0,0,"L");
  
  $pdf->SetFont("Arial", "B", "10");
  $y+=5;
  $pdf->SetXY(22,$y);
  $pdf->Cell(12,10,utf8_decode("FIRMA DEL EVALUADOR"),0,0,"L");
  $pdf->SetXY(89,$y);
  $pdf->Cell(12,10,utf8_decode("Vo. Bo. SUPERVISOR"),0,0,"L");
  $pdf->SetXY(150,$y+2);
  $pdf->MultiCell(42,4,utf8_decode("Vo. Bo. RESPONSABLE DEL AREA"),0,"C");
  $pdf->SetFont("Arial", "", "7");
  $y+=20;
  //á ó é í ú
  $pdf->SetXY(17,$y);
  $pdf->MultiCell(180,4,utf8_decode("Información de acceso restringido y clasificada como reservada en su totalidad, en terminos de los Artículos 13 fracciones I,II, Y I4 fracción I de la Ley Federal
  de Transparencia y Acceso a la Informaciòn Público Gubernamental, Décimo Octavo fracciones I y V y Décimo Noveno fracciones I incisos a) y c) y II fracciones 
  a) y b) de los Lineamientos Generales para la Clasificaciòn y Desclasificacion de la informacion de las Dependencias y Entidades de la Administracion Pública
  Federal, en relación con los articulos 5º fracción III y 51 fracciones I y II de La Ley de Seguridad Nacional, artículo 33 fracciones I y II de la Ley número 374 de 
  Transparencia y Acceso a la informacion Pública de Estado de Guerrero, y artículo 108 Bis fracció IV de la Ley 281 de Seguridad Pública del Estado de 
  Guerrero"),0,"C");
  
  
  // $y+=16;
  // $pdf->SetXY(15,$y);
  // $pdf->SetFont("Arial", "", "9");
  // $pdf->Cell(12,10,utf8_decode("POR ASI CONVENIR A MIS INTERESES, RENUNCIO A LOS BENEFICIOS QUE ESTAS ACTIVIDADES CONCEDEN."),0,0,"J");

  // $y+=5;
  // $pdf->SetXY(15,$y);
  // $pdf->SetFont("Arial", "", "9");
  // $pdf->Cell(12,10,utf8_decode("UNA VEZ FIRMADO EL PRESENTE, EXIMO DE TODA RESPONSABILIDAD AL PERSONAL QUE INTEGRA EL CENTRO"),0,0,"L");

  // $y+=5;
  // $pdf->SetXY(15,$y);
  // $pdf->SetFont("Arial", "", "9");
  // $pdf->Cell(12,10,utf8_decode("ESTATAL DE EVALUACION Y CONTROL DE CONFIANZA SOBRE MI EVALUACION TANTO DE CARACTER"),0,0,"L");
  
  // $y+=5;
  // $pdf->SetXY(15,$y);
  // $pdf->SetFont("Arial", "", "9");
  // $pdf->Cell(12,10,utf8_decode("ADMINISTRATUIVO COMO LEGAL."),0,0,"L");

      //FIRMA 10.08.2019
     
      $y=12;
    
      $pdf->SetAutoPageBreak(false);
      $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
      $pdf->Image($xPath."imgs/mem_2024.jpg", 15, 8, 195, 30);
      $pdf->SetFont("Arial", "B", "11");
      $pdf->SetXY(26,$y);
      $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE"), 0, 0, "C");
      $y=$y+5;
      $pdf->SetXY(29,$y);
      $pdf->Cell(0, 5, utf8_decode("CONFIANZA DEL ESTADO DE GUERRERO"), 0, 0, "C");
  /*
      $pdf->SetY(20);
      $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
      $pdf->SetY(24);
      $pdf->Cell(0, 5, "", 0, 0, "C");
  */
      $pdf->SetFont("Arial", "BU", "10");
      $y=$y+6;
      $pdf->SetY($y);
      $pdf->Cell(0, 5, utf8_decode("ÁREA DE POLIGRAFIA"), 0, 0, "C");
      $y+=12;
      $pdf->SetXY(85,$y);
      $pdf->SetFont("Arial", "", "10");
      $pdf->Cell(0, 5, utf8_decode("SECCIÓN:"), 0, 0, "L");
      $pdf->SetXY(107,$y);
      $pdf->MultiCell(105,5,utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA"),0,'L');
  
      $y+=15;
      $pdf->SetXY(85,$y);
      $pdf->Cell(0, 5, utf8_decode("ASUNTO:"), 0, 0, "L");
      $pdf->SetXY(107,$y);
      $pdf->MultiCell(105,5,utf8_decode("SUSPENSION POR PARTE DEL AREA"),0,'L');

      $y+=20;
      $pdf->SetXY(125,$y);
      $pdf->SetFont("Arial", "", "10");
      $pdf->Cell(0, 5, utf8_decode("Chilpancingo, Gro A ".$xfecha), 0, 0, "L");
      
      $y+=15;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "B", "10");
      $pdf->Cell(0, 5, utf8_decode("Psic. Elida Lopéz Araujo"), 0, 0, "L");

      $y+=5;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "B", "10");
      $pdf->Cell(0, 5, utf8_decode("ENCARGADO GENERAL DEL CENTRO ESTATAL DE EVALUACIÓN"), 0, 0, "L");
      $y+=5;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "B", "10");
      $pdf->Cell(0, 5, utf8_decode("Y CONTROL DE CONFIANZA"), 0, 0, "L");
      $y+=5;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "B", "10");
      $pdf->Cell(0, 5, utf8_decode("P R E S E N T E "), 0, 0, "L");
      $y+=15;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "", "11");
      $pdf->MultiCell(0, 5, utf8_decode("ANTEPONIENDO UN CORDIAL SALUDO, POR MEDIO DE LA PRESENTE LE HAGO DE SU CONOCIMIENTO QUE SE SUSPENDIO LA EVALUACIÓN POLIGRÁFICA DEL C. ".$nombre_completo." DE EDAD ".$xPersona->EDAD." AÑOS, PERTENECIENTE A LA DEPENDENCIA ".$xPersona->getCorporacion($xPersona->CORPORACION)." CON PUESTO DE ".$xPersona->CARGO), 0, "J");
      $y+=24;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "", "11");
      $pdf->Cell(0, 5, utf8_decode("DERIVADO DE QUE:"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "", "11");
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=8;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "B", "11");
      $pdf->Cell(0, 5, utf8_decode("En caso de que vaya avalado por el área médica, anexar la redacción."), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->SetFont("Arial", "", "11");
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=6;
      $pdf->SetXY(15,$y);
      $pdf->Cell(0, 5, utf8_decode("______________________________________________________________________________________"), 0, 0, "L");
      $y+=8;
      $pdf->SetXY(35,$y);
      $pdf->SetFont("Arial", "", "11");
      $pdf->Cell(0, 5, utf8_decode("SIN OTRO PARTUICULAR, AGRADEZCO SU ATENCIÓN."), 0, 0, "L");
      $y+=15;
      $pdf->SetXY(100,$y);
      $pdf->SetFont("Arial", "B", "9");
      $pdf->Cell(0, 5, utf8_decode("ATENTAMENTE"), 0, 0, "L");
      $y+=7;
      $pdf->SetXY(90,$y);
      $pdf->SetFont("Arial", "B", "9");
      $pdf->Cell(0, 5, utf8_decode("POLIGRAFISTA EVALUADOR"), 0, 0, "L");
      $y+=15;
        $DatosEval		= $xPsico->getDatEvaluador( $xPsico->CURP_EVAL_GEN );
        $arregloAuxiliar=explode(" ", $DatosEval[0]["NOMBRE"]);
        if(sizeof($arregloAuxiliar)>3){
            $pdf->SetXY(80,$y);
        }else{
            $pdf->SetXY(90,$y);
        }
      $pdf->SetFont("Arial", "B", "9");
      solicita($xUsr->xCurpEval,$conexion,$pdf);
      $y+=11;
      $pdf->SetXY(20,$y);
      $pdf->SetFont("Arial", "", "7");
      $pdf->Cell(0, 5, utf8_decode("C.c.p. Psic. Sandra Luz Gomez Arroyo / Encargada del Área de Poligrafía"), 0, 0, "L");
      $y+=4;
      $pdf->SetXY(20,$y);
      $pdf->SetFont("Arial", "", "7");
      $pdf->Cell(0, 5, utf8_decode("C.c.p. Lic. Olga Lidia Martinez Alvarez / Encargada del Área de Programación"), 0, 0, "L");
    $pdf->Output("cancelacion.pdf", "I");

?>