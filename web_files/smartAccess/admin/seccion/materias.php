<?php include("../template/cabecera.php"); ?>   
<?php include("../config/bd.php"); ?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$IntID=(int)$txtID;
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtCarrera=(isset($_POST['txtCarrera']))?$_POST['txtCarrera']:"";
$txtHInicio=(isset($_POST['txtHInicio']))?$_POST['txtHInicio']:"";
$txtHFinal=(isset($_POST['txtHFinal']))?$_POST['txtHFinal']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

switch ($accion) {
    case "Agregar":
        echo "agregar";
        $sql = "INSERT INTO materias (nombre, carrera, hora_inicio, hora_final) VALUES ('$txtNombre', '$txtCarrera', '$txtHInicio', '$txtHFinal')";
        $ejec = mysqli_query($conexion,$sql);
        break;    
        
    case "Modificar":
        echo "Modificar";
        break;  

    case "Cancelar":
        echo "Cancelar";
        break;
    case "Seleccionar":
        echo "Seleccionar";
        break; 
    case "Borrar":
        echo "Borrar";
        echo $IntID;
        $sentenSQL= "DELETE FROM materias WHERE id_materia=$IntID";
        $resultado = $conexion->query($sentenSQL);
        break;
}

$sentenSQL= "SELECT * FROM materias";
$resultado = $conexion->query($sentenSQL);

?>


<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos materia
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
            <label for="exampleInputEmail1">ID:</label>
            <input type="text" class="form-control" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Nombre:</label>
            <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Carrera:</label>
            <input type="text" class="form-control" name="txtCarrera" id="txtCarrera" placeholder="Carrera">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Hora inicio:</label>
            <input type="time" class="form-control" name="txtHInicio" id="txtHInicio" placeholder="Hora de inicio de la materia">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Hora final:</label>
            <input type="time" class="form-control" name="txtHFinal" id="txtHFinal" placeholder="Hora de final de la materia">
            </div>
            <br/>
            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agragar</button>
                <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>
        </form>
        </div>

    </div>

    
    
    
</div>
<div class="col-md-7">
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Carrera</th>
                    <th scope="col">H/inicio</th>
                    <th scope="col">H/final</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($resultado->num_rows > 0){
                while($fila = $resultado->fetch_assoc()) {
            ?>
                <tr class="">
                    <td><?php echo $fila["id_materia"]; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["carrera"]; ?></td>
                    <?php $hI = date('H:i:s', strtotime($fila["hora_inicio"])); ?>
                    <?php $hF = date('H:i:s', strtotime($fila["hora_final"])); ?>
                    <td><?php echo $hI; ?></td>
                    <td><?php echo $hF; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $fila["id_materia"]; ?>">                    
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>                    
                        
                    </td>
                </tr>
            <?php 
                }
            }
            ?>
            </tbody>
        </table>
    </div>
    
</div>

<?php include("../template/pie.php"); ?>