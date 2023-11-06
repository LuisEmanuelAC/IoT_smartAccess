<?php include("../template/cabecera.php"); ?>   
<?php include("../config/bd.php"); ?>

<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$IntID=(int)$txtID;
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtIdDocente=(isset($_POST['txtIdDocente']))?$_POST['txtIdDocente']:"";
$txtCarrera=(isset($_POST['txtCarrera']))?$_POST['txtCarrera']:"";
$txtHInicio=(isset($_POST['txtHInicio']))?$_POST['txtHInicio']:"";
$txtHFinal=(isset($_POST['txtHFinal']))?$_POST['txtHFinal']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

echo $txtID;
echo $txtNombre;
echo $accion;

switch ($accion) {
    case "Agregar":
        $sql = "INSERT INTO materias (nombre, id_docente, carrera, hora_inicio, hora_final) VALUES ('$txtNombre', '$txtCarrera', '$txtHInicio', '$txtHFinal')";
        $ejec = mysqli_query($conexion,$sql);
        break;    
        
    case "Modificar":
        $sqlL= "UPDATE materias SET nombre='$txtNombre', id_docente='$txtIdDocente', carrera='$txtCarrera', hora_inicio='$txtHInicio', hora_final='$txtHFinal' WHERE id=$IntID";
        $resultado = $conexion->query($sql);
        
        header("Location:materias.php");
        break;  

    case "Cancelar":
        header("Location:materias.php");
        break;
    case "Seleccionar":
        $sql= "SELECT * FROM materias WHERE id=$IntID";
        $resultado = $conexion->query($sqlL);
        if ($resultado->num_rows > 0){
            $materia = $resultado->fetch_assoc();
            $txtNombre=$materia['nombre'];
            $txtIdDocente=$materia['id_docente'];
            $txtCarrera=$materia['carrera'];
            $txtHInicio=$materia['hora_inicio'];
            $txtHFinal=$materia['hora_final'];
        }
        break; 
    case "Borrar":
        $sql= "DELETE FROM materias WHERE id=$IntID";
        $resultado = $conexion->query($sql);
        break;
}

$sql= "SELECT * FROM materias";
$resultado = $conexion->query($sql);

$sqlL= "SELECT * FROM docentes";
$resultado2 = $conexion->query($sql);

?>

<div class="row align-items-md-stretch">
    <div class="col-md-12">
        <div
            class="h-100 p-5 text-white bg-primary border rounded-3">
            <h2>MATERIAS</h2>
            <p>Añadir las materias</p>
        </div>
    </div>      
</div>

<div>
<br/>
<br/>
</div>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos materia
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
            <label for="exampleInputEmail1">ID:</label>
            <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Nombre:</label>
            <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Carrera:</label>
            <input type="text" required class="form-control" value="<?php echo $txtCarrera; ?>" name="txtCarrera" id="txtCarrera" placeholder="Carrera">
            </div>

            <div class = "form-group">
                <label for="exampleInputEmail1">Docente:</label>
                <select required name="txtIdDocente" id="txtIdDocente" class="form-select form-select-sm" aria-label="Small select example">
                    <option selected>menu docentes</option>
                    <?php
                    if ($resultado2->num_rows > 0) {
                        // Salida de cada fila
                        while($fila = $resultado2->fetch_assoc()) { ?>
                            <option value="<?php echo $fila['id']; ?>" <?php if($txtIdDocente == $fila['id']) echo 'selected'; ?>><?php echo $fila['nombre']; ?></option>
                    <?php
                        }
                    } else {?>
                        <option value="0">nada</option>
                    <?php
                    }?>  
                </select>
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Hora inicio:</label>
            <?php $hI = date('H:i:s', strtotime($txtHInicio)); ?>
            <input type="time" required class="form-control" value="<?php echo $hI; ?>" name="txtHInicio" id="txtHInicio" placeholder="Hora de inicio de la materia">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Hora final:</label>
            <?php $hF = date('H:i:s', strtotime($txtHFinal)); ?>
            <input type="time" required class="form-control" value="<?php echo $hF; ?>" name="txtHFinal" id="txtHFinal" placeholder="Hora de final de la materia">
            </div>

            
            <br/>
            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agragar</button>
                <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>
        </form>
        </div>
    </div> 
</div>

<div class="col-md-7">
    <div class="card">
        <div class="card-header">
            Tabla de materias
            <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Carrera</th>
                        <th scope="col">Docente</th>
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
                        <td><?php echo $fila["id"]; ?></td>
                        <td><?php echo $fila["nombre"]; ?></td>
                        <td><?php echo $fila["carrera"]; ?></td>
                        <?php
                        $IntIdDoce=(int)$fila["id_docente"]; 
                        $sql = "SELECT * FROM docentes WHERE id=$IntIdDoce";
                        $resultado = $conexion->query($sql);
                        $docente = $resultado->fetch_assoc();
                        if ($resultado->num_rows > 0){?>
                            <td><?php echo $docente["nombre"]; ?></td>        
                        <?php
                        }
                        ?>
                        <?php $hI = date('H:i:s', strtotime($fila["hora_inicio"])); ?>
                        <?php $hF = date('H:i:s', strtotime($fila["hora_final"])); ?>
                        <td><?php echo $hI; ?></td>
                        <td><?php echo $hF; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $fila["id"]; ?>">
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">                
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">              
                                <!--<input type="image" name="accion" value="Seleccionar" src="../../img/icon_select.png" alt="" class="btn btn-primary">
                                <input type="image" name="accion" value="Borrar" src="../../img/icon_delate.png" alt="" class="btn btn-danger"> -->             
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
    </div>
</div>


<div class="col-md-7">
    
    
</div>

<?php include("../template/pie.php"); ?>