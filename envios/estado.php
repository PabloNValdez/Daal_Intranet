<?php
session_start();

// Controlo si el usuario ya está logueado en el sistema.
if (isset($_SESSION['email'])) {
} else {
    // Si no está logueado lo redirecciono a la página de login.
    header("HTTP/1.1 302 Moved Temporarily");
    header("Location: iniciar.php");
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Matias Massa para Getsingular.com">
    <title>Envios</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Enable popovers everywhere
            $('[data-bs-toggle="popover"]').popover({
                html: true
            });
        });
    </script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .zoom {
            /*padding: 50px;*/
            background-color: white;
            transition: transform .2s;
            /* Animation */
            width: 75px;
            height: 75px;
            margin: 2px;
            border: solid 1px;
            border-color: #0192bc;
        }

        .zoom:hover {
            transform: scale(3);
            /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
        }

        .nav-link {
            color: #fff !important;
            font-weight: 400 !important;
        }

        p.float-end.align-middle {
            margin-top: 10px !important;
        }
    </style>


</head>

<body>

    <header>

        <nav class="navbar navbar-expand-lg" style="background-color: #0192bc;">
            <div class="container">
                <a href="index.php" class="navbar-brand d-flex align-items-center">
                    <strong style="color:#fff">Getsingular</strong>
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-truck"></i> Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="estado.php"><i class="bi bi-paypal"></i> Estado</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex" role="search">
                    <p style="color:#fff; margin-top:5px">Bienvenido, <strong><a style="color:#fff" href="cerrar.php">cerrar sesión</a></strong></p>
                </div>
            </div>
            <nav>
    </header>

    <main>
        <div class="album bg-light"><br>
            <div class="container">
                <?php if (@$_GET['vacio'] == 1) { ?>
                    <div class="alert alert-danger" role="alert">
                        Importante: Debe seleccionar una orden para cambiar de estado.
                    </div>
                <?php }   ?>


                <form method="POST" action="cambio-estado.php">

                    <table id="tabla" class="table table-striped table-bordered" id="table" data-toggle="table" data-search="true" data-filter-control="true" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">N° Pedido</th>
                                <th data-field="date" data-filter-control="select" data-sortable="true" scope="col">Fecha compra</th>
                                <th scope="col">Nombre envío</th>
                                <th scope="col">Total</th>
                                <th scope="col">Método de Pago</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php include 'tabla-estado.php' ?>
                        </tbody>
                    </table>

            </div>
        </div>


    </main>

    <footer class="footer mt-auto py-3 bg-light fixed-bottom">
        <div class="container">

            <button type="submit" name="cancelados" id="cancelados" value="cancelados" class="btn btn-danger float-end m-1"><i class="bi bi-check-square"></i> Cancelados</button>
            <button type="submit" name="completos" id="completos"  value="completos" class="btn btn-success float-end m-1"><i class="bi bi-check-square"></i> Completos</button></form>
            <p class="float-end align-middle">Cambiar pedidos a: </p>
        </div>
    </footer>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>