<?php
require 'logica/conexion.php';
ob_start();
session_start();
$usuario = $_SESSION['username'];
if (!isset($usuario)) {
    session_destroy();
    header("location: index.php");
} else {

    if (isset($_POST['fecha_inicio']) || isset($_POST['fecha_final'])) {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final  = $_POST['fecha_final'];
    } else {

        date_default_timezone_set("America/Mexico_City");
        $fecha_inicio = date("Y-m-01");
        $fecha_final  = date("Y-m-d");
    }

    if (!isset($usuario)) {
        session_destroy();
        header("location: index.php");
    } else {
        ob_end_flush();
        //consulta para tener los datos del usuario que este logeado
        $q         = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta  = mysqli_query($conexion, $q);
        $info      = mysqli_num_rows($consulta);
        $array     = mysqli_fetch_array($consulta);
        $ID        = $array['id'];
        $nombre    = $array['nombre'];
        $nomUsuario =$array['nombreUsuario'];
        $id_deptoU = $array['id_depto'];
        $admin     = $array['admin'];
        
        /*Selección de departamento*/

        // consulta para obtener el nombre del depa del usuario
        $q2        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
        $consulta2 = mysqli_query($conexion, $q2);
        $array2    = mysqli_fetch_array($consulta2);
        $depa      = $array2['nombre_departamentos'];

    }
    ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Control de folios</title>
        <meta charset="utf-8">

         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

          <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
    th {
  background: white;
  position: sticky;
  top: 0;
</style>

    </head>
    <body>

    <div align="center">
    <img src=imagenes/header.png width="850" height="133">
</div>

  <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">
      <a class="navbar-brand" href="#"> <?php echo "Departamento: $depa" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <span class="navbar-brand" style="margin-left: 5%;">
      Control de folios
    </span>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="#">
            <?php echo "Usuario: $usuario"; ?>
         </a>

      </li>

<!--validación del admin-->
      <?php if ($admin == 1) {?>
          <li class="nav-item">
            <a class="nav-link" href="register.php">
              <span class="sr-only">(current)</span>
                <?php echo "Administrador"; ?>
                <i class="fa fa-pencil" aria-hidden="true"></i>

            </a>

          </li>
    <?php }?>


      <li class="nav-item">


           <a class="nav-link active" href="#">
            Control
            <span class="sr-only">(current)</span>
          <i class="fa fa-address-book" aria-hidden="true"></i>


        </a>
        </li>


      <li class="nav-item">


           <a class="nav-link" href="formsolicitar.php">
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

        <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>
        </a>

      </li>

    </ul>
  </div>

</nav>


<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Solicitudes de folios</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Folios generados</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <h2>Solicitudes de folios</h2>
        <div align="center" style="margin:10px;">
        <form action="control.php" method="POST">
        <label for="fecha_inicio">Fecha inicial:</label>
        <input type="date" id="fecha" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
        <label for="fecha_final">Fecha final:  </label>
        <input type="date" id="fecha" name="fecha_final" value="<?php echo $fecha_final; ?>">
        <button type="submit" value="Filtrar" class="btn btn-info">Filtrar</button>
        </form>
        </div>


            <div style="position: relative; height: 500px; overflow: auto;">
            <table class="table table-striped">
               <thead>
                <tr>
                    <th scope="col">Solicitud No.</th>
                    <th>Fecha</td>
                    <th scope="col">Nombre del solicitante</th>
                    <th scope="col">Departamento que solicita</th>
                    <th scope="col">Departamento al que solicita</th>
                    <th scope="col">Asunto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Usuario que editó</th>
                    <th scope="col">Fecha de edición</th>
                    <th scope="col">Usuario que autorizó</th>
                    <th scope="col">Fecha de autorización</th>
                    <th scope="col">Usuario que canceló</th>
                    <th scope="col">Fecha de cancelación</th>
                    <th scope="col">Editar</th>
                    <th>Imprimir</th>
                </tr>
                </thead>
                <?php

    //si es el admin, mostrar todas las solicitues, no importa el depto
    if($nomUsuario == 'admin'){
        $consultaS = "SELECT * FROM solicitudes WHERE DATE(fecha) >= '$fecha_inicio' and DATE(fecha) <= '$fecha_final'";
    }else{ 
            $consultaS = "SELECT * FROM solicitudes WHERE id_depto_sol = '$id_deptoU' and  DATE(fecha) >= '$fecha_inicio' and DATE(fecha) <= '$fecha_final'";
    }
    $soli = mysqli_query($conexion, $consultaS);



    if (!$soli) {
        //echo "error".mysqli_error($conexion);
    }
    while ($datos = mysqli_fetch_array($soli)) {
        //nombres de los usuarios que solicitaron
        $id_usuarios = $datos['id_usuario'];
        $depto_solicita = $datos['id_depto_sol'];
        $consultaU   = "SELECT id, nombre, apellidos FROM usuarios WHERE id = '$id_usuarios'";
        $nom         = mysqli_query($conexion, $consultaU);

        //seleccionar el nombre de los departamentos que solicitaron
        $consultaD = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$depto_solicita'";
        $depto     = mysqli_query($conexion, $consultaD);
        $d         = mysqli_fetch_array($depto);

        //seleccionar el nombre del departamento al que se solicita el folio
        $consultaAS = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=" . $datos['id_depto_genera'];
        $deptoAS    = mysqli_query($conexion, $consultaAS);

        //Nombre de quién editó
        if ($datos['id_usuario_edit']) {
            $edit        = "SELECT id, nombre, apellidos FROM usuarios WHERE id =" . $datos['id_usuario_edit'];
            $userEdit    = mysqli_query($conexion, $edit);
            $uEdt        = mysqli_fetch_array($userEdit);
            $nombreEdita = $uEdt['nombre'] . " " . $uEdt['apellidos'];
            $fechaEdita  = $datos['fecha_edit'];
        } else {
            $nombreEdita = "-";
            $fechaEdita  = "-";
        }

        //nombre de quién autorizó
        if ($datos['id_usuario_auto']) {
            $auto       = "SELECT id, nombre, apellidos FROM usuarios WHERE id =" . $datos['id_usuario_auto'];
            $userAuto   = mysqli_query($conexion, $auto);
            $uAuto      = mysqli_fetch_array($userAuto);
            $nombreAuto = $uAuto['nombre'] . " " . $uAuto['apellidos'];
            $fechaAuto  = $datos['fecha_auto'];
        } else {
            $nombreAuto = "-";
            $fechaAuto  = "-";
        }
        //nombre de quién canceló
        if ($datos['id_usuario_cancel']) {
            $cancel       = "SELECT id, nombre, apellidos FROM usuarios WHERE id =" . $datos['id_usuario_cancel'];
            $userCancel   = mysqli_query($conexion, $cancel);
            $uCancel      = mysqli_fetch_array($userCancel);
            $nombreCancel = $uCancel['nombre'] . " " . $uCancel['apellidos'];
            $fechaCancel  = $datos['fecha_cancel'];
        } else {
            $nombreCancel = "-";
            $fechaCancel  = "-";
        }

        foreach ($nom as $n) {

            ?>

            <tbody>
                <tr>
                    <th scope="row" ><?php echo $datos['id_solicitud']; ?></th>
                    <td><?php echo $datos['fecha']; ?></td>
                    <td><?php foreach ($nom as $n) {echo $n['nombre'] . " " . $n['apellidos'];}?></td>

                    <td><?php echo $d['nombre_departamentos']; ?></td>
                    
                    <td><?php foreach ($deptoAS as $dAS) {echo $dAS['nombre_departamentos'];}?></td>
                    <td><?php echo $datos['asunto']; ?></td>
                    <td><?php echo $datos['cantidad']; ?></td>
                    <td><?php echo $datos['estado']; ?>
                    <td><?php echo $nombreEdita; ?>
                    <td><?php echo $fechaEdita; ?>
                    <td><?php echo $nombreAuto; ?>
                    <td><?php echo $fechaAuto; ?>
                    <td><?php echo $nombreCancel; ?>
                    <td><?php echo $fechaCancel; ?>
                    <td>
                        <form action="modificar.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud']; ?> hidden="true" >
                            <input type="text" name="dS" value=<?php echo $datos['id_depto_sol']; ?> hidden="true">
                            <input type="text" name="daS" value=<?php echo $datos['id_depto_genera']; ?> hidden="true">
                            <?php if ($datos['estado'] == "Solicitado") {?>
                                <input type="submit" name="editar" value="Editar" class="btn btn-warning" >
                            <?php }?>
                        </form>
                    </td>
                    <td>
                        <form action="Imprimir.php" method="POST" target="_blank">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud']; ?> hidden="true" >
                            <input type="text" name="dS" value=<?php echo $datos['id_depto_sol']; ?> hidden="true">
                            <input type="text" name="daS" value=<?php echo $datos['id_depto_genera']; ?> hidden="true">
                            <?php if ($datos['estado'] != "Solicitado") {?>
                                <input type="submit" name="Imprimir" value="Imprimir" class="btn btn-success" >
                            <?php }?>
                        </form>

                    </td>

                </tr>
                </tbody>
                <?php

        }
    }
    ?>
            </table>
            </div>

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <h2>Folios generados</h2>
            <form action="imprimir2.php" method="POST" target="_blank">
                                <input type="submit" name="Imprimir" value="Imprimir" class="btn btn-success">
            </form>
            <br>
        <table class="table table-striped">
        <tr>
            <td>Folio </td>
            <td>Fecha</td>
            <td>Nombre del solicitante</td>
            <td>Departamento que solicita</td>
            <td>Departamento al que solicita</td>
            <td>Asunto</td>
            <td>Estado</td>
        </tr>
            <?php
    //seleccionar todos los folios si se es admin
    if($nomUsuario == 'admin'){
        $consultaSF = "SELECT * FROM folios WHERE DATE(fecha) >= '$fecha_inicio' and DATE(fecha) <= '$fecha_final' ORDER BY id_depto_genera ASC, id_folio DESC";
    }else{
        $consultaSF = "SELECT * FROM folios WHERE id_depto_sol = '$id_deptoU' and  DATE(fecha) >= '$fecha_inicio' and DATE(fecha) <= '$fecha_final' ORDER BY id_depto_genera ASC, id_folio DESC";
        }
    
    $soliF      = mysqli_query($conexion, $consultaSF);
    
//seleccionar el nombre del departamento del usuario logeado (el que solicita)
    $consultaDF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$id_deptoU'";
    $deptoF     = mysqli_query($conexion, $consultaDF);
    $dF         = mysqli_fetch_array($deptoF);
    
    if (!$soliF) {
        echo "error" . mysqli_error($conexion);
    }
    while ($datosF = mysqli_fetch_array($soliF)) {
        //Seleccionar nombre de los que solicitan los folios
        $consultaUF = "SELECT id, id_depto, nombre, apellidos FROM usuarios WHERE id = " . $datosF['id_usuario'];
        $nomF       = mysqli_query($conexion, $consultaUF);
        $nF         = mysqli_fetch_array($nomF);
        $depto_solicitaFolio = $datosF['id_depto_sol'];
        //seleccionar el nombre del departamento del usuario logeado (el que solicita)
        $consultaDF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$depto_solicitaFolio'";
        $deptoF     = mysqli_query($conexion, $consultaDF);
        $dF         = mysqli_fetch_array($deptoF);

        //seleccionar el nombre del departamento que genera el folio
        $consultaASF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=" . $datosF['id_depto_genera'];
        $deptoASF    = mysqli_query($conexion, $consultaASF);

        foreach ($nomF as $nF) {
            ?>
                <tr>
                    <td><?php echo $datosF['id_folio']; ?></td>
                    <td><?php echo $datosF['fecha']; ?></td>
                    <td><?php echo $nF['nombre'] . " " . $nF['apellidos']; ?></td>
                    <td><?php echo $dF['nombre_departamentos']; ?></td>
                    <td><?php foreach ($deptoASF as $dASF) {echo $dASF['nombre_departamentos'];}?></td>
                    <td><?php echo $datosF['asunto']; ?></td>
                    <td><?php echo $datosF['estado']; ?></td>

                </tr>
                <?php
}
    }
    ?>
            </table>
        </div>

  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </body>

</html>
<?php }?>