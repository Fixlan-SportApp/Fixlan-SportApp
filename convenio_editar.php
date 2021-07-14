<?php $titulo = "Edici&oacute;n de Convenio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $convenio = get_convenio($_GET['id']); 
    }else{
        header('location: tablas_index.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $c_nombre = $_POST['c_nombre'];
        $c_monto = $_POST['c_monto'];
        $c_estado = $_POST['c_estado'];
        
        if(update_convenio($id, $c_nombre, $c_monto, $c_estado)){
            header('location: tablas_index.php');
        }else{
            echo "Error";
        }
    }
?>
<h5><?php echo $titulo; ?></h5><hr>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
        <div class="card shadow mb-3">
            <div class="card-body">
                <form method="post" action="">
                    <input hidden name="id" value="<?php echo $_GET['id']; ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input class="form-control form-control-sm" type="text" name="c_nombre" value="<?php echo $convenio['c_nombre']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Monto</label>
                                <input class="form-control form-control-sm" step="1" type="number" name="c_monto" value="<?php echo $convenio['c_monto']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control form-control-sm" name="c_estado">
                                    <?php
                                        if($convenio['c_estado'] == 'HABILITADO'){
                                            echo '<option selected value="HABILITADO">HABILITADO</option>';
                                            echo '<option value="DESHABILITADO">DESHABILITADO</option>';
                                        }else{
                                            echo '<option value="HABILITADO">HABILITADO</option>';
                                            echo '<option selected value="DESHABILITADO">DESHABILITADO</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                                <a class="btn btn-secondary" href="tablas_index.php">Volver</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
