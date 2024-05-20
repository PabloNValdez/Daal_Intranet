<?php
require '../vendor/autoload.php';
use JsonPath\JsonObject;
$json = file_get_contents('52774104656099.json');
    // Decodifica el JSON a un objeto PHP
    $datos = json_decode($json, true);
    // Crear un nuevo objeto JsonObject con los datos
    $jsonObject = new JsonObject($datos);
$imageName = $jsonObject->get('$..image.imageName');
echo "Imagen: " . $imageName[0] . "<br>";

$buyerFilename = $jsonObject->get('$..image.buyerFilename');
echo "Archivo del comprador: " . $buyerFilename[0] . "<br>";

$frameWidth = $jsonObject->get('$..dimension.width');
echo "Ancho del marco: " . $frameWidth[0] . "<br>";

$frameHeight = $jsonObject->get('$..dimension.height');
echo "Alto del marco: " . $frameHeight[0] . "<br>";

$frameX = $jsonObject->get('$..position.x');
echo "Posición X del marco: " . $frameX[0] . "<br>";

$frameY = $jsonObject->get('$..position.y');
echo "Posición Y del marco: " . $frameY[0] . "<br>";

$imageWidth = $jsonObject->get('$..buyerPlacement.dimension.width');
echo "Ancho de la imagen: " . $imageWidth[0] . "<br>";

$imageHeight = $jsonObject->get('$..buyerPlacement.dimension.height');
echo "Alto de la imagen: " . $imageHeight[0] . "<br>";

$imageX = $jsonObject->get('$..buyerPlacement.position.x');
echo "Posición X de la imagen: " . $imageX[0] . "<br>";

$imageY = $jsonObject->get('$..buyerPlacement.position.y');
echo "Posición Y de la imagen: " . $imageY[0] . "<br>";

$scaleX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
echo "Escala X de la imagen: " . $scaleX[0] . "<br>";

$scaleY = $jsonObject->get('$..buyerPlacement.scale.scaleY');
echo "Escala Y de la imagen: " . $scaleY[0] . "<br>";

$angleOfRotation = $jsonObject->get('$..buyerPlacement.angleOfRotation');
echo "Ángulo de rotación: " . $angleOfRotation[0] . "<br>";

function createCroppedImage($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize) {
    // Cargar la imagen del usuario
    $userImage = new Imagick($userImagePath);

    // Escalar la imagen del usuario
    $userImage->resizeImage($userImage->getImageWidth() * $scaleX, $userImage->getImageHeight() * $scaleY, Imagick::FILTER_LANCZOS, 1);

    // Girar la imagen
    $userImage->rotateImage(new ImagickPixel('none'), $angleOfRotation);

    // Crear un nuevo lienzo para el marco
    $frame = new Imagick();

    // Definir el tamaño del marco para que sea lo suficientemente grande para el recorte
    $frameWidth = max($cropPos['x'] + $cropSize['width'], $userImage->getImageWidth());
    $frameHeight = max($cropPos['y'] + $cropSize['height'], $userImage->getImageHeight());
    $frame->newImage($frameWidth, $frameHeight, new ImagickPixel('transparent'));

    // Posicionar la imagen del usuario en el lienzo
    $frame->compositeImage($userImage, Imagick::COMPOSITE_DEFAULT, $userImagePos['x'], $userImagePos['y']);

    // Recortar la imagen en el marco
    $frame->cropImage($cropSize['width'], $cropSize['height'], $cropPos['x'], $cropPos['y']);

    // Guardar la imagen como PNG
    $frame->writeImage($outputPath);
}

// Datos de prueba
$userImagePath = $imageName[0];
$outputPath = '_image.png';
$scaleX = $scaleX[0] * (1928/241);  // Escalar proporcionalmente al nuevo tamaño de marco
$scaleY = $scaleY[0] * (1928/241);  // Escalar proporcionalmente al nuevo tamaño de marco
$angleOfRotation = $angleOfRotation[0];
$userImagePos = array(
    'x' => $imageX[0] * (1928/241),  // Escalar proporcionalmente al nuevo tamaño de marco
    'y' => $imageY[0] * (1928/241)  // Escalar proporcionalmente al nuevo tamaño de marco
);
$cropPos = array(
    'x' => 636,
    'y' => 164
);
$cropSize = array(
    'width' => 1928,
    'height' => 1928
);

// Uso de la función
createCroppedImage($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize);

?>

