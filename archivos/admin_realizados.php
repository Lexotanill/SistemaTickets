<!DOCTYPE html>
<?php
session_start(); // Inicia la sesión

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

    // Realizar consultas SQL para contar tickets en diferentes estados
    $consultaRealizados = "SELECT COUNT(*) AS total FROM `tickets` WHERE `estado` = 'realizado'";

    $resultRealizados = mysqli_query($connect, $consultaRealizados);

    if ($resultRealizados) {
        $rowRealizados = mysqli_fetch_assoc($resultRealizados);

        $realizadosCount = $rowRealizados['total'];
    } else {
        // Manejo de errores si las consultas no son exitosas
        echo "Error en la consulta SQL. Inténtalo de nuevo.";
    }

?>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tickets Realizados</title>
    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <link rel="stylesheet" href="indec.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/> <!--Replace with your tailwind.css once created-->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> <!--Totally optional :) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>

</head>

<body class="bg-gray-800 font-sans leading-normal tracking-normal mt-12">

<header>
    <!--Nav-->
    <nav aria-label="menu nav" class="bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">

        <div class="flex flex-wrap items-center">
            <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
                <span class="relative w-full">                </span>
            </div>

            <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                    <li class="flex-1 md:flex-none md:mr-3"> </li>
                    <li class="flex-1 md:flex-none md:mr-3"> </li>
                </ul>
            </div>
        </div>

    </nav>
</header>


<main>

    <div class="flex flex-col md:flex-row">
        <nav aria-label="alternative nav">
            <div class="bg-gray-800 shadow-xl h-20 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48 content-center">

                <div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                    <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                        <li class="mr-3 flex-1">
                            <a href="interfaz_admin.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                                <i class="fa fa-list-ul pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Tickets</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="admin_realizados.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                                <i class="fa fa-check pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Realizados</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1"> 
                            <a href="admin_rechazados.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500"> 
                                <i class="fa fa-times pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Rechazados&nbsp;</span> </a> </li>
                        <li class="mr-3 flex-1">
                            <a href="admin_pendientes.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                                <i class="fas fa-clock pr-0 md:pr-3 "></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Pendientes</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section>
          <div id="main" class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">

                <div class="bg-gray-800 pt-3">
                    <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                        <h1 class="font-bold pl-2">Tickets</h1>
                    </div>
                </div>

             <div class="flex flex-wrap">
             <div class="flex flex-wrap">
             <div class="flex flex-wrap">
             <div class="flex flex-wrap">
             <div class="flex flex-wrap">
             <div class="flex flex-wrap">
             <?php
// Realiza la consulta para obtener los tickets pendientes
$consultaTicketsRealizados = "SELECT * FROM `tickets` WHERE `Estado` = 'realizado'";
$resultTicketsRealizados = mysqli_query($connect, $consultaTicketsRealizados);

if ($resultTicketsRealizados) {
    // Muestra los resultados en una tabla con líneas divisorias
    echo '<form method="post" action="admin_pendientes.php">'; // Formulario para procesar los tickets marcados
    echo '<table class="tg" style="margin: 0 auto; text-align: center;">';
    echo '<thead>
        <tr>
            <td class="tg-0pky">Ticket ID</td>
            <td class="tg-0pky">Aula</td>
            <td class="tg-0pky">Materia</td>
            <td class="tg-0pky">Descripción</td>
            <td class="tg-0pky">Estado</td>
            <td class="tg-0pky">Fecha de Creación</td>
            <td class="tg-0pky">Usuario ID</td>
        </tr>
    </thead>';

    while ($rowTicket = mysqli_fetch_assoc($resultTicketsRealizados)) {
        // Calcula la fecha límite (dos semanas atrás)
        $fechaCreacion = strtotime($rowTicket['FechaCreacion']);
        $fechaLimite = strtotime('-2 week');

        // Comprueba si ha pasado más de dos semanas desde la creación del ticket
        if ($fechaCreacion < $fechaLimite) {
            // Realiza la eliminación del ticket en la base de datos
            $ticketID = $rowTicket['TicketID'];
            $consultaEliminar = "DELETE FROM `tickets` WHERE `TicketID` = '$ticketID'";
            mysqli_query($connect, $consultaEliminar);
            continue;  // Salta al siguiente ticket sin mostrarlo en la tabla
        }

        echo '<tr>';
        echo '<td>' . $rowTicket['TicketID'] . '</td>';
        echo '<td>' . $rowTicket['aula'] . '</td>';
        echo '<td>' . $rowTicket['materia'] . '</td>';
        echo '<td>' . $rowTicket['Descripcion'] . '</td>';
        echo '<td>' . $rowTicket['Estado'] . '</td>';
        echo '<td>' . date('d/m/Y h:i A', $fechaCreacion) . '</td>';
        echo '<td>' . $rowTicket['UsuarioID'] . '</td>';
        echo '</tr>';
    }

} else {
    // Manejo de errores si la consulta no es exitosa
    echo "Error en la consulta SQL para los tickets pendientes. Inténtalo de nuevo.";
}
?>

                </div>

</div>
</section>
    </div>
</main>




<script>
    /*Toggle dropdown list*/
    function toggleDD(myDropMenu) {
        document.getElementById(myDropMenu).classList.toggle("invisible");
    }
    /*Filter dropdown options*/
    function filterDD(myDropMenu, myDropMenuSearch) {
        var input, filter, ul, li, a, i;
        input = document.getElementById(myDropMenuSearch);
        filter = input.value.toUpperCase();
        div = document.getElementById(myDropMenu);
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                a[i].style.display = "";
            } else {
                a[i].style.display = "none";
            }
        }
    }
    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
            var dropdowns = document.getElementsByClassName("dropdownlist");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (!openDropdown.classList.contains('invisible')) {
                    openDropdown.classList.add('invisible');
                }
            }
        }
    }
</script>


</body>

</html>
