<?php include("../templates/header.php");

$dias_semana = array("lunes", "martes", "miercoles", "jueves", "viernes");
$fecha_actual = date("d-m-Y H:i:s");

$sql=$conn->prepare("SELECT * FROM tbl_alumnos WHERE ID_usuario=:id");
$sql->bindParam(":id",$ID_USUARIO_SESION);
$sql->execute();
$regis_a=$sql->fetch(PDO::FETCH_LAZY);

$ID_materias =  explode(",", $regis_a['ID_materias']);

$fecha_actual = '2024-05-19'; // Puedes reemplazar esto con la$fecha_actual que desees

//$hora_actual = new DateTime(date("H:i"));
$hora_actual = new DateTime("07:30");

$numero_dia = date('w', strtotime($fecha_actual)); // 0 (Domingo) a 6 (Sábado)
$nombre_dia = $dias_semana[$numero_dia];
echo "El día de la semana para la fecha $fecha_actual es: $nombre_dia";


?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Clases del día</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <div class="btn btn-facebook col-md-8 mb-2 mx-auto">
                <?php echo $nombre_dia; ?>
            </div>
            <?php foreach ($ID_materias as $key => $value) { 
                $sql = $conn->prepare(" SELECT m.ID, m.nombre AS materia, u.ID AS ID_usuario_d, u.nombre AS nombre_d, a.nombre AS aula, m.turno, m.horario FROM tbl_materias m
                JOIN tbl_docentes d ON m.ID_docente = d.ID 
                JOIN tbl_usuarios u ON d.ID_usuario = u.ID
                JOIN tbl_aulas a ON m.ID_aula = a.ID WHERE m.ID=:id");
                $sql->bindParam(":id",$value);
                $sql->execute();
                $materias = $sql->fetch(PDO::FETCH_ASSOC);

                $dias = explode("$", $materias['horario']);
                //print_r($dias);
                for ($i=0; $i < count($dias) - 1; $i++) {
                    $d_value = explode(",", $dias[$i]);
                    //print_r($d_value);

                    if ($nombre_dia == $d_value[0]) {
                        $d=$d_value[0];
                        $hi=$d_value[1];
                        $hf=$d_value[2];

                        $hora_inicio = new DateTime($d_value[1]);
                        $hora_final = new DateTime($d_value[2]);

                        $inter_total = $hora_inicio->diff($hora_final);
                        $inter_actual = $hora_inicio->diff($hora_actual);

                        $segundos_total = ($inter_total->h * 3600) + ($inter_total->i * 60) + $inter_total->s;
                        $segundos_actual = ($inter_actual->h * 3600) + ($inter_actual->i * 60) + $inter_actual->s;

                        $porcentaje = ($segundos_actual / $segundos_total) * 100;

                        // Consulta para verificar si el docente asistió al plantel hoy
                        $sql = $conn->prepare("SELECT * FROM tbl_control_aulas WHERE ID_usuario = :ID_usuario AND fecha = :fecha");
                        $sql->bindParam(":ID_usuario",$materias['ID_usuario_d']);
                        $sql->bindParam(":fecha",$fecha_actual);
                        $sql->execute();
                        $contr_aulas = $sql->fetchall(PDO::FETCH_ASSOC);
                        
                        $estado_doce = "";

                        if (count($contr_aulas) > 0) {
                            $estado_doce = "esta el docente";

                            //"docente esta y en el salon" se checa toda las horas de inicio y checar si son las mimas hora de la materia que tiene le alumno
                            foreach ($contr_aulas as $key => $value) {
                                if ($value['aula'] == $materias['aula']) {
                                    $estado_doce = "docente en el salon";
                                }else {
                                    //"docente esta pero no en el salon"
                                    $estado_doce = "esta el docente, no en el salon";
                                }
                            }                        
                        }else {
                            $estado_doce = "no esta el docente";                        
                        }
                    ?>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-8 mb-4 mx-auto d-block">
                <div
                    class="card <?php if($hora_inicio <= $hora_actual && $hora_actual < $hora_final) echo "border-left-success"; else echo "border-left-primary"; ?> shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div
                                    class="text-xs font-weight-bold <?php if($hora_inicio <= $hora_actual && $hora_actual < $hora_final) echo "text-success"; else echo "text-primary"; ?> text-uppercase mb-1">
                                    (<?php echo $hi;?>-<?php echo $hf;?>)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $materias['materia'];?> en la aula <?php echo $materias['aula'];?>
                                </div>
                                <?php if($hora_inicio <= $hora_actual && $hora_actual < $hora_final){ ?>
                                <div class="progress progress-sm mb-2">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo $porcentaje; ?>%" aria-valuenow="75" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="col-auto">
                                <label for=""><?php echo $estado_doce; ?></label>
                                <!--<img src="<?php echo $url_base; ?>img/estados/estados_docente_noAsistio.png"
                                    class="fa-2x text-gray-300" />-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }

                }  

                ?>

            <?php } ?>

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Main Content -->

    <?php include("../templates/footer.php") ?>