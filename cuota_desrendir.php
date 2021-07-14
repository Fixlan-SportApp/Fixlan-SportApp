<?php $titulo = "Desrendir Cuota"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id = $_GET['id'];
        $cuota = get_info_cuota($id);
        $comprobante = get_info_comprobante($cuota[10]);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $c_monto = -($_POST['c_monto']);
        if (insert_comprobante(date('Y-m-d'), $_POST['c_cuota'], "", $_POST['c_forpag'], $_POST['c_caja'], $c_monto)) {
            if (desrendir_cuota($_POST['c_cuota'])) {
                header('location: cuota_info.php?id=' . $_POST['c_cuota']);
            } else {
                echo 'La cuota '.$_POST['c_cuota'].' no se pudo desrendir.';
                error('La cuota '.$_POST['c_cuota'].' no se pudo desrendir.');
            }
        } else {
            echo 'La cuota '.$_POST['c_cuota'].' no se pudo desrendir. El comprobante no se pudo imputar';
            error('La cuota '.$_POST['c_cuota'].' no se pudo desrendir. El comprobante no se pudo imputar');
        }
        $id = $_POST['c_cuota'];
        $cuota = get_info_cuota($_POST['c_cuota']);
        $comprobante = get_info_comprobante($cuota[10]);
    }
?>
<div class="float-right">
    <a href="cuota_info.php" class="btn btn-sm btn-secondary">Volver a Cuota</a>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
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
                                <td class="text-left" colspan="2">Periodo: <?php echo $cuota[0]->format('m/Y').' - '.$cuota[3].' | ' .$cuota[4]; ?></td>
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
                    <input hidden name="c_cuota" value="<?php echo $id; ?>">
                    <input hidden name="c_monto" value="<?php echo $cuota[9]; ?>">
                    <input hidden name="c_forpag" value="<?php echo $comprobante['c_forpag']; ?>">
                    <input hidden name="c_caja" value="<?php echo $comprobante['c_caja']; ?>">
                    <button class="btn btn-block btn-danger" type="submit">Desrendir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
