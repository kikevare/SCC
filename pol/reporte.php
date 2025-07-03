<?php
//header("Content-type: application/vnd.ms-word"); 
//header("Content-Disposition: attachment; filename=INDICE_archivos_Antecedentes.doc");
header("Content-type: application/vnd.ms-word");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=REPORTE.doc");

session_start();

function getFullUrl_1() {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
      	return
    		($https ? 'https://' : 'http://').
    		(!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
    		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
    		($https && $_SERVER['SERVER_PORT'] === 443 ||
    		$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
			substr( $_SERVER['SCRIPT_NAME'],0, strpos($_SERVER['SCRIPT_NAME'], '/',1))
    		;
}



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

      
  }
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
      
}
$dbname ="bdceecc";
     $dbuser="root";
     $dbhost="10.24.2.25";
     $dbpass='4dminMy$ql$';
    $conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  
//<?php  $xPath."imgs/image002.jpg"  
$sql = "SELECT nombre, a_paterno, a_materno,id_tipo_eval, id_corporacion,categoria,fecha from tbprog_preliminar where xcurp = '".$curp1."' order by id_prog_preliminar desc";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_assoc($resultado);
    $id_corpo = $fila['id_corporacion'];
    $id_tip = $fila['id_tipo_eval'];
    $sql2 = "SELECT corporacion FROM ctcorporacion where id_corporacion = '$id_corpo'";
    $resultadocorp = mysqli_query($conexion, $sql2);
    $filacorp = mysqli_fetch_assoc($resultadocorp);
    $corporacion = $filacorp['corporacion'];
    $sql3 = "SELECT tipo_eval FROM cttipoevaluacion where id_tipo_eval = '$id_tip'";
    $resultadoev = mysqli_query($conexion, $sql3);
    $filatip = mysqli_fetch_assoc($resultadoev);
    $tipoe = $filatip['tipo_eval'];
    $sql4 = "SELECT rfc,id_genero,fecha_nac from tbdatospersonales where curp = '".$curp1."'";
    $resultado4 = mysqli_query($conexion, $sql4);
    $fila4 = mysqli_fetch_assoc($resultado4);
    $sql5 = "SELECT genero from ctgenero where id_genero = '".$fila4['id_genero']."'";
    $resultado5 = mysqli_query($conexion, $sql5);
    $fila5 = mysqli_fetch_assoc($resultado5);
    $fecha = time() - strtotime($fila4['fecha_nac']);
    $edad = floor($fecha / 31556926);
    $sql_rep = "SELECT evaluaciones_anteriores,trayectoria_laboral,situacion_patrimonial,analisis_tecnico,conclusion,admision,observacion from reporte_poli where id_evaluacion = '$id_evaluacion'";
    $resultado6 = mysqli_query($conexion, $sql_rep);
    $fila6 = mysqli_fetch_assoc($resultado6);
    $sql7 = "SELECT apeva from indice_polnu where id_evaluacion='$id_evaluacion'";
    $resultado7 = mysqli_query($conexion, $sql7);
    $fila7 = mysqli_fetch_assoc($resultado7);
  
//<?php  $xPath."imgs/image002.jpg"  

 
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
<link rel=File-List href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/filelist.xml">
<link rel=Edit-Time-Data href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/editdata.mso">
<!--[if !mso]>
<style>
v/:* {behavior:url(#default#VML);}
o/:* {behavior:url(#default#VML);}
w/:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>NV 5302e</o:Author>
  <o:LastAuthor>RMN</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>7</o:TotalTime>
  <o:LastPrinted>2020-03-20T19:25:00Z</o:LastPrinted>
  <o:Created>2020-08-13T19:03:00Z</o:Created>
  <o:LastSaved>2020-08-13T19:03:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>43</o:Words>
  <o:Characters>237</o:Characters>
  <o:Lines>1</o:Lines>
  <o:Paragraphs>1</o:Paragraphs>
  <o:CharactersWithSpaces>279</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:RelyOnVML/>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<link rel=themeData href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/themedata.thmx">
<link rel=colorSchemeMapping href="http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/colorschememapping.xml">
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
@font-face
	{font-family:"Segoe UI";
	panose-1:2 11 5 2 4 2 4 2 2 3;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-469750017 -1073683329 9 0 511 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:10.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-fareast-language:EN-US;}
p.MsoCommentText, li.MsoCommentText, div.MsoCommentText
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-link:"Texto comentario Car";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:10.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
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
	mso-fareast-language:EN-US;}
span.MsoCommentReference
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-ansi-font-size:8.0pt;}
a:link, span.MsoHyperlink
	{mso-style-unhide:no;
	mso-style-parent:"";
	color:blue;
	text-decoration:underline;
	text-underline:single;}
a:visited, span.MsoHyperlinkFollowed
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:#954F72;
	mso-themecolor:followedhyperlink;
	text-decoration:underline;
	text-underline:single;}
p.MsoCommentSubject, li.MsoCommentSubject, div.MsoCommentSubject
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"Texto comentario";
	mso-style-link:"Asunto del comentario Car";
	mso-style-next:"Texto comentario";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:10.0pt;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-fareast-language:EN-US;
	font-weight:bold;
	mso-bidi-font-weight:normal;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-link:"Texto de globo Car";
	margin:0cm;
	mso-pagination:widow-orphan;
	font-size:9.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Segoe UI",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-fareast-language:EN-US;}
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
span.TextodegloboCar
	{mso-style-name:"Texto de globo Car";
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Texto de globo";
	mso-ansi-font-size:9.0pt;
	font-family:"Segoe UI",sans-serif;
	mso-ascii-font-family:"Segoe UI";
	mso-hansi-font-family:"Segoe UI";}
span.TextocomentarioCar
	{mso-style-name:"Texto comentario Car";
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Texto comentario";
	mso-ansi-font-size:10.0pt;}
span.AsuntodelcomentarioCar
	{mso-style-name:"Asunto del comentario Car";
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:"Asunto del comentario";
	font-weight:bold;
	mso-bidi-font-weight:normal;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-hansi-font-family:Calibri;
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
 /* Page Definitions */
 @page
	{mso-footnote-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") fs;
	mso-footnote-continuation-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") fcs;
	mso-endnote-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") es;
	mso-endnote-continuation-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") ecs;}
@page WordSection1
	{size:612.0pt 792.0pt;
	margin:42.55pt 42.55pt 42.55pt 42.55pt;
	mso-header-margin:35.45pt;
	ms/*  */o-footer-margin:35.45pt;
	mso-even-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") eh1;
	mso-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") h1;
/* 	mso-even-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") ef1;
 */	/* mso-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") f1; */
	mso-first-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") fh1;
/* 	mso-first-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") ff1;
 */	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
--> */
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
	mso-para-margin:0cm;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
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
	mso-para-margin:0cm;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
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
	font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-bidi-font-family:"Times New Roman";}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1026"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=ES-MX link=blue vlink="#954F72" style='tab-interval:35.4pt'>

<div class=WordSection1> 

<p class=MsoNormal><span style='font-size:2.0pt;mso-bidi-font-size:10.0pt;
line-height:115%'><o:p>&nbsp;</o:p></span></p>

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:17.0pt'>
  <td width=175 style='width:131.6pt;border:solid windowtext 1.0pt;mso-border-alt:
  solid windowtext .5pt;background:#D9D9D9;mso-background-themecolor:background1;
  mso-background-themeshade:217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'>MOTIVO EVALUACION:<o:p></o:p></span></p>
  </td>
  <td width=210 style='width:157.3pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <?php
  echo $tipoe
   
    ?>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p>
    
 
    <?php echo  $DE
;?></o:p></span></p>
  </td>
  <td width=189 colspan=2 style='width:5.0cm;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#D9D9D9;mso-background-themecolor:background1;
  mso-background-themeshade:217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  color:black;mso-color-alt:windowtext'>FECHA DE EVALUACION:</span><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=128 style='width:95.75pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php
/*     $fecha_ap = $xSys->FormatoCorto( date("d/m/Y", strtotime($xPsico->FECHA_AP)) );
 */
    

    echo $fila['fecha'];
    ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:17.0pt'>
  <td width=175 style='width:131.6pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>NOMBRE:</span><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila['a_paterno']." ".$fila['a_materno']." ".$fila['nombre']?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:17.0pt'>
  <td width=175 style='width:131.6pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>RFC:</span><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=210 style='width:157.3pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila4['rfc'];?></o:p></span></p>
  </td>
  <td width=68 style='width:51.05pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-background-themecolor:
  background1;mso-background-themeshade:217;padding:0cm 5.4pt 0cm 5.4pt;
  height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  color:black;mso-color-alt:windowtext'>EDAD:</span><span style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=249 colspan=2 style='width:186.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $edad;?> A&Ntilde;OS</o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;height:17.0pt'>
  <td width=175 style='width:131.6pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>DEPENDENCIA:</span><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php
  
  
  echo $corporacion ;?></o:p></span></p>


  </td>
 </tr>
 <tr style='mso-yfti-irow:4;height:17.0pt'>
  <td width=175 style='width:131.6pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>CATEGORIA
  DE MANDO:</span><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila['categoria'];?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5;height:17.0pt'>
  <td width=175 style='width:131.6pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=right style='text-align:right'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>PUESTO
  ESPECIFICO:</span><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing><span style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila['categoria'];?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6;height:17.0pt'>
  <td width=702 colspan=5 style='width:526.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <p class=MsoNoSpacing align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  color:black;mso-color-alt:windowtext'>ESTE REPORTE ES ESTRICTAMENTE
  CONFIDENCIAL</span></b><b style='mso-bidi-font-weight:normal'><span
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";mso-fareast-language:ES'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes;height:17.0pt'>
  <td width=702 colspan=5 style='width:526.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:17.0pt'>
  <div style='mso-element:para-border-div;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 31.0pt 6.0pt 19.0pt'>


  <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>EVALUACIONES ANTERIORES:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    style='mso-spacerun:yes'></span><o:p><?php echo $fila6['evaluaciones_anteriores'];?></o:p></span></p>

    
  <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>TRAYECTORIA LABORAL:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    ></span><o:p><?php echo $fila6['trayectoria_laboral'];?></o:p></span></p>

<?php if($fila6['admision']!="" || $fila6['admision']!=null){?>

    <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>ADMISION:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    ></span><o:p><?php echo $fila6['admision'];?></o:p></span></p>
  <?php }?>

<?php if($fila6['observacion']!="" || $fila6['observacion']!=null){?>


    <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>OBSERVACION:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    ></span><o:p><?php echo $fila6['observacion'];?></o:p></span></p>

  <?php }?>


  <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>SITUACION PATRIMONIAL:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    ></span><o:p><?php echo $fila6["situacion_patrimonial"];?></o:p></span></p>


  <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>ANALISIS TECNICO:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    ></span><o:p><?php echo $fila6["analisis_tecnico"];?></o:p></span></p>


  <p class=MsoNormal style='text-align:justify;line-height:normal;
    padding:0cm;mso-padding-alt:0cm 31.0pt 6.0pt 19.0pt'><b
    style='mso-bidi-font-weight:normal'><span lang=ES style='font-size:12.0pt;
    mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;mso-bidi-font-family:
    "Times New Roman";mso-ansi-language:ES'>SINTESIS TECNICA:<br><o:p></o:p></span></b>
  <span
    lang=ES style='font-size:12.0pt;mso-bidi-font-size:10.0pt;font-family:"Tahoma",sans-serif;
    mso-bidi-font-family:"Times New Roman";mso-ansi-language:ES'><span
    ></span><o:p><?php echo $fila6["conclusion"];?></o:p></span></p>

  </div>
  </td>
 </tr>
<!--  <![if !supportMisalignedColumns]>
 <tr height=0>
  <td width=175 style='border:none'></td>
  <td width=210 style='border:none'></td>
  <td width=68 style='border:none'></td>
  <td width=121 style='border:none'></td>
  <td width=128 style='border:none'></td>
 </tr>
 <![endif]> -->
</table>



<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=234 valign=top style='width:175.45pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-background-themecolor:
  background1;mso-background-themeshade:217;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'>ELABOR&Oacute;<o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <td width=234 valign=top style='width:175.45pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#D9D9D9;mso-background-themecolor:background1;
  mso-background-themeshade:217;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>REVIS&Oacute;</span></span><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <td width=234 valign=top style='width:175.5pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#D9D9D9;mso-background-themecolor:background1;
  mso-background-themeshade:217;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-color-alt:windowtext'>AUTORIZ&Oacute;</span></span><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=234 valign=top style='width:175.45pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <td width=234 valign=top style='width:175.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><span
  style='mso-bookmark:tablaTotalHojas'></span>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <td width=234 valign=top style='width:175.5pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'><span
  style='mso-bookmark:tablaTotalHojas'></span>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaTotalHojas'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
 </tr>
 <?php
    ?>
 <tr style='mso-yfti-irow:2;mso-yfti-lastrow:yes;height:14.15pt'>
  <td width=234 style='width:175.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><a
  name=claveEvaluador><b style='mso-bidi-font-weight:normal'><span lang=ES-MX
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'>AP <?php echo $fila7["apeva"];?></span></b></a></span><span
  style='mso-bookmark:tablaTotalHojas'><b style='mso-bidi-font-weight:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <td width=234 style='width:175.45pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><a
  name=claveSupervisor><b style='mso-bidi-font-weight:normal'><span lang=ES-MX
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'>AP <?php $sql_re ="Select curp_supervisor from poligrafia_evnu where id_evaluacion = '$id_evaluacion'";
   $resultado_re = mysqli_query($conexion, $sql_re);
   $fila_re = mysqli_fetch_assoc($resultado_re);
   $ap = $fila_re['curp_supervisor'] ; 
   if ($ap == "LOMJ900927HGRPRS07") {
    echo "18";
   }else {
    echo "17";
   } ?></span></b></a></span><span
  style='mso-bookmark:tablaTotalHojas'><b style='mso-bidi-font-weight:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
  <td width=234 style='width:175.5pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><a
  name=claveCoordinador><b style='mso-bidi-font-weight:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'>AP 03</span></b></a></span><span
  style='mso-bookmark:tablaTotalHojas'><b style='mso-bidi-font-weight:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaTotalHojas'></span>
 </tr>
</table>
<p class=MsoNoSpacing><o:p>&nbsp;</o:p></p>

</div>

</body>

</html> 