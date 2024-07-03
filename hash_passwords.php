<?php
include("conexion.php");

if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Seleccionar todos los usuarios
$consulta_usuarios = "SELECT * FROM `usuarios`";
$result_usuarios = mysqli_query($connect, $consulta_usuarios);

if (mysqli_num_rows($result_usuarios) > 0) {
    while ($usuario = mysqli_fetch_assoc($result_usuarios)) {
        $user_id = $usuario['user_id'];
        $plain_password = $usuario['pass'];
        $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

        // Actualizar la contraseña con el hash
        $actualizar_usuario = "UPDATE `usuarios` SET `pass`='$hashed_password' WHERE `user_id`='$user_id'";
        mysqli_query($connect, $actualizar_usuario);
    }
    echo "Contraseñas actualizadas con éxito.";
} else {
    echo "No se encontraron usuarios.";
}

mysqli_close($connect);
