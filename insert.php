<?php
require 'logica/conexion.php';
session_start();

$nombre        = $_POST['nombre'];
$Apellidos     = $_POST['Apellidos'];
$NombreUsuario = $_POST['NombreUsuario'];
$cargo         = $_POST['cargo'];
$departamento  = $_POST['departamento'];
$password      = $_POST['password'];
$passwordretry = $_POST['passwordretry'];

//Falta el condicional para asignar los departamentos
if ($password === $passwordretry) {

    /* if($departamento == "ISC"){
    $nomDepto ="Ingeniería en Sistemas Computacionales";
    }
    if($departamento == "LA"){
    $nomDepto ="Licenciatura en Administración";
    }
    if($departamento == "IGE"){
    $nomDepto ="Ingeniería en Gestión Empresarial";
    }
    if($departamento == "Dirección"){
    $nomDepto ="Dirección";
    }
    if($departamento == "Subdirección"){
    $nomDepto ="Subdirección";
    }*/
    $nomDepto = $departamento;

    $buscarUsuario = "SELECT nombreUsuario FROM usuarios WHERE nombreUsuario ='$NombreUsuario'";
    $buscar        = mysqli_query($conexion, $buscarUsuario);
    $user          = mysqli_num_rows($buscar);
    if ($user == 0) {

        $selecDepto = "SELECT * FROM departamentos WHERE nombre_departamentos ='$nomDepto'";
        $ejecutar   = mysqli_query($conexion, $selecDepto);
        $depto      = mysqli_fetch_array($ejecutar);
        $id         = $depto['id_depto'];

        $insertar = "INSERT INTO usuarios (nombre, apellidos, nombreUsuario, cargo, contrasena, id_depto) VALUES ('$nombre', '$Apellidos', '$NombreUsuario','$cargo','$password', '$id')";
        $exec     = mysqli_query($conexion, $insertar);
        if (!$exec) {
            echo "error" . mysqli_error($conexion);
        } else {
            echo "<script language='javascript'> alert('Usuario creado con éxito');  window.location.href='index.php';</script>";
        }
    } else {
        echo "<script language='javascript'> alert('Ya existe un usuario con ese nombre de usuario');  window.location.href='register.php';</script>";
    }

} else {
    echo "<script language='javascript'> alert('La contraseña no coincide!!!');  window.location.href='register.php';</script>";
}
