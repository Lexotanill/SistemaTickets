<?php
// Verificar si se ha enviado el formulario para cambiar el estado
if (isset($_POST['cambiar_estado_tickets'])) {
    // Verificar si se ha seleccionado un estado (radio button)
    if (isset($_POST['estado'])) {
        // Obtener el estado seleccionado
        $nuevo_estado = $_POST['estado'];

        session_start(); // Inicia la sesión

        include("conexion.php");
        if (!$connect) {
            die("Error de conexión a la base de datos: " . mysqli_connect_error());
        }

        // Obtener el ID del ticket a partir del formulario (ajusta esto según tu formulario)
        $ticket_id = $_POST['ticket_id'];

        // Preparar la consulta para actualizar el estado del ticket
        $sql = "UPDATE `tickets` SET `Estado` = '$nuevo_estado' WHERE `TicketID` = $ticket_id";

        // Ejecutar la consulta
        if (mysqli_query($connect, $sql)) {
            echo "Estado del ticket actualizado correctamente.";
        } else {
            echo "Error al actualizar el estado del ticket: " . mysqli_error($connect);
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($connect);
    } else {
        // Mostrar un mensaje de error si no se ha seleccionado ningún estado
        echo "Por favor, selecciona un estado para cambiar el ticket.";
    }
} else {
    // Mostrar un mensaje o redirigir si el formulario no ha sido enviado
    echo "El formulario para cambiar el estado no ha sido enviado.";
}
