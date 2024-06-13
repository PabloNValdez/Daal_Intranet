<?php
session_start(); // Iniciar la sesión

// Mensaje de error y éxito
$mensaje_error = isset($_SESSION['mensaje_error']) ? $_SESSION['mensaje_error'] : '';
$mensaje_exito = isset($_SESSION['mensaje_exito']) ? $_SESSION['mensaje_exito'] : '';

// Limpiar los mensajes de sesión después de mostrarlos
unset($_SESSION['mensaje_error']);
unset($_SESSION['mensaje_exito']);
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Revisión</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style type="text/css">
            body {
                background: #f5f5f5;
                margin-top: 20px;
            }

            /*------- portfolio -------*/
            .project {
                margin: 15px 0;
            }

            .no-gutter .project {
                margin: 0 !important;
                padding: 0 !important;
            }

            .has-spacer {
                margin-left: 30px;
                margin-right: 30px;
                margin-bottom: 30px;
            }

            .has-spacer-extra-space {
                margin-left: 30px;
                margin-right: 30px;
                margin-bottom: 30px;
            }

            .has-side-spacer {
                margin-left: 30px;
                margin-right: 30px;
            }

            .project-title {
                font-size: 1.25rem;
            }

            .project-skill {
                font-size: 0.9rem;
                font-weight: 400;
                letter-spacing: 0.06rem;
            }

            .project-info-box {
                margin: 15px 0;
                background-color: #fff;
                padding: 30px 40px;
                border-radius: 5px;
            }

            .project-info-box p {
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #d5dadb;
            }

            .project-info-box p:last-child {
                margin-bottom: 0;
                padding-bottom: 0;
                border-bottom: none;
            }

            /* img {
                width: 100%;
                max-width: 100%;
                height: auto;
                -webkit-backface-visibility: hidden;
            } */

            .rounded {
                border-radius: 5px !important;
            }

            .btn-xs.btn-icon {
                width: 34px;
                height: 34px;
                max-width: 34px !important;
                max-height: 34px !important;
                font-size: 10px;
                line-height: 34px;
            }

            .btn-xs.btn-icon span,
            .btn-xs.btn-icon i {
                line-height: 34px;
            }

            .btn-icon.btn-circle span,
            .btn-icon.btn-circle i {
                margin-top: -1px;
                margin-right: -1px;
            }

            .btn-icon i {
                margin-top: -1px;
            }

            .btn-icon span,
            .btn-icon i {
                display: block;
                line-height: 50px;
            }

            a.btn,
            a.btn-social {
                display: inline-block;
            }

            .mr-5 {
                margin-right: 5px !important;
            }

            .mb-0 {
                margin-bottom: 0 !important;
            }

            .btn-facebook,
            .btn-facebook:active,
            .btn-facebook:focus {
                color: #fff !important;
                background: #4e68a1;
                border: 2px solid #4e68a1;
            }

            .btn-circle {
                border-radius: 50% !important;
            }

            .project-info-box p {
                margin-bottom: 15px;
                padding-bottom: 15px;
                border-bottom: 1px solid #d5dadb;
            }

            p {
                font-family: "Barlow", sans-serif !important;
                font-weight: 300;
                font-size: 1rem;
                color: #686c6d;
                letter-spacing: 0.03rem;
                margin-bottom: 10px;
            }

            b,
            strong {
                font-weight: 700 !important;
            }

            .tituloweb {
                color: #0192bc;
            }

            .btn-success {
                background-color: #0192bc !important;
            }

            .btn-primary {
                background-color: #0192bc !important;
            }

            #log-textarea {
                width: 100%;
                height: 300px;
                padding: 10px;
                border: none;
                border-radius: 5px;
                color: #FFFFFF;
                background-color: #333333;
                font-size: 16px;
                font-family: 'Courier New', Courier, monospace;
                resize: none;
                overflow: auto;
                transition: all 0.3s ease-in-out;
                box-shadow: 0 4px 6px 0 hsla(0, 0%, 0%, 0.2);
                outline: none;
            }

            #log-textarea:focus {
                box-shadow: 0 6px 10px 0 hsla(0, 0%, 0%, 0.3);
            }
            /* --------------------------------------------------------------------------------------------- */
            body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            }

            table.order-table {
                width: 100%;
                border-collapse: collapse;
                margin: 25px 0;
                font-size: 18px;
                text-align: center; /* Center text */
                background-color: #fff;
            }

            .order-table thead tr {
                background-color: #009879;
                color: #ffffff;
                text-align: center; /* Center text in header */
                font-weight: bold;
            }

            .order-table th,
            .order-table td {
                padding: 12px 15px;
                border: 1px solid #dddddd;
                text-align: center; /* Center text in cells */
            }

            .order-table tbody tr {
                border-bottom: 1px solid #dddddd;
            }

            $order-table tbody tr:nth-of-type(even) {
                background-color: #f3f3f3;
            }

            .order-table tbody tr:last-of-type {
                border-bottom: 2px solid #009879;
            }

            .order-table tbody tr:hover {
                background-color: #f1f1f1;
            }

            .order-table img {
                max-width: 100px;
                height: auto;
            }

            .order-table .actions {
                display: flex;
                justify-content: center; /* Center buttons */
                gap: 10px;
            }

            .order-table .actions button {
                padding: 5px 10px;
                border: none;
                background-color: #009879;
                color: white;
                cursor: pointer;
                border-radius: 5px;
            }

            .order-table .actions button:hover {
                background-color: #007f63;
            }

            #select-all {
                margin-right: 5px;
            }

            .button-container {
                text-align: right;
                margin-top: 20px;
            }

            .button-container button {
                padding: 10px 20px;
                border: none;
                background-color: #009879;
                color: white;
                cursor: pointer;
                border-radius: 5px;
            }

            .button-container button:hover {
                background-color: #007f63;
            }

        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    </head>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Revisión de imágenes</title>
    </head>

    <body>
        <div class="container">
            <section class="text-center container">
                <div class="row py-lg-5">
                    <div class="col-lg-6 col-md-8 mx-auto">
                        <h1 class="tituloweb">Revisión de imágenes</h1>
                    </div>
                </div>
            </section>
        </div>

        <button onclick="location.href='index.php'">Volver al inicio</button><br><br>
        <button onclick="location.href='logout.php'">Cerrar Sesión</button><br>

    </body>

</html>