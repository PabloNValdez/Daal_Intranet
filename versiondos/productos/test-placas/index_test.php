<?php
##########################
##  PLACAS SIN LLAVEROS
##  CON Y SIN BASE
##########################
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../../funciones/funciones.php';
require '../../vendor/autoload.php';


$configuracion = parse_ini_file('../../config/configuracion.ini', true);
$alto = $configuracion['datos_madera']['alto'];
$ancho = $configuracion['datos_madera']['ancho'];
$c10 = $configuracion['datos_madera']['c10'];
$c20 = $configuracion['datos_madera']['c20'];
$c30 = $configuracion['datos_madera']['c30'];
$c40 = $configuracion['datos_madera']['c40'];


use JsonPath\JsonObject;

$archivo = $_GET['archivo'];
$base = $_GET['base'];
echo $archivo;
$sql = "SELECT ruta FROM carpetas WHERE archivo = '$archivo' AND procesada = 0 LIMIT 1";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // Mostrar resultados
  while ($row = $result->fetch_assoc()) {
    $ruta = $row["ruta"];
    $ruta = "../../" . $ruta . "/";

    echo "<br>" . $ruta;

    // Obtener los archivos en la carpeta
    $archivos = scandir($ruta);

    // Buscar el archivo JSON
    foreach ($archivos as $archivo) {
      if (pathinfo($archivo, PATHINFO_EXTENSION) == "json") {
        // Leer el contenido del archivo JSON
        $json_str = file_get_contents($ruta . $archivo);
        echo "<br>" . $ruta . $archivo;
        $rutaJson = $ruta . $archivo;
        $json_data = json_decode($json_str, true);

        // Procesar los datos JSON
        echo "<br>Proroceso archivos aqui<br>";
        leerJSON($rutaJson,$ruta);
        // ...

        // Marcar la carpeta como procesada
        $actualizar_ruta =  $row["ruta"];
        $sql_update = "UPDATE carpetas SET procesada = 1 WHERE ruta = '$actualizar_ruta'";
        if ($mysqli->query($sql_update) === TRUE) {
          echo "<br>Carpeta marcada como procesada.\n";
        } else {
          echo "Error actualizando el registro: " . $mysqli->error . "\n";
        }
      }
    }
  }
  // Recargar la página para procesar las siguientes 10 carpetas
  //header('Location: index.php');
  header("Refresh:0");
} else {
  //Al finalizar, comprimimos la carpeta
  //Aqui deberiamos de llevar a otra pagina que copie y comprima
  header('Location: comprimir.php?archivo=' . $archivo.'&tipodeplaca='.$base);
  echo "No hay más carpetas para procesar";
}
$mysqli->close();





function leerJSON($json,$ruta)
{
  global $rootPath;
  global $pedido;
  global $datetime_str;
  global $tipodeplaca;
  global $base;
  $json = file_get_contents($json);
  $datos = json_decode($json, true);
  $jsonObject = new JsonObject($datos);
  $titulo = $jsonObject->get('$..children[?(@.label=="Título de la canción")].inputValue');
  if (@$titulo[0] == "") {
    $titulo = $jsonObject->get('$..children[?(@.label=="Título de la Canción")].inputValue');
  }
  echo $titulo[0] . "<br>";
  $artista = $jsonObject->get('$..children[?(@.label=="Artista/s de la canción")].inputValue');
  if (@$artista[0] == "") {
    $artista = $jsonObject->get('$..children[?(@.label=="Artista(s) de la Canción")].inputValue');
  }
  echo $artista[0] . "<br>";
  $urlSpotify = $jsonObject->get('$..children[?(@.label=="Url Spotify")].inputValue');
  $orderId = $jsonObject->get('$..orderId');
  $orderItemId = $jsonObject->get('$..orderItemId');
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

  $pedido = $orderId[0];

  //$rootPath = 'data/' . $datetime_str; // Definición de la variable global
  
  $urlCliente = $ruta . $imageName[0];
  // Datos de prueba
  $userImagePath = $urlCliente;
  $outputPath = 'image.png';
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
    $frase = $jsonObject->get('$..children[?(@.label=="Frase en la base de madera")].inputValue');
  }
  echo $frase[0];
  crearCortarImagen($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize);
  grabarMadera($frase[0], $ruta);
  grabarPlaca($titulo[0], $artista[0], 0, $ruta, 0,$pedido);
}
function grabarMadera($frase, $url_completa)
{
  global $c10;
  global $c20;
  global $c30;
  global $c40;
  global $alto;
  global $ancho;

  // Cargar una imagen existente
  $image = new Imagick('imagenes/madera.png');

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
  $draw->setFont('fuente/Courgette/Courgette-Regular.ttf');

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
  //registro("Se escribio el texto de la madera correctamente");
  // Limpiar la memoria
  $image->clear();
  $draw->clear();
}
function grabarPlaca($cancion, $artista, $duracion, $url_completa, $qr, $llaveros)
{
    try {
        $imagenBase = new Imagick('imagenes/placa_spotify-40px.png');
        $imagenSuperior = new Imagick('image.png');
        // Coordenadas y dimensiones de la imagen superior
        $coordenadas_imagen = ['x' => 89.5, 'y' => 74.5, 'w' => 709, 'h' => 709];
        // Redimensiona y coloca la imagen superior
        colocarImagen($imagenBase, $imagenSuperior, $coordenadas_imagen);
        // Coordenadas y dimensiones del QR
        $coordenadas_qr = ['x' => 265, 'y' => 806, 'w' => 356, 'h' => 89];
        // Configuración de la fuente
        $fuente = ['color' => 'black', 'tamaño' => 25, 'fuente' => 'fuente/Gotham/Gotham-Medium.ttf'];
        // Anota la canción y el artista
        anotarTexto($imagenBase, $fuente, $cancion, 90, 951);
        anotarTexto($imagenBase, $fuente, $artista, 90, 982);
        // Anota la duración si no es 0
        if ($duracion != 0) {
            $fuente['tamaño'] = 16;
            anotarTexto($imagenBase, $fuente, $duracion, 758, 1055);
        }
        //Lógica cambiada, si el QR se genero, colocamos los QR
        if ($qr !== 0) {
            $imagenQR = new Imagick('QRDescargado/imagen_transparente.png');
        } else {
            $imagenQR = new Imagick('QRDescargado/sinqr.png');
        }
        // Redimensiona y coloca el QR
        colocarImagen($imagenBase, $imagenQR, $coordenadas_qr);

        // Guarda la imagen
        $imagenBase->setImageFormat('png');
        $imagenBase->writeImage($url_completa . 'placa.png');
        registro("Placa creada correctamente");
    } catch (ImagickException $e) {
        registro("Error al guardar la imagen: ',  $e->getMessage(),");
    }
}
function colocarImagen($imagenBase, $imagen, $coordenadas)
{
    $imagen->scaleImage($coordenadas['w'], $coordenadas['h'], true);
    $centerX = $coordenadas['x'] + ($coordenadas['w'] - $imagen->getImageWidth()) / 2;
    $centerY = $coordenadas['y'] + ($coordenadas['h'] - $imagen->getImageHeight()) / 2;
    $imagenBase->compositeImage($imagen, Imagick::COMPOSITE_DEFAULT, $centerX, $centerY);
}

// Función para anotar texto
function anotarTexto($imagenBase, $fuente, $texto, $x, $y)
{
    $draw = new ImagickDraw();
    $draw->setFillColor($fuente['color']);
    $draw->setFontSize($fuente['tamaño']);
    $draw->setFont($fuente['fuente']);
    $imagenBase->annotateImage($draw, $x, $y, 0, $texto);
}
function crearCortarImagen($userImagePath, $outputPath, $scaleX, $scaleY, $angleOfRotation, $userImagePos, $cropPos, $cropSize)
{
    try {
        // Cargar la imagen del usuario
        $userImage = new Imagick($userImagePath);

        // Lee los metadatos EXIF de la imagen para obtener la orientación
        $exifRotationApplied = false;
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($userImagePath);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $userImage->rotateImage(new ImagickPixel('none'), 180);
                        $exifRotationApplied = true;
                        break;
                    case 5: // Transpose
                        $userImage->rotateImage(new ImagickPixel('none'), 90);
                        $userImage->flopImage(); // Reflejar a lo largo del eje x
                        $exifRotationApplied = true;
                        break;
                    case 6:
                        $userImage->rotateImage(new ImagickPixel('none'), 90); // Ajusta la imagen 90° CCW
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
        if (!$exifRotationApplied && $angleOfRotation !== null) {
            // El ángulo ya está en grados, no es necesario convertir
            //$anguloEnGrados = $angleOfRotation;

            // Girar la imagen
            //$userImage->rotateImage(new ImagickPixel('none'), $anguloEnGrados);
        }

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

        // registro finalizacion
        //registro("La imagen del cliente se proceso correctamente (Escala, posicionamiento, y recorte)");

        // Guardar la imagen como PNG
        $frame->writeImage($outputPath);

    } catch (ImagickException $e) {

        registro("Error: ".$e->getMessage());
    } catch (Exception $e) {
        registro("Error: ".$e->getMessage());
        echo 'Error: ' . $e->getMessage();
    }
}