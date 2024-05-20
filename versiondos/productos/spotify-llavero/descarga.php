<?php
$origen = $_GET['origen'];
$salida = $_GET['salida'];
$datetime_str = $_GET['datetime_str'];
echo $origen.'<br>';
echo $salida.'<br>';


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
            if (substr($filename, -8) === '-vp0.jpg' || substr($filename, -8) === '-vp1.jpg' || $filename === 'placa.png' || $filename === 'madera_texto.png') {
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
            // Copia la carpeta original a la nueva carpeta
            $nestedDestinationPath = $destinationPath . '/' . $folderName;
            copyFolder($sourcePath, $nestedDestinationPath);
        }
    }
}

function zipDirectoryAndCreateLink($source, $destination)
{
    $zip = new ZipArchive();
    if ($zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
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


copyAndNestFolders($origen, $salida);
$carpeta = '../../carpeta/';
$zipPath = zipDirectoryAndCreateLink($salida, $carpeta . $datetime_str . '.zip');
//header('Location: ../../carpeta/');
echo "Los warning y errores se enviaron a elmatumassa@gmail.com<br>";

echo "Haga clic en el siguiente enlace para descargar el archivo: ";

echo "<a href='https://chat.getsingular.com/llavero/descarga.php?file=carpeta/" . $datetime_str . ".zip'>Descargar</a> <br>";
