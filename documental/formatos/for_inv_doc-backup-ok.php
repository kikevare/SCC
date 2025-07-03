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
       
    $y=35;
    $palomita=52;
                                            // inicio  costado,inicio arriba, termina costado, ancho 
    //$pdf->Image("../../../../imgs/membrete_nvo.jpg", 10, 8, 195, 30);
    $pdf->Image($xPath."imgs/membrete_nvo.jpg",10, 8, 195, 30);     
    $pdf->SetFont("Arial", "B", "9");
    $pdf->SetY(12);
    $pdf->Cell(0, 5, "SECRETARIADO EJECUTIVO DEL CONSEJO ESTATAL", 0, 0, "C");
    $pdf->SetY(16);
    $pdf->Cell(0, 5, "DE SEGURIDAD PÚBLICA", 0, 0, "C");
    $pdf->SetY(20);
    $pdf->Cell(0, 5, "DIRECCIÓN DEL CENTRO ESTATAL DE EVALUACIÓN", 0, 0, "C");
    $pdf->SetY(24);
    $pdf->Cell(0, 5, "Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO", 0, 0, "C");
    
    $pdf->SetFont("Arial", "BU", "10");
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "DEPARTAMENTO DE INVESTIGACIÓN SOCIOECONÓMICA", 0, 0, "C");
    
    $y+=10;
    $pdf->SetFont("Arial", "B", "11");
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "ÁREA DE INVESTIGACIÓN DOCUMENTAL", 0, 0, "C");
    
    $Nuevo          = ( $xEval->ID_TIPO_EVAL == 1 ) ? "52" :"0";
    $Permanencia    = ( $xEval->ID_TIPO_EVAL == 2 ) ? "52" :"0";
    $Promocion      = ( $xEval->ID_TIPO_EVAL == 3 ) ? "52" :"0";
    
    $y+=10;
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
    $y+=8;
    
    //datos del trabajador
    $pdf->SetXY(15,$y);
    $pdf->Cell(43, 5, "Nombre del evaluado:", 0, 0, "L");
    //NOMBRE COMPLETO 
    $pdf->SetFont("Arial", "", "11");
    $pdf->CellFitScale(112, 5, $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE, "B", 0, "C");
    $pdf->SetXY(170,$y);
    $pdf->Cell(12, 5, "Edad", 0, 0, "L");
    $pdf->SetXY(181,$y);
    //RESPUESTA
    $pdf->Cell(22, 5,$xPersona->EDAD." años","B", 1, "C");   
     
       
    //OPTIENE LA POSICION DEL LA COORDENADA Y
    //$y=$pdf->GetY();
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "Corporación:", 0, 0, "L");
    //RESPUESTA
    $pdf->Cell(163, 5, $xPersona->getCorporacion(), "B", 0, "C");
    
    if($xPersona->CORPORACION == 2){
        
        $muni =",". $xPersona->getMunicipio($xPersona->MPIOADSCRIP);
    }
    
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->Cell(20, 5, "Categoría:",0, 0, "L");
    //RESPUESTA
    $pdf->CellFitScale(70, 5, $xPersona->getCategoria(), "B", 0, "C");
    $pdf->Cell(40, 5, "Unidad de Adscripción",0, 0, "L");
    //RESPUESTA
    $pdf->CellFitScale(58, 5,$xPersona->AREAADSCRIP." ".$muni, "B", 0, "C");
    
    $xfecha = explode("-", $xInvDoc->FECHA_RECEPCION);
    
    
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->Cell(75, 5, "Fecha de recepción en el área documental",0, 0, "L");
    //RESPUESTA
    $pdf->Cell(6, 5, $xfecha[2],"B", 0, "L");
    $pdf->Cell(2, 5, "/",0, 0, "C");
    $pdf->Cell(6, 5, $xfecha[1],"B", 0, "L");
    $pdf->Cell(2, 5, "/",0, 0, "C");
    $pdf->Cell(10, 5, $xfecha[0],"B", 0, "L");
    
    $DatosEval	= $xInvDoc->getDatEvaluador($xInvDoc->CURP_EVAL);
    $xEvaluador	= $DatosEval[0]["NOMBRE"];
    
    $pdf->SetXY(117,$y);
    $pdf->Cell(15, 5, "Recibió",0, 0, "L");
    $pdf->CellFitScale(71, 5, $xEvaluador,"B", 0, "L");
    
    
    //IZQUIERDA
    
    $y+=8;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "PRESENTÓ:",0, 0, "L");
    
    $y+=8;
    $pdf->SetFont("Arial", "B", "10");
    $pdf->SetXY(15,$y);
    $pdf->Cell(45, 5, "CARTILLA DEL S.M.N.",0, 0, "L");
    
    $DatosC = $xInvDoc->getDatosCartilla();
    $observCar = $DatosC[0]["OBSERVACIONES"];
    $catillaNL      = ( $DatosC[0]["DOC_VALIDAR"]== 1 ) ? "52" :"0";
    $catillaYHL     = ( $DatosC[0]["DOC_VALIDAR"]== 2 ) ? "52" :"0";
    $catillaC       = ( $DatosC[0]["DOC_VALIDAR"]== 3 ) ? "52" :"0";
    $catillaYHE     = ( $DatosC[0]["DOC_VALIDAR"]== 4 ) ? "52" :"0";
    $catillaOE      = ( $DatosC[0]["DOC_VALIDAR"]== 5 ) ? "52" :"0";
    $Otro           = ( $DatosC[0]["DOC_VALIDAR"]== 6 ) ? "52" :"0";
    
    $y+=8;
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
    $OriginalCS      = ( $DatosC[0]["PRE_ORIGINAL"]== 1 ) ? "52" :"0" ;
    $OriginalCN      = ( $DatosC[0]["PRE_ORIGINAL"]== 2 ) ? "52" :"0" ;
    
    
    $y-=18;
    $pdf->SetFont("Arial", "B", "10");
    $pdf->SetXY(100,$y);
    $pdf->Cell(20, 5, "ORIGINAL",0, 0, "L");
    $pdf->Cell(6, 5, "SI",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    $pdf->Cell(3, 5, "",0, 0, "L");
    $pdf->Cell(7, 5, "NO",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    
    //RESPUESTA COPIA SI
    $pdf->SetXY(127,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(6,5,chr($OriginalCS),0,0,"C");
    //RESPUESTA COPIA NO
    $pdf->SetXY(143,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(10,5,chr($OriginalCN),0,0,"C");
   
    $CopiaCS         = ( $DatosC[0]["PRE_COPIA"]== 1 ) ? "52" :"0" ;
    $CopiaCN         = ( $DatosC[0]["PRE_COPIA"]== 2 ) ? "52" :"0" ;
   
    $pdf->SetFont("Arial", "B", "10");
    $pdf->SetXY(155,$y);
    $pdf->Cell(15, 5, "COPIA",0, 0, "L");
    $pdf->Cell(6, 5, "SI",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    $pdf->Cell(3, 5, "",0, 0, "L");
    $pdf->Cell(7, 5, "NO",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    
    //RESPUESTA COPIA SI
    $pdf->SetXY(177,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(6,5,chr($CopiaCS),0,0,"C");
    //RESPUESTA COPIA NO
    $pdf->SetXY(193,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(10,5,chr($CopiaCN),0,0,"C");
    
    
    $y+=8;
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
    $pdf->CellFitScale(78, 5, $DatosC[0]["OTRO_DOC"],"B", 0, "L");
    $pdf->SetFont("ZapfDingbats","","10");
    //RESPUESTA
    $pdf->Cell(10,5,chr($Otro),0,0,"C");
    $pdf->SetFont("Arial", "", "11");
    $pdf->SetXY(193,$y);
    $pdf->Cell(10, 5, "(     )",0, 0, "L");
    
    //IZQUIERDA
    //COMPROBANTE DE ESTUDIOS
    $y+=8;
    $pdf->SetFont("Arial", "B", "10");
    $pdf->SetXY(15,$y);
    $pdf->Cell(45, 5, "COMPROBANTE DE ESTUDIO",0, 0, "L");
    
    $DatosE = $xInvDoc->getDatosCompEst();
    $observEst = $DatosE[0]["OBSERVACIONES"];
    
    $Cprimaria          = ( $DatosE[0]["DOC_VALIDAR"]== 1 ) ? "52" :"0";
    $Csecundaria        = ( $DatosE[0]["DOC_VALIDAR"]== 2 ) ? "52" :"0";
    $Cbachillerato      = ( $DatosE[0]["DOC_VALIDAR"]== 3 ) ? "52" :"0";
    $Clicenciatura      = ( $DatosE[0]["DOC_VALIDAR"]== 4 ) ? "52" :"0";
    
    
    $y+=8;
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
    
    $y-=31;
    $pdf->SetFont("Arial", "B", "10");
    $pdf->SetXY(100,$y);
    $pdf->Cell(20, 5, "ORIGINAL",0, 0, "L");
    $pdf->Cell(6, 5, "SI",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    $pdf->Cell(3, 5, "",0, 0, "L");
    $pdf->Cell(7, 5, "NO",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    
    $OriginalCES      = ( $DatosE[0]["PRE_ORIGINAL"]== 1 ) ? "52" :"0" ;
    $OriginalCEN      = ( $DatosE[0]["PRE_ORIGINAL"]== 2 ) ? "52" :"0" ;
    
    //RESPUESTA COPIA SI
    $pdf->SetXY(127,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(6,5,chr($OriginalCES),0,0,"C");
    //RESPUESTA COPIA NO
    $pdf->SetXY(143,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(10,5,chr($OriginalCEN),0,0,"C");
   
   
   
    $pdf->SetFont("Arial", "B", "10");
    $pdf->SetXY(155,$y);
    $pdf->Cell(15, 5, "COPIA",0, 0, "L");
    $pdf->Cell(6, 5, "SI",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    $pdf->Cell(3, 5, "",0, 0, "L");
    $pdf->Cell(7, 5, "NO",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    
    $CopiaCES         = ( $DatosE[0]["PRE_COPIA"]== 1 ) ? "52" :"0" ;
    $CopiaCEN         = ( $DatosE[0]["PRE_COPIA"]== 2 ) ? "52" :"0" ;
    
    //RESPUESTA COPIA SI
    $pdf->SetXY(177,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(6,5,chr($CopiaCES),0,0,"C");
    //RESPUESTA COPIA NO
    $pdf->SetXY(193,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(10,5,chr($CopiaCEN),0,0,"C");
    
    $y+=8;
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
    
    /*
    $y+=8;
    $pdf->SetFont("Arial", "B", "11");
    $pdf->SetXY(15,$y);
    $pdf->Cell(40, 5, "CURP.........................",0, 0, "L");
    
    $CopiaCurpS        = ( $xInvDoc->COPIA_CURP == 1 ) ? "52" :"0" ;
    $CopiaCurpN         = ( $xInvDoc->COPIA_CURP == 2 ) ? "52" :"0" ;
    
    $pdf->Cell(15, 5, "COPIA",0, 0, "L");
    $pdf->Cell(6, 5, "SI",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    $pdf->Cell(3, 5, "",0, 0, "L");
    $pdf->Cell(7, 5, "NO",0, 0, "L");
    $pdf->Cell(8, 5, "(     )",0, 0, "C");
    
    //RESPUESTA COPIA SI
    $pdf->SetXY(77,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(6,5,chr($CopiaCurpS),0,0,"C");
    //RESPUESTA COPIA NO
    $pdf->SetXY(93,$y);
    $pdf->SetFont("ZapfDingbats","","10");
    $pdf->Cell(10,5,chr($CopiaCurpN),0,0,"C");*/
    
    $y+=8;
    $pdf->SetFont("Arial", "B", "11");
    $pdf->SetXY(15,$y);
    $pdf->Cell(15, 5, "CURP:",0, 0, "L");
    $pdf->SetFont("Arial", "", "11");
    $pdf->Cell(35, 5, $xPersona->CURP,0, 0, "L");
    
    $y+=8;
    $pdf->SetFont("Arial", "", "11");
    $pdf->SetXY(15,$y);
    $pdf->Cell(34, 5, "N°. DE CELULAR:",0, 0, "L");
    //RESPUESTA
    $pdf->Cell(65, 5, $xPersona->TELMOVIL,"B", 0, "L");
    $pdf->Cell(23, 5, "TEL. CASA:",0, 0, "L");
    //RESPUESTA
    $pdf->Cell(66, 5, $xPersona->TELFIJO,"B", 0, "L");
    
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->Cell(38, 5, "TEL. DE RECADOS:",0, 0, "L");
    //RESPUESTA
    $pdf->Cell(40, 5, $xInvDoc->TEL_RECADOS,"B", 0, "L");
    $pdf->Cell(56, 5, "NOMBRE DEL PROPIETARIO:",0, 0, "L");
    //RESPUESTA
    $pdf->CellFitScale(54, 5,$xInvDoc->RESP_TEL_RECADOS,"B", 0, "L");
    
    
    if(!empty($observCar)){
      $obseva = $observCar;
      if(!empty($observEst))
      $obseva .=", ".$observEst;
    }
    elseif(!empty($observEst)){
      $obseva =$observEst;
    }
    
    
    $y+=8;
    $pdf->SetXY(15,$y);
    $pdf->SetFont("Arial", "B", "11");
    $pdf->Cell(38, 5, "OBSERVACIONES:",0, 0, "L");
    
    
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->SetFont("Arial", "", "10");
    $pdf->MultiCell(188, 4,strip_tags($obseva),"B","J");
    $y=$pdf->GetY();
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->SetFont("Arial", "B", "10");
    $pdf->MultiCell(188, 4, "Fui enterado por los evaluadores de la documentación que tengo que entregar al área de investigación documental; la cual entrego y presento en original y copia para cotejar. También proporciono 3 números de teléfonos para ser localizado si así se requiriera en esta área, quedando de manifiesto que he sido enterado que MIS DOCUMENTOS  se mandaran a las instituciones correspondientes para realizar la autentificación de los mismos, estando consciente del resultado que esto derive. ",0,"J");
    
    $y=$pdf->GetY();
    $y+=12;
    $pdf->SetXY(15,$y);
    $pdf->Cell(62, 5, "",0, 0, "L");
    $pdf->CellFitScale(63, 5, $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE,"B", 0, "C");
    $pdf->Cell(62, 5, "",0, 0, "L");
    $y+=5;
    $pdf->SetXY(15,$y);
    $pdf->Cell(62, 5, "",0, 0, "L");
    $pdf->Cell(62, 5, "Nombre y firma del evaluado (a)",0, 0, "C");
    $pdf->Cell(62, 5, "",0, 0, "L");
    
    $pdf->Output("for_inv_doc.pdf", "I");

?>