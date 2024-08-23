<?php
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';
use Fpdf\Fpdf;

// Obtener URLs desde la base de datos
function getUrlsFromDatabase($host, $user, $pass, $dbname) {
    $mysqli = new mysqli($host, $user, $pass, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT * FROM temp_urls");

    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $mysqli->close();

    return $data;
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

    return $pdf->Output('S');  // Return the PDF as a string
}

// Manejar la generación del PDF cuando se solicita
if (isset($_GET['action']) && $_GET['action'] == 'get_pdf' && isset($_GET['order_id'])) {
    $host = "localhost";
    $user = "Getsingular";
    $pass = "XdKFu67LyjtFQQvM";
    $dbname = "conversor";

    // Obtener los datos del pedido desde la base de datos según el order_id
    $mysqli = new mysqli($host, $user, $pass, $dbname);
    $stmt = $mysqli->prepare("SELECT * FROM temp_urls WHERE order_id = ?");
    $stmt->bind_param("s", $_GET['order_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    $mysqli->close();

    // Generar el PDF
    if ($data) {
        $pdfContent = generatePDF($data);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $_GET['order_id'] . '.pdf"');
        echo $pdfContent;
    } else {
        http_response_code(404);
        echo "Order not found.";
    }
    exit;
}


// Verifica si es una solicitud AJAX para obtener URLs
if (isset($_GET['action']) && $_GET['action'] == 'get_urls') {
    $host = "localhost";
    $user = "Getsingular";
    $pass = "XdKFu67LyjtFQQvM";
    $dbname = "conversor";

    $data = getUrlsFromDatabase($host, $user, $pass, $dbname);

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

// Verifica si es una solicitud al proxy
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Validar la URL
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        die('URL inválida.');
    }

    // Inicializar CURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);

    // Obtener el contenido
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);

    curl_close($ch); //Se cierra CURL

    if ($httpCode != 200) {
        http_response_code($httpCode);
        die("Error al descargar el archivo: Código HTTP $httpCode. $error");
    }

    // Separar y reenviar los encabezados HTTP
    foreach (explode("\r\n", $headers) as $header) {
        if (!empty($header)) {
            header($header);
        }
    }

    echo $body;
    exit;
}
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
            const currentDate = new Date().toISOString().split('T')[0]; // Formato yyyy-mm-dd
            const numeroAleatorio = Math.floor(1000 + Math.random() * 9000);
            const mainFolderName = `${currentDate}~${numeroAleatorio}`;
            const mainFolder = mainZip.folder(mainFolderName);

            // Crear un objeto para agrupar las URLs por product_type y sub_product_type
            const groupedData = data.reduce((acc, { url, order_id, order_item_id, product_type, sub_product_type }) => {
                if (!acc[product_type]) acc[product_type] = {};
                if (!acc[product_type][sub_product_type]) acc[product_type][sub_product_type] = [];
                acc[product_type][sub_product_type].push({ url, order_id, order_item_id });
                return acc;
            }, {});

            let downloadedFiles = 0;
            const downloadQueue = [];
            const maxConcurrentDownloads = 5; // Controlar la concurrencia

            for (const [productType, subProductTypes] of Object.entries(groupedData)) {
                const productFolder = mainFolder.folder(productType);

                for (const [subProductType, items] of Object.entries(subProductTypes)) {
                    const subProductFolder = productFolder.folder(subProductType);

                    for (const { url, order_id, order_item_id } of items) {
                        downloadQueue.push(async () => {
                            try {
                                // Solicita la generación del PDF
                                const pdfResponse = await fetch(`?action=get_pdf&order_id=${order_id}`);
                                const pdfBlob = await pdfResponse.blob();

                                // Añadir el PDF a la carpeta correspondiente
                                const orderFolder = subProductFolder.folder(`${order_id}_${order_item_id}`);
                                orderFolder.file(`${order_id}.pdf`, pdfBlob);

                                const proxyUrl = `?url=${encodeURIComponent(url)}`;
                                downloadedFiles++;
                                // Actualiza el progreso de la descarga
                                progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Descargando archivo ${downloadedFiles} de ${totalFiles}...`;

                                const blob = await downloadWithRetry(proxyUrl);
                                const arrayBuffer = await blob.arrayBuffer();

                                const zip = new JSZip();
                                const zipContent = await zip.loadAsync(arrayBuffer);

            

                                let imageCounter = 0;

                                for (const [name, file] of Object.entries(zipContent.files)) {
                                    if (!file.dir) {
                                        const fileBlob = await file.async("blob");
                                        const renamedFileName = await renameFileBasedOnResolution(fileBlob, name, order_id, imageCounter);
                                        orderFolder.file(renamedFileName, fileBlob);
                                        if (renamedFileName.includes('-vp')) imageCounter++;
                                    }
                                }
                            } catch (error) {
                                console.error(`Error al descargar archivo ${downloadedFiles}: ${error.message}`);
                                progressElement.innerHTML += `<br>Error al descargar archivo ${downloadedFiles}: ${error.message}`;
                            }
                        });

                        if (downloadQueue.length >= maxConcurrentDownloads) {
                            await Promise.all(downloadQueue.map(fn => fn()));
                            downloadQueue.length = 0; // Vaciar la cola
                        }
                    }
                }
            }

            if (downloadQueue.length > 0) {
                await Promise.all(downloadQueue.map(fn => fn())); // Descargar cualquier archivo restante
            }

            progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Generando archivo ZIP...`;

            mainZip.generateAsync({ type: 'blob' }).then((content) => {
                saveAs(content, `${currentDate}~${numeroAleatorio}.zip`);
            });
        }

        async function downloadWithRetry(proxyUrl, maxRetries = 3) {
            let retries = 0;
            while (retries < maxRetries) {
                try {
                    const response = await fetch(proxyUrl);
                    if (!response.ok) throw new Error(`Error: ${response.statusText}`);
                    return await response.blob();
                } catch (error) {
                    retries++;
                    if (retries === maxRetries) throw error;
                }
            }
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
                    resolve(filename); // Mantener el nombre original si hay un error
                };
                img.src = URL.createObjectURL(blob);
            });
        }

        function renameFile(order_id, counter) {
            return `${order_id}-vp${counter}.jpg`;
        }

    </script>
</body>
</html>

























