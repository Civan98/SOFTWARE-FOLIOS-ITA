<?php

    $server = "localhost";
    $usuario = "root";
    $contra = "1234";

    $conexion = new mysqli($server, $usuario, $contra);

     if($conexion -> connect_error){
         die("Error en al conectar". $conexion-> connect_error);
     }
     else{
         echo "conexión exitosa";
     }

?>
