<?php
function eliminarContenidoCarpeta($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") {
                    eliminarContenidoCarpeta($dir."/".$object);
                    rmdir($dir."/".$object); // Mueve esta línea aquí para solo eliminar las subcarpetas
                } else {
                    // no elimine el archivo index.php
                    if ($object != "index.php") {
                        unlink($dir."/".$object);
                    }
                }
            }
        }
        reset($objects);
    }
}

if(isset($_POST['eliminar'])) {
    $carpeta1 = 'comprimidos';
    $carpeta2 = 'salida';
    $carpeta3 = 'subidas';

    eliminarContenidoCarpeta($carpeta1);
    eliminarContenidoCarpeta($carpeta2);
    eliminarContenidoCarpeta($carpeta3);
    
    echo 'El contenido de las carpetas y las subcarpetas han sido eliminados';
}
?>

<form method="POST" action="limpiar.php">
    <input type="submit" value="Eliminar contenido de carpetas" name="eliminar">
</form>

