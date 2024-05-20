<?php
// CREA LA LA INICIAL SUPERIOR
$texto = "Z";
$anchoArea = 772.5;
$altoArea = 887.5;
$rutaImagenSalida = "texto43.png";
$color = '#FEBE95';  // Puedes cambiar el color según tus necesidades
$fuente = 'fuente/FredokaOne-Regular.ttf';  // Especifica la ruta de tu fuente
$tamanoFuenteMaximo = 1000;
generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaImagenSalida,  $color,$tamanoFuenteMaximo);

//CREAMOS TEXTO INFERIOR
$texto = "Zaira Camila Fernandez";
$anchoArea = 618;
$altoArea = 152;
$rutaImagenSalida = "textoinferior.png";
$color = '#000000';  // Puedes cambiar el color según tus necesidades
$fuente = 'fuente/GloriaHallelujah-Regular.ttf';  // Especifica la ruta de tu fuente
$tamanoFuenteMaximo = 250;
generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente,$rutaImagenSalida,  $color,$tamanoFuenteMaximo);


// Ruta de las imágenes
$rutaImagenBase = 'bases/textoBase.png';
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


// TEXTO IZQUIERDA
$rutaImagenBase = 'bases/taza.png';
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









function generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto, $tamanoFuenteMaximo)
{
    $imagen = new Imagick();

    // Crear una nueva imagen con fondo opaco (por ejemplo, blanco)
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('white'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();
    $draw->setFont($fuente);


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
    $draw->setTextAntialias(true); // Habilitar anti-aliasing


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

    $resolucionDPI = 300; // Puedes ajustar según tus necesidades
    $imagen->setImageResolution($resolucionDPI, $resolucionDPI);

    // Recortar la imagen para eliminar los espacios en blanco alrededor del texto
    $imagen->trimImage(0);

    // Mejorar la calidad de la imagen
    $imagen->setImageCompressionQuality(100);

    // Guardar la nueva imagen
    $imagen->writeImage($rutaGuardado);

    // Destruir el objeto Imagick
    $imagen->destroy();
}

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