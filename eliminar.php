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
        $q = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
        $consulta = mysqli_query($conexion,$q);
        $array = mysqli_fetch_array($consulta);
        $IDU = $array['id'];
   }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Eliminar solicitud de folios</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
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

        <h2 align="center">¿Desea eliminar la siguiente solicitud de folios?</h2>
        <div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>!Atención!</strong> La siguiente solicitud no podrá ser recuperada si es eliminada.
</div>
        <div align="center">
        <div class="jumbotron text-center" style="width: 70%;">
            <div class="container">
            
            <?php

                // echo "datos:". $id." ".$dS." ".$daS." ";
                //seleccionar la solicitud deseada                
                $consultaS="SELECT * FROM solicitudes WHERE id_solicitud = '$id'";
                $soli = mysqli_query($conexion, $consultaS);

                //seleccionar el nombre del usuario logeado
                $consultaU="SELECT nombre, apellidos FROM usuarios WHERE id = '$IDU'";
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
                    <hr class="my-4">
                <input type="submit" name="eliminar" id="eliminar" value="Eliminar" class="btn btn-danger">
                           <input type="button" onclick="location.href='control.php';" name="Regresar" value="Regresar" class="btn btn-secondary">
            </form>

            </div>

        </div>

        </div>

         <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>

</html>