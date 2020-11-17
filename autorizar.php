<?php
require 'logica/conexion.php';
session_start();
$usuario = $_SESSION['username'];

if (!isset($usuario)) {
    session_destroy();
    header("location: index.php");
} else {

    $q            = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
    $consulta     = mysqli_query($conexion, $q);
    $array        = mysqli_fetch_array($consulta);
    $IDU          = $array['id'];
    $deptoUsuario = $array['id_depto'];
    $nomUsuario   = $array['nombreUsuario'];
    $admin        = $array['admin'];

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
        <title>Autorización de folios</title>
        <meta charset="utf-8">
         <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">


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
      Autorizar folios
    </span>

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="#">
            <?php echo "Usuario: $usuario"; ?>
         </a>

      </li>
      <?php if ($admin == 1) {?>
          <li class="nav-item">
            <a class="nav-link" href="register.php">
                <?php echo "Administrador"; ?>
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>

          </li>
      <?php }?>

      <li class="nav-item">


           <a class="nav-link" href="control.php">
            Control
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


           <a class="nav-link active" href="#">
            Autorizar
            <span class="sr-only">(current)</span>
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
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Folios generados</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Autorizar solicitudes de folios</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

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

        </tr>
            <?php
//seleccionar todos los folios si es admin
if($nomUsuario == 'admin'){
  $consultaSF = "SELECT * FROM folios ORDER BY id_depto_genera ASC, id_folio DESC";
}else{
  $consultaSF = "SELECT * FROM folios WHERE id_depto_genera = '$deptoUsuario' ORDER BY id_depto_genera ASC, id_folio DESC";
}

$soliF      = mysqli_query($conexion, $consultaSF);



if (!$soliF) {
    echo "error" . mysqli_error($conexion);
}
while ($datosF = mysqli_fetch_array($soliF)) {
    $depto_a_solicitar = $datosF['id_depto_genera'];
    //Seleccionar nombre de los que solicitan los folios
    $consultaUF = "SELECT id, id_depto, nombre, apellidos FROM usuarios WHERE id = " . $datosF['id_usuario'];
    $nomF       = mysqli_query($conexion, $consultaUF);
    $nF         = mysqli_fetch_array($nomF);

    //seleccionar el nombre del departamento que solicita el folio
    $consultaASF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=" . $datosF['id_depto_sol'];
    $deptoASF    = mysqli_query($conexion, $consultaASF);

    //seleccionar el nombre del departamento que genera el folio
  $consultaDF = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$depto_a_solicitar'";
  $deptoF     = mysqli_query($conexion, $consultaDF);
  $dF         = mysqli_fetch_array($deptoF);

    foreach ($nomF as $nF) {

        ?>


                <tr>
                    <td><?php echo $datosF['id_folio']; ?></td>
                    <td><?php echo $datosF['fecha']; ?></td>
                    <td><?php echo $nF['nombre'] . " " . $nF['apellidos']; ?></td>
                    <td><?php foreach ($deptoASF as $dASF) {echo $dASF['nombre_departamentos'];}?></td>
                    <td><?php echo $dF['nombre_departamentos']; ?></td>
                    <td><?php echo $datosF['asunto']; ?></td>
                    <td><?php echo $datosF['estado']; ?></td>

                </tr>
                <?php
//}
    }
}
?>
            </table>

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        <h2>Autorizar solicitudes de folios</h2>
        <div>
            <table class="table table-striped">
                <tr>
                    <th>Solicitud No.</th>
                    <th>Fecha</th>
                    <th>Nombre del solicitante</th>
                    <th>Departamento que solicita</th>
                    <th>Departamento al que solicita</th>
                    <th>Asunto</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                    <th>Autorizar</th>
                    <th>Cancelar</th>
                </tr>
                <?php
//seleccionar todas las solicitudes si es admin (las que puede autorizar o cancelar)
if($nomUsuario == 'admin'){
  $consultaS = "SELECT * FROM solicitudes ORDER BY fecha DESC";
}else{
  $consultaS = "SELECT * FROM solicitudes WHERE id_depto_genera = '$deptoUsuario' ORDER BY fecha DESC";
}

$soli      = mysqli_query($conexion, $consultaS);


if (!$soli) {
    echo "error" . mysqli_error($conexion);
}
while ($datos = mysqli_fetch_array($soli)) {
    $depto_generaFolio = $datos['id_depto_genera'];
  //NOMBRE de los que solicitan folios
    $consultaU = "SELECT id, id_depto, nombre, apellidos FROM usuarios WHERE id = " . $datos['id_usuario'];
    $nom       = mysqli_query($conexion, $consultaU);
    $n         = mysqli_fetch_array($nom);

    //seleccionar el nombre del departamento que solicita el folio
    $consultaAS = "SELECT nombre_departamentos FROM departamentos WHERE id_depto=" . $datos['id_depto_sol'];
    $deptoS     = mysqli_query($conexion, $consultaAS);

    //seleccionar el nombre del departamento que generará el folio
    $consultaD = "SELECT nombre_departamentos FROM departamentos WHERE id_depto= '$depto_generaFolio'";
    $depto     = mysqli_query($conexion, $consultaD);
    $d         = mysqli_fetch_array($depto);

    // revisar si el departamento al que solicitan es al que el usuario pertenece
    foreach ($nom as $n) {

        ?>

                <tr>
                    <td><?php echo $datos['id_solicitud']; ?></td>
                    <td><?php echo $datos['fecha']; ?></td>
                    <td><?php echo $n['nombre'] . " " . $n['apellidos']; ?></td>
                    <td><?php foreach ($deptoS as $dS) {echo $dS['nombre_departamentos'];}?></td>
                    <td><?php echo $d['nombre_departamentos']; ?></td>
                    <td><?php echo $datos['asunto']; ?></td>
                    <td><?php echo $datos['cantidad']; ?></td>
                    <td><?php echo $datos['estado']; ?></td>
                    <td>
                        <form action="auto.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud']; ?> hidden="true" >
                            <input type="text" name="auto" value="1" hidden="true" >
                            <?php if ($datos['estado'] == "Solicitado") {?>
                            <input type="submit" name="autorizar" value="Autorizar" class="btn btn-success btn-lg" >
                            <?php }?>
                        </form>
                    </td>
                    <td>
                        <form action="auto.php" method="POST">
                            <input type="text" name="id" value=<?php echo $datos['id_solicitud']; ?> hidden="true">
                            <input type="text" name="auto" value="0" hidden="true">
                            <?php if ($datos['estado'] != "Cancelado") {?>
                            <input type="text" class="form-control" placeholder="Motivos" id="infoCancelar" name="infoCancelar" required>                            
                              <input type="submit" name="cancelar" value="Cancelar" class="btn btn-danger btn-lg" >
                            <?php }?>
                        </form>
                    </td>
                </tr>
                <?php
}
}
mysqli_close($conexion);
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