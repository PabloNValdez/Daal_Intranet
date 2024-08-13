

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

            const groupedData = data.reduce((acc, { url, order_id, order_item_id, product_type, sub_product_type }) => {
                if (!acc[product_type]) acc[product_type] = {};
                if (!acc[product_type][sub_product_type]) acc[product_type][sub_product_type] = [];
                acc[product_type][sub_product_type].push({ url, order_id, order_item_id });
                return acc;
            }, {});

            let downloadedFiles = 0;

            for (const [productType, subProductTypes] of Object.entries(groupedData)) {
                const productFolder = mainFolder.folder(productType);

                for (const [subProductType, items] of Object.entries(subProductTypes)) {
                    const subProductFolder = productFolder.folder(subProductType);

                    for (const { url, order_id, order_item_id } of items) {
                        try {
                            const proxyUrl = `?url=${encodeURIComponent(url)}`;
                            downloadedFiles++;

                            // Actualiza el progreso de la descarga
                            progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Descargando archivo ${downloadedFiles} de ${totalFiles}...`;

                            const response = await fetch(proxyUrl);
                            if (!response.ok) {
                                throw new Error(`Error al descargar archivo ${downloadedFiles}: ${response.statusText}`);
                            }
                            const blob = await response.blob();
                            const arrayBuffer = await blob.arrayBuffer();

                            const zip = new JSZip();
                            const zipContent = await zip.loadAsync(arrayBuffer);

                            const orderFolder = subProductFolder.folder(`${order_id}_${order_item_id}`);

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
                            console.error(error);
                            progressElement.innerHTML += `<br>Error al descargar archivo ${downloadedFiles}: ${error.message}`;
                        }
                    }
                }
            }

            progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Generando archivo ZIP...`;
            mainZip.generateAsync({ type: 'blob' }).then((content) => {
                saveAs(content, `${currentDate}~${numeroAleatorio}.zip`);
                progressElement.innerHTML = `Archivos encontrados: ${totalFiles}<br>Descarga completa. Archivo ZIP generado.`;
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
            return `${order_id}-vp${counter}.jpg`;
        }
    </script>
</body>
</html>



































































































