<?php

session_start();
$_SESSION['servidor']='localhost';
$_SESSION['basedatos']='consultas';
$_SESSION['admin']='administrador';
$_SESSION['admin']='administrador';
$_SESSION['med']='medico';
$_SESSION['med']='medico';
$_SESSION['asis']='asistente';
$_SESSION['asis']='asistente';
$_SESSION['pac']='paciente';
$_SESSION['pac']='paciente';

?> 

<!DOCTYPE html>
<html>
<head>
	<title>Inicio <?php echo $_SESSION['rol']; ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body class="body">

	<?php

    //usuario = administrador

	if (isset($_SESSION['dni']) && isset($_SESSION['perfil'])) {

		if ($_SESSION['perfil']=="Administrador") {
			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['admin'], $_SESSION['admin'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

	?>
	
	<h1>Terminal de Administración</h1>
	<form action="" method="POST">
		<fieldset>
			
			<p><button type="submit" name="altapaciente">Alta Paciente</button></p>
			<p><button type="submit" name="altamedico">Alta Médico</button></p>
			<p><button type="submit" name="cerrarsesion">Cerrar Sesión</button></p>
		</fieldset>
	</form>

	<?php

			if (isset($_POST['altapaciente'])) {

				header("Location:altaPac.php");

			}

			if (isset($_POST['altamedico'])) {

				header("Location:altaMed.php");

			}

			if (isset($_POST['cerrarsesion'])) {

				session_destroy();
		 
				header("Location:acceso.php");
			}		

		}

        //usuario: medico

		if ($_SESSION['perfil']=='Medico') {
			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['med'], $_SESSION['med'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

			$consulta="SELECT medNombres,medApellidos FROM medicos WHERE dniMed='".$_SESSION['dni']."';";
			$resultado = mysqli_query ($conexion, $consulta);

	?>
	
	<h1>Terminal de medico</h1>

	<form action="" method="POST">
		<fieldset>
			<p><button type="submit" name="citasatendidas">Ver Citas Atendidas</button></p>
			<p><button type="submit" name="citaspendientes">Ver Citas Pendientes</button></p>
			<p><button type="submit" name="listapacientes">Ver Pacientes</button></p>
			<p><button type="submit" name="cerrarsesion">Cerrar Sesión</button></p>
		</fieldset>
	</form>	

	<?php

			if (isset($_POST['citasatendidas'])) {

				header("Location:atendidas.php");

			}

			if (isset($_POST['citaspendientes'])) {

				header("Location:pendientes.php");

			}

			if (isset($_POST['listapacientes'])) {

				header("Location:pacientes.php");

			}

			if (isset($_POST['cerrarsesion'])) {

					session_destroy();
			 
					header("Location:acceso.php");
			}	

		}

        //usuario : asistente

		if ($_SESSION['perfil']=='Asistente') {
			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['asis'], $_SESSION['asis'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

	?>
	
	<h1>Terminal de Asistente</h1>
	<form action="" method="POST">
		<fieldset>
			<p><button type="submit" name="citasatendidas">Ver Citas Atendidas</button></p>
			<p><button type="submit" name="nuevacita">Nueva Cita</button></p>
			<p><button type="submit" name="altapaciente">Alta Paciente</button></p>
			<p><button type="submit" name="verpacientes">Ver Pacientes</button></p>
			<p><button type="submit" name="cerrarsesion">Cerrar Sesión</button></p>
		</fieldset>
	</form>	

	<?php

			if (isset($_POST['citasatendidas'])) {

				header("Location:atendidas.php");

			}

			if (isset($_POST['nuevacita'])) {

				header("Location:agregarCita.php");

			}

			if (isset($_POST['altapaciente'])) {

				header("Location:altaPac.php");

			}

			if (isset($_POST['verpacientes'])) {

				header("Location:pacientes.php");

			}

			if (isset($_POST['cerrarsesion'])) {

					session_destroy();
			 
					header("Location:acceso.php");
			}

		}

        //usuario: paciente

		if ($_SESSION['perfil']=='Paciente') {
			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['pac'], $_SESSION['pac'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

			$consulta="SELECT pacNombres,pacApellidos FROM pacientes WHERE dniPac='".$_SESSION['dni']."';";
			$resultado = mysqli_query ($conexion, $consulta);

	?>

	<h1>Terminal de paciente</h1>
	<form action="" method="POST">
		<fieldset>
			<h3>Opciones</h3>
			<p><button type="submit" name="listacitas">Ver todas las citas</button></p>
			<p><button type="submit" name="cerrarsesion">Cerrar Sesión</button></p>
		</fieldset>
	</form>	

	<?php

			if (isset($_POST['listacitas'])) {

				header("Location:listaCitas.php");

			}

			if (isset($_POST['cerrarsesion'])) {

					session_destroy();
			 
					header("Location:acceso.php");
			}

		}
	}
	mysqli_close($conexion);
	?>
</body>
</html>