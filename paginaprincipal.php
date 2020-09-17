<?php
//En esta p[agina se puede colocar el contenido de los folios
    session_start();
    $usuario = $_SESSION['username'];

    if(!isset($usuario)){
        header("location: index.php");
    }else{
        echo "<hi> BIENVENIDO $usuario </h1><br>";

       echo "<a href= 'logica/salir.php'> SALIR </a> ";
    }

?>