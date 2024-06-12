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
    <title>Sistema de Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/interfaz_inventario.css">

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
            <h1 id="titulo"><i class="bi bi-backpack4-fill"></i>Inventario</h1>
            <div class="contenedor">
                <div class="contenedor-tabla">
                    <?php
                    include("conexion.php");
                    if ($connect->connect_error) {
                        die("Connection failed: " . $connect->connect_error);
                    }

                    $resultados_por_pagina = 6;

                    if (isset($_GET['pagina'])) {
                        $pagina = $_GET['pagina'];
                    } else {
                        $pagina = 1;
                    }

                    $inicio_desde = ($pagina - 1) * $resultados_por_pagina;

                    $consulta = "SELECT * FROM inventario LIMIT $inicio_desde, $resultados_por_pagina";
                    $resultado = $connect->query($consulta);

                    echo '<table class="blueTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Objeto</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>';

                    while ($fila = $resultado->fetch_assoc()) {
                        echo '<tr>
                                <td>' . $fila['id'] . '</td>
                                <td>' . $fila['objeto'] . ' ' . $fila['especificaciones'] . '</td>
                                <td>' . $fila['cantidad'] . '</td>

                            </tr>';
                    }

                    echo '  </tbody>
                        </table>';

                    $consulta_total = "SELECT COUNT(*) FROM inventario";
                    $resultado_total = $connect->query($consulta_total);
                    $fila_total = $resultado_total->fetch_row();
                    $total_paginas = ceil($fila_total[0] / $resultados_por_pagina);

                    echo '<div class="links">';
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        echo '<a href="interfaz_inventario.php?pagina=' . $i . '">' . $i . '</a> ';
                    }
                    echo '</div>';

                    $connect->close();
                    ?>



                </div>
                <div class="boton-contenedor">
                    <form action="importar_excel.php" method="post" enctype="multipart/form-data">
                        <label for="" class="form-label">
                            Importe un excel
                        </label>
                        <input type="file" name="excel" id="excel" class="form-control">
                        <button class="btn btn-primary mt-2" name="send">Importar datos</button>
                    </form>
                    <button class="btn btn-primary mt-2" name="send">Actualizar Modificaciones</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>