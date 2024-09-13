<?php


use JsonPath\JsonObject;
//function placasSpotify($json, $ruta, $base)
function espinilleras($registros)
{
    global $registros;
    $url_completa = "subidas/" . $registros["url_completa"];
    $url_completa = "subidas/" . obtenerURL($url_completa) . "/";
    $json_ubicacion = "subidas/" . $registros["url_completa"];
    $json = file_get_contents($json_ubicacion);
    $datos = json_decode($json, true);

    $urlXml = str_replace('.json', '.xml', $json_ubicacion);
    mensaje("XML: " . $urlXml);
    $xml = simplexml_load_file($urlXml);
    $jsonObject = new JsonObject($datos);
    mensaje("-----------------------");
    mensaje("Contando Espinilleras");
    $opcionesDelCliente = $xml->xpath('/data/customizationInfo/version3.0/surfaces/areas[5]/optionValue/text()');
    if (!empty($opcionesDelCliente)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $espinillera = (string)$opcionesDelCliente[0];
    }

    $pedido = $registros["pedido"];
    if($espinillera === "Sujetaespinillera Blanco"){
        contador("Espinilleras", "Sujetaespinillera Blanco", $pedido);
    }else{
        contador("Espinilleras", "Sin Sujetaespinilleras", $pedido);
    }
    

    
}

