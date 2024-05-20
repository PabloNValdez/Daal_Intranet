<?php
require 'db.php';
@$date1 = date("Y-m-d", strtotime($_POST['date1']));
@$date2 = date("Y-m-d", strtotime($_POST['date2']));
@$estado = $_POST['estado'];
if (!empty($_POST['date1']) && $estado == "vacio") {
    $query = mysqli_query($conn, "SELECT * FROM `sales_order` WHERE date(`created_at`) BETWEEN '$date1' AND '$date2' ORDER BY `entity_id` DESC LIMIT 50") or die(mysqli_error());
    $row = mysqli_num_rows($query);

    if ($row > 0) {
        echo "<hr> Mostrando órdenes desde: <strong>" . $date1 . "</strong> hasta <strong>" . $date2 . "</strong><hr>";
        while ($fetch = mysqli_fetch_array($query)) {
?>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ordenes[]" value="<?php echo $fetch['increment_id'] ?>" id="envios">
                    </div>
                </td>
                <td><?php echo $fetch['increment_id'] ?></td>
                <td><?php echo $fetch['created_at'] ?></td>
                <td><?php echo $fetch['customer_firstname'] . " " . $fetch['customer_lastname'] ?></td>
                <td><?php echo number_format($fetch['base_grand_total'], 2) . " €" ?></td>
                <td><?php echo $fetch['status'] ?></td>
                <td>

                    <?php
                    $id = $fetch['increment_id'];
                    $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id'");

                    while ($fetch2 = mysqli_fetch_array($detalles)) {

                        $designe = $fetch2['design_id'];
                        if ($designe == "") {
                            echo "Sin imagen";
                        } else {

                            $detalles2 = mysqli_query($conn, "SELECT * FROM `productdesigner_design_images` WHERE `design_id` = '$designe' AND design_image_type = 'base'") or die(mysqli_error());
                            $fetch3 = mysqli_fetch_array($detalles2);
                            $imagen = $fetch3['image_path'];
                            echo "<img class='zoom' src='https://www.getsingular.com/media/productdesigner/designs/$designe/base/$imagen' width='75' height='75'>";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $orden_id = $fetch['entity_id'];
                    $det = mysqli_query($conn, "SELECT name, COUNT(*) AS total FROM `sales_order_item` WHERE `order_id` = $orden_id AND `product_type`='simple' GROUP BY name
                HAVING COUNT(*)>=1");
                    if (mysqli_num_rows($det) > 0) {
                        echo "<ul>";
                        while ($rowCatData = mysqli_fetch_array($det)) {

                            echo '<li>' . $rowCatData["name"] . " (" . $rowCatData["total"] . ")" . '</li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </td>

            </tr>
        <?php
        }
    } else {
        echo '
			<tr>
				<td colspan = "4"><center>No existen pedidos en el rango de fecha seleccionada</center></td>
			</tr>';
    }
} else if (@$_POST['estado'] && empty($_POST['date1'])) {
    @$estado = $_POST['estado'];
    $query = mysqli_query($conn, "SELECT * FROM `sales_order` WHERE status = '$estado' ORDER BY `sales_order`.`entity_id` DESC LIMIT 50") or die(mysqli_error());
    $row = mysqli_num_rows($query);

    if ($row > 0) {
        echo "<hr> Mostrando resultados de órdenes con estado: " . $estado . "<hr>";
        while ($fetch = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ordenes[]" value="<?php echo $fetch['increment_id'] ?>" id="envios">
                    </div>
                </td>
                <td><?php echo $fetch['increment_id'] ?></td>
                <td><?php echo $fetch['created_at'] ?></td>
                <td><?php echo $fetch['customer_firstname'] . " " . $fetch['customer_lastname'] ?></td>
                <td><?php echo number_format($fetch['base_grand_total'], 2) . " €" ?></td>
                <td><?php echo $fetch['status'] ?></td>
                <td>

                    <?php
                    $id = $fetch['increment_id'];
                    $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id'");

                    while ($fetch2 = mysqli_fetch_array($detalles)) {

                        $designe = $fetch2['design_id'];
                        if ($designe == "") {
                            echo "Sin imagen";
                        } else {

                            $detalles2 = mysqli_query($conn, "SELECT * FROM `productdesigner_design_images` WHERE `design_id` = '$designe' AND design_image_type = 'base'") or die(mysqli_error());
                            $fetch3 = mysqli_fetch_array($detalles2);
                            $imagen = $fetch3['image_path'];
                            echo "<img class='zoom' src='https://www.getsingular.com/media/productdesigner/designs/$designe/base/$imagen' width='75' height='75'>";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $orden_id = $fetch['entity_id'];
                    $det = mysqli_query($conn, "SELECT name, COUNT(*) AS total FROM `sales_order_item` WHERE `order_id` = $orden_id AND `product_type`='simple' GROUP BY name
                HAVING COUNT(*)>=1");
                    if (mysqli_num_rows($det) > 0) {
                        echo "<ul>";
                        while ($rowCatData = mysqli_fetch_array($det)) {

                            echo '<li>' . $rowCatData["name"] . " (" . $rowCatData["total"] . ")" . '</li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
    } else {
        echo '
			<tr>
				<td colspan = "4"><center>No encontrado</center></td>
			</tr>';
    }
} else if (!empty($_POST['date1']) && $estado != "vacio") {
    @$estado = $_POST['estado'];
    $query = mysqli_query($conn, "SELECT * FROM `sales_order` WHERE date(`created_at`) BETWEEN '$date1' AND '$date2' AND status = '$estado' ORDER BY `entity_id` DESC LIMIT 50") or die(mysqli_error());
    $row = mysqli_num_rows($query);

    if ($row > 0) {
        echo "<hr> Mostrando órdenes desde: <strong>" . $date1 . "</strong> hasta <strong>" . $date2 . "</strong> con el estado: <strong>" . $estado . "</trong><hr>";
        while ($fetch = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="ordenes[]" value="<?php echo $fetch['increment_id'] ?>" id="envios">
                    </div>
                </td>
                <td><?php echo $fetch['increment_id'] ?></td>
                <td><?php echo date("d-m-Y", strtotime($fetch['created_at'])) ?></td>
                <td><?php echo $fetch['customer_firstname'] . " " . $fetch['customer_lastname'] ?></td>
                <td><?php echo number_format($fetch['base_grand_total'], 2) . " €" ?></td>
                <td><?php echo $fetch['status'] ?></td>
                <td>

                    <?php
                    $id = $fetch['increment_id'];
                    $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id'");

                    while ($fetch2 = mysqli_fetch_array($detalles)) {

                        $designe = $fetch2['design_id'];
                        if ($designe == "") {
                            echo "Sin imagen";
                        } else {

                            $detalles2 = mysqli_query($conn, "SELECT * FROM `productdesigner_design_images` WHERE `design_id` = '$designe' AND design_image_type = 'base'") or die(mysqli_error());
                            $fetch3 = mysqli_fetch_array($detalles2);
                            $imagen = $fetch3['image_path'];
                            echo "<img class='zoom' src='https://www.getsingular.com/media/productdesigner/designs/$designe/base/$imagen' width='75' height='75'>";
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $orden_id = $fetch['entity_id'];
                    $det = mysqli_query($conn, "SELECT name, COUNT(*) AS total FROM `sales_order_item` WHERE `order_id` = $orden_id AND `product_type`='simple' GROUP BY name
                HAVING COUNT(*)>=1");
                    if (mysqli_num_rows($det) > 0) {
                        echo "<ul>";
                        while ($rowCatData = mysqli_fetch_array($det)) {

                            echo '<li>' . $rowCatData["name"] . " (" . $rowCatData["total"] . ")" . '</li>';
                        }
                        echo "</ul>";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
    } else {
        echo '
			<tr>
				<td colspan = "6"><center>No existen resultados para las fechas: <strong>' . $date1 . ' </strong> hasta <strong>' . $date2 . ' </strong>y el estado: <strong>' . $estado . '</strong></center></td>
			</tr>';
    }
} else {
    echo "<hr> Mostrando últimas 50 ordenes<hr>";
    $query = mysqli_query($conn, "SELECT entity_id,increment_id, status, created_at, customer_firstname, customer_lastname, base_grand_total FROM sales_order ORDER BY `sales_order`.`entity_id` DESC LIMIT 50") or die(mysqli_error());
    while ($fetch = mysqli_fetch_array($query)) {
        ?>
        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ordenes[]" value="<?php echo $fetch['increment_id'] ?>" id="envios">
                </div>
            </td>
            <td><?php echo $fetch['increment_id'] ?></td>
            <td><?php echo $fetch['created_at'] ?></td>
            <td><?php echo $fetch['customer_firstname'] . " " . $fetch['customer_lastname'] ?></td>
            <td><?php echo number_format($fetch['base_grand_total'], 2) . " €" ?></td>
            <td><?php echo $fetch['status'] ?></td>
            <td>

                <?php
                $id = $fetch['increment_id'];
                $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id'");

                while ($fetch2 = mysqli_fetch_array($detalles)) {

                    $designe = $fetch2['design_id'];
                    if ($designe == "") {
                        echo "Sin imagen";
                    } else {
                        $detalles2 = mysqli_query($conn, "SELECT * FROM `productdesigner_design_images` WHERE `design_id` = '$designe' AND design_image_type = 'base'") or die(mysqli_error());
                        $fetch3 = mysqli_fetch_array($detalles2);
                        $imagen = $fetch3['image_path'];
                        echo "<img class='zoom' src='https://www.getsingular.com/media/productdesigner/designs/$designe/base/$imagen' width='75' height='75'>";
                    }
                }
                ?>
            </td>
            <td>
                <?php
                $orden_id = $fetch['entity_id'];
                $det = mysqli_query($conn, "SELECT `product_id`,`name`, COUNT(*) AS total FROM `sales_order_item` WHERE `order_id` = $orden_id AND `product_type`='simple' GROUP BY name,product_id HAVING COUNT(*)>=1");
                if (mysqli_num_rows($det) > 0) {
                    //echo "<ul>";
                    while ($rowCatData = mysqli_fetch_array($det)) {

                        // Nombre de cada producto del pedido, y total de cada producto.

                        echo '<div class="container"><div class="row"><div class="col-md-9">';
                        echo '<p>' . $rowCatData["name"] . " <span class='badge rounded-pill text-bg-primary'>" . $rowCatData["total"] . "</span>" . '</p>';
                        echo '</div><div class="col-md-3">';

                        //echo '<li>' . $rowCatData["product_id"] . '</li>';
                        $product_id = $rowCatData["product_id"];
                        $det2 = mysqli_query($conn, "SELECT `value_id` FROM `catalog_product_entity_media_gallery_value` WHERE `entity_id` = $product_id AND `disabled`= 0 LIMIT 1");
                        if (mysqli_num_rows($det2) > 0) {
                            while ($rowDet2 = mysqli_fetch_array($det2)) {
                                //echo '<li>' . $rowDet2["value_id"] . '</li>';
                                $id = $rowDet2["value_id"];
                                $imagen = mysqli_query($conn, "SELECT * FROM `catalog_product_entity_media_gallery` WHERE `value_id` = $id");

                                $imagenes = array();
                                while ($imagen_producto = mysqli_fetch_array($imagen)) {
                                    // Mostrar imagen de cada producto del pedido
                                    $imagenes[] = $imagen_producto["value"];
                                }
                                // Mostrar las imágenes
                                foreach ($imagenes as $imagen) {
                                    echo "<img class='zoom img-fluid' src='https://www.getsingular.com/media/catalog/product/" . $imagen . "' width='75' height='75'>";
                                }
                            }
                        }

                        echo '</div></div></div>';
                    }
                    //echo "</ul>";
                }
                ?>
            </td>

        </tr>
<?php
    }
}
?>