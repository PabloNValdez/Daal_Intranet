<?php
  session_start();
   
  // Elimina la variable email en sesión.
  unset($_SESSION['usuario_id']);
  unset($_SESSION['usuario_nombre']); 
 
  // Elimina la sesion.
  session_destroy();
   
  // Redirecciona a la página de login.
  header("HTTP/1.1 302 Moved Temporarily"); 
  header("Location: login.php");
?>