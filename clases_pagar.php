<?php $titulo = "Pagar Clase Individual"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $clase = get_info_clase_socio($_GET['id']);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(cobrar_cuota_individual($_POST['c_fecha'], "", $_POST['c_clase'], $_POST['c_forpag'], $_POST['c_caja'], $_POST['c_monto'])){
            header('location: clases_socio_info.php?id='.$_POST['c_clase']);
        }else{
            echo 'error';
            $_GET['id'] = $_POST['c_clase'];
            $clase = get_info_clase_socio($_GET['id']);
        }
    }

?>

<div class="float-right"><a class="btn btn-sm btn-secondary" href="clases_socio.php?id=<?php echo $clase[9]; ?>">Volver a las Clases del Socio</a></div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="card shadow mb-3">
                    <div class="card-header py-2">
                        <p class="text-primary m-0 font-weight-bold">Detalle de Clase</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td class="text-center" colspan="2">Concepto</td>
                                <td class="text-center">Monto</td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="2">Clase: <?php echo  $clase[2].' '.$clase[3]->format('d/m/Y'); ?></td>
                                <td class="text-right"> $ <?php echo moneda($clase[8]); ?></td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="2"><strong>Total</strong></td>
                                <td class="text-right"><strong>$ <?php echo moneda($clase[8]);?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <form method="post" action="">
                    <input hidden name="c_clase" value="<?php echo $clase[0]; ?>">
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
                                <input class="form-control form-control-sm" id="c_monto" name="c_monto" value="<?php echo $clase[8];?>">
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
                                <a class="btn btn-sm btn-secondary" href="clase_socio_info.php?id=<?php echo $clase[0]; ?>">Volver</a>
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
