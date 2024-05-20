<?php
require 'db.php';

@$estado = $_POST['estado'];
if (@$_POST['estado'] && empty($_POST['date1'])) {
    @$estado = $_POST['estado'];
    $query = mysqli_query($conn, "SELECT * FROM `sales_order_payment` WHERE `method` = 'paypal_express' ORDER BY `sales_order_payment`.`entity_id` DESC LIMIT 50") or die(mysqli_error());
    $row = mysqli_num_rows($query);

    if ($row > 0) {
        echo "<hr> Mostrando resultados de órdenes con estado: " . $estado . "<hr>";
        while ($fetch = mysqli_fetch_array($query)) {
            $id2 = $fetch['entity_id'];
            $query2 = mysqli_query($conn, "SELECT * FROM `sales_order` WHERE `entity_id` = '$id2' AND status = `processing`") or die(mysqli_error());
            while ($fetch2 = mysqli_fetch_array($query2)) {
?>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="estado[]" value="<?php echo $fetch['increment_id'] ?>" id="envios">
                        </div>
                    </td>
                    <td><?php echo $fetch2['increment_id'] ?></td>
                    <td><?php echo $fetch2['created_at'] ?></td>
                    <td><?php echo $fetch2['customer_firstname'] . " " . $fetch2['customer_lastname'] ?></td>
                    <td><?php echo number_format($fetch2['base_grand_total'], 2) . " €" ?></td>
                    <td><?php

                        echo $fetch2['status'];

                        ?>
                    </td>
                </tr>
            <?php  }
        }
    }
} else {
    echo "<hr> Mostrando últimas 50 ordenes.<hr>";
    $date = date('Y-m-d H:i:s');  // Asegúrate de obtener la fecha actual con la hora
    $fecha_hace_60_dias = date('Y-m-d H:i:s', strtotime('-60 days', strtotime($date)));

    $query = mysqli_query($conn, "SELECT `sales_order`.*, `sales_order_payment`.* FROM `sales_order` LEFT JOIN `sales_order_payment` ON `sales_order_payment`.`parent_id` = `sales_order`.`entity_id` WHERE `status`='processing' AND `created_at` BETWEEN '$fecha_hace_60_dias' AND '$date' ORDER BY `sales_order`.`entity_id` DESC LIMIT 100") or die(mysqli_error());


    while ($fetch = mysqli_fetch_array($query)) {
        $id2 = $fetch['entity_id'];
        $query2 = mysqli_query($conn, "SELECT * FROM `sales_order` WHERE `entity_id` = '$id2'") or die(mysqli_error());
        while ($fetch2 = mysqli_fetch_array($query2)) {
            ?>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="estado[]" value="<?php echo $id2 ?>" id="envios">
                    </div>
                </td>
                <td><?php echo $fetch2['increment_id'] ?></td>
                <td><?php echo $fetch2['created_at'] ?></td>
                <td><?php echo $fetch2['customer_firstname'] . " " . $fetch2['customer_lastname'] ?></td>
                <td><?php echo number_format($fetch2['base_grand_total'], 2) . " €" ?></td>
                <td><?php


                    if ($fetch['method'] == "paypal_express") {
                        echo "<img src='images/paypal.png'>Paypal";
                    } elseif ($fetch['method'] == "free") {
                        echo "Sin método de pago";
                    } else {
                        echo "<img src='images/redsys.png'> Redsys";
                    }

                    ?></td>
                <td><?php

                    echo $fetch2['status'];

                    ?>
                </td>
            </tr>
<?php
        }
    }
}
?>