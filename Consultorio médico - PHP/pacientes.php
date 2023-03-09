<?php

session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Listado de pacientes</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>

	<?php

    //usuario: medico

	if ($_SESSION['perfil']=='Medico') {

	?>

    

	<h1>Listado Pacientes</h1>
	
	
	<?php

		$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['med'], $_SESSION['med'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

	?>
	
	<table border="1" style="text-align: center;">
		<tr>
			<th>DNI</th>
			<th>Nombre</th>
			<th>Apellidos</th>
			<th>Fecha de nacimiento</th>
			<th>Sexo</th>
		</tr>

	<?php

	$dni = $_SESSION['dni'];

	$consulta="SELECT DISTINCT pacientes.* FROM pacientes,citas,medicos WHERE citas.citPaciente=pacientes.dniPac AND citas.citMedico='$dni';";

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
				echo ($array[2]); 
				?>
			</td>
			<td>
				<?php 
				echo $array[3]; 
				?>
			</td>
			<td>
				<?php 
				echo ($array[4]); 
				?>
			</td>
		</tr>

		<?php

			}
		}
		else {
			echo "<tr><td colspan='5'>No tiene ningún paciente</td></tr>";
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

	}
    //usuario: asistente

	if ($_SESSION['perfil']=='Asistente') {

	?>
	
	<h1>Listado Pacientes</h1>
	

	<?php	
		$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['asis'], $_SESSION['asis'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}
	?>
	
	<table border="1" style="text-align: center;">
		<tr>
			<th>DNI</th>
			<th>Nombre</th>
			<th>Apellidos</th>
			<th>Fecha de nacimiento</th>
			<th>Sexo</th>
		</tr>

		<?php

		$consulta="SELECT * FROM pacientes;";
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
				echo ($array[2]); 
				?>
			</td>
			<td>
				<?php 
				echo $array[3]; 
				?>
			</td>
			<td>
				<?php 
				echo ($array[4]); 
				?>
			</td>
		</tr>

		<?php

			}
		}
		else {
			echo "<tr><td colspan='5'>No hay pacientes en el registro</td></tr>";
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