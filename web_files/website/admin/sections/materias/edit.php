<?php 

include("../../config/bd.php");
//exportar de la BD a la tabla
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("SELECT * FROM tbl_materias WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis=$sql->fetch(PDO::FETCH_LAZY);

    $nombre=$regis['nombre'];
    $ID_docente=$regis['ID_docente'];
    $aula=$regis['aula'];
    $turno=$regis['turno'];
    $creditos=$regis['creditos'];
    $horario=$regis['horario'];

    $list_horario = explode("$", $horario); 
    

}
//actualizar el servicio
if ($_POST) {

    $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
    $ID_docente=(isset($_POST['ID_docente']))?$_POST['ID_docente']:"";
    $aula=(isset($_POST['aula']))?$_POST['aula']:"";
    $turno=(isset($_POST['turno']))?$_POST['turno']:"";
    $creditos=(isset($_POST['creditos']))?$_POST['creditos']:"";
    $list_horario=(isset($_POST['horario']))?$_POST['horario']:"";

    $horario="";
    foreach ($list_horario as $index => $dia) {
        if ($index == 0) {
            $horario=$dia;
        }
        if (count($list_horario) > 1 && $index >= 1) {
            $horario=$horario.",".$dia;
        }
    } 

    $sql=$conn->prepare("UPDATE `tbl_materias` SET nombre=:nombre, ID_docente=:ID_docente, aula=:aula, turno=:turno, creditos=:creditos, horario=:horario WHERE ID=:ID");

    $sql->bindParam(":ID",$txtID);    
    $sql->bindParam(":nombre",$nombre, PDO::PARAM_STR);  
    $sql->bindParam(":ID_docente",$ID_docente);
    $sql->bindParam(":aula",$aula);
    $sql->bindParam(":turno",$turno);
    $sql->bindParam(":creditos",$creditos, PDO::PARAM_STR);
    $sql->bindParam(":horario",$horario);
    $sql->execute();
    
    $message="successfully-modified";
    header("Location:index.php?message=".$message);
}

// lista de docentes
$sql=$conn->prepare("SELECT d.ID as ID, u.nombre as nombre, d.carrera as carrera 
FROM tbl_usuarios u
JOIN tbl_docentes d ON u.ID = d.ID_usuario");                                           
$sql->execute();
$list_docentes=$sql->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Editar materia</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de actualizar para modificar el materia</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Mataria: <?php echo $txtID; ?></h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <div class="form-group">
                    <input value="<?php echo $nombre;?>" type="text" class="form-control form-control-user"
                        name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre... " required>
                </div>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand">Docentes</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="ID_docente" id="ID_docente"
                                class="form-select form-select-sm form-control" aria-label="Small select example">
                                <option selected>menu docentes</option>
                                <?php
                                if ($list_docentes) {
                                    // Salida de cada fila
                                    foreach($list_docentes as $regis_d){ ?>
                                <option value="<?php echo $regis_d['ID']; ?>"
                                    <?php if($ID_docente == $regis_d['ID']) echo 'selected'; ?>>
                                    <?php echo $regis_d['ID'] . "Maestro: " . $regis_d['nombre'] . "   || Carrera: " . $regis_d['carrera'] ; ?>
                                </option>
                                <?php
                                    }
                                } else {?>
                                <option value="0">nada</option>
                                <?php
                                }?>
                            </select>
                        </li>
                    </ul>
                </nav>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand">Aula</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="aula" id="aula" class="form-select form-select-sm form-control"
                                aria-label="Small select example" require>
                                <option selected>Aulas</option>
                                <option value="LC1" <?php if($aula == 'LC1') echo 'selected'; ?>>LC1</option>
                                <option value="LC2" <?php if($aula == 'LC2') echo 'selected'; ?>>LC2</option>
                                <option value="LC3" <?php if($aula == 'LC3') echo 'selected'; ?>>LC3</option>
                                <option value="LC4" <?php if($aula == 'LC4') echo 'selected'; ?>>LC4</option>
                                <option value="LC5" <?php if($aula == 'LC5') echo 'selected'; ?>>LC5</option>
                                <option value="LC6" <?php if($aula == 'LC6') echo 'selected'; ?>>LC6</option>

                            </select>
                        </li>
                    </ul>
                </nav>



                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand">Turno</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="turno" id="turno" class="form-select form-select-sm form-control"
                                aria-label="Small select example" require>
                                <option selected>Turno</option>
                                <option value="matu" <?php if($turno == 'matu') echo 'selected'; ?>>Matutino
                                </option>
                                <option value="vesp" <?php if($turno == 'vesp') echo 'selected'; ?>>
                                    Vespertino</option>
                                <option value="d_t" <?php if($turno == 'd_t') echo 'selected'; ?>>Doble turno
                                </option>
                            </select>
                        </li>
                    </ul>
                </nav>

                <br>

                <div class="form-group">
                    <input value="<?php echo $creditos;?>" type="text" class="form-control form-control-user"
                        name="creditos" id="creditos" aria-describedby="helpId" placeholder="Creditos... " required>
                </div>

                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Horario</h6>
                        </div>
                        <div class="card-body" id="horarioContainer">

                            <?php 
                            $dia = "";
                            $hi = "";
                            $hf = "";
                            $list_horario = explode("$", $regis['horario']);               
                                foreach ($list_horario as $key => $value) { ?>
                            <?php
                                        $horario_dia = explode(",", $value);                   
                                        for ($i=0; $i < count($horario_dia); $i++) { 
                                            switch ($horario_dia[$i]) {
                                                case 'd>':
                                                    $i++;                                        
                                                    $dia = $horario_dia[$i];                                     
                                                    break;
                                                
                                                case 'hi>':
                                                    $i++;                                     
                                                    $hi = $horario_dia[$i];                                     
                                                    break;

                                                case 'hf>':
                                                    $i++;                                           
                                                    $hf = $horario_dia[$i];                                     
                                                    break;
                                                default:
                                                    break;                                        
                                            }
                                        }?>
                            <nav class="navbar navbar-expand navbar-light bg-light md-4">
                                <a class="navbar-brand">Día: <?php echo ++$key; ?></a>
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <input value="d>" type="text" class="form-control" name="horario[]" id="horario"
                                            style="display: none;">
                                        <label class="form-label">Día:</label>
                                        <select required name="horario[]" id="horario"
                                            class="form-select form-select-sm form-control"
                                            aria-label="Small select example" require>
                                            <option selected>Turno</option>
                                            <option value="lunes" <?php if($dia == 'lunes') echo 'selected'; ?>>Lunes
                                            </option>
                                            <option value="martes" <?php if($dia == 'martes') echo 'selected'; ?>>
                                                Martes</option>
                                            <option value="miercoles" <?php if($dia == 'miercoles') echo 'selected'; ?>>
                                                Miercoles
                                            </option>
                                            <option value="jueves" <?php if($dia == 'jueves') echo 'selected'; ?>>
                                                Jueves</option>
                                            <option value="viernes" <?php if($dia == 'viernes') echo 'selected'; ?>>
                                                Viernes</option>
                                        </select>
                                    </li>

                                    <input value="hi>" type="text" class="form-control" name="horario[]" id="horario"
                                        style="display: none;">
                                    <li class="nav-item dropdown">
                                        <label class="form-label">Hora inicio:</label>
                                        <input value="<?php echo date("H:i:s",strtotime($hi)); ?>" type="time"
                                            class="form-control form-control-user" name="horario[]" id="horario"
                                            aria-describedby="helpId" required>
                                    </li>

                                    <input value="hf>" type="text" class="form-control" name="horario[]" id="horario"
                                        style="display: none;">
                                    <li class="nav-item dropdown">
                                        <label class="form-label">Hora final:</label>
                                        <input value="<?php echo date("H:i:s",strtotime($hf)); ?>" type="time"
                                            class="form-control form-control-user" name="horario[]" id="horario"
                                            aria-describedby="helpId" required>
                                    </li>
                                    <?php if ($key > 1) { ?>
                                    <button type="button" class="btn btn-warning" onclick="removeDayField(this)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <?php } ?>
                                    <input value="$" type="text" class="form-control" name="horario[]" id="horario"
                                        style="display: none;">
                                </ul>
                            </nav>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="button" id="addButton" class="btn btn-success"
                                    onclick="addNetworkField()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <button type="submit" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Actualizar</span>
                </button>
                <a href="index.php" class="btn btn-secondary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">cancelar</span>
                </a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<?php include("../../templates/footer.php"); ?>

<script>
var cont = <?php echo $key; ?>;
</script>
<script src="../../templates/js/list_horario.js"></script>