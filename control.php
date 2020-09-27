<?php
    require 'logica/conexion.php';
    
    session_start();
    $usuario = $_SESSION['username'];
    //$fecha_inicio = $_POST['fecha_inicio'];
    //$fecha_final = $_POST['fecha_final'];
    if (isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])){
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final = $_POST['fecha_final'];
    }
    else{
        $fecha_inicio = date("Y-m-01");
        $fecha_final = date("Y-m-d");
    }

    if(!isset($usuario)){
        header("location: index.php");
    }else{
       
        //consulta para tener los datos del usuario que este logeado
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $info = mysqli_num_rows($consulta);
        $array = mysqli_fetch_array($consulta);
        $ID = $array['id'];
        $nombre = $array['nombre'];
        $id_deptoU = $array['id_depto'];
       /* $typeUser =$array['cargo']; Selección del tipo de usuario:jefe,director*/

        

        // consulta para obtener el nombre del depa del usuario
        $q2 ="SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
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

         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

          <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    </head>
    <body>
    
    <div align="center">
    <img src=imagenes/header.png width="850" height="133">
</div>

  <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">
      <a class="navbar-brand" href="#"> <?php echo "¡BIENVENIDO! $usuario" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>

      </li>
      </a>
      <li>
       

           <a class="nav-link" href="solicitar.php">
            Solicitar
          <i class="fa fa-wrench" aria-hidden="true"></i>

        </a>
        </li>

        <li>
       

           <a class="nav-link" href="autorizar.php">
            Autorizar
          <i class="fa fa-bolt" aria-hidden="true"></i>

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
        <div align="center" style="margin:10px;">
        <form action="control.php" method="POST">
        <label for="fecha_inicio">Fecha inicial:</label>
        <input type="date" id="fecha" name="fecha_inicio" value="<?php echo $fecha_inicio;?>">
        <label for="fecha_final">Fecha final:  </label>  
        <input type="date" id="fecha" name="fecha_final" value="<?php echo $fecha_final; ?>">  
        <label for=""> <?php echo $fecha_final ?></label>            
        <button type="submit" value="Filtrar" class="btn btn-info">Filtrar</button>
        </form>
        </div>
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
                    <th>Usuario que editó</th>
                    <th>Fecha de edición</th>
                    <th>Usuario que autorizó</th>
                    <th>Fecha de autorización</th>
                    <th>Usuario que canceló</th>
                    <th>Fecha de cancelación</th>                    
                    <th>Editar</th>
                    <!--<th>Eliminar</th>-->
                    <th>Imprimir</th>
                </tr>
                <?php
                //seleccionar las solicitudes del departamento del usuario logueado  BETWEEN fecha = STR_TO_DATE('$fecha_inicio', '%Y-%m-%d') and fecha =STR_TO_DATE('$fecha_final', '%Y-%m-%d')               
                $consultaS="SELECT * FROM solicitudes WHERE id_depto_sol = '$id_deptoU' and  fecha BETWEEN STR_TO_DATE('$fecha_inicio', '%Y-%m-%d') and STR_TO_DATE('$fecha_final', '%Y-%m-%d')";
                $soli = mysqli_query($conexion, $consultaS);
                
                
                //seleccionar el nombre del departamento del usuario logeado
                $consultaD="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$id_deptoU' ";
                $depto=mysqli_query($conexion, $consultaD);
                
                if(!$soli){
                    //echo "error".mysqli_error($conexion);
                }
                while($datos=mysqli_fetch_array($soli)){
                    //nombres de los usuarios que solicitaron
                    $id_usuarios=$datos['id_usuario'];
                    $consultaU="SELECT id, nombre, apellidos FROM usuarios WHERE id = '$id_usuarios'";
                    $nom = mysqli_query($conexion, $consultaU);

                    //seleccionar el nombre del departamento al que se solicita el folio
                    $consultaAS = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datos['id_depto_genera'];
                    $deptoAS = mysqli_query($conexion,$consultaAS);

                    //Nombre de quién editó
                    if($datos['id_usuario_edit']){
                        $edit = "SELECT id, nombre, apellidos FROM usuarios WHERE id =".$datos['id_usuario_edit'];
                        $userEdit = mysqli_query($conexion,$edit);
                        $uEdt = mysqli_fetch_array($userEdit);
                        $nombreEdita = $uEdt['nombre']." ".$uEdt['apellidos'];
                        $fechaEdita = $datos['fecha_edit'];
                    }
                    else{
                        $nombreEdita = "-";
                        $fechaEdita = "-";
                    }
                    
                    //nombre de quién autorizó
                    if($datos['id_usuario_auto']){
                        $auto = "SELECT id, nombre, apellidos FROM usuarios WHERE id =".$datos['id_usuario_auto'];
                        $userAuto = mysqli_query($conexion,$auto);
                        $uAuto = mysqli_fetch_array($userAuto);
                        $nombreAuto = $uAuto['nombre']." ".$uAuto['apellidos'];
                        $fechaAuto = $datos['fecha_auto'];
                    }
                    else{
                        $nombreAuto = "-";
                        $fechaAuto = "-";
                    }
                    //nombre de quién canceló
                    if($datos['id_usuario_cancel']){
                        $cancel = "SELECT id, nombre, apellidos FROM usuarios WHERE id =".$datos['id_usuario_cancel'];
                        $userCancel = mysqli_query($conexion,$cancel);
                        $uCancel = mysqli_fetch_array($userCancel);
                        $nombreCancel = $uCancel['nombre']." ".$uCancel['apellidos'];
                        $fechaCancel = $datos['fecha_cancel'];
                    }
                    else{
                        $nombreCancel = "-";
                        $fechaCancel = "-";
                    }


                    //********************************* mostrar sólo las solicitudes que el usuario ha hecho **********************
                    foreach($nom as $n) {
                      //  if ($datos['id_usuario'] == $n['id']){
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
                    <td><?php echo  $nombreEdita;?>
                    <td><?php echo  $fechaEdita;?>
                    <td><?php echo  $nombreAuto;?>
                    <td><?php echo  $fechaAuto;?>
                    <td><?php echo  $nombreCancel;?>
                    <td><?php echo  $fechaCancel;?>
                    <td>
                        <form action="modificar.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true" >                            
                            <input type="text" name="dS" value=<?php echo $datos['id_depto_sol'];?> hidden="true">
                            <input type="text" name="daS" value=<?php echo $datos['id_depto_genera'];?> hidden="true">
                            <?php if($datos['estado']=="Solicitado"){ ?>                             
                                <input type="submit" name="editar" value="Editar" class="btn btn-warning" > 
                            <?php } ?>
                        </form>
                    </td>
                    <!--   /*              
                    <td>
                        <form action="eliminar.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud'];?> hidden="true">
                            <input type="text" name="dS" value=<?php echo $datos['id_depto_sol'];?> hidden="true">
                            <input type="text" name="daS" value=<?php echo $datos['id_depto_genera'];?> hidden="true">
                            <input type="submit" name="eliminar" value="Eliminar"  class="btn btn-danger" > 
                        </form> 
                        
                    </td> 
                    */
                    -->
                    <td>

                        <button class="btn btn-success">Imprimir</button>
                    </td>                

                </tr>
                <?php
                       /// }
                    }   
                }
                    //mysqli_close($conexion);
                ?>
            </table>




            <!---------------tabla de los folios V2--------------->
            <h2>Folios generados</h2>
        <table class="table table-striped">
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
                //seleccionar los folios del departamento del usuario logeado              
                $consultaSF="SELECT * FROM folios WHERE id_depto_sol = '$id_deptoU'";
                $soliF = mysqli_query($conexion, $consultaSF);

                //seleccionar el nombre del departamento del usuario logeado (el que solicita)
                $consultaDF="SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$id_deptoU'";
                $deptoF=mysqli_query($conexion, $consultaDF);
                $dF = mysqli_fetch_array($deptoF);

                if(!$soliF){
                    echo "error".mysqli_error($conexion);
                }
                while($datosF=mysqli_fetch_array($soliF)){
                    //Seleccionar nombre de los que solicitan los folios
                    $consultaUF="SELECT id, id_depto, nombre, apellidos FROM usuarios WHERE id = ".$datosF['id_usuario'];
                    $nomF = mysqli_query($conexion, $consultaUF);
                    $nF = mysqli_fetch_array($nomF);

                    //seleccionar el nombre del departamento que genera el folio
                    $consultaASF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datosF['id_depto_genera'];
                    $deptoASF = mysqli_query($conexion,$consultaASF);

                    
                    foreach($nomF as $nF) {

                ?>

                
                <tr>
                    <td><?php echo $datosF['id_folio'];?></td>
                    <td><?php echo $datosF['fecha'];?></td>
                    <td><?php echo $nF['nombre']." ".$nF['apellidos']; ?></td>
                    <td><?php echo $dF['nombre_departamentos'];?></td> 
                    <td><?php foreach($deptoASF as $dASF) {echo $dASF['nombre_departamentos'];}?></td>                                                           
                    <td><?php echo $datosF['asunto'];?></td>                    
                    <td><?php echo $datosF['estado'];?></td>            

                </tr>
                <?php
                        
                    }   
                }            
                ?>
            </table>
           
            <!-- VERSIÓN 1
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
                   <td>Modificar</td>
                    <td>Eliminar</td>
                    <td>Imprimir</td> 
                </tr>
                <?php
                //seleccionar los folios del depto del usuario que ha solicitado
                $consultaSF="SELECT * FROM folios WHERE id_depto_sol = '$id_deptoU'";
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
                    $consultaASF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=".$datosF['id_depto_genera'];
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
                     <td>
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
                    </td>               

                </tr>
                <?php
                        }
                    }   
                }
                    mysqli_close($conexion);
                ?>
            </table> -->  


        </div>


    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>

</html>