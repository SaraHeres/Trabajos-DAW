<!DOCTYPE html>
<html lang="es">

<head>
	<title>Inicio tienda</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">


	<style>
		html,
		body {
			background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);
			width: 100%;
			height: 100%;


		}

		.formu {
			text-align: left;
			border: 5px solid white;
			height: 100%;
			width: 100%;
			background-color: white;
			padding: 20px;
			padding-top: 30%;


		}


		#padre {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: center;
		}

		.btn {
			background: #d1d1d1;
			width: 125px;
			color: black;
			border-radius: 4px;
			border: 1px solid #d1d1d1;
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
			font-family: 'Heebo', sans-serif;
			font-weight: 800;
			background-color: #d1d1d1;
			width: 70%;
			height: 35px;
			border: 2px solid #d1d1d1;
			padding: 5px;
			font-size: 12px;
		}

		input:hover {
			background-color: white;
			border: 2px solid black;

		}

		#in::placeholder {
			transition: transform .5s;
			transition: font-size .5s;
		}

		#in:hover::placeholder {
			transform: translateY(-80%);
			font-size: 10px;
		}

		.tit {
			font-family: 'Poppins', sans-serif;
			font-weight: 800;
			font-size: 24px;
		}

		p a {
			font-size: 14px;
			text-decoration: none;
			font-family: 'Poppins', sans-serif;
			color: grey;
			font-weight: 700;
			margin-top: 40px;
		}

		a:hover {
			color: black;
		}



		#formi {
			height: 44.2em;
			width: 25em;
		}



		#ima {
			width: 599px;
			height: 584px;
			background-image: url("imagenes/lol2.jpg");
			background-size: cover;
		}

		#men {
			font-family: 'Poppins', sans-serif;
			font-weight: 700;
			color: red;


		}
	</style>
	<script>
		function mensaje() {
			document.getElementById("men").innerHTML = "Usuario o contraseña incorrectos.";
		}
	</script>
</head>

<body>

	<div id="padre">
		<table>
			<tr>
				<td id="formi">
					<form action="" method="POST" class="formu">

						<p class="tit">INICIAR SESIÓN</p>
						<p><input placeholder="USUARIO" type="text" name="user" required="required" id="in"></p>
						<p><input placeholder="CONTRASEÑA" type="password" name="pass" required="required" id="in"></p>
						<p><input class="btn" type="submit" name="en" value="Iniciar sesión" class="entrar"></p>
						<p><a href="registro.php">Crear una cuenta</a></p>
						<p><span id="men"></span></p>

					</form>
				</td>
				<td id="ima"></td>
			</tr>
		</table>



		<?php

		$conexion = mysqli_connect('localhost', 'access', '', 'carrito');
		if (mysqli_connect_errno()) {
			printf("Conexión fallida %s\n", mysqli_connect_error());
			exit();
		}

		if (isset($_POST['en'])) {
			$usuario = $_POST['user'];
			$password = $_POST['pass'];
			$contraHash = hash_hmac("sha512", $password, "primeraweb", FALSE);
			$sql = "SELECT usuario,rol,idusuario,password FROM usuarios WHERE usuario = '$usuario' AND password = '$contraHash'";
			$result = mysqli_query($conexion, $sql);

			if (mysqli_num_rows($result) > 0) {
				while ($registro = mysqli_fetch_row($result)) {
					$user = $registro[0];
					$rol = $registro[1];
					$id = $registro[2];
					$pass = $registro[3];
				}

				session_start();

				$_SESSION['usuario'] = "$user";
				$_SESSION['rol'] = "$rol";
				$_SESSION['idusuario'] = "$id";

				header("Location: inicio.php");

				exit();
			} else {
				echo "<script>";
				echo "mensaje();";
				echo "</script>";
			}
		}

		mysqli_close($conexion);

		?>




	</div>

</body>

</html>