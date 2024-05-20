<?php
if (extension_loaded('imagick')) {
    echo "Imagick está instalado y cargado en PHP.";
} else {
    echo "Imagick no está instalado o no está cargado en PHP.";
}

?>
<?php
if (extension_loaded('gd')) {
    echo 'La extensión GD está activa en PHP.';
} else {
    echo 'La extensión GD no está activa en PHP.';
}
?>