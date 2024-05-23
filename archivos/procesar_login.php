<!-- procesar_login.php (Manejo del inicio de sesión) -->
<?php
session_start(); // Inicia la sesión

include("conexion.php");
if (!$connect) {  //R: Si connect es evaluado como falso, pasa esto
    die("Error de conexión a la base de datos: " . mysqli_connect_error()); //
}

if (isset($_POST['email']) && isset($_POST['password'])) { //R: Isset es una variable que se utiliza para que el valor de las variables dadas esté comprobado que no sea nulo.
    $email = trim($_POST['email']); //R: Trimm elimina los espacios en blanco de adelate y atrás de la variable
    $password = trim($_POST['password']);

    $consulta_usuario = "SELECT * FROM `usuarios` WHERE `email`='$email' AND `password`='$password'";
    $result_usuario = mysqli_query($connect, $consulta_usuario);

    $consulta_admin = "SELECT * FROM administradores WHERE email = '$email' AND password = '$password'";
    $result_admin = mysqli_query($connect, $consulta_admin);

    $consulta_pasantes = "SELECT * FROM pasantes WHERE email = '$email' AND password = '$password'";
    $result_pasantes= mysqli_query($connect, $consulta_pasantes);

if (mysqli_num_rows($result_admin) == 1) {
    // Usuario autenticado como administrador
    $_SESSION['email'] = $email;
    header("Location: interfaz_admin.php");
    exit;
} elseif (mysqli_num_rows($result_usuario) == 1) {
    // Usuario autenticado como usuario normal
    $_SESSION['email'] = $email;
    header("Location: interfaz_usuario.html");
    exit; 
} elseif (mysqli_num_rows($result_pasantes) == 1) {
    // Usuario autenticado como pasante
    $_SESSION['email'] = $email;
    header("Location: interfaz_pasante.php");
    exit;
} else {
    // Autenticación fallida
    echo "Autenticación fallida. Inténtalo de nuevo.";
}
}
?>