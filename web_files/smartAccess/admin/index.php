<?php
if ($_POST) {
    header('Location:inicio.php');
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
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña</label>
                        <input type="password" class="form-control" name="contraseña" placeholder="Escribe tu cotraseña">
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