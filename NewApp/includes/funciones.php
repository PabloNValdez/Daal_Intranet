<?php 
$conn = new mysqli("localhost", "Getsingular", "XdKFu67LyjtFQQvM", "conversor");
                  //Servidor, Usuario, Contraseña, BD Name

if ($conn->connect_error) {
  die("La conexión ha fallado: " . $conn->connect_error);
}
