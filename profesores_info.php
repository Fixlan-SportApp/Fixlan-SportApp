<?php $titulo = "Información de Profesor/a"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $profesor = get_info_profesor($_GET['id']);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(update_profesor($_POST['id'], $_POST['p_nombre'], $_POST['p_cuit'], $_POST['p_documento'], $_POST['p_telefono'], $_POST['p_celular'], $_POST['p_email'], $_POST['p_comision'], $_POST['p_sueldo'])){
            header('location: profesores_info.php?id='.$_POST['id']);
        }else{
            echo error("No se pudo editar la información del profesor");
            $profesor = get_info_profesor($_POST['id']);
        }
    }
?>
<div class="float-right">
    <a href="profesores_index.php" class="btn btn-secondary btn-sm">Volver a Profesores</a>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-7">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <div class="float-right">
                    <input type="checkbox" class="form-check-input" id="editar_profesor">
                    <label class="form-check-label" for="exampleCheck1">Editar</label>
                </div>
                <p class="text-primary m-0 font-weight-bold">Informaci&oacute;n</p>
            </div>
            <div class="card-body">
                <form method="post" action="" autocomplete="off">
                    <input hidden name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input required class="form-control form-control-sm" id="p_nombre" type="text" name="p_nombre" value="<?php echo $profesor[1]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>CUIT</label>
                                    <input class="form-control form-control-sm" id="p_cuit" type="text" name="p_cuit" value="<?php echo $profesor[2]; ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Documento</label>
                                    <input required class="form-control form-control-sm" id="p_documento" type="text" name="p_documento" value="<?php echo $profesor[3]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Tel&eacute;fono</label>
                                    <input class="form-control form-control-sm" id="p_telefono" type="tel" name="p_telefono" value="<?php echo $profesor[4]; ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input class="form-control form-control-sm" id="p_celular" type="tel" name="p_celular" value="<?php echo $profesor[5]; ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control form-control-sm" id="p_email" type="email" name="p_email" value="<?php echo $profesor[6]; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Comisi&oacute;n (%)</label>
                                    <input required class="form-control form-control-sm" id="p_comision" type="text" name="p_comision" value="<?php echo ($profesor[7]*100); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Sueldo Base</label>
                                    <input required class="form-control form-control-sm" id="p_sueldo" type="text" name="p_sueldo" value="<?php echo $profesor[8]; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="div_profesor" class="modal-footer">
                        <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Clases</p>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered table-striped" style="font-size:13px">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php echo get_listado_actividades_profesor($_GET['id']); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Acciones</p>
            </div>
            <div class="card-body">
                <a href="profesores_sueldo.php?id=<?php echo $profesor[0]; ?>" class="btn btn-secondary">Liquidar Sueldo</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#div_profesor').hide();
        $('#p_nombre').attr('readonly', true);
        $('#p_cuit').attr('readonly', true);
        $('#p_documento').attr('readonly', true);
        $('#p_telefono').attr('readonly', true);
        $('#p_celular').attr('readonly', true);
        $('#p_email').attr('readonly', true);
        $('#p_comision').attr('readonly', true);
        $('#p_sueldo').attr('readonly', true);
    });
    
    $('#editar_profesor').change(function() {
        if ($('#editar_profesor').is(':checked')) {
            $('#p_nombre').attr('readonly', false);
            $('#p_cuit').attr('readonly', false);
            $('#p_documento').attr('readonly', false);
            $('#p_telefono').attr('readonly', false);
            $('#p_celular').attr('readonly', false);
            $('#p_email').attr('readonly', false);
            $('#p_comision').attr('readonly', false);
            $('#p_sueldo').attr('readonly', false);
            $('#div_profesor').show();
        } else {
            $('#p_nombre').attr('readonly', true);
            $('#p_cuit').attr('readonly', true);
            $('#p_documento').attr('readonly', true);
            $('#p_telefono').attr('readonly', true);
            $('#p_celular').attr('readonly', true);
            $('#p_email').attr('readonly', true);
            $('#p_comision').attr('readonly', true);
            $('#p_sueldo').attr('readonly', true);
            $('#div_profesor').hide();
        }
    });
</script>

<?php include 'assets/php/footer.php'; ?>
