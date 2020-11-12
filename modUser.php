<?php
$nombre              = $_POST['nombre'];
$apellidos           = $_POST['apellidos'];
$nombreUsuario       = $_POST['nombreUsuario'];
$nombreUsuario2      = $_POST['nombreUsuario2'];
$cargo               = $_POST['cargo'];
$contrasena          = $_POST['contrasena'];
$nombre_departamento = $_POST['nombre_departamento'];
$admin               = $_POST['admin'];
$autoAutorizar       = $_POST['autorizarauto'];

/*echo $nombre . "--" . $apellidos . "--" . $nombreUsuario . "--" . $cargo . "--" . $contrasena . "--" . $nombre_departamento . "--" . $admin . "--" . $nombreUsuario2;
echo 'Autorizar:' . $autoAutorizar;
 */

require 'logica/conexion.php';
session_start();
$usuario = $_SESSION['username'];
if (!$conexion) {
    echo "Falla en la conexión";
} else {
    $bd = mysqli_select_db($conexion, 'db_controlfolios');
    if (!$bd) {
        echo "no se encontró la base de datos";
    }
}

$q        = "SELECT * from usuarios where nombreUsuario = '$usuario ' ";
$consulta = mysqli_query($conexion, $q);
$array    = mysqli_fetch_array($consulta);
$IDU      = $array['id'];

$buscarDeptoAS = mysqli_query($conexion, "SELECT id_depto FROM departamentos WHERE nombre_departamentos = '$nombre_departamento'");
if (!$buscarDeptoAS) {
    echo "error: " . mysqli_error($conexion);
}
$depa = "";
foreach ($buscarDeptoAS as $DaS) {
    $depa = $DaS['id_depto'];
}

$actualizar = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', nombreUsuario = '$nombreUsuario', cargo = '$cargo', contrasena = '$contrasena', id_depto = '$depa', admin ='$admin', autoAutorizar = '$autoAutorizar'  WHERE nombreUsuario = '$nombreUsuario2 ' ";
$exec       = mysqli_query($conexion, $actualizar);

if (!$exec) {
    echo "error" . mysqli_error($conexion);
} else {
    echo "<script language='javascript'> alert('Usuario editado con éxito');  window.location.href='register.php';</script>";

}
mysqli_close($conexion);
