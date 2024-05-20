<?php
$archivo = $_GET['archivo'];
$base = $_GET['base'];
$llaveros = $_GET['llaveros'];
if ($llaveros === "1") {
    $h1 = "Placa Spotify con 1 llavero";
}else{
    $h1 = "Placa Spotify con 2 llaveros";
}

include '../../funciones/funciones.php';

$sql = "SELECT COUNT(*) as totalCarpetas FROM carpetas WHERE archivo = '$archivo'";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
$totalCarpetas = $row['totalCarpetas'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Amazon - Placa Spotify</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style type="text/css">
        body {
            background: #f5f5f5;
            margin-top: 20px;
        }

        /*------- portfolio -------*/
        .project {
            margin: 15px 0;
        }

        .no-gutter .project {
            margin: 0 !important;
            padding: 0 !important;
        }

        .has-spacer {
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 30px;
        }

        .has-spacer-extra-space {
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 30px;
        }

        .has-side-spacer {
            margin-left: 30px;
            margin-right: 30px;
        }

        .project-title {
            font-size: 1.25rem;
        }

        .project-skill {
            font-size: 0.9rem;
            font-weight: 400;
            letter-spacing: 0.06rem;
        }

        .project-info-box {
            margin: 15px 0;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 5px;
        }

        .project-info-box p {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #d5dadb;
        }

        .project-info-box p:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        /* img {
            width: 100%;
            max-width: 100%;
            height: auto;
            -webkit-backface-visibility: hidden;
        } */

        .rounded {
            border-radius: 5px !important;
        }

        .btn-xs.btn-icon {
            width: 34px;
            height: 34px;
            max-width: 34px !important;
            max-height: 34px !important;
            font-size: 10px;
            line-height: 34px;
        }

        .btn-xs.btn-icon span,
        .btn-xs.btn-icon i {
            line-height: 34px;
        }

        .btn-icon.btn-circle span,
        .btn-icon.btn-circle i {
            margin-top: -1px;
            margin-right: -1px;
        }

        .btn-icon i {
            margin-top: -1px;
        }

        .btn-icon span,
        .btn-icon i {
            display: block;
            line-height: 50px;
        }

        a.btn,
        a.btn-social {
            display: inline-block;
        }

        .mr-5 {
            margin-right: 5px !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .btn-facebook,
        .btn-facebook:active,
        .btn-facebook:focus {
            color: #fff !important;
            background: #4e68a1;
            border: 2px solid #4e68a1;
        }

        .btn-circle {
            border-radius: 50% !important;
        }

        .project-info-box p {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #d5dadb;
        }

        p {
            font-family: "Barlow", sans-serif !important;
            font-weight: 300;
            font-size: 1rem;
            color: #686c6d;
            letter-spacing: 0.03rem;
            margin-bottom: 10px;
        }

        b,
        strong {
            font-weight: 700 !important;
        }

        .tituloweb {
            color: #0192bc;
        }

        .btn-success {
            background-color: #0192bc !important;
        }

        .btn-primary {
            background-color: #0192bc !important;
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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
</head>

<body>

    <div class="container">
        <section class=" text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="tituloweb">Amazon</h1>
                </div>
            </div>
        </section>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="project-info-box mt-0">
                    <h3 class="tituloweb"><?php echo $h1; ?></h3>
                </div>
                <div class="project-info-box">
                    <div id="mensaje">Iniciando el procesamiento de las placas...</div>

                    <div id="progreso">0%</div>
                    <div id="barraProgreso" style="width: 100%; background-color: #ddd;">
                        <div id="barraProgresoInterna" style="height: 24px; background-color: #105465;"></div>
                    </div>
                    <p>Archivo esperado: <?php echo $archivo; ?>.zip</p>
                </div>
                <div class="project-info-box mt-0 mb-0">
                    <p class="mb-0">
                    <div id="contenidoComprimir"></div>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="project-info-box mt-0">
                    <div id="imagenDiv" class="text-center">
                        <img id="imagen" src="placa.jpg" alt="Imagen de Progreso" width="300">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Ver registro de procesamiento
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body"><textarea id="log-textarea"></textarea></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script>
        var totalCarpetas = <?php echo $totalCarpetas ?>;

        function procesarCarpeta() {
            var archivo = '<?php echo $archivo ?>';
            var llaveros = '<?php echo $llaveros ?>';
            var base = '<?php echo $base ?>';

            $.ajax({
                url: 'procesamiento.php',
                type: 'GET',
                data: {
                    archivo: archivo,
                    llaveros: llaveros,
                    base: base
                },
                success: function(response) {
                    var respuesta = JSON.parse(response);
                    console.log(respuesta.message);
                    $("#mensaje").html("Quedan <strong>" + respuesta.carpetasRestantes + " </strong> pedidos por procesar.");

                    if (respuesta.procesoCompletado) {
                        $.ajax({
                            url: 'comprimir.php',
                            type: 'GET',
                            data: {
                                archivo: archivo,
                                tipodeplaca: base
                            },
                            success: function(respuestaComprimir) {
                                $('#contenidoComprimir').html(respuestaComprimir);
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    } else {
                        var porcentajeProgreso = ((totalCarpetas - respuesta.carpetasRestantes) / totalCarpetas) * 100;
                        porcentajeProgreso = parseInt(porcentajeProgreso.toFixed(0));
                        $("#progreso").text(porcentajeProgreso + "%");
                        $("#barraProgresoInterna").width(porcentajeProgreso + "%");

                        if (respuesta.ultimaCarpeta) {
                            var newImageSrc = 'https://chat.getsingular.com/amazon/' + respuesta.ultimaCarpeta + '/placa.png';
                            $('#imagen').attr('src', newImageSrc);
                        }

                        // Movemos la llamada a setTimeout aquí
                        setTimeout(procesarCarpeta, 2000);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        function startGettingLog() {
        setInterval(function() {
          $.get('../../get_registro.php', function(data) {
            $('#log-textarea').val(data); // Carga el contenido del log en el textarea
          });
        }, 1000); // Obtiene el contenido del log cada segundo
      }

        // Llamamos a procesarCarpeta sin setTimeout aquí
        procesarCarpeta();
        startGettingLog()
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>