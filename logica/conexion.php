<?php
    $host = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "bdgeneradorfolios";

    $conexion = mysqli_connect($host,$usuario,$clave,$bd);
    $conexion->set_charset("utf8");
?>