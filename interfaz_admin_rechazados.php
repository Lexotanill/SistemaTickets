<?php
session_start(); // Inicia la sesión

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Determinar la página actual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$tickets_por_pagina = 6;
$offset = ($pagina - 1) * $tickets_por_pagina;

// Consulta para obtener los tickets rechazados con límite y offset
$consulta_tickets_rechazados = "SELECT `TicketID`, `aula`, `materia`, `Descripcion`, `Estado`, `FechaCreacion`, `categoria` FROM `tickets` WHERE `Estado` = 'Rechazado' LIMIT $tickets_por_pagina OFFSET $offset";
$result_tickets_rechazados = mysqli_query($connect, $consulta_tickets_rechazados);

if (!$result_tickets_rechazados) {
    die("Error en la consulta: " . mysqli_error($connect));
}

$consulta_total_tickets_rechazados = "SELECT COUNT(*) as total FROM `tickets` WHERE `Estado` = 'Rechazado'";
$result_total_tickets_rechazados = mysqli_query($connect, $consulta_total_tickets_rechazados);
$total_tickets_rechazados = mysqli_fetch_assoc($result_total_tickets_rechazados)['total'];
$total_paginas = ceil($total_tickets_rechazados / $tickets_por_pagina);
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
            <h1 id="titulo"><i class="bi bi-x-circle-fill"></i>Rechazados</h1>
            <div class="contenedor-tabla">
                <div class="subtitulo">
                    <h1 class="contenido-subtitulo">
                        Tickets Rechazados
                    </h1>
                </div>

                <table class="blueTable">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Aula</th>
                            <th>Materia</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Fecha de creaci&oacute;n</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="6">
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
                        while ($row = mysqli_fetch_assoc($result_tickets_rechazados)) {
                            echo "<tr>";
                            echo "<td>{$row['TicketID']}</td>";
                            echo "<td>{$row['aula']}</td>";
                            echo "<td>{$row['materia']}</td>";
                            echo "<td>{$row['Descripcion']}</td>";
                            echo "<td>{$row['Estado']}</td>";
                            echo "<td>{$row['FechaCreacion']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>