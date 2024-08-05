

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


echo '<form action="" method="post">';
echo '<table border="1">';
echo '<tr>
        <th>Order ID</th>
        <th>Nombre del Producto</th>
      </tr>';

// Suponiendo que $data es tu array con los datos
foreach ($data as $row) {
    $orderId = isset($row[0]) ? $row[0] : '';
    $itemId = isset($row[1]) ? $row[1] : '';
    $sku = isset($row[10]) ? $row[10] : '';
    $productName = isset($row[11]) ? $row[11] : '';
    $quantityPurchased = isset($row[12]) ? $row[12] : '';
    $recipientName = isset($row[16]) ? $row[16] : '';
    $shipAddress1 = isset($row[17]) ? $row[17] : '';
    $shipAddress2 = isset($row[18]) ? $row[18] : '';
    $shipCity = isset($row[20]) ? $row[20] : '';
    $shipState = isset($row[21]) ? $row[21] : '';
    $purchaseDate = isset($row[2]) ? $row[2] : '';
    $url = isset($row[24]) ? $row[24] : '';
    $imageUrl = ''; // Si tienes la URL de la imagen, asigna aquí

    // Mostrar solo Order ID y Nombre del Producto en la tabla
    echo '<tr>';
    echo '<td>' . $orderId . '</td>';
    echo '<td>' . $productName . '</td>';
    echo '</tr>';

    // Campos ocultos para guardar en la base de datos
    echo '<input type="hidden" name="order_ids[]" value="' . $orderId . '">';
    echo '<input type="hidden" name="item_ids[]" value="' . $itemId . '">';
    echo '<input type="hidden" name="skus[]" value="' . $sku . '">';
    echo '<input type="hidden" name="product_names[]" value="' . $productName . '">';
    echo '<input type="hidden" name="quantities[]" value="' . $quantityPurchased . '">';
    echo '<input type="hidden" name="recipient_names[]" value="' . $recipientName . '">';
    echo '<input type="hidden" name="ship_addresses1[]" value="' . $shipAddress1 . '">';
    echo '<input type="hidden" name="ship_addresses2[]" value="' . $shipAddress2 . '">';
    echo '<input type="hidden" name="ship_cities[]" value="' . $shipCity . '">';
    echo '<input type="hidden" name="ship_states[]" value="' . $shipState . '">';
    echo '<input type="hidden" name="purchase_dates[]" value="' . $purchaseDate . '">';
    echo '<input type="hidden" name="urls[]" value="' . $url . '">';
    echo '<input type="hidden" name="image_urls[]" value="' . $imageUrl . '">';
}

echo '</table>';
echo '<input type="submit" name="saveUrls" value="Guardar Seleccionados">';
echo '</form>';

if (isset($_POST['saveUrls']) && !empty($_POST['order_ids'])) {
    
    
    $skus = $_POST['skus'];
    $productNames = $_POST['product_names'];
    $quantities = $_POST['quantities'];
    $recipientNames = $_POST['recipient_names'];
    $shipAddresses1 = $_POST['ship_addresses1'];
    $shipAddresses2 = $_POST['ship_addresses2'];
    $shipCities = $_POST['ship_cities'];
    $shipStates = $_POST['ship_states'];
    $purchaseDates = $_POST['purchase_dates'];
    $imageUrls = $_POST['image_urls'];

    // Vaciar la tabla temporal
    $conn->query("TRUNCATE TABLE temp_urls");

    // Insertar datos en la tabla temporal
    foreach ($orderIds as $index => $orderId) {
        
        
        $skuEsc = $conn->real_escape_string($skus[$index]);
        $productNameEsc = $conn->real_escape_string($productNames[$index]);
        $quantityEsc = $conn->real_escape_string($quantities[$index]);
        $recipientNameEsc = $conn->real_escape_string($recipientNames[$index]);
        $shipAddress1Esc = $conn->real_escape_string($shipAddresses1[$index]);
        $shipAddress2Esc = $conn->real_escape_string($shipAddresses2[$index]);
        $shipCityEsc = $conn->real_escape_string($shipCities[$index]);
        $shipStateEsc = $conn->real_escape_string($shipStates[$index]);
        $purchaseDateEsc = $conn->real_escape_string($purchaseDates[$index]);
        $imageUrlEsc = $conn->real_escape_string($imageUrls[$index]);

        $conn->query("INSERT INTO temp_urls 
            (order_id, order_item_id, sku, product_name, quantity, recipient_name, ship_address1, ship_address2, ship_city, ship_state, purchase_date, url, image_url)
            VALUES ('$orderIdEsc', '$itemIdEsc', '$skuEsc', '$productNameEsc', '$quantityEsc', '$recipientNameEsc', '$shipAddress1Esc', '$shipAddress2Esc', '$shipCityEsc', '$shipStateEsc', '$purchaseDateEsc', '$urlEsc', '$imageUrlEsc')");
    }

    echo '<h3>Datos guardados correctamente en la base de datos.</h3>';
    echo '<form action="descargarArchivos.php" method="post">';
    echo '<input type="submit" name="downloadUrls" value="Descargar Todos">';
    echo '</form>';
}



































































































