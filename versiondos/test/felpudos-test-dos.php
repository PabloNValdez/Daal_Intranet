<?php


require '../vendor/autoload.php';

use JsonPath\JsonObject;
$escalaFijaAncho = 10.35057471;
    $escalaFijaAlto = 10.45833333;
    $felpudo_ancho = 3602;
    $felpudo_alto = 2008;
    $posicionX = 26;
    $posicionY = 100;
$rutaJson = "404-1611085-8049937_31623836999242/31623836999242.json";
$json = file_get_contents($rutaJson);
$datos = json_decode($json, true);
$jsonObject = new JsonObject($datos);


$imageClienteAncho = $jsonObject->get('$..buyerPlacement.dimension.width');
$imageClienteAlto = $jsonObject->get('$..buyerPlacement.dimension.height');

$escalaX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
$escalaY = $jsonObject->get('$..buyerPlacement.scale.scaleY');

$textoCliente = $jsonObject->get('$..inputValue');

$imagenEscalaAncho = $imageClienteAncho[0] * $escalaY[0];
$imagenEscalaAlto = $imageClienteAlto[0] * $escalaX[0];
echo "<br>Primer escalado de Imagen<hr>";
echo $imagenEscalaAncho;
echo "<br>";
echo $imagenEscalaAlto;
echo "<br>";


$imagenClienteEscaladaAncho = $imagenEscalaAncho * $escalaFijaAncho;
$imagenClienteEscaladaAlto = $imagenEscalaAlto * $escalaFijaAlto;
echo "<br>Escaladode Imagen final<hr>";
echo $imagenClienteEscaladaAncho;
echo "<br>";
echo $imagenClienteEscaladaAlto;
echo "<br>";
//Posicionamiento X,Y
$posicionImagenX = $jsonObject->get('$..buyerPlacement.position.x');
$posicionImagenY = $jsonObject->get('$..buyerPlacement.position.y');

    $posicionImagenXEscalada = $posicionImagenX[0] * $escalaFijaAncho;
    $posicionImagenYEscalada = $posicionImagenY[0] * $escalaFijaAlto;
    echo "<br>Posicion Escalada Imagen final<hr>";
    echo $posicionImagenXEscalada;
    echo "<br>";
    echo $posicionImagenYEscalada;
    echo "<br>";

    $x = $posicionX * $escalaFijaAncho;
    $y = $posicionY * $escalaFijaAlto;


    $imagen_Base = new Imagick('felpudo_base.png');

    //Aqui tenemos que pasar los datos de la imagen del cliente
    $imagen_Cliente = new Imagick('404-1611085-8049937_31623836999242/29c928c3-71b4-4d8d-bb90-f245231c9d04.jpg');

    $imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
    $imagen_Base->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);
    $imagen_Base->writeImage('404-1611085-8049937_31623836999242/Felpudo_sin_recorte.png');



    //Agregamos el recuadro de texto, el Archivo de json no da tamaño de fuente, solo el area de texto, entonces
    //Se debe crear una funcion que escriba el texto en un rectangulo, o area, y que ocupe todo ese espacio.

    $TamañoTextoEscalaAncho = $imageClienteAncho[1] * $escalaY[1];
    $TamañoTextoEscalaAlto = $imageClienteAlto[1] * $escalaY[1];

    $tamañoTextoFinalAncho = $TamañoTextoEscalaAncho * $escalaFijaAncho;
    $tamañoTextoFinalAlto = $TamañoTextoEscalaAlto * $escalaFijaAncho;

    $PosicionamientoYtextoFinal = $escalaY[1] * $escalaFijaAncho;
    $PosicionamientoXtextoFinal = $escalaX[1] * $escalaFijaAncho;



    echo "<br>Tamaño texto<hr>";
    echo $tamañoTextoFinalAncho;
    echo "<br>";
    echo $tamañoTextoFinalAlto;
    echo "<br>";

    $textoCliente = $textoCliente[0];
    generarImagenConTexto($textoCliente, 341, 208, '404-1611085-8049937_31623836999242/con_texto.png');
    $Texto_Cliente = new Imagick('404-1611085-8049937_31623836999242/con_texto.png');
    $Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);

    $imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, 369, 1448);

    //Realiza el recorte final de la imagen, pero sin texto, deberia recortar con el texto incluido. 
    $imagen_Base->cropImage($felpudo_ancho, $felpudo_alto, $x, $y);
    $imagen_Base->writeImage('404-1611085-8049937_31623836999242/Felpudo_final_con_texto.png');


    echo "<hr>Ancho y alto del texto<br>";
    echo $imageClienteAncho[1];
    echo "<br>";
    echo $imageClienteAlto[1];
    echo "<br>";

    echo "<hr>Escala del texto<br>";
    echo $escalaY[1];
    echo "<br>";
    echo $escalaX[1];
    echo "<br>";

/* function generarImagenConTexto($texto, $anchoArea, $altoArea, $rutaGuardado)
{
    // Crear una nueva imagen en blanco
    $imagen = new Imagick();
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
    $imagen->setImageFormat('png');
    // Leer el archivo SVG como un SimpleXMLElement
    $rutaSVG = '407-1787054-4771508_31025891732642/744a8e35-021f-23d4-17cc-21b1402b5211.svg';
    $dom = new DOMDocument();
    $dom->load($rutaSVG);
    $textoElemento = $dom->getElementsByTagName('text')->item(0);
    $fontSize = (int) $textoElemento->getAttribute('font-size');
    $draw = new ImagickDraw();
    $draw->setFont('Stencil');
    $draw->setFontSize($fontSize);
    $imagen->annotateImage($draw, 0, $fontSize, 0, $texto);
    // Guardar la imagen
    $imagen->writeImage($rutaGuardado);
} */

function generarImagenConTexto($texto, $anchoArea, $altoArea, $rutaGuardado)
{
    // Crear una nueva imagen en blanco
    $imagen = new Imagick();
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
    $imagen->setImageFormat('png');
    // Leer el archivo SVG como un SimpleXMLElement
    $rutaSVG = '404-1611085-8049937_31623836999242/bf66c624-29a9-f38a-fae9-c07f93bb5fec.svg';
    $dom = new DOMDocument();
    $dom->load($rutaSVG);
    $textoElemento = $dom->getElementsByTagName('text')->item(0);
    
    $fontSize = 1; // Empieza con un tamaño de fuente pequeño

    $draw = new ImagickDraw();
    $draw->setFont('fuente/violette_2/Violette.ttf');
    

    // Ajuste el tamaño de fuente hasta que el texto ocupe el ancho y alto especificados
    do {
        $draw->setFontSize($fontSize);
        $boundingBox = $imagen->queryFontMetrics($draw, $texto);
        $textoAncho = $boundingBox['textWidth'];
        $textoAlto = $boundingBox['textHeight'];
        $fontSize++; // Incrementa el tamaño de fuente
    } while ($textoAncho < $anchoArea && $textoAlto < $altoArea);
    $draw->setTextInterlineSpacing(0.2); // Puedes ajustar este valor según tus necesidades
    // Calcular la posición vertical para que el texto esté centrado verticalmente
    $posicionVertical = ($altoArea - $textoAlto) / 2 + $boundingBox['ascender'];

    // Anotar la imagen con el texto centrado
    $imagen->annotateImage($draw, ($anchoArea - $textoAncho) / 2, $posicionVertical, 0, $texto);

    // Guardar la imagen
    $imagen->writeImage($rutaGuardado);
}

