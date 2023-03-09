<?php

session_start();

$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['pac'], $_SESSION['pac'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Citas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>
	<h1>Terminal de paciente</h1>
	
	<h3>Listado de citas</h3>
	<table border="1" style="text-align: center;">
		<tr>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Médico</th>
			<th>Consultorio</th>
			<th>Estado</th>
			<th>Observaciones</th>
		</tr>

		<?php

		$dni=$_SESSION['dni'];


		$consulta="SELECT citas.citFecha,citas.citHora,medicos.medNombres,medicos.medApellidos,consultorios.conNombre,citas.citEstado,citas.CitObservaciones FROM citas,medicos,consultorios WHERE citas.citPaciente='$dni' AND citas.citMedico=medicos.dniMed AND citas.citConsultorio=consultorios.idConsultorio;";
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
				<?php 
				echo ($array[5]); 
				?>
			</td>
			<td>
				<?php 
				echo ($array[6]); 
				?>
			</td>
		</tr>

		<?php

			}
		}
		else {
			echo "<tr><td colspan='6'>No tiene ninguna cita</td></tr>";
		}

		?>

	</table>
	<p>

	</p>

	<div>
		<form action="" method="POST">
			<button type="submit" name="back">Atrás</button>
			<button type="submit" name="cerrarsesion">Cerrar Sesión</button>
		</form>
	</div>

	<?php

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