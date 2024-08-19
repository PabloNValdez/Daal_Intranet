<?php
require 'vendor/autoload.php';
use Fpdf\Fpdf;
use Picqer\Barcode\BarcodeGeneratorPNG;

// Configuración de la base de datos
$host = "localhost";
$user = "Getsingular";
$pass = "XdKFu67LyjtFQQvM";
$dbname = "conversor";

// Conexión a la base de datos
$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'get_pdf') {
        $order_id = $_GET['order_id'];
        $result = $mysqli->query("SELECT * FROM temp_urls WHERE order_id = '$order_id'");
        $data = $result->fetch_assoc();

        if ($data) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $order_id . '.pdf"');
            echo generatePDF($data);
        }
        exit;
    } elseif ($_GET['action'] === 'get_urls') {
        $result = $mysqli->query("SELECT * FROM temp_urls");
        $data = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
        exit;
    }
}

function generatePDF($data) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, "Recipient Name: " . $data['recipient_name'], 0, 1);
    $pdf->Cell(0, 10, "Address 1: " . $data['ship_address1'], 0, 1);
    if (!empty($data['ship_address2'])) {
        $pdf->Cell(0, 10, "Address 2: " . $data['ship_address2'], 0, 1);
    }
    $pdf->Cell(0, 10, "City: " . $data['ship_city'], 0, 1);
    $pdf->Cell(0, 10, "State: " . $data['ship_state'], 0, 1);
    $pdf->Cell(0, 10, "Purchase Date: " . $data['purchase_date'], 0, 1);
    $pdf->Cell(0, 10, "Company: GetSingular", 0, 1);
    $pdf->Cell(0, 10, "Order ID: " . $data['order_id'], 0, 1);
    $pdf->Cell(0, 10, "Detalles del pedido", 0, 1);
    $pdf->Cell(0, 10, "Product Name: " . $data['product_name'], 0, 1);
    $pdf->Cell(0, 10, "SKU: " . $data['sku'], 0, 1);
    $pdf->Cell(0, 10, "Order Item ID: " . $data['order_item_id'], 0, 1);
    $pdf->Cell(0, 10, "Quantity Purchased: " . $data['quantity_purchased'], 0, 1);
    $pdf->Cell(0, 10, "Image URL: " . $data['image_url'], 0, 1);

    // Generar código de barras para el Order ID
    $barcodeGenerator = new BarcodeGeneratorPNG();
    $barcode = $barcodeGenerator->getBarcode($data['order_id'], $barcodeGenerator::TYPE_CODE_128);

    // Guardar el código de barras como imagen temporal
    $barcodePath = tempnam(sys_get_temp_dir(), 'barcode') . '.png';
    file_put_contents($barcodePath, $barcode);

    // Añadir código de barras al PDF
    $pdf->Image($barcodePath, 10, $pdf->GetY() + 10, 100, 20); // Ajustar posición y tamaño según sea necesario

    // Eliminar imagen temporal
    unlink($barcodePath);

    // Guardar PDF en memoria
    return $pdf->Output('S');
}

$mysqli->close();
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar Archivos</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <style>
        #progress {
            margin-top: 20px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <button id="download-btn">Descargar Archivos</button>
    <div id="progress"></div> <!-- Div para mostrar el progreso -->

    <script>
    document.getElementById('download-btn').addEventListener('click', downloadAndUnzipFiles);

    async function downloadAndUnzipFiles() {
        const progressElement = document.getElementById('progress');
        progressElement.innerHTML = 'Obteniendo URLs...';

        const data = await getUrlsFromServer();
        const totalFiles = data.length;
        progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>`;

        const mainZip = new JSZip();
        const currentDate = new Date().toISOString().split('T')[0];
        const numeroAleatorio = Math.floor(1000 + Math.random() * 9000);
        const mainFolderName = `${currentDate}~${numeroAleatorio}`;
        const mainFolder = mainZip.folder(mainFolderName);

        let downloadedFiles = 0;

        for (const item of data) {
            const productFolder = mainFolder.folder(item.product_type);
            const subProductFolder = productFolder.folder(item.sub_product_type);
            const orderFolder = subProductFolder.folder(`${item.order_id}_${item.order_item_id}`);

            try {
                // Obtener y añadir el PDF al ZIP
                const pdfResponse = await fetch(`?action=get_pdf&order_id=${item.order_id}`);
                const pdfBlob = await pdfResponse.blob();
                orderFolder.file(`${item.order_id}.pdf`, pdfBlob);

                const proxyUrl = `?url=${encodeURIComponent(item.url)}`;
                downloadedFiles++;
                progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Descargando archivo ${downloadedFiles} de ${totalFiles}...`;

                const response = await fetch(proxyUrl);
                if (!response.ok) {
                    throw new Error(`Error al descargar ${item.url}: ${response.statusText}`);
                }
                const blob = await response.blob();
                const arrayBuffer = await blob.arrayBuffer();

                const zip = new JSZip();
                const zipContent = await zip.loadAsync(arrayBuffer);

                let imageCounter = 0;
                for (const [name, file] of Object.entries(zipContent.files)) {
                    if (!file.dir) {
                        const fileBlob = await file.async("blob");
                        const renamedFileName = await renameFileBasedOnResolution(fileBlob, name, item.order_id, imageCounter);
                        orderFolder.file(renamedFileName, fileBlob);
                        if (renamedFileName.includes('-vp')) imageCounter++;
                    }
                }
            } catch (error) {
                console.error(error);
                progressElement.innerHTML += `<br>Error al descargar archivo ${downloadedFiles}: ${error.message}`;
            }
        }

        progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Generando archivo ZIP...`;

        mainZip.generateAsync({ type: 'blob' }).then((content) => {
            saveAs(content, `${currentDate}~${numeroAleatorio}.zip`);
        });
    }

    async function getUrlsFromServer() {
        const response = await fetch('?action=get_urls');
        if (!response.ok) {
            throw new Error('Error al obtener las URLs');
        }
        const urls = await response.json();
        console.log('URLs obtenidas:', urls);
        return urls;
    }

    async function renameFileBasedOnResolution(blob, filename, order_id, counter) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => {
                if (img.width === 400 && img.height === 400) {
                    resolve(renameFile(order_id, counter));
                } else {
                    resolve(filename);
                }
            };
            img.onerror = () => {
                resolve(filename);
            };
            img.src = URL.createObjectURL(blob);
        });
    }

    function renameFile(order_id, counter) {
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const randomLetter = letters.charAt(Math.floor(Math.random() * letters.length));
        return `${order_id}-vp${randomLetter}${counter + 1}.jpg`;
    }
</script>
</body>
</html>




























