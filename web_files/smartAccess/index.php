<?php include("admin/config/bd.php"); ?>
<?php
if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para obtener el usuario con el correo proporcionado
    $sql = "SELECT * FROM usuarios WHERE correo = '$usuario'";
    $resultado = $conexion->query($sql);

    $url="http://".$_SERVER['HTTP_HOST']."/smartaccess";

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verifica si la contraseña proporcionada coincide con la contraseña del usuario en la base de datos
        if ($contrasena == $usuario['contrasena']) {
            if($usuario['tipo_u'] == "admin"){ header('Location:'.$url.'/admin/inicio.php');}
            if($usuario['tipo_u'] == "alumno"){ header('Location:'.$url.'/alumno/inicio.php');
                echo 'es alumno'; }
            if($usuario['tipo_u'] == "docente"){ header('Location:'.$url.'/docente/inicio.php');}
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row">
        <div class="col-4">
        </div>
            <div class="col-4">
            <br/><br/>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form method = "POST">
                        <div class = "form-group">
                        <label for="exampleInputEmail1">Correo</label>
                        <input type="email" class="form-control" name="usuario" placeholder="Escribe tu correo electronico">                     
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" class="form-control" name="contrasena" placeholder="Escribe tu cotraseña">
                        </div> <br/>

                        <button type="submit" class="btn btn-primary">Sign In</button>
                        </form>                      
                        
                    </div>
                    
                </div>
            </div>            
        </div>
    </div>
</body>

</html>         
