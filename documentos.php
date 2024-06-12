<?php
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_SESSION['email']) && isset($_POST['aula']) && isset($_POST['materia']) && isset($_POST['categoria']) && isset($_POST['mensaje']) && isset($_POST['fecha'])) {
    $mail = $_SESSION['email'];
    $aula = trim($_POST['aula']);
    $materia = trim($_POST['materia']);
    $categoria = trim($_POST['categoria']);
    $mensaje = trim($_POST['mensaje']);
    $fecha = trim($_POST['fecha']);
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

        // Agrega la fecha seleccionada por el usuario a la consulta de inserción
        $consulta = "INSERT INTO `tickets`(`mail`, `categoria`, `aula`, `Materia`, `Descripcion`, `UsuarioID`, `FechaCreacion`, `FechaCierre`, `Estado`, `fecha`) 
                    VALUES ('$mail', '$categoria', '$aula', '$materia', '$mensaje', '$usuarioID', '$fechaCreacion', '$fechaCierre', '$estado', '$fecha')";

        $result = mysqli_query($connect, $consulta);

        if ($result) {
            echo "Ticket creado exitosamente.";
            header('Location: enviado.html');
        } else {
            echo "Error al crear el ticket: " . mysqli_error($connect);
        }
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "Datos incompletos.";
}
