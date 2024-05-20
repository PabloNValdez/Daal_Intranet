<?php
// Ejemplo de uso
$texto = "Joan";
$anchoArea = 618;
$altoArea = 152;
$rutaImagenSalida = "textoinferior.png";
$color = '#000000';  // Puedes cambiar el color según tus necesidades
$fuente = 'Allura-Regular.ttf';  // Especifica la ruta de tu fuente
$tamanoFuente = 250;
generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente,$rutaImagenSalida,  $color);



// Ruta de las imágenes
$rutaImagenBase = 'textoBase.png';
$rutaImagenSuperior = 'textoinferior.png';

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
$rutaImagenResultante = 'final_texto_inferior.png';
$imagenBase->writeImage($rutaImagenResultante);

// Libera los recursos
$imagenBase->destroy();
$imagenSuperior->destroy();


function generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
{
    $imagen = new Imagick();
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();
    $draw->setFont("$fuente");

    // Tamaño de fuente máximo permitido
    $tamanoFuenteMaximo = 250;

    // Inicializar el tamaño de fuente al máximo
    $tamanoFuente = $tamanoFuenteMaximo;

    // Bucle para encontrar el tamaño de fuente adecuado
    do {
        $draw->setFontSize($tamanoFuente);
        $boundingBox = $imagen->queryFontMetrics($draw, $texto);
        $textoAncho = $boundingBox['textWidth'];
        $textoAlto = $boundingBox['textHeight'];

        $tamanoFuente--;

    } while ($tamanoFuente > 0 && ($textoAlto > $altoArea || $textoAncho > $anchoArea));

    // Calcular la posición vertical para centrar el texto
    $posicionVertical = ($altoArea - $textoAlto) / 2;

    // Calcular la posición horizontal para centrar el texto
    $posicionHorizontal = ($anchoArea - $textoAncho) / 2;

    // Establecer el color del texto
    $draw->setFillColor($colorTexto);

    // Dividir el texto en líneas
    $lineas = explode("\n", $texto);

    // Calcular la posición vertical inicial
    $posicionVerticalActual = $posicionVertical + $boundingBox['ascender'];

    // Anotar la imagen con el texto centrado
    foreach ($lineas as $linea) {
        $boundingBox = $imagen->queryFontMetrics($draw, $linea);
        $imagen->annotateImage($draw, $posicionHorizontal, $posicionVerticalActual, 0, $linea);
        $posicionVerticalActual += $boundingBox['textHeight'];
    }

    // Recortar la imagen para eliminar los espacios en blanco alrededor del texto
    $imagen->trimImage(0);


    // Guardar la nueva imagen
    $imagen->writeImage($rutaGuardado);

    
}
