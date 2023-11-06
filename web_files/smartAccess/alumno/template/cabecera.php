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

    <?php $url="http://".$_SERVER['HTTP_HOST']."/smartaccess" ?>

    <nav class="navbar navbar-expand navbar-light bg-light">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#" aria-current="page">Home <span class="visually-hidden">(current)</span></a>
            <a class="nav-item nav-link" href="#">Home</a>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link text-white active" href="#" aria-current="page">SMART ACCESS <span class="visually-hidden">(current)</span></a>
            <a class="nav-item nav-link text-white" href="<?php echo $url;?>/alumno/inicio.php">Inicio</a>
            <a class="nav-item nav-link text-white" href="<?php echo $url;?>/alumno/seccion/horario.php" >Horario</a> 
            <a class="nav-item nav-link text-white" href="<?php echo $url;?>/index.php">Cerrar</a>
        </div>
    </nav>

    <div class="container">
    <br>
    <br>
    <br>
    <br>
        <div class="row">