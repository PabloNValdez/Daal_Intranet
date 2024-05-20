<?php
include 'funciones/funciones.php';
$archivo = $_GET['archivo'];
$sql = "SELECT * FROM `productos` WHERE `archivo` = '$archivo' AND (`producto` = 'Felpudos' OR `producto` = 'Placas_Spotify' OR `producto` = 'Botellas' OR `producto` = 'Tazas') AND `procesado` = 'Si'";
try {
    $resultado = $mysqli->query($sql);
    if ($resultado === false) {
        throw new Exception("Error executing SQL: " . $mysqli->error);
    }
} catch (Exception $e) {
    echo json_encode(array('error' => $e->getMessage()));
    exit();
}



if ($resultado->num_rows > 0) {
    while ($registros = $resultado->fetch_assoc()) {

       
        $url_producto = $registros["archivo"]. "/" .$registros["producto"]."/".$registros["variante"]."/";

        $origen = "subidas/".$url_producto;
        $salida = "salida/".$url_producto;
        copyAndNestFolders($origen, $salida);
    }
}
function copyFolder($source, $destination)
{
    // Crea la carpeta de destino
    if (!is_dir($destination)) {
        mkdir($destination, 0755, true);
    }
    // Copia cada archivo en la carpeta de origen a la carpeta de destino
    $directory = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
    $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);
    $specialFiles = [];
    foreach ($iterator as $item) {
        if ($item->isDir()) {
            mkdir($destination . '/' . $iterator->getSubPathName());
        } else {
            $filename = $item->getFilename();
            // Comprueba si el archivo termina con -vp0.jpg, -vp1.jpg o es placa.png
            if (substr($filename, -8) === '-vp0.jpg' || substr($filename, -8) === '-vp1.jpg' || $filename === 'placa.png' || $filename === 'madera_texto.png' || $filename === 'felpudo.png' || $filename === 'botella.png'|| $filename === 'informacion_extra.txt' || substr($filename, -9) === '_taza.png') {
                // Almacena la información del archivo para manejarla más tarde
                $directoryName = $iterator->getSubPath() !== "" ? basename($iterator->getSubPath()) : basename($item->getPath());
                $specialFiles[] = ['source' => $item, 'directoryName' => $directoryName, 'filename' => $filename];
            } else {
                copy($item, $destination . '/' . $iterator->getSubPathName());
            }
        }
    }
    // Maneja los archivos -vp0.jpg, -vp1.jpg y placa.png
    foreach ($specialFiles as $fileInfo) {
        // Asegúrate de que la carpeta de destino exista
        $parentDestination = dirname($destination . '/' . $iterator->getSubPathName());
        if (!file_exists($parentDestination)) {
            mkdir($parentDestination, 0755, true);
        }
        // Cambia el nombre del archivo placa.png y madera_texto.png al copiarlo
        $sourceName = $fileInfo['filename'];
        if ($sourceName === 'placa.png') {

            $text = $fileInfo['directoryName'];
            $pos = strpos($text, '_');
            $firstPart = substr($text, 0, $pos);
            $sourceName = $firstPart . '_placa.png';
        }
        if ($sourceName === 'madera_texto.png') {
            $text = $fileInfo['directoryName'];
            $pos = strpos($text, '_');
            $firstPart = substr($text, 0, $pos);
            $sourceName = $firstPart . '_madera_texto.png';
        }
        if ($sourceName === 'felpudo.png') {
            $text = $fileInfo['directoryName'];
            $pos = strpos($text, '_');
            $firstPart = substr($text, 0, $pos);
            $sourceName = $firstPart . '_felpudo.png';
        }
        if ($sourceName === 'botella.png') {
            $text = $fileInfo['directoryName'];
            $pos = strpos($text, '_');
            $firstPart = substr($text, 0, $pos);
            $sourceName = $firstPart . '_botella.png';
        }
        if ($sourceName === 'informacion_extra.txt') {
            $text = $fileInfo['directoryName'];
            $pos = strpos($text, '_');
            $firstPart = substr($text, 0, $pos);
            $sourceName = $firstPart . '_informacion_extra.txt';
        }
        copy($fileInfo['source'], $parentDestination . '/' . $sourceName);
    }
}

function copyAndNestFolders($sourceFolder, $destinationFolder)
{
    $directory = new RecursiveDirectoryIterator($sourceFolder, RecursiveDirectoryIterator::SKIP_DOTS);
    $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        if ($item->isDir() && $iterator->getDepth() == 0) { // Solo las carpetas de nivel superior
            $folderName = $item->getFilename();
            $sourcePath = $sourceFolder . '/' . $folderName;
            $destinationPath = $destinationFolder . '/' . $folderName;

            // Crea la nueva carpeta si no existe
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Cambio realizado: Copia la carpeta original a la nueva carpeta sin anidarla
            copyFolder($sourcePath, $destinationPath);
            // Fin del cambio
        }
    }
}





function zipDirectoryAndCreateLink($source, $destination)
{
    $zip = new ZipArchive();
    if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        //registro("Error: No se puede abrir el archivo zip.");
        return "Error: No se puede abrir el archivo zip.";
    }
    $source = str_replace('\\', '/', realpath($source));
    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);
            if (is_dir($file) === true) {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            } elseif (is_file($file) === true) {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    } elseif (is_file($source) === true) {
        $zip->addFromString(basename($source), file_get_contents($source));
    }
    $zip->close();
    // Devolver la ruta del archivo ZIP
    return realpath($destination);
}

// Reemplaza '/path/to/source/folder' y '/path/to/destination/folder'
// con las rutas de tus carpetas de origen y destino reales, respectivamente.
//$origen =  $rootPath . "/" . $tipodeplaca;
//$salida = "../../salida/" . $datetime_str;
//header('Location: descarga.php?origen='.$origen.'&salida='.$salida.'&datetime_str='.$datetime_str);



$origen = "salida/$archivo/";

/* echo "Origen: " .$origen . "<br>";
echo "Salida: " .$salida . "<br>"; */
//copyAndNestFolders($origen, $salida);


$carpeta = 'comprimidos/';
$zipPath = zipDirectoryAndCreateLink($origen, $carpeta . $archivo . '.zip');
//header('Location: ../../carpeta/');
//registro("¡Genial! El procesamiento de imagenes finalizo correctamente: Archivo creado $datetime_str.zip ");
/* echo "Los warning y errores se enviaron a elmatumassa@gmail.com<br>"; */

echo '<div class="alert alert-success d-flex align-items-center" role="alert">
  <div>';
  echo "<strong>Haga clic en el siguiente enlace para descargar el archivo: </strong>";
echo "<a class='btn btn-success' href='https://chat.getsingular.com/versiondos/descarga.php?file=comprimidos/" . $archivo . ".zip'><i class='bi bi-arrow-down-circle'></i> Descargar</a></div>
</div>";