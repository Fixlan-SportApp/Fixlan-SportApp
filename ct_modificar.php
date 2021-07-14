<?php $titulo = "Modificar Cheque Tercero"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $cheque = get_info_cheque_tercero($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['cheque_id'];
    
    $ct_ingreso = $_POST['ct_ingreso'];
    $ct_cliente = strtoupper($_POST['ct_cliente']);
    $ct_factura = $_POST['ct_factura'];
    $ct_deposito = $_POST['ct_deposito'];
    $ct_banco_emision = strtoupper($_POST['ct_banco_emision']);
    $ct_numero = $_POST['ct_numero'];
    $ct_titular = strtoupper($_POST['ct_titular']);
    $ct_monto = $_POST['ct_monto'];
    $ct_observacion = $_POST['ct_observacion'];


    $sql = "UPDATE [".get_db()."].[dbo].[tb_cheque_t] SET ct_ingreso = '".$ct_ingreso."', ct_cliente = '".$ct_cliente."', ct_factura = '".$ct_factura."', ct_deposito = '".$ct_deposito."', ct_banco_emision = '".$ct_banco_emision."', ct_numero = '".$ct_numero."', ct_titular = '".$ct_titular."', ct_monto = '".$ct_monto."', ct_observacion = '".$ct_observacion."' WHERE id = '" . $id . "'";

    if (mysqli_query($conexion, $sql)) {
        header('location: ct_index.php');
    } else {
        $cheque = get_info_cheque_tercero($id);
        error('No se pudo modificar el cheque');
    }
}
?>

<h4 class="mt-4">Modificar Cheque de Tercero</h4>

<form action="" method="post">
    <input type="text" hidden name="cheque_id" value="<?php echo $id; ?>">
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="ct_ingreso">Ingreso</label>
                <input type="date" required name="ct_ingreso" id="ct_ingreso" value="<?php echo $cheque['ct_ingreso']->format('Y-m-d'); ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <div class="form-group">
                <label for="ct_cliente">Cliente</label>
                <input type="text" required name="ct_cliente" id="ct_cliente"  value="<?php echo $cheque['ct_cliente']; ?>" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="ct_factura"># Factura</label>
                <input type="text" name="ct_factura" id="ct_factura"  value="<?php echo $cheque['ct_factura']; ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="ct_deposito">Deposito</label>
                <input type="date" required name="ct_deposito"  value="<?php echo $cheque['ct_deposito']->format('Y-m-d'); ?>" id="ct_deposito" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-6">
            <div class="form-group">
                <label for="ct_banco_emision">Banco de Emisi&oacute;n</label>
                <input type="text" name="ct_banco_emision"  value="<?php echo $cheque['ct_banco_emision']; ?>" id="ct_banco_emision" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="ct_numero"># Cheque</label>
                <input type="text" name="ct_numero"  value="<?php echo $cheque['ct_numero']; ?>" id="ct_numero" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-6">
            <div class="form-group">
                <label for="ct_titular">Titular</label>
                <input type="text" name="ct_titular"  value="<?php echo $cheque['ct_titular']; ?>" id="ct_titular" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="ct_monto">Monto</label>
                <input type="text" required name="ct_monto"  value="<?php echo $cheque['ct_monto']; ?>" id="ct_monto" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-12">
            <div class="form-group">
                <label for="ct_observacion">Observaciones</label>
                <textarea class="form-control form-control-sm" name="ct_observacion" id="ct_observacion" rows="4"><?php echo $cheque['ct_observacion']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <button type="submit" class="btn btn-block btn-primary">Guardar</button>
        </div>
    </div>
</form>

<script>

</script>


<?php include 'assets/php/footer.php'; ?>