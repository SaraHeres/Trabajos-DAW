<?php

session_start();



	if (isset($_POST['insertar'])) {

		$dni=$_POST['dni'];
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$fechanacimiento=$_POST['fechanacimiento'];
		$sexo=$_POST['sexo'];
		$usuario=$_POST['usuario'];
		$contra=$_POST['contra'];

		
		if ($_SESSION['perfil']=='Asistente') {
			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['asis'], $_SESSION['asis'], $_SESSION['basedatos']);

			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

			//consultas SQL
			$consulta="INSERT INTO pacientes (dniPac,pacNombres,pacApellidos,pacFechaNacimiento,pacSexo) VALUES ('$dni','$nombre','$apellido','$fechanacimiento','$sexo');";

			$consulta2="INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$dni','$usuario','$contra','Activo','Paciente');";


			if (mysqli_query($conexion, $consulta) && mysqli_query($conexion, $consulta2)) {
			 	echo "<p> Se ha registrado el paciente con éxito</p>";
			}
			else {
				echo " <br> Error: " . $consulta . "<br>" . mysqli_error($conexion);
				echo " <br> Error: " . $consulta2 . "<br>" . mysqli_error($conexion);
			}
		}


		if ($_SESSION['perfil']=='Administrador') {

			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['admin'], $_SESSION['admin'], $_SESSION['basedatos']);

			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}


			//consultas SQL
			$consulta="INSERT INTO pacientes (dniPac,pacNombres,pacApellidos,pacFechaNacimiento,pacSexo) VALUES ('$dni','$nombre','$apellido','$fechanacimiento','$sexo');";

			$consulta2="INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$dni','$usuario','$contra','Activo','Paciente');";

			if (mysqli_query($conexion, $consulta) && mysqli_query($conexion, $consulta2)) {
			 	echo "<p> Se ha registrado el paciente con éxito</p>";
			}
			else {
				echo " <br> Error: " . $consulta . "<br>" . mysqli_error($conexion);
				echo " <br> Error: " . $consulta2 . "<br>" . mysqli_error($conexion);
			}
		}
		mysqli_close($conexion);
	}


	if (isset($_POST['back'])) {

		header("Location:inicio.php");

	}

	if (isset($_POST['cerrarsesion'])) {

		session_destroy();
			 
		header("Location:acceso.php");
	}

	?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Alta paciente</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>
	<h1>Terminal de Administración</h1>
	
	<form action="" method="POST" name="altaForm" onsubmit="return validar()">

		<fieldset>

			<h3>Insertar paciente</h3>
			<p>DNI: <input type="text" name="dni" id="dni" required="required" onblur="valdni()" maxlength="10"><span id="avisodni"></span></p>
			<p>Nombre: <input type="text" name="nombre" required="required" maxlength="50"></p>
			<p>Apellidos: <input type="text" name="apellido" required="required" maxlength="50"></p>
			<p>Fecha de Nacimiento: <input type="date" name="fechanacimiento" id="nacimiento" required="required" onblur="valfn()"><span id="avisofecha"></span></p>
			<p>Sexo: <select name="sexo" required="required">
				<option value="Femenino">Femenino</option>
				<option value="Masculino">Masculino</option>
			</select></p>

			<p>Usuario: <input type="text" name="usuario" required="required" maxlength="15"></p>
			<p>Contraseña: <input type="password" name="contra" required="required" maxlength="157"></p>
			<p>Repita la contraseña: <input type="password" name="rpass" id="rpasswd" required="required" maxlength="157" onblur="valpass()"><span id="avisopass"></span></p>
			<p><input type="submit" name="insertar" value="Dar de alta"></p>

		</fieldset>

	</form>
	<p>

	</p>

	<div>

		<form action="" method="POST">
			<button type="submit" name="back">Atrás</button>
			<button type="submit" name="cerrarsesion">Cerrar Sesión</button>
		</form>
	</div>


	

	<script>
		function validar() {
    if (valdni() && valfn() && valpass()) {
        return true;
    }
    else {
        alert ("Datos erróneos, indtroducir de nuevo");
        return false;
    }
}

function valdni() {
    var nif = document.altaForm.dni.value;
    var expresion_regular_dni
 
      expresion_regular_dni = /^\d{8}[a-zA-Z]$/;
 
      if (expresion_regular_dni.test (nif) == true) {
          document.getElementById('nif').style.border="3px solid green";
        document.getElementById('avisodni').innerHTML=" &check; DNI correcto";
        return true;
      }
      else {
          document.getElementById('nif').style.border="3px solid red";
          document.getElementById('avisodni').innerHTML=" &cross; DNI erróneo, formato no válido";
          return false;
       }	
}

function valfn() {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if (dd<10) {
        dd='0'+dd;
    }
    if (mm<10) {
        mm='0'+mm;
    }
    today = yyyy+"-"+mm+"-"+dd;

    var fecha = document.altaForm.fechanac.value;

    var cf=fecha.localeCompare(today);

    if (cf==1) {
        document.getElementById('nacimiento').style.border="3px solid red";
        document.getElementById('avisofecha').innerHTML=" &cross; Fecha incorrecta (ha de ser una fecha anterior a la de hoy)";
        return false;
    }

    else {
        document.getElementById('nacimiento').style.border="3px solid green";
        document.getElementById('avisofecha').innerHTML=" &check; Fecha correcta";
        return true;
    }
}

function valpass() {
    var contra=document.altaForm.pass.value;
    var rcontra=document.altaForm.rpass.value;

    if (contra===rcontra) {
        document.getElementById('rpasswd').style.border="3px solid green";
        document.getElementById('avisopass').innerHTML=" &check; Contraseña correcta";
        return true;
    }
    else {
        document.getElementById('rpasswd').style.border="3px solid red";
        document.getElementById('avisopass').innerHTML=" &cross; Contraseña incorrecta";
        return false;
    }
}


		
	</script>
</body>
</html>