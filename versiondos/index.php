<?php
function eliminarContenidoCarpeta($dir)
{
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir . "/" . $object) == "dir") {
          eliminarContenidoCarpeta($dir . "/" . $object);
          rmdir($dir . "/" . $object); // Mueve esta línea aquí para solo eliminar las subcarpetas
        } else {
          // no elimine el archivo index.php
          if ($object != "index.php") {
            unlink($dir . "/" . $object);
          }
        }
      }
    }
    reset($objects);
  }
}

if (isset($_POST['eliminar'])) {
  $carpeta1 = 'data';
  $carpeta2 = 'salida';
  $carpeta3 = 'carpeta';

  eliminarContenidoCarpeta($carpeta1);
  eliminarContenidoCarpeta($carpeta2);
  eliminarContenidoCarpeta($carpeta3);

  $eliminado = "si";
}
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <title>Generador de Productos de Amazon</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="plantilla/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .formulario {
      background: #f8f9fa !important;
    }

    .accordion-button {
      color: #034a5a;
      font-weight: 600;
    }

    #log-textarea {
      width: 100%;
      height: 300px;
      padding: 10px;
      border: none;
      border-radius: 5px;
      color: #FFFFFF;
      background-color: #333333;
      font-size: 16px;
      font-family: 'Courier New', Courier, monospace;
      resize: none;
      overflow: auto;
      transition: all 0.3s ease-in-out;
      box-shadow: 0 4px 6px 0 hsla(0, 0%, 0%, 0.2);
      outline: none;
    }

    #log-textarea:focus {
      box-shadow: 0 6px 10px 0 hsla(0, 0%, 0%, 0.3);
    }

    .tituloweb {
      color: #0192bc;
    }

    .text-bg-success {
      color: #444 !important;
      background-color: #fff !important;
    }

    .alert-heading {
      color: #0192bc !important;
    }

    img {
      width: 150px;
    }

    h4 {
      color: #0192bc !important;
    }

    .btn-success {
      background-color: #0192bc !important;
    }

    .btn-primary {
      background-color: #0192bc !important;
    }

    .album.bg-body-tertiary {
      margin-bottom: 20px !important;
      padding: 40px !important;
    }
  </style>


</head>

<body>

  <header data-bs-theme="dark">
    <div class="collapse text-bg-dark" id="navbarHeader">
      <div class="container">

      </div>
    </div>
    <!-- <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
        <strong>Album</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div> -->
  </header>

  <main>

    <section class=" text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="tituloweb">Amazon</h1>
          <div class="alert alert-danger" role="alert">
            Si el programa parece estar congelado, es porque estamos llevando a cabo actualizaciones y añadiendo nuevos productos. Agradecemos su paciencia. ¡Gracias!
          </div>
          <form class="file-upload-form form-control formulario" id="file-upload-form" action="upload_archivo.php" method="post" enctype="multipart/form-data">
            Selecciona el archivo comprimido:
            <input class="form-control" type="file" name="archivo" id="archivo"><br>
            <button class="btn btn-success" type="submit" value="Subir Archivo" name="submit"><i class="bi bi-arrow-up-circle"></i> Subir Archivo</button>

          </form>
          </p>
        </div>
      </div>
    </section>
    <section class="text-center container">
      <?php
      /* if ($eliminado == "si") {
        echo "<strong>Se han eliminado todos los archivos!</strong>";
      } */
      ?>
      <br>
      <div id="status"></div>
      <br>
      <div id="upload-status"></div>
      <textarea id="log-textarea" style="display: none;"></textarea>
    </section>
    <div class="album bg-body-tertiary">
      <div class="container">
      <div class="alert alert-primary" role="alert">
          <strong>Novedades: </strong>25/01/202 - Se agregó el producto 'Tazas Mágicas'.
        </div>
      <div class="alert alert-primary" role="alert">
          <strong>Novedades: </strong>11/12/2023 - Se agregó el producto 'Tazas Inicial + nombre Medio'...
        </div>
      <div class="alert alert-primary" role="alert">
          <strong>Novedades: </strong>10/12/2023 - Se agregó el producto 'Tazas Inicial + nombre Inferior'...
        </div>
        <div class="alert alert-primary" role="alert">
          <strong>Novedades: </strong>6/12/2023 - Se agregó el producto 'Botellas Equipos'...
        </div>
        <br>
        <div class="alert text-bg-success p-3" role="alert">
          <h4 class="alert-heading"><i class="bi bi-exclamation-circle"></i> Instrucciones</h4>
          <p class="texto">El programa ya no requiere que se suban archivos individuales, ahora se puede subir el archivo comprimido con todos los pedidos adentro. El nombre del archivo puede ser cualquiera, siempre que se respete la estructura de las carpetas.
            Ejemplo: <strong>/2023-09-13~20230913-71-rest/Placas_Spotify/Placa_Spotify_BASE/404-1478522-4477956_31486201616842/</strong>
          </p>
          <p>
            Se realizan los siguientes productos:
            <li>Placas Spotify (diseño nuevo).</li>
            <li>Botellas Equipo.</li>
            <li>Botellas Deportes.</li>
            <li>Felpudos.</li>
            <li>Tazas Equipos.</li>
            <li>Tazas Inicial + nombre inferior</li>
            <li>Tazas Inicial + nombre medio</li>
          </p>
          <p>Descargar archivo de ejemplo: <a href="2023-09-13~20230913-71-rest.zip">Archivo de ejemplo</a></p>
          <p>Vero el contador de productos: <a href="contador.php">Contador de productos</a></p>
          <hr>
        </div>


        <!-- <div class="alert alert-light" role="alert">
          <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  <i class="bi bi-play-fill"></i> Placas Spotify con base y sin base
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Placa_Spotify_BASE/Carpetas de cada pedido
                      </i><span>Placa_Spotify_BASE.zip</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Placa_Spotify_sin_BASE/Carpetas de cada
                        pedido</i><span>Placa_Spotify_sin_BASE.zip</span></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  <i class="bi bi-play-fill"></i> Placas Spotify con Llaveros
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Placa_Spotify_1llavero/Carpetas de cada pedido
                      </i><span>Placa_Spotify_1llavero.zip</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Placa_Spotify_2llaveros/Carpetas de cada
                        pedido</i><span>Placa_Spotify_2llaveros.zip</span></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                  <i class="bi bi-play-fill"></i> Felpudos
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Felpudo_33x60/Carpetas de cada pedido
                      </i><span>Felpudo_33x60.zip</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Felpudo_40x70/Carpetas de cada
                        pedido</i><span>Felpudo_40x70.zip</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><i class="bi bi-file-zip"> Felpudo_60x100/Carpetas de cada
                        pedido</i><span>Felpudo_60x100.zip</span></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div> -->

      </div>
    </div>
    <br>
  </main>

  <footer class="text-body-secondary py-5">
    <div class="container">
      <p class="mb-1">Version 3.0</p>
    </div>
  </footer>
  <!--   <script>
    $(document).ready(function() {
      var checkInterval; // Guarda el intervalo para poder limpiarlo más tarde

      $("#file-upload-form").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          url: 'upload.php',
          method: 'post',
          data: new FormData(this),
          processData: false,
          contentType: false,
          beforeSend: function() {
            $('#upload-status').html('<p>Procesando el archivo...</p>');
            $('#loading-gif').show();
            $('#log-textarea').show(); // Muestra el textarea
            startGettingLog(); // Empieza a obtener el contenido del log
          },
          complete: function(response) {
            $('#file-upload-form')[0].reset();
            startCheckingFile();
          }
        });
      });

      function startGettingLog() {
        setInterval(function() {
          $.get('get_registro.php', function(data) {
            $('#log-textarea').val(data); // Carga el contenido del log en el textarea
          });
        }, 1000); // Obtiene el contenido del log cada segundo
      }
      function startCheckingFile() {
        checkInterval = setInterval(updateLatestFile, 5000); // Comprueba cada 5 segundos
      }

      function updateLatestFile() {
        $.get('file.php', function(data) {
          console.log(data); // Añade esta línea para ver qué es lo que devuelve file.php
          if (data) {
            $('#latest-file').html('<div class="file-download"> <p>Se procesaron las placas: <a href="' + data + '">Descargar</a></p></div>');
            $('#loading-gif').hide();
            $('#upload-status').hide();
            clearInterval(checkInterval); // Limpia el intervalo una vez que el archivo está listo
          }
        });
      }
      setInterval(function() {
        $.get('estado.php', function(data) {
          $('#status').html(data);
        });
      }, 1000); // Actualiza cada segundo

    });
  </script> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>


</body>

</html>