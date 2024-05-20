<?php


require '../vendor/autoload.php';

use JsonPath\JsonObject;

$escalaFijaAncho = 10.35057471;
$escalaFijaAlto = 10.45833333;
$felpudo_ancho = 3602;
$felpudo_alto = 2008;
$posicionX = 26;
$posicionY = 100;
$rutaJson = "406-4841519-9828311_32602464688882/32602464688882.json";
$json = file_get_contents($rutaJson);
$datos = json_decode($json, true);
$jsonObject = new JsonObject($datos);


$imageClienteAncho = $jsonObject->get('$..buyerPlacement.dimension.width');
$imageClienteAlto = $jsonObject->get('$..buyerPlacement.dimension.height');


echo "<br>Tamaño Imagen<hr>";
echo $imageClienteAncho[0];
echo "<br>";
echo $imageClienteAlto[0];
echo "<br>";

$escalaX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
$escalaY = $jsonObject->get('$..buyerPlacement.scale.scaleY');

echo "<br>Datos de escala<hr>";
echo $escalaY[0];
echo "<br>";
echo $escalaX[0];
echo "<br>";

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
$imagen_Cliente = new Imagick('406-4841519-9828311_32602464688882/dba80632-a995-4c67-b45b-96478e262adc.jpg');
$imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
$imagen_Base->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);
$imagen_Base->writeImage('406-4841519-9828311_32602464688882/Felpudo_sin_recorte.png');
//Agregamos el recuadro de texto, el Archivo de json no da tamaño de fuente, solo el area de texto, entonces
//Se debe crear una funcion que escriba el texto en un rectangulo, o area, y que ocupe todo ese espacio.

$TamañoTextoEscalaAncho = $imageClienteAncho[1] * $escalaY[1];
$TamañoTextoEscalaAlto = $imageClienteAlto[1] * $escalaY[1];

$tamañoTextoFinalAncho = $TamañoTextoEscalaAncho * $escalaFijaAncho;
$tamañoTextoFinalAlto = $TamañoTextoEscalaAlto * $escalaFijaAncho;

$PosicionamientoYtextoFinal = $escalaY[1] * $escalaFijaAncho;
$PosicionamientoXtextoFinal = $escalaX[1] * $escalaFijaAncho;

$posicionTextoX = $posicionImagenX[1] * $escalaFijaAncho;
$posicionTextoY = $posicionImagenY[1] * $escalaFijaAlto;

echo "<br>Tamaño texto<hr>";
    echo $tamañoTextoFinalAncho;
    echo "<br>";
    echo $tamañoTextoFinalAlto;
    echo "<br>";
$textoCliente = $textoCliente[0];

//Valores fijos
generarImagenConTexto($textoCliente, $tamañoTextoFinalAncho, $tamañoTextoFinalAlto, '406-4841519-9828311_32602464688882/con_texto.png',"#615F5F");

$Texto_Cliente = new Imagick('406-4841519-9828311_32602464688882/con_texto.png');
$Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);

$imagen_Base->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, $posicionTextoX, $posicionTextoY);

//Realiza el recorte final de la imagen, pero sin texto, deberia recortar con el texto incluido. 
$imagen_Base->cropImage($felpudo_ancho, $felpudo_alto, $x, $y);
$imagen_Base->writeImage('406-4841519-9828311_32602464688882/Felpudo_final_con_texto.png');
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