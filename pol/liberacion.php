<?php
//header("Content-type: application/vnd.ms-word"); 
//header("Content-Disposition: attachment; filename=Reporte_Antecedentes.doc");
header("Content-type: application/vnd.ms-word");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=liberaciodn.doc");

session_start();


//-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
//-------------------------------------------------------------//
if( isset($_SESSION["admitted_xsice"]) ){
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   include_once($xPath."includes/catalogos.class.php");
   include_once($xPath."includes/poligrafia.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xCat = New Catalog(); 
   
   $xfecha = date('d') .' de '. $xSys->NomMesLargo( date("m") ) .' de '. date('Y');
  }
  
//<?php  $xPath."imgs/image002.jpg"  
     
   //----- Recepcion de par�metros de ordenaci�n y b�squeda -------//
   $xInicio = 0;
   //-- Inicializa los par�metros...
   $idOrdr      = 2;      
   $tipoOrdr    = "Asc";
   $txtBuscar   = "";
   $cmpBuscar   = 0;      
   //-- Revisa si se ha ejecutado una ordenaci�n...
   if( isset($_POST["id_ordenr"]) ){
      $idOrdr   = $_POST["id_ordenr"];         
      $tipoOrdr = $_POST["tp_ordenr"];
      
      //-- Se guardan los par�metros de ordenaci�n en variables de sesi�n...
      $_SESSION["id_ordenr"] = $idOrdr;
      $_SESSION["tipo_ordenr"] = $tipoOrdr;
   }
   //-- Revisa si se ha ejecutado una b�squeda por campos...
   if( isset($_POST["cbCampor"])  ){
      $cmpBuscar = $_POST["cbCampor"];
                 
      //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
      $_SESSION["cmp_buscar"] = $cmpBuscar;
                  
   }
   /*//-- Revisa si se ha ejecutado una b�squeda por campos...
   if( isset($_POST["txtBuscar"]) && !empty($_POST["txtBuscar"]) ){
      $cmpBuscar = $_POST["cbCampor"];
      $txtBuscar = $_POST["txtBuscar"];            
      //-- Se guardan los par�metros de b�squeda en variables de sesi�n...
      $_SESSION["cmp_buscar"] = $cmpBuscar;
      $_SESSION["txt_buscar"] = $txtBuscar;            
   }*/
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
      if( $_SESSION["id_ordenr"] != "" )   $idOrdr    = $_SESSION["id_ordenr"]; 
      if( $_SESSION["tipo_ordenr"] != "" ) $tipoOrdr  = $_SESSION["tipo_ordenr"];
      if( $_SESSION["cmp_buscar"] != "" )  $cmpBuscar = $_SESSION["cmp_buscar"];
      if( $_SESSION["txt_buscar"] != "" )  $txtBuscar = $_SESSION["txt_buscar"];
      if( $_SESSION["txt_fecha1"] != "" )  $txtFecha  = $_SESSION["txt_fecha1"];
      if( $_SESSION["txt_fecha2"] != "" )  $txtFecha2 = $_SESSION["txt_fecha2"];
      $xMsj = "";//"�ltima b�squeda realizada...";
   }
   else{         
      $_SESSION["id_ordenr"]   = "";
      $_SESSION["tipo_ordenr"] = "";
      $_SESSION["cmp_buscar"]  = "";
      $_SESSION["txt_buscar"]  = "";
      $_SESSION["txt_fecha1"]  = "";
      $_SESSION["txt_fecha2"]  = "";
      $xMsj = "";
   }
 
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 15">
<meta name=Originator content="Microsoft Word 15">
<link rel=File-List href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/filelist.xml">
<link rel=Edit-Time-Data href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/editdata.mso">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Cesar Balderas</o:Author>
  <o:LastAuthor>RMN</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>3</o:TotalTime>
  <o:Created>2020-09-02T19:36:00Z</o:Created>
  <o:LastSaved>2020-09-02T19:36:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>105</o:Words>
  <o:Characters>579</o:Characters>
  <o:Lines>4</o:Lines>
  <o:Paragraphs>1</o:Paragraphs>
  <o:CharactersWithSpaces>683</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<link rel=themeData href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/themedata.thmx">
<link rel=colorSchemeMapping
href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:HyphenationZone>21</w:HyphenationZone>
  <w:PunctuationKerning/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>ES-MX</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:BreakWrappedTables/>
   <w:SnapToGridInCell/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
   <w:DontFlipMirrorIndents/>
   <w:OverrideTableStyleHps/>
  </w:Compatibility>
  <w:DoNotOptimizeForBrowser/>
  <m:mathPr>
   <m:mathFont m:val="Cambria Math"/>
   <m:brkBin m:val="before"/>
   <m:brkBinSub m:val="&#45;-"/>
   <m:smallFrac m:val="off"/>
   <m:dispDef/>
   <m:lMargin m:val="0"/>
   <m:rMargin m:val="0"/>
   <m:defJc m:val="centerGroup"/>
   <m:wrapIndent m:val="1440"/>
   <m:intLim m:val="subSup"/>
   <m:naryLim m:val="undOvr"/>
  </m:mathPr></w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="false"
  DefSemiHidden="false" DefQFormat="false" DefPriority="99"
  LatentStyleCount="376">
  <w:LsdException Locked="false" Priority="0" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 9"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 1"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 2"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 3"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 4"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 5"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 6"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 7"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 8"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footnote text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="header"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footer"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index heading"/>
  <w:LsdException Locked="false" Priority="35" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="table of figures"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="envelope address"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="envelope return"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footnote reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="line number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="page number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="endnote reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="endnote text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="table of authorities"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="macro"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="toa heading"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 5"/>
  <w:LsdException Locked="false" Priority="10" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Closing"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Signature"/>
  <w:LsdException Locked="false" Priority="1" SemiHidden="true"
   UnhideWhenUsed="true" Name="Default Paragraph Font"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Message Header"/>
  <w:LsdException Locked="false" Priority="11" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Salutation"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Date"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text First Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text First Indent 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Note Heading"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Block Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Hyperlink"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="FollowedHyperlink"/>
  <w:LsdException Locked="false" Priority="22" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" Priority="20" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Document Map"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Plain Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="E-mail Signature"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Top of Form"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Bottom of Form"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal (Web)"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Acronym"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Address"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Cite"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Code"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Definition"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Keyboard"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Preformatted"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Sample"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Typewriter"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Variable"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Table"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation subject"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="No List"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Contemporary"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Elegant"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Professional"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Subtle 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Subtle 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Balloon Text"/>
  <w:LsdException Locked="false" Priority="39" Name="Table Grid"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Theme"/>
  <w:LsdException Locked="false" SemiHidden="true" Name="Placeholder Text"/>
  <w:LsdException Locked="false" Priority="1" QFormat="true" Name="No Spacing"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 1"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 1"/>
  <w:LsdException Locked="false" SemiHidden="true" Name="Revision"/>
  <w:LsdException Locked="false" Priority="34" QFormat="true"
   Name="List Paragraph"/>
  <w:LsdException Locked="false" Priority="29" QFormat="true" Name="Quote"/>
  <w:LsdException Locked="false" Priority="30" QFormat="true"
   Name="Intense Quote"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 1"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 1"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 2"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 2"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 2"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 3"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 3"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 3"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 4"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 4"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 4"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 5"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 5"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 5"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 6"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 6"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 6"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="19" QFormat="true"
   Name="Subtle Emphasis"/>
  <w:LsdException Locked="false" Priority="21" QFormat="true"
   Name="Intense Emphasis"/>
  <w:LsdException Locked="false" Priority="31" QFormat="true"
   Name="Subtle Reference"/>
  <w:LsdException Locked="false" Priority="32" QFormat="true"
   Name="Intense Reference"/>
  <w:LsdException Locked="false" Priority="33" QFormat="true" Name="Book Title"/>
  <w:LsdException Locked="false" Priority="37" SemiHidden="true"
   UnhideWhenUsed="true" Name="Bibliography"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="TOC Heading"/>
  <w:LsdException Locked="false" Priority="41" Name="Plain Table 1"/>
  <w:LsdException Locked="false" Priority="42" Name="Plain Table 2"/>
  <w:LsdException Locked="false" Priority="43" Name="Plain Table 3"/>
  <w:LsdException Locked="false" Priority="44" Name="Plain Table 4"/>
  <w:LsdException Locked="false" Priority="45" Name="Plain Table 5"/>
  <w:LsdException Locked="false" Priority="40" Name="Grid Table Light"/>
  <w:LsdException Locked="false" Priority="46" Name="Grid Table 1 Light"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark"/>
  <w:LsdException Locked="false" Priority="51" Name="Grid Table 6 Colorful"/>
  <w:LsdException Locked="false" Priority="52" Name="Grid Table 7 Colorful"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 1"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 1"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 1"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 2"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 2"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 2"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 3"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 3"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 3"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 4"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 4"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 4"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 5"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 5"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 5"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 6"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 6"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 6"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="46" Name="List Table 1 Light"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark"/>
  <w:LsdException Locked="false" Priority="51" Name="List Table 6 Colorful"/>
  <w:LsdException Locked="false" Priority="52" Name="List Table 7 Colorful"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 1"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 1"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 1"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 2"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 2"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 2"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 3"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 3"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 3"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 4"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 4"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 4"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 5"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 5"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 5"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 6"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 6"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 6"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Mention"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Smart Hyperlink"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Hashtag"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Unresolved Mention"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Smart Link"/>
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-469750017 -1073732485 9 0 511 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:8.0pt;
	margin-left:0cm;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-unhide:no;
	mso-style-link:"Encabezado Car";
	margin:0cm;
	mso-pagination:widow-orphan;
	tab-stops:center 212.6pt right 425.2pt;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-unhide:no;
	mso-style-link:"Pie de p�gina Car";
	margin:0cm;
	mso-pagination:widow-orphan;
	tab-stops:center 212.6pt right 425.2pt;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
a:link, span.MsoHyperlink
	{mso-style-unhide:no;
	color:#0563C1;
	mso-themecolor:hyperlink;
	text-decoration:underline;
	text-underline:single;}
a:visited, span.MsoHyperlinkFollowed
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:#954F72;
	mso-themecolor:followedhyperlink;
	text-decoration:underline;
	text-underline:single;}
p.MsoNoSpacing, li.MsoNoSpacing, div.MsoNoSpacing
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
span.EncabezadoCar
	{mso-style-name:"Encabezado Car";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:Encabezado;}
span.PiedepginaCar
	{mso-style-name:"Pie de p�gina Car";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Pie de p�gina";}
span.GramE
	{mso-style-name:"";
	mso-gram-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-hansi-font-family:Calibri;
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
.MsoPapDefault
	{mso-style-type:export-only;
	margin-bottom:8.0pt;
	line-height:107%;}
 /* Page Definitions */
 @page
	{mso-footnote-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") fs;
	mso-footnote-continuation-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") fcs;
	mso-endnote-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") es;
	mso-endnote-continuation-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") ecs;}
@page WordSection1
	{size:792.0pt 612.0pt;
	mso-page-orientation:landscape;
	margin:42.55pt 42.55pt 42.55pt 42.55pt;
	mso-header-margin:35.45pt;
	mso-footer-margin:14.2pt;
	mso-even-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") eh1;
	mso-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") h1;
	mso-even-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") ef1;
	mso-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") f1;
	mso-first-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") fh1;
	mso-first-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/reportes/archivos/header.htm") ff1;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:"Tabla normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin-top:0cm;
	mso-para-margin-right:0cm;
	mso-para-margin-bottom:8.0pt;
	mso-para-margin-left:0cm;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
table.MsoTableSimple1
	{mso-style-name:"Tabla b�sica 1";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid black 1.0pt;
	mso-border-alt:solid black .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid black;
	mso-border-insidev:.5pt solid black;
	mso-para-margin-top:0cm;
	mso-para-margin-right:0cm;
	mso-para-margin-bottom:8.0pt;
	mso-para-margin-left:0cm;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
table.MsoTableGrid
	{mso-style-name:"Tabla con cuadr�cula";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
table.TableGrid1
	{mso-style-name:"Table Grid1";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	mso-style-parent:"";
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 0cm 0cm 0cm;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:EN-US;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="2050"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=ES-MX link="#0563C1" vlink="#954F72" style='tab-interval:35.4pt'>

<div class=WordSection1>

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=603
 style='width:452.5pt;margin-left:247.85pt;border-collapse:collapse;border:
 none;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
 none;mso-border-insidev:none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:11.35pt'>
  <td width=142 style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:8.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>DEPENDENCIA:<o:p></o:p></span></b></p>
  </td>
  <td width=462 style='width:346.2pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing><span style='font-size:8.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>SECRETARIADO EJECUTIVO DEL CONSEJO ESTATAL DE
  SEGURIDAD PUBLICA.<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:11.35pt'>
  <td width=142 style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:8.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>SECCION:<o:p></o:p></span></b></p>
  </td>
  <td width=462 style='width:346.2pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing><span style='font-size:8.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>CENTRO ESTATAL DE EVALUACION Y CONTROL DE CONFIANZA.<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:11.35pt'>
  <td width=142 style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:8.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>OFICIO NO.:<o:p></o:p></span></b></p>
  </td>
  <td width=462 style='width:346.2pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing><span style='font-size:8.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;mso-yfti-lastrow:yes;height:11.35pt'>
  <td width=142 style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:8.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>ASUNTO:<o:p></o:p></span></b></p>
  </td>
  <td width=462 style='width:346.2pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing><span style='font-size:8.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'>ENTREGA DE EXPEDIENTES DE EVALUACION DE POLIGRAFIA.<o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNoSpacing><span style='mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing align=right style='text-align:right'><b style='mso-bidi-font-weight:
normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
ES-MX'>CHILPANCINGO DE LOS BRAVO, GUERRERO, <a name=fechaEntregaAreaArchivo><?php echo $xfecha;?></a><o:p></o:p></span></b></p>

<p class=MsoNoSpacing align=right style='text-align:right;line-height:115%'><b
style='mso-bidi-font-weight:normal'><i style='mso-bidi-font-style:normal'><span
style='font-size:9.0pt;mso-bidi-font-size:10.0pt;line-height:115%;font-family:
"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
ES-MX'><?php echo utf8_decode("2025, Año de la mujer indigena")?><o:p></o:p></span></i></b></p>

<p class=MsoNoSpacing style='line-height:115%'><a name=titularArchivo><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;line-height:115%;font-family:"Arial",sans-serif;mso-bidi-font-family:
"Times New Roman";mso-ansi-language:ES-MX'>LIC. DAN MARTIN CORTEZ SANCHEZ</span></b></a><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;line-height:115%;font-family:"Arial",sans-serif;mso-bidi-font-family:
"Times New Roman";mso-ansi-language:ES-MX'><o:p></o:p></span></b></p>

<p class=MsoNoSpacing style='line-height:115%'><b style='mso-bidi-font-weight:
normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;line-height:
115%;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'>ENCARGADO DEL AREA DE INTEGRACION DE RESULTADOS.<o:p></o:p></span></b></p>

<p class=MsoNoSpacing style='line-height:115%'><b style='mso-bidi-font-weight:
normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;line-height:
115%;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'>PRESENTE<o:p></o:p></span></b></p>

<p class=MsoNoSpacing><span style='font-size:6.0pt;mso-bidi-font-size:10.0pt;
mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'>POR MEDIO DEL PRESENTE, HAGO <b style='mso-bidi-font-weight:
normal'>ENTREGA DE  EXPEDIENTES</b> CORRESPONDIENTES A LA <b style='mso-bidi-font-weight:
normal'><u>EVALUACION DE POLIGRAFIA</u></b> DEL SIGUIENTE PERSONAL:<a
name=tablaEntregaExpediente><o:p></o:p></a></span></p>

<p class=MsoNoSpacing><span style='mso-bookmark:tablaEntregaExpediente'><span
style='font-size:7.0pt;mso-bidi-font-size:10.0pt;mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></span></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:11.35pt'>
  <td width=46 style='width:34.65pt;border:solid windowtext 1.0pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>NO.<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
  <td width=218 style='width:163.55pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>NOMBRE<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
  <td width=161 style='width:120.5pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>CURP<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
  <td width=198 style='width:148.85pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>CORPORACION<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
  <td width=142 style='width:106.3pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>FECHA EVALUACION<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
  <td width=98 valign=top style='width:73.2pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>MOTIVO<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
  <td width=79 style='width:59.35pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.35pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><span
  style='mso-bookmark:tablaEntregaExpediente'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:
  "Arial",sans-serif;mso-bidi-font-family:"Times New Roman";mso-ansi-language:
  ES-MX'>HOJAS<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
 </tr>
 <tbody>    


<?php
$dbname ="bdceecc";
$dbuser="root";
$dbhost="10.24.2.25";
$dbpass='4dminMy$ql$';
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$sql="SELECT curp from liberados_pol where estado='1'";
$resultado = mysqli_query($conexion,$sql);
function obtener_nombre($conexion,$curp)
      {
         $sql ="SELECT nombre, a_paterno, a_materno from tbdatospersonales where curp ='$curp'";
         $resultado = mysqli_query($conexion,$sql);
         $fila = mysqli_fetch_assoc($resultado);
         $nombre = $fila['nombre']." ".$fila['a_paterno']." ".$fila['a_materno'];
         echo $nombre;
      }
      function categoria ($conexion,$curp)
      {
         $sql ="SELECT id_corporacion from tbprog_preliminar where xcurp ='$curp' order by id_prog_preliminar desc";
         $resultado = mysqli_query($conexion,$sql);
         $fila = mysqli_fetch_assoc($resultado);
         $idcor = $fila['id_corporacion'];
         $sql2 = "SELECT corporacion from ctcorporacion where id_corporacion='$idcor'";
         $resultado2 = mysqli_query($conexion,$sql2);
         $fila2 = mysqli_fetch_assoc($resultado2);
         $corporacion=$fila2['corporacion'];
         echo $corporacion;
      }
      function fecha_evaluacion ($conexion,$curp)
      {
         $sql ="SELECT fecha_aplicacion from poligrafia_evnu where curp_evaluado ='$curp' order by id_evaluacion desc";
         $resultado = mysqli_query($conexion,$sql);
         $fila = mysqli_fetch_assoc($resultado);
         $fecha = $fila['fecha_aplicacion'];
         echo $fecha;
      }
      function tipoevaluacion ($conexion,$curp)
      {
         $sql ="SELECT id_tipo_eval from tbprog_preliminar where xcurp ='$curp' order by id_prog_preliminar desc";
         $resultado = mysqli_query($conexion,$sql);
         $fila = mysqli_fetch_assoc($resultado);
         $ideval = $fila['id_tipo_eval'];
         $sql2 = "SELECT tipo_eval from cttipoevaluacion where id_tipo_eval='$ideval'";
         $resultado2 = mysqli_query($conexion,$sql2);
         $fila2 = mysqli_fetch_assoc($resultado2);
         $tipoeval=$fila2['tipo_eval'];
         echo $tipoeval;
      }
      function totalhojas ($conexion,$curp){
         $sql ="SELECT id_evaluacion from poligrafia_evnu where curp_evaluado ='$curp' order by id_evaluacion desc";
         $resultado = mysqli_query($conexion,$sql);
         $fila = mysqli_fetch_assoc($resultado);
         $id_evaluacion = $fila['id_evaluacion'];
         $sql2 = "SELECT total from indice_polnu where id_evaluacion='$id_evaluacion'";
         $resultado2 = mysqli_query($conexion,$sql2);
         $fila2 = mysqli_fetch_assoc($resultado2);
         $total=$fila2['total'];
         echo $total;

      }
      $contador=0;
      $i=1;  
      while ($fila = mysqli_fetch_assoc($resultado)) {
         $curp_evaluado = $fila['curp'];
               echo"<tr bgcolor='#ffffff'>";
               echo"<td align='center'   style='min-width: 100px; border-bottom: 1px solid black;'>".$i++."</td>"; 
               echo"<td align='left'   style='min-width: 100px; border-bottom: 1px solid black;'>".obtener_nombre($conexion,$curp_evaluado)." </td>";
               echo"<td align='center'   style='min-width: 100px; border-bottom: 1px solid black;'>".$curp_evaluado."</td>";
               echo"<td align='center'   style='min-width: 100px; border-bottom: 1px solid black;'> ".categoria($conexion,$curp_evaluado)."</td>";
                          
                    echo"<td align='center' style='min-width: 100px; border-bottom: 1px solid black;'>".fecha_evaluacion($conexion,$curp_evaluado) ."</td>";
               echo"<td align='center' style='min-width: 100px; border-bottom: 1px solid black;'>".tipoevaluacion($conexion,$curp_evaluado)."</td>";
               echo"<td align='center'   style='min-width: 100px; border-bottom: 1px solid black;'>".totalhojas($conexion,$curp_evaluado)."</td>";
               
               //----------------------------------------------------------------------------------------    
               
            echo"</tr>"; 
           
   }
   function liberar ($conexion)
   {
      $upda = "UPDATE liberados_pol SET estado = '2'";
      $resed = mysqli_query($conexion, $upda);
   }
    echo liberar($conexion);     


?>   
</tbody>
  <span style='mso-bookmark:tablaEntregaExpediente'></span>
 </tr>
</table>

<p class=MsoNoSpacing><span style='mso-bookmark:tablaEntregaExpediente'></span><span
style='mso-bookmark:tablaEntregaExpediente'><span style='font-size:7.0pt;
mso-bidi-font-size:10.0pt;mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></span></p>

<p class=MsoNoSpacing><span style='mso-bookmark:tablaEntregaExpediente'><span
style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></span></p>

<span style='mso-bookmark:tablaEntregaExpediente'></span>

<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'>A T E N T A M E N T E<o:p></o:p></span></b></p>

<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNoSpacing align=center style='text-align:center'><b
style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></b></p>

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=941
 style='width:705.9pt;border-collapse:collapse;border:none;mso-yfti-tbllook:
 1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:none;mso-border-insidev:
 none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes'>
  <td width=265 valign=top style='width:7.0cm;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></b></p>
  </td>
  <td width=412 valign=top style='width:309.0pt;border:none;border-top:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNoSpacing align=center style='text-align:center;line-height:150%'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;line-height:150%;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";mso-ansi-language:ES-MX'>ENCARGADA DEL DEPARTAMENTO DE
  POLIGRAFIA<o:p></o:p></span></b></p>
  <p class=MsoNoSpacing align=center style='text-align:center;line-height:150%'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;line-height:150%;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";mso-ansi-language:ES-MX'>LIC. <a name=nombreCoordinador>SANDRA
  LUZ GOMEZ ARROYO</a><o:p></o:p></span></b></p>
  </td>
  <td width=265 valign=top style='width:7.0cm;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></b></p>
  </td>

 </tr>
 
</table>
<p class=MsoNoSpacing><span lang=ES-MX style='font-size:10.0pt;mso-bidi-font-size:
9.0pt;mso-ansi-language:ES-MX'>C.c.p. Psic. Elida L&oacute;pez Araujo/Directora General
del CEEYCC. Para su conocimiento. - PRESENTE<o:p></o:p></span></p>

<p class=MsoNoSpacing><span lang=ES-MX style='font-size:10.0pt;mso-bidi-font-size:
9.0pt;mso-ansi-language:ES-MX'><?php echo utf8_decode("C.c.p. Lic. Arysai Adame Rodriguez/ Encargada de la Subdirección de Estadísticas y Control de Resultados. - PRESENTE") ?><o:p></o:p></span></p>

<p class=MsoNoSpacing><span lang=ES-MX style='font-size:10.0pt;mso-bidi-font-size:
9.0pt;mso-ansi-language:ES-MX'><?php echo utf8_decode("C.c.p. Lic. Kenia Guadalupe Juárez López/ Encargada de Archivo. - PRESENTE")?><o:p></o:p></span></p>
<p class=MsoNoSpacing><span style='mso-ansi-language:ES-MX'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>