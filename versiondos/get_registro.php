<?php
$log_file = 'registro.txt'; // Cambia esto por la ruta real a tu archivo log.txt

if (file_exists($log_file)) {
    echo file_get_contents($log_file);
} else {
    echo "El archivo log.txt no se encuentra.";
}
?>
