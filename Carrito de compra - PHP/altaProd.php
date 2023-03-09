<?php

session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
	<title>Alta producto</title>
	<meta charset="utf-8">

	<link href="https://fonts.googleapis.com/css?family=Marcellus+SC&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">

	<style>
		body {
			background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);
			background-size: cover;
		}

		.formu {
			background-color: white;
			width: 500px;
			height: 500px;
			padding: 30px;
			margin-left: auto;
			margin-right: auto;
			font-size: 16px;
			font-family: 'Poppins', sans-serif;

			box-shadow: 6px 6px 6px black;


		}

		input {
			border-radius: 5%;
			border: 1px solid grey;
			padding: 5px;
			font-family: 'Open Sans', sans-serif;

		}

		select {
			border-radius: 5%;
			border: 1px solid grey;
			padding: 5px;
			font-family: 'Open Sans', sans-serif;

		}

		legend {
			text-align: center;
		}

		.asig {
			margin-top: 15px;
			background: #0f4c75;
			width: 125px;
			padding-top: 5px;
			padding-bottom: 5px;
			color: white;
			border-radius: 4px;
			border: #3282b8 1px solid;
			cursor: pointer;

		}

		.asig:hover {
			background: #3282b8;

		}

		h1,
		h2,
		h3 {
			font-family: 'Poppins', sans-serif;
			font-weight: 800;
			font-size: 24px;
			color: white;
			text-transform: uppercase;
		}

		input {
			border-radius: 4%;
			font-family: 'Heebo', sans-serif;
			font-weight: 800;
			background-color: #f4f4f4;
			width: 70%;
			height: 35px;
			border: 2px solid #f4f4f4;
			padding: 5px;
			font-size: 12px;
			margin-left: 60px;
		}

		textarea {
			margin-left: 60px;
			font-family: 'Heebo', sans-serif;
			font-weight: 800;
			border-radius: 4%;
			border: 2px solid #f4f4f4;
			font-size: 12px;
			background-color: #f4f4f4;
		}

		textarea:hover {
			background-color: white;
			border: 2px solid black;


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
	</style>
</head>

<body>
	<h1 align="center">Bienvenid@ <?php echo $_SESSION['usuario']; ?>, se ha identificado como <?php echo $_SESSION['rol'] ?></h1>
	<div>
		<form action="" method="POST">
			<button class="btn" type="submit" name="back">Volver</button>
			<button class="btn" type="submit" name="logout">Cerrar Sesión</button>
		</form>
	</div>
	<form action="" method="POST" name="altaForm" class="formu">
		<legend><strong>Introducir un nuevo producto</strong></legend>
		<p><input class="in" type="text" name="nom" id="nom" required="required" placeholder="NOMBRE PRODUCTO"></p>
		<p><textarea class="in" placeholder="DESCRIPCIÓN" name="des" style="box-sizing: border-box; width: 350px; height: 200px; resize: none; overflow: auto;"></textarea></p>
		<p><input class="in" placeholder="PRECIO" type="number" name="pre" id="pre" required="required"></p>
		<p><input class="in" placeholder="RUTA IMAGEN" type="text" name="ima" id="ima" required="required"></p>
		<p><input type="submit" class="btn" name="insertar" value="Dar de alta"></p>
	</form>
	<?php

	if (isset($_POST['insertar'])) {

		$nom = $_POST['nom'];
		$des = $_POST['des'];
		$pre = $_POST['pre'];
		$ima = $_POST['ima'];

		if ($_SESSION['rol'] == 'gestor') {

			$conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
			$sqlComp = "SELECT nombreproducto, rutaimagen FROM articulo WHERE nombreproducto='$nom' AND rutaimagen='$ima';";
			$resulArti = mysqli_query($conexion, $sqlComp);
			if (mysqli_num_rows($resulArti) > 0) {
				echo "<h2 align='center'>Ese producto ya existe.</h2>";
			} else {


				$sql = "INSERT INTO articulo(idproducto, nombreproducto, descripcion, precio, rutaimagen) VALUES ('','$nom','$des','$pre','$ima');";

				if (mysqli_query($conexion, $sql)) {
					echo "<h3 align='center'> Se ha registrado el producto con éxito</p>";
				} else {
					echo " <br><h3> Error: </h3>" . $sql . "<br>" . mysqli_error($conexion);
				}
			}
		}
		mysqli_close($conexion);
	}

	if (isset($_POST['back'])) {

		header("Location:inicio.php");
	}

	if (isset($_POST['logout'])) {

		session_destroy();

		header("Location:login.php");
	}

	?>