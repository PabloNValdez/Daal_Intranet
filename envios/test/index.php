<?php
$dirActual = __DIR__;

// Obtiene la ruta del directorio superior (proyecto/)
$dirProyecto = dirname($dirActual);

// Ruta absoluta al proyecto
$rutaAbsolutaProyecto = $dirProyecto . '/';

global $rutaAbsolutaProyecto;
require $rutaAbsolutaProyecto . 'db.php';


$pedido = 1000031305;
$sqlOrder = "SELECT
    o.entity_id AS order_id,
    o.increment_id AS Pedido,
    g.increment_id AS Factura,
    o.created_at AS Fecha,
    a.address_type AS address_type,
    a.street AS address_street,
    a.city AS address_city,
    a.region AS address_region,
    a.postcode AS address_postcode,
    a.telephone AS telefono,
    a.vat_id AS vat,
    p.additional_information AS Pago,
    o.shipping_description AS Envio,
    a_shipping.street AS shipping_street,
    a_billing.street AS billing_street
FROM
    sales_order o
INNER JOIN
    sales_order_address a ON o.entity_id = a.parent_id
LEFT JOIN 
    sales_invoice_grid g ON o.entity_id = g.order_id
INNER JOIN 
    sales_order_payment p ON o.entity_id = p.parent_id
LEFT JOIN
    sales_order_address a_shipping ON o.shipping_address_id = a_shipping.entity_id
LEFT JOIN
    sales_order_address a_billing ON o.billing_address_id = a_billing.entity_id
WHERE
    o.increment_id = '$pedido'";



$sql = $conn->query($sqlOrder);
$resultado = mysqli_fetch_array($sql);

echo "ID de Orden: " . $resultado['order_id'] . "<br>";
echo "Increment ID: " . $resultado['Pedido'] . "<br>";
echo "Factura: " . $resultado['Factura'] . "<br>";
echo "Fecha: " . $resultado['Fecha'] . "<br>";
echo "Dirección de Envío: " . $resultado['shipping_street'] . "<br>";
echo "Dirección de Facturación: " . $resultado['billing_street'] . "<br>";
echo "Ciudad: " . $resultado['address_city'] . "<br>";
echo "Región: " . $resultado['address_region'] . "<br>";
echo "Código Postal: " . $resultado['address_postcode'] . "<br>";
echo "Teléfono: " . $resultado['telefono'] . "<br>";
echo "VAT: " . $resultado['vat'] . "<br>";
echo "Método de Pago: " . $resultado['Pago'] . "<br>";
echo "Descripción de Envío: " . $resultado['Envio'] . "<br><br><br>";



$sqlProducts = "SELECT
    oi.name AS Producto,
    oi.qty_ordered AS Cantidad,
    oi.price AS Precio,
    oi.sku AS SKU
FROM
    sales_order_item oi
WHERE
    oi.order_id = '{$resultado['order_id']}'";

$sqlProductsResult = $conn->query($sqlProducts);

// Procesar productos
while ($producto = mysqli_fetch_array($sqlProductsResult)) {
    echo "Producto: " . $producto['Producto'] . "<br>";
    echo "Precio: " . $producto['SKU'] . "<br>";
    echo "Cantidad: " . $producto['Cantidad'] . "<br>";
    echo "Precio: " . $producto['Precio'] . "<br>";
    echo "---<br>";
}

