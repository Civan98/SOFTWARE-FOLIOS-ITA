<?php
require 'logica/conexion.php';
session_start();

$usuario = $_SESSION['username'];
if (!isset($usuario)) {
    session_destroy();
    header("location: index.php");
} else {

    $nombre        = $_POST['nombre'];
    $Apellidos     = $_POST['Apellidos'];
    $NombreUsuario = $_POST['NombreUsuario'];
    $cargo         = $_POST['cargo'];
    $departamento  = $_POST['departamento'];
    $administrador = $_POST['administrador'];
    $password      = $_POST['password'];
    $passwordretry = $_POST['passwordretry'];
    $autoAutorizar = $_POST['autorizarauto'];

    if ($password === $passwordretry) {
        $nomDepto = $departamento;

        $buscarUsuario = "SELECT nombreUsuario FROM usuarios WHERE nombreUsuario ='$NombreUsuario'";
        $buscar        = mysqli_query($conexion, $buscarUsuario);
        $user          = mysqli_num_rows($buscar);
        if ($user == 0) {

            $selecDepto = "SELECT * FROM departamentos WHERE nombre_departamentos ='$nomDepto'";
            $ejecutar   = mysqli_query($conexion, $selecDepto);
            $depto      = mysqli_fetch_array($ejecutar);
            $id         = $depto['id_depto'];

            $insertar = "INSERT INTO usuarios (nombre, apellidos, nombreUsuario, cargo, contrasena, id_depto, admin, autoAutorizar) VALUES ('$nombre', '$Apellidos', '$NombreUsuario','$cargo','$password', '$id','$administrador', 1)";
            $exec     = mysqli_query($conexion, $insertar);
            if (!$exec) {
                echo "error" . mysqli_error($conexion);
            } else {
                echo "<script language='javascript'> alert('Usuario creado con éxito');  window.location.href='register.php';</script>";
            }
        } else {
            echo "<script language='javascript'> alert('Ya existe un usuario con ese nombre de usuario');  window.location.href='register.php';</script>";
        }

    } else {
        echo "<script language='javascript'> alert('La contraseña no coincide!!!');  window.location.href='register.php';</script>";
    }
}
