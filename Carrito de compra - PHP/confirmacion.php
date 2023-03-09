<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Confirmación</title>
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">
	<style>
		body,
		html {
			width: 100%;
			height: 100%;
		}

		body {
			background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);
			background-size: cover;
			font-family: 'Poppins', sans-serif;
		}

		h1 {
			text-transform: uppercase;
			color: white;
		}

		table {
			width: 50%;
			font-family: 'Poppins', sans-serif;
			background-color: rgba(255, 255, 255, .6);
			border-collapse: collapse;
			border: none;
			text-align: center;

		}

		td {
			padding: 10px;
			border-left: none;
			border-right: none;
		}

		th {
			padding: 20px;
			border: none;
		}

		tr {
			border-top: 1px solid white;
			border-bottom: 1px solid white;
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
	<?php

	$conexion = mysqli_connect('localhost', 'cliente', '', 'carrito');
	if (mysqli_connect_errno()) {
		printf("Conexión fallida %s\n", mysqli_connect_error());
		exit();
	}
	if (isset($preciototal) == false) {
		$preciototal = 0;
	}

	?>

	<h1 align="center">Compra confirmada, <?php echo $_SESSION['usuario']; ?>
	</h1>
	<form action="" method="POST">
		<button class="btn" type="submit" name="back">Volver</button>
		<button class="btn" type="submit" name="logout">Cerrar Sesión</button>

	</form>
	<h3 align="center">Usted acaba de adquirir:</h3>
	<table align="center">
		<tr>
			<th>Producto</th>
			<th>Unidades</th>
			<th>Precio</th>
		</tr>
		<?php
		foreach ($_SESSION['cantidad'] as $key => $valor) {
			if ($valor > 0) {
				$sql = "SELECT precio, idproducto, nombreproducto from articulo where '$key'=articulo.idproducto";

				$resultado = mysqli_query($conexion, $sql);
				$filas = mysqli_num_rows($resultado);
				if ($filas > 0) {
					while ($registro = mysqli_fetch_row($resultado)) {
		?>
						<tr>
							<td><?php echo $registro[2] ?></td>
							<td><?php echo $valor ?></td>
							<td><?php echo ($valor * $registro[0]) ?></td>

						</tr>
		<?php

						$preciototal += ($valor * $registro[0]);
						$date = date('Y-m-d H:i:s');
						$usuario = $_SESSION['idusuario'];
						$precio = $registro[0];
						$idProducto = $registro[1];
						$sql2 = "INSERT into compras (idcompra, idcliente, idarticulo, fecha, cantidad, precio) values (NULL, $usuario,$idProducto,'$date',$valor,$precio);";
						if (mysqli_multi_query($conexion, $sql2)) {
							$aviso = "<h4 align='center'>La compra ha sido procesada </h4>";
						} else {
							$aviso = " <br> Error: " . $sql2 . "<br>" . mysqli_error($conexion);
						}
					}
				}
			}
		}

		?>
		<td>Total: </td>
		<td><?php echo $preciototal ?>€</td>
		</tr>
	</table>
	<?php echo $aviso;
	$_SESSION['cantidad'] = ['1' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0];
	?>
	<h4 align="center">¡Gracias por su compra!</h4>

	<br>

	<?php
	if (isset($_POST['back'])) {

		header("Location:inicio.php");
	}

	if (isset($_POST['logout'])) {

		session_destroy();

		header("Location:login.php");
	}



	?>
</body>

</html>