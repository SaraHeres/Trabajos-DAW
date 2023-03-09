<?php

session_start();

$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['med'], $_SESSION['med'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Citas pendientes</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>
	<h1>Citas Pendientes</h1>
	
	<form action="" method="POST" name="miForm">
	<table border="1" style="text-align: center;">
		<tr>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Paciente</th>
			<th>Consultorio</th>
			<th>Atender</th>
		</tr>

		<?php

		$dni=$_SESSION['dni'];

		$consulta="SELECT citas.citFecha, citas.citHora, pacientes.pacNombres, pacientes.pacApellidos, consultorios.conNombre, pacientes.dniPac FROM citas, pacientes, consultorios WHERE citas.citMedico='$dni' AND citas.citEstado='Asignado' AND citas.citPaciente=pacientes.dniPac AND citas.citConsultorio=consultorios.idConsultorio;";
		$salida = mysqli_query ($conexion, $consulta);
		$filas=mysqli_num_rows($salida);

		if ($filas>0) {
			while ($array = mysqli_fetch_row($salida)) {
				
		?>

		<tr>
			<td>
				<?php
				echo ($array[0]); 
				?>
			</td>
			<td>
				<?php 
				echo ($array[1]); 
				?>
			</td>
			<td>
				<?php 
				echo ($array[2]." ".$array[3]); 
				?>
			</td>
			<td>
				<?php 
				echo ($array[4]); 
				?>
			</td>
			<td>
				<button type="submit" name="ac[]" value=
				<?php 
				echo ($array[5].",".$array[0].",".$array[1]); 
				?>
				>Atender</button></td>
		</tr>

		<?php

			}
		}
		else {
			echo "<tr><td colspan='5'>No hay citas pendientes</td></tr>";
		}

		?>

	</table>
	</form>
	<p>

	</p>

	<div>
		<form action="" method="POST">
			<button class="button" type="submit" name="back">Atrás</button>
			<button class="button" type="submit" name="cerrarsesion">Cerrar Sesión</button>
		</form>
	</div>

	<?php

	if (isset($_POST['ac'])) {
		foreach ($_POST['ac'] as $value) {
			$pac=explode(",", $value);
		}
		$_SESSION['atenderpaciente']=$pac;
		var_dump($_SESSION['atenderpaciente']);
		header("Location:atenderCita.php");
	}

	if (isset($_POST['back'])) {

		header("Location:inicio.php");

	}

	if (isset($_POST['cerrarsesion'])) {

		session_destroy();
			 
		header("Location:acceso.php");
	}

	mysqli_close($conexion);

	?>
</body>
</html>