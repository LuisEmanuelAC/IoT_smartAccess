<?php 
include("../../config/bd.php");

//Borrar
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sql=$conn->prepare("SELECT * FROM `tbl_materias` WHERE ID=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis_a=$sql->fetch(PDO::FETCH_ASSOC);
    $ID_u=(int)$regis_a['ID_usuario'];

    $sql=$conn->prepare("DELETE FROM tbl_materias WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();

    $sql=$conn->prepare("DELETE FROM tbl_docentes WHERE id=:id");
    $sql->bindParam(":id",$ID_u);
    $sql->execute();

    $message="successfully-removed";
    header("Location:index.php?message=".$message);
}

//Lista
$sql=$conn->prepare("SELECT * FROM `tbl_materias`");
$sql->execute();
$list_materia=$sql->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>
<script>
function confirDelate(params) {
    Swal.fire({
        title: "Estás seguro?",
        text: "el contenido será eliminado de toda la tabla!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!"
    }).then((result) => {

        if (result.isConfirmed) {
            window.location.href = "index.php?txtID=" + params;
        }
    });
}

<?php  
if (isset($_GET['message'])) {
    if ($_GET['message'] == "successfully-added") { ?>
Swal.fire({
    position: "top-end",
    icon: "success",
    title: "ha sido añadido con éxito",
    showConfirmButton: false,
    timer: 1000
});
<?php 
    } elseif ($_GET['message'] == "successfully-modified") { ?>
Swal.fire({
    position: "top-end",
    icon: "success",
    title: "ha sido editado con éxito",
    showConfirmButton: false,
    timer: 1000
});
<?php 
    }elseif ($_GET['message'] == "successfully-removed") { ?>
Swal.fire({
    position: "top-end",
    icon: "success",
    title: "ha sido eliminado con éxito",
    showConfirmButton: false,
    timer: 1000
});
<?php 
            }
}
?>
</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Materias</h1>
    <p class="mb-4">Esta tabla te deja ver una lista de los materias que existen y además podrás añadir, editar o
        eliminar los existentes</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lista de materias</h6>
            <a href="create.php" class="btn btn-success btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Añadir</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Materia</th>
                            <th scope="col">Docente</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Creditos</th>
                            <th scope="col">Horario</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Materia</th>
                            <th scope="col">Docente</th>
                            <th scope="col">Aula</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Creditos</th>
                            <th scope="col">Horario</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($list_materia as $regis){ ?>
                        <tr class="">
                            <td scope="col"><?php echo $regis['ID']; ?></td>
                            <td scope="col"><?php echo $regis['nombre']; ?></td>
                            <td scope="col">
                                <?php
                                // lista de docentes
                                $sql=$conn->prepare("SELECT d.ID as ID, u.nombre as nombre
                                FROM tbl_usuarios u
                                JOIN tbl_docentes d ON u.ID = d.ID_usuario
                                WHERE d.ID=:id_d"); 
                                $sql->bindParam(":id_d",$regis['ID_docente']);
                                $sql->execute();
                                $regis_d=$sql->fetch(PDO::FETCH_ASSOC);
                                ?>
                                <ul class="nav justify-content-center flex-column">
                                    <li class="">
                                        <a class="nav-link disabled">-><?php echo $regis_d['ID']; ?>:
                                            <?php echo $regis_d['nombre']; ?></a>
                                    </li>
                                </ul>

                            </td>
                            <td scope="col"><?php echo $regis['aula']; ?></td>
                            <td scope="col"><?php echo $regis['turno']; ?></td>
                            <td scope="col"><?php echo $regis['creditos']; ?></td>
                            <td scope="col">
                                <ul class="nav justify-content-center flex-column">
                                    <?php $list_horario = explode("$", $regis['horario']); 
                                foreach ($list_horario as $key => $value) { ?>
                                    <li class="">
                                        <a class="nav-link disabled">
                                            <?php
                                    $horario_dia = explode(",", $value);                   
                                    for ($i=0; $i < count($horario_dia); $i++) { 
                                        switch ($horario_dia[$i]) {
                                            case 'd>':
                                                $i++;
                                                echo "->Dia: ";
                                                echo $horario_dia[$i];                                     
                                                break;
                                            
                                            case 'hi>':
                                                $i++;
                                                echo "-hora I: ";
                                                echo $horario_dia[$i];                                     
                                                break;

                                            case 'hf>':
                                                $i++;
                                                echo "-hora F: ";
                                                echo $horario_dia[$i];                                     
                                                break;
                                            default:
                                                break;                                        
                                        }
                                    }?>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                                </ul>
                            </td>
                            <td>
                                <a class="btn btn-warning btn-circle" href="edit.php?txtID=<?php echo $regis['ID']; ?>">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-circle"
                                    onclick="confirDelate(<?php echo $regis['ID']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->



<?php include("../../templates/footer.php"); ?>