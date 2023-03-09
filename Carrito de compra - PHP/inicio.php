<?php

session_start();


?>

<!DOCTYPE html>
<html>

<head>
	<title>Inicio <?php echo $_SESSION['usuario']; ?></title>
	<link rel="stylesheet" href="indice.css">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">

	<style>
		#padre {
			display: flex;
			justify-content: center;
			align-items: center;
			height: 100%;
		}

		.btn {
			margin-top: 40px;
			margin-left: 30px;
			width: 200px;
			cursor: pointer;
			padding: 20px;
			display: inline-block;
			transition: all 0.3s ease 0s;
			background: #d1d1d1;
			color: black;
			border-radius: 4px;
			border: 2px solid #d1d1d1;
			font-weight: 800;
			font-size: 0.9em;
			font-family: 'Poppins', sans-serif;
			cursor: pointer;
		}

		.btn:hover {
			color: black;
			background-color: white;
			border-radius: 50px;
			border-color: black;
			transition: all 0.3s ease 0s;

		}

		.btn2 {
			margin-left: 30px;
			width: 150px;
			cursor: pointer;
			padding: 20px;
			display: inline-block;
			transition: all 0.3s ease 0s;
			background: #d1d1d1;
			color: black;
			border-radius: 4px;
			border: 2px solid #d1d1d1;
			font-weight: 800;
			font-size: 0.9em;
			font-family: 'Poppins', sans-serif;
			cursor: pointer;
		}

		.btn2:hover {
			color: black;
			background-color: white;
			border-radius: 50px;
			border-color: black;
			transition: all 0.3s ease 0s;

		}

		form {

			padding: 20px;
			width: 40%;
			height: 30em;
			background-color: white;
			width: 40%;

		}

		.bien {

			margin-top: 90px;
			font-family: 'Poppins', sans-serif;
			font-weight: 800;
			font-size: 24px;
			text-transform: uppercase;
		}

		.botones {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 5%;
			margin-left: 0px;

		}

		.formGes {
			padding: 20px;
			width: 60em;
			height: 30em;
			background-color: white;


		}
	</style>

</head>

<body>

	<?php
	$conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
	if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {

		if ($_SESSION['rol'] == "cliente") {
			$conexion = mysqli_connect('localhost', 'cliente', '', 'carrito');
			if (mysqli_connect_errno()) {
				printf("Conexión fallida %s\n", mysqli_connect_error());
				exit();
			}

	?>


			<div id="padre">
				<form action="" method="POST">
					<p align="center" class="bien">BIENVENID@ <?php echo $_SESSION['usuario']; ?>, ES USTED CLIENTE</p>
					<div class="botones">
						<button class="btn" type="submit" name="verCat">Catálogo</button>
						<button class="btn" type="submit" name="verCom">Compras</button>
						<button class="btn" type="submit" name="verFecha">Búsqueda</button>
						<button class="btn" type="submit" name="logout">Logout</button>
					</div>
				</form>
			</div>

			<?php

			if (isset($_POST['verCat'])) {

				header("Location:verProd.php");
			}

			if (isset($_POST['verCom'])) {

				header("Location:verCom.php");
			}
			if (isset($_POST['verFecha'])) {

				header("Location:verFecha.php");
			}
			if (isset($_POST['logout'])) {

				session_destroy();

				header("Location:login.php");
			}
		}

		if ($_SESSION['rol'] == 'gestor') {
			$conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
			if (mysqli_connect_errno()) {
				printf("Conexión fallida %s\n", mysqli_connect_error());
				exit();
			}
			$conexion = mysqli_connect('localhost', 'cliente', '', 'carrito');




			?>


			<div id="padre">
				<form action="" method="POST" class="formGes">
					<p align="center" class="bien">BIENVENID@ <?php echo $_SESSION['usuario'] ?>, ES USTED <?php echo $_SESSION['rol'] ?></p>
					<div class="botones">
						<p><button class="btn2" type="submit" name="altaProd">Alta</button></p>
						<p><button class="btn2" type="submit" name="verProd">Stock</button></p>
						<p><button class="btn2" type="submit" name="verCom">Compras</button></p>
						<p><button class="btn2" type="submit" name="verFecha">Búsqueda</button></p>
						<p><button class="btn2" type="submit" name="logout">Logout</button></p>
					</div>
				</form>
			</div>

	<?php

			if (isset($_POST['altaProd'])) {

				header("Location:altaProd.php");
			}

			if (isset($_POST['verProd'])) {

				header("Location:verProd.php");
			}

			if (isset($_POST['verCom'])) {

				header("Location:verCom.php");
			}

			if (isset($_POST['verFecha'])) {

				header("Location:verFecha.php");
			}
			if (isset($_POST['logout'])) {

				session_destroy();

				header("Location:login.php");
			}
		}
	}
	mysqli_close($conexion);
	?>
	</div>
</body>

</html>