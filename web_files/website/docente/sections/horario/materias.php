<?php 

include("../../templates/header.php");

$dias_semana = array("lunes", "martes", "miercoles", "jueves", "viernes");

//actualizar el servicio
if ($_POST) {

    $list_materias=(isset($_POST['materias']))?$_POST['materias']:"";

    print_r(count($list_materias));

    $horario="";
    foreach ($list_materias as $index => $dia) {
        if ($index == 0) {
            $horario=$dia;
        }
        if (count($list_materias) > 1 && $index >= 1) {
            $horario=$horario.",".$dia;
        }
    }

    $sql=$conn->prepare("UPDATE tbl_alumnos SET ID_materias=:ID_materias WHERE ID_usuario=:ID_a");
    $sql->bindParam(":ID_a",$ID_usuario);
    $sql->bindParam(":ID_materias",$horario);
    $sql->execute();
    
}

    
$sql=$conn->prepare("SELECT * FROM tbl_alumnos WHERE ID_usuario=:id");
$sql->bindParam(":id",$ID_usuario);
$sql->execute();
$regis_a=$sql->fetch(PDO::FETCH_LAZY);
$ID_materias=$regis_a['ID_materias'];

$materias_ck =  explode(",", $ID_materias); 

//Lista de materias
$sql = $conn->prepare(" SELECT m.ID, m.nombre AS materia, u.nombre AS nombre_d, a.nombre AS aula, m.turno, m.horario FROM tbl_materias m
JOIN tbl_docentes d ON m.ID_docente = d.ID 
JOIN tbl_usuarios u ON d.ID_usuario = u.ID
JOIN tbl_aulas a ON m.ID_aula = a.ID");
$sql->execute();
$materias = $sql->fetchall(PDO::FETCH_ASSOC);

?>
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
    <h1 class="h3 mb-2 text-gray-800">Añadir Materias</h1>
    <p class="mb-4">Esta tabla te deja ver una lista de los materias que existen y selecciona para añadirlo a tu horario
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">alumnos:</h6>
        </div>
        <div class="card-body">

            <form action="" enctype="multipart/form-data" method="post" class="user">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Lista de materias</h6>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Materia / Docente</th>
                                            <th scope="col">Aula / Turno</th>
                                            <th scope="col">Lunes</th>
                                            <th scope="col">Martes</th>
                                            <th scope="col">Miercoles</th>
                                            <th scope="col">Jueves</th>
                                            <th scope="col">Viernes</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">Materia / Docente</th>
                                            <th scope="col">Aula / Turno</th>
                                            <th scope="col">Lunes</th>
                                            <th scope="col">Martes</th>
                                            <th scope="col">Miercoles</th>
                                            <th scope="col">Jueves</th>
                                            <th scope="col">Viernes</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach($materias as $key => $materia){ 
                        
                            ?>

                                        <tr class="">
                                            <td scope="col">
                                                <ul class="nav justify-content-center flex-column">
                                                    <li class="">
                                                        <a class="nav-link disabled">->
                                                            <?php echo $materia['materia']; ?>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a class="nav-link disabled">->
                                                            <?php echo $materia['nombre_d']; ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td scope="col">
                                                <ul class="nav justify-content-center flex-column">
                                                    <li class="">
                                                        <a class="nav-link disabled">->
                                                            <?php echo $materia['aula']; ?>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a class="nav-link disabled">->
                                                            <?php echo $materia['turno']; ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                            <?php 
                            $dias = explode("$", $materia['horario']);
                            foreach($dias_semana as $key => $value){
                            ?><td scope="col"><?php
                                foreach ($dias as $k => $dia) {
                                    $dia = explode(",", $dia);                                    
                                    if ($value == $dia[0]) {
                                        echo "Día: " . $dia[0] . ", Hora I: " . $dia[1] . ", Hora F: " . $dia[2] . "<br>";
                                    }
                                }
                            ?>
                                            </td>
                                            <?php } ?>
                                            <td>
                                                <input class="btn btn-warning btn-circle" type="checkbox"
                                                    name="materias[]" value="<?php echo $materia['ID']; ?>"
                                                    <?php if(in_array($materia['ID'], $materias_ck)) echo 'checked'; ?>>
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
                        <span class="text">Agragar</span>
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