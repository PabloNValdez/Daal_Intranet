<?php
	$conn=mysqli_connect("localhost", "Getsingular", "XdKFu67LyjtFQQvM", "Getsingular_final");
	mysqli_set_charset($conn,"utf8");
	if(!$conn){
		die("Error: Failed to connect to database!");
	}
?>