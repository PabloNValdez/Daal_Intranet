<?php
// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Obtener URLs desde la base de datos
function getUrlsFromDatabase($host, $user, $pass, $dbname) {
    $mysqli = new mysqli($host, $user, $pass, $dbname);

    if ($mysqli->connect_error) {
        die("Conexión fallida: " . $mysqli->connect_error);
    }

    $result = $mysqli->query("SELECT url, order_id, order_item_id FROM temp_urls");

    if (!$result) {
        die("Error en la consulta: " . $mysqli->error);
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'url' => $row['url'],
            'order_id' => $row['order_id'],
            'order_item_id' => $row['order_item_id']
        );
    }

    $mysqli->close();

    return $data;
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
    <title>Descargar y Descomprimir Archivos</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
</head>
<body>
    <button id="download-btn">Descargar y Descomprimir Archivos</button>

    <script>
        document.getElementById('download-btn').addEventListener('click', downloadAndUnzipFiles);

        async function downloadAndUnzipFiles() {
            const data = await getUrlsFromServer();
            const mainZip = new JSZip();

            for (const {url, order_id, order_item_id} of data) {
                const folderName = `${order_id}_${order_item_id}`;
                console.log(`Downloading ${url} via ?url=${encodeURIComponent(url)}`);

                try {
                    const proxyUrl = `?url=${encodeURIComponent(url)}`;
                    const response = await fetch(proxyUrl);
                    if (!response.ok) {
                        throw new Error(`Error al descargar ${url}: ${response.statusText}`);
                    }
                    const blob = await response.blob();
                    const arrayBuffer = await blob.arrayBuffer();

                    const zip = new JSZip();
                    const zipContent = await zip.loadAsync(arrayBuffer);

                    // Crear la estructura de carpetas requerida
                    const baseFolder = mainZip.folder(`${Date.now()}/Placas_Spotify/Placa_Spotify_BASE/${folderName}`);

                    for (const [name, file] of Object.entries(zipContent.files)) {
                        if (!file.dir) {
                            const fileBlob = await file.async("blob");
                            baseFolder.file(name, fileBlob);
                        }
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            mainZip.generateAsync({ type: 'blob' }).then((content) => {
                saveAs(content, 'Archivos_Procesados.zip');
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
    </script>
</body>
</html>


















