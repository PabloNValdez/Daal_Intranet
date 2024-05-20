<?php
require 'includes/funciones.php';

$mensaje_error = '';

if ($conn->connect_error) {
  die("La conexión ha fallado: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $consulta = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conn, $consulta);

    if (mysqli_num_rows($resultado) === 1) {
        $fila = mysqli_fetch_assoc($resultado);
        if (password_verify($contraseña, $fila['contraseña'])) {
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['usuario_nombre'] = $fila['nombre'];
            header('Location: index.php');
            exit();
        } else {
            $mensaje_error = 'Correo o contraseña incorrectos.';
        }
    } else {
        $mensaje_error = 'Correo o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Amazon a DPD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">

  <main class="form-signin w-100 m-auto">
    <form method="POST" action="login.php">
      <h1 class="h3 mb-3 fw-normal text-center">Ingresar</h1>

      <?php if (!empty($mensaje_error)): ?>
          <div class="alert alert-danger">
              <?php echo $mensaje_error; ?>
          </div>
      <?php endif; ?>

      <div class="form-floating">
        <input type="email" class="form-control" name="correo" id="correo" placeholder="name@example.com">
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="contraseña" id="contraseña" placeholder="Password">
        <label for="contraseña">Contraseña</label>
      </div>

      <button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>

    </form>
  </main>

</body>

</html>
