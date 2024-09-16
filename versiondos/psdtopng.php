<?php
if (isset($_FILES['psd_files'])) {
    // Crear archivo ZIP temporal
    $zip = new ZipArchive();
    $zip_file = tempnam(sys_get_temp_dir(), 'psd_to_png_') . '.zip';

    if ($zip->open($zip_file, ZipArchive::CREATE) !== true) {
        die("No se pudo crear el archivo ZIP");
    }

    // Recorrer cada archivo PSD
    foreach ($_FILES['psd_files']['tmp_name'] as $key => $file) {
        $output_file_name = pathinfo($_FILES['psd_files']['name'][$key], PATHINFO_FILENAME) . '.png';

        try {
            // Crear un nuevo objeto Imagick
            $imagick = new Imagick();
            $imagick->readImage($file);

            // Convertir a PNG
            $imagick->setImageFormat('png');

            // Guardar el archivo PNG en una ruta temporal
            $tempFilePath = sys_get_temp_dir() . '/' . $output_file_name;
            $imagick->writeImage($tempFilePath); // Escribir la imagen en un archivo temporal

            // Verificar que el archivo se haya creado correctamente
            if (!file_exists($tempFilePath)) {
                throw new Exception("El archivo $output_file_name no se pudo crear.");
            }

            // Agregar el archivo PNG al archivo ZIP
            $zip->addFile($tempFilePath, $output_file_name);

            // Limpiar el objeto Imagick
            $imagick->clear();
            $imagick->destroy();

        } catch (Exception $e) {
            echo 'Error al convertir el archivo: ' . $e->getMessage();
        }
    }

    // Cerrar el archivo ZIP
    $zip->close();

    // Configurar los encabezados para la descarga del ZIP
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="archivos_convertidos.zip"');
    header('Content-Length: ' . filesize($zip_file));
    header('Pragma: no-cache');
    header('Expires: 0');

    // Enviar el archivo ZIP al navegador
    readfile($zip_file);

    // Eliminar el archivo ZIP temporal después de la descarga
    unlink($zip_file);

    // Finalizar la ejecución del script
    exit;
}
?>

<!-- Formulario HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convertir PSD a PNG</title>
</head>
<body>
    <h1>Convertir múltiples archivos PSD a PNG</h1>
    <form action="psdtopng.php" method="post" enctype="multipart/form-data">
        <label for="psd_files">Selecciona archivos PSD:</label>
        <input type="file" name="psd_files[]" id="psd_files" accept=".psd" multiple required>
        <br><br>
        <input type="submit" value="Convertir a PNG y descargar ZIP">
    </form>
</body>
</html>



