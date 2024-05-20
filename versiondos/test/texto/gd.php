<?php

function escribirInicialesEnAreaGD($iniciales, $anchoArea, $altoArea, $rutaImagenSalida, $color) {
    // Crear una nueva imagen en blanco
    $imagen = imagecreatetruecolor($anchoArea, $altoArea);

    // Convertir el color hexadecimal a RGB
    $rgbColor = sscanf($color, "%02x%02x%02x");
    $colorTexto = imagecolorallocate($imagen, $rgbColor[0], $rgbColor[1], $rgbColor[2]);

    // Cargar la fuente
    $tamanoFuente = 1;
    do {
        $fuentePath = 'fredericka-the-great-v15-latin-regular.ttf';
        $cajaTexto = imagettfbbox($tamanoFuente, 0, $fuentePath, $iniciales);
        $anchoTexto = $cajaTexto[2] - $cajaTexto[0];
        $altoTexto = $cajaTexto[1] - $cajaTexto[7];

        $tamanoFuente++;
    } while ($anchoTexto < $anchoArea && $altoTexto < $altoArea && $tamanoFuente < 100);

    // Calcular la posición horizontal y vertical del texto para centrarlo
    $posicionX = ($anchoArea - $anchoTexto) / 2;
    $posicionY = ($altoArea - $altoTexto) / 2 + $altoTexto;

    // Rellenar el fondo con blanco
    imagefill($imagen, 0, 0, imagecolorallocate($imagen, 255, 255, 255));

    // Escribir el texto en la imagen
    imagettftext($imagen, $tamanoFuente, 0, $posicionX, $posicionY, $colorTexto, $fuentePath, $iniciales);

    // Guardar la imagen resultante en el sistema de archivos
    imagejpeg($imagen, $rutaImagenSalida, 90);

    // Liberar la memoria
    imagedestroy($imagen);
}

// Ejemplo de uso
$iniciales = "AB";
$anchoArea = 309;
$altoArea = 355;
$rutaImagenSalida = "gd.png";
$color = 'a9f0cc';  // Puedes cambiar el color según tus necesidades
$fuente = 'fredericka-the-great-v15-latin-regular.ttf';  // Especifica la ruta de tu fuente

escribirInicialesEnAreaGD($iniciales, $anchoArea, $altoArea, $rutaImagenSalida, $color);

?>
