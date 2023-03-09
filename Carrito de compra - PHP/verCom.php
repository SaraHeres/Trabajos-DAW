<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Inicio <?php echo $_SESSION['usuario']; ?></title>
	<link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">
	<style>
		html,
		body {
			height: 100%;
			width: 100%;
		}

		body {
			background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);
			background-size: cover;
			font-family: 'Mallanna', sans-serif;
			padding: 15px;
		}

		img {
			width: auto;
			height: 100px;

		}

		table {
			width: 50%;
			font-family: 'Poppins', sans-serif;
			background-color: rgba(255, 255, 255, .6);
			border-collapse: collapse;
			border: none;

		}

		td {
			padding: 10px;
			border-left: none;
			border-right: none;
		}

		.titular {
			border-top: none;


		}

		h1 {
			font-family: 'Poppins', sans-serif;
			font-weight: 800;
			font-size: 24px;
			color: white;
			text-transform: uppercase;

		}

		th {
			padding: 20px;
			border: none;
		}

		.odd {
			background-color: rgba(0, 0, 0, .2);
		}

		#padre {
			background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);


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
	$id = $_SESSION['idusuario'];

	$conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
	if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {

		if ($_SESSION['rol'] == "cliente") {
			$conexion = mysqli_connect('localhost', 'cliente', '', 'carrito');
			if (mysqli_connect_errno()) {
				printf("Conexión fallida %s\n", mysqli_connect_error());
				exit();
			}

			if (isset($_POST['logout'])) {

				session_destroy();

				header("Location:login.php");
			}
			if (isset($_POST['back'])) {

				header("Location:inicio.php");
			}

	?>

			<h1 align="center">COMPRAS DE <?php echo $_SESSION['usuario']; ?></h1>


			<div>
				<form action="" method="POST">
					<button class="btn" type="submit" name="back">Volver</button>
					<button class="btn" type="submit" name="logout">Cerrar Sesión</button>
				</form>
			</div>
			<div id="padre">
				<table align="center" border="1" style="text-align: center;">
					<tr class="titular">
						<th>Id compra</th>
						<th>Artículo</th>
						<th>Id cliente</th>
						<th>Fecha | Hora</th>
						<th>Cantidad</th>
						<th>Precio</th>


					</tr>

					<?php




					$sql = "SELECT * from compras WHERE idcliente='$id';";
					$count = 0;
					$resultado = mysqli_query($conexion, $sql);

					$filas = mysqli_num_rows($resultado);

					if ($filas > 0) {
						while ($registro = mysqli_fetch_row($resultado)) {
							$idproducto = $registro[1];
							$sql1 = "SELECT nombreproducto FROM articulo where idproducto='$idproducto';";
							$resultado2 = mysqli_query($conexion, $sql1);
							while ($row = mysqli_fetch_row($resultado2)) {
								$count++;
								if ($count % 2 == 0) {


					?>

									<tr>
										<td><?php echo $registro[0]; ?></td>
										<td><?php echo $row[0]; ?></td>
										<td><?php echo $registro[2]; ?></td>
										<td><?php echo $registro[3]; ?></td>
										<td><?php echo $registro[4]; ?></td>
										<td><?php echo $registro[5]; ?>€</td>

									</tr>

								<?php
								} else {

								?>
									<tr class="odd">
										<td><?php echo $registro[0]; ?></td>
										<td><?php echo $row[0]; ?></td>
										<td><?php echo $registro[2]; ?></td>
										<td><?php echo $registro[3]; ?></td>
										<td><?php echo $registro[4]; ?></td>
										<td><?php echo $registro[5]; ?>€</td>

									</tr>
					<?php
								}
							}
						}
					} elseif ($filas == 0) {
						echo "<tr><td colspan='6'>No has comprado nada.</td></tr>";
					}

					?>

				</table>

			</div>

		<?php



		}

		if ($_SESSION['rol'] == 'gestor') {
			$conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
			if (mysqli_connect_errno()) {
				printf("Conexión fallida %s\n", mysqli_connect_error());
				exit();
			}
			if (isset($_POST['logout'])) {

				session_destroy();

				header("Location:login.php");
			}
			if (isset($_POST['back'])) {

				header("Location:inicio.php");
			}




		?>

			<h1 align="center">Viendo todas las compras como gestor ( <?php echo $_SESSION['usuario']; ?>)</h1>


			<div>
				<form action="" method="POST">
					<button class="btn" type="submit" name="back">Volver</button>
					<button class="btn" type="submit" name="logout">Cerrar Sesión</button>
				</form>
			</div>
			<div id="padre">
				<table align="center" border="1" style="text-align: center;">
					<tr>
						<th>Id compra</th>
						<th>Id artículo</th>
						<th>Id cliente</th>
						<th>Fecha | Hora</th>
						<th>Cantidad</th>
						<th>Precio</th>


					</tr>

					<?php
					$sql = "SELECT * from compras ;";
					$resultado = mysqli_query($conexion, $sql);
					$filas = mysqli_num_rows($resultado);
					$count = 0;
					if ($filas > 0) {
						while ($registro = mysqli_fetch_row($resultado)) {
							$count++;
							if ($count % 2 == 0) {

					?>

								<tr>
									<td><?php echo $registro[0]; ?></td>
									<td><?php echo $registro[1]; ?></td>
									<td><?php echo $registro[2]; ?></td>
									<td><?php echo $registro[3]; ?></td>
									<td><?php echo $registro[4]; ?></td>
									<td><?php echo $registro[5]; ?>€</td>

								</tr>

							<?php
							} else {

							?>
								<tr class="odd">
									<td><?php echo $registro[0]; ?></td>
									<td><?php echo $registro[1]; ?></td>
									<td><?php echo $registro[2]; ?></td>
									<td><?php echo $registro[3]; ?></td>
									<td><?php echo $registro[4]; ?></td>
									<td><?php echo $registro[5]; ?>€</td>

								</tr>
					<?php
							}
						}
					} elseif ($filas == 0) {
						echo "<tr><td colspan='6'>No se han encontrado compras.</td></tr>";
					}


					?>

				</table>

			</div>

	<?php


		}
	}
	mysqli_close($conexion);
	?>
	</div>
</body>

</html>