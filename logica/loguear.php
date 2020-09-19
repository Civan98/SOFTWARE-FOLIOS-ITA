<?php
    require 'conexion.php';
    session_start();

    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    $q = "SELECT COUNT(*) as contar from usuarios where nombreUsuario = '$usuario ' and contrasena = '$clave ' ";
    $consulta = mysqli_query($conexion,$q);
    $array = mysqli_fetch_array($consulta);

    if($array['contar']>0){
        $_SESSION['username']= $usuario;
        header("location: ../control.php");
    }else{
        
       // print_r($array);
        echo "<script language='javascript'> alert('Datos incorrectos');  window.location.href='../index.php';</script>";
        //header("location: ../signup.php");
    }
?>