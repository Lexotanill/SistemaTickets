<?php
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');

include("conexion.php");
if (!$connect) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

function Importar($archivoExcel, $conexion)
{
    echo '<link rel="stylesheet" type="text/css" href="style/result_inventario.css">';

    $documento = IOFactory::load($archivoExcel);
    $hoja = $documento->getActiveSheet();
    $filas = $hoja->getHighestDataRow();

    echo "<div class='container'>";

    for ($fila = 2; $fila <= $filas; $fila++) {
        $objeto = $hoja->getCell('A' . $fila)->getValue();
        $cantidad = $hoja->getCell('B' . $fila)->getValue();
        $especificaciones = $hoja->getCell('C' . $fila)->getValue();

        // Verificar si el objeto ya existe en la base de datos
        $verificarConsulta = "SELECT COUNT(*) AS count FROM `inventario` WHERE `objeto` = '$objeto' AND `especificaciones` = '$especificaciones'";
        $resultado = mysqli_query($conexion, $verificarConsulta);
        $filaResultado = mysqli_fetch_assoc($resultado);

        if ($filaResultado['count'] == 0) {

            // Inserción en la base de datos
            $consulta = "INSERT INTO `inventario`(`objeto`, `cantidad`, `especificaciones`) 
                        VALUES ('$objeto', '$cantidad', '$especificaciones')";      
            
            if (mysqli_query($conexion, $consulta)) {
                echo "<div class='success'>Fila insertada correctamente: $objeto - $cantidad</div>";
            } else {
                echo "<div class='error'>Error al insertar la fila $fila: " . mysqli_error($conexion) . "</div>";
            }
        } else {
            echo "<div class='warning'>El objeto '$objeto' '$especificaciones' ya existe en la base de datos. No se ha insertado.</div>";
        }
    }
    echo "</div>";

}

if (isset($_POST['send'])):
    if (isset($_FILES['excel']) && $_FILES['excel']['size'] > 0):
        if ($_FILES['excel']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || 
            $_FILES['excel']['type'] == 'application/vnd.ms-excel'):
            $archivoContent = $_FILES['excel']['tmp_name'];
            Importar($archivoContent, $connect);
            echo "Estas troll, no es un archivo Excel válido.";
        endif;
        echo "No se seleccionó archivo o el archivo está vacío.";
    endif;
endif;
?>
