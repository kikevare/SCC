<?php
//header("Content-type: application/vnd.ms-word"); 
//header("Content-Disposition: attachment; filename=Reporte_Antecedentes.doc");
header("Content-type: application/vnd.ms-word");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=Indice.doc");

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
    $hoy = date('Y-m-d');
    $fecha = time() - strtotime($fila4['fecha_nac']);
    $edad = floor($fecha / 31556926);
    $sql6 = "SELECT reporte,hojagra,datosgen,hojapreg,proteccion,autorizacion,autorizacion_areas,antecedentes,entrevista,serie,hojacomen,alerta,revision,apeva,total from indice_polnu where id_evaluacion='$id_evaluacion'";
    $resultado6 = mysqli_query($conexion, $sql6);
    $fila6 = mysqli_fetch_assoc($resultado6);
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
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Jes�s Cardoso</o:Author>
  <o:LastAuthor>RMN</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>3</o:TotalTime>
  <o:Created>2020-09-29T14:50:00Z</o:Created>
  <o:LastSaved>2020-09-29T14:50:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>105</o:Words>
  <o:Characters>579</o:Characters>
  <o:Lines>4</o:Lines>
  <o:Paragraphs>1</o:Paragraphs>
  <o:CharactersWithSpaces>683</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
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
	mso-font-signature:-536869121 1107305727 33554432 0 415 0;}
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
	{font-family:IDAutomationHC39M;
	mso-font-alt:Calibri;
	mso-font-charset:0;
	mso-generic-font-family:modern;
	mso-font-pitch:fixed;
	mso-font-signature:-2147483645 64 0 0 1 0;}
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
	mso-fareast-language:EN-US;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-unhide:no;
	mso-style-link:"Encabezado Car";
	margin:0cm;
	mso-pagination:widow-orphan;
	tab-stops:center 220.95pt right 441.9pt;
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
	tab-stops:center 220.95pt right 441.9pt;
	font-size:11.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-bidi-font-family:"Times New Roman";
	mso-fareast-language:EN-US;}
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
	mso-style-link:"Texto de globo";
	mso-ansi-font-size:9.0pt;
	font-family:"Segoe UI",sans-serif;
	mso-ascii-font-family:"Segoe UI";
	mso-hansi-font-family:"Segoe UI";}
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
	{mso-footnote-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") fs;
	mso-footnote-continuation-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") fcs;
	mso-endnote-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") es;
	mso-endnote-continuation-separator:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") ecs;}
@page WordSection1
	{size:612.0pt 792.0pt;
	margin:42.55pt 42.55pt 42.55pt 42.55pt;
	mso-header-margin:35.45pt;
	mso-footer-margin:35.45pt;
	mso-even-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") eh1;
	mso-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") h1;
	mso-even-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") ef1;
	mso-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") f1;
	mso-first-header:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") fh1;
	mso-first-footer:url("http://10.24.2.25/controlconfianza/evaluaciones/poligrafiaNew/formatos/INDICE_archivos/header.htm") ff1;
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
 <o:shapedefaults v:ext="edit" spidmax="1026"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=ES link=blue vlink="#954F72" style='tab-interval:35.4pt'>

<div class=WordSection1>

<p class=MsoNoSpacing><span lang=ES-MX><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
line-height:107%;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>DEPARTAMENTO
DE POLIGRAF&Iacute;A</span></b><b style='mso-bidi-font-weight:normal'><span
lang=ES-MX style='font-size:10.0pt;line-height:107%;font-family:"Arial",sans-serif;
mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-MX style='font-family:"Arial",sans-serif;mso-bidi-font-family:
"Times New Roman"'>&Iacute;NDICE DE VERIFICACI&Oacute;N DEL EXPEDIENTE POLIGR&Aacute;FICO<o:p></o:p></span></b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>MOTIVO
  EVALUACI&Oacute;N:<o:p></o:p></span></p>
  </td>
  <td width=210 style='width:157.3pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><a name=motivoEvaCompleto><b style='mso-bidi-font-weight:
  normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  color:black;mso-color-alt:windowtext;mso-fareast-language:ES;mso-no-proof:
  yes'><?php echo $tipoe;?></span></b></a><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=189 colspan=2 style='width:5.0cm;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman";
  color:black;mso-color-alt:windowtext'>FECHA DE EVALUACI&Oacute;N:</span><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
  <td width=128 style='width:95.75pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
  background:#D9D9D9;mso-background-themecolor:background1;mso-background-themeshade:
  217;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><b style='mso-bidi-font-weight:normal'><span lang=ES-MX
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php
echo $fila['fecha'];
    ?></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>NOMBRE:<o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila['a_paterno']." ".$fila['a_materno']." ".$fila['nombre'] ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>SEXO:<o:p></o:p></span></p>
  </td>
  <td width=210 style='width:157.3pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila5['genero'] ?>
  </td>
  <td width=68 style='width:51.05pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>EDAD:<o:p></o:p></span></p>
  </td>
  <td width=249 colspan=2 style='width:186.45pt;border-top:solid windowtext 1.0pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;
  mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $edad?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>RFC:<o:p></o:p></span></p>
  </td>
  <td width=210 style='width:157.3pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila4['rfc'];?></o:p></span></p>
  </td>
  <td width=68 style='width:51.05pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>CURP:<o:p></o:p></span></p>
  </td>
  <td width=249 colspan=2 style='width:186.45pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $curp1;?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>DEPENDENCIA:<o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php
  
  
  
  
  
  echo $corporacion ;?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>CATEGOR&Iacute;A
  DE MANDO:<o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila['categoria'];?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6;mso-yfti-lastrow:yes;height:14.15pt'>
  <td width=175 style='width:131.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:
  10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>PUESTO
  ESPECIFICO:<o:p></o:p></span></p>
  </td>
  <td width=526 colspan=4 style='width:394.8pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.15pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php echo $fila['categoria'];?></o:p></span></p>
  </td>
 </tr>
 <![if !supportMisalignedColumns]>
 <tr height=0>
  <td width=175 style='border:none'></td>
  <td width=210 style='border:none'></td>
  <td width=68 style='border:none'></td>
  <td width=121 style='border:none'></td>
  <td width=128 style='border:none'></td>
 </tr>
 <![endif]>
</table>

<p class=MsoNoSpacing><span lang=ES-MX style='font-size:7.0pt;mso-bidi-font-size:
10.0pt'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
line-height:107%;font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>COMPLETO<o:p></o:p></span></b></p>

<p class=MsoNoSpacing><a name=tablaIndiceDocumentos><span lang=ES-MX
style='font-size:6.0pt;mso-bidi-font-size:10.0pt'><o:p>&nbsp;</o:p></span></a></p>

<table class=TableGrid1 border=0 cellspacing=0 cellpadding=0 width="84%"
 style='width:84.76%;margin-left:49.4pt;border-collapse:collapse;border:none;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 0cm 0cm 0cm;mso-border-insideh:none;
 mso-border-insidev:none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:19.85pt'>
  <td width="51%" style='width:51.1%;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><b style='mso-bidi-font-weight:
  normal'><span lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;
  font-family:"Arial",sans-serif;mso-bidi-font-family:"Times New Roman"'>FORMATOS
  DE EVALUACI&Oacute;N<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'>SI<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'>NO<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p>&nbsp;</o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'>NO. HOJAS<o:p></o:p></span></b></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:1;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>1. REPORTE</span></span><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6['reporte']>=1){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6['reporte']==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><o:p><?php echo $fila6['reporte'];?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:2;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>2. HOJA DE
  CALIFICACI&Oacute;N DE GR&Aacute;FICOS</span></span><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6['hojagra']>=1){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6['hojagra']==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><o:p><?php echo $fila6['hojagra'];?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:3;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>3. HOJA DE PREGUNTAS</span></span><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["hojapreg"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["hojapreg"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["hojapreg"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:4;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>4. DATOS GENERALES</span></span><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["datosgen"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["datosgen"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["datosgen"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:5;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>5. PROTECCI&Oacute;N DE DATOS</span></span><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["proteccion"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["proteccion"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["proteccion"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:6;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>6. AUTORIZACI&Oacute;N DE
  EXAMEN</span></span><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["autorizacion"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["autorizacion"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["autorizacion"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:7;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>7. AUTORIZACI&Oacute;N DE
  AREAS</span></span><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["autorizacion_areas"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["autorizacion_areas"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["autorizacion_areas"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:8;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>8. ANTECEDENTES
  PERSONALES</span></span><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["antecedentes"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["antecedentes"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["antecedentes"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:9;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>9. ENTREVISTA</span></span><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["entrevista"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["entrevista"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["entrevista"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:10;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>10. SERIE DE GRAFICOS</span></span><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["serie"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["serie"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><o:p><?php echo $fila6["serie"];?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:11;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>11. HOJA DE
  COMENTARIOS</span></span><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><?php if($fila6["hojacomen"]>=1){ echo "X";}?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["hojacomen"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p>&nbsp;</o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["hojacomen"];?><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:12;mso-yfti-lastrow:yes;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>12. ALERTA DE RIESGO<o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["alerta"]>=1){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["alerta"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><o:p><?php echo $fila6["alerta"];?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
 <tr style='mso-yfti-irow:12;mso-yfti-lastrow:yes;height:19.85pt'>
  <td width="51%" style='width:51.1%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'>
  <p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
  style='mso-bookmark:tablaIndiceDocumentos'><span lang=ES-MX style='font-size:
  9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'>13. REVISION DE ANTECEDENTES<o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["revision"]>=1){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="9%" style='width:9.54%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p><?php if($fila6["revision"]==0){ echo "X";}?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="6%" style='width:6.34%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:19.85pt'><span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
  <td width="17%" style='width:17.14%;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:19.85pt'><span
  style='mso-bookmark:tablaIndiceDocumentos'></span>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaIndiceDocumentos'><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman";color:black;mso-fareast-language:ES'><o:p><?php echo $fila6["revision"];?></o:p></span></span></p>
  </td>
  <span style='mso-bookmark:tablaIndiceDocumentos'></span>
 </tr>
</table>

<p class=MsoNormal style='margin-bottom:0cm;line-height:normal'><span
style='mso-bookmark:tablaIndiceDocumentos'></span><span style='mso-bookmark:
tablaIndiceDocumentos'><span lang=ES-MX style='font-size:6.0pt;mso-bidi-font-size:
10.0pt'><o:p>&nbsp;</o:p></span></span></p>

<span style='mso-bookmark:tablaIndiceDocumentos'></span>

<p class=MsoNormal><span lang=ES-MX style='font-size:6.0pt;mso-bidi-font-size:
10.0pt;line-height:107%'><o:p>&nbsp;</o:p></span></p>

<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width="84%"
 style='width:84.72%;margin-left:49.4pt;border-collapse:collapse;border:none;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
 none;mso-border-insidev:none'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes;
  height:19.85pt'>
  <td width="82%" style='width:82.66%;border:none;border-right:solid windowtext 1.0pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:19.85pt'>
  <p class=MsoNormal align=right style='margin-bottom:0cm;text-align:right;
  line-height:normal'><span class=GramE><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'>TOTAL</span></span><span lang=ES-MX style='font-size:9.0pt;
  mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman"'> DE HOJAS <o:p></o:p></span></p>
  </td>
  <td width="17%" style='width:17.34%;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:19.85pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><a name=iTotalHojas><span lang=ES-MX style='font-size:
  8.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;mso-bidi-font-family:
  "Times New Roman";color:black;mso-fareast-language:ES'><?php echo $fila6["total"];?></span></a><span
  lang=ES-MX style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'><o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal><span lang=ES-MX style='font-size:6.0pt;mso-bidi-font-size:
10.0pt;line-height:107%'><o:p>&nbsp;</o:p></span></p>





<p class=MsoNoSpacing><span style='mso-bookmark:tablaTotalHojas'><span
lang=ES-MX style='font-size:6.0pt;mso-bidi-font-size:10.0pt'><o:p>&nbsp;</o:p></span></span></p>

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
 
 <tr style='mso-yfti-irow:2;mso-yfti-lastrow:yes;height:14.15pt'>
  <td width=234 style='width:175.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;text-align:center;
  line-height:normal'><span style='mso-bookmark:tablaTotalHojas'><a
  name=claveEvaluador><b style='mso-bidi-font-weight:normal'><span lang=ES-MX
  style='font-size:9.0pt;mso-bidi-font-size:10.0pt;font-family:"Arial",sans-serif;
  mso-bidi-font-family:"Times New Roman"'>AP <?php echo $fila6["apeva"];?></span></b></a></span><span
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
   } ?> </span></b></a></span><span
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

<span style='mso-bookmark:tablaTotalHojas'></span>

<p class=MsoNormal style='margin-bottom:0cm'><span lang=ES-MX style='font-size:
1.0pt;mso-bidi-font-size:10.0pt;line-height:107%'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>
