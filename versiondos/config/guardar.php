<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $alto = $_POST["alto"];
        $ancho = $_POST["ancho"];

        $c10 = $_POST["c10"];
        $c20 = $_POST["c20"];
        $c30 = $_POST["c30"];
        $c40 = $_POST["c40"];

        $configuracion['datos_madera']['alto'] = $alto;
        $configuracion['datos_madera']['ancho'] = $ancho;
        $configuracion['datos_madera']['c10'] = $c10;
        $configuracion['datos_madera']['c20'] = $c20;
        $configuracion['datos_madera']['c30'] = $c30;
        $configuracion['datos_madera']['c40'] = $c40;

        $datos_nuevos = '';
        foreach ($configuracion as $seccion => $valores) {
            $datos_nuevos .= '[' . $seccion . ']' . PHP_EOL;
            foreach ($valores as $clave => $valor) {
                if (is_numeric($valor)) {
                    $datos_nuevos .= $clave . ' = ' . $valor . PHP_EOL;
                } else {
                    $datos_nuevos .= $clave . ' = "' . $valor . '"' . PHP_EOL;
                }
            }
        }

        file_put_contents('configuracion.ini', $datos_nuevos);
        header('Location: index.php?$aviso=si');
    }
?>

