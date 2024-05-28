<?php
session_start();

$url_base="http://localhost/Iot_smartAccess/web_files/website/";
//buscar ususrio en la tabla a la BD
if ($_POST) { 
    include("../config/bd.php");  

    $email=(isset($_POST['email']))?$_POST['email']:"";
    $password=(isset($_POST['password']))?md5($_POST['password']):"";
 

    $sql=$conn->prepare("SELECT *, count(*) as n_user FROM `tbl_usuarios` WHERE correo=:correo AND contrasena=:contra");
    
    $sql->bindParam(":correo",$email, PDO::PARAM_STR); 
    $sql->bindParam(":contra",$password, PDO::PARAM_STR);
    $sql->execute();

    $list_users=$sql->fetch(PDO::FETCH_LAZY);
    
   if ($list_users['n_user']>0) {
        print_r("si exixte");

        $_SESSION['user']=$list_users['ID'];
        $_SESSION['loggedin']=true;

        switch ($list_users['tipo']) {
            case 'admin':
                header("Location:". $url_base . "admin/sections/index.php");              
                break;

            case 'docente':
                header("Location:". $url_base . "docente/sections/index.php");              
                break;

            case 'alumno':
                header("Location:". $url_base . "alumno/sections/index.php");              
                break;
            
            default:
                header("Location:". $url_base . "sections/404.php");
                break;
        }

    }else {
        $message_userDExist="User or password does not exist";
    }    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo $url_base; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo $url_base; ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <br><br>
                                    <?php if (isset($message_userDExist)) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <strong>Error: </strong><?php echo $message_userDExist; ?>
                                    </div>
                                    <?php } ?>

                                    <script>
                                    var alertList = document.querySelectorAll(".alert");
                                    alertList.forEach(function(alert) {
                                        new bootstrap.Alert(alert);
                                    });
                                    </script>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email"
                                                id="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" id="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">Login</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>