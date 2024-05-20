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
                    $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id' LIMIT 4");

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
                    $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id' LIMIT 4");

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
                    $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id' LIMIT 4");

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
                $detalles = mysqli_query($conn, "SELECT * FROM `productdesigner_order` WHERE `order_id` = '$id' LIMIT 4");

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
        </tr>
<?php
    }
}
?>