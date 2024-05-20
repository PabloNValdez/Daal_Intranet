<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

use JsonPath\JsonObject;

function botellaEquipos($registros)
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

        if ($producto === "Botella Agua Real Sociedad") {
            realSociedadBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Athletic Bilbao") {
            bilbaoBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Valencia CF") {
            valenciaBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Betis") {
            betisBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Agua Barcelona FC") {
            barcelonaBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Agua Sevilla FC") {
            sevillaBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella R. Madrid") {
            realMadridBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella At. Madrid") {
            atMadridBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Celta") {
            celtaBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Granada CF") {
            granadaBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella RCD Espanyol") {
            espanyolBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Villarreal CF") {
            villarrealBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        } elseif ($producto === "Botella Girona FC") {
            gironaBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        }elseif ($producto === "Botella Cadiz CF") {
            cadizBotella($textoCliente, $colorTexto[0], $url_completa, $fuente);
        }
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella de equipos: ' . $e->getMessage());
    }
}
function cadizBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/cadiz.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}
function gironaBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/girona.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}
function villarrealBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/villarreal.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}
function espanyolBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/espanyol.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}

function granadaBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/granada.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}
function celtaBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/celta.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}
function realSociedadBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/real-sociedad.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);

        
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botella Real Sociedad: ' . $e->getMessage());
    }
}
function bilbaoBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/bilbao.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoDos: ' . $e->getMessage());
    }
}
function valenciaBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/valencia.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoTres: ' . $e->getMessage());
    }
}
function betisBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/betis.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en baloncestoCuatro: ' . $e->getMessage());
    }
}
function sevillaBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/sevilla.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tenisUno: ' . $e->getMessage());
    }
}
function barcelonaBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/barcelona.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tenisDos: ' . $e->getMessage());
    }
}
function realMadridBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/real-madrid.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en padelUno: ' . $e->getMessage());
    }
}
function atMadridBotella($textoCliente, $colorTexto, $url_completa, $fuente)
{
    try {
        $imagen_Base = new Imagick('productos/botellas/equipos/at-madrid.png');
        generarTextoBotellasEquipos($textoCliente, 511, 200, $url_completa . 'texto.png', $colorTexto, $fuente);

        $Texto_Cliente = new Imagick($url_completa . 'texto.png');
        // Rotar la imagen del texto
        $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 25, 36);
        $imagen_Base->rotateImage(new ImagickPixel(), -90);
        $imagen_Base->writeImage($url_completa . 'botella.png');
        mensaje("Botella creada correctamente " . $url_completa . 'botella.png');
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en padelDos: ' . $e->getMessage());
    }
}



function generarTextoBotellasEquipos($texto, $anchoArea, $altoArea, $rutaGuardado, $colorTexto, $fuente)
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
            $imagen->rotateImage(new ImagickPixel('transparent'));


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
        mensaje('Error en generarTextoBotellasEquipos: ' . $e->getMessage());
    }
}

