<?php $titulo = "Profesores"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_profesor($_POST['p_nombre'], $_POST['p_cuit'], $_POST['p_documento'], $_POST['p_telefono'], $_POST['p_celular'], $_POST['p_email'], $_POST['p_comision'], $_POST['p_sueldo'])){
            header('location: profesores_index.php');
        }else{
            echo error("El/La profesor/a que desea dar de alta no se pudo guardar. Por favor intentelo nuevamente");
        }
    }
?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#profesor">Nuevo Profesor/a</button>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <table class="table table-sm table-bordered table-striped" style="font-size:13px">
            <thead>
                <th>#</th>
                <th>Nombre</th>
                <th>CUIT</th>
                <th>Documento</th>
                <th>Tel&eacute;fono</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Comisi&oacute;n</th>
                <th>Sueldo Base</th>
                <th></th>
            </thead>
            <tbody>
                <?php echo get_listado_profesores(); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="profesor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Profesor/a</h5>
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
                                <input required class="form-control form-control-sm" type="text" name="p_nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>CUIT</label>
                                <input class="form-control form-control-sm" type="text" name="p_cuit">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Documento</label>
                                <input required class="form-control form-control-sm" type="text" name="p_documento">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Tel&eacute;fono</label>
                                <input class="form-control form-control-sm" type="tel" name="p_telefono">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Celular</label>
                                <input class="form-control form-control-sm" type="tel" name="p_celular">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input required class="form-control form-control-sm" type="email" name="p_email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Comisi&oacute;n <small>Expresar el monto como porcentaje</small></label>
                                <input class="form-control form-control-sm" type="text" name="p_comision">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Sueldo Base</label>
                                <input required class="form-control form-control-sm" type="text" name="p_sueldo">
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
