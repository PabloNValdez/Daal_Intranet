
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../vendor/autoload.php");

use JsonPath\JsonObject;

$registros["url_completa"] = "../../test/tazasImagen/403-5193949-0653101_34094710840682/34094710840682.json";
$url_completa = "../../test/tazasImagen/403-5193949-0653101_34094710840682/";


$json_ubicacion = $registros["url_completa"];
$json = file_get_contents($json_ubicacion);



$urlXml = str_replace('.json', '.xml', $json_ubicacion);
echo  "XML: " . $urlXml;
$datos = json_decode($json, true);
$jsonObject = new JsonObject($datos);
echo  "----------------------- <br> ";
$familia = $jsonObject->get('$..children[0].name');
//echo  "Tipo de familia: " . $familia[0] . "<br><br>";
echo  $familia[0] . " <br>";
########## MI DISEÑO #######
$imageClienteAncho = $jsonObject->get('$..buyerPlacement.dimension.width');
$imageClienteAlto = $jsonObject->get('$..buyerPlacement.dimension.height');

echo "Imagen cliente Ancho " . $imageClienteAncho[0] . "<br>";
echo "Imagen cliente Alto " . $imageClienteAlto[0] . "<br>";

$escalaX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
$escalaY = $jsonObject->get('$..buyerPlacement.scale.scaleY');

echo "Imagen escala x " . $escalaX[0] . "<br>";
echo "Imagen escala y " . $escalaY[0] . "<br>";

$textoCliente = $jsonObject->get('$..inputValue');
//Posicionamiento X,Y
$posicionImagenX = $jsonObject->get('$..buyerPlacement.position.x');
$posicionImagenY = $jsonObject->get('$..buyerPlacement.position.y');

echo "Imagen posicion x " . $posicionImagenX[0] . "<br>";
echo "Imagen posicion y " . $posicionImagenY[0] . "<br>";

$fuente = $jsonObject->get('$..fontSelection.family');
//echo "Fuente: " . $fuente[0] . "<br><br>";
// Cargar el XML

$xml = simplexml_load_file($urlXml);

$imagenCliente = $jsonObject->get('$..image.imageName');
miDiseño($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente);

function miDiseño($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente)
{
    try {
        $escalaFijaAncho = 3.589665653;
        $escalaFijaAlto = 3.589665653;
        $felpudo_ancho = 1181;
        $felpudo_alto = 562;
        $posicionX = 37;
        $posicionY = 126;

        $imagenEscalaAncho = $imageClienteAncho[0] * $escalaY[0];
        $imagenEscalaAlto = $imageClienteAlto[0] * $escalaX[0];
        echo "Primer escalado de Imagen<br>";
        echo "$imagenEscalaAncho<br>";
        echo "$imagenEscalaAlto<br>";


        $imagenClienteEscaladaAncho = $imagenEscalaAncho * $escalaFijaAncho;
        $imagenClienteEscaladaAlto = $imagenEscalaAlto * $escalaFijaAlto;
        echo "Escalado de Imagen final<br>";
        echo "$imagenClienteEscaladaAncho<br>";

        echo "$imagenClienteEscaladaAlto<br>";
        echo "posicion imagene escalado<br>";
        echo "$posicionImagenX[0]<br>";
        echo "$posicionImagenY[0]<br>";

        $posicionImagenXEscalada = $posicionImagenX[0] * $escalaFijaAncho;
        $posicionImagenYEscalada = $posicionImagenY[0] * $escalaFijaAlto;

        echo "Posicion Escalada Imagen final<br>";
        echo "$posicionImagenXEscalada<br>";
        echo "$posicionImagenYEscalada<br>";


        $x = $posicionX * $escalaFijaAncho;
        $y = $posicionY * $escalaFijaAlto;


        if ($fuente === "Arial") {
            $fuente = '../../productos/felpudos-familia/fuente/arial/arial.ttf';
        } elseif ($fuente === "Georgia") {
            $fuente = 'Georgia';
        } elseif ($fuente === "Geometos Rounded") {
            $fuente = '../../productos/felpudos-familia/fuente/geometos_rounded/Geometos Rounded.ttf';
        } elseif ($fuente === "Violette") {
            $fuente = '../../productos/felpudos-familia/fuente/violette_2/Violette.ttf';
        } else {
            $fuente = '../../productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        }

        $imagenBase = new Imagick('../../productos/felpudos-familia/Felpudo_33x60/tazas-magicas.png');
        //Aqui tenemos que pasar los datos de la imagen del cliente
        $imagen_Cliente = new Imagick($url_completa . $imagenCliente[0]);
        $imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
        $imagen_Cliente->writeImage($url_completa . 'imagen-cliente.png');

        $imagenBase->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);
        $imagenBase->writeImage($url_completa . 'Felpudo_sin_recorte.png');
        //Agregamos el recuadro de texto, el Archivo de json no da tamaño de fuente, solo el area de texto, entonces
        //Se debe crear una funcion que escriba el texto en un rectangulo, o area, y que ocupe todo ese espacio.

        if ($textoCliente[0] !="") {
            $TamañoTextoEscalaAncho = $imageClienteAncho[1] * $escalaY[1];
            $TamañoTextoEscalaAlto = $imageClienteAlto[1] * $escalaY[1];


            $tamañoTextoFinalAncho = $TamañoTextoEscalaAncho * $escalaFijaAncho;
            $tamañoTextoFinalAlto = $TamañoTextoEscalaAlto * $escalaFijaAncho;

            $PosicionamientoYtextoFinal = $escalaY[1] * $escalaFijaAncho;
            $PosicionamientoXtextoFinal = $escalaX[1] * $escalaFijaAncho;
            $posicionTextoX = $posicionImagenX[1] * $escalaFijaAncho;
            $posicionTextoY = $posicionImagenY[1] * $escalaFijaAlto;
            $textoCliente = $textoCliente[0];

            echo "Tamaño texto<br>";
            echo "$tamañoTextoFinalAncho<br>";

            echo "$tamañoTextoFinalAlto<br>";



            //Valores fijos
            generarImagenConTexto($textoCliente, $tamañoTextoFinalAncho, $tamañoTextoFinalAlto, $fuente, $url_completa . 'con_texto.png', "#615F5F");

            $Texto_Cliente = new Imagick($url_completa . 'con_texto.png');
            $Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);
            $Texto_Cliente->writeImage($url_completa . 'Texto_Cliente.png');
            echo "Ancho y alto del texto<br>";
            echo $imageClienteAncho[1] . "<br>";
    
            echo $imageClienteAlto[1] . "<br>";
    
    
            echo "Escala del texto<br>";
            echo $escalaY[1] . "<br>";
    
            echo $escalaX[1] . "<br>";
            $imagenBase->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, $posicionTextoX, $posicionTextoY);
        }

        

        //Realiza el recorte final de la imagen, pero sin texto, deberia recortar con el texto incluido. 
        $imagenBase->cropImage($felpudo_ancho, $felpudo_alto, $x, $y);
        $imagenBase->writeImage($url_completa . 'Felpudo_final_con_texto.png');

       

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'taza.png');
        echo "Felpudo creado correctamente " . $url_completa . 'taza.png';
    } catch (ImagickException $e) {
        echo "Error al guardar la imagen: " . $e->getMessage();
    }
}

function generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
{
    $imagen = new Imagick();
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();
    $draw->setFont("$fuente");

    // Inicializar el tamaño de fuente al 90% del alto del área
    $fontSize = $altoArea * 0.9;

    // Calcular el tamaño de fuente máximo para ajustarse al área
    do {
        $draw->setFontSize($fontSize);
        $boundingBox = $imagen->queryFontMetrics($draw, $texto);
        $textoAncho = $boundingBox['textWidth'];
        $textoAlto = $boundingBox['textHeight'];
        $fontSize--;
    } while ($textoAlto > $altoArea || $textoAncho > $anchoArea);

    // Calcular la posición vertical para centrar el texto
    $posicionVertical = ($altoArea - $textoAlto) / 2;

    // Calcular la posición horizontal para centrar el texto
    $posicionHorizontal = ($anchoArea - $textoAncho) / 2;

    // Establecer el color del texto
    $draw->setFillColor($colorTexto);

    // Dividir el texto en líneas
    $lineas = explode("\n", $texto);

    // Calcular el espacio entre las líneas
    $espacioEntreLineas = $textoAlto / count($lineas);

    // Calcular la posición vertical inicial
    $posicionVerticalActual = $posicionVertical + $boundingBox['ascender'];

    // Anotar la imagen con el texto centrado
    foreach ($lineas as $linea) {
        $boundingBox = $imagen->queryFontMetrics($draw, $linea);
        $textoAncho = $boundingBox['textWidth'];
        $posicionHorizontal = ($anchoArea - $textoAncho) / 2;
        $imagen->annotateImage($draw, $posicionHorizontal, $posicionVerticalActual, 0, $linea);
        $posicionVerticalActual += $espacioEntreLineas;
    }

    // Guardar la imagen
    $imagen->writeImage($rutaGuardado);
}
