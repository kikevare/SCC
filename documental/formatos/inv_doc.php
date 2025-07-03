<?php
 session_start();
    //-------------------------------------------------------------//
    $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
    for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
    //-------------------------------------------------------------//
    include_once($xPath."includes/xsystem.php");
    include_once($xPath."includes/persona.class.php");
    include_once($xPath."includes/invDocumental.class.php");
    include_once($xPath."includes/html/mpdf.php");
    
    $xSys = New System();   
    $pdf = New mPDF('c','A4','','',15,10,15,15,10,15); 
    $pdf->SetAutoPageBreak(false);
    $pdf->SetMargins(15, 10, 15);
    
    $xPersona = New Persona( $_SESSION["xCurp"] );
    //$xEval= New Evaluaciones( $_SESSION["xCurp"] );
    $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
    
     
      
    $pdf->AddPage();
    $pdf->SetMargins(15, 10, 15);
    $pdf->Image($xPath."imgs/membrete_nvo.jpg", 10, 8, 195, 30,false,false,true,false);
    $pdf->SetFont("Arial", "B", "9");
    $pdf->SetY(12);
    $pdf->Cell(0, 5, "SECRETARIADO EJECUTIVO DEL SISTEMA ESTATAL", 0, 0, "C");
    $pdf->SetY(16);
    $pdf->Cell(0, 5, "DE SEGURIDAD PUBLICA", 0, 0, "C");
    $pdf->SetY(20);
    $pdf->Cell(0, 5, "DIRECCION DEL CENTRO ESTATAL DE EVALUACION", 0, 0, "C");
    $pdf->SetY(24);
    $pdf->Cell(0, 5, "Y CONTROL DE CONFIANZA DEL ESTADO DE GUERRERO", 0, 0, "C");
    
    $pdf->SetFont("Arial", "B", "11");
    $y=40;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "INFORME DE VALIDACION", 0, 0, "C");
    $pdf->SetFillColor(200,215,255);
    
    $y+=10;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "", "B", 0, "C");
    
    $y+=8;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "DATOS GENERALES", 0, 0, "C",true);
    $y+=5;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "DEL EVALUADO", 0, 0, "C",true);
    
    $pdf->SetFont("Arial", "BU", "11");
    $y+=10;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "NOMBRE:", 0, 0, "L");
    $pdf->SetFont("Arial", "", "11");
    $pdf->Cell(120, 5, $xPersona->APATERNO." ".$xPersona->AMATERNO." ".$xPersona->NOMBRE, 0, 0, "L");
    $last_eval = $xInvDoc->getLastEval($xPersona->CURP);
    
    $pdf->SetFont("Arial", "B", "11");
    $pdf->Cell(15, 5, " ", 0, 0, "L");
    $xInvDoc->getDatosGenerales();
    $fecha = $xSys->FormatoCorto( date("d-m-Y", strtotime( $xInvDoc->FECHA_RECEPCION ) ) );
    $pdf->SetFont("Arial", "", "11");
    $pdf->Cell(30, 5, $fecha, 0, 0, "R");
 

    $pdf->SetFont("Arial", "BU", "11");
    $y+=8;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "CURP:", 0, 0, "L");
    $pdf->SetFont("Arial", "", "11");
    $pdf->Cell(161, 5, $xPersona->CURP, 0, 0, "L");
    
    $pdf->SetFont("Arial", "BU", "11");
    $y+=8;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "ESTATUS:", 0, 0, "L");
    $pdf->SetFont("Arial", "", "10");
    $pdf->Cell(161, 5,$xInvDoc->TIPO_EVAL, 0, 0, "L");
    
    
    
    $pdf->SetFont("Arial", "BU", "10");
    $y+=8;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "PUESTO:", 0, 0, "L");
    $pdf->SetFont("Arial", "", "10");
    $pdf->Cell(161, 5, $xPersona->getCategoria(), 0, 0, "L");
    
    if($xPersona->CORPORACION == 2 || $xPersona->CORPORACION == 10 || $xPersona->CORPORACION == 12){
        
        $muni =", ". $xPersona->getMunicipio($xPersona->MPIOADSCRIP);
    }
        
    $pdf->SetFont("Arial", "BU", "10");
    $y+=8;
    $pdf->SetXY(15,$y);
    $pdf->Cell(25, 5, "ADSCRITO:", 0, 0, "L");
    $pdf->SetFont("Arial", "", "11");
    $pdf->Cell(161, 5, $xPersona->getCorporacion()." ".$muni, 0, 0, "L");
    
    $pdf->SetFont("Arial", "B", "11");
    $y+=10;
    $pdf->SetY($y);
    $pdf->Cell(0, 8, "RESULTADO", 0, 0, "C",true);
    
    $Datos = $xInvDoc->getDatosCompEst();
    
    $pdf->SetFont("Arial", "", "11");
    $y+=10;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, "DOCUMENTO VERIFICADO", 0, 0, "C");
    
    $docId=$Datos[0]["DOC_VALIDAR"];
    
    if($docId == 1) $doc="CERTIFICADO PRIMARIA";
    elseif($docId == 2) $doc="CERTIFICADO SECUNDARIA";
    elseif($docId == 3) $doc="CERTIFICADO BACHILLERATO";
    elseif($docId == 4) $doc="CERTIFICADO LICENCIATURA";
    elseif($docId == 5) $doc="TITULO PROFESIONAL";
    elseif($docId == 6) $doc="CEDULA PROFESIONAL";
    elseif($docId == 7) $doc=$Datos[0]["OTRO_DOC"];
    elseif($docId == 8) $doc="SIN ESCOLARIDAD";
    elseif($docId == 9) $doc="NO PRESENTO DOCUMENTO";
    elseif($docId == 10) $doc="COMPROBANTE DE ESTUDIOS";
    elseif($docId == 11) $doc="GRADO MAESTRIA";
    elseif($docId == 12) $doc="MAESTRIA";
    elseif($docId == 13) $doc="KARDEX";
    $pdf->SetFont("Arial", "BU", "11");
    $y+=7;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, $doc, 0, 0, "C");
    
    $pdf->SetTextColor(255,0,0);
    $pdf->SetFont("Arial", "BU", "12");
    
    $resId=$Datos[0]["RESULTADO_COMP_EST"];
    
    /*if($resId == 1) $res="AUT�NTICO";
    elseif($resId == 2) $res="CARENTE DE VALIDEZ";
    elseif($resId == 3) $res="EN PROCESO";*/
    $result_ofi =$Datos[0]["RESULT_OFI"];
    $y+=9;
    $pdf->SetY($y);
    $pdf->Cell(0, 5, $result_ofi, 0, 0, "C");
    
    $pdf->SetFont("Arial", "B", "11");
    $pdf->SetTextColor(0,0,0);
    $y+=5;
    $pdf->SetY($y);
    $pdf->MultiCell(0, 8, "ANTECEDENTE DEL RESULTADO", 0,  "C",true);
    
    
    $html=$Datos[0]["ANTECEDENTES"];
    $pdf->SetFont("Arial", "", "11");
    $y+=10;
    $pdf->SetMargins(15,15);
    $pdf->SetY($y);
    //$pdf->SetFont("Arial", "", "11");
    $mpdf->jSWord = 0;
    $mpdf->jSmaxChar = 0;
    $pdf->WriteHTML($html);
    
    $mpdf->jSWord = 0;
    $mpdf->jSmaxChar = 0;
    $pdf->SetFont("Arial", "", "10");
    //$y=$pdf->Get;
    $xDatosE = $xInvDoc->getDatEvaluador($Datos[0]["CURP_EVALUADOR"]);
    
    $xDatosT = $xInvDoc->getTitularArea(8);
    //$xDatosE = $xInvDoc->getDatEvaluador($xInvDoc->CURP_EVAL);
    $y+=80;
    if( $Datos[0]["CURP_EVALUADOR"] != $xDatosT[0]["CURP"] ){
    
    
        $pdf->SetXY(15,$y);
/*         $pdf->Cell(85, 5, "ELABORO:", 0, 0, "C");
 */        
        
        
        $y+=30;
        $pdf->SetXY(65,$y);
        $pdf->Cell(85, 5, "", "B", 0, "C");
        
        
        $y+=5;
        $pdf->SetXY(65,$y);
         $pdf->Cell(85, 5,$xDatosE[0]["NOMENCLAT"]." ".$xDatosE[0]["NOMBRE"], 0, 0, "C");
       
        $y+=5;
        $pdf->SetXY(65,$y);
        $pdf->Cell(85, 5, "INVESTIGADOR DOCUMENTAL", 0, 0, "C");
        
/*         $y-=45;
        
        $pdf->SetFont("Arial", "", "10");
        $y+=15;
        $pdf->SetXY(113,$y);
        $pdf->Cell(85, 5, "SUPERVISO:", 0, 0, "C");
        
        
        $y+=20;
        $pdf->SetXY(113,$y);
        $pdf->Cell(85, 5, "", "B", 0, "C");
        
        $y+=5;
        $pdf->SetXY(113,$y);
        $pdf->Cell(85, 5,"LIC. KARINA BAUTISTA GARCIA", 0, 0, "C");
        
        $y+=5;
        $pdf->SetXY(113,$y);
        $pdf->Cell(85, 5, "RESPONSABLE DEL AREA DOCUMENTAL", 0, 0, "C"); */
    }
    else{
      /*   $pdf->SetY($y);
        $pdf->Cell(0, 5, "ELABORO:", 0, 0, "C");
        
        $y+=20;
        $pdf->SetXY(69,$y);
        $pdf->Cell(71, 5, "", "B", 0, "C");
        
        $y+=5;
        $pdf->SetY($y);
        $pdf->Cell(0, 5,"LIC. KARINA BAUTISTA GARCIA", 0, 0, "C");
        
        $y+=5;
        $pdf->SetY($y);
        $pdf->Cell(0, 5, "RESPONSABLE DEL AREA DOCUMENTAL", 0, 0, "C"); */
    }
    
    
    $pdf->Output();
?>