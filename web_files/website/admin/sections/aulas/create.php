<?php 
include("../../../config/bd.php");


//insertar lo de la tabla a la BD
if ($_POST) {
    $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
    $estado=(isset($_POST['estado']))?$_POST['estado']:"";
    $lugar=(isset($_POST['lugar']))?$_POST['lugar']:"";

    $sql=$conn->prepare("INSERT INTO `tbl_aulas` (`ID`, `nombre`, `estado`, `lugar` ) VALUES (NULL, :nombre, :estado, :lugar )");

    $sql->bindParam(":nombre",$nombre, PDO::PARAM_STR);
    $sql->bindParam(":estado",$estado);
    $sql->bindParam(":lugar",$lugar, PDO::PARAM_STR);
    $sql->execute();

    $message="successfully-added";
    header("Location:index.php?message=".$message);
}

include("../../templates/header.php"); ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Crear aula</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de añadir para crear una nueva aula</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="nombre" id="nombre"
                        aria-describedby="helpId" placeholder="Nombre..." required>
                </div>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand" href="#">Estado</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="estado" id="estado" class="form-select form-select-sm form-control"
                                aria-label="Small select example" require>
                                <option selected value="inactivo">inactivo
                                </option>
                                <option value="abierto">abierto
                                </option>
                                <option value="cerrado">cerrado
                                </option>
                            </select>
                        </li>
                    </ul>
                </nav>

                <br>

                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="lugar" id="lugar"
                        aria-describedby="helpId" placeholder="Lugar..." required>
                </div>

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