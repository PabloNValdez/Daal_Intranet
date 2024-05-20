<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

use JsonPath\JsonObject;
include "productos/botellas/deportes.php";
include "productos/botellas/equipos.php";
function botella($registros)
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
       
        mensaje("#Seleccionando el tipo de botella: ");

        // Encontrar el valor basado en el nombre
        $producto = $xml->xpath('//customizationData/children/name/text()');
        if (!empty($producto)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $producto = (string)$producto[0];
        }

        if($producto == "Fútbol 4" || $producto == "Fútbol 3" || $producto == "Fútbol 2" || $producto == "Fútbol 1" || $producto == "Pádel 1" || $producto == "Pádel 2" || $producto == "Tenis 1" || $producto == "Tenis 2" || $producto == "Baloncesto 1" || $producto ==  "Baloncesto 2" || $producto ==  "Baloncesto 3" || $producto ==  "Baloncesto 4") {
            mensaje("#Botella de Deportes: ");
            botellaDeportes($registros);
        } elseif($producto == "Botella Agua Real Sociedad" || $producto == "Botella Athletic Bilbao" || $producto == "Botella Valencia CF" || $producto == "Botella Betis" || $producto == "Botella Agua Barcelona FC" || $producto == "Botella Agua Sevilla FC" || $producto == "Botella R. Madrid" || $producto == "Botella At. Madrid") {
            mensaje("#Botella de equipos: ");
            botellaEquipos($registros);
        } 
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella de equipos: ' . $e->getMessage());
    }
}
