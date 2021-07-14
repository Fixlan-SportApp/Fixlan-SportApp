<?php $titulo = "Categor&iacute;as"; ?>
<?php include 'assets/php/header.php'; ?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#categoria">Nueva Categor&iacute;a</button>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Listado de Categor&iacute;as</p>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Concepto</th>
                            <th width="20px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo get_listado_categorias();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_categoria($_POST['c_nombre'], $_POST['c_descripcion'])){
            header('location: categorias_index.php');
        }else{
            echo 'error';
        }
    }
?>

<div class="modal fade" id="categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Categor&iacute;a</h5>
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
                                <input required class="form-control form-control-sm" type="text" name="c_nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Descripci&oacute;n</label>
                                <textarea class="form-control form-control-sm" rows="4" name="c_descripcion"></textarea>
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
