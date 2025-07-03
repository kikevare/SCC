<?php
    session_start();
    //-------------------------------------------------------------//
    $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
    for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
    //-------------------------------------------------------------//
    include_once($xPath."includes/xsystem.php");
    include_once($xPath."includes/persona.class.php");
    include_once($xPath."includes/invDocumental.class.php");
    include_once($xPath.'includes/fpdf16/pdf.php');
    
    $xSys = New System();   
    $pdf = New PDF('P','mm','Letter');
    $pdf->SetAutoPageBreak(false);
    $pdf->SetMargins(15, 10, 15);
    
    $xPersona = New Persona( $_SESSION["xCurp"] );
    $xEval= New Evaluaciones( $_SESSION["xCurp"] );
    $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
     
    $xInvDoc->getDatosGenerales(); 	  
    $pdf->AddPage();
    //encabezado del documento
    $pdf->SetMargins(15, 10, 15);
    
    $y=10;
    $DatosC = $xInvDoc->getDatosCartilla();
    if($DatosC[0]["DOC_RESGUARDO"] == 1){
        $pdf->Image($xPath."imgs/membrete_nvo.jpg", 10, $y, 195, 30);   
        $pdf->SetFont("Arial", "B", "9");
        $y+=3;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "SECRETARIADO EJECUTIVO DEL CONSEJO ESTATAL", 0, 0, "C");
        $y+=6;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "DE SEGURIDAD PÚBLICA", 0, 0, "C");
        $y+=6;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "DIRECCIÓN DEL CENTRO ESTATAL DE EVALUACIÓN", 0, 0, "C");
        $y+=6;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO", 0, 0, "C");
        
        
        $y+=6;
        $palomita=52;
        
        $pdf->SetFont("Arial", "U", "10");
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "ÁREA DE INVESTIGACIÓN DOCUMENTAL", 0, 0, "C");
        
        $y+=6;
        $pdf->SetFont("Arial", "BU", "10");
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "RECIBO DE  CARTILLA MILITAR DEL S.M.N.", 0, 0, "C");
        
        $y+=6;
        $pdf->SetFont("Arial", "B", "11");
        //datos del trabajador
        $pdf->SetXY(15,$y);
        $pdf->Cell(20, 5, "NOMBRE:", 0, 0, "L");
        //NOMBRE COMPLETO 
        $pdf->SetFont("Arial", "", "11");
        $pdf->CellFitScale(120, 5, $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE, "B", 0, "C");
        $pdf->Cell(16, 5, "FECHA:", 0, 0, "L");
        $pdf->CellFitScale(32, 5, $xSys->FormatoCorto(date('d-m-Y')), "B", 0, "C");
        
        $Nuevo          = ( $xEval->ID_TIPO_EVAL == 1 ) ? "52" :"0";
        $Permanencia    = ( $xEval->ID_TIPO_EVAL == 2 ) ? "52" :"0";
        $Promocion      = ( $xEval->ID_TIPO_EVAL == 3 ) ? "52" :"0";
        
        $y+=8;
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(25, 5, "Nuevo Ingreso", 0, 0, "L");
        $pdf->Ellipse(45,$y+2.5,4,2.5);
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Nuevo),0,0,"C");
        
        
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(95,$y);
        $pdf->Cell(23, 5, "Permanencia", 0, 0, "L");
        $pdf->Ellipse(123,$y+2.5,4,2.5);
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Permanencia),0,0,"C");
        
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(173,$y);
        $pdf->Cell(20, 5, "Promoción", 0, 0, "L");
        $pdf->Ellipse(198,$y+2.5,4,2.5);
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Promocion),0,0,"C");
        
        $pdf->SetFont("Arial", "B", "10");
        //OPTIENE LA POSICION DEL LA COORDENADA Y
        //$y=$pdf->GetY();
        //$xPersona->CORPORACION == 2
        $estatal      = ( $xPersona->CORPORACION== 1 ) ? "52" :"0";
        $municipal    = ( $xPersona->CORPORACION== 2 ) ? "52" :"0";
        $ipae         = ( $xPersona->CORPORACION== 3 ) ? "52" :"0";
        $pgje         = ( $xPersona->CORPORACION== 4 ) ? "52" :"0";
        $seg_priv     = ( $xPersona->CORPORACION== 5 ) ? "52" :"0";
        $cesp         = ( $xPersona->CORPORACION== 6 ) ? "52" :"0";
        
        //OPTIENE LA POSICION DEL LA COORDENADA Y
        //$y=$pdf->GetY();
        $y+=5;
        $pdf->SetXY(15,$y);
        $pdf->Cell(25, 5, "Corporación:", 0, 0, "L");
        //--------------------------------------------
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "POLICIA ESTATAL..................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->SetXY(80,$y);
        $pdf->Cell(10,5,chr($estatal),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "POLICIA MUNICIPAL...",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->SetXY(80,$y);
        $pdf->Cell(10,5,chr($municipal),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "I.P.A.E......................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->SetXY(80,$y);
        $pdf->Cell(10,5,chr($ipae),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(      )",0, 0, "L");
        
        
        //DERECHA
        $y-=10;
        
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "P.G.J.E..................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->SetXY(193,$y);
        $pdf->Cell(10,5,chr($pgje),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "SEGURIDAD PRIVADA..............................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->SetXY(193,$y);
        $pdf->Cell(10,5,chr($seg_priv),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(15, 5, "C.E.S.P..........................................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->SetXY(193,$y);
        $pdf->Cell(10,5,chr($cesp),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        //--------------------------------------------
        
        $y+=5;
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(45, 5, "DOCUMENTACION EN RESGUARDO:",0, 0, "L");
        
        
        $catillaNL      = ( $DatosC[0]["DOC_VALIDAR"]== 1 ) ? "52" :"0";
        $catillaYHL     = ( $DatosC[0]["DOC_VALIDAR"]== 2 ) ? "52" :"0";
        $catillaC       = ( $DatosC[0]["DOC_VALIDAR"]== 3 ) ? "52" :"0";
        $catillaYHE     = ( $DatosC[0]["DOC_VALIDAR"]== 4 ) ? "52" :"0";
        $catillaOE      = ( $DatosC[0]["DOC_VALIDAR"]== 5 ) ? "52" :"0";
        $Otro           = ( $DatosC[0]["DOC_VALIDAR"]== 6 ) ? "52" :"0";
        
        $y+=6;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "CARTILLA (NO LIBERADA)..................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($catillaNL),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "CARTILLA Y HOJA DE LIBERACIÓN...",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($catillaYHL),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "CONSTANCIA DEL S.M.N.....................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($catillaC),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        
        //DERECHA
        
        
        $y-=10;
        
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "CARTILLA Y HOJA DE EXCEPCIÓN.................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($catillaYHE),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "OFICIO DE EXCEPTUACIÓN.............................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($catillaOE),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(15, 5, "OTROS",0, 0, "L");
        //RESPUESTA
        $pdf->CellFitScale(78, 5, $DatosC[0]["OTRO_DOC"],"B", 0,"L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Otro),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        $xInvDoc->getDatosGenerales();
        $xDatosE = $xInvDoc->getDatEvaluador($DatosC[0]["CURP_EVALUADOR"]);
        
        $y+=10;
        $pdf->SetFont("Arial", "B", "11");
        //datos del trabajador
        $pdf->SetXY(15,$y);
        $pdf->Cell(20, 5, "RECIBIO:", 0, 0, "L");
        //NOMBRE COMPLETO 
        $pdf->SetFont("Arial", "", "10");
        $pdf->CellFitScale(120, 5, $xDatosE[0]["NOMENCLAT"]." ".$xDatosE[0]["NOMBRE"], "B", 0, "C");
        $pdf->Cell(16, 5, "FIRMA:", 0, 0, "L");
        $pdf->CellFitScale(32, 5, "", "B", 0, "C");
        
        $y+=8; 
        $pdf->SetY($y);
        $pdf->SetFont("Arial", "", "10");
        $pdf->MultiCell(189,4,"PARA CONFIRMAR SI LA CARTILLAS YA CULMINO SU PROCESO DE VERIFICACION LLAMAR EN UN PERIODO 75  DIAS.  LLAMAR AL AREA DE VALIDACION DOCUMENTAL  DE 9:00 A.M.  A 16:00 HRS DE LUNES A VIERNES. TEL. 01 (747) 47 1 92 0 1 EX.10514",0, "J");
        
    }
     $DatosE = $xInvDoc->getDatosCompEst();   
    if($DatosE[0]["DOC_RESGUARDO"] == 1){
    
        $y=$pdf->GetY();
        $y+=7;
        //ESTUDIO
        $pdf->Image($xPath."imgs/membrete_nvo.jpg", 10, $y, 195, 30);   
        $pdf->SetFont("Arial", "B", "9");
        $y+=3.5;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "SECRETARIADO EJECUTIVO DEL CONSEJO ESTATAL", 0, 0, "C");
        $y+=4;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "DE SEGURIDAD PÚBLICA", 0, 0, "C");
        $y+=4;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "DIRECCIÓN DEL CENTRO ESTATAL DE EVALUACIÓN", 0, 0, "C");
        $y+=4;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO", 0, 0, "C");
        $y+=6;
        
        $pdf->SetFont("Arial", "U", "10");
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "ÁREA DE INVESTIGACIÓN DOCUMENTAL", 0, 0, "C");
        
        $y+=6;
        $pdf->SetFont("Arial", "BU", "10");
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "RECIBO DE  COMPROBANTE DE ESTUDIO", 0, 0, "C");
        
        $y+=8;
        $pdf->SetFont("Arial", "B", "11");
        //datos del trabajador
        $pdf->SetXY(15,$y);
        $pdf->Cell(20, 5, "NOMBRE:", 0, 0, "L");
        //NOMBRE COMPLETO 
        $pdf->SetFont("Arial", "", "11");
        $pdf->CellFitScale(120, 5, $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE, "B", 0, "C");
        $pdf->Cell(16, 5, "FECHA:", 0, 0, "L");
        $pdf->CellFitScale(32, 5,$xSys->FormatoCorto(date('d-m-Y')), "B", 0, "C");
        
        $Nuevo          = ( $xEval->ID_TIPO_EVAL == 1 ) ? "52" :"0";
        $Permanencia    = ( $xEval->ID_TIPO_EVAL == 2 ) ? "52" :"0";
        $Promocion      = ( $xEval->ID_TIPO_EVAL == 3 ) ? "52" :"0";
        
        $y+=8;
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(25, 5, "Nuevo Ingreso", 0, 0, "L");
        $pdf->Ellipse(45,$y+2.5,4,2.5);
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Nuevo),0,0,"C");
        
        
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(95,$y);
        $pdf->Cell(23, 5, "Permanencia", 0, 0, "L");
        $pdf->Ellipse(123,$y+2.5,4,2.5);
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Permanencia),0,0,"C");
        
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(173,$y);
        $pdf->Cell(20, 5, "Promoción", 0, 0, "L");
        $pdf->Ellipse(198,$y+2.5,4,2.5);
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Promocion),0,0,"C");
        
        $pdf->SetFont("Arial", "B", "11");
        //OPTIENE LA POSICION DEL LA COORDENADA Y
        //$y=$pdf->GetY();
        $estatal      = ( $xPersona->CORPORACION== 1 ) ? "52" :"0";
        $municipal    = ( $xPersona->CORPORACION== 2 ) ? "52" :"0";
        $ipae         = ( $xPersona->CORPORACION== 3 ) ? "52" :"0";
        $pgje         = ( $xPersona->CORPORACION== 4 ) ? "52" :"0";
        $seg_priv     = ( $xPersona->CORPORACION== 5 ) ? "52" :"0";
        $cesp         = ( $xPersona->CORPORACION== 6 ) ? "52" :"0";
        
        //OPTIENE LA POSICION DEL LA COORDENADA Y
        //$y=$pdf->GetY();
        $y+=5;
        $pdf->SetXY(15,$y);
        $pdf->Cell(25, 5, "Corporación:", 0, 0, "L");
        //--------------------------------------------
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "POLICIA ESTATAL..................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($estatal),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "POLICIA MUNICIPAL...",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($municipal),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "I.P.A.E......................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($ipae),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(      )",0, 0, "L");
        
        
        //DERECHA
        $y-=10;
        
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "P.G.J.E..................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($pgje),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "SEGURIDAD PRIVADA..............................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($seg_priv),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(15, 5, "C.E.S.P..........................................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($cesp),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        //--------------------------------------------
        
        $y+=6;
        $pdf->SetFont("Arial", "B", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(45, 5, "DOCUMENTACION EN RESGUARDO:",0, 0, "L");
        //IZQUIERDA
        //COMPROBANTE DE ESTUDIOS
        
        $Cprimaria          = ( $DatosE[0]["DOC_VALIDAR"]== 1 ) ? "52" :"0";
        $Csecundaria        = ( $DatosE[0]["DOC_VALIDAR"]== 2 ) ? "52" :"0";
        $Cbachillerato      = ( $DatosE[0]["DOC_VALIDAR"]== 3 ) ? "52" :"0";
        $Clicenciatura      = ( $DatosE[0]["DOC_VALIDAR"]== 4 ) ? "52" :"0";
        
        
        $y+=6;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(45, 5, "CERTIFICADO",0, 0, "L");
        
        $y+=8;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "PRIMARIA................................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Cprimaria),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "SECUNDARIA.........................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Csecundaria),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "BACHILLERATO......................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Cbachillerato),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(15,$y);
        $pdf->Cell(65, 5, "LICENCIATURA.......................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Clicenciatura),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(80,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        
        
        //DERECHA
        
        $y-=23;
        
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(20, 5, "PROFESIONAL",0, 0, "L");
        
        $Titulo             = ( $DatosE[0]["DOC_VALIDAR"]== 5 ) ? "52" :"0";
        $Cedula             = ( $DatosE[0]["DOC_VALIDAR"]== 6 ) ? "52" :"0";
        $Otros              = ( $DatosE[0]["DOC_VALIDAR"]== 7 ) ? "52" :"0";
        
        $y+=8;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "TITULO.................................................................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Titulo),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(93, 5, "CEDULA................................................................................",0, 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Cedula),0,0,"C");
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        $y+=5;
        $pdf->SetFont("Arial", "", "10");
        $pdf->SetXY(100,$y);
        $pdf->Cell(15, 5, "OTROS",0, 0, "L");
        //RESPUESTA
        $pdf->CellFitScale(78, 5, $DatosE[0]["OTRO_DOC"],"B", 0, "L");
        $pdf->SetFont("ZapfDingbats","","10");
        //RESPUESTA
        $pdf->Cell(10,5,chr($Otros),0,0,"C");
        $pdf->SetFont("Arial", "", "11");
        $pdf->SetXY(193,$y);
        $pdf->Cell(10, 5, "(     )",0, 0, "L");
        
        
        $y+=13;
        $pdf->SetXY(15,$y);
        $pdf->Cell(60, 5, "DOCUMENTO EXPEDIDO POR:",0, 0, "L");
        $pdf->CellFitScale(128, 5, $DatosE[0]["DATOS_INST"],"B", 0, "L");
        $xInvDoc->getDatosGenerales();
        $xDatosE = $xInvDoc->getDatEvaluador($DatosE[0]["CURP_EVALUADOR"]);
        
        $y+=10;
        $pdf->SetFont("Arial", "B", "11");
        //datos del trabajador
        $pdf->SetXY(15,$y);
        $pdf->Cell(20, 5, "RECIBIO:", 0, 0, "L");
        //NOMBRE COMPLETO 
        $pdf->SetFont("Arial", "", "10");
        $pdf->CellFitScale(120, 5, $xDatosE[0]["NOMENCLAT"]." ".$xDatosE[0]["NOMBRE"], "B", 0, "C");
        $pdf->Cell(16, 5, "FIRMA:", 0, 0, "L");
        $pdf->CellFitScale(32, 5, "", "B", 0, "C");
        
        $y+=8; 
        $pdf->SetY($y);
        $pdf->SetFont("Arial", "", "10");
        $pdf->MultiCell(189,4,"SU COMPROBANTE DE ESTUDIOS SE LE ENTREGARA EN UN PERIODO APROXIMADO DE 75  DIAS. DUDAS LLAMAR AL AREA DE VALIDACION DOCMENTAL A PARTIR DE 9:00 A.M.  A 16:00 HRS DE LUNES A VIERNES TEL. OFICNA: 01 747 47 1 92 01 EXTENSION: 10514 Ó 10524",0, "J");
    
    }
    $pdf->Output("for_inv_doc.pdf", "I");

?>