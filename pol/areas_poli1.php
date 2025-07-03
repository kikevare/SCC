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

   
  $sql = "SELECT nombre,a_paterno,a_materno,rfc,fecha_nac from tbdatospersonales where curp='$curp1' ";
  $resultado = mysqli_query($conexion, $sql);
  $fila = mysqli_fetch_assoc($resultado);
  $nombre_largo = $fila['nombre']." ".$fila['a_paterno']." ".$fila['a_materno'];


    // inicio  costado,inicio arriba, termina costado, ancho 
    //encabezado del documento
    $pdf->SetAutoPageBreak(false);
    $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
    $pdf->Image($xPath."imgs/mem_2024.jpg", 20, 9, 180, 20);
    $pdf->SetXY(18,14);
    $pdf->SetFont("Arial", "B", "8");
    $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA"), 0, 0, "C");
/*
    $pdf->SetY(20);
    $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
    $pdf->SetY(24);
    $pdf->Cell(0, 5, "", 0, 0, "C");
*/
    $pdf->SetFont("Arial", "BU", "9");
    $pdf->SetY(20);
    $pdf->Cell(0, 5, utf8_decode("DEPARTAMENTO DE POLIGRAFIA"), 0, 0, "C");

    $y=30;
    $pdf->SetFont("Arial", "B", "9.5");
    $pdf->SetY($y);
    $pdf->Cell(0, 5, utf8_decode("AUTORIZACIÓN DE AREAS EN EL EXAMEN POLIGRÁFICO"), 0, 0, "C");

  
   
    $y+=10; 
   
     //datos personales
     $xfecha = date('d') .' de '. $xSys->NomMesLargo( date("m") ) .' de '. date('Y');

  //datos personales
  $pdf->SetFont("Arial", "", "8");

  $pdf->SetXY(120,38);
  $pdf->Cell(12, 5, "CHILPANCINGO,Gro. a ".$xfecha, 0, 0, "L");
/* $pdf->Cell(10, 4, "", "B", 0, "C");
$pdf->Cell(17, 5, "del mes de", 0, 0, "C");
$pdf->Cell(35, 4, "", "B", 0, "C");
$pdf->Cell(16, 5, utf8_decode("del año 20"), 0, 0, "R"); */
$pdf->Cell(7, 4, ".", "B", 0, "R");
$pdf->SetXY(3,255);
$pdf->SetFont("Arial", "", "9");
$pdf->SetXY(50,45);
$pdf->MultiCell(125, 4, utf8_decode("A continuación se enlistan las áreas a tratar durante la entrevista por favor marcar con una X las áreas que autorice profundizar"),
0, "J");
   
     $pdf->Rect(25,60,175,135);
     $y=$pdf->GetY();
     $y+=5;
  
    
//fsfsfs
      $pdf->SetXY(26,68);
   
     $pdf->SetFont("Arial", "", "9");
       $pdf->MultiCell(115, 4, utf8_decode("1.- Datos Generales"),
      0, "J");
      //respuesta 1
      $pdf->SetXY(100,68);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "SI", 0,0,"L");
      $pdf->SetXY(105,68);
      $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,68);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,68);
$pdf->Cell(35, 4, "", "B",0,"L");

      $pdf->Rect(25,60,175,15);
  

     //fsfsfs
     $pdf->SetXY(26,80);

     $pdf->SetFont("Arial", "", "9");
       $pdf->MultiCell(115, 4, utf8_decode("2.-Información Personal"),
      0, "J");

            //respuesta 1
            $pdf->SetXY(100,80);
            $pdf->SetFont("Arial", "", "8");
            $pdf->Cell(20, 4, "SI", 0,0,"L");
            $pdf->SetXY(105,80);
            $pdf->Cell(35, 4, "", "B",0,"L");
      //respuesta 1
      $pdf->SetXY(140,80);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "NO", 0,0,"L");
      $pdf->SetXY(145,80);
      $pdf->Cell(35, 4, "", "B",0,"L");
      
      $pdf->Rect(25,60,175,30);
          //fsfsfs

          //fsfsfs
     $pdf->SetXY(26,95);

     $pdf->SetFont("Arial", "", "9");
       $pdf->MultiCell(115, 4, utf8_decode("3.-Aspectos de Salud"),
      0, "J");

       //respuesta 1
       $pdf->SetXY(100,95);
       $pdf->SetFont("Arial", "", "8");
       $pdf->Cell(20, 4, "SI", 0,0,"L");
       $pdf->SetXY(105,95);
       $pdf->Cell(35, 4, "", "B",0,"L");
 //respuesta 1
 $pdf->SetXY(140,95);
 $pdf->SetFont("Arial", "", "8");
 $pdf->Cell(20, 4, "NO", 0,0,"L");
 $pdf->SetXY(145,95);
 $pdf->Cell(35, 4, "", "B",0,"L");
 
      $pdf->Rect(25,60,175,45);

      $pdf->SetXY(26,110);

      $pdf->SetFont("Arial", "", "9");
        $pdf->MultiCell(115, 4, utf8_decode("4.-Antecedentes Laborales"),
       0, "J");
        //respuesta 1
        $pdf->SetXY(100,110);
        $pdf->SetFont("Arial", "", "8");
        $pdf->Cell(20, 4, "SI", 0,0,"L");
        $pdf->SetXY(105,110);
        $pdf->Cell(35, 4, "", "B",0,"L");
  //respuesta 1
  $pdf->SetXY(140,110);
  $pdf->SetFont("Arial", "", "8");
  $pdf->Cell(20, 4, "NO", 0,0,"L");
  $pdf->SetXY(145,110);
  $pdf->Cell(35, 4, "", "B",0,"L");
  
       $pdf->Rect(25,60,175,60);

    
  //RESPUESTA firmas
     
  $pdf->SetXY(26,125);

  $pdf->SetFont("Arial", "", "9");
    $pdf->MultiCell(115, 4, utf8_decode("5.-Situación Patrimonial"),
   0, "J");
    //respuesta 1
    $pdf->SetXY(100,125);
    $pdf->SetFont("Arial", "", "8");
    $pdf->Cell(20, 4, "SI", 0,0,"L");
    $pdf->SetXY(105,125);
    $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,125);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,125);
$pdf->Cell(35, 4, "", "B",0,"L");

   $pdf->Rect(25,60,175,75);
 //RESPUESTA firmas
     
 $pdf->SetXY(26,140);

 $pdf->SetFont("Arial", "", "9");
   $pdf->MultiCell(115, 4, utf8_decode("6.-Delitos"),
  0, "J");
   //respuesta 1
   $pdf->SetXY(100,140);
   $pdf->SetFont("Arial", "", "8");
   $pdf->Cell(20, 4, "SI", 0,0,"L");
   $pdf->SetXY(105,140);
   $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,140);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,140);
$pdf->Cell(35, 4, "", "B",0,"L");

  $pdf->Rect(25,60,175,90);

 //RESPUESTA firmas
     
 $pdf->SetXY(26,155);

 $pdf->SetFont("Arial", "", "9");
   $pdf->MultiCell(115, 4, utf8_decode("7.-Drogas"),
  0, "J");
   //respuesta 1
   $pdf->SetXY(100,153);
   $pdf->SetFont("Arial", "", "8");
   $pdf->Cell(20, 4, "SI", 0,0,"L");
   $pdf->SetXY(105,153);
   $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,153);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,153);
$pdf->Cell(35, 4, "", "B",0,"L");

  $pdf->Rect(25,60,175,100);

 //RESPUESTA firmas
     
 $pdf->SetXY(26,165);

 $pdf->SetFont("Arial", "", "9");
   $pdf->MultiCell(115, 4, utf8_decode("8.-Alcohol"),
  0, "J");
   //respuesta 1
   $pdf->SetXY(100,163);
   $pdf->SetFont("Arial", "", "8");
   $pdf->Cell(20, 4, "SI", 0,0,"L");
   $pdf->SetXY(105,163);
   $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,163);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,163);
$pdf->Cell(35, 4, "", "B",0,"L");

  $pdf->Rect(25,60,175,110);
  
 //RESPUESTA firmas
     
 $pdf->SetXY(26,175);

 $pdf->SetFont("Arial", "", "9");
   $pdf->MultiCell(115, 4, utf8_decode("9.-Participación en cualquier tipo de organizaciones"),
  0, "J");
   //respuesta 1
   $pdf->SetXY(100,175);
   $pdf->SetFont("Arial", "", "8");
   $pdf->Cell(20, 4, "SI", 0,0,"L");
   $pdf->SetXY(105,175);
   $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,175);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,175);
$pdf->Cell(35, 4, "", "B",0,"L");

  $pdf->SetXY(26,190);

  $pdf->SetFont("Arial", "", "9");
    $pdf->MultiCell(115, 4, utf8_decode("10.-Motivos de ingreso a esta institucion"),
   0, "J");
    //respuesta 1
    $pdf->SetXY(100,188);
    $pdf->SetFont("Arial", "", "8");
    $pdf->Cell(20, 4, "SI", 0,0,"L");
    $pdf->SetXY(105,188);
    $pdf->Cell(35, 4, "", "B",0,"L");
//respuesta 1
$pdf->SetXY(140,188);
$pdf->SetFont("Arial", "", "8");
$pdf->Cell(20, 4, "NO", 0,0,"L");
$pdf->SetXY(145,188);
$pdf->Cell(35, 4, "", "B",0,"L");

  $pdf->Rect(25,60,175,125);
  





        $pdf->SetXY(150,215);
        $pdf->SetFont("Arial", "", "8");
        $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");

       

         //NOMBRE
     
         $pdf->SetXY(75,215);
         $pdf->SetFont("Arial", "", "8");
         $pdf->Cell(20, 4, "NOMBRE", 0,0,"L");
        
           //RESPUESTA 5
          
           //RESPUESTA
           $pdf->SetXY(150,210);
           $pdf->Cell(35, 4, "", "B",0,"L");

         

  /* lugar de la huella 10.08.2019 $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE*/
   
   
     //RESPUESTA
    


$pdf->SetXY(75,225);
$pdf->Cell(20, 4, "FIRMA DE CONFORMIDAD Y A MI ENTERA SATISFACCION", 0,0,"L");
$pdf->SetXY(45,210);

$pdf->Cell(100, 4, $nombre_largo, "B",0,"L");

  /* lugar de la huella 10.08.2019 */
  
  $pdf->Rect(25,200,175,30);
 


  $pdf->SetXY(25,245);
$pdf->SetFont("Arial", "", "6");

$pdf->MultiCell(170, 5, utf8_decode('"La información contenida en el presente documento está clasificado como reservada de conformidad con el Artículo 6 párrafo A fracción I de la Constitución Política de los Estados Unidos Mexicanos, artículos 16, 97 y 113 fracción I de la Ley Federal de Transparencia y Acceso a la Información Pública, Articulo 56 segundo párrafo de la Ley General del Sistema Nacional de Seguridad Pública, Artículos 74, 114 fracciones I y II y 129 de la Ley número 207 de Transparencia y Acceso a la Información Pública del Estado de Guerrero, y Artículos 49 y 50 fracción XIII de la Ley Número 179 del Sistema de Seguridad Pública del Estado Libre y Soberano de Guerrero"'),
 0, "J");

      //FIRMA 10.08.2019
     
      $pdf->SetAutoPageBreak(false);
      $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
      $pdf->Image($xPath."imgs/mem_2024.jpg", 20, 9, 180, 20);
      $pdf->SetXY(18,14);
      $pdf->SetFont("Arial", "B", "8");
      $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA"), 0, 0, "C");
  /*
      $pdf->SetY(20);
      $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
      $pdf->SetY(24);
      $pdf->Cell(0, 5, "", 0, 0, "C");
  */
      $pdf->SetFont("Arial", "BU", "9");
      $pdf->SetY(20);
      $pdf->Cell(0, 5, utf8_decode("DEPARTAMENTO DE POLIGRAFIA"), 0, 0, "C");
  
      $y=30;
      $pdf->SetFont("Arial", "B", "9.5");
      $pdf->SetY($y);
      $pdf->Cell(0, 5, utf8_decode("FORMATO DE AUTORIZACIÓN AL EXAMEN POLIGRÁFICO"), 0, 0, "C");
  
    
     
      $y+=10; 
     
       //datos personales
       $pdf->SetFont("Arial", "B", "8");

       $pdf->SetXY(141,38);
       $pdf->Cell(12, 5, "CHILPANCINGO,Gro. a ".$xfecha, 0, 0, "L");
  $pdf->Cell(7, 4, ".", "B",1, "R");
  $pdf->SetFont("Arial", "", "9");
  
  $pdf->Ln(2);
  $pdf->SetX(24);
  $pdf->MultiCell(176, 4, utf8_decode("Declaro que me sujeto de forma voluntaria a ser evaluado (a) por el Centro Estatal de Evaluación y Control de Confianza del Estado de Guerrero, a efecto de dar cumplimiento al Artículo 21 Constitucional, que establece que la seguridad pública es una función a cargo de la Federación, los Estados y los Municipios; que las instituciones de seguridad pública se sujetarán a las bases mínimas para regular la selección, ingreso, formación, permanencia, evaluación, reconocimiento y certificación de los integrantes de las instituciones de seguridad pública; El Artículo 88 de la Ley General del Sistema Nacional de Seguridad Pública que establece que son requisitos de ingreso y permanencia en las Instituciones Policiales, aprobar los procesos de evaluación de control de confianza; Los Artículos 49 y 50 de la Ley  Número 179 del Sistema de Seguridad Pública del Estado Libre y Soberano de Guerrero que especifica que el Centro Estatal de Evaluación y Control de Confianza, aplicará las evaluaciones, tanto en los procesos de selección de aspirantes, como en la evaluación para la permanencia, el desarrollo y la promoción del personal de las Instituciones de Seguridad Pública, sus auxiliares  y privada."),
 0, "J");
  //$pdf->SetXY(3,255);
      
  
       
     
       $pdf->Rect(25,85,175,125);
       $y=$pdf->GetY();
       $y+=5;
    
       $pdf->SetXY(26,90);
  
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(150, 4, utf8_decode("Declaro que me fue explicada la naturaleza y caracteristica del examen poligráfico."),
        0, "J");
  //fsfsfs
        $pdf->SetXY(26,104);
  
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(115, 4, utf8_decode("Declaro que me sujeto en forma voluntaria al examen Poligráfico, en el entendido que puedo retirarme en el momento que lo desee."),
        0, "J");
       //fsfsfs
       $pdf->SetXY(26,121);
  
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(115, 4, utf8_decode("Autorizo que el resultado obenido sea revisado por el personal autorizado e involucrado en mi proceso de control de confianza."),
        0, "J");
       
            //fsfsfs
       $pdf->SetXY(26,136);
  
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(115, 4, utf8_decode("Entiendo que el resultado que arroje el proceso de evaluacion, es definitivo y las conclusiones técnicas no estan sujetas a modificacion."),
        0, "J");
   //fsfsfs
        $pdf->SetXY(26,151);
  
        $pdf->SetFont("Arial", "", "9");
          $pdf->MultiCell(115, 4, utf8_decode("Autorizo que sean colocados en mi persona aditamentos necesarios para el examen poligráfico."),
         0, "J");
  
          //fsfsfs
        $pdf->SetXY(26,166);
  
        $pdf->SetFont("Arial", "", "9");
          $pdf->MultiCell(115, 4, utf8_decode("Me comprometo a responder con veracidad las preguntas que me sean formuladas, en el entendido de que la información será manejada con carácter confidencial. Expreso mi consentimiento para que los documentos que contengan, sean depurados en cualquier momento."),
         0, "J");
  
         $pdf->SetXY(26,191);
  
         $pdf->SetFont("Arial", "", "9");
           $pdf->MultiCell(115, 4, utf8_decode("Se me informó que, por razones de control de calidad y seguridad, mi procedimiento de evaluación puede ser registrado en medios electrónicos."),
          0, "J");
    //RESPUESTA firmas
       
           $pdf->SetXY(150,225);
           $pdf->SetFont("Arial", "", "8");
           $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
            //RESPUESTA
          $pdf->SetXY(150,220);
          $pdf->Cell(35, 4, "", "B",0,"L");
  
         
  
          //  //NOMBRE
       
          $pdf->SetXY(70,225);
          $pdf->SetFont("Arial", "", "8");
          $pdf->Cell(20, 4, "NOMBRE", 0,0,"L");
          $pdf->SetXY(50,220);
          $pdf->Cell(35, 4, $nombre_largo, "B",0,"L");
        
         //RESPUESTA 5
      $pdf->SetXY(150,95);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
       //RESPUESTA
       $pdf->SetXY(150,90);
       $pdf->Cell(35, 4, "", "B",0,"L");

        //RESPUESTA 5
        $pdf->SetXY(150,109);
        $pdf->SetFont("Arial", "", "8");
        $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
        //RESPUESTA
        $pdf->SetXY(150,104);
        $pdf->Cell(35, 4, "", "B",0,"L");

       //RESPUESTA
      $pdf->SetXY(150,126);
      $pdf->SetFont("Arial", "", "8");
       $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
       //RESPUESTA
       $pdf->SetXY(150,121);
       $pdf->Cell(35, 4, "", "B",0,"L");
      
           //RESPUESTA
      $pdf->SetXY(150,141);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
           //RESPUESTA
      $pdf->SetXY(150,136);
      $pdf->Cell(35, 4, "", "B",0,"L");
     
      //RESPUESTA 3
      $pdf->SetXY(150,156);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
      //RESPUESTA
      $pdf->SetXY(150,151);
      $pdf->Cell(35, 4, "", "B",0,"L");
          
      //RESPUESTA 4
      $pdf->SetXY(150,171);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
      //RESPUESTA
      $pdf->SetXY(150,166);
      $pdf->Cell(35, 4, "", "B",0,"L");

      // $pdf->SetXY(150,135);
      // $pdf->Cell(35, 4, "", "B",0,"L");
      // //RESPUESTA 5
      $pdf->SetXY(150,196);
      $pdf->SetFont("Arial", "", "8");
      $pdf->Cell(20, 4, "FIRMA DEL EVALUADO", 0,0,"L");
      //RESPUESTA
      $pdf->SetXY(150,191);
      $pdf->Cell(35, 4, "", "B",0,"L");
  
    /* lugar de la huella 10.08.2019 */
     
     
       //RESPUESTA
      
  
  
  $pdf->SetXY(75,233);
  $pdf->Cell(20, 4, "FIRMA DE CONFORMIDAD Y A MI ENTERA SATISFACCION", 0,0,"L");
  $pdf->SetXY(30,220);
  $pdf->Cell(100, 4, "", "B",0,"L");
  
    /* lugar de la huella 10.08.2019 */
    
    $pdf->Rect(25,210,175,30);
   
  
  
    $pdf->SetXY(25,245);
  $pdf->SetFont("Arial", "", "6");
  
  $pdf->MultiCell(175, 3, utf8_decode('"La información contenida en el presente documento está clasificado como reservada de conformidad con el Artículo 6 párrafo A fracción I de la Constitución Política de los Estados Unidos Mexicanos, artículos 16, 97 y 113 fracción I de la Ley Federal de Transparencia y Acceso a la Información Pública, Articulo 56 segundo párrafo de la Ley General del Sistema Nacional de Seguridad Pública, Artículos 74, 114 fracciones I y II y 129 de la Ley número 207 de Transparencia y Acceso a la Información Pública del Estado de Guerrero, y Artículos 49 y 50 fracción XIII de la Ley Número 179 del Sistema de Seguridad Pública del Estado Libre y Soberano de Guerrero"'),
   0, "J");
  
        //FIRMA 10.08.2019
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
        $pdf->Image($xPath."imgs/mem_2024.jpg", 20, 9, 180, 20);
        $pdf->SetXY(18,14);
        $pdf->SetFont("Arial", "B", "8");
        $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA"), 0, 0, "C");
    /*
        $pdf->SetY(20);
        $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
        $pdf->SetY(24);
        $pdf->Cell(0, 5, "", 0, 0, "C");
    */
        $pdf->SetFont("Arial", "BU", "9");
        $pdf->SetY(20);
        $pdf->Cell(0, 5, utf8_decode("DEPATAMENTO DE POLIGRAFIA"), 0, 0, "C");
    
        $y=30;
        $pdf->SetFont("Arial", "B", "9.5");
        $pdf->SetY($y);
        $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
    
      
       
        $y+=10; 
       
         //datos personales
       
    
    $pdf->SetXY(25,45);
    $pdf->SetFillColor(200);
    
    
    $pdf->SetFont("Arial", "B", "9");
    
    $pdf->Cell(175, 10, "DATOS GENERALES ", 1, 0, "C",true);
    $pdf->SetXY(25,55);
    $pdf->Cell(175, 10, "ANALISIS POLIGRAFICO ", 1, 0, "C",true);
    
    $pdf->Rect(25,65,175,60);
    $pdf->SetXY(26,70);
    
    $pdf->SetFont("Arial", "", "9");
      $pdf->MultiCell(180, 4, "NOMBRE:" .$nombre_largo,
     0, "J");
   /*  
     $pdf->SetXY(40,75);
     $pdf->MultiCell(115, 4, utf8_decode("APELLIDO PATERNO"),
     0, "J");
    
     $pdf->SetXY(85,75);
     $pdf->MultiCell(115, 4, utf8_decode("APELLIDO MATERNO"),
     0, "J");
    
     $pdf->SetXY(135,75);
     $pdf->MultiCell(115, 4, utf8_decode("NOMBRE"),
     0, "J"); */
    //fsfsfs
         
         
           
          //respuesta 1
      
    
         //fsfsfs
         $pdf->SetXY(26,85);
    $fechahoy=date('Y-m-d');
    $edad = $fechahoy-$fila['fecha_nac'];
         $pdf->SetFont("Arial", "", "9");
           $pdf->MultiCell(115, 4, utf8_decode("EDAD: ".$edad),
          0, "J");
    
                //respuesta 1
                $pdf->SetXY(70,85);
                $pdf->SetFont("Arial", "", "8");
                $pdf->Cell(20, 4, "RFC: " .$fila['rfc'], 0,0,"L");
           
          //respuesta 1
          $pdf->SetXY(115,85);
          $pdf->SetFont("Arial", "", "8");
          $pdf->Cell(20, 4, "LUGAR Y FECHA DE NACIMIENTO:____________________", 0,0,"L");
        
       
              //fsfsfs
    
              //fsfsfs
         $pdf->SetXY(26,95);
    
         $pdf->SetFont("Arial", "", "9");
           $pdf->MultiCell(115, 4, utf8_decode("ESTADO CIVIL:___________"),
          0, "J");
    
           //respuesta 1
           $pdf->SetXY(70,95);
           $pdf->SetFont("Arial", "", "8");
           $pdf->Cell(20, 4, "DOMICILIO ACTUAL:(COMPLETO)__________________________________________________", 0,0,"L");
         
     //respuesta 1
    
     $pdf->SetXY(26,100);
     $pdf->Cell(170, 4, "", "B",0,"L");
     
         
    
          $pdf->SetXY(26,115);
    
          $pdf->SetFont("Arial", "", "9");
            $pdf->MultiCell(115, 4, utf8_decode("TELEFONO:________________"),
           0, "J");
            //respuesta 1
            $pdf->SetXY(80,115);
            $pdf->SetFont("Arial", "", "8");
            $pdf->Cell(20, 4, "OFICINA:________________", 0,0,"L");
            
      //respuesta 1
      
      $pdf->SetXY(130,115);
      $pdf->Cell(35, 4, "EXT:_______________", 0,0,"L");
      
       
     $pdf->SetXY(26,105);
     $pdf->MultiCell(115, 4, utf8_decode("COLONIA"),
     0, "J");
    
     $pdf->SetXY(85,105);
     $pdf->MultiCell(115, 4, "DELEGACION O MUNICIPIO: ".$xPersona->getMunicipio($xPersona->MPIOADSCRIP),
     0, "J");
    
     $pdf->SetXY(175,105);
     $pdf->MultiCell(115, 4, utf8_decode("C.P."),
     0, "J");
    
        
      //RESPUESTA firmas
    
      $pdf->Rect(25,130,175,50);
    
      /* lugar de la huella 10.08.2019 */
      $pdf->SetXY(26,135);
    
      $pdf->SetFont("Arial", "", "9");
        $pdf->MultiCell(175, 4, utf8_decode("GRADO MAXIMO DE ESTUDIOS:_____________________________________________________________________"),
       0, "J");
    
       $pdf->SetXY(26,142);
    
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(175, 4, utf8_decode("COMPROBANTE DE ESTUDIOS:_____________________________________________________________________"),
        0, "J");
        $pdf->SetXY(26,148);
    
        $pdf->SetFont("Arial", "", "9");
          $pdf->MultiCell(175, 4, utf8_decode("ESCUELA Y LUGAR DONDE REALIZO SUS ULTIMOS ESTUDIOS:__________________________________________"),
         0, "J");
    
       
         $pdf->SetXY(26,156);
     
         $pdf->SetFont("Arial", "", "9");
           $pdf->MultiCell(175, 4, utf8_decode("EVALUADO PARA EL PUESTO:______________________________ AREA:__________________________________"),
          0, "J");
    
          $pdf->SetXY(26,162);
     
          $pdf->SetFont("Arial", "", "9");
          $pdf->MultiCell(175, 4, utf8_decode("COMO O POR QUIEN SE ENTERO DE ESTA VACANTE:__________________________________________________"),
         0, "J");
       
         //RESPUESTA
         $pdf->SetXY(26,168);
     
      $pdf->SetFont("Arial", "", "9");
      $pdf->MultiCell(175, 4, utf8_decode("RELACION CON QUIEN LO RECOMIENDA:_____________________________________________________________"),
     0, "J");
    
     $pdf->SetXY(26,175);
     
     $pdf->SetFont("Arial", "", "9");
     $pdf->MultiCell(175, 4, utf8_decode("TIEMPO DE CONOCERLO:__________________________________________________________________________"),
    0, "J");
    
    
    
    
      $pdf->SetXY(25,180);
      $pdf->SetFillColor(200);
    
    
      $pdf->SetFont("Arial", "B", "9");
      
      $pdf->Cell(175, 10, " ", 1, 0, "C",true);
      $pdf->SetXY(26,181);
     
      $pdf->SetFont("Arial", "", "9");
      $pdf->MultiCell(174, 4, utf8_decode("EN CASO DE QUE HAYA SIDO CANALIZADO CON QUIEN LO RECOMIENDA POR MEDIO DE ALGUNA OTRA PERSONA FAVOR DE ANOTAR LOS SIGUIENTES DATOS"),
     0, "J");
     
    
     /* lugar de la huella 10.08.2019 */
     $pdf->SetXY(26,192);
    
     $pdf->SetFont("Arial", "", "9");
       $pdf->MultiCell(175, 4, utf8_decode("QUIEN LO CANALIZO_______________________________________________________________________________"),
      0, "J");
    
      $pdf->SetXY(26,198);
    
      $pdf->SetFont("Arial", "", "9");
        $pdf->MultiCell(175, 4, utf8_decode("RELACION CON QUIEN LO CANALIZO_________________________________________________________________"),
       0, "J");
       $pdf->SetXY(26,203);
    
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(175, 4, utf8_decode("TIEMPO DE CONOCERLO___________________________________________________________________________"),
        0, "J");
    
        $pdf->SetXY(25,208);
      $pdf->SetFillColor(200);
    
    
      $pdf->SetFont("Arial", "B", "9");
      
      $pdf->Cell(175, 8, " ", 1, 0, "C",true);
      $pdf->SetXY(26,210);
     
      $pdf->SetFont("Arial", "", "9");
      $pdf->MultiCell(174, 4, utf8_decode("EXCLUSIVO PARA PERSONAS QUE LABORAN O HAN LABORADO EN LA INSTITUCION"),
     0, "J");
     $pdf->SetXY(26,218);
    
     $pdf->SetFont("Arial", "", "9");
       $pdf->MultiCell(175, 4, utf8_decode("FECHA DE INGRESO A LA INSTITUCION:______________________________________________________________"),
      0, "J");
    
    
      $pdf->SetXY(26,222);
    
      $pdf->SetFont("Arial", "", "9");
        $pdf->MultiCell(175, 4, utf8_decode("PUESTO ANTERIOR:______________________________ AREA:___________________________________________"),
       0, "J");
    
       $pdf->SetXY(26,226);
    
       $pdf->SetFont("Arial", "", "9");
         $pdf->MultiCell(175, 4, utf8_decode("SUBDIRECCION:______________________________ DEPARTAMENTO:_____________________________________"),
        0, "J");
     
    ///dFGDF
    $pdf->SetXY(25,231);
    $pdf->SetFillColor(200);
    
    
    $pdf->SetFont("Arial", "B", "9");
    
    $pdf->Cell(175, 5, " ", 1, 0, "C",true);
    $pdf->SetXY(75,232);
    
    $pdf->SetFont("Arial", "", "9");
    $pdf->MultiCell(174, 4, utf8_decode("PARA USO EXCLUSIVO DEL EVALUADOR"),
    0, "J");
    $pdf->SetXY(26,242);
    
    $pdf->SetFont("Arial", "", "9");
     $pdf->MultiCell(175, 4, utf8_decode("FECHA DE APLICACION:___________________________________________________________________________"),
    0, "J");
    
    
    $pdf->SetXY(26,237);
    
    $pdf->SetFont("Arial", "", "9");
      $pdf->MultiCell(175, 4, utf8_decode("IDENTIFICACION:____________________ POLIGRAFISTA EVALUADOR:___________________________________"),
     0, "J");
    
     $pdf->SetXY(26,247);
    
     $pdf->SetFont("Arial", "", "9");
     $pdf->MultiCell(175, 4, utf8_decode("FECHA DE APLICACION DEL ULTIMO EXAMEN POLIGRAFICO:___________________________________________"),
      0, "J");
    
    
    
    
    
    
    
    
    
    
    
    
     
      $pdf->SetXY(25,255);
    $pdf->SetFont("Arial", "", "6");
    
    
    
    
    $pdf->MultiCell(170, 2, utf8_decode('"La información contenida en el presente documento está clasificado como reservada de conformidad con el Artículo 6 párrafo A fracción I de la Constitución Política de los Estados Unidos Mexicanos, artículos 16, 97 y 113 fracción I de la Ley Federal de Transparencia y Acceso a la Información Pública, Articulo 56 segundo párrafo de la Ley General del Sistema Nacional de Seguridad Pública, Artículos 74, 114 fracciones I y II y 129 de la Ley número 207 de Transparencia y Acceso a la Información Pública del Estado de Guerrero, y Artículos 49 y 50 fracción XIII de la Ley Número 179 del Sistema de Seguridad Pública del Estado Libre y Soberano de Guerrero"'),
     0, "J");
    
          //FIRMA 10.08.2019  
    
          $pdf->SetAutoPageBreak(false);
          $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
          $pdf->Image($xPath."imgs/mem_2024.jpg", 20, 9, 180, 20);
          $pdf->SetXY(18,14);
          $pdf->SetFont("Arial", "B", "8");
          $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA"), 0, 0, "C");
      /*
          $pdf->SetY(20);
          $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
          $pdf->SetY(24);
          $pdf->Cell(0, 5, "", 0, 0, "C");
      */
          $pdf->SetFont("Arial", "BU", "9");
          $pdf->SetY(20);
          $pdf->Cell(0, 5, utf8_decode("DEPARTAMENTO DE POLIGRAFIA"), 0, 0, "C");
      
          $y=30;
          $pdf->SetFont("Arial", "B", "9.5");
          $pdf->SetY($y);
          $pdf->Cell(0, 5, utf8_decode("FORMATO DE AUTORIZACIÓN AL EXAMEN POLIGRÁFICO"), 0, 0, "C");
      
          $y+=10;
          $pdf->SetFont("Arial", "", "8");

          $pdf->SetXY(130,38);
          $pdf->Cell(12, 5, "CHILPANCINGO,Gro. a ".$xfecha, 0, 0, "L");
          
          $pdf->Cell(28, 5, "", "B", 0, "L");
          $pdf->Cell(1, 5, ".", 0, 0, "C");
      
          $y+=10;
          $pdf->SetXY(15,$y);
          $pdf->SetFont("Arial", "B", "9");
          $pdf->Cell(17, 5, "YO:", 0, 0, "L");
          $pdf->SetFont("Arial", "", "9");
          $pdf->Cell(150, 5, "", "B", 0, "L");
      
          $y+=10;
          $pdf->SetFont("Arial", "", "11");
          $pdf->SetXY(15,$y);
          $pdf->MultiCell(189, 5, utf8_decode("Inicie a las         :           horas el proceso de evaluación como parte del proceso de Control de Confianza.  "),
           0, "J");
           $y+=10;
           $pdf->SetFont("Arial", "", "11");
           $pdf->SetXY(15,$y);
           $pdf->MultiCell(189, 5, utf8_decode("Mediante este escrito se me informó que la evaluación concluyó siendo las         :         horas."),
            0, "J");
      
       
          $y+=10;
          $y=$pdf->GetY();
      
          $pdf->SetXY(20,$y);
          $pdf->MultiCell(180, 5, utf8_decode("Por favor, en los recuadros adjuntos escriba un breve comentario respecto al examen y al trato que recibío por parte del poligrafista  que lo atendió. Si tiene alguna queja u objeción en este momento regístrelo en el mismo espacio."),
          0, "J");
          $pdf->Rect(15,$y,189,90);
      
          $y=$pdf->GetY();
      
          $y=$pdf->GetY();
      
      
          $y+=10;
         
         
          $y+=21;
         
         
          $y+=45;
      
          $pdf->SetFont("Arial", "", "11");
          $pdf->SetXY(20,$y);
          $pdf->Cell(189, 5, utf8_decode("De no existir queja u objeción firme el calce, para ratificar la siguiente afirmación:"), 0, 0, "L");
      
          $y+=15;
          $pdf->SetXY(15,$y);
          $pdf->MultiCell(189, 5, utf8_decode('"Manifiesto que presenté el examen poligráfico  por mi libre voluntad, sabiendo que pude suspenderla en el momento en que lo deseara; que no se me formuló ninguna promesa y que no fui objeto de daño, amenazas o intimidación alguna."'),
           0, "J");
           $y+=20;
           $pdf->SetXY(15,$y);
          /*  pdf->MultiCell(189, 5, utf8_decode('"He sido enterado (a) de que, para salvaguardar mis datos personales, toda la informacion que proporcione sera clasificada como confidencial de conformidad con la normativa aplicable en materia de transparencia y acceso a la Informacion Publica Gubernamental"'),
            0, "J"); */
      
          $y=$pdf->GetY();
          $y+=25;
          $pdf->SetXY(50,$y);
          $pdf->Cell(110, 5, "", "B", 0, "L");

          $y+=5;
          $pdf->SetXY(65,$y);
          $pdf->SetFont("Arial", "", "9");

          $pdf->Cell(15, 5, "FIRMA DE CONFORMIDAD Y A MI ENTERA SATISFACCION", 0, 0, "");

          $y+=15;
          $pdf->SetXY(80,$y);
          $pdf->SetFont("Arial", "B", "9");

          $pdf->Cell(15, 5, "GRACIAS POR SU COLABORACION", 0, 0, "");
       //datos personales
       
      
      
      
      
      
          /* lugar de la huella 10.08.2019 */
          //$pdf->Rect(179,218,20,20);
          $pdf->SetXY(130,$y+10);
         
          //$pdf->Cell(10, 2, utf8_decode("HUELLA DEL DEDO ÍNDICE DERECHO"), 0, 0, "L");
          $y=$pdf->GetY();
          
         
          $pdf->SetXY(50,$y);
        
           $y=$pdf->GetY();
           
      
          $pdf->SetFont("Arial", "", "5");
          $pdf->SetXY(15,$y);
          $pdf->MultiCell(189, 2.5, utf8_decode('"La información contenida en el presente documento está clasificado como reservada de conformidad con el Artículo 6 párrafo A fracción I de la Constitución Política de los Estados Unidos Mexicanos, artículos 16, 97 y 113 fracción I de la Ley Federal de Transparencia y Acceso a la Información Pública, Articulo 56 segundo párrafo de la Ley General del Sistema Nacional de Seguridad Pública, Artículos 74, 114 fracciones I y II y 129 de la Ley número 207 de Transparencia y Acceso a la Información Pública del Estado de Guerrero, y Artículos 49 y 50 fracción XIII de la Ley Número 179 del Sistema de Seguridad Pública del Estado Libre y Soberano de Guerrero"'),
           0, "J");
           
    
      $pdf->SetAutoPageBreak(false);
      $pdf->AddPage();                                       // inicio  costado,inicio arriba, termina costado, ancho
      $pdf->Image($xPath."imgs/mem_2024.jpg", 20, 9, 180, 20);
      $pdf->SetXY(18,14);
      $pdf->SetFont("Arial", "B", "8");
      $pdf->Cell(0, 5, utf8_decode("CENTRO ESTATAL DE EVALUACIÓN Y CONTROL DE CONFIANZA"), 0, 0, "C");
  /*
      $pdf->SetY(20);
      $pdf->Cell(0, 5, utf8_decode(""), 0, 0, "C");
      $pdf->SetY(24);
      $pdf->Cell(0, 5, "", 0, 0, "C");
  */
      $pdf->SetFont("Arial", "BU", "9");
      $pdf->SetY(20);
      $pdf->Cell(0, 5, utf8_decode("DEPARTAMENTO DE POLIGRAFIA"), 0, 0, "C");
  
      $y=30;
      $pdf->SetFont("Arial", "B", "9.5");
      $pdf->SetY($y);
      $pdf->Cell(0, 5, utf8_decode("MANIFESTACIÓN PARA LA PROTECCIÓN DE DATOS PERSONALES"), 0, 0, "C");
  
      $y+=10;
      $pdf->SetFont("Arial", "", "11");

      $pdf->SetXY(30,60);
      $pdf->Cell(12, 5, "EL SUSCRITO ____________________________________________________________", 0, 0, "L");
      
      $pdf->SetXY(30,90);

      $pdf->SetFont("Arial", "", "10");

      $pdf->MultiCell(150, 5, utf8_decode('NO AUTORIZA QUE SE HAGA PUBLICA LA INFORMACIÓN DERIVADA DEL PRESENTE PROCESO DE EVALUACIÓN DE CONTROL DE CONFIANZA, ASÍ COMO SUS RESULTADOS.'),
      0, "J");
     
      $pdf->SetFont("Arial", "B", "9");

      //$pdf->Cell(15, 5, "GRACIAS POR SU COLABORACION", 0, 0, "");
   //datos personales
   
   $y+=10;

  
   $pdf->SetXY(45,130);
   $pdf->Cell(12, 5, " ______________________________________________________________________", 0, 0, "L");
  
  
   $pdf->SetXY(100,135);
   $pdf->Cell(12, 5, " FIRMA", 0, 0, "L");
  


   
   $pdf->SetXY(45,180);
   $pdf->Cell(12, 5, " ______________________________________________________________________", 0, 0, "L");
  
  
   $pdf->SetXY(100,185);
   $pdf->Cell(12, 5, " FECHA", 0, 0, "L");
      /* lugar de la huella 10.08.2019  $xfecha*/
      //$pdf->Rect(179,218,20,20);

      $pdf->SetXY(90,180);
      $pdf->Cell(12, 5, $xfecha, 0, 0, "L");
      
 
      $pdf->SetXY(25,245);
      $pdf->SetFont("Arial", "", "6");
      
      $pdf->MultiCell(170, 5, utf8_decode('"La información contenida en el presente documento está clasificado como reservada de conformidad con el Artículo 6 párrafo A fracción I de la Constitución Política de los Estados Unidos Mexicanos, artículos 16, 97 y 113 fracción I de la Ley Federal de Transparencia y Acceso a la Información Pública, Articulo 56 segundo párrafo de la Ley General del Sistema Nacional de Seguridad Pública, Artículos 74, 114 fracciones I y II y 129 de la Ley número 207 de Transparencia y Acceso a la Información Pública del Estado de Guerrero, y Artículos 49 y 50 fracción XIII de la Ley Número 179 del Sistema de Seguridad Pública del Estado Libre y Soberano de Guerrero"'),
       0, "J");
      

    $pdf->Output("iniciales.pdf", "I");

?>