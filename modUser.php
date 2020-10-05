<?php
        $nombre           = $_POST['nombre'];
        $apellidos        = $_POST['apellidos'];
        $nombreUsuario    = $_POST['nombreUsuario'];
        $cargo            = $_POST['cargo'];
        $contrasena       = $_POST['contrasena'];
        $nombre_departamento = $_POST['nombre_departamento'];
        $admin            = $_POST['admin'];

       // echo $nombre.$apellidos.$nombreUsuario.$cargo.$contrasena.$nombre_departamento.$admin

 
        require 'logica/conexion.php';
        session_start();
        $usuario = $_SESSION['username'];
        if(!$conexion){
            echo "Falla en la conexión";
        }else{
            $bd = mysqli_select_db($conexion, 'bdgeneradorfolios');
            if(!$bd){
                echo "no se encontró la base de datos";
            }
        }

        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];    
    
        $buscarDeptoAS = mysqli_query($conexion, "SELECT id_depto FROM departamentos WHERE nombre_departamentos = '$nombre_departamento'");
        if(!$buscarDeptoAS){
            echo "error: ".mysqli_error($conexion);
        }
        $depa= "";
        foreach($buscarDeptoAS as $DaS){
            $depa = $DaS['id_depto'];
            }

        $actualizar = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', nombreUsuario = '$nombreUsuario', cargo = '$cargo', contrasena = '$contrasena', id_depto = '$depa', admin ='$admin'  WHERE nombreUsuario = '$nombreUsuario ' ";
        $exec = mysqli_query($conexion, $actualizar);
            
        if(!$exec){
            echo "error".mysqli_error($conexion);
        }
        else{
            echo "<script language='javascript'> alert('Usuario editado con éxito');  window.location.href='register.php';</script>";
        
        }
        mysqli_close($conexion);
    
?>