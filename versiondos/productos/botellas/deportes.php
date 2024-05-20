<?php
##########################
##  PLACAS SIN LLAVEROS
##  CON Y SIN BASE
##########################
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

use JsonPath\JsonObject;

function botellaDeportes($registros)
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

        // Encontrar el valor basado en el nombre
        $producto = $xml->xpath('//customizationData/children/name/text()');
        if (!empty($producto)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $producto = (string)$producto[0];
        }

        mensaje($producto);
        @$textoCliente = $textoCliente[0];
        mensaje($textoCliente);
        mensaje($fuente[0]);
        mensaje($colorTexto[0]);
        mensaje($rotacion[0]);

        if ($producto === "Fútbol 4") {
            futbolCuatro($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Fútbol 3") {
            futbolTres($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Fútbol 2") {
            futbolDos($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Fútbol 1") {
            futbolUno($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Pádel 1") {
            padelUno($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Pádel 2") {
            padelDos($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Tenis 1") {
            tenisUno($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Tenis 2") {
            tenisDos($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Baloncesto 1") {
            baloncestoUno($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Baloncesto 2") {
            baloncestoDos($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Baloncesto 3") {
            baloncestoTres($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Baloncesto 4") {
            baloncestoCuatro($textoCliente, $colorTexto[0], $url_completa, $fuente);
        }
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botellaDeportes: ' . $e->getMessage());
    }
}
function baloncestoUno($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/baloncesto1.png');
        generarImagenConTextoBotellas($textoCliente, 537, 123, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto


        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 443);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoUno: ' . $e->getMessage());
    }
}
function baloncestoDos($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/baloncesto2.png');
        generarImagenConTextoBotellas($textoCliente, 489, 136, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 336, 204);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoDos: ' . $e->getMessage());
    }
}
function baloncestoTres($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/baloncesto3.png');
        generarImagenConTextoBotellas($textoCliente, 392, 213, $fuente, $url_completa . 'texto.png', $colorTexto);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');

        // Rotar la imagen del texto


        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 405, 121);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoTres: ' . $e->getMessage());
    }
}

function baloncestoCuatro($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/baloncesto4.png');
        generarImagenConTextoBotellas($textoCliente, 537, 123, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 441);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoCuatro: ' . $e->getMessage());
    }
}
function tenisUno($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/tenis1.png');
        generarImagenConTextoBotellas($textoCliente, 537, 131, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 408);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tenisUno: ' . $e->getMessage());
    }
}
function tenisDos($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/tenis2.png');
        generarImagenConTextoBotellas($textoCliente, 537, 114, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 344);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tenisDos: ' . $e->getMessage());
    }
}
function padelUno($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/padel1.png');
        generarImagenConTextoBotellas($textoCliente, 537, 123, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 443);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en padelUno: ' . $e->getMessage());
    }
}
function padelDos($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/padel2.png');
        generarImagenConTextoBotellas($textoCliente, 537, 132, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 395);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en padelDos: ' . $e->getMessage());
    }
}
function futbolUno($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/futbol1.png');
        generarImagenConTextoBotellas($textoCliente, 537, 123, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 449);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en futbolUno: ' . $e->getMessage());
    }
}
function futbolDos($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/futbol2.png');
        generarImagenConTextoBotellas($textoCliente, 444, 113, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 356, 211);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en futbolDos: ' . $e->getMessage());
    }
}

function futbolTres($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/futbol3.png');
        generarImagenConTextoBotellas($textoCliente, 363, 170, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 399, 151);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en futbolTres: ' . $e->getMessage());
    }
}

function futbolCuatro($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/deportes/futbol4.png');
        generarImagenConTextoBotellas($textoCliente, 537, 123, $url_completa . 'texto.png', $colorTexto, $fuente, $rotacion);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 12, 449);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en futbolCuatro: ' . $e->getMessage());
    }
}


function generarImagenConTextoBotellas($texto, $anchoArea, $altoArea, $rutaGuardado, $colorTexto, $fuente)
{
    try {


        // Crear una nueva imagen en blanco
        $imagen = new Imagick();
        $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
        $imagen->setImageFormat('png');

        $draw = new ImagickDraw();
        mensaje("Fuente: ".$fuente[0]);
        if ($fuente[0] === "Audiowide") {
            $draw->setFont('productos/botellas/fuente/Audiowide/audiowide-v16-latin-regular.ttf');
        } elseif ($fuente[0] === "Fugaz One") {
            $draw->setFont('productos/botellas/fuente/Fugaz One/FugazOne-Regular.ttf');
        } elseif ($fuente[0] === "Titan One") {
            $draw->setFont('productos/botellas/fuente/Titan One/Titan One.ttf');
        } else {
            $draw->setFont('productos/botellas/fuente/Saira Stencil One/Saira Stencil One.ttf');
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
