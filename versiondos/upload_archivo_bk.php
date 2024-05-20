<?php
$ubicacion = '/home/chat.getsingular/public_html/versiondos/registro.txt';
$mensaje = "Buenos días! Comenzando el procesamiento";
file_put_contents($ubicacion, $mensaje . PHP_EOL);
$conn = new mysqli('localhost', 'Getsingular', 'XdKFu67LyjtFQQvM', 'versiondos');
// Crear conexión
//$conn = new mysqli($servername, $username, $password, $nombre_base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
if (isset($_POST["submit"])) {
    $directorio_subidas = 'subidas' . DIRECTORY_SEPARATOR;

    // Verificar si se subió el archivo sin errores
    if ($_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
        // Obtener nombre del archivo y ruta temporal
        $nombre_archivo = basename($_FILES["archivo"]["name"]);
        $ruta_temporal = $_FILES["archivo"]["tmp_name"];

        // Mover el archivo a la carpeta de subidas
        $ruta_destino = $directorio_subidas . $nombre_archivo;
        move_uploaded_file($ruta_temporal, $ruta_destino);

        // Descomprimir el archivo
        $zip = new ZipArchive;
        if ($zip->open($ruta_destino) === TRUE) {
            $zip->extractTo($directorio_subidas);
            $zip->close();
            //echo 'El archivo se descomprimió correctamente.<br><br>';

            // Ruta del directorio principal
            $directorio_principal = $directorio_subidas . pathinfo($nombre_archivo, PATHINFO_FILENAME);

            // Buscar archivos JSON en las subcarpetas
            $archivos_json = glob($directorio_principal . '/*/*/*/*.json');

            // Iterar sobre los archivos JSON
            foreach ($archivos_json as $archivo_json) {
                // Mostrar la ruta completa del archivo JSON
                /*                 echo "Ruta del archivo JSON: $archivo_json<br>";
 */
                // Obtener las subcarpetas
                $partes_ruta = explode(DIRECTORY_SEPARATOR, dirname($archivo_json));
                array_shift($partes_ruta); // Eliminar la primera carpeta "subidas"
                $ruta_sin_subida = str_replace("subidas", "", $archivo_json);
                $url = $ruta_sin_subida;
                $archivo_generado = dirname($url);
                $carp = explode("/", $archivo_generado);
                $sql = "INSERT INTO productos (archivo, producto, variante, pedido, url_completa) VALUES 
                    ('$carp[1]', '$carp[2]', '$carp[3]', '$carp[4]','$ruta_sin_subida')";
                    $conn->query($sql);

  /*               foreach ($partes_ruta as $indice => $carpeta) {

                    $carp = explode("/", $carpeta);

                    $ruta_sin_subida = str_replace("subidas", "", $archivo_json);
                    $sql = "INSERT INTO productos (archivo, producto, variante, pedido, url_completa) VALUES 
                    ('$carp[0]', '$carp[1]', '$carp[2]', '$carp[3]','$ruta_sin_subida')";
                    $conn->query($sql);
                } */
            }
            header('location: ajax.php?archivo=' . $carp[1]);
        } else {
            echo 'Error al descomprimir el archivo.<br><br>';
        }

        // Eliminar el archivo comprimido si lo deseas
        // unlink($ruta_destino);


        // Si todo finaliza sin error, se procede a Generar los productos, de momento solo: Placas, felpudos Familia


    } else {
        echo 'Error al subir el archivo.<br><br>';
    }
}
