<?php
session_start(); // Inicia la sesión

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que la ruta a autoload.php de PHPMailer sea correcta

// Determinar la página actual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$tickets_por_pagina = 6;
$offset = ($pagina - 1) * $tickets_por_pagina;

// Procesar el formulario si se ha enviado
if (isset($_POST['submit'])) {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'estado_') === 0) {
            $ticketID = str_replace('estado_', '', $key);
            $nuevo_estado = mysqli_real_escape_string($connect, $value);

            // Actualizar el estado del ticket en la base de datos
            $update_query = "UPDATE `tickets` SET `Estado` = '$nuevo_estado' WHERE `TicketID` = $ticketID";
            if (!mysqli_query($connect, $update_query)) {
                die("Error al actualizar el estado del ticket $ticketID: " . mysqli_error($connect));
            }

            // Consultar la información del ticket actualizado
            $consulta_ticket = "SELECT `TicketID`, `aula`, `materia`, `Descripcion`, `Estado`, `FechaCreacion`, `categoria`, `mail` FROM `tickets` WHERE `TicketID` = $ticketID";
            $result_ticket = mysqli_query($connect, $consulta_ticket);
            $row = mysqli_fetch_assoc($result_ticket);

            // Enviar correo electrónico si el estado es "Realizado" o "Rechazado"
            if ($nuevo_estado == 'Realizado' || $nuevo_estado == 'Rechazado') {
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

                    // Configuración del correo
                    $mail->setFrom('ilucero@itel.edu.ar', 'Sistema de Tickets');
                    $mail->addAddress($row['mail']); // Dirección del destinatario

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = 'Actualización de Estado de Ticket';
                    $mail->Body    = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización de Estado de Ticket</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f3f8;
            font-family: \'Open Sans\', sans-serif;
        }
        .container {
            max-width: 670px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 3px;
            box-shadow: 0 6px 18px 0 rgba(0, 0, 0, 0.06);
        }
        .header {
            padding: 40px 0;
            text-align: center;
        }
        .header img {
            width: 80px;
        }
        .content {
            padding: 0 40px;
        }
        .content h1 {
            color: #1e1e2d;
            font-weight: 400;
            font-size: 32px;
            margin: 0;
        }
        .content hr {
            border: 1px solid #cecece;
            width: 100px;
            margin: 29px 0 26px;
        }
        .content p {
            color: #455056;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="container">
        <tr>
            <td class="header">
                <img src="https://itel.edu.ar/img/ITEL3.png" title="logo" alt="logo">
            </td>
        </tr>
        <tr>
            <td class="content">
                <h1>Actualización de Ticket</h1>
                <hr>
                <p>Estimado(a),</p>
                <p>Le informamos que el estado de su ticket con ID <strong>' . $ticketID . '</strong> ha sido actualizado a: <strong>' . $nuevo_estado . '</strong>.</p>
                <p>Detalles del ticket:</p>
                <p><strong>Aula:</strong> ' . $row['aula'] . '</p>
                <p><strong>Materia:</strong> ' . $row['materia'] . '</p>
                <p><strong>Descripción:</strong> ' . $row['Descripcion'] . '</p>
                <p>Gracias por su paciencia y colaboración.</p>
                <p>Saludos cordiales,</p>
                <p>Equipo de Soporte</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                &copy; ' . date('Y') . ' ITEL. Todos los derechos reservados.
            </td>
        </tr>
    </table>
</body>
</html>';


                    $mail->send();
                } catch (Exception $e) {
                    echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    }
}

// Consulta para obtener los tickets pendientes con límite y offset
$consulta_tickets_pendientes = "SELECT `TicketID`, `aula`, `materia`, `Descripcion`, `Estado`, `FechaCreacion`, `categoria` FROM `tickets` WHERE `Estado` = 'pendiente' LIMIT $tickets_por_pagina OFFSET $offset";
$result_tickets_pendientes = mysqli_query($connect, $consulta_tickets_pendientes);

if (!$result_tickets_pendientes) {
    die("Error en la consulta: " . mysqli_error($connect));
}

$consulta_total_tickets = "SELECT COUNT(*) as total FROM `tickets` WHERE `Estado` = 'pendiente'";
$result_total_tickets = mysqli_query($connect, $consulta_total_tickets);
$total_tickets = mysqli_fetch_assoc($result_total_tickets)['total'];
$total_paginas = ceil($total_tickets / $tickets_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jersey+25+Charted&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/interfaz_admin_pendientes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Sistema de Tickets</title>
</head>

<body>
    <div class="contego">
        <div class="panel1">
            <h1>Sistema de Tickets</h1>
            <h1><i class="bi bi-person-circle"></i></h1>
        </div>
        <div class="panel2">
            <h1>Menú</h1>
            <div class="lista">
                <a href="interfaz_admin.php"><i class="bi bi-clipboard2-check"></i>Tickets</a>
                <a href="interfaz_admin_pendientes.php"><i class="bi bi-clock-fill"></i>Pendientes</a>
                <a href="interfaz_admin_realizados.php"><i class="bi bi-check-circle-fill"></i>Realizados</a>
                <a href="interfaz_admin_rechazados.php"><i class="bi bi-x-circle-fill"></i>Rechazados</a>
                <a href="#"><i class="bi bi-calendar-week-fill"></i>Calendario</a>
                <a href="interfaz_inventario.php"><i class="bi bi-backpack4-fill"></i>Inventario</a>
            </div>
        </div>
        <div class="panel3">
            <h1 id="titulo"><i class="bi bi-clock-fill"></i>Pendientes</h1>
            <div class="contenedor-tabla">
                <div class="subtitulo">
                    <h1 class="contenido-subtitulo">
                        Tickets Pendientes
                    </h1>
                </div>

                <table class="blueTable page1">
                    <form method="post" action="">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Aula</th>
                                <th>Materia</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Fecha de creaci&oacute;n</th>
                                <th>Categoría</th>
                                <th><i class="bi bi-check-circle-fill"></i></th>
                                <th><i class="bi bi-x-circle-fill"></i></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="9">
                                    <div class="links">
                                        <?php if ($pagina > 1) : ?>
                                            <a href="?pagina=<?php echo $pagina - 1; ?>">&laquo;</a>
                                        <?php endif; ?>
                                        <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                                            <a href="?pagina=<?php echo $i; ?>" <?php if ($i == $pagina) echo 'class="active"'; ?>><?php echo $i; ?></a>
                                        <?php endfor; ?>
                                        <?php if ($pagina < $total_paginas) : ?>
                                            <a href="?pagina=<?php echo $pagina + 1; ?>">&raquo;</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result_tickets_pendientes)) {
                                $ticketID = $row['TicketID'];
                                $realizado_checked = '';
                                $rechazado_checked = '';

                                if (isset($_POST['estado_' . $ticketID])) {
                                    $selected_value = $_POST['estado_' . $ticketID];
                                    $realizado_checked = ($selected_value == 'Realizado') ? 'checked' : '';
                                    $rechazado_checked = ($selected_value == 'Rechazado') ? 'checked' : '';
                                }

                                echo "<tr>";
                                echo "<td>{$row['TicketID']}</td>";
                                echo "<td>{$row['aula']}</td>";
                                echo "<td>{$row['materia']}</td>";
                                echo "<td>{$row['Descripcion']}</td>";
                                echo "<td>{$row['Estado']}</td>";
                                echo "<td>{$row['FechaCreacion']}</td>";
                                echo "<td>{$row['categoria']}</td>";
                                echo '<td>';
                                echo '<input class="radio" type="radio" name="estado_' . $ticketID . '" value="Realizado" ' . $realizado_checked . '>';
                                echo '</td>';
                                echo '<td>';
                                echo '<input class="radio" type="radio" name="estado_' . $ticketID . '" value="Rechazado" ' . $rechazado_checked . '>';
                                echo '</td>';
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                </table>
                <input type="submit" name="submit" value="Guardar Cambios">
                </form>
            </div>
        </div>
    </div>
</body>

</html>