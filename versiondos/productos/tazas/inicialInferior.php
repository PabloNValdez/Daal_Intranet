<?php
##########################
##  PLACAS SIN LLAVEROS
##  CON Y SIN BASE
##########################
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

use JsonPath\JsonObject;

function tazasInferior($registros)
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
        @$inicial = $jsonObject->get('$..inputValue');
        //@$producto = $jsonObject->get('$..children[0].label');
        @$fuente = $jsonObject->get('$..fontSelection.family');
        @$colorTexto = $jsonObject->get('$..colorSelection.value');
        @$rotacion = $jsonObject->get('$..buyerPlacement.angleOfRotation');
        $fuenteDos = $xml->xpath('/data/customizationInfo/version3.0/surfaces/areas[3]/fontFamily/text()');
        if (!empty($fuenteDos)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $fuenteDos = (string)$fuenteDos[0];
        }

        $nombre = $xml->xpath('/data/customizationInfo/version3.0/surfaces/areas[3]/text');
        if (!empty($nombre)) {
            // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
            $nombre = (string)$nombre[0];
        }

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
        @$inicial = $inicial[0];
        mensaje($inicial);
        mensaje($fuente[0]);
        mensaje($colorTexto[0]);
        mensaje($colorTaza);
        mensaje($fuenteDos);
        mensaje($nombre);
        crearImagenIniciales($inicial, $colorTexto[0], $fuente[0], $url_completa);
        crearImagenTextoInferior($nombre, $fuenteDos, $url_completa);
        crearTazas($colorTaza, $url_completa,$pedido);
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en botellaDeportes: ' . $e->getMessage());
    }
}

function crearTazas($colorTaza, $url_completa,$pedido)
{
    try {
        // Ruta de las imágenes
        $rutaImagenBase = 'productos/tazas/bases/textoBase.png';
        $rutaImagenSuperior = 'productos/tazas/textoinferior.png';

        // Carga las imágenes con Imagick
        $imagenBase = new \Imagick($rutaImagenBase);
        $imagenSuperior = new \Imagick($rutaImagenSuperior);

        // Obtén dimensiones de ambas imágenes
        $anchoBase = $imagenBase->getImageWidth();
        $altoBase = $imagenBase->getImageHeight();

        $anchoSuperior = $imagenSuperior->getImageWidth();
        $altoSuperior = $imagenSuperior->getImageHeight();

        // Calcula la escala necesaria
        $escalaAncho = $anchoBase / $anchoSuperior;
        $escalaAlto = $altoBase / $altoSuperior;

        // Elige la escala mínima para que la imagen superior se ajuste completamente
        $escala = min($escalaAncho, $escalaAlto);

        // Redimensiona la imagen superior
        $imagenSuperior->scaleImage($anchoSuperior * $escala, $altoSuperior * $escala);

        // Calcula las coordenadas para centrar la imagen superior en la imagen base
        $x = ($anchoBase - $imagenSuperior->getImageWidth()) / 2;
        $y = ($altoBase - $imagenSuperior->getImageHeight()) / 2;

        // Composición de las imágenes
        $imagenBase->compositeImage($imagenSuperior, \Imagick::COMPOSITE_OVER, $x, $y);

        // Guarda la imagen resultante
        $rutaImagenResultante = 'productos/tazas/final_texto_inferior.png';
        $imagenBase->writeImage($rutaImagenResultante);

        // Libera los recursos
        $imagenBase->destroy();
        $imagenSuperior->destroy();

        // TEXTO IZQUIERDA
        $rutaImagenBase = 'productos/tazas/bases/taza.png';
        $rutaImagenSuperior = 'productos/tazas/inicial.png';
        $x = 49; // Coordenada x
        $y = 25; // Coordenada y

        $anchoArea = 309; // Ancho del área
        $altoArea = 355; // Alto del área

        superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea, $colorTaza, $url_completa);

        // TEXTO DERECHA
        $rutaImagenBase = 'productos/tazas/taza_final.png';
        $rutaImagenSuperior = 'productos/tazas/inicial.png';
        $x = 824; // Coordenada x
        $y = 25; // Coordenada y

        $anchoArea = 309; // Ancho del área
        $altoArea = 355; // Alto del área

        superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea, $colorTaza, $url_completa);

        // TEXTO INFERIOR IZQUIERDA
        $rutaImagenBase = 'productos/tazas/taza_final.png';
        $rutaImagenSuperior = 'productos/tazas/final_texto_inferior.png';
        $x = 49; // Coordenada x
        $y = 402; // Coordenada y

        $anchoArea = 309; // Ancho del área
        $altoArea = 76; // Alto del área

        superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea, $colorTaza, $url_completa);
        // Puedes utilizar $rutaResultado como la ruta de la imagen resultante o realizar otras operaciones con ella.

        // TEXTO INFERIOR DERECHA
        $rutaImagenBase = 'productos/tazas/taza_final.png';
        $rutaImagenSuperior = 'productos/tazas/final_texto_inferior.png';
        $x = 824; // Coordenada x
        $y = 402; // Coordenada y

        $anchoArea = 309; // Ancho del área
        $altoArea = 76; // Alto del área

        $rutaResultado = superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea, $colorTaza, $url_completa);
        mensaje("Ruta Resultado: " . $rutaResultado);
        // Crear un objeto Imagick
        $imagen = new Imagick($rutaResultado);

        // Clonar la imagen para crear una copia
        $copiaImagen = clone $imagen;

        // Guardar la nueva imagen
    
        $copiaImagen->writeImage($url_completa.$pedido.'_'. $colorTaza . '_taza.png');
        mensaje("Taza creada correctamente:  " . $url_completa.$pedido.'_'. $colorTaza . '_taza.png');
    } catch (\Exception $e) {
        // Manejo de la excepción

        mensaje('Error: ' . $e->getMessage());
    }
}


function crearImagenIniciales($iniciales, $color, $fuente, $url_completa)
{

    // CREA LA LA INICIAL SUPERIOR
    $texto = strtoupper($iniciales);
    $anchoArea = 772.5;
    $altoArea = 887.5;
    $rutaImagenSalida = "productos/tazas/inicial.png";
    /* $color = '#fce976';  // Puedes cambiar el color según tus necesidades
    $fuente = 'fuente/Ultra.ttf';  // Especifica la ruta de tu fuente */
    $tamanoFuenteMaximo = 1000;
    generarImagenIniciales($texto, $anchoArea, $altoArea, $fuente, $rutaImagenSalida, $color, $tamanoFuenteMaximo);
}

function crearImagenTextoInferior($nombre, $fuenteDos, $url_completa)
{
    //CREAMOS TEXTO INFERIOR
    $texto = $nombre;
    $anchoArea = 618;
    $altoArea = 152;
    $rutaImagenSalida = "productos/tazas/textoinferior.png";
    $color = '#000000';  // Puedes cambiar el color según tus necesidades
    $fuente = $fuenteDos;  // Especifica la ruta de tu fuente
    $tamanoFuenteMaximo = 250;
    generarImagenIniciales($texto, $anchoArea, $altoArea, $fuente, $rutaImagenSalida,  $color, $tamanoFuenteMaximo);
}
function generarImagenIniciales($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto, $tamanoFuenteMaximo)
{
    $imagen = new Imagick();

    // Crear una nueva imagen con fondo opaco (por ejemplo, blanco)
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('white'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();

    $selectedFont = $fuente; // Asegúrate de que estás usando el método correcto (POST o GET)

    // Realiza acciones diferentes según el nombre de la fuente seleccionada
    if ($selectedFont === "Caveat") {
        $draw->setFont('fuentes/Caveat-Regular.ttf');
    } else if ($selectedFont === "Homemade Apple") {
        // Código para la fuente Homemade Apple
        $draw->setFont('fuentes/HomemadeApple-Regular.ttf');
    } else if ($selectedFont === "Kaushan Script") {
        // Código para la fuente Kaushan Script
        $draw->setFont('fuentes/KaushanScript-Regular.ttf');
    } else if ($selectedFont === "Satisfy") {
        // Código para la fuente Satisfy
        $draw->setFont('fuentes/Satisfy-Regular.ttf');
    } else if ($selectedFont === "Sacramento") {
        // Código para la fuente Sacramento
        $draw->setFont('fuentes/Sacramento-Regular.ttf');
    } else if ($selectedFont === "Gloria Hallelujah") {
        // Código para la fuente Gloria Hallelujah
        $draw->setFont('fuentes/GloriaHallelujah-Regular.ttf');
    } else if ($selectedFont === "Allura") {
        // Código para la fuente Allura
        $draw->setFont('fuentes/Allura-Regular.ttf');
    } elseif ($selectedFont === "Rubik Mono One") {
        // Código para la fuente Rubik Mono One
        $draw->setFont('fuentes/RubikMonoOne-Regular.ttf');
    } else if ($selectedFont === "Montserrat") {
        // Código para la fuente Montserrat
        $draw->setFont('fuentes/Montserrat-Regular.ttf');
    } else if ($selectedFont === "Righteous") {
        // Código para la fuente Righteous
        $draw->setFont('fuentes/Righteous-Regular.ttf');
    } else if ($selectedFont === "Fredoka One") {
        // Código para la fuente Fredoka One
        $draw->setFont('fuentes/FredokaOne-Regular.ttf');
    } else if ($selectedFont === "Ultra") {
        // Código para la fuente Ultra
        $draw->setFont('fuentes/Ultra-Regular.ttf');
    } else if ($selectedFont === "Fredericka the Great") {
        // Código para la fuente Fredericka the Great
        $draw->setFont('fuentes/fredericka-the-great-v15-latin-regular.ttf');
    }
    // Inicializar el tamaño de fuente al máximo
    $tamanoFuente = $tamanoFuenteMaximo;

    // Bucle para encontrar el tamaño de fuente adecuado
    do {
        $draw->setFontSize($tamanoFuente);
        $boundingBox = $imagen->queryFontMetrics($draw, $texto);
        $textoAncho = $boundingBox['textWidth'];
        $textoAlto = $boundingBox['textHeight'];

        $tamanoFuente--;
    } while ($tamanoFuente > 0 && ($textoAlto > $altoArea || $textoAncho > $anchoArea));

    // Calcular la posición vertical para centrar el texto
    $posicionVertical = ($altoArea - $textoAlto) / 2;

    // Calcular la posición horizontal para centrar el texto
    $posicionHorizontal = ($anchoArea - $textoAncho) / 2;

    // Establecer el color del texto
    $draw->setFillColor($colorTexto);
    $draw->setTextAntialias(true); // Habilitar anti-aliasing


    // Dividir el texto en líneas
    $lineas = explode("\n", $texto);

    // Calcular la posición vertical inicial
    $posicionVerticalActual = $posicionVertical + $boundingBox['ascender'];

    // Anotar la imagen con el texto centrado
    foreach ($lineas as $linea) {
        $boundingBox = $imagen->queryFontMetrics($draw, $linea);
        $imagen->annotateImage($draw, $posicionHorizontal, $posicionVerticalActual, 0, $linea);
        $posicionVerticalActual += $boundingBox['textHeight'];
    }

    $resolucionDPI = 300; // Puedes ajustar según tus necesidades
    $imagen->setImageResolution($resolucionDPI, $resolucionDPI);

    // Recortar la imagen para eliminar los espacios en blanco alrededor del texto
    $imagen->trimImage(0);

    // Mejorar la calidad de la imagen
    $imagen->setImageCompressionQuality(100);

    // Guardar la nueva imagen
    $imagen->writeImage($rutaGuardado);

    // Destruir el objeto Imagick
    $imagen->destroy();
}

function superponerImagen($rutaImagenBase, $rutaImagenSuperior, $x, $y, $anchoArea, $altoArea, $colorTaza)
{
    // Carga las imágenes con Imagick
    $imagenBase = new \Imagick($rutaImagenBase);
    $imagenSuperior = new \Imagick($rutaImagenSuperior);

    // Obtén dimensiones de ambas imágenes
    $anchoBase = $imagenBase->getImageWidth();
    $altoBase = $imagenBase->getImageHeight();

    $anchoSuperior = $imagenSuperior->getImageWidth();
    $altoSuperior = $imagenSuperior->getImageHeight();

    // Calcula las coordenadas para posicionar el área
    $x = min(max(0, $x), $anchoBase - $anchoArea);
    $y = min(max(0, $y), $altoBase - $altoArea);

    // Redimensiona la imagen superior para que se ajuste al área
    $escalaAncho = $anchoArea / $anchoSuperior;
    $escalaAlto = $altoArea / $altoSuperior;
    $escala = min($escalaAncho, $escalaAlto);

    $imagenSuperior->scaleImage($anchoSuperior * $escala, $altoSuperior * $escala);

    // Calcula las coordenadas para centrar la imagen superior en el área
    $xSuperior = $x + ($anchoArea - $imagenSuperior->getImageWidth()) / 2;
    $ySuperior = $y + ($altoArea - $imagenSuperior->getImageHeight()) / 2;

    // Composición de las imágenes
    $imagenBase->compositeImage($imagenSuperior, \Imagick::COMPOSITE_OVER, $xSuperior, $ySuperior);
    $imagenBase->setImageCompressionQuality(100);
    // Guarda la imagen resultante

    $rutaImagenResultante = 'productos/tazas/taza_final.png';


    $imagenBase->writeImage($rutaImagenResultante);

    // Libera los recursos
    $imagenBase->destroy();
    $imagenSuperior->destroy();

    return $rutaImagenResultante;
}
