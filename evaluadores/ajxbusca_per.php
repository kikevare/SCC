<?php
   session_start();
   header("content-type: text/html; charset=iso-8859-1");
   include("../../includes/xsystem.php");
   include("../../includes/persona.class.php");
   $xSys = New System();
        
   $curp = $_POST["curp"];
   
   $xPersona = New Persona($curp);   
   if( !empty($xPersona->CURP) ){           
      echo"
      <div style='width: 98%; padding: 10px 5px 10px 5px;'>
         <fieldset id='fsContenido' style='width: 100%;'>
            <legend style='font-size: 9pt;'></legend>
            <table class='stytbContenido' style='margin-left: 25px;' border='0' cellpadding='0' cellspacing='0'>
               <tr>
                  <td class='styTdNombreCampo' width='250'>C.U.R.P.:</td>
                  <td class='styTdCampo' width='350'>                     
                     <input name='xcurp' size='27' maxlength='18' value='".$xPersona->CURP."' class='text' readonly='true' /> 
                  </td>
               </tr>            
               <tr>
                  <td class='styTdNombreCampo'>Nombre:</td>
                  <td class='styTdCampo'>                     
                     <input name='xnombre' size='35' maxlength='35' value='".$xPersona->NOMBRE."' class='text' readonly='true' /> 
                  </td>
               </tr>
               <tr>
                  <td class='styTdNombreCampo'>Apellido Paterno:</td>
                  <td class='styTdCampo'>                     
                     <input name='xa_paterno' size='35' maxlength='30' value='".$xPersona->APATERNO."' class='text' readonly='true' />
                  </td>
               </tr>              
               <tr>
                  <td class='styTdNombreCampo'>Apellido Materno:</td>
                  <td class='styTdCampo'>
                     <input name='xa_materno' size='35' maxlength='30' value='".$xPersona->AMATERNO."' class='text' readonly='true' />
                  </td>
               </tr>
               <tr>
                  <td class='styTdNombreCampo'>Fecha de nacimiento:</td>
                  <td class='styTdCampo'>
                     <input name='xfecha_nac' size='15' maxlength='10' value='"
                        .$xSys->FormatoCorto( date("d-m-Y", strtotime($xPersona->FECHANAC)) ).
                     "' class='text' readonly='true' />
                  </td>
               </tr>               
               <tr>
                  <td class='styTdNombreCampo'>Sexo:</td>
                  <td class='styTdCampo'>
                     <select name='xsexo' class='select'>                     
                        <option>".$xPersona->getSexo()."</option>
                     </select>               
                  </td>
               </tr>            
               <tr>
                  <td class='styTdNombreCampo'>R.F.C.:</td>
                  <td class='styTdCampo'>                     
                     <input name='xrfc' size='17' maxlength='13' value='".$xPersona->RFC."' class='text' readonly='true' />
                  </td>
               </tr>               
               <tr>
                  <td class='styTdNombreCampo'>C.U.I.P.:</td>
                  <td class='styTdCampo'>                     
                     <input name='xcuip' size='25' maxlength='20' value='".$xPersona->CUIP."' class='text' readonly='true' />                  
                  </td>
               </tr>               
            </table>
         </fieldset>
         <p style='padding: 10px 3px 0px 3px; color: #e41b17;'>
         Ya existe un elemento con la misma CURP que ha especificado. 
         A continuacion se le redireccionara al modulo principal, para que pueda 
         asignarle una nueva evaluacion a este elemento si asi lo desea.<br /><br /> 
         Click en Aceptar para continuar...
         </p>
      </div>
      ";
   }      
   else
      echo"";
?>