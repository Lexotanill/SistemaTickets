<?php
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_SESSION['email']) && isset($_POST['aula']) && isset($_POST['materia']) && isset($_POST['categoria']) && isset($_POST['mensaje'])) {
    $mail = $_SESSION['email'];
    $aula = trim($_POST['aula']);
    $materia = trim($_POST['materia']);
    $categoria = trim($_POST['categoria']);
    $mensaje = trim($_POST['mensaje']);
    $estado = "pendiente";

    // Recupera el UsuarioID desde la base de datos
    $consultaUsuarioID = "SELECT `user_id` FROM `usuarios` WHERE `email` = '$mail'";
    $resultUsuarioID = mysqli_query($connect, $consultaUsuarioID);

    if ($resultUsuarioID && mysqli_num_rows($resultUsuarioID) == 1) {
        $row = mysqli_fetch_assoc($resultUsuarioID);
        $usuarioID = $row['user_id'];

        // Calcula la fecha de cierre, dos semanas en el futuro
        $fechaCreacion = date('Y-m-d H:i:s'); // Fecha actual
        $fechaCierre = date('Y-m-d H:i:s', strtotime($fechaCreacion . ' + 2 weeks'));

        // Agrega la fecha de cierre y el estado "pendiente" a la consulta de inserción
        $consulta = "INSERT INTO `tickets`(`mail`,`categoria`, `aula`, `Materia`, `Descripcion`, `UsuarioID`, `FechaCreacion`, `FechaCierre`, `Estado`) 
                    VALUES ('$mail', '$categoria', '$aula', '$materia', '$mensaje', '$usuarioID', '$fechaCreacion', '$fechaCierre', '$estado')";

        $result = mysqli_query($connect, $consulta);

        if ($result) {
            header("Location: advertencia.html");
            exit();
        } else {
            echo "matate";
        }
    } else {
        echo "Error al obtener el UsuarioID. Inténtalo de nuevo.";
    }
}

?>