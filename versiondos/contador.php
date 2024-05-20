<!DOCTYPE html>
<html lang="en">
<?php
include("funciones/funciones.php");
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos generados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap-extended.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/fonts/simple-line-icons/style.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/colors.min.css">
  <link rel="stylesheet" type="text/css" href="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
  <style>
    .h3,
    h3 {
      font-size: 1.1rem;
      font-weight: 600;
    }

    .card.total {
      background: #1b2942;
      color: #fff;
    }

    .card.total h2 {

      font-size: 2.9rem !important;
    }

    .nav-link,
    .navbar {
      padding: 0.4rem 0.9rem;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
      color: #ffffff;
      background-color: #1b2942;
      border-color: #1b2942 #1b2942 transparent;
      font-weight: 700;
    }

    .nav-tabs .nav-link {
      border: 1px solid transparent;
      border-top-left-radius: 0.25rem;
      border-top-right-radius: 0.25rem;
      color: #9da2a9;
      font-weight: 600;
    }
    .alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    color: #fff;
    text-transform: uppercase;
    font-size: 12px
}

.alert_info {
    background-color: #4285f4;
    border: 2px solid #4285f4
}

button.close {
    -webkit-appearance: none;
    padding: 0;
    cursor: pointer;
    background: 0 0;
    border: 0
}

.close {
    font-size: 20px;
    color: #fff;
    opacity: 0.9;
    font-weight: normal
}

.alert_success {
    background-color: #09c97f;
    border: 2px solid #09c97f
}

.alert_warning {
    background-color: #f8b15d;
    border: 2px solid #f8b15d
}

.alert_error {
    background-color: #f95668;
    border: 2px solid #f95668
}

.fade_info {
    background-color: #d9e6fb;
    border: 1px solid #4285f4
}

.fade_info .close {
    color: #4285f4
}

.fade_info strong {
    color: #4285f4
}

.fade_success {
    background-color: #c9ffe5;
    border: 1px solid #09c97f
}

.fade_success .close {
    color: #09c97f
}

.fade_success strong {
    color: #09c97f
}

.fade_warning {
    background-color: #fff0cc;
    border: 1px solid #f8b15d
}

.fade_warning .close {
    color: #f8b15d
}

.fade_warning strong {
    color: #f8b15d
}

.fade_error {
    background-color: #ffdbdb;
    border: 1px solid #f95668
}

.fade_error .close {
    color: #f95668
}

.fade_error strong {
    color: #f95668
}
  </style>
</head>

<body>

  <div class="container">
    <?php
    // Obtén los valores de los parámetros 'month' y 'year' de la URL
    $selectedDia = isset($_GET['dia']) ? $_GET['dia'] : 01; // Valor por defecto: mes actual
    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('M'); // Valor por defecto: mes actual
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y'); // Valor por defecto: año actual

    // Definir un array de meses con el formato Mes Año
    $months = array(
      '12-Dec-2023' => 'Dic 2023',
      '01-Jan-2024' => 'Ene 2024',
      '02-Feb-2024' => 'Feb 2024',
      '03-Mar-2024' => 'Mar 2024',
      '04-Apr-2024' => 'Abr 2024',
      '05-May-2024' => 'May 2024',
      '06-Jun-2024' => 'Jun 2024',
      '07-Jul-2024' => 'Jul 2024',
      '08-Aug-2024' => 'Ago 2024',
      '09-Sep-2024' => 'Sep 2024',
      '10-Oct-2024' => 'Oct 2024',
      '11-Nov-2024' => 'Nov 2024',
      '12-Dec-2024' => 'Dic 2024',
    );

    // Obtén el rango de años (desde 2023 hasta 2024)
    $years = range(2023, 2024);

    // Validar que el año seleccionado esté en la lista, de lo contrario, usar 2023 por defecto
    $selectedYear = in_array($selectedYear, $years) ? $selectedYear : 2023;

    function contarProductos($conexion, $producto = null, $variante = null, $mes = null, $anio = null)
    {
      $consulta = "SELECT producto, variante, COUNT(*) AS cantidad FROM contador";

      $whereClause = "";

      if ($producto !== null) {
        $whereClause .= " WHERE producto = '$producto'";
        if ($variante !== null) {
          $whereClause .= " AND variante = '$variante'";
        }
      }

      if ($mes !== null) {
        $whereClause .= empty($whereClause) ? " WHERE" : " AND";
        $whereClause .= " MONTH(fecha) = '$mes'";
      }

      if ($anio !== null) {
        $whereClause .= empty($whereClause) ? " WHERE" : " AND";
        $whereClause .= " YEAR(fecha) = '$anio'";
      }

      $consulta .= $whereClause . " GROUP BY producto, variante";

      $resultado = $conexion->query($consulta);

      if ($resultado === false) {
        return "0";
      }

      while ($fila = $resultado->fetch_assoc()) {
        return $fila['cantidad'];
      }

      $resultado->close();
    }



    // Ejemplo de uso
    $mysqli = new mysqli('localhost', 'Getsingular', 'XdKFu67LyjtFQQvM', 'versiondos');

    // Verifica la conexión
    if ($mysqli->connect_error) {
      die('Error de Conexión (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    // Ejemplo 1: Contar todos los productos y variantes
    //contarProductos($mysqli);

    // Ejemplo 2: Contar solo el producto "ProductoEjemplo"
    //contarProductos($mysqli, 'Placas_Spotify');

    // Ejemplo 3: Contar el producto "ProductoEjemplo" y la variante "VarianteEjemplo"
    //contarProductos($mysqli, 'Placas_Spotify', 'Placa_Spotify_1llavero');

    // Cierra la conexión al final, cuando ya no la necesitas

    ?>
  </div>


  <div class="grey-bg container">
    <section id="minimal-statistics">
      <div class="row">
        <div class="col-12 mt-5 mb-5 text-center">
          <h2>Contador de productos generados</h2>
        </div>
      </div>
      <nav>
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <?php


            foreach ($months as $key => $value) {
              list($dia, $month, $year) = explode('-', $key);
              $isActive = ($dia == $selectedDia && $month == $selectedMonth && $year == $selectedYear) ? 'active' : '';
              echo '<a class="nav-link ' . $isActive . '" href="?dia=' . $dia . '&month=' . $month . '&year=' . $year . '" role="tab" aria-selected="' . ($isActive == 'active' ? 'true' : 'false') . '">' . $value . '</a>';
            }
            ?>
          </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-<?php echo $selectedDia; ?>-<?php echo $selectedMonth; ?>-<?php echo $selectedYear; ?>" role="tabpanel" aria-labelledby="nav-<?php echo $selectedDia; ?>-<?php echo $selectedMonth; ?>-<?php echo $selectedYear; ?>-tab" tabindex="0">
            <br>
            <?php
            if ($selectedDia === "12" && $selectedYear === "2023") {
              echo '<strong>Se comenzó a contar desde el día: 29 de Diciembre.</strong><br>';
            }
            
            $luzSinLlavero = contarProductos($mysqli, 'Placa Spotify con Luz', 'Placa Spotify con Luz sin llaveros', $selectedDia, $selectedYear);
            $luz1Llavero = contarProductos($mysqli, 'Placa Spotify con Luz', 'Placa Spotify con Luz + 1 llavero', $selectedDia, $selectedYear);
            $luz2Llaveros = contarProductos($mysqli, 'Placa Spotify con Luz', 'Placa Spotify con Luz + 2 llaveros', $selectedDia, $selectedYear);
            $totalLuz = $luzSinLlavero + $luz1Llavero + $luz2Llaveros;


            $baseSinLlvero = contarProductos($mysqli, 'Placa Spotify con Base', 'Placa Spotify con base sin llavero', $selectedDia, $selectedYear);
            $base1Llavero = contarProductos($mysqli, 'Placa Spotify con Base', 'Placa Spotify con base + 1 llavero', $selectedDia, $selectedYear);
            $base2Llaveros = contarProductos($mysqli, 'Placa Spotify con Base', 'Placa Spotify con base + 2 llaveros', $selectedDia, $selectedYear);
            $totalBase = $baseSinLlvero + $base1Llavero + $base2Llaveros;


            $sinBaseSinLlvero = contarProductos($mysqli, 'Placa Spotify sin Base', 'Placa Spotify sin base sin llavero', $selectedDia, $selectedYear);
            $sinBase1Llavero = contarProductos($mysqli, 'Placa Spotify sin Base', 'Placa Spotify sin base + 1 llavero', $selectedDia, $selectedYear);
            $sinBase2Llaveros = contarProductos($mysqli, 'Placa Spotify sin Base', 'Placa Spotify sin base + 2 llaveros', $selectedDia, $selectedYear);
            $totalSinBase = $sinBaseSinLlvero + $sinBase1Llavero + $sinBase2Llaveros;

            $espinillerasSin = contarProductos($mysqli, 'Espinilleras', 'Sin Sujetaespinilleras', $selectedDia, $selectedYear);
            $spinillerasCon = contarProductos($mysqli, 'Espinilleras', 'Sujetaespinillera Blanco', $selectedDia, $selectedYear);
            $totalEspinillera = $espinillerasSin + $spinillerasCon;
            ?>

            <div class="row">
              <h3>Placas Spotify con Luz</h3>
              <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify con Luz', 'Placa Spotify con Luz sin llaveros', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify con Luz</h3>
                          <span>Sin llaveros</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify con Luz', 'Placa Spotify con Luz + 1 llavero', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify con Luz</h3>
                          <span>1 llavero</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify con Luz', 'Placa Spotify con Luz + 2 llaveros', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify con Luz</h3>
                          <span>2 llaveros</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card total">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">

                        <div class="align-self-center">
                          <h3 class="float-left">TOTAL:</h3>
                        </div>
                        <div class="media-body font-large-2 text-right">
                          <h2><?php echo $totalLuz; ?></h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <h3>Placa Spotify con Base</h3>
              <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify con Base', 'Placa Spotify con base sin llavero', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify con Base</h3>
                          <span>Sin llaveros</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify con Base', 'Placa Spotify con base + 1 llavero', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify con Base</h3>
                          <span>1 llavero</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify con Base', 'Placa Spotify con base + 2 llaveros', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify con Base</h3>
                          <span>2 llaveros</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card total">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">

                        <div class="align-self-center">
                          <h3 class="float-left">TOTAL:</h3>
                        </div>
                        <div class="media-body font-large-2 text-right">
                          <h2><?php echo $totalBase; ?></h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <h3>Placa Spotify sin Base</h3>
              <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify sin Base', 'Placa Spotify sin base sin llavero', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify sin Base</h3>
                          <span>Sin llaveros</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify sin Base', 'Placa Spotify sin base + 1 llavero', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify sin Base</h3>
                          <span>1 llavero</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo contarProductos($mysqli, 'Placa Spotify sin Base', 'Placa Spotify sin base + 2 llaveros', $selectedDia, $selectedYear); ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Placa Spotify sin Base</h3>
                          <span>2 llaveros</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card total">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">

                        <div class="align-self-center">
                          <h3 class="float-left">TOTAL:</h3>
                        </div>
                        <div class="media-body font-large-2 text-right">
                          <h2><?php echo $totalSinBase; ?></h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <h3>Espinilleras</h3>
              <div class="col-xl-3 col-sm-6 col-12">

                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo $espinillerasSin; ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Espinilleras</h3>
                          <span>Sin Sujetaespinilleras</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">
                        <div class="align-self-center">
                          <div class="primary font-large-2 float-left">
                            <?php echo $spinillerasCon; ?>
                          </div>
                        </div>
                        <div class="media-body text-right">
                          <h3>Espinilleras</h3>
                          <span>Sujetaespinillera Blanco</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card total">
                  <div class="card-content">
                    <div class="card-body">
                      <div class="media d-flex">

                        <div class="align-self-center">
                          <h3 class="float-left">TOTAL:</h3>
                        </div>
                        <div class="media-body font-large-2 text-right">
                          <h2><?php echo $totalEspinillera; ?></h2>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </div>
  </section>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>