<?php
if($_POST){
    session_start();
 
    // Obtengo los datos cargados en el formulario de login.
    $email = $_POST['email'];
    $password = $_POST['password'];
     
    // Esto se puede remplazar por un usuario real guardado en la base de datos.
    if($email == 'info@getsingular.com' && $password == 'XdKFu67LyjtFQQvM'){
      // Guardo en la sesión el email del usuario.
      $_SESSION['email'] = $email;
       
      // Redirecciono al usuario a la página principal del sitio.
      header("HTTP/1.1 302 Moved Temporarily"); 
      header("Location: index.php"); 
    }else{
      echo 'El email o password es incorrecto, <a href="index.php">vuelva a intenarlo</a>.<br/>';
    }
}
?>


<!doctype html>
<html lang="en">
  <head>
  	<title>Iniciar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user-o"></span>
		      	</div>
		      	<h3 class="text-center mb-4">Bienvenido</h3>
                
						<form action="iniciar.php" method="POST" class="login-form">
		      		<div class="form-group">
		      			<input type="email" name="email" class="form-control rounded-left" placeholder="Email" required>
		      		</div>
	            <div class="form-group d-flex">
	              <input type="password" name="password" class="form-control rounded-left" placeholder="Contraseña" required>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Ingresar</button>
	            </div>
                <p class="text-center">Envios 1.0</p>
	          </form>
	        </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>
