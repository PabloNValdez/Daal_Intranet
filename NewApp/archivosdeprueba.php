

'4055-botcumple-500Mentalida'
'4055-botcumple-750Cantinú'
'4055-botcumple-350Maravill'
'4055-botcumple-350Losabe'
'4055-botcumple-500Losabe'
'4055-botcumple-750Maravill'
'4055-botcumple-500Carr'
'4055-botcumple-350Granaño'
'4055-botcumple-750Losabes'
'4055-botcumple-500Montón'
'4055-botcumple-750Carro'
'4055-botcumple-500Cantinúa'
'4055-botcumple-500Maravilla'
'4055-botcumple-350Cantinúa'
'4055-botcumple-750Montón'
'4055-botcumple-500Granaño'
'4055-botcumple-750Mentalidad'
'4055-botcumple-350Mentalidad'
'4055-botcumple-350Carro'
'4055-botcumple'
'4055-botcumple-750Granaño'
'4055-botcumple-350Cumple'
'4055-botcumple-350Masuno'
'4055-botcumple-350Montón'
'4055-botcumple-750Cumplea'
'4055-botcumple-500Masuno'
'4055-botcumple-750Masuno'
'4055-botcumple-500Cumplea'
'4055-botcumple-500Laurel'
'4055-botcumple-750Laurel'
'4055-botcumple-350Laurel'
'4055-botcumple-500Plumas'
'4055-botcumple-750Plumas'
'4055-botcumple-350Plumas'
'4055-botcumple-500Floral'
'4055-botcumple-750Floral'
'4055-botcumple-350Floral'
'4055-botcumple-750Script'
'4055-botcumple-500Script'
'4055-botcumple-350Script'
'4055-botcumple-750Cactus'
'4055-botcumple-500Cactus'
'4055-botcumple-350Cactus'

//Estas son tazas y cojines en combo. Hay que ver qué hacer.
'1739-madre-mejormama'
'1739-madre-felicidades'
'1739-madre-mandona'
'1739-madre-casamama'
'1739-madre-escrito'
'1739-madre-mejorabuela'
'1739-mama-flores'
'1739-madre-chupete'
'1739-madre-encasa'
'1739-madre-100%'
'936-1739-abuelo-mejorabuelos'
'936-1739-abuelo'
'936-1739-abuela-scrapbook'
'936-1739-abuela-aro'
'936-1739-abuelo-marco'
'936-1739-abuelo-scrapbook'
'936-1739-abuelo-aro'
'936-1739-abuela-escudo'
'936-1739-abuelos-escudo'
'936-1739-abuelo-mejorabuelo'
'936-1739-abuelo-mejorabuela'
'936-1739-abuelo-escudo'
'936-1739-padre'
'936-1739-padre-todomas'
'936-1739-padre-chupetepapa'
'936-1739-padre-escrito'
'936-1739-padre-100%'
'936-1739-padre-escudo'
'936-1739-padre-mejorpapa', 
'936-1739-padre-gracias', 
'936-1739-padre-rayas', 
'936-1739-padre-felicidades', 
'936-1739-padre-mejorabuelo', 
'936-1739-padre-encasa', 
'936-1739-padre-mogollon'
'936-1739-mama-mejor'
'936-1739-diseño-coñazo'
'936-1739-mama-caña'
'936-1739-mama-increible'
'936-1739-siempre-juntas'
'936-1739-foto-coñazo'


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

    const groupedData = data.reduce((acc, { url, order_id, order_item_id, product_type, sub_product_type }) => {
        if (!acc[product_type]) acc[product_type] = {};
        if (!acc[product_type][sub_product_type]) acc[product_type][sub_product_type] = [];
        acc[product_type][sub_product_type].push({ url, order_id, order_item_id });
        return acc;
    }, {});

    let downloadedFiles = 0;
    const downloadQueue = [];
    const maxConcurrentDownloads = 5;

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

                        // Continúa con la descarga del archivo ZIP asociado
                        const proxyUrl = `?url=${encodeURIComponent(url)}`;
                        downloadedFiles++;
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

    await Promise.all(downloadQueue.map(fn => fn()));

    const mainZipBlob = await mainZip.generateAsync({ type: 'blob' });
    saveAs(mainZipBlob, `${mainFolderName}.zip`);
}






























































































