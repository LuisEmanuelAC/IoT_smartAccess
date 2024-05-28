<?php 
include("../../../config/bd.php");

$job = "";
//insertar lo de la tabla a la BD
if ($_POST) {
    $fullname=(isset($_POST['fullname']))?$_POST['fullname']:"";
    $foto=(isset($_FILES['image']['name']))?$_FILES['image']['name']:"";
    $email=(isset($_POST['email']))?$_POST['email']:"";
    $password=(isset($_POST['password']))?md5($_POST['password']):"";  
    $job=(isset($_POST['job']))?$_POST['job']:"";


    $image_date=new Datetime();
    $n_rand = rand(1, 100);
    $name_file_image=($foto!="")?$image_date->getTimestamp().$n_rand."_".$foto:"";
    
    $tmp_image=$_FILES["image"]["tmp_name"];
    if ($tmp_image!="") {
        move_uploaded_file($tmp_image,"../../../img/users/".$name_file_image);
        //print_r('se creo la imagen');
    }  

    $sql=$conn->prepare("INSERT INTO `tbl_usuarios` (`ID`, `nombre`, `foto`, `correo`, `contrasena`, `tipo`) VALUES (NULL, :nombre, :foto, :correo, :contrasena, 'admin')");

    $sql->bindParam(":nombre",$fullname, PDO::PARAM_STR);
    $sql->bindParam(":foto",$name_file_image);
    $sql->bindParam(":correo",$email, PDO::PARAM_STR);
    $sql->bindParam(":contrasena",$password, PDO::PARAM_STR);
    $sql->execute();

    $last_id = $conn->lastInsertId();

    $sql=$conn->prepare("INSERT INTO `tbl_adminis` (`ID`, `ID_usuario`, `cargo`) VALUES (NULL, :ID_usuario, :cargo)");
 
    $sql->bindParam(":ID_usuario",$last_id);
    $sql->bindParam(":cargo",$job, PDO::PARAM_STR);
    $sql->execute();

    $message="successfully-added";
    header("Location:index.php?message=".$message);
}

include("../../templates/header.php"); ?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Crear administrador</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de añadir para crear un nuevo administrador</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Formulario</h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <div class="form-group">
                    <input type="text" class="form-control form-control-user" name="fullname" id="fullname"
                        aria-describedby="helpId" placeholder="Nombre... " required>
                </div>

                <div class="form-group">
                    <input type="email" class="form-control form-control-user" name="email" id="email"
                        aria-describedby="emailHelp" placeholder="Correo..." required>
                </div>

                <div class="form-group mb-3 d-flex align-items-center">
                    <input type="password" class="form-control form-control-user" name="password" id="password"
                        placeholder="Contraseña..." required>
                    <a href="#" class="btn btn-warning btn-circle">
                        <i class="fas fa-eye" id="togglePassword"></i>
                    </a>
                </div>

                <nav class="navbar navbar-expand navbar-light bg-light md-4">
                    <a class="navbar-brand" href="#">Cargo</a>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <select required name="job" id="job" class="form-select form-select-sm form-control"
                                aria-label="Small select example" require>
                                <option selected>cargo</option>
                                <option value="director" <?php if($job == 'director') echo 'selected'; ?>>Director
                                </option>
                                <option value="jefe car" <?php if($job == 'jefe car') echo 'selected'; ?>>Jef@ de
                                    carrera
                                </option>
                                <option value="tecnico" <?php if($job == 'tecnico') echo 'selected'; ?>>Tecnico de
                                    sistemas</option>
                            </select>
                        </li>
                    </ul>
                </nav>

                <br>

                <div class="form-group">
                    <label for="image" class="form-label">Foto</label>
                    <input type="file" class="form-control form-control-user" name="image" id="image"
                        aria-describedby="fileHelpId" placeholder="Foto..." required>
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