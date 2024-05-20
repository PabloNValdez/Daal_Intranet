<?php

$archivo = $_GET["archivo"];
//Tenemos que obtener el tipo de producto, y su variante... para poder procesar ese pedido
$query = "SELECT * FROM `productos`  WHERE `archivo`= '2023-09-13~20230913-71-rest' AND `producto`= 'Placas_Spotify' OR `producto`= 'Felpudos'";
try {
    $result = $mysqli->query($sql);
    if ($result === false) {
        throw new Exception("Error executing SQL: " . $mysqli->error);
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
    exit();
}


$procesoCompletado = false; // Esta variable se usará para verificar si el proceso ha finalizado

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ruta = $row["ruta"];
      /*   $ruta = "../../" . $ruta . "/";
        $archivos = scandir($ruta); */
        foreach ($archivos as $archivo) {
            if (pathinfo($archivo, PATHINFO_EXTENSION) == "json") {
                $json_str = file_get_contents($ruta . $archivo);
                $rutaJson = $ruta . $archivo;
                $json_data = json_decode($json_str, true);
                    //leerJSON($rutaJson, $ruta, $base);
                $actualizar_ruta =  $row["ruta"];
                $sql_update = "UPDATE carpetas SET procesada = 1 WHERE ruta = '$actualizar_ruta'";
                if ($mysqli->query($sql_update) === TRUE) {
                }
            }
        }
    }
} else {
    $procesoCompletado = true;
    $actualizar_ruta = false;
}
$sql = "SELECT COUNT(*) FROM `productos`  WHERE `archivo`= '2023-09-13~20230913-71-rest' AND `producto`= 'Placas_Spotify' OR `producto`= 'Felpudos' WHERE procesado = 0";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$carpetasRestantes = $row['carpetasRestantes'];

$response = array(
    'message' => 'Carpeta procesada exitosamente.', //Mensaje que se muestra en el estado
    'carpetasRestantes' => $carpetasRestantes, //Enviado por AJAX indicando carpetas restantes
    'ultimaCarpeta' => $actualizar_ruta, 
    'procesoCompletado' => $procesoCompletado, //Si el procesado completado, el Ajax carga el archivo de comprimir
);

echo json_encode($response);
$mysqli->close();


?>