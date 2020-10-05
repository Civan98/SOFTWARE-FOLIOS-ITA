<?php
$id_user          = $_POST['id_user'];
$nombre           = $_POST['nombre'];
$apellidos        = $_POST['apellidos'];
$nombreUsuario    = $_POST['nombreUsuario'];
$cargo            = $_POST['cargo'];
$contrasena       = $_POST['contrasena'];
$nombre_departamento = $_POST['nombre_departamento'];
$admin            = $_POST['admin'];


require 'logica/conexion.php';
session_start();
$usuario = $_SESSION['username'];

if (!isset($usuario)) {
    header("location: index.php");
} else {
    $q        = "SELECT * from usuarios where id = '$id_user' ";
    $consulta = mysqli_query($conexion, $q);
    $array    = mysqli_fetch_array($consulta);
    $ape       = $array['apellidos'];
    
   

    $q2        = "SELECT * from departamentos";
    $consulta2 = mysqli_query($conexion, $q2);

    // consulta para obtener el nombre del depa del usuario
    $q3        = "SELECT * FROM usuarios JOIN departamentos ON usuarios.id_depto = departamentos.id_depto WHERE usuarios.nombreUsuario = '$usuario' ";
    $consulta3 = mysqli_query($conexion, $q3);
    $array3    = mysqli_fetch_array($consulta3);
    $depa      = $array3['nombre_departamentos'];

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modificar Usuario</title>
        <meta charset="utf-8">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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

  <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">

        <a class="nav-link" href="logica/salir.php">
            Salir
          <i class="fa fa-sign-in" aria-hidden="true"></i>

      </li>
      </a>
      <li>


           <a class="nav-link" href="register.php">
            Volver
          <i class="fa fa-reply" aria-hidden="true"></i>

        </a>
        </li>

    </ul>
  </div>

</nav>


        <div align="center">
        <h2>Modificar Usuario</h2>
          

            <form action="modUser.php" method="POST">
                <div class="form-group">
                <label for="nombre">Nombre: <?php echo $nombre ?> </label> <input type="text" name="nombre" value="<?php echo $nombre ?> " required> <br> <br>
                <label for="apellidos">Apellidos: <?php echo $ape ?> </label> <input type="text" name="apellidos" value="<?php echo $ape ?> " required> <br> <br>
                <label for="nombreUsuario">Nombre de Usuario: <?php echo $nombreUsuario ?> </label> <input type="text" name="nombreUsuario" value="<?php echo $nombreUsuario ?>" required> <br><br>
                <label for="cargo">Cargo: <?php echo $cargo ?> </label> <input type="text" name="cargo" value="<?php echo $cargo ?>" required>  <br><br>
                <label for="contrasena">Contraseña: <?php echo $contrasena ?> </label> <input type="text" name="contrasena" value="<?php echo $contrasena ?>" required>  <br><br>
                <?php if ($usuario == "admin"){?>
                <label for="nombre_departamento">Departamento: <?php echo $nombre_departamento ?></label>
                <select name="nombre_departamento" id="listaDaS">
                    <?php
                        //Consulta para rellenar el combobox
                        $indice = 0;
                        while ($row = mysqli_fetch_array($consulta2)) {
                            $indice++;
                            $depto = $row['nombre_departamentos'];
                            ?>
                                <option value="<?php echo $depto ?>"> <?php echo $indice . ' - ' . $depto ?></option>
                                            <?php
                            }
                        ?>

                        </select><?php }else{//si no es admin le asigna el depa por defecto?>
                            <input type="text" name="nombre_departamento" value= <?php echo $nombre_departamento?> hidden="true">
                        <?php }?>
                  <br><br>
                
                <label for="nombre">Admistrador: <?php echo $admin ?> </label>
                <select  id="inputState"  name="admin" >
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
          <br><br>
   <br>
                <input type="submit" name="modificar" id="modificar" value="Modificar" class="btn btn-primary btn-lg">

            </div>
            </form>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


        </div>
    </body>

</html>