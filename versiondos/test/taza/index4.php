<?php
    $userImage = new Imagick('bd7f1494-9fa4-46b5-8dce-d46864ef15e2.jpg');
  // Guardar las dimensiones originales de la imagen
  $originalWidth = $userImage->getImageWidth();
  $originalHeight = $userImage->getImageHeight();

  $angleOfRotation = -90;
  $scaleX = 0.3214377983050695;
  $scaleY = 0.3214377983050697;
  $imageX = 47;
  $imageY = 235;
    $scaleX = $scaleX * (1928 / 241);  // Escalar proporcionalmente al nuevo tamaño de marco
    $scaleY = $scaleY * (1928 / 241);  // Escalar proporcionalmente al nuevo tamaño de marco
    $angleOfRotation = $angleOfRotation;
    $userImagePos = array(
        'x' => $imageX * (1928 / 241),  // Escalar proporcionalmente al nuevo tamaño de marco
        'y' => $imageY * (1928 / 241)  // Escalar proporcionalmente al nuevo tamaño de marco
    );
    $cropPos = array(
        'x' => 636,
        'y' => 164
    );
    $cropSize = array(
        'width' => 1928,
        'height' => 1928
    );
  // Lee los metadatos EXIF de la imagen para obtener la orientación
  $exifRotationApplied = false;
  if (function_exists('bd7f1494-9fa4-46b5-8dce-d46864ef15e2.jpg')) {
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
      $anguloEnGrados = $angleOfRotation;

      // Girar la imagen
      $userImage->rotateImage(new ImagickPixel('none'), $anguloEnGrados);
  }

  // Escalar la imagen del usuario
  $userImage->resizeImage($userImage->getImageWidth() * $scaleX, $userImage->getImageHeight() * $scaleY, Imagick::FILTER_LANCZOS, 1);

  // Crear un nuevo lienzo para el marco
  $frame = new Imagick();

  // Verificar si las dimensiones de la imagen han cambiado después de la rotación
  $rotatedWidth = $userImage->getImageWidth();
  $rotatedHeight = $userImage->getImageHeight();

  if ($rotatedWidth != $originalWidth || $rotatedHeight != $originalHeight) {
      // Ajustar las posiciones del recorte
      // Estos son solo ejemplos de cómo podrías ajustar las posiciones.
      // Deberás modificar estos cálculos según tu caso de uso específico.
      $cropPos['x'] = ($rotatedWidth - $cropSize['width']) / 2;
      $cropPos['y'] = ($rotatedHeight - $cropSize['height']) / 2;
  }

  // Definir el tamaño del marco para que sea lo suficientemente grande para el recorte
  $frameWidth = max($cropPos['x'] + $cropSize['width'], $userImage->getImageWidth());
  $frameHeight = max($cropPos['y'] + $cropSize['height'], $userImage->getImageHeight());
  $frame->newImage($frameWidth, $frameHeight, new ImagickPixel('transparent'));

  // Posicionar la imagen del usuario en el lienzo
  $frame->compositeImage($userImage, Imagick::COMPOSITE_DEFAULT, $userImagePos['x'], $userImagePos['y']);

  // Recortar la imagen en el marco
  $frame->cropImage($cropSize['width'], $cropSize['height'], $cropPos['x'], $cropPos['y']);

  // Guardar la imagen como PNG
  $frame->writeImage('ojala.png');