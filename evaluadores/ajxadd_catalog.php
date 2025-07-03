<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include($xPath."includes/xsystem.php");
   include($xPath."includes/catalogos.class.php");
   $xSys = New System();
   $xCat = New Catalog();
   $xUsr = New Usuario();
   
   $id_cat     = $_POST["id_cat"];
   $nvo_valor  = $_POST["nvo_valor"];
   
   //--- Especialidad... 
   if( $id_cat == 1 ){
      $id_corp = $_POST["id_corp"];      
      if( $xCat->addEspecialidad($nvo_valor, $id_corp) ){
         $xSys->xLog($xUsr->xCveUsr, "ctespecialidad", $xCat->xLASTID, "Inserción");
         $xCat->shwEspecialidad($xCat->xLASTID, $id_corp);        
      }
      else
         echo "0";
   }
   //--- Categoria...
   else if( $id_cat == 2 ){     
      if( $xCat->addCategoria($nvo_valor) ){
         $xSys->xLog($xUsr->xCveUsr, "ctcategoria", $xCat->xLASTID, "Inserción");         
         $xCat->shwCategoria($xCat->xLASTID);         
      }
      else
         echo "0";
   }
   //--- Función de evaluación...
   else if( $id_cat == 3 ){     
      if( $xCat->addFuncionEval($nvo_valor) ){
         $xSys->xLog($xUsr->xCveUsr, "ctfuncionevaluacion", $xCat->xLASTID, "Inserción");         
         $xCat->shwFuncionEval($xCat->xLASTID);         
      }
      else
         echo "0";
   }
?>