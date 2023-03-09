<?php

session_start();



//bloque de conexion
$conexion = mysqli_connect('localhost', 'usuacceso', 'usuacceso', 'consultas');
if (mysqli_connect_errno()) {
	printf("Conexión fallida %s\n", mysqli_connect_error());
	exit();
}

if (isset($_POST['enviar'])) {

	$usuario = $_POST['usuario'];
	$contra = $_POST['contra'];

	$consulta = "SELECT dniUsu,usutipo FROM usuarios WHERE usuLogin = '$usuario' AND usuPassword = '$contra'";
	$salida = mysqli_query($conexion, $consulta);

	if (mysqli_num_rows($salida) > 0) {
		while ($array = mysqli_fetch_row($salida)) {
			$dni = $array[0];
			$perfil = $array[1];
		}

		$_SESSION['dni'] = "$dni";
		$_SESSION['perfil'] = "$perfil";
		$_SESSION['user'] = $usuario;





		header("Location: inicio.php");

		exit();
	} 
	
	else {

		echo ("<p>El usuario o contraseña no son correctos, vuelva a introducirlos</p>");
	}
}
mysqli_close($conexion);

?>


<!DOCTYPE html>

<html lang="es">

<head>
	<title>Centro Médico Sana Samna Culito de Rana</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>

<body>

<h1>Iniciar sesión</h1>

	<form action="" method="POST">
		<fieldset>

			<legend></legend>
			<p>Login: <input type="text" name="usuario" required="required"></p>
			<p>Password: <input type="password" name="contra" required="required"></p>
			<p><input type="submit" name="enviar" value="Enviar"></p>

		</fieldset>
	</form>


</body>


</html>