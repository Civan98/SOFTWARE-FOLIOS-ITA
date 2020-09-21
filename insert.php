<?php
    require 'logica/conexion.php';
    session_start();

    $nombre = $_POST['nombre'];
    $Apellidos = $_POST['Apellidos'];
    $NombreUsuario = $_POST['NombreUsuario'];
    $cargo = $_POST['cargo'];
    $departamento = $_POST['departamento'];
    $password = $_POST['password'];
    $passwordretry = $_POST['passwordretry'];

    //Falta el condicional para asignar los departamentos
    if($password === $passwordretry){

        if($departamento == "ISC"){
            $id_depto =1;
        }
        if($departamento == "LA"){
            $id_depto =2;
        }
        if($departamento == "IGE"){
            $id_depto =3;
        }

        $insertar = "INSERT INTO usuarios (nombre, apellidos, nombreUsuario, cargo, contrasena, id_depto) VALUES ('$nombre', '$Apellidos', '$NombreUsuario','$cargo','$password', '$id_depto')";
        $exec = mysqli_query($conexion, $insertar);
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            header("location: /generador-de-folios/index.php");
        }

    }else{
        echo "<script language='javascript'> alert('La contraseña no coincide!!!');  window.location.href='/generador-de-folios/register.php';</script>";
    }

?>