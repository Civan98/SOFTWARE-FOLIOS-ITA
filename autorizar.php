<?php
    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];

    if(!isset($usuario)){
        header("location: index.php");
    }else{
        echo "<hi> BIENVENIDO $usuario </h1><br>";
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];
        $deptoUsuario = $array['id_depto'];
       echo "<a href= 'logica/salir.php'> SALIR </a> ";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Autorización de folios</title>
        <meta charset="utf-8">
    </head>
    <body>
                <!---------------tabla de los folios--------------->
        <h2>Folios generados</h2>
        <table border="1">
        <tr>
            <td>Folio </td>
            <td>Fecha</td>
            <td>Nombre del solicitante</td>
            <td>Departamento que solicita</td>
            <td>Departamento al que solicita</td>
            <td>Asunto</td>                    
            <td>Estado</td>
             <!-- <td>Modificar</td>
            <td>Eliminar</td>
            <td>Imprimir</td> -->
        </tr>
            <?php
                //seleccionar las solicitudes del usuario logueado                
                $consultaSF="SELECT * FROM folios WHERE id_usuario = '$IDU'";
                $soliF = mysqli_query($conexion, $consultaSF);

                //seleccionar el nombre del usuario logeado
                $consultaUF="SELECT id,nombre, apellidos FROM usuarios WHERE id = '$IDU'";
                $nomF = mysqli_query($conexion, $consultaUF);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaDF="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$deptoUsuario'";
                $deptoF=mysqli_query($conexion, $consultaDF);
                
                if(!$soliF){
                    echo "error".mysqli_error($conexion);
                }
                while($datosF=mysqli_fetch_array($soliF)){
                    //seleccionar el nombre del departamento al que se solicita el folio
                    $consultaASF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datosF['id_depto_a_sol'];
                    $deptoASF = mysqli_query($conexion,$consultaASF);

                    //mostrar sólo las solicitudes que el usuario ha hecho
                    foreach($nomF as $nF) {
                        if ($datosF['id_usuario'] == $nF['id']){
                ?>

                
                <tr>
                    <td><?php echo $datosF['id_folio'];?></td>
                    <td><?php echo $datosF['fecha'];?></td>
                    <td><?php foreach($nomF as $nF) {echo $nF['nombre']." ".$nF['apellidos'];} ?></td>
                    <td><?php foreach($deptoF as $dF){echo $dF['nombre_departamentos'];}?></td>
                    <td><?php foreach($deptoASF as $dASF) {echo $dASF['nombre_departamentos'];}?></td>
                    <td><?php echo $datosF['asunto'];?></td>                    
                    <td><?php echo $datosF['estado'];?></td>
                    <!-- <td>
                        <form action="modificar.php" method="POST">
                            <input type="text" name="id" value=<?php //echo $datosF['id_solicitud'];?> hidden="true" >                            
                            <input type="text" name="dS" value=<?php //echo $datosF['id_depto_sol'];?> hidden="true">
                            <input type="text" name="daS" value=<?php //echo $datosF['id_depto_a_sol'];?> hidden="true">
                            <?php // if($datos['estado']=="pendiente"){ ?>                             
                                <input type="submit" name="modificar" value="Modificar" > 
                            <?php //} ?>
                        </form>
                    </td>                 
                    <td>
                        <form action="eliminar.php" method="POST">
                            <input type="text" name="id" value=<?php //echo $datosF['id_solicitud'];?> hidden="true">
                            <input type="text" name="dS" value=<?php //echo $datosF['id_depto_sol'];?> hidden="true">
                            <input type="text" name="daS" value=<?php //echo $datosF['id_depto_a_sol'];?> hidden="true">
                            <input type="submit" name="eliminar" value="Eliminar" >
                        </form>
                    </td>   -->              

                </tr>
                <?php
                        }
                    }   
                }            
                ?>
            </table>



        <h2>Autorizar solicitudes de folios</h2>
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
                    <td>Autorizar</td>
                    <td>Cancelar</td>
                </tr>
                <?php
                //seleccionar las solicitudes del usuario logueado                
                $consultaS="SELECT * FROM solicitudes WHERE id_usuario = '$IDU'";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT id,id_depto, nombre, apellidos FROM usuarios WHERE id = '$IDU'";
                $nom = mysqli_query($conexion, $consultaU);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$deptoUsuario'";
                $depto=mysqli_query($conexion, $consultaD);
                
                if(!$soli){
                    echo "error".mysqli_error($conexion);
                }
                while($datos=mysqli_fetch_array($soli)){
                    //seleccionar el nombre del departamento al que se solicita el folio
                    $consultaAS = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datos['id_depto_a_sol'];
                    $deptoAS = mysqli_query($conexion,$consultaAS);
                    // revisar si el departamento al que solicitan es al que el usuario pertenece
                    foreach($nom as $n) {
                        if ($datos['id_depto_a_sol'] == $n['id']){

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
                        <form action="auto.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true" >
                            <input type="text" name="auto" value="1" hidden="true" > 
                            <?php if($datos['estado']=="pendiente"){ ?>                                                                                
                            <input type="submit" name="autorizar" value="Autorizar" > 
                            <?php } ?>
                        </form>
                    </td>                 
                    <td>
                        <form action="auto.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true">
                            <input type="text" name="auto" value="0" hidden="true"> 
                            <?php if($datos['estado']=="pendiente"){ ?>  
                            <input type="submit" name="cancelar" value="Cancelar" >
                            <?php } ?>
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