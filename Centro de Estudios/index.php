<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>

<body>
    <form action="" method="post">
        Usuario:</br><input type="text" name="nombre" maxlength="12" required /></br></br>
        Password:</br><input type="text" name="contra" maxlength="12" required />

        <input type="submit" name="enviar" />
    </form>
 
    <?php
    $conexion = mysqli_connect("localhost", "pupilo", "pupilo", "instituto");
    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (isset($_POST["enviar"])) {
        $login = $_POST["nombre"];
        $clave = $_POST["contra"];
        $sql = "SELECT id,login,password,rol FROM usuarios WHERE login = '$login' AND password='$clave'";
        $resultado = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            while ($registro = mysqli_fetch_row($resultado)) {
                $idusu = $registro[0];
                $nombreusu = $registro[1];
                $rolusu = $registro[3];
                session_start();
                $_SESSION['idusu'] = "$idusu";
                $_SESSION['usuario'] = "$nombreusu";
                $_SESSION['roles'] = "$rolusu";
                if ($_SESSION['roles'] == "alumno") {
                    mysqli_close($conexion);
                    header("Location: alumno.php");
                } elseif ($_SESSION['roles'] == "director") {
                    mysqli_close($conexion);
                    header("Location: director.php");
                }
            }
        } else {
            echo "</br><b style='color:darkred';>*Login o clave incorrectas</b>";
        }
    }
    ?>
</body>

</html>