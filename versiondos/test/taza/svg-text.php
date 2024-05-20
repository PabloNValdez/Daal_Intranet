<?php

// Ruta del archivo SVG
$svgPath = '407-1787054-4771508_31025891732642/744a8e35-021f-23d4-17cc-21b1402b5211.svg';

// Leer el contenido del SVG
$svgContent = file_get_contents($svgPath);

$im = new Imagick();
$im->readImageBlob($svgContent);
$im->setImageFormat("png");

// Guardar la imagen en el servidor
$im->writeImage("hello.png");

// Limpiar memoria
$im->clear();
$im->destroy();

echo "SVG convertido a PNG con éxito.";

?>

