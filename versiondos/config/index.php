<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Configuración</title>
    <!-- Incluye Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container py-5">
        <?php
        $configuracion = parse_ini_file('configuracion.ini', true);
        $ancho = $configuracion['datos_madera']['ancho'];
        $alto = $configuracion['datos_madera']['alto'];
        $c10 = $configuracion['datos_madera']['c10'];
        $c20 = $configuracion['datos_madera']['c20'];
        $c30 = $configuracion['datos_madera']['c30'];
        $c40 = $configuracion['datos_madera']['c40'];
        ?>
        <form method="POST" action="guardar.php">
            <?php
            if ($aviso == "si") {
                echo "<strong>La configuración se guardó exitosamente</strong>";
            }
            ?>
            <fieldset>
                <legend>Placa de Madera</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alto">Ancho:</label>
                            <input type="text" id="ancho" name="ancho" class="form-control" value="<?php echo $ancho; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ancho">Alto:</label>
                            <input type="text" id="alto" name="alto" class="form-control" value="<?php echo $alto; ?>">
                        </div>
                    </div>
                </div>
                <p>Configuración del tamaño de la fuente: Tamaño en PX, segun cantidad de caracteres que tenga la frase
                    <hr>
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c10">Hasta 10 Caracteres</label>
                            <input type="text" id="c10" name="c10" class="form-control" value="<?php echo $c10; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c20">Hasta 20 Caracteres:</label>
                            <input type="text" id="c20" name="c20" class="form-control" value="<?php echo $c20; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c30">Hasta 30 Caracteres</label>
                            <input type="text" id="c30" name="c30" class="form-control" value="<?php echo $c30; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="c40">Hasta 40 Caracteres:</label>
                            <input type="text" id="c40" name="c40" class="form-control" value="<?php echo $c40; ?>">
                        </div>
                    </div>
                </div>

            </fieldset>
            <div class="form-group">
                <input type="submit" value="Guardar" class="btn btn-primary">
            </div>
        </form>




        <fieldset>
            <legend>Eliminar placas</legend>
            <div class="row">
                <?php
            if ($eliminado == "si") {
                echo "<strong>Se han eliminado todos los archivos!</strong>";
            } ?>
                <div class="col-md-6">
                    <form method="POST" action="index.php">
                        <input type="submit"  class="btn btn-primary" value="Eliminar contenido de carpetas" name="eliminar">
                    </form>
                </div>
            </div>
        </fieldset>
    </div>



    <?php
    function eliminarContenidoCarpeta($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        eliminarContenidoCarpeta($dir . "/" . $object);
                        rmdir($dir . "/" . $object); // Mueve esta línea aquí para solo eliminar las subcarpetas
                    } else {
                        // no elimine el archivo index.php
                        if ($object != "index.php") {
                            unlink($dir . "/" . $object);
                        }
                    }
                }
            }
            reset($objects);
        }
    }

    if (isset($_POST['eliminar'])) {
        $carpeta1 = '../data';
        $carpeta2 = '../salida';
        $carpeta3 = '../carpeta';

        eliminarContenidoCarpeta($carpeta1);
        eliminarContenidoCarpeta($carpeta2);
        eliminarContenidoCarpeta($carpeta3);

       $eliminado = "si";
    }
    ?>
</body>

</html>