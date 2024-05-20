<?php
$archivo = $_GET["archivo"];
// Crear conexión
//$mysqli = new mysqli('localhost', 'Getsingular', 'XdKFu67LyjtFQQvM', 'versiondos');

include 'funciones/funciones.php';
require 'vendor/autoload.php';

include 'productos/placas-spotify/procesamiento.php';
include 'productos/felpudos-familia/Felpudo_33x60.php';
include 'productos/felpudos-familia/Felpudo_40x70.php';
include 'productos/felpudos-familia/Felpudo_60x100.php';
include 'productos/botellas/botellas.php';
/* include 'productos/botellas/deportes.php';
include 'productos/botellas/equipos.php'; */
include 'productos/tazas/tazas.php';
include 'productos/test-placas/procesamiento.php';
include 'productos/espinilleras/procesamiento.php';
$sql = "SELECT * FROM `productos` WHERE `archivo` = '$archivo' AND (`producto` = 'Felpudos' OR `producto` = 'Placas_Spotify' OR `producto` = 'Botellas' OR `producto` = 'Tazas' OR `producto` = 'Espinilleras') AND `procesado` = 'No' LIMIT 1";
try {
    $resultado = $mysqli->query($sql);
    if ($resultado === false) {
        throw new Exception("Error executing SQL: " . $mysqli->error);
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
    exit();
}

$procesoCompletado = false;
if ($resultado->num_rows > 0) {
    while ($registros = $resultado->fetch_assoc()) {
        $actualizarProcesados = "UPDATE productos SET procesado = 'Si' WHERE pedido = '" . $registros["pedido"] . "'";
        $mysqli->query($actualizarProcesados);
        if ($registros["producto"] === "Placas_Spotify") {

            // La variante también cumple la condición, realiza acciones adicionales aquí
            $titulo =  "Placa Spotify Luz";
            nuevasPlacas($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "placa.png";
            $imagen_generada = "subidas" . $archivo_generado . "/" . $nombre_archivo;
        
    } elseif ($registros["variante"] === "Felpudo_33x60") {
            $titulo =  "Felpudos 33x60";
            CrearFelpudos33x60($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "felpudo.png";
            $imagen_generada = "subidas" . $archivo_generado . "/" . $nombre_archivo;
        } elseif ($registros["variante"] === "Felpudo_40x70") {
            $titulo =  "Felpudos 40x70";
            CrearFelpudos40x70($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "felpudo.png";
            $imagen_generada = "subidas" . $archivo_generado . "/" . $nombre_archivo;
        } elseif ($registros["variante"] === "Felpudo_60x100") {
            $titulo =  "Felpudos 60x100";
            CrearFelpudos60x100($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "felpudo.png";
            $imagen_generada = "subidas" . $archivo_generado . "/" . $nombre_archivo;
        } elseif (
            $registros["variante"] === "Botellas_Agua_500_Amarillo_Diseno"
            || $registros["variante"] === "Botellas_Agua_500_Blanco_Diseno"
            || $registros["variante"] === "Botellas_Agua_500_Plata_Diseno"
            || $registros["variante"] === "Botellas_Agua_500_Verde_Diseno"
        ) {
            $titulo =  "Botellas";
            botella($registros);
            //botellaDeportes($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "botella.png";
            $imagen_generada = "subidas" . $archivo_generado . "/" . $nombre_archivo;
        } elseif ($registros["producto"] === "Tazas") {
            $titulo =  "Tazas";
            tazas($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "felpudo.png";
            $imagen_generada = "productos/tazas/taza-equipo.jpg";
        }elseif ($registros["producto"] === "Espinilleras") {
            $titulo =  "Contando Espinilleras";
            espinilleras($registros);
            $url = $registros['url_completa'];
            $archivo_generado = dirname($url);
            $nombre_archivo = "felpudo.png";
            $imagen_generada = "productos/tazas/taza-equipo.jpg";
        }
    }
} else {
    $procesoCompletado = true;
    $imagen_generada = false;
}
$sql = "SELECT COUNT(*) as total 
        FROM `productos` 
        WHERE `archivo` = '$archivo' 
          AND (
            `producto` IN ('Felpudos', 'Placas_Spotify', 'Botellas','Tazas','Espinilleras') 
            OR `variante` = 'Tazas_equipos'
          ) 
          AND `procesado` = 'No'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$carpetasRestantes = $row['total'];
if (!$result) {
    die("Error en la consulta SQL: " . $mysqli->error);
}


$response = array(
    'message' => 'Carpeta procesada exitosamente.', //Mensaje que se muestra en el estado
    'carpetasRestantes' => $carpetasRestantes, //Enviado por AJAX indicando carpetas restantes
    'titulo' => $titulo, //el titulo del producto
    'ultimaCarpeta' => $imagen_generada,
    'procesoCompletado' => $procesoCompletado, //Si el procesado completado, el Ajax carga el archivo de comprimir
);

echo json_encode($response);

function mensaje($mensaje)
{
    $ubicacion = 'registro.txt';
    if (file_put_contents($ubicacion, $mensaje . PHP_EOL, FILE_APPEND) === false) {
        return false; // En caso de error al escribir el archivo, se retorna false
    } else {
        return true; // Si se escribe con éxito, se retorna true
    }
}
