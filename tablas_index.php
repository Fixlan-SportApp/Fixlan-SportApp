<?php $titulo = "Tablas"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['btn_beca'])){
            if(insert_beca($_POST['b_nombre'], $_POST['b_porcentaje'])){
                
            }else{
                header('location: error.php?id=3');
            }
        }
        if(isset($_POST['btn_convenio'])){
            if(insert_convenio($_POST['c_nombre'], $_POST['c_monto'])){
                
            }else{
                header('location: error.php?id=6');
            }
        }
    }
?>
<h5><?php echo $titulo; ?></h5><hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Formas de Pago</p>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th width="25px">C&oacute;d</th>
                            <th>Descripci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $r = mysqli_query($conexion, "SELECT a.id, a.forpag_nombre FROM ".get_db().".forpag AS a ORDER BY a.id ASC");
                            while($f = mysqli_fetch_array($r)){
                                echo '<tr>';
                                    echo '<td>'.$f[0].'</td>';
                                    echo '<td>'.$f[1].'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Frecuencias de Pago</p>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th width="25px">C&oacute;d</th>
                            <th>Descripci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $r = mysqli_query($conexion, "SELECT a.id, a.frepag_nombre FROM ".get_db().".frepag AS a ORDER BY a.id ASC");
                            while($f = mysqli_fetch_array($r)){
                                echo '<tr>';
                                    echo '<td>'.$f[0].'</td>';
                                    echo '<td>'.$f[1].'</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#beca">Nueva Beca</button>
                </div>
                <p class="text-primary m-0 font-weight-bold">Becas</p>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th width="25px">C&oacute;d</th>
                            <th>Descripci&oacute;n</th>
                            <th>Estado</th>
                            <th width="25px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $r = mysqli_query($conexion, "SELECT a.id, a.b_nombre, a.b_estado FROM ".get_db().".beca AS a ORDER BY a.id ASC");
                            while($f = mysqli_fetch_array($r)){
                                echo '<tr>';
                                    echo '<td>'.$f[0].'</td>';
                                    echo '<td>'.$f[1].'</td>';
                                    echo '<td>'.$f[2].'</td>';
                                    echo '<td><a href="beca_editar.php?id='.$f[0].'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a></td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#convenio">Nuevo Convenio</button>
                </div>
                <p class="text-primary m-0 font-weight-bold">Convenios</p>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th width="25px">C&oacute;d</th>
                            <th>Descripci&oacute;n</th>
                            <th>Estado</th>
                            <th width="25px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $r = mysqli_query($conexion, "SELECT a.id, a.c_nombre, a.c_estado FROM ".get_db().".convenio AS a ORDER BY a.id ASC");
                            while($f = mysqli_fetch_array($r)){
                                echo '<tr>';
                                    echo '<td>'.$f[0].'</td>';
                                    echo '<td>'.$f[1].'</td>';
                                    echo '<td>'.$f[2].'</td>';
                                    echo '<td><a href="convenio_editar.php?id='.$f[0].'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a></td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!--NUEVA BECA-->
<div class="modal fade" id="beca" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Beca</h5>
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
                                <input class="form-control form-control-sm" required type="text" name="b_nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Porcentaje <small><i>Expresar valor en n&uacute;meros</i></small></label>
                                <input class="form-control form-control-sm" type="number" required step="0.1" name="b_porcentaje">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_beca" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--NUEVO CONVENIO-->
<div class="modal fade" id="convenio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Convenio</h5>
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
                                <label>Monto <small><i>Expresar valor en n&uacute;meros</i></small></label>
                                <input required class="form-control form-control-sm" step="1" type="number" name="c_monto">
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
