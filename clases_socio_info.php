<?php $titulo = "Informaci&oacute;n de Clase"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id_clase = $_GET['id'];
        $clase = get_info_clase_socio($id_clase);
    }
?>

<div class="float-right">
    <a class="btn btn-success" href="clases_saldar.php?id=<?php echo $clase[7]; ?>">Saldar Clases</a>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Datos de Clase</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input readonly class="form-control form-control-sm" value="<?php echo $clase[2]; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>D&iacute;a</label>
                            <input readonly class="form-control form-control-sm" value="<?php echo $clase[3]->format('d/m/Y'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Hora Inicio</label>
                            <input readonly class="form-control form-control-sm" value="<?php echo $clase[4]->format('H:i'); ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>Hora Fin</label>
                            <input readonly class="form-control form-control-sm" value="<?php echo $clase[5]->format('H:i'); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <h2><?php echo get_badge_estado_clase($clase[6]); ?></h2>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <?php
                                if($clase[6] == "IMPAGA"){
                                    echo '<a href="clases_pagar.php?id='.$id_clase.'" class="btn btn-block btn-success">Pagar</a>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Clases relacionadas</p>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>D&iacute;a</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<?php include 'assets/php/footer.php'; ?>
