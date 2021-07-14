<?php $titulo = "Disciplinas"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_disciplina($_POST['a_nombre'], $_POST['a_descripcion'], $_POST['a_profesor'], $_POST['a_fecini'], $_POST['a_fecfin'], $_POST['a_monto_mensual'], $_POST['a_monto_clase'], $_POST['a_cupo'], $_POST['a_limite_cancelacion'])){
            header('location: disciplinas_index.php');
        }else{
            echo error('La disciplina no se pudo dar de alta');
        }
    }
?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#disciplina">Nueva Disciplina</button>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <table class="table table-sm table-bordered table-striped" style="font-size:13px">
            <thead>
                <th>#</th>
                <th>Nombre</th>
                <th>Profesor</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Fin</th>
                <th>Abono</th>
                <th>Clase</th>
                <th>Cupo</th>
                <th>Limite de Cancelaci&oacute;n</th>
                <th></th>
            </thead>
            <tbody>
                <?php echo get_listado_disciplinas(); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="disciplina" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Disciplina</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input required class="form-control form-control-sm" type="text" name="a_nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Descrici&oacute;n</label>
                                <textarea class="form-control form-control-sm" name="a_descripcion" cols="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Profesor</label>
                                <select required name="a_profesor" class="form-control form-control-sm">
                                    <option value="">-Seleccione una opci&oacute;n-</option>
                                    <?php echo get_select_profesor(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Inicio</label>
                                <input required class="form-control form-control-sm" type="date" name="a_fecini" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Finalizaci&oacute;n</label>
                                <input required class="form-control form-control-sm" type="date" name="a_fecfin" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Monto por Abono</label>
                                <input required class="form-control form-control-sm" type="number" min="0" value="0" name="a_monto_mensual">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Monto por Clase</label>
                                <input required class="form-control form-control-sm" type="number" min="0" value="0" name="a_monto_clase">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Cupo</label>
                                <input class="form-control form-control-sm" type="number" step="1" min="0" value="1" name="a_cupo">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label>L&iacute;mite de d&iacute;as para cancelaci&oacute;n</label>
                                <input required class="form-control form-control-sm" type="number" min="0" value="1" name="a_limite_cancelacion">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
