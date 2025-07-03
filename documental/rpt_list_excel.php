<?php
session_start();
//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - 2;
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");   
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/invDocumental.class.php");
   $xSys = New System();
   $xUsr = New Usuario();  
   $xPersona = New Persona();
   $xInvDoc = New invDocumental();
        
   //----- Recepcion de par�metros de ordenaci�n y b�squeda -------//
   $xInicio = 0;
   //-- Inicializa los par�metros...
      $idOrdr      = 2;      
      $tipoOrdr    = "Asc";
      $txtBuscar   = "";
      $cmpBuscar   = 1;//TIPO DOCUMENTO
      $cmpBuscarf  = 1;//fecha recepcion
      $cmpBuscard  = 1;//fecha solicitud y respuesta
      $cmpBuscarS  = 0;//sexo
      $cmpBuscar2  = 0;//NIVEL ESTUDIO
      $cmpBuscar3  = 0; //DOCUMENTO ESTUDIO
      $cmpBuscar4  = 0; //ESCUELA
      $cmpBuscar5  = 0; //RESULTADO ESTUDIO
      $cmpBuscar6  = 0; //DOCUMENTO CARTILLA
      $cmpBuscar7  = 0; //DEPENDENCIA CARTILLA
      $cmpBuscar8  = 0; //RESULTADO CARTILLA
      
      //-- Revisa si se ha ejecutado una ordenaci�n...
      if( isset($_POST["id_ordenr"]) ){
         
         $idOrdr   = $_POST["id_ordenr"];         
         $tipoOrdr = $_POST["tp_ordenr"];
         //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
         $_SESSION["id_ordenr"] = $idOrdr;
         $_SESSION["tipo_ordenr"] = $tipoOrdr;
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos TIPO DOCUMENTO
      if( isset($_POST["cbCampor"])  ){
         $cmpBuscar = $_POST["cbCampor"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar"] = $cmpBuscar;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos SEXO...
      if( isset($_POST["cbCamporS"])  ){
         $cmpBuscarS = $_POST["cbCamporS"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscarS"] = $cmpBuscarS;             
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos FECHA RECEPCION
      if( isset($_POST["cbCamporf"])  ){
         $cmpBuscarf = $_POST["cbCamporf"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscarf"] = $cmpBuscarf;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos FECHAS SOLICITUD Y RESPUESTA
      if( isset($_POST["cbCampord"])  ){
         $cmpBuscard = $_POST["cbCampord"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscard"] = $cmpBuscard;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor2"])  ){
         $cmpBuscar2 = $_POST["cbCampor2"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar2"] = $cmpBuscar2;
                     
      }
      
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor3"])  ){
         $cmpBuscar3 = $_POST["cbCampor3"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar3"] = $cmpBuscar3;
                     
      }
      
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor4"])  ){
         $cmpBuscar4 = $_POST["cbCampor4"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar4"] = $cmpBuscar4;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["cbCampor5"])  ){
         $cmpBuscar5 = $_POST["cbCampor5"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar5"] = $cmpBuscar5;
                     
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos
      if( isset($_POST["cbCampor6"])  ){
         $cmpBuscar6 = $_POST["cbCampor6"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar6"] = $cmpBuscar6;
                     
      }
      
      //-- Revisa si se ha ejecutado una b�squeda por campos
      if( isset($_POST["cbCampor7"])  ){
         $cmpBuscar7 = $_POST["cbCampor7"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar7"] = $cmpBuscar7;          
      }
       //-- Revisa si se ha ejecutado una b�squeda por campos
      if( isset($_POST["cbCampor8"])  ){
         $cmpBuscar8 = $_POST["cbCampor8"];
                    
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["cmp_buscar8"] = $cmpBuscar8;          
      }
      //-- Revisa si se ha ejecutado una b�squeda por campos...
      if( isset($_POST["txtBuscar"]) && !empty($_POST["txtBuscar"]) ){
         //$cmpBuscar3 = $_POST["cbCampor3"];
         $txtBuscar = $_POST["txtBuscar"];            
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         //$_SESSION["cmp_buscar3"] = $cmpBuscar3;
         $_SESSION["txt_buscar"] = $txtBuscar;            
      }
      //-- Revisa si se ha ejecutado una b�squeda por fecha...
      if( isset($_POST["txtFecha1"]) && !empty($_POST["txtFecha1"]) ){         
         $txtFecha1 = $xSys->ConvertirFecha($_POST["txtFecha1"], "yyyy-mm-dd");
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["txt_fecha1"] = $txtFecha1;
      }
      //-- Revisa si se ha ejecutado una b�squeda por fecha...
      if( isset($_POST["txtFecha2"]) && !empty($_POST["txtFecha2"]) ){         
         $txtFecha2 = $xSys->ConvertirFecha($_POST["txtFecha2"], "yyyy-mm-dd");
         //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
         $_SESSION["txt_fecha2"] = $txtFecha2;
      }
      /*
      Si el m�dulo no ha sido invocado desde el men� principal,
      entonces revisa si existen datos en las variables de sesi�n
      de alguna b�squeda u ordenaci�n.
      */
      if( $xInicio == 0 ){
         if( $_SESSION["id_ordenr"] != "" )   $idOrdr      = $_SESSION["id_ordenr"]; 
         if( $_SESSION["tipo_ordenr"] != "" ) $tipoOrdr    = $_SESSION["tipo_ordenr"];
         if( $_SESSION["cmp_buscar"] != "" )  $cmpBuscar   = $_SESSION["cmp_buscar"];//TIPO DOCUMENTO
         if( $_SESSION["cmp_buscarS"] != "" ) $cmpBuscarS  = $_SESSION["cmp_buscarS"];//SEXO
         if( $_SESSION["cmp_buscarf"] != "" ) $cmpBuscarf  = $_SESSION["cmp_buscarf"];//RECEPCION
         if( $_SESSION["cmp_buscard"] != "" ) $cmpBuscard  = $_SESSION["cmp_buscard"];//SOLICITUD Y RESPUESTA
         if( $_SESSION["cmp_buscar2"] != "" ) $cmpBuscar2  = $_SESSION["cmp_buscar2"];//NIVEL DE ESTUDIO
         if( $_SESSION["cmp_buscar3"] != "" ) $cmpBuscar3  = $_SESSION["cmp_buscar3"];//DOCUMENTO ESTUDIO
         if( $_SESSION["cmp_buscar4"] != "" ) $cmpBuscar4  = $_SESSION["cmp_buscar4"];//ESCUELA
         if( $_SESSION["cmp_buscar5"] != "" ) $cmpBuscar5  = $_SESSION["cmp_buscar5"];//RESULTADO ESTUDIO
         if( $_SESSION["cmp_buscar6"] != "" ) $cmpBuscar6  = $_SESSION["cmp_buscar6"];//RESULTADO ESTUDIO
         if( $_SESSION["cmp_buscar7"] != "" ) $cmpBuscar7  = $_SESSION["cmp_buscar7"];//RESULTADO ESTUDIO
         if( $_SESSION["cmp_buscar8"] != "" ) $cmpBuscar8  = $_SESSION["cmp_buscar8"];//RESULTADO ESTUDIO
         if( $_SESSION["txt_buscar"] != "" )  $txtBuscar   = $_SESSION["txt_buscar"];
         if( $_SESSION["txt_fecha1"] != "" )  $txtFecha    = $_SESSION["txt_fecha1"];//FECHA INICIA
         if( $_SESSION["txt_fecha2"] != "" )  $txtFecha2   = $_SESSION["txt_fecha2"];//FECHA TERMINA
         $xMsj = "�ltima b�squeda realizada...";
      }
      else{         
         $_SESSION["id_ordenr"]   = "";
         $_SESSION["tipo_ordenr"] = "";
         $_SESSION["cmp_buscar"]  = "";//TIPO DOCUMENTO
         $_SESSION["cmp_buscarS"] = "";//SEXO
         $_SESSION["cmp_buscarf"] = "";//RECEPCION
         $_SESSION["cmp_buscard"] = "";//SOLICITUD Y RESPUESTA
         $_SESSION["cmp_buscar2"] = "";//NIVEL DE ESTUDIO
         $_SESSION["cmp_buscar3"] = "";//DOCUMENTO ESTUDIO
         $_SESSION["cmp_buscar4"] = "";//ESCUELA
         $_SESSION["cmp_buscar5"] = "";//RESULTADO ESTUDIO
         $_SESSION["cmp_buscar6"] = "";//RESULTADO ESTUDIO
         $_SESSION["cmp_buscar7"] = "";//RESULTADO ESTUDIO
         $_SESSION["cmp_buscar8"] = "";//RESULTADO ESTUDIO
         $_SESSION["txt_buscar"]  = "";
         $_SESSION["txt_fecha1"]  = "";//FECHA INICIA
         $_SESSION["txt_fecha2"]  = "";//FECHA TERMINA
         $xMsj = "";
      }
   //-----------------------------------------------------------------//
   header("Content-type: application/vnd.ms-excel"); 
   header("Content-Disposition: attachment; filename=Reporte_" . date("Y-m-d") . ".xls");
   ?> 

   <table style="border-bottom: 1px solid #cccccc;">         
      <thead>
         <tr>
            <td colspan="15" style="text-align: center; font-weight: bold; font-size: 14pt;">CENTRO ESTATAL DE EVALUACION Y CONTROL DE CONFIANZA</td>
         </tr>
         <tr>
            <td colspan="15" style="text-align: center; font-weight: bold; font-size: 12pt;">DEPARTAMENTO INVESTIGACI�N DOCUMENTAL</td>
         </tr>
         <tr>
            <td colspan="15" style="text-align: center; font-weight: bold; font-size: 12pt;">REPORTE GENERAL DE PERSONAL EVALUADO</td>
         </tr>
         <tr>
            <th style="border: 1px solid #cccccc;">NOMBRE</th>
            <th style="border: 1px solid #cccccc;">SEXO</th>
            <th style="border: 1px solid #cccccc;">CURP</th>
            <th style="border: 1px solid #cccccc;">PUESTO O CATEGORIA</th>
            <th style="border: 1px solid #cccccc;">CORPORACION</th>
            <th style="border: 1px solid #cccccc;">MUNICIPIO</th>
            <th style="border: 1px solid #cccccc;">ESTATUS</th>
            <th style="border: 1px solid #cccccc;">FECHA DE EVALUACION</th>
            
            <th style="border: 1px solid #cccccc;">ESCOLARIDAD</th>
            <th style="border: 1px solid #cccccc;">DATOS DE LA INSTITUCION</th>
            <th style="border: 1px solid #cccccc;">LUGAR DE EXPEDICION</th>
            <th style="border: 1px solid #cccccc;">ESTADO</th>
            <th style="border: 1px solid #cccccc;">DEPENDENCIA</th>
            <th style="border: 1px solid #cccccc;">LUGAR DE REMISION</th>

            <th style="border: 1px solid #cccccc;">DOCUMENTO A VALIDAR</th>
            <th style="border: 1px solid #cccccc;">FECHA DE SOLICITUD</th>
            <th style="border: 1px solid #cccccc;">NUMERO DE OFICIO</th>
            <th style="border: 1px solid #cccccc;">FECHA DE RESPUESTA</th>
            <th style="border: 1px solid #cccccc;">NUMERO DE OFICIO</th>
            <th style="border: 1px solid #cccccc;">RESULTADO</th>
            <!--<th style="border: 1px solid #cccccc;">REPORTE</th>-->
            <th style="border: 1px solid #cccccc;">OBSERVACIONES</th>
            
            <th style="border: 1px solid #cccccc;">DOCUMENTO A VALIDAR</th>
            <th style="border: 1px solid #cccccc;">MATRICULA</th>
            <th style="border: 1px solid #cccccc;">CLASE</th>
            <th style="border: 1px solid #cccccc;">ZONA MILITAR</th>
            <th style="border: 1px solid #cccccc;">FOLIO DEL DOCUMENTO</th>

            <th style="border: 1px solid #cccccc;">FECHA DE SOLICITUD</th>
            <th style="border: 1px solid #cccccc;">NUMERO DE OFICIO</th>
            <th style="border: 1px solid #cccccc;">FECHA DE RESPUESTA</th>
            <th style="border: 1px solid #cccccc;">NUMERO DE OFICIO</th>
            <th style="border: 1px solid #cccccc;">RESULTADO</th>
            <!--<th style="border: 1px solid #cccccc;">REPORTE</th>-->
            <th style="border: 1px solid #cccccc;">OBSERVACIONES</th>   
         </tr>
      </thead>         
      <tbody>         
         <?php
            $Datos = $xInvDoc->BusRptDoc($cmpBuscar, $cmpBuscarS, $cmpBuscarf, $cmpBuscard, $cmpBuscar2, $cmpBuscar3, $cmpBuscar4, $cmpBuscar5,$cmpBuscar6,$cmpBuscar7,$cmpBuscar8, $txtBuscar, $idOrdr, $tipoOrdr, 1, $_SESSION["txt_fecha1"], $_SESSION["txt_fecha2"]);            
                foreach( $Datos As $registro ){
               echo"<tr id='".$registro["CURP"]."' bgcolor='#ffffff'>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["APELLIDOS"]." ".$registro["NOMBRE"]."</a>";
                  if($registro["GENERO"]==1)
                        $Genero="H";
                  else 
                        $Genero="M";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$Genero."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["CURP"]."</td>";
                  if($registro["ID_CORPORACION"]==2)
                        $municipio=$registro["MUNICIPIO"];
                      else
                        $municipio=$registro["CORPORACION"];
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["CATEGORIA"]."</td>";
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["CORPORACION"]."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["MUNICIPIO"]."</td>";
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["TIPO_EVAL"]."</td>";
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".date("d/m/Y",strtotime($registro["FECHA_RECEPCION"]))."</td>";
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["NIVELESTUDIOS"]."</td>";
				  
                 $entregaestori="";
                $entregaestcop="";
                if($registro["DEJO_EST"]==1 && $registro["C_EST_ORI"]==1)
                  $entregaestori="ORIGINAL";
                else
                  $entregaestcop="COPIA"; 
                  
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["DATOS_INSTITUCION"]."</td>";
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["MPIO_STDIO"]."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["ENTI_STDIO"]."</td>";

                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["DEPEN_STDIO"]."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".""."</td>";

                  if($registro["ID_STDIO"]!= 7)
                    echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["DOC_STDIO"]." ".$entregaestori." ". $entregaestcop."</td>";
                  else
                    echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["OTRO_STDIO"]." ".$entregaestori." ". $entregaestcop."</td>";
                  if(empty($registro["FECHA_SOL_STDIO"]))
                        $fecha_est_sol="";
                      else
                        $fecha_est_sol=date("d/m/Y",strtotime($registro["FECHA_SOL_STDIO"]));
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$fecha_est_sol."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["NUM_SOL_STDIO"]."</td>";
                  if(empty($registro["FECHA_RESP_STDIO"]))
                        $fecha_est_res="";
                      else
                        $fecha_est_res=date("d/m/Y",strtotime($registro["FECHA_RESP_STDIO"]));
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$fecha_est_res."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["NUM_RESP_STDIO"]."</td>";
                  if(empty($registro["RES_OFI_STDIO"]))
                     echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["STDIO_RESUL"]."</td>";
                  else
                     echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["RES_OFI_STDIO"]."</td>";
                  //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>REPORTE</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["OBSERVA_STDIO"]."</td>";
                  
                  $entregacarori="";
                      $entregacarcop="";
                      if( $registro["DEJO_CAR"]==1 && $registro["CAR_ORI"]==1 )
                        $entregacarori="ORIGINAL";
                      else
                        $entregacarcop="COPIA"; 
                  if($registro["ID_CAR"]!=6)   
				    echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$entregacarcop." ".$registro["DOC_CAR"]." ".$entregacarori."</td>";
                  else
                    echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$entregacarcop." ".$registro["OTRO_CAR"]." ".$entregacarori."</td>";
                    
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["MAT_CARTILLA"]."</td>";
				  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["CAR_CLASE"]."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["DEPEN_CAR"]."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["FOLIO"]."</td>";

                  if(empty($registro["FECHA_SOL_CAR"]))
                        $fecha_car_sol="";
                      else
                        $fecha_car_sol=date("d/m/Y",strtotime($registro["FECHA_SOL_CAR"]));
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$fecha_car_sol."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["NUM_SOL_CAR"]."</td>";
                  if(empty($registro["FECHA_RESP_CAR"]))
                        $fecha_car_res="";
                      else
                        $fecha_car_res=date("d/m/Y",strtotime($registro["FECHA_RESP_CAR"]));
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$fecha_car_res."</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["NUM_RESP_CAR"]."</td>";
                  if(empty($registro["RES_OFI_CAR"]))
                     echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["CAR_RESUL"]."</td>";
                  else
                     echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["RES_OFI_CAR"]."</td>";                  
                  //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>REPORTE</td>";
                  echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["OBSERVA_CAR"]."</td>";
				  
				  
				  
				  
                  //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["MUNICIPIO"]."</td>";
                  
                  //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["ESPECIALIDAD"]."</td>";
                  
                  //echo"<td align='left'   style='min-width: 100px; border-bottom: 1px dotted #cccccc;'>".$registro["AREA"]."</td>";
                  //----------------------------------------------------------------------------------------
                  
                  
                  
                  
               echo"</tr>"; 
            }
         $xTotal = count($Datos);
         if( $xTotal <= 0 ){
            echo"<tr style='background: none;'>
                  <td colspan='15' align='center'>
                     <div style='font-family: sans-serif; font-weight: normal; font-size: 8pt; color: #ff0000;'>
                        No existen resultados para la b�squeda...
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