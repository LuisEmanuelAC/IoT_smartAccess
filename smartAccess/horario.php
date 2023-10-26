<?php include("template/cabecera.php"); ?>   
<?php include("admin/config/bd.php"); ?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos materia
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
            <div class = "form-group">
            <label for="exampleInputEmail1">ID:</label>
            <input type="text" class="form-control" name="txtID" id="txtID" placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Nombre:</label>
            <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Carrera:</label>
            <input type="text" class="form-control" name="txtCarrera" id="txtCarrera" placeholder="Carrera">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Hora inicio:</label>
            <input type="time" class="form-control" name="txtHInicio" id="txtHInicio" placeholder="Hora de inicio de la materia">
            </div>

            <div class = "form-group">
            <label for="exampleInputEmail1">Hora final:</label>
            <input type="time" class="form-control" name="txtHFinal" id="txtHFinal" placeholder="Hora de final de la materia">
            </div>
            <br/>
            <div class="btn-group" role="group" aria-label="">
                <button type="button" class="btn btn-success">Agragar</button>
                <button type="button" class="btn btn-warning">Modificar</button>
                <button type="button" class="btn btn-info">Cancelar</button>
            </div>
        </form>
        </div>

    </div>

    
    
    
</div>
<div class="col-md-5">
    
</div>



<?php include("template/pie.php"); ?>