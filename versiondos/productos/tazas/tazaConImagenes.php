<?php
##########################
##  PLACAS SIN LLAVEROS
##  CON Y SIN BASE
##########################
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

use JsonPath\JsonObject;

function tazasConImagenes($registros)
{
    try {
        global $registros;
        $url_completa = "subidas/" . $registros["url_completa"];
        $url_completa = "subidas/" . obtenerURL($url_completa) . "/";

        $json_ubicacion = "subidas/" . $registros["url_completa"];
        $json = file_get_contents($json_ubicacion);
        $urlXml = str_replace('.json', '.xml', $json_ubicacion);
        mensaje("XML: " . $urlXml);
        $datos = json_decode($json, true);
        $jsonObject = new JsonObject($datos);
        mensaje("-----------------------  ");
        $familia = $jsonObject->get('$..children[0].name');
        //mensaje("Tipo de familia: " . $familia[0] . "";
        mensaje($familia[0] . " ");
        @$colorTexto = $jsonObject->get('$..colorSelection.value');
        mensaje($colorTexto[0]);
        ########## MI DISEÑO #######
        $imageClienteAncho = $jsonObject->get('$..buyerPlacement.dimension.width');
        $imageClienteAlto = $jsonObject->get('$..buyerPlacement.dimension.height');
        $rotacion = $jsonObject->get('$..buyerPlacement.angleOfRotation');

        mensaje("Imagen cliente Ancho " . $imageClienteAncho[0] . "");
        mensaje("Imagen cliente Alto " . $imageClienteAlto[0] . "");

        $escalaX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
        $escalaY = $jsonObject->get('$..buyerPlacement.scale.scaleY');

        mensaje("Imagen escala x " . $escalaX[0] . "");
        mensaje("Imagen escala y " . $escalaY[0] . "");

        $textoCliente = $jsonObject->get('$..inputValue');
        //Posicionamiento X,Y
        $posicionImagenX = $jsonObject->get('$..buyerPlacement.position.x');
        $posicionImagenY = $jsonObject->get('$..buyerPlacement.position.y');

        mensaje("Imagen posicion x " . $posicionImagenX[0] . "");
        mensaje("Imagen posicion y " . $posicionImagenY[0] . "");

        $fuente = $jsonObject->get('$..fontSelection.family');
        //mensaje("Fuente: " . $fuente[0] . "";
        // Cargar el XML

        $xml = simplexml_load_file($urlXml);
        $pedido = $registros["pedido"];
        $imagenCliente = $jsonObject->get('$..image.imageName');
        tazasMagicas($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente[0],$colorTexto[0], $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente,$rotacion,$pedido);
    } catch (Exception $e) {
        // Manejar la excepción, puedes registrarla, imprimir un mensaje de error, etc.
        mensaje('Error en tazas con imágenes: ' . $e->getMessage());
    }
}


function tazasMagicas($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente,$colorTexto, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente, $rotacion, $pedido)
{
    try {
        $escalaFijaAncho = 3.45;
        $escalaFijaAlto = 3.45;
        $felpudo_ancho = 1181;
        $felpudo_alto = 562;
        $posicionX = 29.25;
        $posicionY = 120.5;
        $rotacion = $rotacion[0];
        mensaje("Rotacion: $rotacion");
        $imagenEscalaAncho = $imageClienteAncho[0] * $escalaY[0];
        $imagenEscalaAlto = $imageClienteAlto[0] * $escalaX[0];
        mensaje("Primer escalado de Imagen");
        mensaje("$imagenEscalaAncho");
        mensaje("$imagenEscalaAlto");


        $imagenClienteEscaladaAncho = $imagenEscalaAncho * $escalaFijaAncho;
        $imagenClienteEscaladaAlto = $imagenEscalaAlto * $escalaFijaAlto;
        mensaje("Escalado de Imagen final");
        mensaje("$imagenClienteEscaladaAncho");

        mensaje("$imagenClienteEscaladaAlto");
        mensaje("posicion imagene escalado");
        mensaje("$posicionImagenX[0]");
        mensaje("$posicionImagenY[0]");

        $posicionImagenXEscalada = $posicionImagenX[0] * $escalaFijaAncho;
        $posicionImagenYEscalada = $posicionImagenY[0] * $escalaFijaAlto;

        mensaje("Posicion Escalada Imagen final");
        mensaje("$posicionImagenXEscalada");
        mensaje("$posicionImagenYEscalada");


        $x = $posicionX * $escalaFijaAncho;
        $y = $posicionY * $escalaFijaAlto;

        mensaje('La fuente es: ' . $fuente);
        if ($fuente == 'Arial') {
            // Código para manejar la fuente Arial
            $fuente = 'fuentes/arial/ARIAL.TTF';
        } elseif ($fuente == 'Audiowide') {
            // Código para manejar la fuente Audiowide
            $fuente = 'fuentes/Audiowide/Audiowide-Regular.ttf';
        } elseif ($fuente == 'Chewy') {
            // Código para manejar la fuente Chewy
            $fuente = 'fuentes/Chewy-Regular.ttf';
        } elseif ($fuente == 'Georgia') {
            // Código para manejar la fuente Georgia
            $fuente = 'fuentes/georgia.ttf';
        } elseif ($fuente == 'Geometos Rounded') {
            // Código para manejar la fuente Geometos Rounded
            $fuente = 'fuentes/geometos_rounded/Geometos Rounded.ttf';
        } elseif ($fuente == 'Fredoka One') {
            // Código para manejar la fuente Fredoka One
            $fuente = 'fuentes/FredokaOne-Regular.ttf';
        } elseif ($fuente == 'Pacifico') {
            // Código para manejar la fuente Pacifico
            $fuente = 'fuentes/Pacifico-Regular.ttf';
        } elseif ($fuente == 'Righteous') {
            // Código para manejar la fuente Righteous
            $fuente = 'fuentes/Righteous-Regular.ttf';
        } elseif ($fuente == 'Rubik Mono One') {
            // Código para manejar la fuente Rubik Mono One
            $fuente = 'fuentes/RubikMonoOne-Regular.ttf';
        } elseif ($fuente == 'Stencil') {
            // Código para manejar la fuente Stencil
            $fuente = 'fuentes/STENCIL.woff';
        } elseif ($fuente == 'Violette') {
            // Código para manejar la fuente Violette
            $fuente = 'fuentes/Violette.ttf';
        }

        $imagenBase = new Imagick('productos/tazas/bases/tazas-magicas.png');
        //Aqui tenemos que pasar los datos de la imagen del cliente
        $imagen_Cliente = new Imagick($url_completa . $imagenCliente[0]);
        // Lee los metadatos EXIF de la imagen para obtener la orientación
        
        
        

        $imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
        
        $imagen_Cliente->writeImage($url_completa . 'imagen-cliente.png');
        $imagenBase->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);

        $imagenBase->rotateImage(new ImagickPixel('none'), $rotacion);
        
        $imagenBase->writeImage($url_completa . 'Felpudo_sin_recorte.png');
        //Agregamos el recuadro de texto, el Archivo de json no da tamaño de fuente, solo el area de texto, entonces
        //Se debe crear una funcion que escriba el texto en un rectangulo, o area, y que ocupe todo ese espacio.

        if ($textoCliente[0] != "") {
            mensaje("Texto del cliente: ". $textoCliente[0]);
            $TamañoTextoEscalaAncho = $imageClienteAncho[1] * $escalaY[1];
            $TamañoTextoEscalaAlto = $imageClienteAlto[1] * $escalaY[1];


            $tamañoTextoFinalAncho = $TamañoTextoEscalaAncho * $escalaFijaAncho;
            $tamañoTextoFinalAlto = $TamañoTextoEscalaAlto * $escalaFijaAncho;

            $PosicionamientoYtextoFinal = $escalaY[1] * $escalaFijaAncho;
            $PosicionamientoXtextoFinal = $escalaX[1] * $escalaFijaAncho;
            $posicionTextoX = $posicionImagenX[1] * $escalaFijaAncho;
            $posicionTextoY = $posicionImagenY[1] * $escalaFijaAlto;
            $textoCliente = $textoCliente[0];

            mensaje("Tamaño texto");
            mensaje("$tamañoTextoFinalAncho");

            mensaje("$tamañoTextoFinalAlto");



            //Valores fijos
            generarImagenConTextoMagicas($textoCliente, $tamañoTextoFinalAncho, $tamañoTextoFinalAlto, $fuente, $url_completa . 'con_texto.png', $colorTexto);

            $Texto_Cliente = new Imagick($url_completa . 'con_texto.png');
            $Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);
            $Texto_Cliente->writeImage($url_completa . 'Texto_Cliente.png');
            mensaje("Ancho y alto del texto");
            mensaje($imageClienteAncho[1] . "");

            mensaje($imageClienteAlto[1] . "");


            mensaje("Escala del texto");
            mensaje($escalaY[1] . "");

            mensaje($escalaX[1] . "");
            $imagenBase->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, $posicionTextoX, $posicionTextoY);
        }



        //Realiza el recorte final de la imagen, pero sin texto, deberia recortar con el texto incluido.
        
        $imagenBase->cropImage($felpudo_ancho, $felpudo_alto, $x, $y);
        $imagenBase->writeImage($url_completa . 'Felpudo_final_con_texto.png');



        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . $pedido.'_taza.png');
        mensaje("Felpudo creado correctamente " . $url_completa . '_taza.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}

function generarImagenConTextoMagicas($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
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
