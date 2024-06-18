<?php 
$servername = "localhost";
$username = "Getsingular";
$password = "XdKFu67LyjtFQQvM";
$dbname = "conversor";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
}
?>
