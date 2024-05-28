<?php 

include("../../../config/bd.php");
//exportar de la BD a la tabla
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("SELECT * FROM tbl_aulas WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis=$sql->fetch(PDO::FETCH_LAZY);

    $nombre=$regis['nombre'];
    $estado=$regis['estado'];
    $lugar=$regis['lugar'];

}
//actualizar el servicio
if ($_POST) {

    $nombre=(isset($_POST['nombre']))?$_POST['nombre']:"";
    $estado=(isset($_POST['estado']))?$_POST['estado']:"";
    $lugar=(isset($_POST['lugar']))?$_POST['lugar']:"";

    $sql=$conn->prepare("UPDATE tbl_aulas SET nombre=:nombre, estado=:estado, lugar=:lugar WHERE ID=:ID");

    $sql->bindParam(":ID",$txtID);
    $sql->bindParam(":nombre",$nombre, PDO::PARAM_STR);
    $sql->bindParam(":estado",$estado);
    $sql->bindParam(":lugar",$lugar, PDO::PARAM_STR);
    $sql->execute();   
    
    $message="successfully-modified";
    header("Location:index.php?message=".$message);
}

include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Editar usuario</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de actualizar para modificar el usuario</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Usuario: <?php echo $txtID; ?></h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <div class="form-group">
                    <input value="<?php echo $nombre;?>" type="text" class="form-control form-control-user"
                        name="nombre" id="nombre" aria-describedby="helpId" placeholder="Nombre..." required>
                </div>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand" href="#">Estado</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="estado" id="estado" class="form-select form-select-sm form-control"
                                aria-label="Small select example" require>
                                <option selected value="inactivo" <?php if($estado == 'inactivo') echo 'selected'; ?>>
                                    inactivo
                                </option>
                                <option value="abierto" <?php if($estado == 'abierto') echo 'selected'; ?>>abierto
                                </option>
                                <option value="cerrado" <?php if($estado == 'cerrado') echo 'selected'; ?>>cerrado
                                </option>
                            </select>
                        </li>
                    </ul>
                </nav>

                <br>

                <div class="form-group">
                    <input value="<?php echo $lugar;?>" type="text" class="form-control form-control-user" name="lugar"
                        id="lugar" aria-describedby="helpId" placeholder="Lugar..." required>
                </div>

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