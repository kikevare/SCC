<?php
session_start();
 //-------------------------------------------------------------//
$xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
 //-------------------------------------------------------------//
 

// RUTA DONDE SE ALMACENARAN LAS IMAGENES DE LOS PERFILES
$ruta= $xPath."Archivo/Fotografias/".$_SESSION["xCurp"]."/";
if( !is_dir($ruta) ){//Si la carpeta de la persona no existe, entonces la crea...
		if( !mkdir($ruta, 0777)  ){
         echo "No se pudo crear la carpeta...";
         exit();
      }
}


// Definimos variables generales
//define("maxUpload", 80000);
define("maxWidth", 189);
define("maxHeight", 252);
//define("uploadURL", 'images/');
//define("fileName", 'foto_');

$tipo_perfil= $_GET["p"];
$id_eval= $_GET["id_eval"];

// Tipos MIME
//$fileType = array('image/jpeg','image/pjpeg','image/png');

// Bandera para procesar imagen
//$pasaImgSize = false;

//bandera de error al procesar la imagen
//$respuestaFile = false;

// nombre por default de la imagen a subir
//$fileName = '';
// error del lado del servidor
$mensajeFile = 'ERROR EN EL SCRIPT';

// Obtenemos los datos del archivo
$tamanio = $_FILES['userfile']['size'];
$tipo = $_FILES['userfile']['type'];
$archivo = $_FILES['userfile']['name'];

// Tamaño de la imagen
$imageSize = getimagesize($_FILES['userfile']['tmp_name']);
						
// Verificamos la extensión del archivo independiente del tipo mime
//$extension = explode('.',$_FILES['userfile']['name']);
$extension = end(explode(".",strtolower(trim($_FILES["userfile"]["name"])))); 
//Extensiones validas
$extensiones = array("jpg","jpeg","gif","png"); 

//$num = count($extension)-1;


// Creamos el nombre del archivo dependiendo la opción
$imgFile = fileName.mktime().'.'.$extension[$num];

// Verificamos el tamaño válido para los logotipos
if($imageSize[0] <= maxWidth && $imageSize[1] <= maxHeight)
	$pasaImgSize = true;

// Verificamos el status de las dimensiones de la imagen a publicar
//if($pasaImgSize == true)
//{

	// Verificamos Tamaño y extensiones
	if( $tamanio>1 )
	{
		// Verificamos extensiones
		 if(in_array($extension,$extensiones)){ 
		 		if($extension == "jpg" || $ext == "jpeg"){ 
                    $image = imagecreatefromjpeg($_FILES['userfile']['tmp_name']);
                } 
                else if($extension == "gif"){ 
                    $image = imagecreatefromgif($_FILES['userfile']['tmp_name']); 
                } 
                else if($extension == "png"){ 
                    $image = imagecreatefrompng($_FILES['userfile']['tmp_name']); 
                } 
				// Obtiene el width and height de la imagen
                list($width,$height) = getimagesize($_FILES['userfile']['tmp_name']); 
				//Se asignan nuevos tamaños
				if($width > maxWidth){ 
                        $newwidth = maxWidth; 
                } else { 
                        $newwidth = $width; 
                } 
				$newheight = maxHeight;
				// Crea imagen temporal. 
                $tmp = imagecreatetruecolor($newwidth,$newheight); 
                // Copia la imagen con nuevo width and height. 
                imagecopyresampled($tmp,$image,0,0,0,0,$newwidth,$newheight,$width,$height); 
                
				// ruta y nombre de la imagen
				$filenamepath = $ruta.$_SESSION["xCurp"].$tipo_perfil.$id_eval.".jpg"; 
				if(is_file($filenamepath))
				 unlink($filenamepath);
                // Crea la imagen . 
                imagejpeg($tmp,$filenamepath,100); 
				imagedestroy($image); 
                imagedestroy($tmp); 
				$respuestaFile = 'done';
				$fileName = $filenamepath;
				$mensajeFile = $fileName;
				
		 }
		 else { 
            $mensajeFile="Tipo de imagen invalido. Solo se permiten imagenes(jpg, jpeg, gif, png)."; 
        } 
		
		/*
		// Intentamos copiar el archivo
		if(is_uploaded_file($_FILES['userfile']['tmp_name']))
		{
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], uploadURL.$imgFile))
			{
				$respuestaFile = 'done';
				$fileName = $imgFile;
				$mensajeFile = $imgFile;
			}
			else
				// error del lado del servidor
				$mensajeFile = 'No se pudo subir el archivo';
		}
		else
			// error del lado del servidor
			$mensajeFile = 'No se pudo subir el archivo';*/
	}
	else
		// Error en el tamaño y tipo de imagen
		$mensajeFile = 'Verifique el tamaño de la imagen';
					
//}
//else
	// Error en las dimensiones de la imagen
	//$mensajeFile = 'Verifique las dimensiones de la Imagen';

$salidaJson = array("respuesta" => $respuestaFile,
					"mensaje" => $mensajeFile,
					"fileName" => $fileName);

echo json_encode($salidaJson);
?>