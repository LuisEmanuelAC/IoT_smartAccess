<?php include("admin/config/bd.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Horario del Estudiante</title>
</head>

<body>
    <h1>AGRAGAR MATERIA</h1>
    <form method="post" action="guardar_horario.php">
        <table>
            <tr>
                <th>Materia</th>
                <th>Carrera</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td><input type="text" name="Materia[]"></td>
                <td><input type="text" name="Carrera[]"></td>
                <td><input type="time" name="Hora_inicio[]"></td>
                <td><input type="time" name="Hora_final[]"></td>
                <td><button type="button" id="agregarFila">Agregar Fila</button></td>
            </tr>
        </table>
        <input type="submit" value="Guardar Horario">
    </form>

    <script>
        document.getElementById('agregarFila').addEventListener('click', function() {
            const fila = document.querySelector('table tr:last-child').cloneNode(true);
            const inputs = fila.querySelectorAll('input');
            inputs.forEach(input => input.value = '');
            document.querySelector('table').appendChild(fila);
        });
    </script>
</body>

<body>
    <h1>HORARIO</h1>

    <table border="1">
        <tr>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Hora de Entrada</th>
            <th>Hora de Salida</th>
        </tr>

        <?php
        $consulta = "SELECT Nombre, Carrera, Hora_inicio, Hora_final FROM materias";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $fila['Nombre'] . "</td>";
                echo "<td>" . $fila['Carrera'] . "</td>";
                $hora1 = date('H:i:s', strtotime($fila["Hora_inicio"]));
                $hora2 = date('H:i:s', strtotime($fila["Hora_final"]));
                echo "<td>" . $hora1 . "</td>";
                echo "<td>" . $hora2 . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron registros.</td></tr>";
        }

        $conexion->close();
        ?>
    </table>
</body>

</html>
 