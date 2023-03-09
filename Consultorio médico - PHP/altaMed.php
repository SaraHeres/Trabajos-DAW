<?php

session_start();

?>

<?php

	if (isset($_POST['insertar'])) {

		$dni=$_POST['dni'];
		$nombre=$_POST['nombre'];
		$apellido=$_POST['apellido'];
		$especialidad=$_POST['especialidad'];
		$telefono=$_POST['telefono'];
		$correo=$_POST['correo'];
		$usuario=$_POST['usuario'];
		$contra=$_POST['contra'];

		if ($_SESSION['perfil']=='Administrador') {

			$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['admin'], $_SESSION['admin'], $_SESSION['basedatos']);
			if (mysqli_connect_errno()) {
	    		printf("Conexión fallida %s\n", mysqli_connect_error());
	    		exit();
			}

			$consulta="INSERT INTO medicos (dniMed,medNombres,medApellidos,medEspecialidad,medTelefono,medCorreo) VALUES ('$dni','$nombre','$apellido','$especialidad','$telefono','$correo');";
			$consulta2="INSERT INTO usuarios (dniUsu,usuLogin,usuPassword,usuEstado,usutipo) VALUES ('$dni','$usuario','$contra','Activo','Medico');";


			if (mysqli_query($conexion, $consulta) && mysqli_query($conexion, $consulta2)) {
			 	echo "<p> Se ha registrado el médico con éxito</p>";
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
	<title>Alta médico</title>
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
		<h3>Registro de médicos</h3>
			<p>DNI: <input type="text" name="dni" id="dni" required="required" onblur="valdni()" maxlength="10"><span id="avisodni"></span></p>
			<p>Nombre: <input type="text" name="nombre" required="required" maxlength="50"></p>
			<p>Apellidos: <input type="text" name="apellido" required="required" maxlength="50"></p>
			<p>Especialidad: <input type="text" name="especialidad" required="required" maxlength="50"></p>
			<p>Teléfono: <input type="text" name="telefono" id="telefono" required="required" maxlength="15" onblur="valtlf()"><span id="avisotlf"></span></p>
			<p>Email: <input type="text" name="correo" id="correo" required="required" maxlength="50" onblur="valmail()"><span id="avisomail"></span></p>
			<p>Usuario: <input type="text" name="usuario" required="required" maxlength="15"></p>
			<p>Contraseña: <input type="password" name="contra" required="required" maxlength="157"></p>
			<p>Repita la contraseña: <input type="password" name="rpass" id="rpasswd" required="required" maxlength="157" onblur="valpass()"><span id="avisopass"></span></p>
			<p>Estado: <select name="estado" required="required">
				<option value="Activo">Activo</option>
				<option value="Inactivo">Inactivo</option>
			</select></p>
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

		     //validacion del formulario
		
			 function validar() {
        if (valdni() && valtlf() && valmail() && valpass()) {
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

    function valtlf() {
        var regexptlf = /^[56789]\d{8}/
        var tlf = document.altaForm.tlf.value;
        if (tlf.match(regexptlf)) {
            document.getElementById('tlf').style.border="3px solid green";
            document.getElementById('avisotlf').innerHTML=" &check; Teléfono correcto";
            return true;
        }
        else {
            document.getElementById('tlf').style.border="3px solid red";
              document.getElementById('avisotlf').innerHTML=" &cross; Teléfono no válido";
            return false;
        }
    }

    function valmail() {
        var regexpmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
        var mail = document.altaForm.mail.value;
        if (mail.match(regexpmail)) {
            document.getElementById('mail').style.border="3px solid green";
            document.getElementById('avisomail').innerHTML=" &check; Email correcto";
            return true;
        }
        else {
            document.getElementById('mail').style.border="3px solid red";
            document.getElementById('avisomail').innerHTML=" &cross; Email incorrecto";
            return false;
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