<?php


require '../vendor/autoload.php';

use JsonPath\JsonObject;

Imagick::setResourceLimit(Imagick::RESOURCETYPE_MAP, 256); // Ajusta según tus necesidades

// Variables para escalar y posicionar la imagen del cliente
$escalaFijaAncho = 12;
$escalaFijaAlto = 13;
$posicionX = 38;
$posicionY = 108;

// Ruta al archivo JSON
$rutaJson = "405-7602800-9115538_33173392792202/33173392792202.json";

// Cargar y decodificar el JSON
$json = file_get_contents($rutaJson);
$datos = json_decode($json, true);
$jsonObject = new JsonObject($datos);

// Obtener datos del JSON
$imageClienteAncho = $jsonObject->get('$..buyerPlacement.dimension.width');
$imageClienteAlto = $jsonObject->get('$..buyerPlacement.dimension.height');
$escalaX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
$escalaY = $jsonObject->get('$..buyerPlacement.scale.scaleY');
$textoCliente = $jsonObject->get('$..inputValue');
$posicionImagenX = $jsonObject->get('$..buyerPlacement.position.x');
$posicionImagenY = $jsonObject->get('$..buyerPlacement.position.y');

// Calcular dimensiones y posiciones escaladas
$imagenClienteEscaladaAncho = $imageClienteAncho[0] * $escalaY[0] * $escalaFijaAncho;
$imagenClienteEscaladaAlto = $imageClienteAlto[0] * $escalaX[0] * $escalaFijaAlto;
$posicionImagenXEscalada = $posicionImagenX[0] * $escalaFijaAncho;
$posicionImagenYEscalada = $posicionImagenY[0] * $escalaFijaAlto;

// Crear imagen base
$imagen_Base = new Imagick('40x700.png');

// Crear y escalar imagen del cliente
$imagen_Cliente = new Imagick('405-7602800-9115538_33173392792202/c9d9f71f-8d2e-425a-9ec7-08f906f50254.jpg');
$imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
$imagen_Cliente->writeImage('405-7602800-9115538_33173392792202/image-cliente-escalada.jpg');
$imagen_Base->setImageProfiles('icc', null);
// Componer imagen del cliente sobre la imagen base
$imagen_Base->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);


// Ruta para la imagen con texto
$rutaImagenConTexto = '405-7602800-9115538_33173392792202/con_texto.png';

// Generar imagen con texto
generarImagenConTexto($textoCliente[0], $imageClienteAncho[1] * $escalaY[1] * $escalaFijaAncho, $imageClienteAlto[1] * $escalaY[1] * $escalaFijaAncho, $rutaImagenConTexto, "#615F5F");

// Crear imagen con texto
$Texto_Cliente = new Imagick($rutaImagenConTexto);
$Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);

// Posiciones del texto
$posicionTextoX = $posicionImagenX[1] * $escalaFijaAncho;
$posicionTextoY = $posicionImagenY[1] * $escalaFijaAlto;

// Componer texto sobre la imagen base
$imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, $posicionTextoX, $posicionTextoY);

// Recortar la imagen final con texto
$imagen_Base->cropImage(4193, 2421, $posicionX * $escalaFijaAncho, $posicionY * $escalaFijaAlto);
$imagen_Base->writeImage('405-7602800-9115538_33173392792202/Felpudo_final_con_texto.png');

// Liberar recursos de Imagick
$imagen_Cliente->clear();
$imagen_Cliente = null;

$Texto_Cliente->clear();
$Texto_Cliente = null;

function generarImagenConTexto($texto, $anchoArea, $altoArea, $rutaGuardado, $colorTexto)
{


    // Crear una nueva imagen en blanco
    $imagen = new Imagick();
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();
    $draw->setFont('fuente/Stencil/STENCIL.woff');
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


    echo "$texto <br>";
    echo "$anchoArea <br>";
    echo "$altoArea <br>";

    echo "$rutaGuardado <br>";
    echo "$colorTexto <br>";
    echo "$posicionVertical <br>";

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
    echo "$posicionHorizontal <br>";
    // Guardar la imagen
    $imagen->writeImage($rutaGuardado);
}