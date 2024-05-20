<?php

// function generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
// {
//     $imagen = new Imagick();
//     $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
//     $imagen->setImageFormat('png');

//     $draw = new ImagickDraw();
//     $draw->setFont("$fuente");

//     // Inicializar el tamaño de fuente al 90% del alto del área, puedes ajustar este valor
//     $fontSize = 465;

//     // Calcular el tamaño de fuente máximo para ajustarse al área
//     do {
//         $draw->setFontSize($fontSize);
//         $boundingBox = $imagen->queryFontMetrics($draw, $texto);
//         $textoAncho = $boundingBox['textWidth'];
//         $textoAlto = $boundingBox['textHeight'];
//         // Puedes ajustar el valor de la reducción para aumentar más rápidamente el tamaño
//         $fontSize -= 0.5; // Puedes ajustar este valor según tus necesidades
//     } while ($textoAlto > $altoArea || $textoAncho > $anchoArea);

//     // Calcular la posición vertical para centrar el texto
//     $posicionVertical = ($altoArea - $textoAlto) / 2;

//     // Calcular la posición horizontal para centrar el texto
//     $posicionHorizontal = ($anchoArea - $textoAncho) / 2;

//     // Establecer el color del texto
//     $draw->setFillColor($colorTexto);

//     // Dividir el texto en líneas
//     $lineas = explode("\n", $texto);

//     // Calcular el espacio entre las líneas
//     $espacioEntreLineas = $textoAlto / count($lineas);

//     // Calcular la posición vertical inicial
//     $posicionVerticalActual = $posicionVertical + $boundingBox['ascender'];

//     // Anotar la imagen con el texto centrado
//     foreach ($lineas as $linea) {
//         $boundingBox = $imagen->queryFontMetrics($draw, $linea);
//         $textoAncho = $boundingBox['textWidth'];
//         $posicionHorizontal = ($anchoArea - $textoAncho) / 2;
//         $imagen->annotateImage($draw, $posicionHorizontal, $posicionVerticalActual, 0, $linea);
//         $posicionVerticalActual += $espacioEntreLineas;
//     }

//     // Guardar la imagen
//     $imagen->writeImage($rutaGuardado);
// }


// Ejemplo de uso
$texto = "J";
$anchoArea = 772.5;
$altoArea = 887.5;
$rutaImagenSalida = "texto43.png";
$color = '#fce976';  // Puedes cambiar el color según tus necesidades
$fuente = 'Ultra.ttf';  // Especifica la ruta de tu fuente
$tamanoFuente = 465;
generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaImagenSalida,  $color);


function generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
{
    $imagen = new Imagick();

    // Crear una nueva imagen con fondo opaco (por ejemplo, blanco)
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('white'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();
    $draw->setFont($fuente);

    // Tamaño de fuente máximo permitido
    $tamanoFuenteMaximo = 1000;

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
