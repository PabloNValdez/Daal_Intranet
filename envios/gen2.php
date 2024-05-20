<?php
session_start();

// Controlo si el usuario ya está logueado en el sistema.
if (isset($_SESSION['email'])) {
} else {
    // Si no está logueado lo redirecciono a la página de login.
    header("HTTP/1.1 302 Moved Temporarily");
    header("Location: iniciar.php");
}


include 'includes/funciones.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>


<?php
if (!empty($_GET['fichero'])) {
    $archivo = $_GET['fichero'];
    $carpeta = $_GET['carpeta'];
    descargaArchivo($archivo, $carpeta);
}


if (!isset($_GET["ordenes"])) {
    header("HTTP/1.1 302 Moved Temporarily");
    header("Location: index.php?vacio=1");
} else {
    if ($_GET["opcion"] == "envios") {
        // Llamada a la función
        $ordenes = $_GET["ordenes"];
        $resultados = generarFicheroTXT($ordenes);

        // Obtener los valores
        $array_num = $resultados['array_num'];
        $url_corta = $resultados['url_corta'];
        $carpeta = "ficheros";
        $titulo = "Descargar Fichero de Envío";
    } else {
        $nombreCarpeta = date("Y-m-d_H-i-s");
        $pedidos = $_GET["ordenes"];
        foreach ($pedidos as $pedido) {
            $codigoADescargar = $pedido;
            descargarCodigoBarras($codigoADescargar);
            $factura = crearFactura($pedido, $nombreCarpeta);
            // Hacer algo con la factura, por ejemplo, imprimir o almacenar en una variable           
        }
        $rutaCarpeta = $rutaAbsolutaProyecto . 'Facturas/' . $factura . '/';
        $rutaGuardado = $rutaAbsolutaProyecto . 'Facturas/';
        //echo $rutaCarpeta;
        comprimirCarpeta($rutaCarpeta, $factura . '.zip', $rutaCarpeta);
        $titulo = "Descargar Facturas";
        $url_corta = $factura . '.zip';
        $carpeta = "Facturas/" . $factura . "/";
    }

?>


    <!doctype html>
    <html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Envios</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
        <script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
        </style>


    </head>

    <body>

        <header>

            <div class="navbar" style="background-color: #0192bc;">
                <div class="container">
                    <a href="index.php" class="navbar-brand d-flex align-items-center">
                        <strong style="color:#fff">Getsingular</strong>
                    </a>
                    <div class="d-flex" role="search">
                        <p style="color:#fff">Bienvenido, <strong><a style="color:#fff" href="cerrar.php">cerrar sesión</a></strong></p>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="container">
                <div class="container py-5">
                    <!-- For demo purpose -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mx-auto text-center"> <br>
                            <h1 class="display-4"><?php echo $titulo; ?></h1>
                        </div>
                    </div>
                    <!-- End -->
                    <div class="row">
                        <div class="col-lg-7 mx-auto">
                            <div class="bg-white rounded-lg shadow-sm p-5">
                                <div class="tab-content">
                                    <div id="nav-tab-card" class="tab-pane fade show active">
                                        
                                            <?php
                                            if (isset($array_num)) {
                                                echo "<p class='alert alert-success'><strong> Total ordenes: </strong> $array_num </p>";
                                            }

                                            ?>

                                        
                                        <form role="form">
                                            <div class="form-group">
                                                <label for="username"><strong>Descargar fichero:</strong></label>
                                                <br>
                                                <div class="d-grid gap-2 col-4 mx-auto">
                                                <a class="btn btn-primary" href="<?php echo $carpeta . $url_corta; ?>" download="<?php echo $url_corta; ?>">Descargar archivo</a>
                                                </div>

                                                

                                            </div>
                                            <hr>

                                        </form>
                                    </div>

                                </div>
                                <!-- End -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <footer class="footer mt-auto py-3 bg-light fixed-bottom">
            <div class="container">
                <span class="text-muted"><a href="index.php" class="btn btn-primary float-end"><i class="bi bi-arrow-left-short"></i> Volver</a></form></span>
            </div>
        </footer>


        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


    </body>

    </html>

<?php
    //fin de comprobacion de que se recibe datos via GET

}
?>