<?php

session_start();

?>
<!DOCTYPE html>
<th lang="es">

  <head>
    <meta charset="UTF-8">
    <title>Productos carrito</title>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:800|Muli|Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Heebo:800&display=swap" rel="stylesheet">
    <style>
      #conten {
        display: flex;
        flex-flow: row-wrap;

      }

      #contenido {

        height: 600px;
        overflow: scroll;
        width: 55%;
        float: left;
        background: whitesmoke;
        justify-content: space-around;
        margin-top: 10px;
        margin-left: 60px
      }

      #contenido2 {
        height: 600px;
        overflow: scroll;
        width: 55%;
        background: whitesmoke;
        justify-content: space-around;
        margin-top: 10px;
        margin-left: 350px
      }

      #productos {
        display: block;
        width: 60%;

      }


      #producto {

        float: left;
        width: 18%;
        min-width: 100px;
        max-width: 200px;
        height: 200px;
        margin: 3% 3%;
        margin-bottom: 90px;
        font-size: 75%;

      }

      #producto img {
        width: 80px;
        height: auto;
        margin-bottom: 10px;
      }

      html,
      body {
        width: 100%;
        height: 100%;
      }

      body {
        background-image: linear-gradient(to right, #550a46, #4a69bb, #550a46);
        background-size: cover;
        font-family: 'Poppins', sans-serif;
        padding: 15px;
        height: 100%;

      }

      #producto h2 {
        margin-bottom: 8px;
        font-family: 'Poppins', sans-serif;

      }

      #producto p {
        margin-bottom: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;

      }

      #producto .boton {
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 8px;
        padding-right: 8px;
        font-size: 100%;
        background-color: #4a69bb;
        width: 125px;
        color: black;
        border-radius: 4px;
        border: 1px solid #f4f4f4;
        font-weight: 800;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
      }

      #producto .boton:hover {
        background: white;
        border: 1px solid black;
      }



      h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 34px;
        color: white;
        clear: both;
        text-transform: uppercase;

      }

      #car {

        clear: left;
        float: right;
        padding: 5px;
        width: 20%;
        margin-right: 20px;
        margin-left: 60px;
        background: rgba(255, 255, 255, .5);
        border: 2px solid white;
      }

      .btn {
        background: #f4f4f4;
        width: 125px;
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
    </style>
  </head>

  <body>
    <h1 align="center">Bienvenid@, <?php echo $_SESSION['usuario'] ?> (<?php echo $_SESSION['rol'] ?>) </h1>
    <form action="" method="POST">
      <button class="btn" type="submit" name="volver">Volver</button>
      <button class="btn" type="submit" name="logout">Cerrar Sesión</button>
    </form>
    <div id="conten">


      <?php
      if (isset($_POST['agregar'])) {

        header("Location:control.php");
      }
      if (isset($_POST['conf'])) {

        header("Location:confirmacion.php");
      }
      if (isset($_POST['volver'])) {
        header("Location:inicio.php");
      }

      if (isset($_POST['logout'])) {

        session_destroy();

        header("Location:login.php");
      }

      if ($_SESSION['rol'] == 'cliente') {
        $conexion = mysqli_connect("localhost", "cliente", "", "carrito");
        if (mysqli_connect_errno()) {
          printf("Conexión fallida %s\n", mysqli_connect_error());
          exit();
        }
        if (isset($_SESSION['cantidad']) == false) {
          $_SESSION['cantidad'] = ['1' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0, '9' => 0, '10' => 0];
        }
        if (isset($preciototal) == false) {
          $preciototal = 0;
        }

      ?>
        <section id="contenido">
          <form action="control.php" method="POST" id="catalogo">
            <table border="1" style="text-align: center;">

              <?php
              $contador = 1;
              $sql = "SELECT * FROM articulo;";
              $resultado = mysqli_query($conexion, $sql);
              if (mysqli_num_rows($resultado) > 0) {
                while ($registro = mysqli_fetch_row($resultado)) {
              ?>
                  <div id="producto" align="center">
                    <img src="<?php echo $registro[4]; ?>" />
                    <h2><?php echo $registro[1]; ?></h2>
                    <p><?php echo $registro[2]; ?></p>
                    <p>PRECIO: <?php echo $registro[3]; ?>€</p>

                    <button type="submit" class="boton" name="agregar" value="<?php echo $registro[0] ?>">Agregar</button>
                  </div>
                <?php
                }
                ?>
            </table>
          </form>
        </section>

      <?php
              } else {
                echo "No hay ningún artículo";
              }
      ?>
      <div id="car">
        <h1 class="carrito" align="center">Carrito</h1>
        <ul>
          <?php
          echo "<form action='control.php' method=POST>";
          foreach ($_SESSION["cantidad"] as $key => $valor) {
            if ($valor > 0) {
              $sql1 = "SELECT precio, nombreproducto from articulo where '$key'=articulo.idproducto";
              $resultado1 = mysqli_query($conexion, $sql1);
              $filas1 = mysqli_num_rows($resultado1);
              if ($filas1 > 0) {
                while ($registro1 = mysqli_fetch_row($resultado1)) {
                  echo '<li> ' . $valor . ' x ' .  $registro1[1] . ' ---- '  . ($valor * $registro1[0]) . '€<button class="btn" type="submit" name="quitar" value=' . $key . '>Quitar</button><br></li>  ';
                  $preciototal += ($valor * $registro1[0]);
                }
              }
            }
          }
          echo "Total: " . $preciototal . "€";
          echo "</form>";
          ?>
        </ul>

        <form align="center" action="confirmacion.php" method="POST">
          <button class="btn" type="submit" name="confirmar" value="Confirmar compra">Confirmar</button>
        </form>
      </div>
    <?php }
      if ($_SESSION['rol'] == 'gestor') {
        $conexion = mysqli_connect("localhost", "gestor", "", "carrito");
        if (mysqli_connect_errno()) {
          printf("Conexión fallida %s\n", mysqli_connect_error());
          exit();
        }
    ?>


      <section id="contenido2">
        <table border="1" style="text-align: center;">

          <?php
          $contador = 1;
          $sql = "SELECT * FROM articulo;";
          $resultado = mysqli_query($conexion, $sql);
          if (mysqli_num_rows($resultado) > 0) {
            while ($registro = mysqli_fetch_row($resultado)) {
          ?>
              <div id="producto" align="center">
                <img src="<?php echo $registro[4]; ?>" />
                <h2><?php echo $registro[1]; ?></h2>
                <p><?php echo $registro[2]; ?></p>
                <p>PRECIO: <?php echo $registro[3]; ?>€</p>


              </div>
            <?php
            }
            ?>
        </table>

      </section>
  <?php

          } else {
            echo "<tr><td colspan='4'>No hay ningún artículo</td></tr>";
          }
        }

  ?>

    </div>
  </body>

  </html>