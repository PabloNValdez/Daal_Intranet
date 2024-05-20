<?php

// Ruta del archivo SVG
$rutaSVG = '407-1787054-4771508_31025891732642/744a8e35-021f-23d4-17cc-21b1402b5211.svg';

// Crear una nueva instancia de Imagick
$imagen = new Imagick();

// Leer el archivo SVG
$imagen->readImage($rutaSVG);

// Convertir el formato a PNG
$imagen->setImageFormat('png');

// Ruta de guardado para la imagen PNG
$rutaPNG = 'imagen-no-svg.png';

// Guardar la imagen PNG
$imagen->writeImage($rutaPNG);

// Liberar recursos
$imagen->destroy();

// Verificar si la conversión fue exitosa
if (file_exists($rutaPNG)) {
    echo 'La conversión fue exitosa. La imagen PNG se guardó en: ' . $rutaPNG;
} else {
    echo 'Hubo un error durante la conversión.';
}

?>
