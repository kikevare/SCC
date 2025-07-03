<?php
session_start();
///obiente la ruta completa donde se almacena la imagen
function getFullUrl_1() {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
      	return
    		($https ? 'https://' : 'http://').
    		(!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
    		(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
    		($https && $_SERVER['SERVER_PORT'] === 443 ||
    		$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
    		"/controlconfianza/Archivo/DeptoESocial/documental/documentos/".$_SESSION["xCurp"];
    }

 //-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
 //-------------------------------------------------------------//
include_once($xPath."includes/xsystem.php");
$xSys = New System();
$xUsr = New Usuario(); 
//ruta completa donde se almacena la imagen con funciones del sice   
$ruta1      = $xPath."Archivo/DeptoESocial/documental/documentos/".$_SESSION["xCurp"]."/";
//rtua donde se almacena el thumbail  con funciones del sice 
$ruta2      = $xPath."Archivo/DeptoESocial/documental/documentos/".$_SESSION["xCurp"]."/thumbnails/";
//ruta completa donde se almacena la imagen con funcion getFullUrl_1()
$ruta3      = getFullUrl_1().'/';


if( !is_dir($ruta1) ){//Si la carpeta de la persona no existe, entonces la crea...
		if( !mkdir($ruta1, 0777)  ){
         echo "No se pudo crear la carpeta...";
         exit();
      }
}
if( !is_dir($ruta2) ){//Si la carpeta thumbail  no existe, entonces la crea...
		if( !mkdir($ruta2, 0777)  ){
         echo "No se pudo crear la carpeta...";
         exit();
      }
}

$options= NULL;
require('upload.class.php');
$upload_handler = new UploadHandler($options,$ruta1,$ruta3);

header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'OPTIONS':
        break;
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            $upload_handler->delete();
        } else {
            $upload_handler->post();
        }
        break;
    case 'DELETE':
        $upload_handler->delete();
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
}


