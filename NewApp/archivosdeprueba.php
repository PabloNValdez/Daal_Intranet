<?php 
    require 'includes/funciones.php';
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
    //use ZipArchive;

    //Los SKU asociados a las placas Spotify
    $allowed_skus_spotify = ['Placa_Luz', 'PLACA-1LLAV', 'PLACA-2LLAV', 'XG-XTS3-4OW8', 'RY-SFSN-TEZ8', 'IG-3M8S-0B0S'];
    // Los SKU asociados a las botellas
    $allowed_skus_bottle = ['BOTTLE-123', 'BOTTLE-456', 'BOTTLE-789']; // Actualiza con los SKUs reales

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
                echo '<tr><th>Seleccionar</th><th>Order ID</th><th>Item ID</th><th>SKU</th><th>Nombre del Producto</th><th>Tipo de Producto</th></tr>';
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

            $result = $conn->query("SELECT url, product_type FROM temp_urls");
            while ($row = $result->fetch_assoc()) {
                $url = $row['url'];
                $productType = $row['product_type'];
                $fileContents = file_get_contents($url);
                if ($fileContents !== FALSE) {
                    $pathInfo = pathinfo($url);
                    $fileName = $productType . '/' . $pathInfo['basename'];
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
            <input type="file" name="excelFile" accept=".xlsx">
            <br><br>
            <input type="submit" value="Subir">
        </form>

    </div>

</body>

</html>
