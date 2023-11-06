<?php include("../template/cabecera.php"); ?>   
<?php include("../config/bd.php"); ?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$IntID=(int)$txtID;
$usua_txtNombre=(isset($_POST['usua_txtNombre']))?$_POST['usua_txtNombre']:"";
$usua_txtCorreo=(isset($_POST['usua_txtCorreo']))?$_POST['usua_txtCorreo']:"";
$usua_txtContr=(isset($_POST['usua_txtContr']))?$_POST['usua_txtContr']:"";
$usua_txtTurno=(isset($_POST['usua_txtTurno']))?$_POST['usua_txtTurno']:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";


switch ($accion) {
    case "Agregar":
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, turno, tipo_u) VALUES ('$usua_txtNombre', '$usua_txtCorreo', '$usua_txtContr', '$usua_txtTurno', 'admin')";
        if ($conexion->query($sql) !== TRUE) { echo "Error: " . $sql . "<br>" . $conexion->error; }
        
        header("Location:admins.php");
        break;    
        
    case "Modificar":     

        $sql = "UPDATE usuarios SET nombre='$usua_txtNombre', correo='$usua_txtCorreo', contrasena='$usua_txtContr', tipo_u='$usua_txtTipoU', turno='$usua_txtTurno' WHERE id=$IntID";
        $resultado = $conexion->query($sql);
        
        header("Location:admins.php");
        break;  

    case "Cancelar":
        header("Location:admins.php");
        break;
    case "Seleccionar":      
        $sql = "SELECT * FROM usuarios WHERE id=$IntID";
        $resultado2 = $conexion->query($sql);
        $usuario = $resultado2->fetch_assoc();
        if ($resultado2->num_rows > 0){  
            $usua_txtNombre=$usuario['nombre'];
            $usua_txtCorreo=$usuario['correo'];
            $usua_txtContr=$usuario['contrasena'];     
            $usua_txtTurno=$usuario['turno'];
        }   
        break;
         
    case "Borrar": 
        $sql = "DELETE FROM usuarios WHERE id=$IntID";
        $resultado = $conexion->query($sql);        
        break;
}

$sql = "SELECT * FROM usuarios";
$resultado = $conexion->query($sql);

?>

<div class="row align-items-md-stretch">
    <div class="col-md-12">
        <div
            class="h-100 p-5 text-white bg-primary border rounded-3">
            <h2>ADMINISTRADORES</h2>
            <p>Añadir los administradores</p>
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
            Datos Alumno
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
            <label for="exampleInputEmail1">ID:</label>
            <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Nombre alumno:</label>
            <input type="text" required class="form-control" value="<?php echo $usua_txtNombre; ?>" name="usua_txtNombre" id="usua_txtNombre" placeholder="Nombre Alumno">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Correo alumno:</label>
            <input type="text" required class="form-control" value="<?php echo $usua_txtCorreo; ?>" name="usua_txtCorreo" id="usua_txtCorreo" placeholder="Correo Alumno">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Contraseña alumno:</label>
            <input type="text" required class="form-control" value="<?php echo $usua_txtContr; ?>" name="usua_txtContr" id="usua_txtContr" placeholder="Contraseña Alumno">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Turno alumno:</label>
            <select required name="usua_txtTurno" id="usua_txtTurno" class="form-select form-select-sm" aria-label="Small select example">
                <option selected>Turnos</option>
                <option value="manana" <?php if($usua_txtTurno == 'manana') echo 'selected'; ?>>Mañana</option>
                <option value="tarde" <?php if($usua_txtTurno == 'tarde') echo 'selected'; ?>>Tarde</option>
                <option value="dTurnos" <?php if($usua_txtTurno == 'dTurnos') echo 'selected'; ?>>Dos turnos</option>
            </select>
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
                        <th scope="col">Correo</th>
                        <th scope="col">Contraseña</th>            
                        <th scope="col">Turno</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($resultado->num_rows > 0){
                    while($fila = $resultado->fetch_assoc()) {
                        if($fila["tipo_u"] == "admin"){
                ?>
                        <tr class="">
                            <td><?php echo $fila["id"]; ?></td>
                            <td><?php echo $fila["nombre"]; ?></td>
                            <td><?php echo $fila["correo"]; ?></td>
                            <td><?php echo $fila["contrasena"]; ?></td>
                            <td><?php echo $fila["turno"]; ?></td> 
                                        
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
                        ?>
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

<?php include("../template/pie.php"); ?>