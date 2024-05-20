<?php
##########################
##  PLACAS SIN LLAVEROS
##  CON Y SIN BASE
##########################
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


use JsonPath\JsonObject;

function CrearFelpudos33x60($registros)
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
        $fraseSuperior = trim((string)$fraseSuperior[0]);
    }else{
        $fraseSuperior = $xml->xpath('//children[name="Phrase supérieure"]/children/inputValue');
        $fraseSuperior = trim((string)$fraseSuperior[0]);
    }

    //echo "Frase Superior: " . $fraseSuperior[0] . "<br>";
    mensaje("Frase Superior " . "$fraseSuperior");
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
    //@$fraseSuperior = $fraseSuperior[0];

    if ($familia[0] === "Famlia Pareja + 3 Perros/Gatos") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascotas = ['izquierda' => $mascotaIzquierda, 'derecha' => $mascotaDerecha, 'inferior' => $mascotaCentro];
        parejaTresMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Soltero/a + Hijo/a") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda];
        $hijo = $zapatillaDerecha;
        mensaje('Zapatilla izquierda: ' . $zapatillaIzquierda);
        mensaje('Zapatilla pequeña: ' . $zapatillaDerecha);
        solteroHijo($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Soltero/a + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda];
        $mascota = $mascotaSoltero;
        solteroMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Pareja") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        familiaPareja($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Pareja + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascota = $mascotaSoltero;
        familiaParejaMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia Pareja + 2 Perros/Gatos") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascotas = ['superior' => $mascotaSuperior, 'inferior' => $mascotaInferior];
        familiaParejaDosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 3") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasCentro;
        parejaTres($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 3 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasCentro;
        $mascota = $mascotaSoltero;
        familiaTresUnaMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 3 + 2 Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasPequeñas;
        $mascotas = ['izquierda' => $mascotaInferiorIzquierda, 'derecha' => $mascotaInferiorDerecha];
        familiaTresDosMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 4") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['superior' => $zapatillasPequeñasSuperior, 'inferior' => $zapatillasPequeñasInferior];
        familiaCuatro($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 4 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha];
        $mascota = $mascotaSoltero;
        familiaCuatroUnaMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 4 + 2 Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['derecha' => $zapatillasPequeñasIzquierda, 'izquierda' => $zapatillasPequeñasDerecha];
        $mascotas = ['izquierda' => $mascotaIzquierda, 'derecha' => $mascotaDerecha];
        familiaCuatroDosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascotas, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 5") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'inferior' => $zapatillasPequeñasInferior];
        familiaCinco($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    } elseif ($familia[0] === "Famlia 5 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'centro' => $zapatillasPequeñasInferior];
        $mascota = $mascotaSoltero;
        familiaCincoMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa);
    } elseif ($familia === "Famlia 6") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'inferiorIzquierda' => $zapatillasInferiorIzquierda, 'inferiorDerecha' => $zapatillasInferiorDerecha];
        familiaSeis($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    } elseif ($familia[0] === "Diseño Love/33 x 60") {
        $nombre = $nombres[0];
        love($nombre, $url_completa);
    }  /* elseif ($familia[0] === "Mi Diseño/33 x 60") {

        miDiseño($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente);
    } */
}
function miDiseño($imageClienteAncho, $imageClienteAlto, $escalaX, $escalaY, $textoCliente, $fuente, $posicionImagenX, $posicionImagenY, $url_completa, $imagenCliente)
{
    try {
        $escalaFijaAncho = 10.35057471;
        $escalaFijaAlto = 10.45833333;
        $felpudo_ancho = 3602;
        $felpudo_alto = 2008;
        $posicionX = 26;
        $posicionY = 100;

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

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/personalizado.png');
        //Aqui tenemos que pasar los datos de la imagen del cliente
        $imagen_Cliente = new Imagick($url_completa . $imagenCliente[0]);
        $imagen_Cliente->resizeImage($imagenClienteEscaladaAncho, $imagenClienteEscaladaAlto, Imagick::FILTER_LANCZOS, 1);
        $imagenBase->compositeImage($imagen_Cliente, Imagick::COMPOSITE_OVER, $posicionImagenXEscalada, $posicionImagenYEscalada);
        $imagenBase->writeImage($url_completa . 'Felpudo_sin_recorte.png');
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
        generarImagenConTexto($textoCliente, $tamañoTextoFinalAncho, $tamañoTextoFinalAlto, $fuente, $url_completa . 'con_texto.png', "#615F5F");

        $Texto_Cliente = new Imagick($url_completa . 'con_texto.png');
        $Texto_Cliente->resizeImage($tamañoTextoFinalAncho, $tamañoTextoFinalAlto, Imagick::FILTER_LANCZOS, 1);

        $imagenBase->compositeImage($Texto_Cliente, Imagick::COMPOSITE_OVER, $posicionTextoX, $posicionTextoY);

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
function familiaSeis($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 6/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 6/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 6/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

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

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 150, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 150, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoInferiorIzquierda, $fuente, 150, 'black', $areaHijoInferiorIzquierda);
        escribirTextoEnArea($imagenBase, $hijoInferiorDerecha, $fuente, 150, 'black', $areaInferiorDerecha);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCincoMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 5 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 5 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 5 + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 246, 'y' => 1715, 'width' => 906, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2553, 'y' => 1715, 'width' => 906, 'height' => 200];

        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1272, 'y' => 1044, 'width' => 500, 'height' => 156];
        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 1962, 'y' => 1044, 'width' => 500, 'height' => 156];

        $hijoCentro = $hijos['centro'];
        $areaHijoCentro = ['x' => 1272, 'y' => 1810, 'width' => 500, 'height' => 156];

        $mascota = $mascota;
        $areaMascota = ['x' => 1962, 'y' => 1810, 'width' => 500, 'height' => 156];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 150, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 150, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoCentro, $fuente, 150, 'black', $areaHijoCentro);

        escribirTextoEnArea($imagenBase, $mascota, $fuente, 150, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCinco($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 5/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 5/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 5/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 246, 'y' => 1715, 'width' => 906, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2553, 'y' => 1715, 'width' => 906, 'height' => 200];



        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1272, 'y' => 1044, 'width' => 500, 'height' => 156];

        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 1962, 'y' => 1044, 'width' => 500, 'height' => 156];

        $hijoInferior = $hijos['inferior'];
        $areaHijoInferior = ['x' => 1574, 'y' => 1810, 'width' => 500, 'height' => 156];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 150, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 150, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoInferior, $fuente, 150, 'black', $areaHijoInferior);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCuatroDosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4 + 2 PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4 + 2 PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4 + 2 PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 246, 'y' => 1715, 'width' => 906, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2553, 'y' => 1715, 'width' => 906, 'height' => 200];

        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1272, 'y' => 1044, 'width' => 500, 'height' => 156];
        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 1962, 'y' => 1044, 'width' => 500, 'height' => 156];

        $mascotaIzquierda = $mascotas['izquierda'];
        $areaMascotaIzquierda = ['x' => 1272, 'y' => 1715, 'width' => 500, 'height' => 156];

        $mascotaDerecha = $mascotas['derecha'];
        $areaMascotaDerecha = ['x' => 1962, 'y' => 1715, 'width' => 500, 'height' => 156];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 150, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 150, 'black', $areaHijoDerecha);

        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 150, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 150, 'black', $areaMascotaDerecha);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCuatroUnaMascota($coloresZapatillas,$fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa)
{
    try {

        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4 + PerroGato/Zapatillas-Rojas.png');
        }


        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 246, 'y' => 1715, 'width' => 906, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2553, 'y' => 1715, 'width' => 906, 'height' => 200];



        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1247, 'y' => 1044, 'width' => 500, 'height' => 156];

        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 1962, 'y' => 1044, 'width' => 500, 'height' => 156];

        $mascota = $mascota;
        $areaMascota = ['x' => 1574, 'y' => 1791, 'width' => 500, 'height' => 156];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);


        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 150, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 150, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 150, 'black', $areaMascota);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente " . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaCuatro($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 4/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 306, 'y' => 1700, 'width' => 900, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2448, 'y' => 1700, 'width' => 900, 'height' => 200];

        $zapatillasPequeñasSuperior = $hijos['superior'];
        $areazapatillasPequeñasSuperior = ['x' => 1350, 'y' => 1000, 'width' => 948, 'height' => 205];

        $zapatillasPequeñasInferior = $hijos['inferior'];
        $areazapatillasPequeñasInferior = ['x' => 1350, 'y' => 1800, 'width' => 948, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $zapatillasPequeñasSuperior, $fuente, 150, 'black', $areazapatillasPequeñasSuperior);
        escribirTextoEnArea($imagenBase, $zapatillasPequeñasInferior, $fuente, 150, 'black', $areazapatillasPequeñasInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaTresDosMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3 + 2 PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3 + 2 PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3 + 2 PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 287, 'y' => 1758, 'width' => 800, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2594, 'y' => 1758, 'width' => 800, 'height' => 200];

        $hijo = $hijo;
        $areaHijoSuperior = ['x' => 1401, 'y' => 1180, 'width' => 800, 'height' => 200];

        $mascotaIzquierda = $mascotas['izquierda'];
        $areaMascotaIzquierda = ['x' => 1142, 'y' => 1770, 'width' => 700, 'height' => 200];

        $mascotaDerecha = $mascotas['derecha'];
        $areaMascotaDerecha = ['x' => 1859, 'y' => 1770, 'width' => 700, 'height' => 200];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 180, 'black', $areaHijoSuperior);
        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 150, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 150, 'black', $areaMascotaDerecha);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaTresUnaMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3 + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 442, 'y' => 1700, 'width' => 900, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2500, 'y' => 1700, 'width' => 900, 'height' => 200];

        $hijo = $hijo;
        $areaHijoSuperior = ['x' => 1400, 'y' => 1100, 'width' => 900, 'height' => 150];

        $mascota = $mascota;
        $areaMascotaInferior = ['x' => 1400, 'y' => 1850, 'width' => 900, 'height' => 150];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 150, 'black', $areaHijoSuperior);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 150, 'black', $areaMascotaInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function parejaTres($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia 3/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 291, 'y' => 1713, 'width' => 990, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2403, 'y' => 1713, 'width' => 990, 'height' => 200];

        $hijo = $hijo;
        $areaHijoCentro = ['x' => 1306, 'y' => 1398, 'width' => 990, 'height' => 200];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 150, 'black', $areaHijoCentro);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaParejaDosMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + 2 PerrosGatos/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + 2 PerrosGatos/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + 2 PerrosGatos/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 492, 'y' => 1776, 'width' => 700, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2542, 'y' => 1776, 'width' => 700, 'height' => 200];

        $mascotaSuperior = $mascotas['superior'];
        $areaMascotaSuperior = ['x' => 1489, 'y' => 1000, 'width' => 700, 'height' => 200];

        $mascotaInferior = $mascotas['inferior'];
        $areaMascotaInferior = ['x' => 1489, 'y' => 1600, 'width' => 700, 'height' => 200];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $mascotaSuperior, $fuente, 190, 'black', $areaMascotaSuperior);
        escribirTextoEnArea($imagenBase, $mascotaInferior, $fuente, 190, 'black', $areaMascotaInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaParejaMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 348, 'y' => 1733, 'width' => 900, 'height' => 200];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2460, 'y' => 1733, 'width' => 900, 'height' => 200];
        $mascota = $mascota;
        $areaMascota = ['x' => 1384, 'y' => 1300, 'width' => 900, 'height' => 200];


        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 150, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function familiaPareja($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        //$areaFraseSuperior = ['x' => 100, 'y' => 87, 'width' => 3292, 'height' => 400];;


        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 400, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 513, 'y' => 1688, 'width' => 1086, 'height' => 218];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2028, 'y' => 1688, 'width' => 1086, 'height' => 218];


        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function solteroMascota($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Soltero+mascota/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Soltero+mascota/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Soltero+mascota/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");
        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 704, 'y' => 1700, 'width' => 924, 'height' => 277];

        $areaMascota = ['x' => 1850, 'y' => 1700, 'width' => 924, 'height' => 277];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 180, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function solteroHijo($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas == "Zapatillas Rojo/Negro") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Soltero+hijo/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas == "Zapatillas Negras") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Soltero+hijo/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Soltero+hijo/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");
        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 747, 'y' => 1662, 'width' => 924, 'height' => 210];

        $areaHijo = ['x' => 1863, 'y' => 1662, 'width' => 924, 'height' => 210];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $hijo, $fuente, 180, 'black', $areaHijo);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function parejaTresMascotas($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + 3 PerrosGatos/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + 3 PerrosGatos/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/Famlia Pareja + 3 PerrosGatos/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow" || $fuente === "Harlow Solid") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 249, 'y' => 162, 'width' => 3104, 'height' => 403];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 300, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 372, 'y' => 1713, 'width' => 900, 'height' => 170];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 2508, 'y' => 1713, 'width' => 900, 'height' => 170];

        $mascotaIzquierda = $mascotas['izquierda'];
        $areaMascotaIzquierda = ['x' => 1140, 'y' => 1014, 'width' => 660, 'height' => 144];

        $mascotaDerecha = $mascotas['derecha'];
        $areaMascotaDerecha = ['x' => 1836, 'y' => 966, 'width' => 660, 'height' => 144];

        $mascotaInferior = $mascotas['inferior'];
        $areaMascotaInferior = ['x' => 1476, 'y' => 1569, 'width' => 660, 'height' => 144];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 180, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 180, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 150, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 150, 'black', $areaMascotaDerecha);
        escribirTextoEnArea($imagenBase, $mascotaInferior, $fuente, 150, 'black', $areaMascotaInferior);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function love($nombre, $url_completa)
{
    try {

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/love.png');
        $fuente = 'productos/felpudos-familia/fuente/lemon_tuesday/Lemon-Tuesday.otf';

        $areaNombre = ['x' => 305, 'y' => 864, 'width' => 2743, 'height' => 425];
        escribirTextoEnArea($imagenBase, $nombre, $fuente, 400, 'black', $areaNombre);
        mensaje("$nombre se escribio correctamente");

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function hogar($nombre, $url_completa)
{
    try {

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/hogar.png');
        $fuente = 'productos/felpudos-familia/fuente/impact/impact.ttf';

        $areaNombre = ['x' => 905, 'y' => 1427, 'width' => 1802, 'height' => 186];
        escribirTextoEnArea($imagenBase, $nombre, $fuente, 200, 'black', $areaNombre);
        mensaje("$nombre se escribio correctamente");

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function bienvenidosNombre($nombre, $url_completa)
{
    try {

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/bienvenidos-nombre.png');
        $fuente = 'productos/felpudos-familia/fuente/impact/impact.ttf';

        $areaNombre = ['x' => 1178, 'y' => 1181, 'width' => 1218, 'height' => 300];
        escribirTextoEnArea($imagenBase, $nombre, $fuente, 100, 'black', $areaNombre);
        mensaje("$nombre se escribio correctamente");

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}
function bienvenidosIniciales($nombre, $url_completa)
{
    try {

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_33x60/bienvenidos-nombre.png');
        $fuente = 'productos/felpudos-familia/fuente/impact/impact.ttf';

        $areaNombre = ['x' => 1216, 'y' => 1474, 'width' => 1297, 'height' => 270];
        escribirTextoEnArea($imagenBase, $nombre, $fuente, 100, 'black', $areaNombre);
        mensaje("$nombre se escribio correctamente");

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente" . $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}

/* function generarImagenConTexto($texto, $anchoArea, $altoArea, $fuente, $rutaGuardado, $colorTexto)
{
    // Crear una nueva imagen en blanco
    $imagen = new Imagick();
    $imagen->newImage($anchoArea, $altoArea, new ImagickPixel('transparent'));
    $imagen->setImageFormat('png');

    $draw = new ImagickDraw();
    $draw->setFont("$fuente");
    $fontSize = 1; // Empieza con un tamaño de fuente pequeño

    mensaje("$texto");
    mensaje("$anchoArea");
    mensaje("$altoArea");
    mensaje("$fuente");
    mensaje("$rutaGuardado");
    mensaje("$colorTexto");

    // Ajuste el tamaño de fuente hasta que el texto ocupe el ancho y alto especificados
    do {
        $draw->setFontSize($fontSize . 'px');
        $boundingBox = $imagen->queryFontMetrics($draw, $texto);
        $textoAncho = $boundingBox['textWidth'];
        $textoAlto = $boundingBox['textHeight'];
        $fontSize++; // Incrementa el tamaño de fuente
    } while ($textoAncho < $anchoArea && $textoAlto < $altoArea);

    // Calcular la posición vertical para que el texto esté centrado verticalmente
    $posicionVertical = ($altoArea - $textoAlto) / 2 . 'px';
    mensaje($posicionVertical);
    $y = $posicionVertical;
    $lineas = explode("\n", $texto);

    $textoAlto = 0;
    foreach ($lineas as $linea) {
        // Obtener las dimensiones de cada línea
        $boundingBox = $imagen->queryFontMetrics($draw, $linea);
        $textoAncho = $boundingBox['textWidth'];

        // Calcular la posición horizontal para centrar el texto
        $posicionHorizontal = ($anchoArea - $textoAncho) / 2 . 'px';

        // Establecer el color del texto
        $draw->setFillColor($colorTexto);

        // Anotar la imagen con el texto centrado
        $imagen->annotateImage($draw, $posicionHorizontal, $y + $boundingBox['ascender'], 0, $linea);

        $y += $boundingBox['textHeight'];
    }
    mensaje($posicionHorizontal);
    // Guardar la imagen
    $imagen->writeImage($rutaGuardado);
} */
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
