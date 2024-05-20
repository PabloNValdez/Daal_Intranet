<?php
###DEFINO RUTA ABSOLUTA DEL PROYECTO.
// Obtiene la ruta del directorio actual (sistema/)
$dirActual = __DIR__;

// Obtiene la ruta del directorio superior (proyecto/)
$dirProyecto = dirname($dirActual);

// Ruta absoluta al proyecto
$rutaAbsolutaProyecto = $dirProyecto . '/';

global $rutaAbsolutaProyecto;
error_reporting(E_ALL);
ini_set('display_errors', 0);
function comprimirCarpeta($rutaCarpeta, $nombreArchivoZip, $directorioDestino)
{
    $zip = new ZipArchive();
    $rutaCompletaZip = $directorioDestino . '/' . $nombreArchivoZip;

    if ($zip->open($rutaCompletaZip, ZipArchive::CREATE) !== TRUE) {
        die("No se pudo abrir o crear el archivo ZIP");
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rutaCarpeta),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $file) {
        if (!$file->isDir()) {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rutaCarpeta) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
}

function descargarCodigoBarras($valorCodigo)
{
    global $rutaAbsolutaProyecto;
    // Construir la URL con el valor proporcionado
    $url = "https://barcode.tec-it.com/barcode.ashx?data=" . $valorCodigo . "&translate-esc=on";

    try {
        // Iniciar una sesión cURL
        $ch = curl_init($url);

        // Configurar las opciones de cURL para devolver el resultado como un string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la consulta cURL y obtener el contenido de la imagen
        $imagen = curl_exec($ch);

        // Verificar si la solicitud fue exitosa (código de estado 200)
        $codigoEstado = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($codigoEstado == 200) {
            // Guardar la imagen con un nombre específico
            file_put_contents($rutaAbsolutaProyecto . "Codigos/" . $valorCodigo . ".png", $imagen);
            //echo "Imagen descargada correctamente como " . $valorCodigo . ".png";
        } else {
            //echo "Error al descargar la imagen. Código de estado: " . $codigoEstado;
        }

        // Cerrar la sesión cURL
        curl_close($ch);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


function descargarVP($codigo, $nombre)
{
    global $rutaAbsolutaProyecto;
    // Construir la URL con el valor proporcionado
    $url = "https://www.getsingular.com/media/productdesigner/designs/" . $codigo . "/base/" . $nombre . "";

    try {
        // Iniciar una sesión cURL
        $ch = curl_init($url);

        // Configurar las opciones de cURL para devolver el resultado como un string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la consulta cURL y obtener el contenido de la imagen
        $imagen = curl_exec($ch);

        // Verificar si la solicitud fue exitosa (código de estado 200)
        $codigoEstado = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($codigoEstado == 200) {
            // Guardar la imagen con un nombre específico
            file_put_contents($rutaAbsolutaProyecto . "Codigos/$nombre", $imagen);
        } else {
            echo "Error al descargar la imagen. Código de estado: " . $codigoEstado;
        }

        // Cerrar la sesión cURL
        curl_close($ch);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
// Ejemplo de uso



#####FUNCION PARA DESCARGAR EL FICHERO
function descargaArchivo($nombreArchivo, $ubicacion)
{   global $rutaAbsolutaProyecto;
    $rutaCompleta = "/".$ubicacion.$nombreArchivo;

    if (file_exists($rutaCompleta)) {
        // Definir headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$nombreArchivo");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // Leer el archivo
        readfile($rutaCompleta);
        exit;
    } else {
        echo 'Imposible descargar el archivo, error.';
    }
}

#####FIN FUNCION PARA DESCARGAR EL FICHERO


######FUNCION GENERAR TXT DE ENVIO########
function generarFicheroTXT($ordenes)
{
    require 'db.php';
    global $rutaAbsolutaProyecto;
    if ($conn->connect_errno) {
        echo "Tenemos un problemita";
    }
    //Array desde GET formulario
    $array = $ordenes;
    $array_num = count($array);

    // Creo contador
    $contador = 0;
    //Creo archivo temporal
    $file = "fichero_temporal.txt";

    //Creo encabezado del fichero text
    $jump = "\r\n";
    $separator = "\t";
    $fp = fopen($file, 'a');
    $registro =
        'order-id' . $separator .
        'order-item-id' . $separator .
        'purchase-date' . $separator .
        'payments-date' . $separator .
        'reporting-date' . $separator .
        'promise-date' . $separator .
        'days-past-promise' . $separator .

        'buyer-email' . $separator .
        'buyer-name' . $separator .
        'buyer-phone-number' . $separator .

        'sku' . $separator .
        'product-name' . $separator .
        'quantity-purchased' . $separator .
        'quantity-shipped' . $separator .
        'quantity-to-ship' . $separator .

        'ship-service-level' . $separator .
        'recipient-name' . $separator .

        'ship-address-1' . $separator .
        'ship-address-2' . $separator .
        'ship-address-3' . $separator .


        'ship-city' . $separator .
        'ship-state' . $separator .
        'ship-postal-code' . $separator .
        'ship-country' . $separator .

        'sales-channel' . $separator .
        'customized-url' . $separator .
        'customized-page' . $separator .
        'is-business-order' . $separator .
        'purchase-order-number' . $separator .
        'price-designation' . $separator .
        'is-prime' . $separator .
        'is-iba' . $jump;
    fwrite($fp, $registro);
    //While con consulta 
    while ($contador < $array_num) {
        $valor = $array[$contador];
        $sql = $conn->query("SELECT entity_id,increment_id, created_at, shipping_address_id,customer_email,shipping_description FROM sales_order WHERE increment_id = '$valor';");

        while ($row = mysqli_fetch_array($sql)) {
            $shippin_id = $row['shipping_address_id'];
            $sql2 = $conn->query("SELECT * FROM `sales_order_address` WHERE entity_id = '$shippin_id';");
            $sales_order_address = mysqli_fetch_array($sql2);
            $sql3 = $conn->query("SELECT * FROM `sales_shipment_grid` WHERE order_increment_id = '$valor';");
            $sales_shipment_grid = mysqli_fetch_array($sql3);

            if (@$sales_shipment_grid['shipping_name'] == "") {
                $nombreCliente = $sales_order_address['firstname'] . " " . $sales_order_address['lastname'];
            } else {
                $nombreCliente =  $sales_shipment_grid['shipping_name'];
            }

            if (@$sales_shipment_grid['shipping_address'] == "") {
                $direccion = preg_replace("[\n|\r|\n\r]", "", $sales_order_address['street']);
            } else {
                $direccion = preg_replace("[\n|\r|\n\r]", "", $sales_shipment_grid['shipping_address']);
            }

            $registro2 =
                $row['increment_id'] . $separator .
                $row['increment_id'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .
                $row['created_at'] . $separator .

                $row['customer_email'] . $separator .
                @$sales_shipment_grid['shipping_name'] . $separator .
                $sales_order_address['telephone'] . $separator .

                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .

                $row['shipping_description'] . $separator .
                $nombreCliente . $separator .


                $direccion . $separator .
                "-" . $separator .
                "-" . $separator .

                $sales_order_address['city'] . $separator .
                $sales_order_address['region'] . $separator .
                $sales_order_address['postcode'] . $separator .
                $sales_order_address['country_id'] . $separator .


                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                "-" . $separator .
                $jump;
            fwrite($fp, $registro2);
        }
        $contador++;
    }
    $nombre = date('j-m-y_h-i-s');
    $origen = $rutaAbsolutaProyecto . "fichero_temporal.txt";
    $destino = $rutaAbsolutaProyecto . "ficheros/" . $nombre . ".txt"; #Copiar pero cambiar nombre
    $resultado = copy($origen, $destino);
    $eliminar = unlink($origen);

    $url_corta = mb_substr($destino, strlen(__DIR__), null, "UTF-8");
    return array(
        'array_num' => $array_num,
        'url_corta' => $url_corta,
        'destino' => $destino
    );
}
######FIN FUNCION GENERAR TXT DE ENVIO########


######FUNCION CREAR FACTURAS ###########

function limpiarMetodoPago($jsonPago)
{
    // Decodificar el JSON
    $arrayPago = json_decode($jsonPago, true);

    // Obtener el valor de "method_title"
    $methodTitle = isset($arrayPago['method_title']) ? $arrayPago['method_title'] : '';

    // Limpiar y devolver el resultado
    return ucwords(strtolower($methodTitle)); // Convierte a minúsculas y capitaliza
}
function formatearPrecio($precio)
{
    // Formatear el precio con dos decimales, coma como separador de miles y punto como separador decimal
    return number_format($precio, 2, ',', '.');
}
function mostrarInformacionProducto($json)
{
    $html = '';  // Inicializar la variable HTML
    // Decodificar el JSON
    $datosProducto = json_decode($json, true);

    // Comprobar si el formato del JSON es el esperado
    if ($datosProducto && isset($datosProducto['options'])) {
        $opciones = $datosProducto['options'];

        // Mostrar las opciones del producto
        foreach ($opciones as $opcion) {
            $label = isset($opcion['label']) ? $opcion['label'] : '';
            $value = isset($opcion['value']) ? $opcion['value'] : '';

            // Concatenar al HTML
            $html .=  "<em>" . $label . "</em><br>" . PHP_EOL;
            $html .= "&nbsp;&nbsp;&nbsp;&nbsp;" . str_repeat(' ', 5) . $value . "<br>" . PHP_EOL;
        }
    } else {
        //$html .=  "Formato de JSON no válido.";
    }
    return $html;  // Devolver el HTML generado
}
// Uso de la función
function limpiarCantidad($cantidad)
{
    // Formatear la cantidad y obtener solo la parte entera
    $cantidadLimpia = number_format($cantidad, 0, '', '');

    return $cantidadLimpia;
}

require $rutaAbsolutaProyecto . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function crearFactura($pedido, $nombreCarpeta)
{
    global $rutaAbsolutaProyecto;
    try {
        require 'db.php';
        $sqlOrder = "SELECT
    o.entity_id AS order_id,
    o.increment_id AS Pedido,
    o.base_subtotal_invoiced AS subtotal_final,
    o.base_tax_invoiced AS impuestos,
    o.total_invoiced AS total_general,
    a.firstname AS Nombre,
    a.lastname AS Apellido,
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
    a_shipping.street AS direccion_envio,
    a_billing.street AS direccion_comprador,
    o.base_shipping_invoiced AS Costo_Envio
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

        $factura = $resultado['Factura'];
        $fecha = $resultado['Fecha'];
        $vendido_a = $resultado['direccion_comprador'];
        $enviado_a = $resultado['direccion_envio'];
        $telefono = $resultado['telefono'];
        $vat = $resultado['vat'];
        $nombre = $resultado['Nombre'];
        $apellido = $resultado['Apellido'];
        $ciudad = $resultado['address_city'];
        $region = $resultado['address_region'];
        $cp = $resultado['address_postcode'];
        $metodoDePagoLimpio = limpiarMetodoPago($resultado['Pago']);
        $envio = $resultado['Envio'];
        $costo_Envio = formatearPrecio($resultado['Costo_Envio']);
        $subtotal_final = formatearPrecio($resultado['subtotal_final']);
        $impuestos = formatearPrecio($resultado['impuestos']);
        $total_general  = formatearPrecio($resultado['total_general']);
        $sqlProducts = "SELECT
    oi.name AS Producto,
    oi.qty_ordered AS Cantidad,
    oi.price AS Precio,
    oi.sku AS SKU,
    oi.product_options AS info,
    oi.base_tax_amount AS IVA,
    oi.price AS precio_producto,
    oi.row_total_incl_tax AS subtotal
    FROM
    sales_order_item oi
    WHERE
    oi.order_id = '{$resultado['order_id']}'";

        $sqlProductsResult = $conn->query($sqlProducts);

        // Crear una instancia de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('chroot', '/home/chat.getsingular/public_html/envios/');


        $dompdf = new Dompdf($options);
        $ruta_fuentes = '/home/chat.getsingular/public_html/envios/fuente/';
        $fuente_quicksand_regular = $ruta_fuentes . 'Quicksand/Quicksand-Regular.ttf';




        // Contenido HTML de tu plantilla
        $html = '<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura 1</title>
        <style>
            @font-face {
                font-family: "Quicksand";
                src: url("' . $fuente_quicksand_regular . '") format("truetype");
                font-weight: normal;
                font-style: normal;
            }

            body {
                font-family: "Quicksand", sans-serif;
            }
        </style>
    </head>

    <body>
        <table style="width: 100%;">
            <tr>
                <!-- Columna Izquierda -->
                <td style="width: 70%; vertical-align: top;">

                    <!-- Encabezado -->
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 33.3333%;"><img style="height: 50px;" src="' . $rutaAbsolutaProyecto . '/images/logo.png"></td>
                            <td style="width: 33.3333%;text-align: center;"><img style="height: 70px;" src="' . $rutaAbsolutaProyecto . 'Codigos/' . $pedido . '.png"></td>
                        </tr>
                    </table>

                    <!-- Datos de Factura -->
                    <table style="width: 100%; border: 0.5px solid #737373; background-color: #737373; ">
                        <tr>
                            <td style="width: 100%;
                            color: white;
                            font-size: 12px;
                            border: 0.5px solid #737373;
                            ">Factura # ' . $factura . ' <br>Pedido nº ' . $pedido . '<br> Fecha de pedido: ' . $fecha . '</td>
                        </tr>
                    </table>

                    <!-- Detalles de Cliente y Envío -->
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #737373; vertical-align: middle;">
                        <tr>
                            <td style="width: 50%; border: 0.5px solid #737373; background-color: rgb(237, 235, 235); height: 30px; font-weight: 600;">
                                Vendido a:</td>
                            <td style="width: 50%; border: 0.5px solid #737373; background-color: rgb(237, 235, 235);  margin: 0px auto; font-weight: 600;">Enviar
                                a:</td>
                        </tr>
                        <tr>
                            <td style="width: 100%; font-size: 10px; border: 0.5px solid #737373;" colspan="2">
                                <table style="width: 100%;">
                                    <td style="width: 50%;">' . $nombre . ' ' . $apellido . '<br>' . $vendido_a . '<br>' . $ciudad . ',<br>' . $region . ', ' . $cp . '<br>España<br>T: ' . $telefono . '<br>VAT: ' . $vat . '
                                    </td>
                                    <td style="width: 50%;">' . $nombre . ' ' . $apellido . '<br>' . $enviado_a . '<br>' . $ciudad . ',<br>' . $region . ', ' . $cp . '<br>España<br>T: ' . $telefono . '<br>VAT: ' . $vat . '</td>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <!-- Detalles de Cliente y Envío 
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #737373; vertical-align: middle;">
                        <tr>
                            <td style="width: 50%; border: 0.5px solid #737373; background-color: rgb(237, 235, 235); height: 30px; font-weight: 600;">Forma de pago</td>
                            <td style="width: 50%; border: 0.5px solid #737373; background-color: rgb(237, 235, 235);  margin: 0px auto; font-weight: 600;">Método de envío</td>
                        </tr> 
                        <tr>
                            <td style="width: 100%; font-size: 10px; border: 0.5px solid #737373;" colspan="2">
                                <table style="width: 100%;">
                                    <td style="width: 50%;">' . $metodoDePagoLimpio . '
                                    </td>
                                    <td style="width: 50%;">' . $envio . ' <br><br> (Gastos de envío ' . $costo_Envio . ' €)<br><br></td>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br
                    Detalles de producto y valores -->
                    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50% !important;border: 0.5px solid #737373; background-color: rgb(237, 235, 235); font-weight: 600;  font-size: 12px; height: 12px;">Productos<br></td>
                <td style="width: 30% !important;border: 0.5px solid #737373; background-color: rgb(237, 235, 235); font-weight: 600;  font-size: 12px; height: 12px;">SKU<br></td>
                <td style="width: 20% !important;border: 0.5px solid #737373; background-color: rgb(237, 235, 235); font-weight: 600;  font-size: 12px; height: 12px;">Cantidad&nbsp;<br></td>
            </tr>';
        while ($producto = mysqli_fetch_array($sqlProductsResult)) {
            $info = $producto['info'];
            //echo $info ."<br><br><br><br><br>";
            //echo mostrarInformacionProducto($info)."<br><br><br><br><br>";
            $precio = formatearPrecio($producto['Precio']);
            $iva = formatearPrecio($producto['IVA']);
            $precio_producto = formatearPrecio($producto['precio_producto']);
            $cantidadLimpia = limpiarCantidad($producto['Cantidad']);

            $subtotal = formatearPrecio($producto['subtotal']);
            $html .= '<tr>
                <td style="width: 50%x !important; font-size: 12px;"><strong>' . $producto['Producto'] . '</strong><br> </td>
                    <td style="width: 30% !important;font-size: 10px;">' . $producto['SKU'] . '<br></td>
                    <td style="font-size: 10px;text-align: center;"><strong>' . $cantidadLimpia . '</strong><br></td>
                </tr>';
            $html .= '<tr>
                <td style="width: 100%;font-size: 10px;">' . mostrarInformacionProducto($info) . ' <em>Producto personalizado:</em><br>&nbsp;&nbsp;&nbsp;&nbsp;Si<br> </td>
                    
                </tr>';
        }
        $html .= '
        </tbody>
    </table>

    <br>
    <!-- <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 33.3333%;"></td>
                <td style="width: 50.5781%; text-align: right;font-size: 12px;"><strong>Subtotal:</strong>&nbsp;</td>
                <td style="width: 16.0656%; text-align: right;font-size: 12px;"><strong>' . $subtotal_final . ' &euro;</strong></td>
            </tr>
            <tr>
                <td style="width: 33.3333%;"></td>
                <td style="width: 50.5781%; text-align: right;font-size: 12px;"><strong>Cargos por manejos y env&iacute;o:</strong></td>
                <td style="width: 16.0656%; text-align: right;font-size: 12px;"><strong>' . $costo_Envio . ' &euro;</strong></td>
            </tr>
            <tr>
                <td style="width: 33.3333%;"></td>
                <td style="width: 50.5781%; text-align: right;font-size: 12px;"><strong>Total general (sin impuestos):</strong></td>
                <td style="width: 16.0656%; text-align: right;font-size: 12px;"><strong>' . $subtotal_final . ' &euro;</strong></td>
            </tr>
            <tr>
                <td style="width: 33.3333%;"></td>
                <td style="width: 50.5781%; text-align: right;font-size: 12px;"><strong>Impuestos:</strong></td>
                <td style="width: 16.0656%; text-align: right;font-size: 12px;"><strong>' . $impuestos . ' &euro;</strong></td>
            </tr>
            <tr>
                <td style="width: 33.3333%;"></td>
                <td style="width: 50.5781%; text-align: right;font-size: 12px;"><strong>Total general (con impuestos):&nbsp;</strong></td>
                <td style="width: 16.0656%; text-align: right;font-size: 12px;"><strong>' . $total_general . ' &euro;</strong></td>
            </tr>
        </tbody>
    </table>  -->

                </td>

                <!-- Columna Derecha (5cm) -->
                <td style="width: 5cm; text-align: center;">';
        $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$pedido'");

        while ($fetch2 = mysqli_fetch_array($detalles)) {

            $designe = $fetch2['design_id'];
            if ($designe == "") {
                echo "Sin imagen";
            } else {

                $detalles2 = mysqli_query($conn, "SELECT * FROM `productdesigner_design_images` WHERE `design_id` = '$designe' AND design_image_type = 'base'") or die(mysqli_error());
                $fetch3 = mysqli_fetch_array($detalles2);
                $imagen = $fetch3['image_path'];
                descargarVP($designe, $imagen);
                $html .= '<img src="' . $rutaAbsolutaProyecto . 'Codigos/' . $imagen . '" width="150">';
            }
        }
        $html .= '
                </td>
            </tr>
        </table>
    </body>

    </html>';

        // Cargar el contenido HTML en dompdf
        $dompdf->loadHtml($html);

        // Establecer el tamaño del papel (Opcional)
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF (primera pasada para obtener el número de páginas)
        $dompdf->render();

        // Obtener el número de páginas
        $numero_de_paginas = $dompdf->getCanvas()->get_page_count();

        // Renderizar el PDF (segunda pasada para agregar el número de páginas)
        $dompdf->render();

        // Guardar el PDF en un archivo en el servidor
        $rutaCarpeta = 'Facturas/' . $nombreCarpeta;
        // Asegúrate de que el directorio de Facturas exista
        $directorioFacturas = $rutaAbsolutaProyecto . 'Facturas/';
        if (!file_exists($directorioFacturas)) {
            mkdir($directorioFacturas, 0755, true);
        }

        // Asegúrate de que la subcarpeta con el nombre de carpeta exista
        $directorioNombreCarpeta = $directorioFacturas . $nombreCarpeta . '/';
        if (!file_exists($directorioNombreCarpeta)) {
            mkdir($directorioNombreCarpeta, 0755, true);
        }
        $nombre_archivo = $directorioNombreCarpeta . '_Factura_' . $pedido . '.pdf';
        $archivo_pdf = $dompdf->output();
        file_put_contents($nombre_archivo, $archivo_pdf);

        // Mensaje indicando que el archivo ha sido guardado
        return $nombreCarpeta;
    } catch (Exception $e) {
        // Manejar la excepción
        throw new Exception("Error al generar la factura: " . $e->getMessage());
    }
}
