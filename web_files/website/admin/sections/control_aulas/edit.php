<?php 

include("../../../config/bd.php");
//exportar de la BD a la tabla
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("SELECT * FROM tbl_control_aulas WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis=$sql->fetch(PDO::FETCH_LAZY);

    $ID_usuario=$regis['ID_usuario'];
    $fecha=$regis['fecha'];
    $h_inicio=$regis['h_inicio'];
    $h_final=$regis['h_final'];

}
//actualizar el servicio
if ($_POST) {

    $ID_usuario=(isset($_POST['ID_usuario']))?$_POST['ID_usuario']:"";
    $fecha=(isset($_POST['fecha']))?$_POST['fecha']:"";
    $h_inicio=(isset($_POST['h_inicio']))?$_POST['h_inicio']:"";
    $h_final=(isset($_POST['h_final']))?$_POST['h_final']:"";

    $sql=$conn->prepare("UPDATE tbl_control_aulas SET  ID_usuario=:ID_usuario, fecha=:fecha, h_inicio=:h_inicio, h_final=:h_final WHERE ID=:ID");

    $sql->bindParam(":ID",$txtID);
    $sql->bindParam(":ID_usuario",$ID_usuario);
    $sql->bindParam(":fecha",$fecha);
    $sql->bindParam(":h_inicio",$h_inicio);
    $sql->bindParam(":h_final",$h_final);
    $sql->execute();   
    
    $message="successfully-modified";
    header("Location:index.php?message=".$message);
}

//Lista de aulas
$sql=$conn->prepare("SELECT * FROM `tbl_usuarios`");
$sql->execute();
$list_usuarios=$sql->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Editar usuario</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de actualizar para modificar el usuario</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Registro: <?php echo $txtID; ?></h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand">Registro</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="ID_usuario" id="ID_usuario"
                                class="form-select form-select-sm form-control" aria-label="Small select example">
                                <option selected>menu usuario</option>
                                <?php                    
                                if ($list_usuarios) {
                                    
                                    // Salida de cada fila
                                    foreach($list_usuarios as $regis_a){ ?>

                                <option value="<?php echo $regis_a['ID']; ?>"
                                    <?php if($ID_usuario == $regis_a['ID']) echo 'selected'; ?>>
                                    <?php echo $regis_a['ID'] ; ?> -
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
                <br>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand">Fecha</a>
                    <ul class="navbar-nav ml-auto">
                        <input value="<?php echo $fecha;?>" type="date" class="form-control form-control-user"
                            name="fecha" id="fecha" aria-describedby="helpId" placeholder="fecha..." required>
                    </ul>
                </nav>
                <br>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand">Horario</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <label class="form-label">Hora inicio:</label>
                            <input value="<?php echo $h_inicio; ?>" type="time" class="form-control form-control-user"
                                name="h_inicio" id="h_inicio" aria-describedby="helpId" placeholder="hora de inicio..."
                                required>
                        </li>

                        <li class="nav-item dropdown">
                            <label class="form-label">Hora final:</label>
                            <input value="<?php echo $h_final; ?>" type="time" class="form-control form-control-user"
                                name="h_final" id="h_final" aria-describedby="helpId" placeholder="hora de final...">
                        </li>
                    </ul>
                </nav>
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