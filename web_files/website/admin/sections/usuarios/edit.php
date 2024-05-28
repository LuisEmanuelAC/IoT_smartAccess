<?php 

include("../../../config/bd.php");
//exportar de la BD a la tabla
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("SELECT * FROM tbl_usuarios WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis=$sql->fetch(PDO::FETCH_LAZY);

    $fullname=$regis['nombre'];
    $email=$regis['correo'];
    $password=$regis['contrasena'];
    $type=$regis['tipo'];
    $image=$regis['foto'];

}
//actualizar el servicio
if ($_POST) {

    $fullname=(isset($_POST['fullname']))?$_POST['fullname']:"";
    $imagen=(isset($_FILES['image']['name']))?$_FILES['image']['name']:"";
    $email=(isset($_POST['email']))?$_POST['email']:"";
    $password=(isset($_POST['password']))?md5($_POST['password']):"";
    $type=(isset($_POST['tipo']))?$_POST['tipo']:"";

    print_r($fullname);

    $sql=$conn->prepare("UPDATE tbl_usuarios SET nombre=:nombre, correo=:correo, contrasena=:contrasena, tipo=:tipo WHERE ID=:ID");

    $sql->bindParam(":ID",$txtID);
    $sql->bindParam(":nombre",$fullname, PDO::PARAM_STR);
    $sql->bindParam(":correo",$email, PDO::PARAM_STR);
    $sql->bindParam(":contrasena",$password, PDO::PARAM_STR);
    $sql->bindParam(":tipo",$type, PDO::PARAM_STR);
    $sql->execute();

    if ($_FILES["image"]["tmp_name"]!="") {
        $db_image=$image;
        $image=(isset($_FILES['image']['name']))?$_FILES['image']['name']:"";

        $image_date=new Datetime();
        $n_rand = rand(1, 100);
        $name_file_image=($image!="")?$image_date->getTimestamp().$n_rand."_".$image:"";
    
        $tmp_image=$_FILES["image"]["tmp_name"];
        if ($tmp_image!="") {
            move_uploaded_file($tmp_image,"../../../img/users/".$name_file_image);
        }

        if (file_exists("../../../img/users/".$db_image)) {
            unlink("../../../img/users/".$db_image);
        }

        $sql=$conn->prepare("UPDATE tbl_usuarios SET foto=:foto WHERE ID=:ID");
        $sql->bindParam(":ID",$txtID);
        $sql->bindParam(":foto",$name_file_image);
        $sql->execute();
    }
    
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
                    <input value="<?php echo $fullname;?>" type="text" class="form-control form-control-user"
                        name="fullname" id="fullname" aria-describedby="helpId" placeholder="Nombre..." required>
                </div>

                <div class="form-group">
                    <input value="<?php echo $email;?>" type="email" class="form-control form-control-user" name="email"
                        id="email" aria-describedby="emailHelp" placeholder="Correo..." required>
                </div>

                <div class="form-group mb-3 d-flex align-items-center">
                    <input type="password" class="form-control form-control-user" name="password" id="password"
                        placeholder="Contraseña...">
                    <a href="#" class="btn btn-warning btn-circle">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </a>
                </div>

                <div class="form-group">
                    <input value="<?php echo $type;?>" type="text" class="form-control form-control-user" name="tipo"
                        id="tipo" aria-describedby="helpId" placeholder="Tipo..." required>
                </div>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand" href="#">Fotos</a>
                    <ul class="navbar-nav ml-auto">
                        <li>
                            <img width="50" src="../../../img/users/<?php echo $image; ?>" />
                        </li>
                        <li class="nav-item dropdown">
                            <input type="file" class="form-control form-control-user" name="image" id="image"
                                aria-describedby="fileHelpId" placeholder="Foto...">
                        </li>
                    </ul>
                </nav>

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