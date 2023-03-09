<?php
session_start();

if (isset($_POST["agregar"])) {
    $contador = $_POST["agregar"];
    $_SESSION["cantidad"][$contador]++;
}
if (isset($_POST["quitar"])) {
    if ($_SESSION["cantidad"][$_POST["quitar"]] > 0) {
        $contador = $_POST["quitar"];
        $_SESSION["cantidad"][$contador]--;
    }
}
header("location:verProd.php");

if (isset($_POST["agregar"])) {
    $producto = $_POST["agregar"];
    $_SESSION['productos'][$producto]++;
}
if (isset($_POST['quitar'])) {
    if ($_SESSION['productos'][$_POST['quitar']] > 0) {
        $producto = $_POST['quitar'];
        $_SESSION['productos'][$producto]--;
    }
}
header("location:verProd.php");
