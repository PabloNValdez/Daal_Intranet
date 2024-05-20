<?php

// Cargar la imagen del usuario
$userImage = new Imagick('292f0c1a-a244-4367-8926-9a22368b2b46.jpg');


// Escalar la imagen del usuario
$scaleX = 0.15071919949968732 * (1928/241);  // Escalar proporcionalmente al nuevo tamaño de marco
$scaleY = 0.15071919949968732 * (1928/241);  // Escalar proporcionalmente al nuevo tamaño de marco
$userImage->resizeImage($userImage->getImageWidth() * $scaleX, $userImage->getImageHeight() * $scaleY, Imagick::FILTER_LANCZOS, 1);

// Girar la imagen
$angleOfRotation = 0;
$userImage->rotateImage(new ImagickPixel('none'), $angleOfRotation);

// Crear un nuevo lienzo para el marco
$frame = new Imagick();

// Definir el tamaño del marco para que sea lo suficientemente grande para el recorte
$frameWidth = max(636 + 1928, $userImage->getImageWidth());
$frameHeight = max(164 + 1928, $userImage->getImageHeight());
$frame->newImage($frameWidth, $frameHeight, new ImagickPixel('transparent'));

// Posicionar la imagen del usuario en el lienzo
$posX = 109.06848030018762 * (1928/241);  // Escalar proporcionalmente al nuevo tamaño de marco
$posY = 19.999999999999986 * (1928/241);  // Escalar proporcionalmente al nuevo tamaño de marco
$frame->compositeImage($userImage, Imagick::COMPOSITE_DEFAULT, $posX, $posY);

// Recortar la imagen en el marco
$frame->cropImage(1928, 1928, 636, 164);

// Guardar la imagen como PNG
$frame->writeImage('path_to_output_image.png');

?>
