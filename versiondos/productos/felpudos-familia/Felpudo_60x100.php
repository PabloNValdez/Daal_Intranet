<?php
##########################
##  PLACAS SIN LLAVEROS
##  CON Y SIN BASE
##########################
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
use JsonPath\JsonObject;
function CrearFelpudos60x100($registros)
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
    //@$fraseSuperior = $fraseSuperior[0];

    if ($familia[0] === "Famlia Pareja + 3 Perros/Gatos") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascotas = ['izquierda' => $mascotaIzquierda, 'derecha' => $mascotaDerecha, 'inferior' => $mascotaCentro];
        parejaTresMascotas60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia Soltero/a + Hijo/a") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda];
        $hijo = $zapatillaDerecha;
        mensaje('Zapatilla izquierda: '.$zapatillaIzquierda);
        mensaje('Zapatilla pequeña: '.$zapatillaDerecha);
        solteroHijo60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia Soltero/a + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda];
        $mascota = $mascotaSoltero;
        solteroMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia Pareja") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        familiaPareja60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia Pareja + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascota = $mascotaSoltero;
        familiaParejaMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia Pareja + 2 Perros/Gatos") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $mascotas = ['superior' => $mascotaSuperior, 'inferior' => $mascotaInferior];
        familiaParejaDosMascotas60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 3") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasCentro;
        parejaTres60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 3 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasCentro;
        $mascota = $mascotaSoltero;
        familiaTresUnaMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascota, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 3 + 2 Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijo = $zapatillasPequeñas;
        $mascotas = ['izquierda' => $mascotaInferiorIzquierda, 'derecha' => $mascotaInferiorDerecha];
        familiaTresDosMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascotas, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 4") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['superior' => $zapatillasPequeñasSuperior, 'inferior' => $zapatillasPequeñasInferior];
        familiaCuatro60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 4 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['derecha' => $zapatillasPequeñasIzquierda, 'izquierda' => $zapatillasPequeñasDerecha];
        $mascota = $mascotaSoltero;
        familiaCuatroUnaMascota60x100($fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 4 + 2 Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['derecha' => $zapatillasPequeñasIzquierda, 'izquierda' => $zapatillasPequeñasDerecha];
        $mascotas = ['izquierda' => $mascotaIzquierda, 'derecha' => $mascotaDerecha];
        familiaCuatroDosMascotas60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascotas, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 5") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'inferior' => $zapatillasPequeñasInferior];
        familiaCinco60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 5 + Perro/Gato") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'centro' => $zapatillasPequeñasInferior];
        $mascota = $mascotaSoltero;
        familiaCincoMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente,$url_completa);
    } elseif ($familia[0] === "Famlia 6") {
        $zapatillasPadres = ['izquierda' => $zapatillaIzquierda, 'derecha' => $zapatillaDerecha];
        $hijos = ['izquierda' => $zapatillasPequeñasIzquierda, 'derecha' => $zapatillasPequeñasDerecha, 'inferiorIzquierda' => $zapatillasInferiorIzquierda, 'inferiorDerecha' => $zapatillasInferiorDerecha];
        familiaSeis60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa);
    }
}
function familiaSeis60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 6/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 6/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 6/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
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

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 166, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 166, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoInferiorIzquierda, $fuente, 166, 'black', $areaHijoInferiorIzquierda);
        escribirTextoEnArea($imagenBase, $hijoInferiorDerecha, $fuente, 166, 'black', $areaInferiorDerecha);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaCincoMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 5 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 5 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 5 + PerroGato/Zapatillas-Rojas.png');
        }

        if ($fuente === "Cooper" || $fuente === "Cooper Std Black" || $fuente === "Cooper Std Black") {
            $fuente = 'productos/felpudos-familia/fuente/Cooper/Cooper.ttf';
        } elseif ($fuente === "Stencil") {
            $fuente = 'productos/felpudos-familia/fuente/Stencil/STENCIL.woff';
        } elseif ($fuente === "Harlow") {
            $fuente = 'productos/felpudos-familia/fuente/Harlow/Harlow.ttf';
        } else {
            $fuente = 'productos/felpudos-familia/fuente/Golden/GoldenHillsDEMO.ttf';
        }
        /* */

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 517, 'y' => 2924, 'width' => 1326, 'height' => 277];

        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4226, 'y' => 2924, 'width' => 1326, 'height' => 277];

        $hijoIzquierda = $hijos['izquierda'];
            $areaHijoIzquierda = ['x' => 1983, 'y' => 1783, 'width' => 1000, 'height' => 264];

        $hijoDerecha = $hijos['derecha'];
            $areaHijoDerecha = ['x' => 3140, 'y' => 1783, 'width' => 1000, 'height' => 264];

        $hijoCentro = $hijos['centro'];
            $areaHijoCentro = ['x' => 1983, 'y' => 3114, 'width' => 1000, 'height' => 264];

        $mascota = $mascota;
            $areaMascota = ['x' => 3140, 'y' => 3140, 'width' => 1000, 'height' => 264];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 250, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 250, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 230, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 230, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoCentro, $fuente, 230, 'black', $areaHijoCentro);

        escribirTextoEnArea($imagenBase, $mascota, $fuente, 230, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaCinco60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 5/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 5/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 5/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 461, 'y' => 2976, 'width' => 1326, 'height' => 264];
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4261, 'y' => 2976, 'width' => 1326, 'height' => 264];

        $hijoIzquierda = $hijos['izquierda'];
            $areaHijoIzquierda = ['x' => 1983, 'y' => 1884, 'width' => 1000, 'height' => 200];

        $hijoDerecha = $hijos['derecha'];
            $areaHijoDerecha = ['x' => 3164, 'y' => 1884, 'width' => 1000, 'height' => 200];

        $hijoInferior = $hijos['inferior'];
            $areaHijoInferior = ['x' => 2511, 'y' => 3156, 'width' => 1000, 'height' => 200];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 330, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 330, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 250, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 250, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $hijoInferior, $fuente, 250, 'black', $areaHijoInferior);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaCuatroDosMascotas60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4 + 2 PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4 + 2 PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4 + 2 PerroGato/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 461, 'y' => 2924, 'width' => 1326, 'height' => 264];
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4261, 'y' => 2924, 'width' => 1326, 'height' => 264];

        $hijoIzquierda = $hijos['izquierda'];
            $areaHijoIzquierda = ['x' => 1983, 'y' => 1884, 'width' => 1000, 'height' => 264];

        $hijoDerecha = $hijos['derecha'];
            $areaHijoDerecha = ['x' => 3137, 'y' => 1884, 'width' => 1000, 'height' => 264];

        $mascotaIzquierda = $mascotas['izquierda'];
            $areaMascotaIzquierda = ['x' => 1983, 'y' => 2922, 'width' => 1000, 'height' => 205];

        $mascotaDerecha = $mascotas['derecha'];
            $areaMascotaDerecha = ['x' => 3137, 'y' => 2922, 'width' => 1000, 'height' => 205];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 330, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 330, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 230, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 230, 'black', $areaHijoDerecha);

        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 200, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 200, 'black', $areaMascotaDerecha);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaCuatroUnaMascota60x100($fraseSuperior, $zapatillasPadres, $hijos, $mascota, $fuente, $url_completa)
{
    try {

        $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4 + PerroGato/Zapatillas-Rojo-Negro.png');

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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 517, 'y' => 2924, 'width' => 1326, 'height' => 277];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 4292, 'y' => 2924, 'width' => 1326, 'height' => 277];



        $hijoIzquierda = $hijos['izquierda'];
        $areaHijoIzquierda = ['x' => 1983, 'y' => 1783, 'width' => 1000, 'height' => 260];

        $hijoDerecha = $hijos['derecha'];
        $areaHijoDerecha = ['x' => 3140, 'y' => 1773, 'width' => 1000, 'height' => 260];

        $mascota = $mascota;
        $areaMascota = ['x' => 2483, 'y' => 3040, 'width' => 1000, 'height' => 260];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);


        escribirTextoEnArea($imagenBase, $hijoIzquierda, $fuente, 200, 'black', $areaHijoIzquierda);
        escribirTextoEnArea($imagenBase, $hijoDerecha, $fuente, 200, 'black', $areaHijoDerecha);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 200, 'black', $areaMascota);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaCuatro60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijos, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 4/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 512, 'y' => 2922, 'width' => 1600, 'height' => 264];
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4037, 'y' => 2922, 'width' => 1600, 'height' => 264];

        $zapatillasPequeñasSuperior = $hijos['superior'];
        $areazapatillasPequeñasSuperior = ['x' => 2385, 'y' => 1785, 'width' => 1326, 'height' => 265];

        $zapatillasPequeñasInferior = $hijos['inferior'];
        $areazapatillasPequeñasInferior = ['x' => 2385, 'y' => 3018, 'width' => 1326, 'height' => 265];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 400, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 400, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $zapatillasPequeñasSuperior, $fuente, 300, 'black', $areazapatillasPequeñasSuperior);
        escribirTextoEnArea($imagenBase, $zapatillasPequeñasInferior, $fuente, 300, 'black', $areazapatillasPequeñasInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaTresDosMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3 + 2 PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3 + 2 PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3 + 2 PerroGato/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 475, 'y' => 2986, 'width' => 1335, 'height' => 240];

        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4279, 'y' => 2986, 'width' => 1335, 'height' => 240];

        $hijo = $hijo;
            $areaHijoSuperior = ['x' => 2522, 'y' => 1873, 'width' => 1002, 'height' => 240];

        $mascotaIzquierda = $mascotas['izquierda'];
            $areaMascotaIzquierda = ['x' => 2065, 'y' => 2986, 'width' => 918, 'height' => 200];

        $mascotaDerecha = $mascotas['derecha'];
            $areaMascotaDerecha = ['x' => 3195, 'y' => 2986, 'width' => 918, 'height' => 200];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 280, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 280, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 230, 'black', $areaHijoSuperior);
        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 210, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 210, 'black', $areaMascotaDerecha);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaTresUnaMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3 + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3 + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3 + PerroGato/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
        $areaZapatillaIzquierda = ['x' => 509, 'y' => 2922, 'width' => 1626, 'height' => 289];
        $nombreDerecha = $zapatillasPadres['derecha'];
        $areaZapatillaDerecha = ['x' => 3968, 'y' => 2922, 'width' => 1626, 'height' => 289];

        $hijo = $hijo;
        $areaHijoSuperior = ['x' => 2448, 'y' => 1938, 'width' => 1200, 'height' => 289];

        $mascota = $mascota;
        $areaMascotaInferior = ['x' => 2448, 'y' => 3078, 'width' => 1200, 'height' => 289];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 389, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 389, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 270, 'black', $areaHijoSuperior);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 250, 'black', $areaMascotaInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function parejaTres60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia 3/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 668, 'y' => 2970, 'width' => 1335, 'height' => 241];
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4150, 'y' => 2970, 'width' => 1335, 'height' => 241];

        $hijo = $hijo;
        $areaHijoCentro = ['x' => 2515, 'y' => 2458, 'width' => 1002, 'height' => 240];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 350, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 350, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $hijo, $fuente, 270, 'black', $areaHijoCentro);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaParejaDosMascotas60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + 2 PerrosGatos/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + 2 PerrosGatos/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + 2 PerrosGatos/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 650, 'y' => 2992, 'width' => 1335, 'height' => 241];
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 4066, 'y' => 2992, 'width' => 1335, 'height' => 241];

        $mascotaSuperior = $mascotas['superior'];
            $areaMascotaSuperior = ['x' => 2524, 'y' => 1781, 'width' => 1002, 'height' => 240];

        $mascotaInferior = $mascotas['inferior'];
            $areaMascotaInferior = ['x' => 2524, 'y' => 2740, 'width' => 1002, 'height' => 240];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 350, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 350, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $mascotaSuperior, $fuente, 230, 'black', $areaMascotaSuperior);
        escribirTextoEnArea($imagenBase, $mascotaInferior, $fuente, 230, 'black', $areaMascotaInferior);


        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaParejaMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + PerroGato/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + PerroGato/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + PerroGato/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 509, 'y' => 2988, 'width' => 1626, 'height' => 289];
        
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 3980, 'y' => 2988, 'width' => 1626, 'height' => 289];
        
        $mascota = $mascota;
            $areaMascota = ['x' => 2445, 'y' => 2439, 'width' => 1200, 'height' => 289];


        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 389, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 389, 'black', $areaZapatillaDerecha);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 250, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function familiaPareja60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 1081, 'y' => 2970, 'width' => 1335, 'height' => 277];
        
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 3579, 'y' => 2970, 'width' => 1335, 'height' => 277];


        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 430, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 430, 'black', $areaZapatillaDerecha);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function solteroMascota60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascota, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Soltero+mascota/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Soltero+mascota/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Soltero+mascota/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 1222, 'y' => 2927, 'width' => 1626, 'height' => 289];
        
            $areaMascota = ['x' => 3283, 'y' => 2927, 'width' => 1200, 'height' => 289];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 389, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $mascota, $fuente, 389, 'black', $areaMascota);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function solteroHijo60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $hijo, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas == "Zapatillas Rojo/Negro") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Soltero+hijo/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas == "Zapatillas Negras") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Soltero+hijo/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Soltero+hijo/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 1222, 'y' => 2927, 'width' => 1626, 'height' => 289];
        
            $areaHijo = ['x' => 3283, 'y' => 2927, 'width' => 1200, 'height' => 289];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 389, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $hijo, $fuente, 389, 'black', $areaHijo);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
function parejaTresMascotas60x100($coloresZapatillas, $fraseSuperior, $zapatillasPadres, $mascotas, $fuente, $url_completa)
{
    try {
        if ($coloresZapatillas === "Zapatillas Rojo/Negro" || $coloresZapatillas === "Chaussures Rouge/Noir") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + 3 PerrosGatos/Zapatillas-Rojo-Negro.png');
        } elseif ($coloresZapatillas === "Zapatillas Negras" || $coloresZapatillas === "Chaussures Noires") {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + 3 PerrosGatos/Zapatillas-Negras.png');
        } else {
            $imagenBase = new Imagick('productos/felpudos-familia/Felpudo_60x100/Famlia Pareja + 3 PerrosGatos/Zapatillas-Rojas.png');
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

        $areaFraseSuperior = ['x' => 450, 'y' => 174, 'width' => 5067, 'height' => 600];
        escribirTextoEnArea($imagenBase, $fraseSuperior, $fuente, 500, 'black', $areaFraseSuperior);
        mensaje("Frase superior $fraseSuperior se escribio correctamente");

        $nombreIzquierda = $zapatillasPadres['izquierda'];
            $areaZapatillaIzquierda = ['x' => 365, 'y' => 2903, 'width' => 1626, 'height' => 289];
        $nombreDerecha = $zapatillasPadres['derecha'];
            $areaZapatillaDerecha = ['x' => 3999, 'y' => 2903, 'width' => 1626, 'height' => 289];

        $mascotaIzquierda = $mascotas['izquierda'];
            $areaMascotaIzquierda = ['x' => 1892, 'y' => 1700, 'width' => 1002, 'height' => 240];

        $mascotaDerecha = $mascotas['derecha'];
            $areaMascotaDerecha = ['x' => 3053, 'y' => 1700, 'width' => 1002, 'height' => 240];

        $mascotaInferior = $mascotas['inferior'];
            $areaMascotaInferior = ['x' => 2447, 'y' => 2693, 'width' => 1002, 'height' => 240];

        escribirTextoEnArea($imagenBase, $nombreIzquierda, $fuente, 230, 'black', $areaZapatillaIzquierda);
        escribirTextoEnArea($imagenBase, $nombreDerecha, $fuente, 230, 'black', $areaZapatillaDerecha);

        escribirTextoEnArea($imagenBase, $mascotaIzquierda, $fuente, 230, 'black', $areaMascotaIzquierda);
        escribirTextoEnArea($imagenBase, $mascotaDerecha, $fuente, 230, 'black', $areaMascotaDerecha);
        escribirTextoEnArea($imagenBase, $mascotaInferior, $fuente, 230, 'black', $areaMascotaInferior);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'felpudo.png');
        mensaje("Felpudo creado correctamente". $url_completa . 'felpudo.png');
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: ". $e->getMessage());
    }
}
