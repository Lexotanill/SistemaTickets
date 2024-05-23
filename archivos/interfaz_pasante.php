<!DOCTYPE html>
<html lang="en">
    
<?php
session_start(); // Inicia la sesión

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

    // Realizar consultas SQL para contar tickets en diferentes estados
    $consultaPendientes = "SELECT COUNT(*) AS total FROM `tickets` WHERE `estado` = 'pendiente'";
    $consultaRealizados = "SELECT COUNT(*) AS total FROM `tickets` WHERE `estado` = 'realizado'";
    $consultaRechazados = "SELECT COUNT(*) AS total FROM `tickets` WHERE `estado` = 'rechazado'";

    $resultPendientes = mysqli_query($connect, $consultaPendientes);
    $resultRealizados = mysqli_query($connect, $consultaRealizados);
    $resultRechazados = mysqli_query($connect, $consultaRechazados);

    if ($resultPendientes && $resultRealizados && $resultRechazados) {
        $rowPendientes = mysqli_fetch_assoc($resultPendientes);
        $rowRealizados = mysqli_fetch_assoc($resultRealizados);
        $rowRechazados = mysqli_fetch_assoc($resultRechazados);

        $pendientesCount = $rowPendientes['total'];
        $realizadosCount = $rowRealizados['total'];
        $rechazadosCount = $rowRechazados['total'];
    } else {
        // Manejo de errores si las consultas no son exitosas
        echo "Error en la consulta SQL. Inténtalo de nuevo.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<!-- Resto de tu código HTML -->


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrar Tickets</title>
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
                            <a href="pasante_tickets.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                                <i class="fa fa-list-ul pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Tickets</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1">
                            <a href="pasante_realizados.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
                                <i class="fa fa-check pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Realizados</span>
                            </a>
                        </li>
                        <li class="mr-3 flex-1"> 
                            <a href="pasante_rechazados.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500"> 
                                <i class="fa fa-times pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Rechazados&nbsp;</span> </a> </li>
                        <li class="mr-3 flex-1">
                            <a href="pasante_pendientes.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-purple-500">
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
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-green-200 to-green-100 border-b-4 border-green-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-green-600"><i class="fa fa-check fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                    <h2 class="font-bold uppercase text-gray-600">REALIZADOS</h2>
                                   <p class="font-bold text-3xl"><?php echo $realizadosCount; echo "  "; ?><span class="text-green-500"><i class="fas fa-caret-up"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
                    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-pink-200 to-pink-100 border-b-4 border-pink-500 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-pink-600"><i class="fas fa-times fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                  <h2 class="font-bold uppercase text-gray-600">RECHAZADOS</h2>
                                    <p class="font-bold text-3xl"><?php echo $rechazadosCount; echo "  "; ?><span class="text-pink-500"><i class="fas fa-caret-up"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                    </div>
              <div class="w-full md:w-1/2 xl:w-1/3 p-6">
                        <!--Metric Card-->
                        <div class="bg-gradient-to-b from-yellow-200 to-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-xl p-5">
                            <div class="flex flex-row items-center">
                                <div class="flex-shrink pr-4">
                                    <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-clock fa-2x fa-inverse"></i></div>
                                </div>
                                <div class="flex-1 text-right md:text-center">
                                  <h2 class="font-bold uppercase text-gray-600">pendientes</h2>
                                    <p class="font-bold text-3xl"><?php echo $pendientesCount; echo "  "; ?><span class="text-yellow-600"><i class="fas fa-caret-up"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <!--/Metric Card-->
                </div>
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
