
// Variable para contar los días


// Función para añadir un nuevo campo de texto para networks
function addNetworkField() {
    cont++;
    var container = document.getElementById('horarioContainer');
    var inputGroup = document.createElement('nav');
    inputGroup.classList.add('navbar', 'navbar-expand', 'navbar-light', 'bg-light', 'md-4');

    inputGroup.innerHTML = `
                        <a class="navbar-brand">Día: ` + cont + `</a>
                        <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <input value="d>" type="text" class="form-control" name="horario[]" id="horario"
                                            style="display: none;">
                                        <label class="form-label">Día:</label>
                                        <select required name="horario[]" id="horario"
                                            class="form-select form-select-sm form-control"
                                            aria-label="Small select example" require>
                                            <option selected>Turno</option>
                                            <option value="lunes" <?php if($turno == 'lunes') echo 'selected'; ?>>Lunes
                                            </option>
                                            <option value="martes" <?php if($turno == 'martes') echo 'selected'; ?>>
                                                Martes</option>
                                            <option value="miercoles"
                                                <?php if($turno == 'miercoles') echo 'selected'; ?>>Miercoles
                                            </option>
                                            <option value="jueves" <?php if($turno == 'jueves') echo 'selected'; ?>>
                                                Jueves</option>
                                            <option value="viernes" <?php if($turno == 'viernes') echo 'selected'; ?>>
                                                Viernes</option>
                                        </select>
                                    </li>

                                    <input value="hi>" type="text" class="form-control" name="horario[]" id="horario"
                                        style="display: none;">
                                    <li class="nav-item dropdown">
                                        <label class="form-label">Hora inicio:</label>
                                        <input type="time" class="form-control form-control-user" name="horario[]"
                                            id="horario" aria-describedby="helpId" required>
                                    </li>

                                    <input value="hf>" type="text" class="form-control" name="horario[]" id="horario"
                                        style="display: none;">
                                    <li class="nav-item dropdown">
                                        <label class="form-label">Hora final:</label>
                                        <input type="time" class="form-control form-control-user" name="horario[]"
                                            id="horario" aria-describedby="helpId" required>
                                    </li>
                           
                                    <button type="button" class="btn btn-warning" onclick="removeDayField(this)">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <input value="$" type="text" class="form-control" name="horario[]" id="horario"
                                        style="display: none;">
                                </ul>                        
    `;

    container.appendChild(inputGroup);

    // Si se han añadido 7 días, ocultar el botón
    if (cont >= 7) {
        document.getElementById('addButton').style.display = 'none';
    }
}

// Función para eliminar el campo de texto actual
function removeDayField(button) {
    cont--;
    var inputGroup = button.closest('.navbar', 'navbar-expand', 'navbar-light', 'bg-light', 'md-4');
    if (inputGroup) {
        inputGroup.remove();
    }
    if (cont <= 7) {
        document.getElementById('addButton').style.display = '';
    }
}