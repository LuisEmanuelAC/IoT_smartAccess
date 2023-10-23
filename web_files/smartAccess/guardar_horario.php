<?php
// Establecer la conexión con la base de datos (ajusta los valores según tu configuración)
include("admin/config/bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $materias = $_POST["Materia"];
    $salones = $_POST["Carrera"];
    $horas_entrada = $_POST["Hora_inicio"];
    $horas_salida = $_POST["Hora_final"];

    // Recorre los datos y guárdalos en la base de datos
    for ($i = 0; $i < count($materias); $i++) {
        $Materia = $materias[$i];
        $Carrera = $salones[$i];
        $Hora_inicio = $horas_entrada[$i];
        $Hora_final = $horas_salida[$i];

        // Prepara la consulta SQL para insertar los datos
        $sql = "INSERT INTO materias (Materia, Carrera, Hora_inicio, Hora_final) VALUES ('$Materia', '$Carrera', '$Hora_inicio', '$Hora_final')";

        if ($conn->query($sql) === TRUE) {
            echo "Horario guardado correctamente.";
        } else {
            echo "Error al guardar el horario: " . $conn->error;
        }
    }

    $conn->close();
}
?>
