<?php
// Conéctate a la base de datos
//$mysqli = new mysqli('localhost', 'root', '', 'amazon');
$mysqli = new mysqli('localhost', 'Getsingular', 'XdKFu67LyjtFQQvM', 'versiondos');
// Verifica la conexión
if ($mysqli->connect_error) {
    die('Error de Conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

function contador($producto, $variante, $pedido)
{
    $fecha = date("Y-m-d"); // Obtiene la fecha actual en el formato YYYY-MM-DD
    $conexion = new mysqli('localhost', 'Getsingular', 'XdKFu67LyjtFQQvM', 'versiondos');
    // Verifica la conexión
    if ($conexion->connect_error) {
        mensaje('Error de Conexión (' . $conexion->connect_errno . ') ' . $conexion->connect_error);
    }

    // Verifica si ya existe un registro con el mismo pedido
    $consultaExistencia = "SELECT COUNT(*) FROM contador WHERE pedido = '$pedido'";
    $resultadoExistencia = $conexion->query($consultaExistencia);

    if ($resultadoExistencia === false) {
        mensaje("Error en la consulta de existencia: " . $conexion->error);
    }

    $contador = $resultadoExistencia->fetch_assoc()['COUNT(*)'];

    if ($contador > 0) {
        // El pedido ya existe. Puedes realizar alguna acción si lo deseas.
        mensaje("El pedido ya existe. No se ha insertado ningún registro.");
    } else {
        $sql = "INSERT INTO contador (producto, variante, pedido, fecha) VALUES ('$producto', '$variante', '$pedido', '$fecha')";

        if ($conexion->query($sql) === true) {
            mensaje("Registro insertado correctamente.");
        } else {
            mensaje("Error en la inserción: " . $conexion->error);
        }
    }
}

// function registro($mensaje){
//     $ubicacion = 'D:/laragon/www/amazon/registro.txt';
//     if (file_put_contents($ubicacion, $mensaje.PHP_EOL, FILE_APPEND) === false) {
//         return false; // En caso de error al escribir el archivo, se retorna false
//     } else {
//         return true; // Si se escribe con éxito, se retorna true
//     }
// }
function eliminarMacosx($dir)
{
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!eliminarMacosx($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}
function obtenerURL($url)
{
    $patron = '/^.*\/([^\/]+\/[^\/]+\/[^\/]+\/[^\/]+)\/[^\/]+\.json$/';
    if (preg_match($patron, $url, $matches)) {
        return $matches[1];
    } else {
        return null;
    }
}



//FUNCIONES PARA FELPUDOS:
// Función para anotar texto
function escribirTextoEnArea($imagick, $texto, $tipoDeFuente, $tamanoDeFuente, $colorDeFuente, $area)
{
    $draw = new \ImagickDraw();
    /* Establece el color del texto */
    $draw->setFillColor($colorDeFuente);
    /* Establece la fuente */
    $draw->setFont($tipoDeFuente);
    /* Establece el tamaño de la fuente */
    $draw->setFontSize($tamanoDeFuente);
    /* Establece el área de texto y alinea el texto en el centro */
    $draw->setGravity(\Imagick::GRAVITY_CENTER);
    $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
    /* Calcula las coordenadas para centrar el texto */
    $x = $area['x'] + ($area['width'] / 2);
    $y = $area['y'] + ($area['height'] / 2);
    $tamanoDeFuente = ajustarTamañoDeFuente($imagick, $draw, $texto, $area);
    $draw->setFontSize($tamanoDeFuente);
    /* Añade el texto a la imagen */
    $imagick->annotateImage($draw, $x, $y, 0, $texto);
}
function ajustarTamañoDeFuente($imagick, $draw, $texto, $area)
{
    $tamanoDeFuente = $draw->getFontSize();

    /* Calcula el ancho del texto */
    $metrics = $imagick->queryFontMetrics($draw, $texto);
    $anchoDelTexto = $metrics['textWidth'];

    /* Reduce el tamaño de la fuente hasta que el ancho del texto sea menor que el ancho del área */
    while ($anchoDelTexto > $area['width'] && $tamanoDeFuente > 0) {
        $tamanoDeFuente -= 1;
        $draw->setFontSize($tamanoDeFuente);

        $metrics = $imagick->queryFontMetrics($draw, $texto);
        $anchoDelTexto = $metrics['textWidth'];
    }

    return $tamanoDeFuente;
}

function escribirInfoExtra($texto, $ruta)
{
    // Definir el nombre del archivo de texto
    $fileName = $ruta . 'informacion_extra.txt';

    // Escribir la información en el archivo
    file_put_contents($fileName, $texto);
}
