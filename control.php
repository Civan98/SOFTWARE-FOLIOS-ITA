<?php
    require 'logica/conexion.php';
    session_start();
    $usuario = $_SESSION['username'];

    if(!isset($usuario)){
        header("location: index.php");
    }else{
       
        //consulta para tener los datos del usuario que este logeado
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $ID = $array['id'];
        $nombre = $array['nombre'];
        $id_deptoU = $array['id_depto'];

        // consulta para obtener el nombre del depa del usuario
        $q2 ="SELECT nombre_departamentos FROM usuarios JOIN departamentos ON usuarios.id = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario ' ";
        $consulta2 = mysqli_query($conexion,$q2);
        $array2 = mysqli_fetch_array($consulta2);
        $depa = $array2['nombre_departamentos'];
        /*
        echo "<hi> BIENVENIDO $usuario </h1><br>";
        echo "id_depto usuario:".$id_deptoU;
        echo "<br>$ID<br>";
        echo "$nombre<br>";
        echo "$depa<br>";

       echo "<a href= 'logica/salir.php'> SALIR </a> ";

       */
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Control de folios</title>
        <meta charset="utf-8">
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
          <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    </head>
    <body>
    
  <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">
      <a class="navbar-brand" href="#"> <?php echo "BIENVENIDO $usuario" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>
         
          <span class="sr-only">(current)</span>
        </a>
      </li>
     <!-- <li class="nav-item">
        <a class="nav-link" href="#">
            aaa
         </a>
      </li>
     -->
    </ul>
  </div>
  
</nav>

        <h2>Solicitudes de folios</h2>
        <div>
            <table class="table table-striped">
                <tr>
                    <th>Solicitud No.</th>
                    <th>Fecha</td>
                    <th>Nombre del solicitante</th>
                    <th>Departamento que solicita</th>
                    <th>Departamento al que solicita</th>
                    <th>Asunto</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                    <th>Imprimir</th>
                </tr>
                <?php
                //seleccionar las solicitudes del usuario logueado                
                $consultaS="SELECT * FROM solicitudes WHERE id_usuario = '$ID'";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT id,nombre, apellidos FROM usuarios WHERE id = '$ID'";
                $nom = mysqli_query($conexion, $consultaU);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$id_deptoU'";
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
                    <td><?php echo $datos['estado'];?>
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
                            <input type="submit" name="eliminar" value="Eliminar"  class="btn btn-danger" >
                        </form>
                    </td>                 

                </tr>
                <?php
                        }
                    }   
                }
                    //mysqli_close($conexion);
                ?>
            </table>
            <!---------------tabla de los folios--------------->
            <h2>Folios generados</h2>
            <table class="table table-striped">
                <tr>
                    <th>Folio </th>
                    <th>Fecha</th>
                    <th>Nombre del solicitante</th>
                    <th>Departamento que solicita</th>
                    <th>Departamento al que solicita</th>
                    <th>Asunto</th>                    
                    <th>Estado</th>
                   <!-- <td>Modificar</td>
                    <td>Eliminar</td>
                    <td>Imprimir</td> -->
                </tr>
                <?php
                //seleccionar las solicitudes del usuario logueado                
                $consultaSF="SELECT * FROM folios WHERE id_usuario = '$ID'";
                $soliF = mysqli_query($conexion, $consultaSF);

                //seleccionar el nombre del usuario logeado
                $consultaUF="SELECT id,nombre, apellidos FROM usuarios WHERE id = '$ID'";
                $nomF = mysqli_query($conexion, $consultaUF);
                

                //seleccionar el nombre del departamento del usuario logeado
                $consultaDF="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$id_deptoU'";
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
                    mysqli_close($conexion);
                ?>
            </table>


        </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>

</html>