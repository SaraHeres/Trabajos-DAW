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
    $contador = 0;
    $_SESSION['suspensas'] = $contador;
    ?>
    <p>Buenos dias <?php echo $_SESSION['usuario'] ?>, se ha validado como <?php echo $_SESSION['roles'] ?></p>
    <form action="" method="post">
        <input type="submit" name="cerrar" value="Cerrar sesion" />
        <input type="submit" name="consultar" value="Consultar notas" />
    </form>
    <?php

    if (isset($_POST["cerrar"])) {

        mysqli_close($conexion);
        session_destroy();
        header("Location: index.php");
    }
    if (isset($_POST["consultar"])) {
        //header("Location: consultar.php");
        $conexion = mysqli_connect("localhost", "pupilo", "pupilo", "instituto");
        if (!$conexion) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $idusu = $_SESSION['idusu'];
        $sql = "SELECT alumno,asignatura,fecha,nota FROM notas WHERE alumno='$idusu'";
        $resultado = mysqli_query($conexion, $sql);
        echo "<table border='1px solid black'>";
        echo "<tr><td>Asignatura</td>";
        echo "<td>Fecha</td>";
        echo "<td>Nota</td>";
        echo "<td>Estadística</td></tr>";

        if (mysqli_num_rows($resultado) > 0) {
            while ($registro = mysqli_fetch_row($resultado)) {

                echo "<tr>";
                echo "<td>" . $registro[1] . "</td>";
                echo "<td>" . $registro[2] . "</td>";
                echo "<td>" . $registro[3] . "</td>";
                echo "<td>" ?> <svg width="" height="">
                    <?php if ($registro[3] < 5) { ?>
                        <rect width="<?php
                                        echo  $registro[3] * 10; ?>" height="10" style="fill:#ff0000;" />
                </svg></td>
            <?php
                    } else { ?>
                <rect width="<?php
                                echo  $registro[3] * 10; ?>" height="10" style="fill:#18a31d;" />
                </svg></td>
            <?php
                    }
            ?>
<?php
                echo "</tr>";
                if ($registro[3] < 5) {
                    $_SESSION['suspensas']++;
                }
            }
        }
        echo "</table>";
        echo "Has suspendido " . $_SESSION['suspensas'] . " asignatura";
    }

?>

</body>

</html>