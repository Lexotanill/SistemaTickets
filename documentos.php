<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';


session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_SESSION['email']) && isset($_POST['aula']) && isset($_POST['materia']) && isset($_POST['categoria']) && isset($_POST['mensaje']) && isset($_POST['fecha'])) {
    $email = $_SESSION['email'];
    $aula = trim($_POST['aula']);
    $materia = trim($_POST['materia']);
    $categoria = trim($_POST['categoria']);
    $mensaje = trim($_POST['mensaje']);
    $fechaSolicitud = trim($_POST['fecha']); // Cambiado el nombre a fechaSolicitud para mayor claridad
    $estado = "pendiente";

    // Recupera el UsuarioID desde la base de datos
    $consultaUsuarioID = "SELECT `user_id` FROM `usuarios` WHERE `email` = '$email'";
    $resultUsuarioID = mysqli_query($connect, $consultaUsuarioID);

    if ($resultUsuarioID && mysqli_num_rows($resultUsuarioID) == 1) {
        $row = mysqli_fetch_assoc($resultUsuarioID);
        $usuarioID = $row['user_id'];

        // Calcula la fecha de cierre, dos semanas en el futuro
        $fechaCreacion = date('Y-m-d H:i:s'); // Fecha actual
        $fechaCierre = date('Y-m-d H:i:s', strtotime($fechaCreacion . ' + 2 weeks'));

        // Agrega la fecha seleccionada por el usuario a la consulta de inserción
        $consulta = "INSERT INTO `tickets`(`mail`, `categoria`, `aula`, `Materia`, `Descripcion`, `UsuarioID`, `FechaCreacion`, `FechaCierre`, `Estado`, `fechaSolicitud`) 
                    VALUES ('$email', '$categoria', '$aula', '$materia', '$mensaje', '$usuarioID', '$fechaCreacion', '$fechaCierre', '$estado', '$fechaSolicitud')";

        $result = mysqli_query($connect, $consulta);

        if ($result) {
            echo "Ticket creado exitosamente.";
        } else {
            echo "Error al crear el ticket: " . mysqli_error($connect);
        }
    } else {
        echo "Usuario no encontrado.";
    }
} else {
    echo "Datos incompletos.";
}

// Configurar PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración del servidor de correo
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Reemplaza con tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'ilucero@itel.edu.ar'; // Reemplaza con tu email
    $mail->Password = 'vvfy rcay uwjt dmgx'; // Reemplaza con tu contraseña de email
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Remitente y destinatarios
    $mail->setFrom('ilucero@itel.edu.ar', 'Solicitud');
    $mail->addAddress('ianlucero2006@gmail.com'); // Reemplaza con el destinatario

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo ticket enviado';
    $mail->Body = '
        <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
            <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
                style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: \'Open Sans\', sans-serif;">
                <tr>
                    <td>
                        <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
                            align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            <!-- Logo -->
                            <tr>
                                <td style="text-align:center;">
                                <a href="https://itel.edu.ar" title="logo" target="_blank">
                                    <img width="80" src="https://itel.edu.ar/img/ITEL3.png" title="logo" alt="logo">
                                </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px;">&nbsp;</td>
                            </tr>
                            <!-- Email Content -->
                            <tr>
                                <td>
                                    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                        style="max-width:670px; background:#fff; border-radius:3px;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:0 40px;">
                                        <tr>
                                            <td style="height:40px;">&nbsp;</td>
                                        </tr>
                                        <!-- Title -->
                                        <tr>
                                            <td style="padding:0 15px; text-align:center;">
                                                <h1 style="color:#1e1e2d; font-weight:400; margin:0;font-size:32px;font-family:\'Rubik\',sans-serif;">Nueva Solicitud</h1>
                                                <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; 
                                                width:100px;"></span>
                                            </td>
                                        </tr>
                                        <!-- Details Table -->
                                        <tr>
                                            <td>
                                                <table cellpadding="0" cellspacing="0"
                                                    style="width: 100%; border: 1px solid #ededed">
                                                    <tbody>
                                                        <tr>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                Aula:</td>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                                ' . $aula . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                Materia:</td>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                                ' . $materia . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                Categoría:</td>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                                ' . $categoria . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                                Fecha:</td>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                                ' . $fechaSolicitud . '</td>
                                                        </tr>
                                                        <tr>
                                                            <td
                                                                style="padding: 10px;  border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                                Mensaje:</td>
                                                            <td
                                                                style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                                ' . $mensaje . '</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height:40px;">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    ';
    $mail->AltBody = "Aula: $aula\nMateria: $materia\nCategoría: $categoria\nFecha: $fechaSolicitud\nMensaje: $mensaje";

    $mail->send();
    echo 'El mensaje ha sido enviado';
} catch (Exception $e) {
    echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
}
