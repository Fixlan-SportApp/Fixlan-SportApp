<?php $titulo = "Informaci&oacute;n de Cuota"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $cuota = get_info_cuota($_GET['id']);
    }

    $estado = "";
    if($cuota[10] == 0){
        if($cuota[13] == 'SI'){
            $estado = "ANULADA";
        }else{
            $estado = "IMPAGA";
        }
    }else{
        $estado = "PAGA";
    }
?>

<div class="float-right"><a href="actividades_info.php?id=<?php echo $cuota[18]; ?>" class="btn btn-secondary">Volver a Actividad</a></div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Detalle de Cuota</p>
            </div>
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td class="text-center" colspan="2">Concepto</td>
                        <td class="text-center">Monto</td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">Periodo: <?php echo $cuota[0].' - '.$cuota[3].' | ' .$cuota[4]; ?></td>
                        <td class="text-right"> $ <?php echo moneda($cuota[19]); ?></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">Beca: <?php echo $cuota[7];?></td>
                        <td class="text-right"> - $ <?php echo moneda($cuota[20]);?></td>
                    </tr>
                    <tr>
                        <td class="text-left" colspan="2">Convenio: <?php echo $cuota[8];?></td>
                        <td class="text-right"> - $ <?php echo moneda($cuota[21]);?></td>
                    </tr>
                    <?php
                        $correccion_monto = $cuota[19] - $cuota[9];
                        if($cuota[19] <> $cuota[9]){
                            echo '<tr>
                                    <td class="text-left" colspan="2">Correcci&oacute;n de Monto</td>
                                    <td class="text-right"> - $ '.moneda($correccion_monto).'</td>
                                </tr>';
                        }
                    ?>
                    <tr>
                        <td class="text-left" colspan="2"><strong>Total</strong></td>
                        <td class="text-right"><strong>$ <?php echo moneda($cuota[9]);?></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Informaci&oacute;n de Cuota</p>
            </div>
            <div class="card-body">
                <div class="row justify-content-end">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-block btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opciones
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php if($estado == 'IMPAGA') { ?>
                                <a class="dropdown-item" href="cuota_cobrar.php?id=<?php echo $_GET['id']; ?>">Cobrar</a>
                                <a class="dropdown-item" href="cuota_anular.php?id=<?php echo $_GET['id']; ?>">Anular</a>
                                <?php } ?>
                                <?php if($estado == 'PAGA') { ?>
                                <a class="dropdown-item" href="cuota_desrendir.php?id=<?php echo $_GET['id']; ?>">Desrendir</a>
                                <?php } ?>
                                <?php if($estado == 'ANULADA') { ?>
                                <a class="dropdown-item" href="#">Sin opciones</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Generaci&oacute;n</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $cuota[11]; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Nro de Socio</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $cuota[1]; ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <div class="form-group">
                            <label>Apellido y Nombre</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $cuota[2]; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Forma de Pago</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $cuota[5]; ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Frecuencia de Pago</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $cuota[6]; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Comprobante</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $cuota[10]; ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <input readonly class="form-control form-control-sm" readonly value="<?php echo $estado;; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
