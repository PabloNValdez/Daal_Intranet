<?php 
    require 'includes/funciones.php';
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    //use ZipArchive;

    //Los SKU asociados a las placas Spotify
    $allowed_skus_spotify = ['Placa_Luz', 'PLACA-1LLAV', 'PLACA-2LLAV', 'XG-XTS3-4OW8', 'RY-SFSN-TEZ8', 'IG-3M8S-0B0S'];
    // Los SKU asociados a las botellas
    $allowed_skus_bottle = ['040560004-500-ef-celta', '040560004-500-ef-granada', '040560004-500-ef-espanyol', '040560004-500-ef-villarreal', '040560004-500-ef-girona', 
                            '040560004-500-ef-cadiz', '4055-botnom-350verde', '4055-botnom-750verde', '4055-bl-750-nommedio', '040560004-500-pl-fut3-', '4055-botdis-500foto',
                            '4055-botdis-350foto', '4055-botdis-750foto', '4055-botnominicial-500Plumas', '040560004-500-ef-rsociedad', '040560004-500-ef-athletic', '040560004-500-ef-valencia',
                            '040560004-500-ef-valencia', '040560004-500-ef-atmadrid', '040560004-500-ef', '040560004-500-ef-betis', '040560004-500-ef-barca', '040560004-500-ef-sevilla',
                            '040560004-500-ef-madrid' , '040560004-500-plat-fut4-', '040560004-500-bl-tenis1-', '040560004-500-verde-fut4', '040560004-500-plat-futbol1', '040560004-500-bl-fut2',
                            '040560004-500-bl-basq2', '040560004-500-ver-basq1', '040560004-500-bl-padel1', '040560004-500-pl-padel2', '040560004-500-am-fut4', '040560004-500-bl',
                            '040560004-500-am-padel2', '040560004-500-pl-tenis1', '040560004-500-ver-tenis1', '040560004-500-am-basq1', '040560004-500-am-fut1', '040560004-500-am-padel1', 
                            '040560004-500-pl-basq1', '040560004-500-ver-fut1', '040560004-500-ver-fut2', '040560004-500-bl-tenis2', '040560004-500-ver-fut3', '040560004-500-am-tenis1', 
                            '040560004-500-am-fut3', '040560004-500-bl-padel2', '040560004-500-pl-basq2', '040560004-500-bl-fut3', '040560004-500-ver-padel2', '040560004-500-bl-fut1', 
                            '040560004-500-am-basq2', '040560004-500-ver-basq2', '040560004-500-ver-padel1', '040560004-500-am-fut2', '040560004-500-bl-basq1', '040560004-500-pl-tenis2', 
                            '040560004-500-bl-fut4', '040560004-500-am-tenis2', '040560004-500-pl-fut2', '040560004-500-ver-tenis2', '040560004-500-pl-padel1', '4055-bi-350nommedio', 
                            '4055-bi-750nomdebajo', '4055-bi-350nomdebajo', '4055-bi-500nommedio', '4055-bi-500nomdebajo', '4055-botcumple-500Mentalida', '4055-botcumple-750Cantinú', 
                            '4055-botcumple-350Maravill', '4055-botcumple-350Losabe', '4055-botcumple-500Losabe', '4055-botcumple-750Maravill', '4055-botcumple-500Carr', '040560009-NomInic-EmojisRosa', 
                            '040560009-NomInic-DinoRosa', '040560009-NomInic-UnicorRosa', '040560009-NomInic-DinoAzul', '040560009-NomInic', '040560009-NomInic-AnimRosa', '040560009-NomInic-GeomeAzul', 
                            '040560009-NomInic-EmojisAzul', '040560009-NomInic-UnicorAzul', '040560009-NomInic-GeomeRosa', '040560009-NomInic-AnimAzul', '040560009-Nom', '040560009-Nom-SolLunaRosa', 
                            '040560009-Nom-IndioRosa', '040560009-Nom-ZebraRosa', '040560009-Nom-ZebraAzul', '040560009-Nom-ConejitoAzul', '040560009-Nom-IndioAzul', '040560009-Nom-ArcoirisAzul', 
                            '040560009-Nom-SolLunaAzul', '040560009-Nom-ConejitoRosa', '040560009-Nom-ArcoirisRosa', '040560009-Nom-ZorroAzul', '040560009-Nom-ZorroRosa', '4055-botcumple-350Granaño', 
                            '4055-botcumple-750Losabes', '4055-botcumple-500Montón', '4055-botcumple-750Carro', '4055-botcumple-500Cantinúa', '4055-botcumple-500Maravilla', '4055-botcumple-350Cantinúa', 
                            '4055-botcumple-750Montón', '4055-botcumple-500Granaño', '4055-botcumple-750Mentalidad', '4055-botcumple-350Mentalidad', '4055-botcumple-350Carro', '4055-botcumple', 
                            '4055-botcumple-750Granaño', '4055-botcumple-350Cumple', '4055-botcumple-350Masuno', '4055-botcumple-350Montón', '4055-botcumple-750Cumplea', '4055-botcumple-500Masuno', 
                            '4055-botcumple-750Masuno', '4055-botcumple-500Cumplea', '4055-botnominicial-350Cactus', '4055-botnominicial-500Laurel', '4055-botnominicial-500Floral', '4055-botnominicial-750Laurel', 
                            '4055-botnominicial-500Script', '4055-botnominicial-350Script', '4055-botnominicial-350Plumas', '4055-botnominicial-750Script', '4055-botnominicial-750Cactus', '4055-botnominicial-750Plumas', 
                            'botnominicial-500-Cactus', '4055-botnominicial-350Laurel', '4055-botnominicial-750Floral', '4055-botnominicial-350Floral', '4055-botnominicial', '4055-botnomfrases-350Siempre', 
                            '4055-botnomfrases-500-Siempre', '4055-botnomfrases-750Lugarfavorito', '4055-botnomfrases-750Atulado', '4055-botnomfrases-750Favorita', '4055-botnomfrases-350Atulado', '4055-botnomfrases-500Atulado', 
                            '4055-botnomfrases-350Vida', '4055-botnomfrases-350Favorita', '4055-botnomfrases-500Mejor', 'botnomfrases-350Mejor', 'botnomfrases-750Especial', 'botnomfrases-500Especial', 
                            'botnomfrases-500Lugarfavorito', '4055-botnomfrases-350Especial', '4055-botnomfrases-500-Vida', '4055-botnomfrases-350Lugarfavorito', '4055-botnomfrases-750Vida', '4055-botnomfrases-500Favorita', 
                            '4055-botnomfrases-750Siempre', '4055-botnomfrases-750Mejor', '4055-botnomfrases', '4055-botnombre-500plateado-purpurina', '4055-botnombre-500cobre-purpurina', '4055-botnombre-500rosa-purpurina', 
                            '040560009-azul', '040560009-rosa', '040560009', '4055-botpadre750-mogollon', '4055-botpadre500-felicidades', '4055-botpadre350-mejorabuelo', '4055-botpadre750-gracias', '4055-botpadre750-papi',
                            '4055-botpadre350-mogollon', '4055-botpadre350-escudo', '4055-botpadre500-todoymas', '4055-botpadre750-100', '4055-botpadre750-escrito', '4055-botpadre500-mogollon', 
                            '4055-botpadre750-felicidades', '4055-botpadre500-100', '4055-botpadre500-encasa', '4055-botpadre350-chupetepapa', '4055-botpadre500-mejorabuelo', '4055-botpadre500-escudo', 
                            '4055-botpadre350-encasa', '4055-botpadre350-gracias', '4055-botpadre750-todoymas', '4055-botpadre350-casapapa', '4055-botpadre350-mejorapapa', '4055-botpadre750-encasa', 
                            '4055-botpadre500-escrito', '4055-botpadre350-rayas', '4055-botpadre', '4055-botpadre500-mejorpapa', '4055-botpadre500-chupetepapa', '4055-botpadre350-papi', '4055-botpadre750-mejorabuelo',
                            '4055-botpadre750-chupetepapa', '4055-botpadre500-rayas', '4055-botpadre350-escrito', '4055-botpadre750-rayas', '4055-botpadre350-todoymas', '4055-botpadre750-escudo', 
                            '4055-botpadre500-casapapa', '4055-botpadre750-casapapa', '4055-botpadre500-gracias', '4055-botpadre350-felicidades', '4055-botpadre750-mejorpapa', '4055-botpadre500-papi', 
                            '4055-botpadre350-100', '4055-botdis-750dust', '4055-botdis-500geometric', '4055-botbdis-350geometric', '4055-botdis-750stripes', '4055-botdis-750love', '4055-botdis-750arrows',
                            '4055-botdis-500dust', '4055-botdis-750geometric', '4055-botdis-500love', '4055-botdis-500stripes', '4055-botdis-350stripes', '4055-botdis-350love', '4055-botdis', '4055-botbl-350plateado',
                            '4055-botnombre', '4055-botnombre-500blanco', '4055-botbl-500plateado', '4055-botnombre-500lila', '4055-botbl-500verde', '4055-botnombre-350amarillo', '4055-botnombre-750blanco',
                            '4055-botnombre-350blanco', '4055-botnombre-500amarillo', '4055-botbl-750plateado', '4055-botnombre-750lila', '4055-botnombre-750amarillo', '4055-botnombre-350lila', 
                            '4055-botella500verde', '4055-botella500blanca', '4055-botella750blanca', '4055-botella500lila', '4055-botella500amarillo', '4055-botella500plateado', '4055-botella750plateado',
                            '4055-botella350verde', '4055-botella350lila', '4055-botella350amarillo', '4055-botella750verde', '4055-botella750lila', '4055-botella750amarillo', '4055-botella350plateado',
                            '4055-botella350blanca', '4055-botella', '1303-botellaaluminio', '1303-botellaaluminio-blanca', '1303-botellaaluminio-plata'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $fileName = $_FILES['excelFile']['name'];
            $fileTmpPath = $_FILES['excelFile']['tmp_name'];
            $fileSize = $_FILES['excelFile']['size'];
            $fileType = $_FILES['excelFile']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            if ($fileExtension == 'xlsx') {
                $reader = new Xlsx();
                $spreadsheet = $reader->load($fileTmpPath);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();

                echo '<form action="" method="post">';
                echo '<table border="1">';
                echo '<tr><th>Seleccionar</th><th>Order ID</th><th>Item ID</th><th>SKU</th><th>Nombre del Producto</th></tr>';
                foreach ($data as $index => $row) {
                    $sku = isset($row[10]) ? $row[10] : '';
                    $productType = '';

                    if (in_array($sku, $allowed_skus_spotify)) {
                        $productType = 'Spotify';
                    } elseif (in_array($sku, $allowed_skus_bottle)) {
                        $productType = 'Bottle';
                    }

                    if ($productType) {
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="urls[]" value="' . htmlspecialchars($row[24]) . '"></td>';
                        echo '<td><input type="hidden" name="order_ids[]" value="' . (isset($row[1]) ? htmlspecialchars($row[1]) : '') . '">' . (isset($row[1]) ? $row[1] : '') . '</td>'; // Order ID
                        echo '<td><input type="hidden" name="item_ids[]" value="' . (isset($row[1]) ? htmlspecialchars($row[1]) : '') . '">' . (isset($row[1]) ? $row[1] : '') . '</td>'; // Item ID
                        echo '<td>' . $sku . '</td>'; // SKU
                        echo '<td>' . (isset($row[11]) ? $row[11] : '') . '</td>'; // Nombre
                        echo '<td><input type="hidden" name="product_types[]" value="' . $productType . '">' . $productType . '</td>'; // Tipo de Producto
                        if (isset($row[24])) {
                            echo '<td><a href="' . htmlspecialchars($row[24]) . '" target="_blank">Descargar</a></td>';
                        } else {
                            echo '<td>URL no disponible</td>';
                        }
                        echo '</tr>';
                    }
                }
                echo '</table>';
                echo '<input type="submit" name="saveUrls" value="Guardar Seleccionados">';
                echo '</form>';
            } else {
                echo '<h3>El archivo subido no es un .xlsx válido.</h3>';
            }
        } elseif (isset($_POST['saveUrls']) && !empty($_POST['urls'])) {
            $urls = $_POST['urls'];
            $order_ids = $_POST['order_ids'];
            $item_ids = $_POST['item_ids'];
            $product_types = $_POST['product_types'];

            // Vaciar la tabla temporal
            $conn->query("TRUNCATE TABLE temp_urls");

            // Insertar URLs en la tabla temporal
            foreach ($urls as $index => $url) {
                $url = $conn->real_escape_string($url);
                $orderId = $conn->real_escape_string($order_ids[$index]);
                $itemId = $conn->real_escape_string($item_ids[$index]);
                $productType = $conn->real_escape_string($product_types[$index]);
                $conn->query("INSERT INTO temp_urls (order_id, order_item_id, url, product_type) VALUES ('$orderId', '$itemId', '$url', '$productType')");
            }

            echo '<h3>URLs guardadas correctamente en la base de datos.</h3>';
            echo '<form action="" method="post">';
            echo '<input type="submit" name="downloadUrls" value="Descargar Todos">';
            echo '</form>';

        } elseif (isset($_POST['downloadUrls'])) {
            $zip = new ZipArchive();
            $zipFileName = 'descargas.zip';
            $zipFilePath = sys_get_temp_dir() . '/' . $zipFileName;

            if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
                exit("No se puede abrir el archivo ZIP");
            }

            $result = $conn->query("SELECT url FROM temp_urls");
            while ($row = $result->fetch_assoc()) {
                $url = $row['url'];
                $productType = $row['product_type'];
                $fileContents = file_get_contents($url);
                if ($fileContents !== FALSE) {
                    $pathInfo = pathinfo($url);
                    $fileName = $pathInfo['basename'];
                    $zip->addFromString($fileName, $fileContents);
                }
            }

            $zip->close();

            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipFileName);
            header('Content-Length: ' . filesize($zipFilePath));
            readfile($zipFilePath);
            unlink($zipFilePath);
            exit();
        } else {
            echo '<h3>Error al subir el archivo.</h3>';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sublimet APP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
        /* --------------------------------------------------------------------------------------------- */
        body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
        }

        table.order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: center; /* Center text */
            background-color: #fff;
        }

        .order-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: center; /* Center text in header */
            font-weight: bold;
        }

        .order-table th,
        .order-table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
            text-align: center; /* Center text in cells */
        }

        .order-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        $order-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .order-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .order-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .order-table img {
            max-width: 100px;
            height: auto;
        }

        .order-table .actions {
            display: flex;
            justify-content: center; /* Center buttons */
            gap: 10px;
        }

        .order-table .actions button {
            padding: 5px 10px;
            border: none;
            background-color: #009879;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .order-table .actions button:hover {
            background-color: #007f63;
        }

        #select-all {
            margin-right: 5px;
        }

        .button-container {
            text-align: right;
            margin-top: 20px;
        }

        .button-container button {
            padding: 10px 20px;
            border: none;
            background-color: #009879;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .button-container button:hover {
            background-color: #007f63;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
</head>

<body>

    <div class="container">
        <section class=" text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="tituloweb">Sublimet App</h1>
                </div>
            </div>
        </section>
        
        <button onclick="location.href='index.php'">Volver al inicio</button><br><br>
        <button onclick="location.href='logout.php'">Cerrar Sesión</button><br>

        <h2>Seleccionar archivo (.xlsx)</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <!-- <input type="file" name="excelFile" accept=".xlsx"> -->
                <input type="file" name="excelFile" accept=".xlsx">
                <br><br>
                <input type="submit" value="Subir">
            </form>

    </div>

</body>

</html>
