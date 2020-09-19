<?php
    
    $conexion=new  mysqli("localhost",'root',"",'bdgeneradorfolios');
    //require 'logica/conexion.php';
    //session_start();
    $id = $_POST['id_so'];

    $sql = "DELETE FROM solicitudes WHERE id_solicitud ='$id'";
    $consulta = mysqli_query($conexion,$sql);
    if(!$consulta){
        echo "error: ".mysqli_error($conexion);        
    }
    else{
       // echo "Solicitud eliminada, link para volver al inicio";
        header("location: control.php");
    }
    mysqli_close($conexion);

?>