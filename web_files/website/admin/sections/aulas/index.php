<?php 
include("../../../config/bd.php");

//Borrar
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("DELETE FROM tbl_aulas WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();

    $message="successfully-removed";
    header("Location:index.php?message=".$message);
}

//Lista de aulas
$sql=$conn->prepare("SELECT * FROM `tbl_aulas`");
$sql->execute();
$list_aulas=$sql->fetchAll(PDO::FETCH_ASSOC);

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
    <h1 class="h3 mb-2 text-gray-800">Aulas</h1>
    <p class="mb-4">Esta tabla te deja ver una lista de las aulas que existen y además podrás añadir, editar o
        eliminar los existentes</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lista de aulas</h6>
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
                            <th scope="col">Nombre</th>
                            <th scope="col">estado</th>
                            <th scope="col">lugar</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">estado</th>
                            <th scope="col">lugar</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($list_aulas as $regis){ ?>
                        <tr class="">
                            <td scope="col"><?php echo $regis['ID']; ?></td>
                            <td scope="col"><?php echo $regis['nombre']; ?></td>
                            <td scope="col"><?php echo $regis['estado']; ?></td>
                            <td scope="col"><?php echo $regis['lugar']; ?></td>
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