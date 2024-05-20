<?php

function superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea) {
    // Carga las imágenes con Imagick
    $imagenBase = new \Imagick($rutaImagenBase);
    $imagenSuperior = new \Imagick($rutaImagenSuperior);

    // Obtén dimensiones de ambas imágenes
    $anchoBase = $imagenBase->getImageWidth();
    $altoBase = $imagenBase->getImageHeight();

    $anchoSuperior = $imagenSuperior->getImageWidth();
    $altoSuperior = $imagenSuperior->getImageHeight();

    // Calcula las coordenadas para posicionar el área
    $x = min(max(0, $x), $anchoBase - $anchoArea);
    $y = min(max(0, $y), $altoBase - $altoArea);

    // Redimensiona la imagen superior para que se ajuste al área
    $escalaAncho = $anchoArea / $anchoSuperior;
    $escalaAlto = $altoArea / $altoSuperior;
    $escala = min($escalaAncho, $escalaAlto);

    $imagenSuperior->scaleImage($anchoSuperior * $escala, $altoSuperior * $escala);

    // Calcula las coordenadas para centrar la imagen superior en el área
    $xSuperior = $x + ($anchoArea - $imagenSuperior->getImageWidth()) / 2;
    $ySuperior = $y + ($altoArea - $imagenSuperior->getImageHeight()) / 2;

    // Composición de las imágenes
    $imagenBase->compositeImage($imagenSuperior, \Imagick::COMPOSITE_OVER, $xSuperior, $ySuperior);
    $imagenBase->setImageCompressionQuality(100);
    // Guarda la imagen resultante
    $rutaImagenResultante = 'taza_final.png';
    $imagenBase->writeImage($rutaImagenResultante);

    // Libera los recursos
    $imagenBase->destroy();
    $imagenSuperior->destroy();

    return $rutaImagenResultante;
}

// TEXO IZQUIERDA
$rutaImagenBase = 'taza.png';
$rutaImagenSuperior = 'texto43.png';
$x = 49; // Coordenada x
$y = 25; // Coordenada y

$anchoArea = 309; // Ancho del área
$altoArea = 355; // Alto del área

$rutaResultado = superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea);

// TEXTO DERECHA
$rutaImagenBase = 'taza_final.png';
$rutaImagenSuperior = 'texto43.png';
$x = 824; // Coordenada x
$y = 25; // Coordenada y

$anchoArea = 309; // Ancho del área
$altoArea = 355; // Alto del área

$rutaResultado = superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea);



// TEXTO INFERIOR IZQUIERDA
$rutaImagenBase = 'taza_final.png';
$rutaImagenSuperior = 'final_texto_inferior.png';
$x = 49; // Coordenada x
$y = 402; // Coordenada y

$anchoArea = 309; // Ancho del área
$altoArea = 76; // Alto del área

$rutaResultado = superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea);
// Puedes utilizar $rutaResultado como la ruta de la imagen resultante o realizar otras operaciones con ella.

// TEXTO INFERIOR DERECHA
$rutaImagenBase = 'taza_final.png';
$rutaImagenSuperior = 'final_texto_inferior.png';
$x = 824; // Coordenada x
$y = 402; // Coordenada y

$anchoArea = 309; // Ancho del área
$altoArea = 76; // Alto del área

$rutaResultado = superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea);
// Puedes utilizar $rutaResultado como la ruta de la imagen resultante o realizar otras operaciones con ella.

?>
