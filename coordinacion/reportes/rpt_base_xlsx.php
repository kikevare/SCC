<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - 2;
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");   
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/invSocioEconomica.class.php");
   include_once($xPath."includes/invDocumental.class.php");
   include_once($xPath."includes/entsocial.class.php");
   $xSys = New System();
   $xUsr = New Usuario();     
        
   //----- Recepcion de parámetros de ordenación y búsqueda -------//
   $xInicio = 0;
   $contador = 0;
   //-----------------------------------------------------------------//
   
   header("Content-type: application/vnd.ms-excel"); 
   header("Content-Disposition: attachment; filename=Reporte_base_xlsx" . date("Y-m-d") . ".xls");
   ?> 

   <table style="border-bottom: 1px solid #cccccc;">         
      <thead>
         <tr>
            <td colspan="15" style="text-align: center; font-weight: bold; font-size: 14pt;">CENTRO ESTATAL DE EVALUACION Y CONTROL DE CONFIANZA</td>
         </tr>
         <tr>
            <td colspan="15" style="text-align: center; font-weight: bold; font-size: 12pt;">DEPARTAMENTO DE ENTORNO SOCIAL --> COORDINACIÓN</td>
         </tr>
         <tr>
            <td colspan="15" style="text-align: center; font-weight: bold; font-size: 12pt;">REPORTE BASE DEL SICE</td>
         </tr>
         <tr>
                 
            <th style="border: 1px solid #cccccc; font-size: 15pt;">N/P</th>       
            <th style="border: 1px solid #cccccc; font-size: 15pt;">NOMBRE DEL EVALUADO</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">CATEGORIA</th>
            <!--<th style="border: 1px solid #cccccc; font-size: 15pt;">FIRMA DEL EVALUADO</th> <!-- NO PRESENTE EN BD-->
            <th style="border: 1px solid #cccccc; font-size: 15pt;">TIPO DE EVALUACI&Oacute;N</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">ADSCRIPCI&oacute;N</th> 
            <th style="border: 1px solid #cccccc; font-size: 15pt;">MUNICIPIO</th> 
            <th style="border: 1px solid #cccccc; font-size: 15pt;">FECHA DE EVALUACI&oacute;N</th>  
            <th style="border: 1px solid #cccccc; font-size: 15pt;">RESULTADO</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">CRITERIOS ESPECIFICOS</th> <!-- NO PRESENTE EN BD-->
            <th style="border: 1px solid #cccccc; font-size: 15pt;">OBSERVACIONES</th> <!-- NO PRESENTE EN BD-->
            <th style="border: 1px solid #cccccc; font-size: 15pt;">EVALUADOR</th> 
            <th style="border: 1px solid #cccccc; font-size: 15pt;">SUPERVISOR</th>  
            
                       
            <!--<th style="border: 1px solid #cccccc; font-size: 15pt;">FIRMA DE EXPEDIENTE RECIBIDO</th>  <!-- NO PRESENTE EN BD-->           
            <th style="border: 1px solid #cccccc; font-size: 15pt;">CONTEO MENSUAL DE EVALUADOS</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">CUB&iacute;CULO</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">TIPO DE INCIDENCIA</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">DETALLE DE INCIDENCIA</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">ANTECEDENTES</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">RESULTADO CARTILLA</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">TIPO DE DOCUMENTO</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">RESULTADO DE COMPROBANTE DE ESTUDIOS</th>
            <th style="border: 1px solid #cccccc; font-size: 15pt;">TIPO DE DOCUMENTO</th>
            <!--<th style="border: 1px solid #cccccc; font-size: 15pt;">RESULTADO ISE</th> -->
                                       
         </tr>
      </thead>         
      <tbody>  
        <tr>
            <td>&nbsp;</td>      
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td> 
            <td>&nbsp;</td> 
            <td>&nbsp;</td>
        </tr> 
         <?php
         $xRpt = New invSocioEconomica();
         $Datos = $xRpt->RptBaseCoordinacionISE();                           
                
         foreach( $Datos As $registro ){                                    
            $xRpt = New invSocioEconomica( $registro["CURP_EVALUADO"] );
            $xInvDoc = New invDocumental( $registro["CURP_EVALUADO"] );
            $xPersona = New Persona( $registro["CURP_EVALUADO"] );
            $xAnt = New EntSocial( $registro["CURP_EVALUADO"] );
            $DatosResISE = $xRpt->getDatosAnalisis();
            $DatosCart   =   $xInvDoc->getDatosCartilla();
            $DatosComp   =   $xInvDoc->getDatosCompEst();
            
            $DatEval        = $xRpt->getDatEvaluador( $registro["CURP_EVALUADOR"] );
            $DatosResPrevio = $xRpt->getDatosAnalisis();
            if( $DatosResPrevio[0]["FECHA_EVALUACION"] != "" ){
                $fecha_eval = $xSys->FormatoCorto( date("d-m-Y", strtotime( $DatosResPrevio[0]["FECHA_EVALUACION"] ) ) );
            } 
            $Resultado = $xRpt->getResultadoPrevio( $DatosResPrevio[0]["RESULTADO_PREVIO"] );
            if( empty($Resultado) ){
                $Resultado = "NO ESPECIFICADO";
            } 
            $DatSup         = $xRpt->getDatEvaluador( $DatosResPrevio[0]["CURP_SUPERVISOR"] );
            $res_antecedentes = $xAnt->ExistIdInvestAnteced() ? "SI" : "NO";
            $contador ++;
            echo"<tr>";
            //DATOS
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>" . $contador . "</td>";
            echo"<td align='left'   style='min-width: 90px;  border-left:   1px solid  #cccccc; border-bottom: 1px dotted #cccccc;'>". $xPersona->NOMBRE . " " . $xPersona->APATERNO . " " . $xPersona->AMATERNO ."</td>";                                         
            echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$xPersona->getCategoria($xPersona->CATEGORIA)."</td>";
            //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>&nbsp;</td>";
            echo"<td align='left'   style='min-width: 80px; border-bottom: 1px dotted #cccccc;'>" . $xRpt->TIPO_EVAL . "</td>";
            echo"<td align='center' style='min-width: 70px; border-bottom: 1px dotted #cccccc;'>".$xPersona->AREAADSCRIP."</td>";
            echo"<td align='center' style='min-width: 70px; border-bottom: 1px dotted #cccccc;'>".$xPersona->getMunicipio($xPersona->MPIOADSCRIP)."</td>";
            echo"<td align='center' style='min-width: 70px; border-bottom: 1px dotted #cccccc;'>".$fecha_eval."</td>";
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$Resultado ."</td>";
            echo"<td align='center' style='min-width: 70px;  border-bottom: 1px dotted #cccccc;'>&nbsp;</td>";
            echo"<td align='center' style='min-width: 70px;  border-bottom: 1px dotted #cccccc;'>&nbsp;</td>";
            echo"<td align='center' style='min-width: 70px;  border-bottom: 1px dotted #cccccc;'>".$DatEval[0]["NOMBRE"]."</td>";
            echo"<td align='center' style='min-width: 70px;  border-bottom: 1px dotted #cccccc;'>".$DatSup[0]["NOMBRE"]."</td>";
            
            
            //echo"<td align='center' style='min-width: 70px;  border-bottom: 1px dotted #cccccc;'>&nbsp;</td>";
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["TOTAL_MES"]."</td>";
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["CUBICULO"] ."</td>";
            //INCIDENCIAS
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["TIPO_INCIDENCIA"]."</td>";
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["INCIDENCIA_DETALLES"]."</td>";
            //ANTECEDENTES
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$res_antecedentes."</td>";
            //VALIDACION DOCUMENTAL    
            //CARTILLA   
            
            $res_cartilla = empty( $DatosCart[0]["RESULTADO_CARTILLA"] ) ? "NO ESPECIFICADO" : $xInvDoc->getResultado( $DatosCart[0]["RESULTADO_CARTILLA"] );
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>" . $res_cartilla . "</td>";
            $res_docval = empty( $DatosCart[0]["DOC_VALIDAR"] ) ? "NO ESPECIFICADO" : $xInvDoc->getTipoDocumentoValidar( $DatosCart[0]["DOC_VALIDAR"], 1 );       
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>" . $res_docval . "</td>";
            
            
            //COMPROBANTE DE ESTUDIOS
            $res_comprobante = empty( $DatosComp[0]["RESULTADO_COMP_EST"] ) ? "NO ESPECIFICADO" : $xInvDoc->getResultado( $DatosComp[0]["RESULTADO_COMP_EST"] );
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>" . $res_comprobante . "</td>";
            $res_compest = empty( $DatosComp[0]["DOC_VALIDAR"] ) ? "NO ESPECIFICADO" : $xInvDoc->getTipoDocumentoValidar( $DatosComp[0]["DOC_VALIDAR"], 2 );   
            echo"<td align='center' style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>" . $res_compest . "</td>";
            
            //RESULTADO ISE
            //$res_ise = empty( $DatosResISE[0]["RESULTADO_PREVIO"] ) ? "NO ESPECIFICADO" : "SI"; 
            //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>". $res_ise ."</td>";                                                                                                                                                                              
               
            echo"</tr>"; 
         }
         $xTotal = count($Datos);
         if( $xTotal <= 0 ){
            echo"<tr style='background: none;'>
                  <td colspan='15' align='center'>
                     <div style='font-family: sans-serif; font-weight: normal; font-size: 8pt; color: #ff0000;'>
                        No existen datos...
                     </div>                     
                  </td>
               </tr>";
         }   
         ?>   
      </tbody>
   </table>   
<?php
}
else
   header("Location: ".$xPath."exit.php"); 
?>