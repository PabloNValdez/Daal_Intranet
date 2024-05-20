<?php
session_start();
// Verificar si el usuario ya ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

require 'includes/funciones.php';
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    // el archivo cargado
    $archivo = $_FILES["archivo"]["tmp_name"];
    $nombreArchivo = $_FILES["archivo"]["name"];

    // Comprueba la extensión del archivo
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    if (strtolower($extension) !== "txt") {
        echo "Error: Solo se permiten archivos .txt";
        return;
    }
    // Leemos el contenido del archivo .txt
    $lines = file($archivo);

    // Creamos una matriz para almacenar las nuevas líneas
    $newLines = [];
    // Creamos un conjunto para almacenar las órdenes procesadas
    $processedOrders = [];
    
    // Analizamos cada línea
    foreach ($lines as $line) {
        // Ignoramos la primera línea porque contiene los títulos de las columnas
        if (strpos($line, ' Delivery Note Number') === 0) {
            continue;
        }

        // Convertimos los caracteres especiales a ANSI
        $parts = explode("\t", replaceSpecialChars($line));

        // Obtenemos el 'order-item-id' que empieza en la posición 1 (0 en índice de PHP)
        $orderItemId = substr($line, 0, 19); // ajusta el segundo argumento al número de caracteres que quieras extraer

        // Obtenemos el 'Shipm.-ID' que empieza en la posición 106 (105 en índice de PHP)
        $shipmId = substr($line, 105, 18); // ajusta el segundo argumento al número de caracteres que quieras extraer

        // Verificamos si la orden ya ha sido procesada
        if (in_array($orderItemId, $processedOrders)) {
            continue;
        }

        $sql = "SELECT * FROM `envios` WHERE `ordenItem` = '$orderItemId' ORDER BY id DESC LIMIT 1";
        $resultado = $conn->query($sql);
        $fecha = date('m-d-Y');
        $fila = $resultado->fetch_assoc();

        if ($fila !== null) {
            $newLine = $fila['ordenItem'] . "\t\t\t" . $fecha . "\t" . "DPD" . "\t\t" . $shipmId . "\t" . "Predict";
            $newLines[] = $newLine;
            // Agregamos la orden a las procesadas
            $processedOrders[] = $orderItemId;
        } else {
            //echo "No se encontró una fila para ordenItem: $orderItemId\n"; // Añade este mensaje si es necesario
        }
    }
    $nombreArchivo = $_FILES['archivo']['name'];
    $nombreArchivo = pathinfo($nombreArchivo, PATHINFO_FILENAME);
    // Creamos el archivo .data
    $file = fopen($nombreArchivo . '-envio.txt', 'w');

    // Escribimos la versión en el archivo .data
    fwrite($file, "order-id\torder-item-id\tquantity\tship-date\tcarrier-code\tcarrier-name\ttracking-number" . PHP_EOL);

    // Escribimos las nuevas líneas en el archivo .data
    fwrite($file, implode(PHP_EOL, $newLines));

    // Cerramos el archivo
    fclose($file);
}


function replaceSpecialChars($string)
{
    $string = str_replace("ñ", "n", $string);
    $string = str_replace("Ñ", "N", $string);
    return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Matias Sublimet">
    <meta name="generator" content="Visual Studio">
    <title>Amazon a DPD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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

        .navbar-nav .nav-link.active,
        .navbar-nav .nav-link.show {
            color: #fff;
            font-weight: bold;
        }

        .navbar-nav .nav-link {
            color: #fff;

        }
    </style>
    <link href="estilo.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #0192bc;">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <strong style="color:#fff">DPD</strong>
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php"><i class="bi bi-repeat"></i> Amazon a DPD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="seguimiento-dpd.php"><i class="bi bi-truck"></i> Seguimiento DPD Amazon</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex" role="search">
                    <p style="color:#fff; margin-top:5px">Bienvenido, <strong><a style="color:#fff" href="cerrar.php">cerrar sesión</a></strong></p>
                </div>
            </div>
            <nav>
    </header>
    <main class="d-flex align-items-center py-5">
        <form class="form-signin w-100 m-auto" method="post" enctype="multipart/form-data">
            <h2 class="center text-center">Convertir de DPD a Amazon Seguimientos</h2>
            <div class="form-floating">
                <div class="card text-center sombra">
                    <div class="card-body">
                        <h5 class="card-title">Subir archivo TXT de DPD</h5>
                        <div class="input-group">
                            <input type="file" name="archivo" id="archivo" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        </div>
                    </div>
                    <?php
                    if (isset($_POST["submit"])) {
                        echo "<p>Archivo convertido exitosamente. Registros procesados: <span class='badge text-bg-success'>" . count($newLines) . '</span></p>';
                        echo '<div class="d-grid gap-2 d-md-block"><a href="' . $nombreArchivo . '-envio.txt" type="button" class="btn btn-success" download>Descargar archivo</a><br><br></div>';
                    }
                    ?>
                </div>
            </div>
            <br>
            <button class="btn btn-primary w-100 py-2" name="submit" type="submit">Convertir archivo</button>
        </form>
    </main>
</body>

</html>