<?php 
    require 'includes/funciones.php';
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    //use ZipArchive;

    //Los SKU asociados a las placas Spotify
    $allowed_skus = ['Placa_Luz', 'PLACA-1LLAV', 'PLACA-2LLAV', 'XG-XTS3-4OW8', 'RY-SFSN-TEZ8', 'IG-3M8S-0B0S'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
            $fileName = $_FILES['excelFile']['name'];
            $fileTmpPath = $_FILES['excelFile']['tmp_name'];
            $fileSize = $_FILES['excelFile']['size'];
            $fileType = $_FILES['excelFile']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            if ($fileExtension == 'xlsx') {
                //echo '<h3>Formato válido.</h3>';
                $reader = new Xlsx();
                $spreadsheet = $reader->load($fileTmpPath);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();
    
                echo '<form action="" method="post">';
                //echo '<h3>Archivo Subido Correctamente</h3>';
                echo '<table border="1">';
                echo '<tr><th>Seleccionar</th><th>Order ID</th><th>Item ID</th><th>SKU</th><th>Nombre del Producto</th></tr>';
                foreach ($data as $row) {
                    $sku = isset($row[10]) ? $row[10] : '';
                    if (in_array($sku, $allowed_skus)) {
                        echo '<tr>';
                        echo '<td><input type="checkbox" name="urls[]" value="' . htmlspecialchars($row[24]) . '"></td>';
                        echo '<td>' . (isset($row[1]) ? $row[1] : '') . '</td>'; // Order ID
                        echo '<td>' . (isset($row[1]) ? $row[1] : '') . '</td>'; // Item ID
                        echo '<td>' . $sku . '</td>'; // SKU
                        echo '<td>' . (isset($row[11]) ? $row[11] : '') . '</td>'; // Nombre
                        //echo '<td>' . (isset($row[24]) ? $row[24] : '') . '</td>'; // URL
                        //echo '<td>' . (isset($row[25]) ? $row[25] : '') . '</td>'; // Page
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

            // Vaciar la tabla temporal
            $conn->query("TRUNCATE TABLE temp_urls");

            // Insertar URLs en la tabla temporal
            foreach ($urls as $url) {
                $url = $conn->real_escape_string($url);
                $conn->query("INSERT INTO temp_urls (url) VALUES ('$url')");
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
