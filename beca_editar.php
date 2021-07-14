<?php $titulo = "Edici&oacute;n de Beca"; ?>
<?php include 'assets/php/header.php'; ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $beca = get_beca($_GET['id']); 
    }else{
        header('location: tablas_index.php');
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $b_nombre = $_POST['b_nombre'];
        $b_porcentaje = $_POST['b_porcentaje'];
        $b_estado = $_POST['b_estado'];
        
        if(update_beca($id, $b_nombre, $b_porcentaje, $b_estado)){
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
                                <input class="form-control form-control-sm" type="text" name="b_nombre" value="<?php echo $beca['b_nombre']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Monto</label>
                                <input class="form-control form-control-sm" step="0.1" type="number" name="b_porcentaje" value="<?php echo $beca['b_porcentaje']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control form-control-sm" name="b_estado">
                                    <?php
                                        if($beca['b_estado'] == 'HABILITADO'){
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
