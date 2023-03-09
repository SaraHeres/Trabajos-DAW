<?php

session_start();



//bloque de conexion

$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['med'], $_SESSION['med'], $_SESSION['basedatos']);

			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

$dni=$_SESSION['atenderpaciente'][0];
	



	if (isset($_POST['atender'])) {
		$observaciones=$_POST['observaciones'];
		$consulta="UPDATE citas SET citEstado='Atendido', CitObservaciones='$observaciones' WHERE citPaciente='$dni';";
		if (mysqli_query($conexion, $consulta)) {
			 	echo "<p> Se han registrado las observaciones con éxito</p>";
			}
		else {
			echo " <br> Error: " . $consulta . "<br>" . mysqli_error($conexion);
		}
	}

	if (isset($_POST['back'])) {

		header("Location:pendientes.php");

	}

	if (isset($_POST['cerrarsesion'])) {

		session_destroy();
			 
		header("Location:acceso.php");
	}

	//mysqli_close($conexion);

	?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Atender cita</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>

	<h1>Terminal de médico</h1>
	<h2>Atender cita </h2>
	
	<form action="" method="POST">
		<fieldset>
			<legend></legend>
			<table border="1" style="text-align: center;">
				<tr>
					<th>DNI paciente</th>
					<td>
						
					<?php				
					echo $dni; 
					?>
					
					</td>
				</tr>
				<tr>
					<th>Nombre paciente</th>
					<?php

					$consulta="SELECT pacNombres,pacApellidos FROM pacientes WHERE dniPac='$dni';";
					$salida = mysqli_query($conexion, $consulta);
					$array=mysqli_fetch_row($salida);


					?>
					<td>
						
					<?php
					
					echo $array[0]." ".$array[1];

					?>
					</td>
				</tr>
					<th>Observaciones</th>
					<td><textarea name="observaciones" placeholder="Escriba aquí las observaciones del paciente" style="box-sizing: border-box; width: 350px; height: 200px; resize: none; overflow: auto;" required="required"></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="atender" value="Enviar"></td>
				</tr>
			</table>
		</fieldset>
	</form>

	<div class="botones">
		<form action="" method="POST">
			<button type="submit" name="back">Atrás</button>
			<button type="submit" name="cerrarsesion">Cerrar Sesión</button>
		</form>
	</div>

	
</body>
</html>