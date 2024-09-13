<?php
if (isset($_FILES['psd_file'])) {
    $file = $_FILES['psd_file']['tmp_name'];
    $output_file_name = pathinfo($_FILES['psd_file']['name'], PATHINFO_FILENAME) . '.png';

    try {
        // Crear un nuevo objeto Imagick
        $imagick = new Imagick();
        $imagick->readImage($file);

        // Convertir a PNG
        $imagick->setImageFormat('png');

        // Guardar en una ruta temporal
        $tempFilePath = sys_get_temp_dir() . '/' . $output_file_name;
        $imagick->writeImage($tempFilePath);

        // Configurar los encabezados para la descarga
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . $output_file_name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');
        header('Content-Length: ' . filesize($tempFilePath));

        // Leer y enviar el archivo temporal al navegador
        readfile($tempFilePath);

        // Limpiar el objeto Imagick y eliminar el archivo temporal
        $imagick->clear();
        $imagick->destroy();
        unlink($tempFilePath);

    } catch (Exception $e) {
        echo 'Error al convertir el archivo: ' . $e->getMessage();
    }
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
    <h1>Convertir archivos PSD a PNG</h1>
    <form action="psdtopng.php" method="post" enctype="multipart/form-data">
        <label for="psd_file">Selecciona un archivo PSD:</label>
        <input type="file" name="psd_file" id="psd_file" accept=".psd" required>
        <br><br>
        <input type="submit" value="Convertir a PNG">
    </form>
</body>
</html>


