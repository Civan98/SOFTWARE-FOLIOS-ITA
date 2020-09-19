<?php
    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];
    //$ID = $_SESSION['id'];

    if(!isset($usuario)){
        header("location: index.php");
    }else{
       
        //consulta para tener los datos del usuario que este logeado
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $ID = $array['id'];
        $nombre = $array['nombre'];

        // consulta para obtener el nombre del depa del usuario
        $q2 ="SELECT nombre_departamentos FROM usuarios JOIN departamentos ON usuarios.id = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario ' ";
        $consulta2 = mysqli_query($conexion,$q2);
        $array2 = mysqli_fetch_array($consulta2);
        $depa = $array2['nombre_departamentos'];

        echo "<hi> BIENVENIDO $usuario </h1><br>";
        echo "$ID<br>";
        echo "$nombre<br>";
        echo "$depa<br>";

       echo "<a href= 'logica/salir.php'> SALIR </a> ";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Control de folios</title>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Solicitudes de folios</h2>
        <div>
            <table border="1">
                <tr>
                    <td>Solicitud No.</td>
                    <td>Fecha</td>
                    <td>Nombre del solicitante</td>
                    <td>Departamento que solicita</td>
                    <td>Departamento al que solicita</td>
                    <td>Asunto</td>
                    <td>Cantidad</td>
                    <td>Estado</td>
                    <td>Modificar</td>
                    <td>Eliminar</td>
                    <td>Imprimir</td>
                </tr>
                <?php
                //seleccionar las solicitudes del usuario logueado                
                $consultaS="SELECT * FROM solicitudes WHERE id_usuario = 1";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT id,nombre, apellidos FROM usuarios WHERE id = 1";
                $nom = mysqli_query($conexion, $consultaU);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= 1";
                $depto=mysqli_query($conexion, $consultaD);
                
                if(!$soli){
                    echo "error".mysqli_error($conexion);
                }
                while($datos=mysqli_fetch_array($soli)){
                    //seleccionar el nombre del departamento al que se solicita el folio
                    $consultaAS = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datos['id_depto_a_sol'];
                    $deptoAS = mysqli_query($conexion,$consultaAS);

                    //mostrar sólo las solicitudes que el usuario ha hecho
                    foreach($nom as $n) {
                        if ($datos['id_usuario'] == $n['id']){
                ?>

                
                <tr>
                    <td><?php echo $datos['id_solicitud'];?></td>
                    <td><?php echo $datos['fecha'];?></td>
                    <td><?php foreach($nom as $n) {echo $n['nombre']." ".$n['apellidos'];} ?></td>
                    <td><?php foreach($depto as $d){echo $d['nombre_departamentos'];}?></td>
                    <td><?php foreach($deptoAS as $dAS) {echo $dAS['nombre_departamentos'];}?></td>
                    <td><?php echo $datos['asunto'];?></td>
                    <td><?php echo $datos['cantidad'];?></td>
                    <td><?php echo $datos['estado'];?></td>
                    <td>
                        <form action="modificar.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true" >                            
                            <input type="text" name="dS" value=<?php echo $datos['id_depto_sol'];?> hidden="true">
                            <input type="text" name="daS" value=<?php echo $datos['id_depto_a_sol'];?> hidden="true">
                            <?php if($datos['estado']=="pendiente"){ ?> 
                            
                            <input type="submit" name="modificar" value="Modificar" > 
                            <?php } ?>
                        </form>
                    </td>                 
                    <td>
                        <form action="eliminar.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true">
                            <input type="text" name="dS" value=<?php echo $datos['id_depto_sol'];?> hidden="true">
                            <input type="text" name="daS" value=<?php echo $datos['id_depto_a_sol'];?> hidden="true">
                            <input type="submit" name="eliminar" value="Eliminar" >
                        </form>
                    </td>                 

                </tr>
                <?php
                        }
                    }   
                }
                    mysqli_close($conexion);
                ?>
            </table>


        </div>
    </body>

</html>