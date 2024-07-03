<?php
session_start();

include("conexion.php");

if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);

    // Consulta para obtener el usuario con el email proporcionado
    $consulta_usuario = "SELECT * FROM `usuarios` WHERE `email`='$email'";
    $result_usuario = mysqli_query($connect, $consulta_usuario);

    if (mysqli_num_rows($result_usuario) == 1) {
        $usuario = mysqli_fetch_assoc($result_usuario);

        // Verificar la contraseña usando password_verify
        if (password_verify($pass, $usuario['pass'])) {
            $_SESSION['email'] = $email;

            if ($usuario['rol'] == 'admin') {
                header("Location: interfaz_admin.php");
                exit;
            } elseif ($usuario['rol'] == 'user') {
                header("Location: interfaz_usuario.html");
                exit;
            } elseif ($usuario['rol'] == 'pasante') {
                header("Location: interfaz_pasante.php");
                exit;
            } else {
                echo "Rol no reconocido.";
            }
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró una cuenta con ese email.";
    }
} else {
    echo "Por favor, completa todos los campos.";
}
