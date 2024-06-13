<?php
require 'includes/funciones.php';
session_start();

// Mensaje de error
$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contraseña = $_POST['contraseña'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("SELECT id, nombre, contraseña FROM usuarios WHERE correo = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si se encontró el usuario
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $nombre, $hash_contraseña);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($contraseña, $hash_contraseña)) {
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['mensaje_exito'] = 'Sesión iniciada correctamente. Ir al inicio';
            echo "<script>alert('" . $_SESSION['mensaje_exito'] . "');</script>";
            header('Refresh: 1; URL=index.php'); // Redirigir después de 3 segundos
        } else {
            $_SESSION['mensaje_error'] = 'Correo o contraseña incorrectos.';
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['mensaje_error'] = 'Correo o contraseña incorrectos. Parte 2';
        header('Location: index.php');
        exit();
    }

    // Cerrar la conexión
    $stmt->close();
}
?>


