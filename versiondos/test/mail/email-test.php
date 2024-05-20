<?php
// Incluir el archivo de configuración de PrestaShop
//require_once('../config/config.inc.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';


//Obtener datos de texto de email, dias, y cantidad de correo a enviarse.
/* $sql = "SELECT *  FROM mat_encuestas_config";
$resultado = Db::getInstance()->executeS($sql);
$dias = $resultado[0]["dias"];
$email_horas = $resultado[0]["email_horas"];
$texto_email = $resultado[0]["texto_email"];

Db::getInstance(); */

//$fechaHace = date('Y-m-d', strtotime('-' . $dias . ' days'));
//$fechaHace = date('Y-m-d', strtotime('-180 days'));
/* $sql = "
SELECT c.id_customer, c.email, c.firstname, c.lastname
FROM "._DB_PREFIX_."customer c
INNER JOIN "._DB_PREFIX_."customer_group cg ON c.id_customer = cg.id_customer
INNER JOIN "._DB_PREFIX_."orders o ON c.id_customer = o.id_customer
INNER JOIN "._DB_PREFIX_."address a ON c.id_customer = a.id_customer
WHERE o.date_add >= '$fechaHace'
AND a.id_country = (SELECT id_country FROM "._DB_PREFIX_."country WHERE iso_code = 'ES')
AND (o.current_state = 5 OR o.current_state = 73)
GROUP BY c.id_customer
"; */

//Selecciona por grupo de clientes, para hacer pruebas.
/* $sql = "SELECT DISTINCT c.id_customer, c.email, c.firstname, c.lastname
FROM "._DB_PREFIX_."customer c
INNER JOIN "._DB_PREFIX_."customer_group cg ON c.id_customer = cg.id_customer
INNER JOIN "._DB_PREFIX_."orders o ON c.id_customer = o.id_customer
WHERE cg.id_group = '55'"; 
$result = Db::getInstance()->executeS($sql);
$mail = new PHPMailer(true); */
$mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'mail.sublimet.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'no-reply@sublimet.com';
    $mail->Password = 'Pantone109c.';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->SMTPDebug = 2;

    $mail->setFrom('no-reply@sublimet.com', 'Sublimet');
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = 'Gana un vale de 50€ de compra en Sublimet';


    $mail->addAddress('elmatumassa@gmail.com');
    
    $mail->Body    = 'Contenido del correo';
    
    if(!$mail->send()) {
    
    echo 'El mensaje no pudo ser enviado.';

    echo 'Error: ' . $mail->ErrorInfo;
    } else {
    
    echo 'El mensaje fue enviado correctamente.';
    
    } 