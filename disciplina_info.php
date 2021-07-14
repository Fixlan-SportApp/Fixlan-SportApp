<?php $titulo = "Disciplina"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $actividad = get_info_disciplina($_GET['id']);    
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if(isset($_POST['btn_update_disciplina'])){
            if(update_disciplina($_POST['id'], $_POST['a_nombre'], $_POST['a_descripcion'], $_POST['a_profesor'], $_POST['a_fecini'], $_POST['a_fecfin'], $_POST['a_monto_mensual'], $_POST['a_monto_clase'], $_POST['a_cupo'], $_POST['a_limite_cancelacion'])){
                header('location: disciplina_info.php?id='.$_POST['id']);
            }else{
                echo error('La disciplina no se pudo guardar');
                $actividad = get_info_disciplina($_POST['id']);    
            }
        }
        
        if(isset($_POST['generacion_dias'])){
            if(generacion_dias_clases($_POST['c_actividad'], $_POST['desde'], $_POST['hasta'], $_POST['dia'], $_POST['c_horaini'], $_POST['c_horafin'], $_POST['c_cupo'])){
                header('location: disciplina_info.php?id='.$_POST['c_actividad']);
            }else{
                echo error('No se pudieron generar los días');
                $actividad = get_info_disciplina($_POST['id']);  
            }
        }
        
        
        
    }
    
?>
<div class="float-right">
    <a class="btn btn-sm btn-secondary" href="disciplinas_index.php">Volver a Disciplinas</a>&nbsp;&nbsp;<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#disciplina">Generaci&oacute;n de Clases</button>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <div class="float-right">
                    <input type="checkbox" class="form-check-input" id="editar_disciplina">
                    <label class="form-check-label" for="exampleCheck1">Editar</label>
                </div>
                <p class="text-primary m-0 font-weight-bold">Informaci&oacute;n</p>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <input hidden name="id" value="<?php echo $actividad[0]; ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Profesor</label>
                                <select class="form-control form-control-sm" id="a_profesor" name="a_profesor">
                                    <?php echo get_select_profesor($actividad[10]);?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Disciplina</label>
                                <input readonly class="form-control form-control-sm" id="a_nombre" type="text" name="a_nombre" value="<?php echo $actividad[1]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea readonly class="form-control form-control-sm" id="a_descripcion" type="text" name="a_descripcion"><?php echo $actividad[2]; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Inicio</label>
                                <input readonly class="form-control form-control-sm" id="a_fecini" type="date" name="a_fecini" value="<?php echo $actividad[4]; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Finalizaci&oacute;n</label>
                                <input readonly class="form-control form-control-sm" id="a_fecfin" type="date" name="a_fecfin" value="<?php echo $actividad[5]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Monto Abono</label>
                                <input readonly class="form-control form-control-sm" id="a_monto_mensual" type="text" name="a_monto_mensual" value="<?php echo $actividad[6]; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Monto Clase</label>
                                <input readonly class="form-control form-control-sm" id="a_monto_clase" type="text" name="a_monto_clase" value="<?php echo $actividad[7]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Cupo</label>
                                <input readonly class="form-control form-control-sm" id="a_cupo" type="text" name="a_cupo" value="<?php echo $actividad[8]; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label>L&iacute;m. de dias para cancelaci&oacute;n</label>
                                <input readonly class="form-control form-control-sm" type="text" id="a_limite_cancelacion" name="a_limite_cancelacion" value="<?php echo $actividad[9]; ?>">
                            </div>
                        </div>
                    </div>
                    <div id="div_disciplina" class="modal-footer">
                        <button type="submit" name="btn_update_disciplina" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-7">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Clases / Turno</p>
            </div>
            <div class="card-body">
                <table style="font-size:13px;" class="table table-sm table-bordered table-striped" id="tabla_clases">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>D&iacute;a</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Cupos</th>
                            <th>Reservas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo get_listado_clases($actividad[0]);?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="disciplina" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Genarci&oacute;n de Clases</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <input hidden name="id" value="<?php echo $actividad[0]; ?>">
                <input hidden name="c_actividad" value="<?php echo $actividad[0]; ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Desde</label>
                                <input required class="form-control form-control-sm" type="date" name="desde" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Hasta</label>
                                <input required class="form-control form-control-sm" type="date" name="hasta" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>D&iacute;a de la Semana</label>
                                <select required class="form-control form-control-sm" name="dia">
                                    <option value="">Seleccione un d&iacute;a</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Mi&eacute;rcoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">S&aacute;bado</option>
                                    <option value="7">Domingo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Hora de Inicio</label>
                                <input required class="form-control form-control-sm" type="time" name="c_horaini" value="<?php echo date('H:i:00'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Hora de Finalici&oacute;n</label>
                                <input required class="form-control form-control-sm" type="time" name="c_horafin" value="<?php echo date('H:i:00'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Cupo</label>
                                <input required class="form-control form-control-sm" type="text" name="c_cupo" value="<?php echo $actividad[8]; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="generacion_dias" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        $('#tabla_clases').DataTable({
            "order": [
                [0, "asc"],[1, "asc"]
            ]
        });
    });
    
    $(document).ready(function(){
        $('#div_disciplina').hide();
        $('#a_nombre').attr('readonly', true);
        $('#a_descripcion').attr('readonly', true);
        $('#a_fecini').attr('readonly', true);
        $('#a_fecfin').attr('readonly', true);
        $('#a_monto_mensual').attr('readonly', true);
        $('#a_monto_clase').attr('readonly', true);
        $('#a_cupo').attr('readonly', true);
        $('#a_limite_cancelacion').attr('readonly', true);
        $('#a_profesor').attr('readonly', true);
        
    });
    
    $('#editar_disciplina').change(function() {
        if ($('#editar_disciplina').is(':checked')) {
            $('#div_disciplina').show();
            $('#a_nombre').attr('readonly', false);
            $('#a_descripcion').attr('readonly', false);
            $('#a_fecini').attr('readonly', false);
            $('#a_fecfin').attr('readonly', false);
            $('#a_monto_mensual').attr('readonly', false);
            $('#a_monto_clase').attr('readonly', false);
            $('#a_cupo').attr('readonly', false);
            $('#a_limite_cancelacion').attr('readonly', false);
            $('#a_profesor').attr('readonly', false);
        } else {
            $('#div_disciplina').hide();
            $('#a_nombre').attr('readonly', true);
            $('#a_descripcion').attr('readonly', true);
            $('#a_fecini').attr('readonly', true);
            $('#a_fecfin').attr('readonly', true);
            $('#a_monto_mensual').attr('readonly', true);
            $('#a_monto_clase').attr('readonly', true);
            $('#a_cupo').attr('readonly', true);
            $('#a_limite_cancelacion').attr('readonly', true);
            $('#a_profesor').attr('readonly', true);
        }
    });
</script>
<?php include 'assets/php/footer.php'; ?>
