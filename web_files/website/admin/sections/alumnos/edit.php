<?php 

include("../../config/bd.php");
//exportar de la BD a la tabla
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sql=$conn->prepare("SELECT * FROM tbl_alumnos WHERE id=:id");
    $sql->bindParam(":id",$txtID);
    $sql->execute();
    $regis_a=$sql->fetch(PDO::FETCH_LAZY);

    $ID_u=(int)$regis_a['ID_usuario'];
    $sql=$conn->prepare("SELECT * FROM `tbl_usuarios` WHERE ID=$ID_u");
    $sql->execute();
    $regis_u=$sql->fetch(PDO::FETCH_ASSOC);

    $fullname=$regis_u['nombre'];
    $email=$regis_u['correo'];
    $password=$regis_u['contraseña'];
    $carrera=$regis_a['carrera'];
    $image=$regis_u['foto'];
    $ID_materias=$regis_a['ID_materias'];

    $materias_ck =  explode(",", $ID_materias); 

}
//actualizar el servicio
if ($_POST) {

    $fullname=(isset($_POST['fullname']))?$_POST['fullname']:"";
    $foto=(isset($_FILES['image']['name']))?$_FILES['image']['name']:"";
    $email=(isset($_POST['email']))?$_POST['email']:"";
    $password=(isset($_POST['password']))?md5($_POST['password']):"";  
    $carrera=(isset($_POST['carrera']))?$_POST['carrera']:"";
    $list_materias=(isset($_POST['materias']))?$_POST['materias']:"";

    $horario="";
    foreach ($list_materias as $index => $dia) {
        if ($index == 0) {
            $horario=$dia;
        }
        if (count($list_materias) > 1 && $index >= 1) {
            $horario=$horario.",".$dia;
        }
    }

    $sql=$conn->prepare("UPDATE tbl_alumnos SET ID_materias=:ID_materias, carrera=:carrera WHERE ID=:ID_a");
    $sql->bindParam(":ID_a",$txtID);
    $sql->bindParam(":ID_materias",$horario);
    $sql->bindParam(":carrera",$carrera);
    $sql->execute();

    $sql=$conn->prepare("UPDATE tbl_usuarios SET nombre=:nombre, correo=:correo, contraseña=:contrasena WHERE ID=:ID_u");

    $sql->bindParam(":ID_u",$ID_u);
    $sql->bindParam(":nombre",$fullname, PDO::PARAM_STR);
    $sql->bindParam(":correo",$email, PDO::PARAM_STR);
    $sql->bindParam(":contrasena",$password, PDO::PARAM_STR);   
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
        $sql->bindParam(":ID",$ID_u);
        $sql->bindParam(":foto",$name_file_image);
        $sql->execute();
    }
    
    $message="successfully-modified";
    header("Location:index.php?message=".$message);
}

//Lista de materias
$sql=$conn->prepare("SELECT * FROM `tbl_materias`");
$sql->execute();
$list_materias=$sql->fetchAll(PDO::FETCH_ASSOC);

include("../../templates/header.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Editar alumnos</h1>
    <p class="mb-4">Llena este formulario y presiona el botón de actualizar para modificar el alumnos</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">alumnos: <?php echo $txtID; ?></h6>
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
                    <input value="<?php echo $carrera;?>" type="text" class="form-control form-control-user"
                        name="carrera" id="carrera" aria-describedby="helpId" placeholder="Carrera..." required>
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

                <br>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Materias para añadir</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Docente</th>
                                            <th scope="col">Aula</th>
                                            <th scope="col">Turno</th>
                                            <th scope="col">Creditos</th>
                                            <th scope="col">Horario</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Docente</th>
                                            <th scope="col">Aula</th>
                                            <th scope="col">Turno</th>
                                            <th scope="col">Creditos</th>
                                            <th scope="col">Horario</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach($list_materias as $regis){ ?>
                                        <tr class="">
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
                                                        <a class="nav-link disabled">-><?php echo $regis_d['ID']; ?> -
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
                                                <input class="btn btn-warning btn-circle" type="checkbox"
                                                    name="materias[]" value="<?php echo $regis['ID']; ?>"
                                                    <?php if(in_array($regis['ID'], $materias_ck)) echo 'checked'; ?>>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                </div>
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