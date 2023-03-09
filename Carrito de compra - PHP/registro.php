<!DOCTYPE html>
<html lang="es">

<head>
	<title>Registro de usuario</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">

	<style>
		body {
			/*background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);*/
			background-image: url("imagenes/fondo2.jpg");
			font-family: 'Open Sans', sans-serif;
			background-size: cover;
			display: flex;
			justify-content: center;
			align-content: center;
			flex-direction: column;
		}

		legend {
			font-family: 'Poppins', sans-serif;
			text-align: center;
			font-weight: 800;
			font-size: 24px;
		}

		.formu {
			background-color: white;
			width: 400px;
			height: 25em;
			padding: 20px;
			margin-left: auto;
			margin-right: auto;
			font-size: 16px;
			box-shadow: 6px 6px 6px black;
			border: 5px solid white;
			border: 5px solid white;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;


		}


		.btn {
			background: #f4f4f4;
			width: 125px;
			color: black;
			border-radius: 4px;
			border: 1px solid #f4f4f4;
			font-weight: 800;
			font-size: 0.9em;
			font-family: 'Poppins', sans-serif;
			cursor: pointer;
		}

		.btn:hover {
			background: white;
		}

		input {
			border-radius: 4%;
			font-family: 'Poppins', sans-serif;
			font-weight: 800;
			background-color: #f4f4f4;
			width: 250px;
			height: 35px;
			border: 2px solid #f4f4f4;

			font-size: 12px;
		}

		input:hover {
			background-color: white;
			border: 2px solid black;

		}

		.in::placeholder {
			transition: transform .5s;
			transition: font-size .5s;
		}

		.in:hover::placeholder {
			transform: translateY(-80%);
			font-size: 10px;
		}

		h2 {
			color: white;
			font-family: 'Poppins', sans-serif;

		}
	</style>
</head>

<body>

	<div class="backClose">
		<form action="" method="POST">
			<button class="btn" type="submit" name="inicio">Volver al inicio</button>
		</form>
	</div>
	<form action="" method="POST" name="regForm" onsubmit="return validar()" class="formu">
		<legend>Únete a la familia de ICYOU</legend>
		<p><input type="text" placeholder="Usuario" name="usu" required="required" maxlength="20" class="in"></p>
		<p><input type="email" placeholder="Email" name="mail" required="required" maxlength="50" class="in"></p>
		<p><input type="password" placeholder="Contraseña" name="pass" required="required" maxlength="50" class="in"></p>
		<p><input type="password" placeholder="Repita contraseña" name="rpass" id="rpasswd" required="required" maxlength="50" class="in" onblur="valpass()"><span id="avisopass"></span></p>
		<p><button class="btn" type="submit" name="registrar">Registrar</button></p>
	</form>

	<?php

	if (isset($_POST['registrar'])) {
		$usu = $_POST['usu'];
		$sqlUsuarios = "SELECT usuario from usuarios where usuario='$usu' ;";
		$conexion = mysqli_connect("localhost", "access", "", "carrito");

		$resulUsuarios = mysqli_query($conexion, $sqlUsuarios);
		if (mysqli_num_rows($resulUsuarios) > 0) {
			echo "<h2 align='center'>¡Oops! Ese nombre de usuario ya está cogido.</h2>";
		} else {

			$contra = $_POST['rpass'];
			$user = $_POST['usu'];
			$contraHash = hash_hmac("sha512", $contra, "primeraweb", FALSE);

			$conexion = mysqli_connect("localhost", "access", "", "carrito");
			if (mysqli_connect_errno()) {
				printf("Conexión fallida %s\n", mysqli_connect_error());
				exit();
			}

			$sql = "INSERT INTO usuarios (idusuario,usuario,password,rol) VALUES (NULL,'$user','$contraHash','cliente');";
			if (mysqli_query($conexion, $sql)) {
				$mensajeregistro = "<h2 align='center'>¡Se ha registrado el usuario con éxito!</h2>";
				echo $mensajeregistro;
			} else {
				echo " <br> Error: " . $sql . "<br>" . mysqli_error($conexion);
			}
		}
		mysqli_close($conexion);
	}

	if (isset($_POST['inicio'])) {

		header("Location:login.php");
	}

	?>

	<script>
		function validar() {
			if (valpass()) {
				return true;
			} else {
				alert("Datos erróneos, indtroducir de nuevo");
				return false;
			}
		}

		function valpass() {
			var contra = document.regForm.pass.value;
			var rcontra = document.regForm.rpass.value;

			if (contra === rcontra) {
				document.getElementById('rpasswd').style.border = "3px solid green";
				document.getElementById('avisopass').innerHTML = " &check; Contraseña correcta";
				return true;
			} else {
				document.getElementById('rpasswd').style.border = "3px solid red";
				document.getElementById('avisopass').innerHTML = " &cross; Contraseña incorrecta";
				return false;
			}
		}
	</script>
</body>

</html>