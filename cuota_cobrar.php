<?php $titulo = "Cobrar Cuota"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $cuota = get_info_cuota($_GET['id']);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(cobrar_cuota_individual($_POST['c_fecha'], $_POST['c_cuota'], "", $_POST['c_forpag'], $_POST['c_caja'], $_POST['c_monto'])){
            header('location: actividades_info.php?id='.$_POST['actividad']);
        }else{
            echo 'error';
            $_GET['id'] = $_POST['c_cuota'];
            $cuota = get_info_cuota($_GET['id']);
        }
    }
?>
<div class="float-right"><a class="btn btn-sm btn-secondary" href="actividades_info.php?id=<?php echo $cuota[18]; ?>">Volver a Actividad</a></div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
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
                <form method="post" action="">
                    <input hidden name="c_cuota" value="<?php echo $_GET['id']; ?>">
                    <input hidden name="actividad" value="<?php echo $cuota[18]; ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Pago</label>
                                <input class="form-control form-control-sm" type="date" name="c_fecha" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Caja</label>
                                <select name="c_caja" class="form-control form-control-sm">
                                    <?php echo get_select_cajas(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                <select name="c_forpag" class="form-control form-control-sm">
                                    <?php echo get_select_forpag(0); ?>
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
                                <input class="form-control form-control-sm" id="c_monto" name="c_monto" value="<?php echo $cuota[9];?>">
                            </div>
                        </div>
                    </div>
<!--
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-inline">
                                    <input type="checkbox" id="comprobante_email">
                                    <label>&nbsp;&nbsp;Enviar comprobante por correo electr&oacute;nico</label>
                                </div>
                            </div>
                        </div>
                    </div>
-->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <button class="btn btn-sm btn-success" type="submit">Cobrar</button>
                                <a class="btn btn-sm btn-secondary" href="actividades_info.php?id=<?php echo $cuota[18]; ?>">Volver</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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
