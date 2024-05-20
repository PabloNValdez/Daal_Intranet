<?php
##########################
##  EN ESTE ARCHIVO SE REALIZAN TODAS LAS PLACAS QUE SE LISTAN A CONTINUACION
##
##  CON Y SIN BASE
##########################
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */
//include '../../funciones/funciones.php';
/* include 'funciones/funciones.php';
require 'vendor/autoload.php'; */
$configuracion = parse_ini_file('config/configuracion.ini', true);
$alto = $configuracion['datos_madera']['alto'];
$ancho = $configuracion['datos_madera']['ancho'];
$c10 = $configuracion['datos_madera']['c10'];
$c20 = $configuracion['datos_madera']['c20'];
$c30 = $configuracion['datos_madera']['c30'];
$c40 = $configuracion['datos_madera']['c40'];


use JsonPath\JsonObject;
//function placasSpotify($json, $ruta, $base)
function nuevasPlacas($registros)
{
    global $registros;
    $url_completa = "subidas/" . $registros["url_completa"];
    $url_completa = "subidas/" . obtenerURL($url_completa) . "/";
    $json_ubicacion = "subidas/" . $registros["url_completa"];
    $json = file_get_contents($json_ubicacion);
    $datos = json_decode($json, true);

    $urlXml = str_replace('.json', '.xml', $json_ubicacion);
    mensaje("XML: " . $urlXml);
    $xml = simplexml_load_file($urlXml);
    $jsonObject = new JsonObject($datos);
    mensaje("-----------------------");
    $titulo = $jsonObject->get('$..children[?(@.label=="Título de la canción")].inputValue');
    if (@$titulo[0] == "") {
        @$titulo = $jsonObject->get('$..children[?(@.label=="Título de la Canción")].inputValue');
    }
    //echo $titulo[0] . "<br>";
    $artista = $jsonObject->get('$..children[?(@.label=="Artista/s de la canción")].inputValue');
    if (@$artista[0] == "") {
        @$artista = $jsonObject->get('$..children[?(@.label=="Artista(s) de la Canción")].inputValue');
    }
    //echo $artista[0] . "<br>";
    $urlSpotify = $jsonObject->get('$..children[?(@.label=="Url Spotify")].inputValue');
    $imageName = $jsonObject->get('$..image.imageName');
    $buyerFilename = $jsonObject->get('$..image.buyerFilename');
    $frameWidth = $jsonObject->get('$..dimension.width');
    $frameHeight = $jsonObject->get('$..dimension.height');
    $frameX = $jsonObject->get('$..position.x');
    $frameY = $jsonObject->get('$..position.y');
    $imageWidth = $jsonObject->get('$..buyerPlacement.dimension.width');
    $imageHeight = $jsonObject->get('$..buyerPlacement.dimension.height');
    $imageX = $jsonObject->get('$..buyerPlacement.position.x');
    $imageY = $jsonObject->get('$..buyerPlacement.position.y');
    $scaleX = $jsonObject->get('$..buyerPlacement.scale.scaleX');
    $scaleY = $jsonObject->get('$..buyerPlacement.scale.scaleY');
    $angleOfRotation = $jsonObject->get('$..buyerPlacement.angleOfRotation');
    $opcionesDelCliente = $xml->xpath('//customizationData/children//children//children/optionSelection/name/text()');
    if (!empty($opcionesDelCliente)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $tipoDePlaca = (string)$opcionesDelCliente[0];
    }

    if (!empty($opcionesDelCliente)) {
        // Obtener el primer resultado (puede haber múltiples, dependiendo de la estructura del XML)
        $llaveros = (string)$opcionesDelCliente[1];
    }
    $pedido = $registros["pedido"];
    $asin = $xml->xpath('/data/asin/text()');
    //$rootPath = 'data/' . $datetime_str; // Definición de la variable global

    $urlCliente = $url_completa . $imageName[0];

    // Datos de prueba
    $userImagePath = $urlCliente;
    $outputPath = 'temp/placas/' . $pedido . '-image.png';
    $scaleX = $scaleX[0] * (1928 / 241);  // Escalar proporcionalmente al nuevo tamaño de marco
    $scaleY = $scaleY[0] * (1928 / 241);  // Escalar proporcionalmente al nuevo tamaño de marco
    $angleOfRotation = $angleOfRotation[0];
    $userImagePos = array(
        'x' => $imageX[0] * (1928 / 241),  // Escalar proporcionalmente al nuevo tamaño de marco
        'y' => $imageY[0] * (1928 / 241)  // Escalar proporcionalmente al nuevo tamaño de marco
    );
    $cropPos = array(
        'x' => 636,
        'y' => 164
    );
    $cropSize = array(
        'width' => 1928,
        'height' => 1928
    );

    $frase = $jsonObject->get('$..children[?(@.label=="Frase de la Base de Madera")].inputValue');
    if (@$frase[0] == "") {
        $frase = $jsonObject->get('$..children[?(@.label=="Base de Madera")].inputValue');
    }

    if (@$frase[0] == "") {
        $frase = $jsonObject->get('$..children[?(@.label=="Frase en la base de madera")].inputValue');
    }


    /* mensaje("Frase de la base: $frase[0]");
    mensaje("Tipo de Placa : $tipoDePlaca");
    mensaje("Llaveros : $llaveros");
    mensaje("URL Spotify : $urlSpotify[0]"); */

    //echo $frase[0];
    crearCortarImagenNueva($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize);
    $urlSpotify = $urlSpotify[0];


    $url = $urlSpotify;
    if (esURL($url)) {
        $trackID = obtenerTrackNueva($urlSpotify);
        mensaje("Es URL");
        if ($tipoDePlaca == "Base con luz 7 colores") {
            $qr = ObtenerQRNueva($trackID, "negro", $pedido);
        } else {
            $qr = ObtenerQRNueva($trackID, "null", $pedido);
        }
        if ($trackID !== 0) {
            $duracion = duracionCancionNueva($trackID);
            //echo "Duracion: " .$duracion. "<br>";
        }
    } else {
        $trackID = 0;
        mensaje("No es una URL de Spotify válida");
        $duracion = 0;
        $qr = 0;
    }

    @$titulo = $titulo[0];
    @$artista = $artista[0];
    mensaje("Comenzó el procesamiento del pedido: $pedido");

    $variantes =  $registros["variante"];
    //mensaje("URL: $urlSpotify");
    mensaje("La variante es: " . $variantes);
    $producto = $registros["producto"];
    //contador($producto, $variantes, $pedido);
    
    //NUEVO PRODUCTO: PLACAS DE SPOTIFY CON LUZ 
    if ($variantes === "Placa_Spotify_Luz" || $variantes === "Placa_Spotify_1llavero" || $variantes === "Placa_Spotify_2llaveros"|| $variantes === "Placa_Spotify_BASE" || $variantes === "Placa_Spotify_sin_BASE") {
        placaSpotifyLuz($titulo, $artista, $duracion, $url_completa, $qr, $llaveros, $tipoDePlaca, $pedido, $registros);
        mensaje("Frase de la base: $frase[0]");
        if ($tipoDePlaca != "Sin Base" || $variantes != "Placa_Spotify_sin_BASE") {
            grabarMaderaNueva(@$frase[0], @$url_completa);
        }
    }
}

function placaSpotifyLuz($cancion, $artista, $duracion, $url_completa, $qr, $llaveros, $tipoDePlaca, $pedido, $registros)
{
    try {
        mensaje("Cancion: $cancion");
        mensaje("Artista: $artista");
        mensaje("Duracion: $duracion");
        mensaje("QR: $qr");
        mensaje("Llaveros: $llaveros");
        mensaje("Tipos de placa: $tipoDePlaca");

        //Comprobamos que la funcion que obtiene el código QR, si no da 0, 
        if ($qr !== 0) {
            $imagenQR = new Imagick('temp/QR/' . $pedido . '-imagen_transparente.png');
            $llaveroUno = new Imagick('temp/QR/' . $pedido . '-imagen_transparente.png');
            $llaveroUno->resizeImage(356, 89, Imagick::FILTER_LANCZOS, 1);
            $llaveroUno->rotateImage(new ImagickPixel('none'), 90);
        } else {
            $imagenQR = new Imagick('productos/test-placas/QRDescargado/sinqr.png');
        }

        //Comprobamos el tipo de placa de este producto (Sin base, Base de madera, Base con luz 7 colores,)
        if ($tipoDePlaca == "Base con luz 7 colores") {

            //La imagen principal de la placa, en este caso es una placa de color blanco
            $imagenBase = new Imagick('productos/test-placas/imagenes/placa_llavero_blanco.png');

            //Comprobamos cantidad de llaveros por placa (2 llaveros, 1 llavero, sin llavero)
            if ($llaveros === "2 Llavero") { //DOS LLAVEROS CON LUZ LED
                contador("Placa Spotify con Luz", "Placa Spotify con Luz + 2 llaveros", $pedido);
                $imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 935);
                $imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 550);
            } elseif ($llaveros === "1 Llavero") { //UN LLAVERO CON LUZ LED
                contador("Placa Spotify con Luz", "Placa Spotify con Luz + 1 llavero", $pedido);
                $imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 935);
            } else { //SIN LLAVERO CON LUZ LED
                contador("Placa Spotify con Luz", "Placa Spotify con Luz sin llaveros", $pedido);
                $imagenBase = new Imagick('productos/test-placas/imagenes/placa_spotify-40px-blanco.png');
                //$imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 935);
            }

            //Escritura del titulo de la cancion, el artista, y la duracion
            $fuente = ['color' => 'white', 'tamaño' => 25, 'fuente' => 'productos/placas-spotify/fuente/Gotham/Gotham-Medium.ttf'];
            anotarTextoNueva($imagenBase, $fuente, $cancion, 90, 951);
            anotarTextoNueva($imagenBase, $fuente, $artista, 90, 982);
            if ($duracion != 0) {
                $fuente['tamaño'] = 16;
                anotarTextoNueva($imagenBase, $fuente, $duracion, 758, 1055);
            }
        } elseif ($tipoDePlaca == "Base de madera" || $tipoDePlaca == "Sin Base" || $registros["variante"] === "Placa_Spotify_1llavero" || $registros["variante"] === "Placa_Spotify_2llaveros" || $registros["variante"] === "Placa_Spotify_BASE" || $registros["variante"] === "Placa_Spotify_sin_BASE") {

            $imagenBase = new Imagick('productos/test-placas/imagenes/placa_llavero.png');

            if ($llaveros === "2 Llavero" || $registros["variante"] === "Placa_Spotify_2llaveros") { //DOS LLAVEROS SIN LUZ LED
                if ($tipoDePlaca == "Base de madera" || $registros["variante"]!= "Placa_Spotify_sin_BASE") {
                    contador("Placa Spotify con Base", "Placa Spotify con base + 2 llaveros", $pedido);
                } else {
                    contador("Placa Spotify sin Base", "Placa Spotify sin base + 2 llaveros", $pedido);
                }
                $imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 935);
                $imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 550);
            } elseif ($llaveros === "1 Llavero"  || $registros["variante"] === "Placa_Spotify_1llavero") { //UN LLAVEROS SIN LUZ LED
                if ($tipoDePlaca == "Base de madera" || $registros["variante"]!= "Placa_Spotify_sin_BASE") {
                    contador("Placa Spotify con Base", "Placa Spotify con base + 1 llavero", $pedido);
                } else {
                    contador("Placa Spotify sin Base", "Placa Spotify sin base + 1 llavero", $pedido);
                }
                $imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 935);
            } else { //SIN LLAVEROS SIN LUZ LED
                $imagenBase = new Imagick('productos/test-placas/imagenes/placa_spotify-40px.png');
                //$imagenBase->compositeImage($llaveroUno, Imagick::COMPOSITE_DEFAULT, 890, 935);
                if ($tipoDePlaca == "Base de madera" || $registros["variante"]!= "Placa_Spotify_sin_BASE") {
                    contador("Placa Spotify con Base", "Placa Spotify con base sin llavero", $pedido);
                } else {
                    contador("Placa Spotify sin Base", "Placa Spotify sin base sin llavero", $pedido);
                }
            }
            //Escritura del titulo de la cancion, el artista, y la duracion
            $fuente = ['color' => 'black', 'tamaño' => 25, 'fuente' => 'productos/placas-spotify/fuente/Gotham/Gotham-Medium.ttf'];
            anotarTextoNueva($imagenBase, $fuente, $cancion, 90, 951);
            anotarTextoNueva($imagenBase, $fuente, $artista, 90, 982);
            if ($duracion != 0) {
                $fuente['tamaño'] = 16;
                anotarTextoNueva($imagenBase, $fuente, $duracion, 758, 1055);
            }
        }

        //Coordenadas y colocacion en la imagen del código QR
        $coordenadas_qr = ['x' => 265, 'y' => 806, 'w' => 356, 'h' => 89];
        colocarImagenNueva($imagenBase, $imagenQR, $coordenadas_qr);



        //Imagen del cliente
        $imagenSuperior = new Imagick('temp/placas/' . $pedido . '-image.png');
        // Coordenadas y dimensiones de la imagen superior
        $coordenadas_imagen = ['x' => 88, 'y' => 74, 'w' => 709, 'h' => 709];
        // Redimensiona y coloca la imagen superior
        colocarImagenNueva($imagenBase, $imagenSuperior, $coordenadas_imagen);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $nombre_archivo = 'placa.png'; // Nombre del archivo
        $ruta_completa = $url_completa . $nombre_archivo;

        $imagenBase->writeImage($ruta_completa);
        mensaje("Placa creada correctamente: " . $ruta_completa);
    } catch (ImagickException $e) {
        mensaje("Error al guardar la imagen: " . $e->getMessage());
    }
}

function esURL($cadena)
{
    // Filtra la cadena como una URL
    $url_valida = filter_var($cadena, FILTER_VALIDATE_URL);

    // Comprueba si la cadena es una URL válida
    if ($url_valida !== false) {
        return true;
    } else {
        return false;
    }
}


function colocarImagenNueva($imagenBase, $imagen, $coordenadas)
{
    $imagen->scaleImage($coordenadas['w'], $coordenadas['h'], true);
    $centerX = $coordenadas['x'] + ($coordenadas['w'] - $imagen->getImageWidth()) / 2;
    $centerY = $coordenadas['y'] + ($coordenadas['h'] - $imagen->getImageHeight()) / 2;
    $imagenBase->compositeImage($imagen, Imagick::COMPOSITE_DEFAULT, $centerX, $centerY);
}
function grabarMaderaNueva($frase, $url_completa)
{
    global $c10;
    global $c20;
    global $c30;
    global $c40;
    global $alto;
    global $ancho;

    // Cargar una imagen existente
    $image = new Imagick('productos/placas-spotify/imagenes/madera.png');

    // Crear un nuevo objeto de dibujo
    $draw = new ImagickDraw();

    // Definir el color del texto
    $draw->setFillColor('black');

    // Definir la alineación del texto al centro
    $draw->setTextAlignment(Imagick::ALIGN_CENTER);

    // Tu texto
    $texto = $frase;

    // Determinar el tamaño de la fuente basado en la longitud del texto
    if (strlen($texto) <= 10) {
        $draw->setFontSize($c10);
    } else if (strlen($texto) <= 20) {
        $draw->setFontSize($c20);
    } else if (strlen($texto) <= 30) {
        $draw->setFontSize($c30);
    } else {
        $draw->setFontSize($c40);
    }

    // Especificar la fuente si es necesario
    $draw->setFont('productos/placas-spotify/fuente/Courgette/Courgette-Regular.ttf');

    // Obtener las propiedades del texto para centrarlo verticalmente
    $textProperties = $image->queryFontMetrics($draw, $texto);

    // Calcular la posición y de la línea de base del texto
    $y = ($alto - $textProperties['textHeight']) / 2 + $textProperties['ascender'];

    // Anotar la imagen con el texto en el centro
    $image->annotateImage($draw, $ancho / 2, $y, 0, $texto);

    // Establecer el formato de imagen
    $image->setImageFormat('png');

    // Guardar la imagen en un archivo
    $guardado = $url_completa;
    $image->writeImage($guardado . 'madera_texto.png');
    mensaje("Se escribio el texto de la madera correctamente");
    // Limpiar la memoria
    $image->clear();
    $draw->clear();
}
// Función para anotar texto
function anotarTextoNueva($imagenBase, $fuente, $texto, $x, $y)
{
    $draw = new ImagickDraw();
    $draw->setFillColor($fuente['color']);
    $draw->setFontSize($fuente['tamaño']);
    $draw->setFont($fuente['fuente']);
    $imagenBase->annotateImage($draw, $x, $y, 0, $texto);
}
function crearCortarImagenNueva($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize)
{
    try {
        // Cargar la imagen del usuario
        $userImage = new Imagick($userImagePath);

        // Lee los metadatos EXIF de la imagen para obtener la orientación
        $exifRotationApplied = false;
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($userImagePath);
            if ($exif !== false && !empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $userImage->rotateImage(new ImagickPixel('none'), 180);
                        $exifRotationApplied = true;
                        break;
                    case 6:
                        $userImage->rotateImage(new ImagickPixel('none'), 90);
                        $exifRotationApplied = true;
                        break;
                    case 8:
                        $userImage->rotateImage(new ImagickPixel('none'), -90);
                        $exifRotationApplied = true;
                        break;
                }
            }
        }

        // Si no se aplicó una rotación EXIF, aplicar la rotación proporcionada
        //if (!$exifRotationApplied && $angleOfRotation !== null) {
        //$userImage->rotateImage(new ImagickPixel('none'), $angleOfRotation);
        //}

        // Escalar la imagen del usuario
        $userImage->resizeImage($userImage->getImageWidth() * $scaleX, $userImage->getImageHeight() * $scaleY, Imagick::FILTER_LANCZOS, 1);

        // Crear un nuevo lienzo para el marco
        $frame = new Imagick();

        // Definir el tamaño del marco para que sea lo suficientemente grande para el recorte
        $frameWidth = max($cropPos['x'] + $cropSize['width'], $userImage->getImageWidth());
        $frameHeight = max($cropPos['y'] + $cropSize['height'], $userImage->getImageHeight());
        $frame->newImage($frameWidth, $frameHeight, new ImagickPixel('transparent'));

        // Posicionar la imagen del usuario en el lienzo
        $frame->compositeImage($userImage, Imagick::COMPOSITE_DEFAULT, $userImagePos['x'], $userImagePos['y']);

        // Recortar la imagen en el marco
        $frame->cropImage($cropSize['width'], $cropSize['height'], $cropPos['x'], $cropPos['y']);

        // Guardar la imagen como PNG
        $frame->writeImage($outputPath);
    } catch (ImagickException $e) {
        // Aquí debes manejar las excepciones de Imagick como consideres apropiado
        // Por ejemplo, puedes registrar el error en un archivo log
    } catch (Exception $e) {
        // Aquí debes manejar las demás excepciones como consideres apropiado
        // Por ejemplo, puedes registrar el error en un archivo log
    }
}
function duracionCancionNueva($trackId)
{
    // Verificar si se pasó un ID de pista válido
    if (empty($trackId)) {
        return 0;
    }

    try {
        $client = new GuzzleHttp\Client();
        // Autenticación
        $response = $client->request('POST', 'https://accounts.spotify.com/api/token', [
            'form_params' => [
                'grant_type' => 'client_credentials'
            ],
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('6062cc3d96e74cb89a1d0372e4dbe699' . ':' . 'b3f2d0c09a034b3fbb1e0ece895193e6')
            ]
        ]);
        $token = json_decode((string) $response->getBody(), true)['access_token'];
        // Obtener detalles del track
        $response = $client->request('GET', 'https://api.spotify.com/v1/tracks/' . $trackId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);
        $track = json_decode((string) $response->getBody(), true);
        // La duración se da en milisegundos, así que la convertimos a segundos y luego a formato minutos:segundos
        $durationSeconds = $track['duration_ms'] / 1000;
        $formattedDuration = gmdate('i:s', $durationSeconds);
        return $formattedDuration;
    } catch (Exception $e) {
        // Si algo va mal, devuelve 0
        return 0;
    }
}

function obtenerTrackNueva($url)
{
    // Verificar si la URL está vacía
    if (empty($url)) {
        return 0;
    }

    $parsedUrl = parse_url($url);

    // Verificar si parse_url() devolvió un host
    if (!isset($parsedUrl['host'])) {
        return 0;
    }

    $host = $parsedUrl['host'];

    if ($host == 'open.spotify.com' || $host == 'spotify.link') {

        if ($host == 'spotify.link') {
            $url = obtenerRedirecionURLNueva($url);
        }

        $trackId = extraerTrackNueva($url);

        return $trackId;
    } else {
        return 0;
    }
}

function obtenerRedirecionURLNueva($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($http_status >= 300 && $http_status < 400) {
        preg_match('/^Location:(.*)$/mi', $response, $match);

        if (!empty($match[1])) {
            return trim($match[1]);
        }
    }
    return null;
}
function extraerTrackNueva($url)
{
    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'];
    $query = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';
    if (strpos($path, '/track/') !== false) {
        $trackStartPos = strrpos($path, '/track/') + strlen('/track/');
        $trackId = substr($path, $trackStartPos) . (empty($query) ? '' : '?' . $query);
        return $trackId;
    }
    return null;
}
function ObtenerQRNueva($trackId, $color, $pedido)
{
    // Verificar si se pasó un ID de pista válido
    if (empty($trackId) || $trackId === 0) {
        return 0;
    }

    if ($color === "negro") {
        $imageUrl = "https://scannables.scdn.co/uri/plain/png/00000/white/640/spotify:track:" . $trackId;
    } else {
        $imageUrl = "https://scannables.scdn.co/uri/plain/png/fffff/black/640/spotify:track:" . $trackId;
    }


    $imageData = file_get_contents($imageUrl);

    $llaveros = "https://scannables.scdn.co/uri/plain/png/fffff/black/640/spotify:track:" . $trackId;
    $llaveros = file_get_contents($llaveros);
    // Verificar si file_get_contents() fue exitoso


    if ($imageData === FALSE) {
        return 0;
    }

    $dir = 'temp/QR';
    if (!file_exists($dir)) {
        if (!mkdir($dir, 0777, true)) {
            // No se pudo crear el directorio
            return 0;
        }
    }

    $file = $dir . '/' . $pedido . '-imagen.png'; // Nombre de tu imagen
    if (file_put_contents($file, $imageData) === FALSE) {
        // file_put_contents() no tuvo éxito
        return 0;
    }

    $llaveros_file = $dir . '/' . $pedido . '-llaveros_qr.png';
    if (file_put_contents($llaveros_file, $llaveros) === FALSE) {
        // file_put_contents() no tuvo éxito
        return 0;
    }

    try {
        $QRTransparente = new Imagick($file);
        $llaverosTransparente = new Imagick($llaveros_file);
        $llaverosTransparente->transparentPaintImage('white', 0, 65000, false);
        if ($color === "negro") {
            $QRTransparente->transparentPaintImage('black', 0, 65000, false);
        } else {
            $QRTransparente->transparentPaintImage('white', 0, 65000, false);
        }
        $QRTransparente->writeImage($dir . '/' . $pedido . '-imagen_transparente.png');
        $llaverosTransparente->writeImage($dir . '/' . $pedido . '-llaveros_transparente.png');
    } catch (Exception $e) {
        // Se produjo un error al manipular la imagen
        return 0;
    }

    return $dir . '/imagen_transparente.png'; // Devolver la ruta a la imagen si todo fue exitoso
}
