<?php
require 'logica/conexion.php';
session_start();
$usuario = $_SESSION['username'];

$q        = "SELECT * from departamentos";
$consulta = mysqli_query($conexion, $q);

$q2        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
$consulta2 = mysqli_query($conexion, $q2);
$array     = mysqli_fetch_array($consulta2);
$admin     = $array['admin'];
$idDE      = $array['id_depto'];

// consulta para obtener el nombre del depa del usuario
$q3        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
$consulta3 = mysqli_query($conexion, $q3);
$array3    = mysqli_fetch_array($consulta3);
$depa      = $array3['nombre_departamentos'];

//se valida que haya usuario en sesion

if (!isset($usuario)) {
    session_destroy();
    header("location: index.php");
} else {
    if ($admin == 0) {
        //valida que el usuario no sea admin
        session_destroy();
        header("location: index.php");
    } else {

        ?>
<!DOCTYPE html>
 <html lang="es">

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>TecNM | Tecnológico Nacional de México Campus Acapulco</title>
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style type="text/css">
  .hidetext { -webkit-text-security: square; }
</style>
</head>


<body>
<div align="center">
  <img src=imagenes/header.png width="850" height="133"></div>
<div align="center">
  <nav class="navbar navbar-expand-lg navbar-light navbar-dark" style="background-color: #1B396A">
      <a class="navbar-brand" href="#"> <?php echo "Departamento: $depa" ?> </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

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
            <a class="nav-link active" href="register.php">
              <span class="sr-only">(current)</span>
                <?php echo "Adminstrador"; ?>
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
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Registrar nuevo usuario</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Usuarios registrados</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

      <h1>Registro de usuario</h1>
  <h2>Por favor, introduzca los datos solicitados:</h2>
<form action ="insert.php" method ="POST">
<div class="row">

  <div class="col">
    <label for="nombre">Nombre:</label>
          <input type="text" class="form-control" placeholder="Nombre" id="nombre" name="nombre" required>
  </div>

  <div class="col-4">
      <label for="Apellidos">Apellidos:</label>
        <input type="text" class="form-control" placeholder="Apellidos" id="Apellidos" name="Apellidos" required>
      </div>

  <div class="col">
    <label for="NombreUsuario">Nombre de usuario:</label>
        <input type="text" class="form-control" placeholder="Nombre de usuario" id="NombreUsuario" name="NombreUsuario" required>
  </div>

</div>

    <div class="row">
  <div class="col">
    <label for="cargo">Cargo:</label>
    <input type="text" class="form-control" placeholder="Cargo" id="cargo"  name="cargo" required>
  </div>

  <div class="col">
    <label for="cargo">Administrador:</label>
          <select  id="inputState" class="form-control" name="administrador" >
            <option value="1">Si</option>
            <option value="0">No</option>
          </select>
  </div>
</div>
  <div class="row">
      <div class="col">
      <!--si es admin solo el da de alta otro depa de lo contrario se le asigna el depa del usario logeado-->
      <?php if ($usuario == 'admin') {
            ?>
          <label for="departamento">Departamento:</label>
          <select id="inputState" class="form-control" name="departamento">
          <?php
$indice = 0;
            while ($row = mysqli_fetch_array($consulta)) {
                $indice++;
                $depto = $row['nombre_departamentos'];
                ?>
                <option value="<?php echo $depto ?>"> <?php echo $indice . ' - ' . $depto ?></option>
              <?php
}
            ?>
               <?php
} else {?>
                  <input type="text" value ="<?php echo $depa ?>" name="departamento" hidden="true" >
               <?php }
        ?>

          </select>
      </div>


    </div>

          <div class="row">
        <div class="col">
          <label for="password">Contraseña:</label>
          <input type="password" name="password" id="password" name="password" placeholder="Contraseña" class="form-control" required>
        </div>

        <div class="col">
           <label for="passwordretry">Confirmar contraseña:</label>
          <input type="password" name="passwordretry" id="passwordretry" name="passwordretry" placeholder="Confirmar Contraseña" class="form-control" required>
        </div>

        </div>
      <br>

        <button type="submit" class="btn btn-primary btn-lg">Enviar</button>
</form>

  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <h2>Usuarios registrados</h2>
    <!-- EMPIEZA LA TABLA DE USUARIOS-->
<br>
<br>

<?php
//si es admin se muestra todos los usuarios
        if ($usuario == "admin") {
            ?>
    <table class="table table-striped">
              <thead>
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Nombre Usuario</th>
                        <th scope="col">Cargo</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Administrador</th>
                        <th scope="col">Autorizar automático</th>
                        <th scope="col">Editar</th>
                      </tr>
                    </thead>
                      <?php
$sql    = "SELECT * FROM usuarios";
            $result = mysqli_query($conexion, $sql);

            while ($mostrar = mysqli_fetch_array($result)) {
//cambia los 1 por SI y 0 por NO

                if ($mostrar['admin'] == 1) {
                    $admin = "SI";
                } else {
                    $admin = "NO";
                }
                if ($mostrar['autoAutorizar'] == 1) {
                    $autorizar = 'SI';
                } else {
                    $autorizar = 'NO';
                }

                //consulta para el nombre de los depas
                $idD       = $mostrar['id_depto'];
                $sql2      = "SELECT * FROM departamentos WHERE id_depto = $idD";
                $result2   = mysqli_query($conexion, $sql2);
                $array     = mysqli_fetch_array($result2);
                $nom_depto = $array['nombre_departamentos'];

                ?>
                        <tr>
                          <td><?php echo $mostrar['nombre'] ?></td>
                          <td><?php echo $mostrar['apellidos'] ?></td>
                          <td><?php echo $mostrar['nombreUsuario'] ?></td>
                          <td><?php echo $mostrar['cargo'] ?></td>
                          <td class="hidetext"><?php echo $mostrar['contrasena'] ?></td>
                          <td><?php echo $nom_depto ?></td>
                          <td><?php echo $admin ?></td>
                          <td><?php echo $autorizar ?></td>
                          <td>
                                    <form action="modificarUser.php" method="POST">
                                      <input type="text" name="id_user" value=<?php echo $mostrar['id']; ?> hidden="true">
                                      <input type="text" name="nombre" value= <?php echo $mostrar['nombre'] ?> hidden="true">
                                      <input type="text" name="apellidos" value= <?php echo $mostrar['apellidos'] ?> hidden="true">
                                      <input type="text" name="nombreUsuario" value= <?php echo $mostrar['nombreUsuario'] ?> hidden="true">
                                      <input type="text" name="cargo" value= <?php echo $mostrar['cargo'] ?> hidden="true">
                                      <input type="text" name="contrasena" value= <?php echo $mostrar['contrasena'] ?> hidden="true">
                                      <input type="text" name="nombre_departamento" value= <?php echo $nom_depto ?> hidden="true">
                                      <input type="text" name="admin" value= <?php echo $admin ?> hidden="true">
                                      <input type="text" name="autoAutorizar" value= <?php echo $autorizar ?> hidden="true">
                                      <input type="submit" name="editar" value="Editar" class="btn btn-warning" >
                                    </form>
                                    </td>
                        </tr>
                      <?php
}
            ?>
    </table>
  <?php } else {
            ?>
              <table class="table table-striped">
                         <thead>
                                <tr>
                                  <th scope="row">Nombre</th>
                                  <th scope="row">Apellidos</th>
                                  <th scope="row">Nombre Usuario</th>
                                  <th scope="row">Cargo</th>
                                  <th scope="row">Contraseña</th>
                                  <th scope="row">Departamento</th>
                                  <th scope="row">Administrador</th>
                                  <th scope="col">Autorizar automático</th>
                                  <th scope="row">Editar</th>
                                </tr>
                            </thead>
                                <?php
$sql    = "SELECT * FROM usuarios WHERE id_depto = $idDE";
            $result = mysqli_query($conexion, $sql);

            while ($mostrar = mysqli_fetch_array($result)) {
//cambia los 1 por SI y 0 por NO
                if ($mostrar['admin'] == 1) {
                    $admin = "SI";
                } else {
                    $admin = "NO";
                }
                if ($mostrar['autoAutorizar'] == 1) {
                  $autorizar = 'SI';
              } else {
                  $autorizar = 'NO';
              }

                //consulta para el nombre de los depas
                $idD       = $mostrar['id_depto'];
                $sql2      = "SELECT * FROM departamentos WHERE id_depto = $idD";
                $result2   = mysqli_query($conexion, $sql2);
                $array     = mysqli_fetch_array($result2);
                $nom_depto = $array['nombre_departamentos'];

                //para no mostrar el admin
                if ($mostrar['nombreUsuario'] == "admin") {

                } else {
                    ?>
                                  <tr>
                                    <td><?php echo $mostrar['nombre'] ?></td>
                                    <td><?php echo $mostrar['apellidos'] ?></td>
                                    <td><?php echo $mostrar['nombreUsuario'] ?></td>
                                    <td><?php echo $mostrar['cargo'] ?></td>
                                    <td class="hidetext"><?php echo $mostrar['contrasena'] ?></td>
                                    <td><?php echo $nom_depto ?></td>
                                    <td><?php echo $admin ?></td>
                                    <td><?php echo $autorizar ?></td>
                                    <td>
              <form action="modificarUser.php" method="POST">
                          <input type="text" name="id_user" value=<?php echo $mostrar['id']; ?> hidden="true">
                          <input type="text" name="nombre" value= <?php echo $mostrar['nombre'] ?> hidden="true">
                          <input type="text" name="apellidos" value= <?php echo $mostrar['apellidos'] ?> hidden="true">
                          <input type="text" name="nombreUsuario" value= <?php echo $mostrar['nombreUsuario'] ?> hidden="true">
                          <input type="text" name="cargo" value= <?php echo $mostrar['cargo'] ?> hidden="true">
                          <input type="text" name="contrasena" value= <?php echo $mostrar['contrasena'] ?> hidden="true">
                          <input type="text" name="nombre_departamento" value= <?php echo $nom_depto ?> hidden="true">
                          <input type="text" name="admin" value= <?php echo $admin ?> hidden="true">
                          <input type="text" name="autoAutorizar" value= <?php echo $autorizar ?> hidden="true">
                          <input type="submit" name="editar" value="Editar" class="btn btn-warning" >
                        </form>
                            </td>

                          <?php }
                ?>

                                  </tr>
                                <?php
}
            ?>
              </table>
           <?php
}
        ?>




  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>
<?php }?>

<?php }?>