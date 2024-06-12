<?php
session_start(); // Inicia la sesión

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Contar tickets por estado
$consulta_tickets_realizados = "SELECT COUNT(*) as total_realizados FROM `tickets` WHERE `Estado` = 'Realizado'";
$result_realizados = mysqli_query($connect, $consulta_tickets_realizados);
$total_realizados = mysqli_fetch_assoc($result_realizados)['total_realizados'];

$consulta_tickets_rechazados = "SELECT COUNT(*) as total_rechazados FROM `tickets` WHERE `Estado` = 'Rechazado'";
$result_rechazados = mysqli_query($connect, $consulta_tickets_rechazados);
$total_rechazados = mysqli_fetch_assoc($result_rechazados)['total_rechazados'];

$consulta_tickets_pendientes = "SELECT COUNT(*) as total_pendientes FROM `tickets` WHERE `Estado` = 'Pendiente'";
$result_pendientes = mysqli_query($connect, $consulta_tickets_pendientes);
$total_pendientes = mysqli_fetch_assoc($result_pendientes)['total_pendientes'];

// Obtener tickets recientes
$consulta_tickets_recientes = "SELECT `TicketID`, `aula`, `Descripcion` FROM `tickets` ORDER BY `FechaCreacion` DESC LIMIT 5";
$result_tickets_recientes = mysqli_query($connect, $consulta_tickets_recientes);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="style/interfaz_admin.css">
    <title>Sistema de Tickets</title>
</head>

<body>
    <div class="contego">
        <div class="panel1">
            <h1>Sistema de Tickets</h1>
            <h1 id="#i"><i class="bi bi-person-circle"></i></h1>
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
            <h1 id="titulo"><i class="bi bi-ticket-perforated-fill"></i>Tickets</h1>
            <div class="subcontenedor">
                <div class="estados">
                    <div class="listo" id="contenedor">
                        <div class="rea" id="icono"><i class="bi bi-check-circle-fill"></i></div>
                        <div id="contenido">
                            <h3>Realizados</h3>
                            <p><?php echo $total_realizados; ?></p>
                            <i class="bi bi-caret-up-fill"></i>
                        </div>
                    </div>
                    <div class="rechazado" id="contenedor">
                        <div class="rec" id="icono"><i class="bi bi-x-circle-fill"></i></div>
                        <div id="contenido">
                            <h3>Rechazados</h3>
                            <p><?php echo $total_rechazados; ?></p>
                            <i class="bi bi-caret-up-fill"></i>
                        </div>
                    </div>
                    <div class="pendientes" id="contenedor">
                        <div class="pen" id="icono"><i class="bi bi-clock-fill"></i></div>
                        <div id="contenido">
                            <h3>Pendientes</h3>
                            <p><?php echo $total_pendientes; ?></p>
                            <i class="bi bi-caret-up-fill"></i>
                        </div>
                    </div>
                </div>

                <div class="otros">
                    <div class="recientes">
                        <div class="titulado">
                            <h1>Evento Próximo</h1>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Aula</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_tickets_recientes)) {
                                    echo "<tr>";
                                    echo "<td>{$row['TicketID']}</td>";
                                    echo "<td>{$row['aula']}</td>";
                                    echo "<td>{$row['Descripcion']}</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="eventos">
                        <div class="titulado">
                            <h1>Evento Próximo</h1>
                        </div>
                        <ul>
                            <li>Evento 1</li>
                            <li>Evento 2</li>
                            <li>Evento 3</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>