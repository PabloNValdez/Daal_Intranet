<?php
use JsonPath\JsonObject;

function tazasEquipos($registros)
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
        $datos = json_decode($json, true);
        $jsonObject = new JsonObject($datos);
        mensaje("-----------------------");
        @$textoCliente = $jsonObject->get('$..inputValue');
        //@$producto = $jsonObject->get('$..children[0].label');
        @$fuente = $jsonObject->get('$..fontSelection.family');
        @$colorTexto = $jsonObject->get('$..colorSelection.value');
        @$rotacion = $jsonObject->get('$..buyerPlacement.angleOfRotation');

        if (!empty($rotacion)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $rotacion = 0;
        }

        // Encontrar el valor basado en el nombre
        $pedido = $xml->xpath('/data/orderId/text()');
        if (!empty($pedido)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $pedido = (string)$pedido[0];
        }

        // Encontrar el valor basado en el nombre
        $producto = $xml->xpath('//customizationData/children/name/text()');
        if (!empty($producto)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $producto = (string)$producto[0];
        }

        $colorTaza = $xml->xpath('/data/customizationData/children/children/children[1]/displayValue');

        if (!empty($colorTaza)) {
            $colorTaza = (string)$colorTaza[0];
            mensaje($colorTaza);
        } else {
            mensaje("No se encontró el elemento <name> con el valor 'color'.");
        }

        mensaje($pedido);
        mensaje($producto);
        @$textoCliente = $textoCliente[0];
        mensaje($textoCliente);
        mensaje($fuente[0]);
        mensaje($colorTexto[0]);
        mensaje($colorTaza);

        if ($producto === "Taza Real Sociedad") {
            realSociedad($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion, $pedido);
        } elseif ($producto === "Taza Athletic Club Bilbao") {
            bilbao($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion, $pedido);
        } elseif ($producto === "Taza Barcelona fc") {
            barcelonaFC($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        } elseif ($producto === "Taza del betis") {
            betis($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        } elseif ($producto === "Taza Sevilla fc") {
            sevilla($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        } elseif ($producto === "Taza Atlético de Madrid") {
            madrid($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        } elseif ($producto === "Taza Real Madrid") {
            realMadrid($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        } elseif ($producto === "Taza Valencia") {
            valencia($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }elseif ($producto === "Taza Celta") {
            celta($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }elseif ($producto === "Taza Girona") {
            girona($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }elseif ($producto === "Taza Granada") {
            granada($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }elseif ($producto === "Taza Villarreal CF") {
            villarreal($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }elseif ($producto === "Taza Cadiz") {
            cadiz($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }elseif ($producto === "Taza Espanyol") {
            espanyol($textoCliente, $colorTexto[0], $url_completa, $fuente, $colorTaza, $rotacion,$pedido);
        }
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en taza de equipo: ' . $e->getMessage());
    }
}
function espanyol($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/espanyol.png');
        generarImagenConTextoTazas($textoCliente, 533, 161, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 14, 81);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en Taza Espanyol: ' . $e->getMessage());
    }
}
function cadiz($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/cadiz.png');
        generarImagenConTextoTazas($textoCliente, 533, 161, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 14, 81);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en Taza Cadiz: ' . $e->getMessage());
    }
}
function villarreal($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/villarreal.png');
        generarImagenConTextoTazas($textoCliente, 533, 161, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 14, 81);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en Taza Villarreal CF: ' . $e->getMessage());
    }
}
function granada($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/granada.png');
        generarImagenConTextoTazas($textoCliente, 533, 161, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 14, 81);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tazas granada: ' . $e->getMessage());
    }
}
function girona($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/girona.png');
        generarImagenConTextoTazas($textoCliente, 533, 161, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 14, 81);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tazas girona: ' . $e->getMessage());
    }
}
function celta($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/celta.png');
        generarImagenConTextoTazas($textoCliente, 533, 161, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 14, 81);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tazas celta: ' . $e->getMessage());
    }
}
function realSociedad($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/real-sociedad.png');
        generarImagenConTextoTazas($textoCliente, 442, 134, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en realSociedad: ' . $e->getMessage());
    }
}
function bilbao($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/bilbao.png');
        generarImagenConTextoTazas($textoCliente, 442, 134, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en bilbao: ' . $e->getMessage());
    }
}
function barcelonaFC($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/barcelona.png');
        generarImagenConTextoTazas($textoCliente, 442, 134, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en barcelonaFC: ' . $e->getMessage());
    }
}
function betis($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/betis.png');
        generarImagenConTextoTazas($textoCliente, 442, 104, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en betis: ' . $e->getMessage());
    }
}
function sevilla($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/sevilla.png');
        generarImagenConTextoTazas($textoCliente, 442, 134, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en sevilla: ' . $e->getMessage());
    }
}
function madrid($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/athletic-madrid.png');
        generarImagenConTextoTazas($textoCliente, 442, 134, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en madrid: ' . $e->getMessage());
    }
}
function realMadrid($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/real-madrid.png');
        generarImagenConTextoTazas($textoCliente, 442, 104, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        error_log('Error en realMadrid: ' . $e->getMessage());
        mensaje('Error en realMadrid: ' . $e->getMessage());
    }
    
}
function valencia($textoCliente, $colorTexto, $url_completa, $fuente, $colorTaza,$rotacion,$pedido)
{
    try {
        $imagen_Base = new Imagick('productos/tazas/equipos/valencia.png');
        generarImagenConTextoTazas($textoCliente, 442, 134, $url_completa . 'texto.png', $colorTexto, $fuente,$rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 148, 61);
        $imagen_Base->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');

    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en valencia: ' . $e->getMessage());
    }
}
function generarImagenConTextoTazas($texto, $anchoArea, $altoArea, $rutaGuardado, $colorTexto, $fuente, $rotacion)
{
    try {
        // Crear una nueva imagen en blanco
        $imagen = new Imagick();
        $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
        $imagen->setImageFormat('png');

        $draw = new ImagickDraw();
        $fuenteSeleccionada = $fuente[0];

        mensaje("Fuente:  " .$fuenteSeleccionada);
        mensaje("Texto:  " .$texto);
        mensaje("Texto:  " .$colorTexto);

        if ($fuenteSeleccionada == 'Fugaz One') {
            $draw->setFont('fuentes/FugazOne-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Titan One') {
            $draw->setFont('fuentes/Titan_One(1)/TitanOne-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Audiowide') {
            $draw->setFont('fuentes/Audiowide/Audiowide-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Airborne 86 Stencil') {
            $draw->setFont('fuentes/Airborne 86.woff');
        } elseif ($fuenteSeleccionada == 'Chewy') {
            $draw->setFont('fuentes/Chewy-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Geometos Rounded') {
            $draw->setFont('fuentes/geometos_rounded/Geometos Rounded.ttf');
        } elseif ($fuenteSeleccionada == 'Georgia') {
            $draw->setFont('fuentes/georgia.ttf');
        } elseif ($fuenteSeleccionada == 'Pangolin') {
            $draw->setFont('fuentes/Pangolin-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Righteous') {
            $draw->setFont('fuentes/Righteous-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Staatliches') {
            $draw->setFont('fuentes/Staatliches-Regular.ttf');
        } elseif ($fuenteSeleccionada == 'Ultra') {
            $draw->setFont('fuentes/Ultra.ttf');
        }
        $fontSize = 1; // Empieza con un tamaño de fuente pequeño

        // Ajuste el tamaño de fuente hasta que el texto ocupe el ancho y alto especificados
        do {
            $draw->setFontSize($fontSize);
            $boundingBox = $imagen->queryFontMetrics($draw, $texto);
            $textoAncho = $boundingBox['textWidth'];
            $textoAlto = $boundingBox['textHeight'];
            $fontSize++; // Incrementa el tamaño de fuente
        } while ($textoAncho < $anchoArea && $textoAlto < $altoArea);

        // Calcular la posición vertical para que el texto esté centrado verticalmente
        $posicionVertical = ($altoArea - $textoAlto) / 2;

        $y = $posicionVertical;
        $lineas = explode("\n", $texto);

        $textoAlto = 0;
        foreach ($lineas as $linea) {
            // Obtener las dimensiones de cada línea
            $boundingBox = $imagen->queryFontMetrics($draw, $linea);
            $textoAncho = $boundingBox['textWidth'];

            // Calcular la posición horizontal para centrar el texto
            $posicionHorizontal = ($anchoArea - $textoAncho) / 2;

            // Establecer la rotación del texto
            $imagen->rotateImage(new ImagickPixel('transparent'), $rotacion);


            // Establecer el color del texto
            $draw->setFillColor($colorTexto);
            // Anotar la imagen con el texto centrado
            $imagen->annotateImage($draw, $posicionHorizontal, $y + $boundingBox['ascender'], 0, $linea);

            $y += $boundingBox['textHeight'];
        }

        // Guardar la imagen
        $imagen->writeImage($rutaGuardado);
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en generarImagenConTextoBotellas: ' . $e->getMessage());
    }
}
