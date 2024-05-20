<?php
require '../vendor/autoload.php';
use JsonPath\JsonObject;
$rutaJson = "31678415209322.json";

leerJSON($rutaJson);
function leerJSON($json)
{

    $json = file_get_contents($json);
    $datos = json_decode($json, true);
    $jsonObject = new JsonObject($datos);
    /* $titulo = $jsonObject->get('$..children[?(@.label=="Título de la canción")].inputValue');
    if (@$titulo[0] == "") {
        $titulo = $jsonObject->get('$..children[?(@.label=="Título de la Canción")].inputValue');
    }
    //echo $titulo[0] . "<br>";
    $artista = $jsonObject->get('$..children[?(@.label=="Artista/s de la canción")].inputValue');
    if (@$artista[0] == "") {
        $artista = $jsonObject->get('$..children[?(@.label=="Artista(s) de la Canción")].inputValue');
    }
    //echo $artista[0] . "<br>";
    $urlSpotify = $jsonObject->get('$..children[?(@.label=="Url Spotify")].inputValue'); */
    $orderId = $jsonObject->get('$..orderId');
    $orderItemId = $jsonObject->get('$..orderItemId');
    $imageName = $jsonObject->get('$..image.imageName');
    $buyerFilename = $jsonObject->get('$..image.buyerFilename');
    $frameWidth = $jsonObject->get('$..dimension.width');
    $frameHeight = $jsonObject->get('$..dimension.height');
    $frameX = $jsonObject->get('$..position.x');
    $frameY = $jsonObject->get('$..position.y');
    $imageWidth = $jsonObject->get('$..buyerPlacement.dimension.width');
    $imageHeight = $jsonObject->get('$..buyerPlacement.dimension.height');
    $imageX = $jsonObject->get('$..buyerPlacement.position.x');
    $imageY = $jsonObject->get('$..buyerPlacement.position.y');
    $scaleX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
    $scaleY = $jsonObject->get('$..buyerPlacement.scale.scaleY');
    $angleOfRotation = $jsonObject->get('$..buyerPlacement.angleOfRotation');

    $pedido = $orderId[0];

    //$rootPath = 'data/' . $datetime_str; // Definición de la variable global

    $urlCliente = $imageName[0];

    // Datos de prueba
    $userImagePath = $urlCliente;
    $outputPath = 'felpudo-recortada.png';
    $scaleX = $scaleX[0] * (2756 / 400);  // Escalar proporcionalmente al nuevo tamaño de marco
    $scaleY = $scaleY[0] * (2076 / 399);  // Escalar proporcionalmente al nuevo tamaño de marco
    $angleOfRotation = $angleOfRotation[0];
    $userImagePos = array(
        'x' => $imageX[0] * (2756 / 400),  // Escalar proporcionalmente al nuevo tamaño de marco
        'y' => $imageY[0] * (2076 / 399)  // Escalar proporcionalmente al nuevo tamaño de marco
    );
    $cropPos = array(
        'x' => 224,
        'y' => 696
    );
    $cropSize = array(
        'width' => 2756,
        'height' => 2076
    );
    crearCortarImagen($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize);
    CrearFelpudo();

}


function CrearFelpudo()
{
    try {
        $imagenBase = new Imagick('felpudo.png');
        $imagenSuperior = new Imagick('felpudo-recortada.png');
        // Coordenadas y dimensiones de la imagen superior
        $coordenadas_imagen = ['x' => 0, 'y' => 0, 'w' => 3602, 'h' => 2008];
        // Redimensiona y coloca la imagen superior
        colocarImagen($imagenBase, $imagenSuperior, $coordenadas_imagen);
        // Anota la canción y el artista
        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage('felpudo-final.png');
        echo "Felpudo creada correctamente";
    } catch (ImagickException $e) {
        echo "Error al guardar la imagen: ',  $e->getMessage(),";
    }
}
function colocarImagen($imagenBase, $imagen, $coordenadas)
{
    $imagen->scaleImage($coordenadas['w'], $coordenadas['h'], true);
    $centerX = $coordenadas['x'] + ($coordenadas['w'] - $imagen->getImageWidth()) / 2;
    $centerY = $coordenadas['y'] + ($coordenadas['h'] - $imagen->getImageHeight()) / 2;
    $imagenBase->compositeImage($imagen, Imagick::COMPOSITE_DEFAULT, $centerX, $centerY);
}
function crearCortarImagen($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize)
{
    try {
        // Cargar la imagen del usuario
        $userImage = new Imagick($userImagePath);

        // Leer los metadatos EXIF de la imagen para obtener la orientación
        $exifRotationApplied = false;

        // Guardar la imagen con escala
        $userImage->resizeImage($userImage->getImageWidth() * $scaleX, $userImage->getImageHeight() * $scaleY, Imagick::FILTER_LANCZOS, 1);
        $userImage->writeImage($outputPath . '1_scaled.jpg');

        // Crear un nuevo lienzo para el marco
        $frame = new Imagick();

        // Definir el tamaño del marco para que sea lo suficientemente grande para el recorte
        $frameWidth = max($cropPos['x'] + $cropSize['width'], $userImage->getImageWidth());
        $frameHeight = max($cropPos['y'] + $cropSize['height'], $userImage->getImageHeight());
        $frame->newImage($frameWidth, $frameHeight, new ImagickPixel('transparent'));

        // Posicionar la imagen del usuario en el lienzo
        $frame->compositeImage($userImage, Imagick::COMPOSITE_DEFAULT, $userImagePos['x'], $userImagePos['y']);
        $frame->writeImage($outputPath . '2_positioned.jpg');

        // Recortar la imagen en el marco
        $frame->cropImage($cropSize['width'], $cropSize['height'], $cropPos['x'], $cropPos['y']);
        $frame->writeImage($outputPath . '3_cropped.jpg');

        // Guardar la imagen como PNG
        $frame->writeImage($outputPath);
    } catch (ImagickException $e) {
        // Aquí debes manejar las excepciones de Imagick como consideres apropiado
        // Por ejemplo, puedes registrar el error en un archivo log
    } catch (Exception $e) {
        // Aquí debes manejar las demás excepciones como consideres apropiado
        // Por ejemplo, puedes registrar el error en un archivo log
    }
}
