<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado un estado válido
    if (isset($_POST['estado'])) {
        // Conectarse a la base de datos (reemplaza estas líneas con tu lógica de conexión)
        $host = "tu_host";
        $usuario = "tu_usuario";
        $contrasena = "tu_contraseña";
        $base_de_datos = "tu_base_de_datos";

        include("conexion.php");
        if (!$connect) {
            die("Error de conexión a la base de datos: " . mysqli_connect_error());
        }

        // Obtener el ticket_id y el nuevo estado
        $ticket_id = $_POST['ticket_id'];
        $nuevo_estado = $_POST['estado']; // El valor seleccionado del radio button

        // Verificar que el estado sea uno de los valores permitidos (Realizado, Pendiente, Rechazado)
        $estados_permitidos = ['Realizado', 'Pendiente', 'Rechazado'];
        if (!in_array($nuevo_estado, $estados_permitidos)) {
            echo "Estado no válido.";
            // Finalizar el script o redirigir según tu lógica
        }

        // Actualizar el estado del ticket en la base de datos
        $consulta_actualizar_estado = "UPDATE `tickets` SET `Estado` = '$nuevo_estado' WHERE `TicketID` = $ticket_id";

        if (mysqli_query($conexion, $consulta_actualizar_estado)) {
            echo "Estado actualizado correctamente.";
        } else {
            echo "Error al actualizar el estado del ticket: " . mysqli_error($conexion);
        }

        // Cerrar la conexión
        mysqli_close($conexion);
    } else {
        echo "No se ha seleccionado un estado.";
    }
} else {
    echo "Acceso no autorizado.";
}
