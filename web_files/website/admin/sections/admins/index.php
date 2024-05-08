<?php 
include("../../config/bd.php");

//Borrar
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("DELETE FROM tbl_usuarios WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
}

//Lista de servicios
$sql=$conn->prepare("SELECT * FROM `tbl_usuarios`");
$sql->execute();
$list_usuarios=$sql->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>
<script>
function confirDelate(params) {
    Swal.fire({
        title: "Are you sure?",
        text: "the content will be removed from the entire table!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {

        if (result.isConfirmed) {
            window.location.href = "index.php?txtID=" + params;
            Swal.fire({
                title: "Deleted!",
                text: "content has been deleted.",
                icon: "success"
            });
        }
    });
}
</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
    <p class="mb-4">Esta tabla te deja ver una lista de los usuarios que existen y además podrás añadir, editar o
        eliminar los existentes</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lista de usuarios</h6>
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
                            <th scope="col">Foto</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Contraseña</th>
                            <th scope="col">Turno</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach($list_usuarios as $regis){ ?>
                        <tr class="">
                            <td scope="col"><?php echo $regis['ID']; ?></td>
                            <td scope="col"><?php echo $regis['nombre']; ?></td>
                            <td scope="col">
                                <img width="100" src="../../../assets/img/team/<?php echo $regis['image']; ?>" />
                            </td>
                            <td scope="col"><?php echo $regis['correo']; ?></td>
                            <td scope="col"><?php echo $regis['contraseña']; ?></td>
                            <td scope="col"><?php echo $regis['tipo']; ?></td>
                            <td>
                                <a href="#" class="btn btn-danger btn-circle"
                                    href="edit.php?txtID=<?php echo $regis['ID']; ?>">
                                    <i class="fas fa-pen-to-square"></i>
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