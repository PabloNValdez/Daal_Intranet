<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 */

use JsonPath\JsonObject;

function CrearFelpudos40x70($registros)
{
    global $registros;
    $url_completa = "subidas/" . $registros["url_completa"];
    $url_completa = "subidas/" . obtenerURL($url_completa) . "/";

    $json_ubicacion = "subidas/" . $registros["url_completa"];
    $json = file_get_contents($json_ubicacion);

    $urlXml = str_replace('.json', '.xml', $json_ubicacion);
    mensaje("XML: " . $urlXml);
    $datos = json_decode($json, true);
    $jsonObject = new JsonObject($datos);
    mensaje("-----------------------");
    $familia = $jsonObject->get('$..children[0].name');
    //echo "Tipo de familia: " . $familia[0] . "<br>";
    mensaje($familia[0]);

    ########## MI DISEÑO #######
    $imageClienteAncho = $jsonObject->get('$..buyerPlacement.dimension.width');
    $imageClienteAlto = $jsonObject->get('$..buyerPlacement.dimension.height');

   /*  mensaje("Imagen cliente Ancho" . $imageClienteAncho[0]);
    mensaje("Imagen cliente Alto" . $imageClienteAlto[0]); */

    $escalaX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
    $escalaY = $jsonObject->get('$..buyerPlacement.scale.scaleY');

  /*   mensaje("Imagen escala x" . $escalaX[0]);
    mensaje("Imagen escala y" . $escalaY[0]); */

    $textoCliente = $jsonObject->get('$..inputValue');
    //Posicionamiento X,Y
    $posicionImagenX = $jsonObject->get('$..buyerPlacement.position.x');
    $posicionImagenY = $jsonObject->get('$..buyerPlacement.position.y');

    /* mensaje("Imagen posicion x" . $posicionImagenX[0]);
    mensaje("Imagen posicion y" . $posicionImagenY[0]); */

    $imagenCliente = $jsonObject->get('$..image.imageName');

    ########## FIN MI DISEÑO #######
    $zapatillas = $jsonObject->get('$..optionSelection.name');
    //echo "Colores de Zapatillas: " . $zapatillas[0] . "<br>";
    $fuente = $jsonObject->get('$..fontSelection.family');
    //echo "Fuente: " . $fuente[0] . "<br>";
    // Cargar el XML

    $xml = simplexml_load_file($urlXml);

    // Encontrar el valor basado en el nombre
    $fraseSuperior = $xml->xpath('//children[name="Frase superior"]/children/inputValue');
    if (!empty($fraseSuperior)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $fraseSuperior = (string)$fraseSuperior[0];
    }else{
        $fraseSuperior = $xml->xpath('//children[name="Phrase supérieure"]/children/inputValue');
        $fraseSuperior = (string)$fraseSuperior[0];
    }

    //echo "Frase Superior: " . $fraseSuperior[0] . "<br>";
    mensaje("Frase Superior " . $fraseSuperior);
    ##Nombre de zapatillas
    //$zapatillaIzquierda =  $jsonObject->get('$..children[?(@.label=="Nombre Zapatillas Izquierda")].inputValue');
    // Verificar si se encontró el valor
    $zapatillaIzquierda = $xml->xpath('//children[name="Nombre Zapatillas Izquierda"]/children/inputValue');
    
    // Verificar si se encontró el valor
    if (!empty($zapatillaIzquierda)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillaIzquierda = (string)$zapatillaIzquierda[0];
        // Imprimir el resultado
        mensaje($zapatillaIzquierda);
    } else {
        mensaje("No se encontró el valor con el nombre especificado.");
    }

    //echo "Nombre Zapatillas Izquierda: " . $zapatillaIzquierda . "<br>";
    //$zapatillaDerecha =  $jsonObject->get('$..children[?(@.label=="Nombre Zapatillas Derecha")].inputValue');
    $zapatillaDerecha = $xml->xpath('//children[name="Nombre Zapatillas Derecha"]/children/inputValue');
    
    // Verificar si se encontró el valor
    if (!empty($zapatillaDerecha)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillaDerecha = (string)$zapatillaDerecha[0];
        // Imprimir el resultado
        mensaje($zapatillaDerecha);
    } else {
        mensaje("No se encontró el valor con el nombre especificado.");
    }



    //echo "Nombre Zapatillas Derecha: " . $zapatillaDerecha . "<br>";
    ##Nombre Mascotas e hijos
    $mascotaIzquierda = $xml->xpath('//children[name="Nombre Mascota Izquierda"]/children/inputValue');
    if (!empty($mascotaIzquierda)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaIzquierda = (string)$mascotaIzquierda[0];
    }else{
        $mascotaIzquierda = $xml->xpath('//children[name="Nombre Mascota izquierda"]/children/inputValue');
        $mascotaIzquierda = (string)$mascotaIzquierda[0];
    }

    //echo "Nombre Mascota Izquierda: " . $mascotaIzquierda[0] . "<br>";
    ##Nombre Mascotas e hijos
    $mascotaDerecha = $xml->xpath('//children[name="Nombre Mascota Derecha"]/children/inputValue');
    if (!empty($mascotaDerecha)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaDerecha = (string)$mascotaDerecha[0];
    }else{
        $mascotaDerecha = $xml->xpath('//children[name="Nombre Mascota derecha"]/children/inputValue');
        $mascotaDerecha = (string)$mascotaDerecha[0];
    }


    //echo "Nombre Mascota Derecha: " . $mascotaDerecha[0] . "<br>";
    ##Nombre Mascotas e hijos

    $mascotaInferior = $xml->xpath('//children[name="Nombre Mascota Inferior"]/children/inputValue');
    if (!empty($mascotaInferior)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaInferior = (string)$mascotaInferior[0];
    }
    //echo "Nombre Mascota Inferior: " . $mascotaInferior[0] . "<br>";
    $zapatillasPequeñas = $xml->xpath('//children[name="Nombre Zapatillas Pequeñas"]/children/inputValue');
    if (!empty($zapatillasPequeñas)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasPequeñas = (string)$zapatillasPequeñas[0];
    }


    //echo "Nombre Zapatillas Pequeñas: " . $zapatillasPequeñas[0] . "<br>";
    $mascotaSoltero = $xml->xpath('//children[name="Nombre Mascota"]/children/inputValue');
    if (!empty($mascotaSoltero)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaSoltero = (string)$mascotaSoltero[0];
    }else{
        $mascotaSoltero = $xml->xpath('//children[name="Nombre mascota"]/children/inputValue');
        $mascotaSoltero = (string)$mascotaSoltero[0];
    }



    $mascotaCentro = $xml->xpath('//children[name="Nombre Mascota Centro"]/children/inputValue');
    if (!empty($mascotaCentro)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaCentro = (string)$mascotaCentro[0];
    }

    //echo "Nombre Mascota Soltero: " . $mascotaSoltero[0] . "<br>";
    $mascotaSuperior = $xml->xpath('//children[name="Nombre Mascota Superior"]/children/inputValue');
    if (!empty($mascotaSuperior)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaSuperior = (string)$mascotaSuperior[0];
    }


    //echo "Nombre Mascota Superior: " . $mascotaSuperior[0] . "<br>";
    $zapatillasCentro  = $xml->xpath('//children[name="Nombre Zapatillas Pequeñas Centro"]/children/inputValue');
    if (!empty($zapatillasCentro )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasCentro  = (string)$zapatillasCentro[0];
    }



    //echo "Nombre Zapatillas Pequeñas Centro: " . $zapatillasCentro[0] . "<br>";
    $mascotaInferiorIzquierda  = $xml->xpath('//children[name="Nombre Mascota Inferior Izquierda"]/children/inputValue');
    if (!empty($mascotaInferiorIzquierda )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaInferiorIzquierda  = (string)$mascotaInferiorIzquierda[0];
    }


    //echo "Nombre Mascota Inferior Izquierda: " . $mascotaInferiorIzquierda[0] . "<br>";
    $mascotaInferiorDerecha  = $xml->xpath('//children[name="Nombre Mascota Inferior Derecha"]/children/inputValue');
    if (!empty($mascotaInferiorDerecha )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $mascotaInferiorDerecha  = (string)$mascotaInferiorDerecha[0];
    }

    //echo "Nombre Mascota Inferior Derecha: " . $mascotaInferiorDerecha[0] . "<br>";
    $zapatillasPequeñasSuperior  = $xml->xpath('//children[name="Nombre Zapatillas Pequeñas Superior"]/children/inputValue');
    if (!empty($zapatillasPequeñasSuperior )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasPequeñasSuperior  = (string)$zapatillasPequeñasSuperior[0];
    }


    //echo "Nombre Zapatillas Pequeñas Superior: " . $zapatillasPequeñasSuperior[0] . "<br>";
    if (@$zapatillasPequeñasSuperior[0] == NULL) {
        $zapatillasPequeñasSuperior  = $xml->xpath('//children[name="Nombre zapatillas pequeñas Superior"]/children/inputValue');
        $zapatillasPequeñasSuperior  = (string)$zapatillasPequeñasSuperior[0];
    }


    $zapatillasPequeñasInferior = $xml->xpath('//children[name="Nombre Zapatillas Pequeñas Inferior"]/children/inputValue');
    if (!empty($zapatillasPequeñasInferior)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasPequeñasInferior = (string)$zapatillasPequeñasInferior[0];
    }else{
        $zapatillasPequeñasInferior = $xml->xpath('//children[name="Nombre zapatillas pequeñas inferior"]/children/inputValue');
        $zapatillasPequeñasInferior = (string)$zapatillasPequeñasInferior[0];
    }


    $zapatillasPequeñasIzquierda  = $xml->xpath('//children[name="Nombre Zapatillas Pequeñas Izquierda"]/children/inputValue');
    if (!empty($zapatillasPequeñasIzquierda )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasPequeñasIzquierda  = (string)$zapatillasPequeñasIzquierda[0];
    }


    //echo "Nombre Zapatillas Pequeñas Izquierda: " . $zapatillasPequeñasIzquierda[0] . "<br>";

    $zapatillasPequeñasDerecha = $xml->xpath('//children[name="Nombre Zapatillas Pequeñas Derecha"]/children/inputValue');
    if (!empty($zapatillasPequeñasDerecha )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasPequeñasDerecha  = (string)$zapatillasPequeñasDerecha[0];
    }

    //echo "Nombre Zapatillas Pequeñas Derecha: " . $zapatillasPequeñasDerecha[0] . "<br>";


    $zapatillasInferiorIzquierda = $xml->xpath('//children[name="Nombre Zapatillas Inferior Izquierda"]/children/inputValue');
    if (!empty($zapatillasInferiorIzquierda )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasInferiorIzquierda  = (string)$zapatillasInferiorIzquierda[0];
    }
    //echo "Nombre Zapatillas Inferior Izquierda: " . $zapatillasInferiorIzquierda[0] . "<br>";

    $zapatillasInferiorDerecha = $xml->xpath('//children[name="Nombre Zapatillas Inferior Derecha"]/children/inputValue');
    if (!empty($zapatillasInferiorDerecha )) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $zapatillasInferiorDerecha  = (string)$zapatillasInferiorDerecha[0];
    }
    //echo "Nombre Zapatillas Inferior Derecha: " . $zapatillasInferiorDerecha[0] . "<br>";


    $nombres = $jsonObject->get('$..children[?(@.label=="Apellidos")].inputValue');

    @$fuente = $fuente[0];
    if (@$zapatillas[0] != NULL) {
        $coloresZapatillas = $zapatillas[0];
    }

    $infoExtra = $xml->xpath('//areas[name="Información Extra"]/text');

    // Verificar si el elemento text tiene contenido
    if (!empty($infoExtra[0])) {
        $infoExtra = (string) $infoExtra[0];
        escribirInfoExtra($infoExtra, $url_completa);
    }

    if ($familia[0] === "Famlia Pareja + 3 Perros/Gatos") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascotas = ['izquierda' => $mascotaIzquierda, 'derecha' => $mascotaDerecha, 'inferior' => $mascotaCentro];
        familiaPareja40x70Mascotas40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Soltero/a + Hijo/a") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda];
        $hijo = $zapatillaDerecha;
        mensaje('Zapatilla izquierda: ' . $zapatillaIzquierda);
        mensaje('Zapatilla pequeña: ' . $zapatillaDerecha);
        solteroHijo40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Soltero/a + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda];
        $mascota = $mascotaSoltero;
        solteroMascota40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Pareja") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        familiaPareja40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Pareja + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascota = $mascotaSoltero;
        familiaPareja40x70Mascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Pareja + 2 Perros/Gatos") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascotas = ['superior' => $mascotaSuperior, 'inferior' => $mascotaInferior];
        familiaPareja40x70DosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 3") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasCentro;
        familiaTres40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 3 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasCentro;
        $mascota = $mascotaSoltero;
        familiaTresUnaMascota40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 3 + 2 Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasPequeñas;
        $mascotas = ['izquierda' => $mascotaInferiorIzquierda, 'derecha' => $mascotaInferiorDerecha];
        familiaTresDosMascota40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 4") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['superior' => $zapatillasPequeñasSuperior, 'inferior' => $zapatillasPequeñasInferior];
        familiaCuatro40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 4 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['derecha' => $zapatillasPequeñasIzquierda, 'izquierda' => $zapatillasPequeñasDerecha];
        $mascota = $mascotaSoltero;
        familiaCuatro40x70UnaMascota($fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 4 + 2 Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['derecha' => $zapatillasPequeñasIzquierda, 'izquierda' => $zapatillasPequeñasDerecha];
        $mascotas = ['izquierda' => $mascotaIzquierda, 'derecha' => $mascotaDerecha];
        familiaCuatro40x70DosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 5") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'inferior' => $zapatillasPequeñasInferior];
        familiaCinco40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 5 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'centro' => $zapatillasPequeñasInferior];
        $mascota = $mascotaSoltero;
        familiaCinco40x70Mascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 6") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'inferiorIzquierda' => $zapatillasInferiorIzquierda, 'inferiorDerecha' => $zapatillasInferiorDerecha];
        familiaSeis40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    } /* elseif ($familia[0] === "Mi Diseño/40 x 70") {

        miDiseño40($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente);
    } */
}
function miDiseño40($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente)
{
    try {
        $escalaFijaAncho = 12.90153846;
        $escalaFijaAlto = 13.75568182;
        $felpudo_ancho = 4193;
        $felpudo_alto = 2421;
        $posicionX = 38;
        $posicionY = 108;

        $imagenEscalaAncho = $imageClienteAncho[0] * $escalaY[0];
        $imagenEscalaAlto = $imageClienteAlto[0] * $escalaX[0];
        mensaje("Primer escalado de Imagen");
        mensaje("$imagenEscalaAncho");
        mensaje("$imagenEscalaAlto");


        $imagenClienteEscaladaAncho = $imagenEscalaAncho * $escalaFijaAncho;
        $imagenClienteEscaladaAlto = $imagenEscalaAlto * $escalaFijaAlto;
        mensaje("Escaladode Imagen final");
        mensaje("$imagenClienteEscaladaAncho");

        mensaje("$imagenClienteEscaladaAlto");


        $posicionImagenXEscalada = $posicionImagenX[0] * $escalaFijaAncho;
        $posicionImagenYEscalada = $posicionImagenY[0] * $escalaFijaAlto;

        mensaje("Posicion Escalada Imagen final");
        mensaje("$posicionImagenXEscalada");
        mensaje("$posicionImagenYEscalada");


        $x = $posicionX * $escalaFijaAncho;
        $y = $posicionY * $escalaFijaAlto;


        if ($fuente === "Arial") {
            $fuente = 'productos/felpudos-familia/fuente/arial/arial.ttf';
        } elseif ($fuente === "Georgia") {
            $fuente = 'Georgia';
        } elseif ($fuente === "Geometos Rounded") {
            $fuente = 'productos/felpudos-familia/fuente/geometos_rounded/Geometos Rounded.ttf';
        } elseif ($fuente === "Violette") {
            $fuente = 'productos/felpudos-familia/fuente/violette_2/Violette.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        }

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/40x70.png');
        //Aqui tenemos que pasar los datos de la imagen del cliente
        $imagen_Cliente = new Imagick($url_completa . $imagenCliente[0]);
        $imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
        $imagenBase->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);
        $imagenBase->writeImage($url_completa . 'Felpudo_sin_recorte.jpg');
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
        $textoCliente = $textoCliente[0];

        mensaje("Tamaño texto");
        mensaje("$tamañoTextoFinalAncho");

        mensaje("$tamañoTextoFinalAlto");



        //Valores fijos
        if (!empty($textoCliente)) {
            generarImagenConTexto40($textoCliente, $tamañoTextoFinalAncho, $tamañoTextoFinalAlto, $fuente, $url_completa . 'con_texto.png', "#615F5F");
            $Texto_Cliente = new Imagick($url_completa . 'con_texto.png');
            $Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);
            $imagenBase->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, $posicionTextoX, $posicionTextoY);
        }


        //Realiza el recorte final de la imagen, pero sin texto, deberia recortar con el texto incluido. 
        $imagenBase->cropImage($felpudo_ancho, $felpudo_alto, $x, $y);
        $imagenBase->writeImage($url_completa . 'Felpudo_final_con_texto.png');

        mensaje("Ancho y alto del texto");
        mensaje($imageClienteAncho[1]);

        mensaje($imageClienteAlto[1]);


        mensaje("Escala del texto");
        mensaje($escalaY[1]);

        mensaje($escalaX[1]);



        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente " . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}

function generarImagenConTexto40($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
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


function familiaSeis40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 6/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 6/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 6/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 296, 'y' => 2000, 'width' => 1120, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2948, 'y' => 2000, 'width' => 1120, 'height' => 277];

        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1472, 'y' => 1300, 'width' => 576, 'height' => 164];
        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 2296, 'y' => 1300, 'width' => 576, 'height' => 164];
        $hijoInferiorIzquierda = $hijos['inferiorIzquierda'];
        $areaHijoInferiorIzquierda = ['x' => 1472, 'y' => 2214, 'width' => 576, 'height' => 205];
        $hijoInferiorDerecha = $hijos['inferiorDerecha'];
        $areaInferiorDerecha = ['x' => 2296, 'y' => 2214, 'width' => 576, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 166, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 166, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoInferiorIzquierda, $fuente, 166, 'black', $areaHijoInferiorIzquierda);
        escribirTextoEnArea($imagenBase, $hijoInferiorDerecha, $fuente, 166, 'black', $areaInferiorDerecha);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCinco40x70Mascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 5 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 5 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 5 + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 296, 'y' => 2000, 'width' => 1120, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2948, 'y' => 2000, 'width' => 1120, 'height' => 277];

        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1472, 'y' => 1300, 'width' => 576, 'height' => 164];
        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 2296, 'y' => 1300, 'width' => 576, 'height' => 164];
        $hijoCentro = $hijos['centro'];
        $areaHijoCentro = ['x' => 1472, 'y' => 2214, 'width' => 576, 'height' => 205];

        $mascota = $mascota;
        $areaMascota = ['x' => 2296, 'y' => 2214, 'width' => 576, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 166, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 166, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoCentro, $fuente, 166, 'black', $areaHijoCentro);

        escribirTextoEnArea($imagenBase, $mascota, $fuente, 166, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCinco40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 5/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 5/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 5/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 296, 'y' => 2000, 'width' => 1120, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2948, 'y' => 2000, 'width' => 1120, 'height' => 277];

        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1472, 'y' => 1300, 'width' => 576, 'height' => 164];

        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 2296, 'y' => 1300, 'width' => 576, 'height' => 164];

        $hijoInferior = $hijos['inferior'];
        $areaHijoInferior = ['x' => 1680, 'y' => 2214, 'width' => 892, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 200, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 200, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoInferior, $fuente, 200, 'black', $areaHijoInferior);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCuatro40x70DosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4 + 2 PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4 + 2 PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4 + 2 PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 222, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2842, 'y' => 2076, 'width' => 1236, 'height' => 277];

        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1400, 'y' => 1317, 'width' => 716, 'height' => 205];

        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 2200, 'y' => 1317, 'width' => 716, 'height' => 205];

        $mascotaIzquierda = $mascotas['izquierda'];
        $areaMascotaIzquierda = ['x' => 1416, 'y' => 2000, 'width' => 716, 'height' => 205];

        $mascotaDerecha = $mascotas['derecha'];
        $areaMascotaDerecha = ['x' => 2208, 'y' => 2000, 'width' => 716, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 200, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 200, 'black', $areaHijoDerecha);

        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 200, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 200, 'black', $areaMascotaDerecha);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCuatro40x70UnaMascota($fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa)
{
    try {

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4 + PerroGato/Zapatillas-Rojo-Negro.png');

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 222, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2842, 'y' => 2076, 'width' => 1236, 'height' => 277];



        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1400, 'y' => 1317, 'width' => 716, 'height' => 205];

        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 2200, 'y' => 1317, 'width' => 716, 'height' => 205];

        $mascota = $mascota;
        $areaMascota = ['x' => 1628, 'y' => 2130, 'width' => 948, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);


        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 200, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 200, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 200, 'black', $areaMascota);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCuatro40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 4/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 292, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2742, 'y' => 2076, 'width' => 1236, 'height' => 277];

        $zapatillasPequeñasSuperior = $hijos['superior'];
        $areazapatillasPequeñasSuperior = ['x' => 1652, 'y' => 1250, 'width' => 948, 'height' => 205];

        $zapatillasPequeñasInferior = $hijos['inferior'];
        $areazapatillasPequeñasInferior = ['x' => 1652, 'y' => 2150, 'width' => 948, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $zapatillasPequeñasSuperior, $fuente, 230, 'black', $areazapatillasPequeñasSuperior);
        escribirTextoEnArea($imagenBase, $zapatillasPequeñasInferior, $fuente, 230, 'black', $areazapatillasPequeñasInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaTresDosMascota40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3 + 2 PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3 + 2 PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3 + 2 PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 222, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2842, 'y' => 2076, 'width' => 1236, 'height' => 277];

        $hijo = $hijo;
        $areaHijoSuperior = ['x' => 1652, 'y' => 1400, 'width' => 948, 'height' => 205];

        $mascotaIzquierda = $mascotas['izquierda'];
        $areaMascotaIzquierda = ['x' => 1416, 'y' => 2100, 'width' => 716, 'height' => 205];

        $mascotaDerecha = $mascotas['derecha'];
        $areaMascotaDerecha = ['x' => 2208, 'y' => 2100, 'width' => 716, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 230, 'black', $areaHijoSuperior);
        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 230, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 230, 'black', $areaMascotaDerecha);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaTresUnaMascota40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3 + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 292, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2742, 'y' => 2076, 'width' => 1236, 'height' => 277];

        $hijo = $hijo;
        $areaHijoSuperior = ['x' => 1652, 'y' => 1400, 'width' => 948, 'height' => 205];

        $mascota = $mascota;
        $areaMascotaInferior = ['x' => 1652, 'y' => 2150, 'width' => 948, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 230, 'black', $areaHijoSuperior);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 230, 'black', $areaMascotaInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaTres40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia 3/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 356, 'y' => 2100, 'width' => 1120, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2748, 'y' => 2100, 'width' => 1120, 'height' => 277];

        $hijo = $hijo;
        $areaHijoCentro = ['x' => 1596, 'y' => 1700, 'width' => 1064, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 230, 'black', $areaHijoCentro);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaPareja40x70DosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 292, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2742, 'y' => 2076, 'width' => 1236, 'height' => 277];

        $mascotaSuperior = $mascotas['superior'];
        $areaMascotaSuperior = ['x' => 1652, 'y' => 1250, 'width' => 948, 'height' => 205];

        $mascotaInferior = $mascotas['inferior'];
        $areaMascotaInferior = ['x' => 1652, 'y' => 1900, 'width' => 948, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $mascotaSuperior, $fuente, 230, 'black', $areaMascotaSuperior);
        escribirTextoEnArea($imagenBase, $mascotaInferior, $fuente, 230, 'black', $areaMascotaInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaPareja40x70Mascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 292, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2742, 'y' => 2076, 'width' => 1236, 'height' => 277];
        $mascota = $mascota;
        $areaMascota = ['x' => 1644, 'y' => 1631, 'width' => 985, 'height' => 205];


        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 230, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaPareja40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 604, 'y' => 2100, 'width' => 1176, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2348, 'y' => 2100, 'width' => 1176, 'height' => 277];


        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function solteroMascota40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Soltero+mascota/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Soltero+mascota/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Soltero+mascota/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 904, 'y' => 2100, 'width' => 924, 'height' => 277];
        $areaMascota = ['x' => 2224, 'y' => 2100, 'width' => 924, 'height' => 277];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 250, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 250, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function solteroHijo40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas == "Zapatillas Rojo/Negro") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Soltero+hijo/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas == "Zapatillas Negras") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Soltero+hijo/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Soltero+hijo/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");
        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 904, 'y' => 2100, 'width' => 924, 'height' => 277];
        $areaHijo = ['x' => 2224, 'y' => 2100, 'width' => 924, 'height' => 277];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 250, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $hijo, $fuente, 250, 'black', $areaHijo);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaPareja40x70Mascotas40x70($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + 3 PerrosGatos/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + 3 PerrosGatos/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_40x70/Famlia Pareja + 3 PerrosGatos/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 100, 'y' => 160, 'width' => 3992, 'height' => 500];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 296, 'y' => 2100, 'width' => 1120, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2748, 'y' => 2100, 'width' => 1120, 'height' => 277];

        $mascotaIzquierda = $mascotas['izquierda'];
        $areaMascotaIzquierda = ['x' => 1372, 'y' => 1250, 'width' => 576, 'height' => 164];

        $mascotaDerecha = $mascotas['derecha'];
        $areaMascotaDerecha = ['x' => 2136, 'y' => 1250, 'width' => 576, 'height' => 164];

        $mascotaInferior = $mascotas['inferior'];
        $areaMascotaInferior = ['x' => 1628, 'y' => 1952, 'width' => 892, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 230, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 230, 'black', $areaMascotaDerecha);
        escribirTextoEnArea($imagenBase, $mascotaInferior, $fuente, 230, 'black', $areaMascotaInferior);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
