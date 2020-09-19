<?php
    $id = $_POST['id'];
    $dS = $_POST['dS'];
    $daS = $_POST['daS'];
   // $conexion=new  mysqli("localhost",'root',"1234",'bdgeneradorfolios');
   require 'logica/conexion.php';
   session_start();
   $usuario = $_SESSION['username'];

   if(!isset($usuario)){
       header("location: index.php");
   }else{
       echo "<hi> BIENVENIDO $usuario </h1><br>";

      echo "<a href= 'logica/salir.php'> SALIR </a> ";
   }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Eliminar solicitud de folios</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>¿Desea eliminar la siguiente solicitud de folios?</h2>
        <div>
            
            <?php

                // echo "datos:". $id." ".$dS." ".$daS." ";
                //seleccionar la solicitud deseada                
                $consultaS="SELECT * FROM solicitudes WHERE id_solicitud = '$id'";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT nombre, apellidos FROM usuarios WHERE id = 1";
                $nom = mysqli_query($conexion, $consultaU);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$dS'";
                $depto=mysqli_query($conexion, $consultaD);

                //seleccionar el nombre del depto al que se le solicitan los folios
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$daS'";
                $deptoAS=mysqli_query($conexion, $consultaD);
                
                if(!$soli){
                    echo "error".mysqli_error($conexion);
                    echo $id." ".$ds." ".$daS." ";
                }


                
            ?>
            <form action="elim.php" method="POST">
                <label for="Nsolicitud">Solicitud No.: <?php foreach($soli as $s){echo $s['id_solicitud'];}?> </label> <input type="number" name="id_so" value=<?php foreach($soli as $s){echo $s['id_solicitud'];}?> hidden="true"><br><br>
                <label for="fecha">Fecha:  <?php foreach($soli as $s){echo $s['fecha'];}?></label><br><br>
                <label for="Nombre del solicitante">Nombre del solicitante: <?php foreach($nom as $n) {echo $n['nombre']." ".$n['apellidos'];} ?></label> <br><br>
                <label for="Departamento que solicita">Departamento que solicita: <?php foreach($depto as $d){echo $d['nombre_departamentos'];}?> </label> <br><br>
                <label for="Departamento al que solicita">Departamento al que solicita: <?php foreach($deptoAS as $depto_a_S){echo $depto_a_S['nombre_departamentos'];}?>  <br><br>
                <label for="Asunto">Asunto: <?php foreach($soli as $s){echo $s['asunto'];}?>  <br><br>
                <label for="Cantidad">Cantidad: <?php foreach($soli as $s){echo $s['cantidad'];}?>  <br><br>
                <input type="submit" name="eliminar" id="eliminar" value="Eliminar">
            </form>


        </div>
    </body>

</html>