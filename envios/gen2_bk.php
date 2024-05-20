<?php
session_start();

// Controlo si el usuario ya está logueado en el sistema.
if (isset($_SESSION['email'])) {
} else {
    // Si no está logueado lo redirecciono a la página de login.
    header("HTTP/1.1 302 Moved Temporarily");
    header("Location: iniciar.php");
}
?><?php

if(!empty($_GET['fichero'])){
    $fileName = basename($_GET['fichero']);
    $filePath = 'ficheros/'.$fileName;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'Imposible descargar el archivo, error.';
    }
}
if (!isset($_GET["ordenes"])) {
    header("HTTP/1.1 302 Moved Temporarily");
    header("Location: index.php?vacio=1");
} else {
    require 'db.php';
    if ($conn->connect_errno) {
        echo "Tenemos un problemita";
    }
    //Array desde GET formulario
    $array = $_GET["ordenes"];
    $array_num = count($array);

    // Creo contador
    $contador = 0;
    //Creo archivo temporal
    $file = "fichero_temporal.txt";

    //Creo encabezado del fichero text
    $jump = "\r\n";
    $separator = "\t";
    $fp = fopen($file, 'a');
    $registro =
        'order-id' . $separator .
        'order-item-id' . $separator .
        'purchase-date' . $separator .
        'payments-date' . $separator .
        'reporting-date' . $separator .
        'promise-date' . $separator .
        'days-past-promise' . $separator .

        'buyer-email' . $separator .
        'buyer-name' . $separator .
        'buyer-phone-number' . $separator .

        'sku' . $separator .
        'product-name' . $separator .
        'quantity-purchased' . $separator .
        'quantity-shipped' . $separator .
        'quantity-to-ship' . $separator .

        'ship-service-level' . $separator .
        'recipient-name' . $separator .

        'ship-address-1' . $separator .
        'ship-address-2' . $separator .
        'ship-address-3' . $separator .


        'ship-city' . $separator .
        'ship-state' . $separator .
        'ship-postal-code' . $separator .
        'ship-country' . $separator .

        'sales-channel' . $separator .
        'customized-url' . $separator .
        'customized-page' . $separator .
        'is-business-order' . $separator .
        'purchase-order-number' . $separator .
        'price-designation' . $separator .
        'is-prime' . $separator .
        'is-iba' . $jump;
    fwrite($fp, $registro);
    //While con consulta 
    while ($contador < $array_num) {
        $valor = $array[$contador];
        $sql = $conn->query("SELECT entity_id,increment_id, created_at, shipping_address_id,customer_email,shipping_description FROM sales_order WHERE increment_id = '$valor';");

        while ($row = mysqli_fetch_array($sql)) {
            $shippin_id = $row['shipping_address_id'];
            $sql2 = $conn->query("SELECT * FROM `sales_order_address` WHERE entity_id = '$shippin_id';");
            $sales_order_address = mysqli_fetch_array($sql2);
            $sql3 = $conn->query("SELECT * FROM `sales_shipment_grid` WHERE order_increment_id = '$valor';");
            $sales_shipment_grid = mysqli_fetch_array($sql3);

            if($sales_shipment_grid['shipping_name']==""){
                $nombreCliente = $sales_order_address['firstname']." ". $sales_order_address['lastname'];
            }else{
                $nombreCliente =  $sales_shipment_grid['shipping_name'];
            }

            if($sales_shipment_grid['shipping_address']==""){
                $direccion = preg_replace("[\n|\r|\n\r]", "",$sales_order_address['street']);
            }else{
                $direccion = preg_replace("[\n|\r|\n\r]", "",$sales_shipment_grid['shipping_address']);
            }
            
            $registro2 =
                $row['increment_id'] . $separator .
                $row['increment_id'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .

                $row['customer_email'] . $separator .
                $sales_shipment_grid['shipping_name'] . $separator .
                $sales_order_address['telephone'] . $separator .

                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .

                $row['shipping_description'] . $separator .
                $nombreCliente . $separator .


                $direccion . $separator .
                "-" . $separator .
                "-" . $separator .

                $sales_order_address['city'] . $separator .
                $sales_order_address['region'] . $separator .
                $sales_order_address['postcode'] . $separator .
                $sales_order_address['country_id'] . $separator .


                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                $jump;
            fwrite($fp, $registro2);
        }
        $contador++;
    }
    $nombre = date('j-m-y_h-i-s');
    $origen = __DIR__ . "/fichero_temporal.txt";
    $destino = __DIR__ . "/ficheros/" . $nombre . ".txt"; #Copiar pero cambiar nombre

    $ur_corta = mb_substr($destino, strlen(__DIR__), null, "UTF-8");


    $resultado = copy($origen, $destino);
    $eliminar = unlink($origen);
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
                            <h1 class="display-4">Fichero TXT Generado</h1>
                        </div>
                    </div>
                    <!-- End -->
                    <div class="row">
                        <div class="col-lg-7 mx-auto">
                            <div class="bg-white rounded-lg shadow-sm p-5">
                                <div class="tab-content">
                                    <div id="nav-tab-card" class="tab-pane fade show active">
                                        <p class="alert alert-success">
                                            <strong> Total ordenes: </strong> <?php echo $array_num; ?>
                                        </p>
                                        <form role="form">
                                            <div class="form-group">
                                                <label for="username"><strong>Descargar fichero:</strong></label>
                                                <br>
                                                <a href="gen2.php?fichero=<?php echo $ur_corta; ?>">Descargar Fichero TXT</a>

                                            </div>
                                            <hr>
                                            <div class="form-group">

                                                <label for="cardNumber"><strong>Ubicacion del fichero:</strong></label><br>
                                                <?php echo $destino; ?>
                                            </div>
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
} //fin de comprobacion de que se recibe datos via GET
?>