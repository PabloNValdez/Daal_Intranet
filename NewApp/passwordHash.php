<?php
require 'includes/funciones.php';

// Seleccionar todas las contraseñas en texto plano
$query = "SELECT id, correo, contraseña FROM usuarios";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $correo = $row['correo'];
        $contraseña_plano = $row['contraseña'];

        // Hashear la contraseña en texto plano
        $hash_contraseña = password_hash($contraseña_plano, PASSWORD_DEFAULT);

        // Actualizar la contraseña hasheada en la base de datos
        $update_stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
        $update_stmt->bind_param('si', $hash_contraseña, $id);
        $update_stmt->execute();
        $update_stmt->close();

        echo "Contraseña actualizada para usuario ID: $id, Correo: $correo<br>";
    }
} else {
    echo "No se encontraron usuarios.";
}

$conn->close();
?>