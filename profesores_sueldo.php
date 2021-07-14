<?php $titulo = "Liquidar Sueldo Profesor"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id_profesor = $_GET['id'];
        $profesor = get_info_profesor($id_profesor);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_profesor = $_POST['id'];
        $profesor = get_info_profesor($id_profesor);
    }
?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Datos Profesor/a</p>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label>Nombre</label>
                    <input readonly type="text" class="form-control form-control-sm"
                        value="<?php echo $profesor[1]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <label>CUIT</label>
                    <input readonly type="text" class="form-control form-control-sm"
                        value="<?php echo $profesor[2]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <label>Sueldo Base</label>
                    <input readonly type="text" class="form-control form-control-sm"
                        value="<?php echo "$ ".$profesor[8]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-2">
                <div class="form-group">
                    <label>Comisi&oacute;n</label>
                    <input readonly type="text" class="form-control form-control-sm"
                        value="<?php echo($profesor[7]*100) . "%"; ?>">
                </div>
            </div>
        </div>
        <?php
            if ($_SERVER['REQUEST_METHOD'] != 'POST') { ?>
                <form method="post" action="">
                    <input hidden type="text" name="id" value="<?php echo $profesor[0]; ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Desde</label>
                                <input type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>"
                                    name="fecini">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <div class="form-group">
                                <label>Hasta</label>
                                <input type="date" class="form-control form-control-sm" value="<?php echo date('Y-m-d'); ?>"
                                    name="fecfin">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-sm btn-block btn-success">Generar
                                    Liquidaci&oacute;n</button>
                            </div>
                        </div>
                    </div>
                </form>
        <?php } ?>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $porcentaje = $profesor[7];
                $sueldo_base = $profesor[8];
                $fecini = $_POST['fecini'];
                $fecfin = $_POST['fecfin'];
                $datos = get_suma_pagos_profesor($profesor[0], $fecini, $fecfin);
                $cantidad = $datos[0];
                $monto = $datos[1];
                $monto_comision = $monto * $porcentaje;
                $sueldo = $sueldo_base + $monto_comision; ?>
        <hr>
        <h5><?php echo "Liquidaci&oacute;n desde " . date('d/m/Y', strtotime($fecini)) . " hasta " . date('d/m/Y', strtotime($fecfin)); ?></h5>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="card p-2">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Conceptos</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Sueldo Base</td>
                                <td>$ <?php echo moneda($sueldo_base); ?></td>
                            </tr>
                            <tr>
                                <td>Comisi&oacute;n por pagos</td>
                                <td>$ <?php echo moneda($monto_comision); ?></td>
                            </tr>
                            <tr>
                                <td>Monto a Liquidar</td>
                                <td>$ <?php echo moneda($sueldo); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="card p-2">
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Fecha de Egreso</label>
                                    <input class="form-control form-control-sm" type="date" name="e_fecha"
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Caja</label>
                                    <select name="e_caja" class="form-control form-control-sm">
                                        <?php echo get_select_cajas(0); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="float-right">
                                        <div class="form-inline">
                                            <input type="checkbox" id="modificar_monto">
                                            <label>&nbsp;&nbsp;Modificar Monto</label>
                                        </div>
                                    </div>
                                    <label>Monto a abonar</label>
                                    <input class="form-control form-control-sm" id="c_monto" name="e_monto"
                                        value="<?php echo $sueldo; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button class="btn btn-sm btn-success" type="submit">Cobrar</button>
                                    <a class="btn btn-sm btn-secondary"
                                        href="actividades_info.php?id=<?php echo $cuota[18]; ?>">Volver</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php
            } ?>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#c_monto').attr('readonly', true);

    $('#modificar_monto').change(function() {
        if ($('#modificar_monto').is(':checked')) {
            $('#c_monto').attr('readonly', false);
        } else {
            $('#c_monto').attr('readonly', true);
        }
    });
});
</script>

<?php include 'assets/php/footer.php'; ?>