<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ej2</title>
</head>

<body>
    <?php
    session_start();
    $notam = 0;
    $total = 0;
    $alta = 0;
    $nota = 0;
    $baja = 11;
    $_SESSION["notamed"] = $notam;
    $_SESSION["total"] = $total;
    $_SESSION["masalta"] = $alta;
    $_SESSION["notas"] = $nota;
    $_SESSION["masbaja"] = $baja;
    ?>
    <p>Buenos dias <?php echo $_SESSION['usuario'] ?>, se ha validado como <?php echo $_SESSION['roles'] ?></p>
    <form action="" method="post">
        <input type="submit" name="cerrar" value="Cerrar sesion" />
        <input type="submit" name="consultar" value="Consultar notas" />
        <input type="submit" name="alta" value="Insertar alumno" />
    </form>
    <?php
    if (isset($_POST["alta"])) {
    ?>
        </br>
        <form action="" method="post">
            <p>Nombre <input type="text" name="nombre" required /></p>
            <p>Apellidos <input type="text" name="ape" required /></p>
            <p>Localidad <input type="text" name="loc" required /></p>
            <p>Contraseña <input type="password" name="con" required /></p>
            <p>Repetir Contraseña <input type="password" name="contra" required /></p>
            <input type="submit" name="dalt" value="Dar de alta" />
        </form>
    <?php
    }
    ?>
    <?php
    if (isset($_POST["consultar"])) {
    ?>
        </br>
        <form action="" method="post">
            <p>Asignatura <input type="text" name="asignatura" required /></p>

            <input type="submit" name="notas" value="Mostrar notas" />
        </form>
    <?php
    }
    if (isset($_POST["notas"])) {
        $asigna = $_POST["asignatura"];
        $conexion = mysqli_connect("localhost", "dirige", "", "instituto");
        $sql3 = "SELECT notas.alumno,notas.asignatura,notas.fecha,notas.nota,usuarios.nombre,usuarios.id FROM notas INNER JOIN usuarios ON notas.alumno=usuarios.id WHERE asignatura='$asigna'";
        $resultados = mysqli_query($conexion, $sql3);
        if (mysqli_num_rows($resultados) > 0) {
            echo "resultados de asignatura: " . $asigna;
            echo "<table border='1px solid black'>";
            echo "<tr>";
            echo "<td>nombre alumno</td>";
            echo "<td> id alumno </td>";
            echo "<td>fecha</td>";
            echo "<td>nota</td>";
            echo "</tr>";
            while ($registro = mysqli_fetch_row($resultados)) {
                echo "<tr>";
                echo "<td>" . $registro[4] . "</td>";
                echo "<td>" . $registro[0] . "</td>";
                echo "<td>" . $registro[2] . "</td>";
                echo "<td>" . $registro[3] . "</td>";
                echo "</tr>";
                $_SESSION["notamed"] += $registro[3];
                $_SESSION["total"]++;
                $_SESSION["notas"] = $registro[3];
                if ($_SESSION["notas"] > $_SESSION["masalta"]) {
                    $_SESSION["masalta"] = $_SESSION["notas"];
                }
                if ($_SESSION["notas"] < $_SESSION["masbaja"]) {
                    $_SESSION["masbaja"] = $_SESSION["notas"];
                }
            }
            echo "</table>";
            echo "la nota media es:" . $_SESSION["notamed"] / $_SESSION["total"] . "</br>";
            echo "la nota más alta es :" . $_SESSION["masalta"] . "</br>";
            echo "la nota mas baja es :" . $_SESSION["masbaja"] . "</br>";
            echo "el total de alumnos es :" . $_SESSION["total"];
        } else {
            echo "No hay ninguna materia con ese nombre";
        }
    }


    if (isset($_POST["dalt"])) {
        $nombre = $_POST["nombre"];
        $apellidos = $_POST["ape"];
        $localidad = $_POST["loc"];
        $contra = $_POST["con"];
        $confcontra = $_POST["contra"];
        $rol = "alumno";
        $login = $nombre;
        $conexion = mysqli_connect("localhost", "dirige", "", "instituto");
        $sql0 = "SELECT login,password FROM usuarios WHERE login='$login' AND password='$contra'";
        if ($contra == $confcontra) {
            $resultados = mysqli_query($conexion, $sql0);
            if (mysqli_num_rows($resultados) > 0) {
                echo "el usuario ya existe";
            } else {
                $sql = "INSERT INTO usuarios VALUES (null,'$nombre','$apellidos','$login','$contra','$rol','$localidad')";
                if (mysqli_query($conexion, $sql)) {
                    echo "<br> <p>Alumno añadido</p>";
                    echo var_dump($sql);
                } else {
                    echo "nada";
                }
            }
        } else {
            echo "las contraseñas no coinciden";
        }
        //if (!$conexion) {
        //  die("Connection failed: " . mysqli_connect_error());
        //}
    ?>
    <?php

    }


    if (isset($_POST["cerrar"])) {
        mysqli_close($conexion);
        session_destroy();
        header("Location: index.php");
    }

    ?>
</body>

</html>