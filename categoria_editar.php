<?php $titulo = "Editar Categor&iacute;a"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $categoria = get_categoria($_GET['id']);
    }else{
        header('location: categorias_index.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(editar_categoria($_POST['id'], $_POST['c_nombre'], $_POST['c_descripcion'])){
            header('location: categorias_index.php');
        }else{
            echo 'error';
        }
    }
?>

<h5><?php echo $titulo; ?></h5><hr>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card shadow mb-3">
            <div class="card-body">
                <form method="post" action="" autocomplete="off">
                    <input hidden name="id" value="<?php echo $categoria['id']; ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input required class="form-control form-control-sm" type="text" name="c_nombre" value="<?php echo $categoria['c_nombre'];?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Descripci&oacute;n</label>
                                    <textarea class="form-control form-control-sm" rows="4" name="c_descripcion"><?php echo $categoria['c_descripcion'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                        <a type="button" class="btn btn-secondary" href="categorias_index.php">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
