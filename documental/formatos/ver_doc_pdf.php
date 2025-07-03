<?php
 session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   include_once($xPath.'includes/fpdf16/pdf.php');
    //require('../../../../includes/fpdf16/pdf.php');

    $pdf = New PDF('P','mm','Letter');        
   
    //encabezado del documento
    $pdf->SetMargins(15,10,10);
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", "10");
    
    $Fx = $_GET["fx"];    
    $imagen_doc = $xPath."Archivo/DeptoESocial/invdoc/Expedientes/".$_SESSION["xCurp"]."/".$_SESSION["xCurp"]."_" . $Fx . ".jpg";
    
    $pdf->Image($imagen_doc, 1, 1, 214, 278);
    $pdf->Cell(40, 20, "HOLA", 0, 0, "C");


    $pdf->Output("cartilla.pdf", "I");

?>