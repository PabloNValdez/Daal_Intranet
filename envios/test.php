<?php

function codigoBarra($pedido)
{
    // URL del enlace que genera la imagen del código de barras
    $url = "https://barcode.tec-it.com/barcode.ashx?data={$pedido}&code=Code128&translate-esc=on";

    // Obtener los datos de la imagen desde la URL
    $imagenDatos = file_get_contents($url);

    // Ruta donde deseas guardar la imagen del código de barras
    $rutaGuardarImagen = $pedido.'.png';

    // Guardar la imagen en el archivo
    file_put_contents($rutaGuardarImagen, $imagenDatos);

    return $rutaGuardarImagen;
}

echo codigoBarra(1000031285);