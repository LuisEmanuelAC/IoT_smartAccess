<?php 

include("../../bd.php");
//exportar de la BD a la tabla
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("SELECT * FROM tbl_services WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis=$sql->fetch(PDO::FETCH_LAZY);

    $icon=$regis['icon'];
    $title=$regis['title'];
    $descrip=$regis['description'];

}
//actualizar el servicio
if ($_POST) {
    $txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
    $icon=(isset($_POST['icon']))?$_POST['icon']:"";
    $title=(isset($_POST['title']))?$_POST['title']:"";
    $descrip=(isset($_POST['descrip']))?$_POST['descrip']:"";

    $sql=$conn->prepare("UPDATE tbl_services SET icon=:icon, title=:title, description=:descrip WHERE id=:id");

    $sql->bindParam(":id",$txtID);
    $sql->bindParam(":icon",$icon);
    $sql->bindParam(":title",$title);
    $sql->bindParam(":descrip",$descrip);
    $sql->execute();
    
    $message="successfully modified";
    header("Location:index.php?message=".$message);
}

include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Crear usuario</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de añadir para crear un nuevo usuario</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="fullname" id="fullname"
                        aria-describedby="helpId" placeholder="Nombre...">
                </div>

                <div class="form-group">
                    <input type="email" class="form-control form-control-user" name="email" id="email"
                        aria-describedby="emailHelp" placeholder="Correo...">
                </div>

                <div class="form-group mb-3 d-flex align-items-center">
                    <input type="password" class="form-control form-control-user" name="password" id="password"
                        placeholder="Contraseña...">
                    <a href="#" class="btn btn-warning btn-circle">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </a>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="tipo" id="tipo"
                        aria-describedby="helpId" placeholder="Tipo...">
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Foto</label>
                    <input type="file" class="form-control form-control-user" name="image" id="image"
                        aria-describedby="fileHelpId" placeholder="Foto...">
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

<script>
// JavaScript code snippet
document.addEventListener('DOMContentLoaded', function() {
    var passwordInput = document.getElementById('password');
    var toggleButton = document.getElementById('togglePassword');
    toggleButton.className = 'fas fa-eye-slash';
    toggleButton.onclick = function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.className = 'fas fa-eye';
        } else {
            passwordInput.type = 'password';
            toggleButton.className = 'fas fa-eye-slash';
        }
    };
});
</script>