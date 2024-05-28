<?php 
include("../../../config/bd.php");

$aula = "";
$turno = "";
$ID_docente = "";

//insertar lo de la tabla a la BD
if ($_POST) {
    $materia=(isset($_POST['materia']))?$_POST['materia']:"";
    $ID_docente=(isset($_POST['ID_docente']))?$_POST['ID_docente']:"";
    $ID_aula=(isset($_POST['ID_aula']))?$_POST['ID_aula']:"";
    $turno=(isset($_POST['turno']))?$_POST['turno']:"";
    $creditos=(isset($_POST['creditos']))?$_POST['creditos']:"";
    $list_horario=(isset($_POST['horario']))?$_POST['horario']:"";

    $horario = "";
    $noComa = false;
    
    foreach ($list_horario as $index => $value) {
        if ($index == 0) {
            $horario = $value;
            $noComa = ($value == "$");
        } else {
            if ($value == "$") {
                $horario = $horario . $value;
                $noComa = true;
            } else {
                if ($noComa) {
                    $horario = $horario . $value;
                } else {
                    $horario = $horario . "," . $value;
                }
                $noComa = false;
            }
        }
    }   

    
    $sql=$conn->prepare("INSERT INTO `tbl_materias` (`ID`, `nombre`, `ID_docente`, `ID_aula`, `turno`, `creditos`, `horario`) 
    VALUES (NULL, :nombre, :ID_docente, :ID_aula, :turno, :creditos, :horario)");

    $sql->bindParam(":nombre",$materia, PDO::PARAM_STR);  
    $sql->bindParam(":ID_docente",$ID_docente);
    $sql->bindParam(":ID_aula",$ID_aula);
    $sql->bindParam(":turno",$turno);
    $sql->bindParam(":creditos",$creditos);
    $sql->bindParam(":horario",$horario);
    $sql->execute();

    $message="successfully-added";
    header("Location:index.php?message=".$message);
}

// lista de docentes
$sql=$conn->prepare("SELECT d.ID as ID, u.nombre as nombre, d.carrera as carrera 
FROM tbl_usuarios u
JOIN tbl_docentes d ON u.ID = d.ID_usuario");                                           
$sql->execute();
$list_docentes=$sql->fetchAll(PDO::FETCH_ASSOC);

//Lista de aulas
$sql=$conn->prepare("SELECT * FROM `tbl_aulas`");
$sql->execute();
$list_aulas=$sql->fetchAll(PDO::FETCH_ASSOC);


include("../../templates/header.php"); ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Crear materia</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de añadir para crear una nueva materia</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="materia" id="materia"
                        aria-describedby="helpId" placeholder="Nombre... " required>
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
                            <select required name="ID_aula" id="ID_aula" class="form-select form-select-sm form-control"
                                aria-label="Small select example">
                                <option selected>menu aula</option>
                                <?php                    
                                if ($list_aulas) {
                                    // Salida de cada fila
                                    foreach($list_aulas as $regis_a){ ?>
                                <option value="<?php echo $regis_a['ID']; ?>">
                                    <?php echo $regis_a['nombre'] ; ?>
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
                    <input type="text" class="form-control form-control-user" name="creditos" id="creditos"
                        aria-describedby="helpId" placeholder="Creditos... " required>
                </div>

                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Horario</h6>
                        </div>
                        <div class="card-body" id="horarioContainer">
                            <nav class="navbar navbar-expand navbar-light bg-light md-4">
                                <a class="navbar-brand">Día: 1</a>
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <label class="form-label">Día:</label>
                                        <select required name="horario[]" id="horario"
                                            class="form-select form-select-sm form-control"
                                            aria-label="Small select example" require>
                                            <option selected>Turno</option>
                                            <option value="lunes" <?php if($turno == 'lunes') echo 'selected'; ?>>Lunes
                                            </option>
                                            <option value="martes" <?php if($turno == 'martes') echo 'selected'; ?>>
                                                Martes</option>
                                            <option value="miercoles"
                                                <?php if($turno == 'miercoles') echo 'selected'; ?>>Miercoles
                                            </option>
                                            <option value="jueves" <?php if($turno == 'jueves') echo 'selected'; ?>>
                                                Jueves</option>
                                            <option value="viernes" <?php if($turno == 'viernes') echo 'selected'; ?>>
                                                Viernes</option>
                                        </select>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <label class="form-label">Hora inicio:</label>
                                        <input type="time" class="form-control form-control-user" name="horario[]"
                                            id="horario" aria-describedby="helpId" required>
                                    </li>


                                    <li class="nav-item dropdown">
                                        <label class="form-label">Hora final:</label>
                                        <input type="time" class="form-control form-control-user" name="horario[]"
                                            id="horario" aria-describedby="helpId" required>
                                    </li>
                                    <li>
                                        <input value="$" type="text" class="form-control" name="horario[]" id="horario"
                                            style="display: none;">

                                    </li>
                                </ul>
                            </nav>
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
                    <span class="text">añadir</span>
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
var cont = 1;
</script>
<script src="../../../js/list_horario.js"></script>