<?php
    $host = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "bdgeneradorfolios";

    $conexion = mysqli_connect($host,$usuario,$clave,$bd);

    if($conexion){
        echo "si";
    }else{
        echo "no";
    }
?>