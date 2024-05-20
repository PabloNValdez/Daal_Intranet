<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

use JsonPath\JsonObject;
include "productos/tazas/inicialInferior.php";
include "productos/tazas/inicialmedio.php";
include "productos/tazas/equipos.php";
include "productos/tazas/tazaConImagenes.php";
function tazas($registros)
{
    try {
        global $registros;
        $url_completa = "subidas/" . $registros["url_completa"];
        $url_completa = "subidas/" . obtenerURL($url_completa) . "/";

        $json_ubicacion = "subidas/" . $registros["url_completa"];
        $json = file_get_contents($json_ubicacion);
        $urlXml = str_replace('.json', '.xml', $json_ubicacion);
        mensaje("XML: " . $urlXml);
        $xml = simplexml_load_file($urlXml);
       
        mensaje("#Seleccionando el tipo de taza: ");

        // Encontrar el valor basado en el nombre
        $producto = $xml->xpath('//customizationData/children/name/text()');
        if (!empty($producto)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $producto = (string)$producto[0];
        }

        if (
            $producto === "Taza Real Sociedad" ||
            $producto === "Taza Athletic Club Bilbao" ||
            $producto === "Taza Barcelona fc" ||
            $producto === "Taza del betis" ||
            $producto === "Taza Sevilla fc" ||
            $producto === "Taza Atlético de Madrid" ||
            $producto === "Taza Real Madrid" ||
            $producto === "Taza Valencia"
        ) {
            mensaje('Leyendo tazas equipos');
            // Llamar a la función común aquí
            // Puedes utilizar la variable $producto para determinar el comportamiento específico dentro de la función común
            tazasEquipos($registros);
        }elseif ($producto === "Taza nombre medio abajo") {
            mensaje('Leyendo tazas inicial + abajo');
            tazasInferior($registros);
        } elseif ($producto === "Taza nombre medio" || $producto === "Botellas con Nombre + Inicial") {
            mensaje('Leyendo tazas inicial + medio');
            tazasMedio($registros);
        }elseif ($producto === "Taza Mágica") {
            mensaje('Leyendo tazas mágicas');
            tazasConImagenes($registros);
        }

        
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella de equipos: ' . $e->getMessage());
    }
}
