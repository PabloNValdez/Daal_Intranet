<?php

// Ruta de las imágenes
$rutaImagenBase = 'base.png';
$rutaImagenSuperior = 'texto43.png';

// Carga las imágenes con Imagick
$imagenBase = new \Imagick($rutaImagenBase);
$imagenSuperior = new \Imagick($rutaImagenSuperior);

// Obtén dimensiones de ambas imágenes
$anchoBase = $imagenBase->getImageWidth();
$altoBase = $imagenBase->getImageHeight();

$anchoSuperior = $imagenSuperior->getImageWidth();
$altoSuperior = $imagenSuperior->getImageHeight();

// Calcula la escala necesaria
$escalaAncho = $anchoBase / $anchoSuperior;
$escalaAlto = $altoBase / $altoSuperior;

// Elige la escala mínima para que la imagen superior se ajuste completamente
$escala = min($escalaAncho, $escalaAlto);

// Redimensiona la imagen superior
$imagenSuperior->scaleImage($anchoSuperior * $escala, $altoSuperior * $escala);

// Calcula las coordenadas para centrar la imagen superior en la imagen base
$x = ($anchoBase - $imagenSuperior->getImageWidth()) / 2;
$y = ($altoBase - $imagenSuperior->getImageHeight()) / 2;

// Composición de las imágenes
$imagenBase->compositeImage($imagenSuperior, \Imagick::COMPOSITE_OVER, $x, $y);

// Guarda la imagen resultante
$rutaImagenResultante = 'imagen_resultante.png';
$imagenBase->writeImage($rutaImagenResultante);

// Libera los recursos
$imagenBase->destroy();
$imagenSuperior->destroy();

?>
