<?php

session_start();

$conexion=mysqli_connect($_SESSION['servidor'], $_SESSION['asis'], $_SESSION['asis'], $_SESSION['basedatos']);
	if (mysqli_connect_errno()) {
	    printf("Conexión fallida %s\n", mysqli_connect_error());
	    exit();
	}


	if (isset($_POST['insertar'])) {
		$paciente=$_POST['paciente'];
		$fechacita=$_POST['fechacita'];
		$horacita=$_POST['horacita'];
		$medico=$_POST['medico'];
		$consultorio=$_POST['consultorio'];

		if ($_SESSION['perfil']=='Asistente') {

			$consulta="INSERT INTO citas (idCita,citFecha,citHora,citPaciente,citMedico,citConsultorio,citEstado,citObservaciones) VALUES ('','$fechacita','$horacita','$paciente','$medico','$consultorio','Asignado','');";
			if (mysqli_query($conexion, $consulta)) {
			 	echo "<p>Cita registrada</p>";
			}
			else {
				echo " <br> Error: " . $consulta . "<br>" . mysqli_error($conexion);
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Nueva cita</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css.css">
</head>
<header>
	<h1>Clínica Pediátrica Sana Sana Culito de Rana</h1>


</header>
<body>
	<h1>Terminal de Asistente</h1>
	
	
	<form action="" method="POST" name="ncForm" onsubmit="return validar()">
		<fieldset>
		<h3>Asignar cita a paciente</h3>
			
			<p>Paciente: <select name="paciente" required="required" onblur="valselp()" id="selp">
				<option value="vacio">Seleccione</option>
				<?php

				$consulta="SELECT pacNombres,pacApellidos,dniPac FROM pacientes;";
				$salida = mysqli_query ($conexion, $consulta);
				while ($array = mysqli_fetch_row($salida)) {

				?>

				<option value=
				<?php
				 echo $array[2] 
				 
				 ?>
				 >
				 <?php echo $array[0]." ".$array[1]; 
				 
				 ?>
				 
				</option>

				<?php

				}

				?>
			</select><span id="avisoselectp"></span></p>
			<p>Fecha: <input type="date" name="fechacita" id="fechacita" required="required" onblur="valfc()"><span id="avisofecha"></span></p>
			<p>Hora: <input type="time" name="horacita" id="horacita" required="required" onblur="valhc()"><span id="avisohora"></span></p>
			<p>Médico: <select name="medico" required="required" onblur="valselm()" id="selm">
				<option value="vacio">Seleccione</option>
				<?php

				$consulta2="SELECT medNombres,medApellidos,dniMed FROM medicos;";
				$salida2 = mysqli_query($conexion, $consulta2);
				while ($array = mysqli_fetch_row($salida2)) {

				?>

				<option value=
				<?php 
				echo ($array[2]); 
				
				?>
				
				>
				<?php 
				
				echo ($array[0]." ".$array[1]); 
				
				?>
				</option>

				<?php

				}

				?>
			</select><span id="avisoselectm"></span></p>
			<p>Consultorio: <select name="consultorio" required="required" onblur="valselc()" id="selc">
				<option value="vacio">Seleccione</option>
				<?php

				$consulta3="SELECT idConsultorio,conNombre FROM consultorios;";
				$salida3 = mysqli_query($conexion, $consulta3);
				while ($array = mysqli_fetch_row($salida3)) {

				?>

				<option value=
				
				<?php
				
				echo ($array[0]); 
				
				?>
				>
				<?php
				
				echo ($array[0]." - ".$array[1]); 
				
				?>
				
			</option>

				<?php

				}

				?>
			</select><span id="avisoselectc"></span></p>
			<p><input type="submit" name="insertar" value="Asignar cita"></p>
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

	<?php

	

	if (isset($_POST['back'])) {

		header("Location:inicio.php");

	}

	if (isset($_POST['cerrarsesion'])) {

		session_destroy();
			 
		header("Location:acceso.php");
	}

	?>

	<script>
		        //validacion de formulario

				function validar() {
			if (valselp() && valfc() && valhc() && valselm() && valselc()) {
				return true;
			}
			else {
				alert ("Datos erróneos, indtroducir de nuevo");
				return false;
			}
		}

		function valfc() {
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

			var fecha = document.ncForm.fechacit.value;

			var cf=fecha.localeCompare(today);

			if (cf==1 || cf==0) {
				document.getElementById('fc').style.border="3px solid green";
				document.getElementById('avisofecha').innerHTML=" &check; Fecha correcta";
				return true;
			}
			else {
				document.getElementById('fc').style.border="3px solid red";
				document.getElementById('avisofecha').innerHTML=" &cross; Fecha incorrecta (No puede ser una fecha anterior a la de hoy)";
				return false;
			}
		}

		function valhc() {
			var liminf = "08:00";
			var limsup = "15:00";

			var hora = document.ncForm.horacit.value;

			var chi = hora.localeCompare(liminf);
			var chs = hora.localeCompare(limsup);

			if ( (chi==1 || chi==0) && (chs==-1 || chs==0)) {
				document.getElementById('hc').style.border="3px solid green";
				document.getElementById('avisohora').innerHTML=" &check; Hora correcta";
				return true;
			}
			else {
				document.getElementById('hc').style.border="3px solid red";
				document.getElementById('avisohora').innerHTML=" &cross; Hora incorrecta (Horario de 08:00 a 15:00)";
				return false;
			}
		}

		function valselp() {
			var sp = document.ncForm.pac.value;

			if (sp=="vacio") {
				document.getElementById('selp').style.border="3px solid red";
				document.getElementById('avisoselectp').innerHTML=" &cross; Ha de seleccionar alguna opción";
				return false;
			}
			else {
				document.getElementById('selp').style.border="3px solid green";
				document.getElementById('avisoselectp').innerHTML=" &check; Opción válida";
				return true;
			}
		}

		function valselm() {
			var sm = document.ncForm.med.value;

			if (sm=="vacio") {
				document.getElementById('selm').style.border="3px solid red";
				document.getElementById('avisoselectm').innerHTML=" &cross; Ha de seleccionar alguna opción";
				return false;
			}
			else {
				document.getElementById('selm').style.border="3px solid green";
				document.getElementById('avisoselectm').innerHTML=" &check; Opción válida";
				return true;
			}
		}

		function valselc() {
			var sc = document.ncForm.cons.value;

			if (sc=="vacio") {
				document.getElementById('selc').style.border="3px solid red";
				document.getElementById('avisoselectc').innerHTML=" &cross; Ha de seleccionar alguna opción";
				return false;
			}
			else {
				document.getElementById('selc').style.border="3px solid green";
				document.getElementById('avisoselectc').innerHTML=" &check; Opción válida";
				return true;
			}
		}



	</script>
</body>
</html>


<br><br><br>
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            
                                            <th width="18%">imagen</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									require_once 'DBconect.php';
									$select_stmt=$db->prepare("SELECT ruta FROM imagenes");
                                    //forEach
                                    //<img src="$select_stmt">
									$select_stmt->execute();
									
									while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
									{
									?>
                                        <tr>
                                            
                                            <td><?php echo $row["ruta"]; ?></td>
                                            
                                            
				
                                        </tr>
									<?php 
									}
									?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div> 