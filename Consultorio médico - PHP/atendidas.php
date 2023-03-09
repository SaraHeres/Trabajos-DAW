<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Citas atendidas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>
	
	<?php

    //citas atendidas como medico

	if ($_SESSION['perfil']=='Medico') {

	?>
	
	<h1>Citas atendidas</h1>
	

	<?php	
		$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['med'], $_SESSION['med'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

	?>
	
	<table border="1" style="text-align: center;">
		<tr>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Paciente</th>
			<th>Consultorio</th>
			<th>Observaciones</th>
		</tr>

		<?php

		$dni=$_SESSION['dni'];

		$consulta="SELECT citas.citFecha, citas.citHora, pacientes.pacNombres, pacientes.pacApellidos, consultorios.conNombre, citas.citObservaciones FROM citas, pacientes, consultorios WHERE citas.citMedico='$dni' AND citas.citEstado='Atendido' AND citas.citPaciente=pacientes.dniPac AND citas.citConsultorio=consultorios.idConsultorio;";
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
		</tr>

		<?php

			}
		}
		else {
			echo "<tr><td colspan='5'>No hay ninguna cita atendida</td></tr>";
		}

		?>

	</table>

	<p>
		<?php
		echo(" <br> ")
		?>

	</p>

	<div>
		<form action="" method="POST">
			<button type="submit" name="back">Atrás</button>
			<button type="submit" name="cerrarsesion">Cerrar Sesión</button>
		</form>
	</div>

	<?php		

	}

    //citas atendidas como asistente

	if ($_SESSION['perfil']=='Asistente') {

	?>
	
	<h1>Pantalla de Citas Atendidas</h1>
	

	<?php	
		$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['asis'], $_SESSION['asis'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}
	?>
	
	<table border="1" style="text-align: center;">
		<tr>
			<th>Fecha</th>
			<th>Hora</th>
			<th>Paciente</th>
			<th>Médico</th>
			<th>Consultorio</th>
			<th>Observaciones</th>
		</tr>

		<?php

		$consulta="SELECT citas.citFecha,citas.citHora,pacientes.pacNombres,pacientes.pacApellidos,medicos.medNombres,medicos.medApellidos,consultorios.conNombre,citas.citObservaciones FROM citas,pacientes,medicos,consultorios WHERE citas.citEstado='Atendido' AND citas.citPaciente=pacientes.dniPac AND citas.citMedico=medicos.dniMed AND citas.citConsultorio=consultorios.idConsultorio;";
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
				echo ($array[4]." ".$array[5]); 
				?>
			</td>
			<td>
				<?php 
				echo ($array[6]); 
				?>
			</td>
			<td>
				<?php 
				echo ($array[7]); 
				?>
			</td>
		</tr>	

		<?php

			}
		}
		else {
			echo "<tr><td colspan='6'>No hay ninguna cita atendida</td></tr>";
		}

		?>

	</table>
	
	<div>
		<form action="" method="POST">
			<button type="submit" name="back">Atrás</button>
			<button type="submit" name="cerrarsesion">Cerrar Sesión</button>
		</form>
	</div>

	<?php	

	}

	if (isset($_POST['back'])) {

		header("Location:inicio.php");

	}

	if (isset($_POST['cerrarsesion'])) {

		session_destroy();
			 
		header("Location:acceso.php");
	}
	//mysqli_close($conexion);
	?>
</body>
</html>