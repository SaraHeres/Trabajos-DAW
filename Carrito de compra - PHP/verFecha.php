<?php
session_start();
$hoy = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ver compras por fecha</title>
    <link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
        }

        body {
            background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);
            background-size: cover;
            font-family: 'Poppins', sans-serif;
            padding: 15px;

        }

        .btn {
            background: #f4f4f4;
            width: 40px;
            color: black;
            border-radius: 4px;
            border: 1px solid #f4f4f4;
            font-weight: 800;
            font-size: 0.9em;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .btn:hover {
            background: white;
        }

        h2 {
            color: white;
        }

        input {
            border-radius: 4%;
            font-family: 'Heebo', sans-serif;
            font-weight: 800;
            background-color: #f4f4f4;
            width: 30%;
            height: 35px;
            border: 2px solid #f4f4f4;
            padding: 5px;
            font-size: 12px;
        }

        input:hover {
            background-color: white;
            border: 2px solid black;

        }

        .in::placeholder {
            transition: transform .5s;
            transition: font-size .5s;
        }

        .in:hover::placeholder {
            transform: translateY(-80%);
            font-size: 10px;
        }

        #formi {

            height: 8em;
            width: 50em;
            font-weight: 800;
            color: whitesmoke;


        }

        .hijo {
            display: flex;
            justify-content: center;
        }

        .btn {
            background: #ede6e6;
            width: 125px;
            color: black;
            border-radius: 4px;
            border: 1px solid #ede6e6;
            font-weight: 800;
            font-size: 0.9em;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .btn:hover {
            background: white;
        }

        .btnlu {
            cursor: pointer;
            border: none;
            background-color: rgba(0, 0, 0, 0);


        }

        table {
            width: 50%;
            font-family: 'Poppins', sans-serif;
            background-color: rgba(255, 255, 255, .6);
            border-collapse: collapse;
            border: none;
            text-align: center;

        }

        td {
            padding: 10px;
            border-left: none;
            border-right: none;
        }

        th {
            padding: 20px;
            border: none;
        }

        .odd {
            background-color: rgba(0, 0, 0, .2);
        }

        tr {
            border-top: 1px solid white;
            border-bottom: 1px solid white;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST['back'])) {
        header('location:inicio.php');
    }
    if (isset($_POST['logout'])) {

        session_destroy();

        header("Location:login.php");
    }
    $id = $_SESSION['idusuario'];
    if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {

        if ($_SESSION['rol'] == "gestor") {
            $conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
            if (mysqli_connect_errno()) {
                printf("Conexión fallida %s\n", mysqli_connect_error());
                exit();
            }
    ?>
            <h2 align="center">FILTRAR COMPRAS POR FECHA</h2>
            <form action="#" method="POST">
                <button class="btn" type="submit" name="back" id="back">Volver</button>
                <button class="btn" type="submit" name="logout">Cerrar Sesión</button>

            </form>
            <div class='padre'>
                <div class="hijo">


                    <form align="center" action="#" method="POST" id="formi">

                        Desde: <input class="in" type="date" name="fech1" id="fech1" max="<?php echo $hoy ?>" required="required">

                        Hasta: <input class="in" type="date" name="fech2" id="fech2" max="<?php echo $hoy ?>" required="required">

                        <button class="btnlu" type="submit" name="search" id="search"><img width="25px" src="imagenes/lupa.png"></button>
                    </form>

                </div>

                <?php

                if (isset($_POST['search'])) {
                    $conexion = mysqli_connect('localhost', 'gestor', '', 'carrito');
                    $f1 = $_POST['fech1'] . " 00:00:00";
                    $f2 = $_POST['fech2'] . " 23:59:59";

                    if ($f2 < $f1) {
                        echo "<h2 align='center'>La segunda fecha no puede ser menor a la primera</h2>";
                    } else {
                        $listado = "SELECT * from compras where  fecha between '$f1' and '$f2'  order by fecha asc";
                        $result = mysqli_query($conexion, $listado);
                        if ($result) {
                            $count = 0;
                            if (mysqli_num_rows($result) > 0) { ?>
                                <div class="hijo"> <br><br><br>
                                    <table>
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Cliente</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Fecha | Hora</th>
                                        </tr><?php
                                                while ($registro = mysqli_fetch_row($result)) {
                                                    $count++;
                                                    if ($count % 2 == 0) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $registro[1]; ?></td>
                                                    <td><?php echo $registro[2]; ?></td>
                                                    <td><?php echo $registro[5]; ?>€</td>
                                                    <td><?php echo $registro[4]; ?></td>
                                                    <td><?php echo $registro[3]; ?></td>
                                                </tr>

                                            <?php
                                                    } else {

                                            ?>
                                                <tr class="odd">
                                                    <td><?php echo $registro[1]; ?></td>
                                                    <td><?php echo $registro[2]; ?></td>
                                                    <td><?php echo $registro[5]; ?>€</td>
                                                    <td><?php echo $registro[4]; ?></td>
                                                    <td><?php echo $registro[3]; ?></td>
                                                </tr>
                        <?php
                                                    }
                                                }
                                            } else {
                                                echo "<h2 align='center'>No hay compras en esas fechas.</h2>";
                                            }
                                        }
                                    }
                                }
                            }
                            if (isset($_POST['back'])) {
                                header('location:inicio.php');
                            }
                            if ($_SESSION['rol'] == "cliente") {
                                $conexion = mysqli_connect('localhost', 'cliente', '', 'carrito');
                                if (mysqli_connect_errno()) {
                                    printf("Conexión fallida %s\n", mysqli_connect_error());
                                    exit();
                                }
                        ?>
                        <h2 align="center">FILTRAR COMPRAS POR FECHA</h2>
                        <form action="#" method="POST">
                            <button class="btn" type="submit" name="back" id="back">Volver</button>
                            <button class="btn" type="submit" name="logout">Cerrar Sesión</button>


                        </form>
                        <div class='padre'>
                            <div class="hijo">
                                <form id="formi" action=" #" method="POST">

                                    Desde: <input class="in" type="date" name="fech1" id="fech1" max="<?php echo $hoy ?>" required="required">
                                    Hasta: <input class="in" type="date" name="fech2" id="fech2" max="<?php echo $hoy ?>" required="required">
                                    <button class="btnlu" type="submit" name="search" id="search"><img width="25px" src="imagenes/lupa.png"></button>
                                </form>

                            </div>

                            <?php

                                if (isset($_POST['search'])) {
                                    $conexion = mysqli_connect('localhost', 'cliente', '', 'carrito');
                                    $usu = $_SESSION['idusuario'];
                                    $f1 = $_POST['fech1'] . " 00:00:00";
                                    $f2 = $_POST['fech2'] . " 23:59:59";

                                    if ($f2 < $f1) {
                                        echo "<h2 align='center'>La segunda fecha no puede ser menor a la primera</h2>";
                                    } else {
                                        $listado = "SELECT * from compras where  fecha between '$f1' and '$f2' and idcliente='$usu' order by fecha asc";
                                        $count = 0;
                                        $result = mysqli_query($conexion, $listado);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) { ?>
                                            <div class="hijo">
                                                <table>
                                                    <tr>
                                                        <th>Articulo</th>
                                                        <th>Precio</th>
                                                        <th>Cantidad</th>
                                                        <th>Fecha | Hora</th>
                                                    </tr><?php
                                                            while ($registro = mysqli_fetch_row($result)) {
                                                                $count++;
                                                                if ($count % 2 == 0) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $registro[1]; ?></td>
                                                                <td><?php echo $registro[5]; ?>€</td>
                                                                <td><?php echo $registro[4]; ?></td>
                                                                <td><?php echo $registro[3]; ?></td>
                                                            </tr>

                                                        <?php
                                                                } else {
                                                        ?>
                                                            <tr class="odd">
                                                                <td><?php echo $registro[1]; ?></td>
                                                                <td><?php echo $registro[5]; ?>€</td>
                                                                <td><?php echo $registro[4]; ?></td>
                                                                <td><?php echo $registro[3]; ?></td>
                                                            </tr>
                            <?php
                                                                }
                                                            }
                                                        } else {
                                                            echo "<h2 align='center'>No hay compras en esas fechas.</h2>";
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                            ?>
                                                </table>
                                            </div>
                        </div>

</body>

</html>