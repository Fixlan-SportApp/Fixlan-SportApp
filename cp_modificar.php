<?php $titulo = "Modificar Cheque Propio"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $cheque = get_info_cheque_propio($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['cheque_id'];
    $cp_entrega = $_POST['cp_entrega'];
    $cp_proveedor = strtoupper($_POST['cp_proveedor']);
    $cp_factura = $_POST['cp_factura'];
    $cp_pago = $_POST['cp_pago'];
    $cp_banco_emision = strtoupper($_POST['cp_banco_emision']);
    $cp_numero = $_POST['cp_numero'];
    $cp_titular = strtoupper($_POST['cp_titular']);
    $cp_monto = $_POST['cp_monto'];
    $cp_observacion = $_POST['cp_observacion'];

    $sql = "UPDATE [".get_db()."].[dbo].[tb_cheque_p] SET cp_entrega = '".$cp_entrega."', cp_proveedor = '".$cp_proveedor."', cp_factura = '".$cp_factura."', cp_pago = '".$cp_pago."', cp_banco_emision = '".$cp_banco_emision."', cp_numero = '".$cp_numero."', cp_titular = '".$cp_titular."', cp_monto = '".$cp_monto."', cp_observacion = '" . $cp_observacion . "' WHERE id = '" . $id . "'";
    consola($sql);
    if (mysqli_query($conexion, $sql)) {
        header('location: cp_index.php');
    } else {
        $cheque = get_info_cheque_propio($id);
        error('No se pudo modificar el cheque');
    }
}
?>

<h4 class="mt-4">Cheque Propio a Pagar</h4>

<form action="" method="post">
    <input type="text" hidden name="cheque_id" value="<?php echo $id; ?>">
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="cp_entrega">Entrega</label>
                <input type="date" required name="cp_entrega" id="cp_entrega" value="<?php echo $cheque['cp_entrega']->format('Y-m-d'); ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-9">
            <div class="form-group">
                <label for="cp_proveedor">Proveedor</label>
                <input type="text" required name="cp_proveedor" id="cp_proveedor" value="<?php echo $cheque['cp_proveedor']; ?>" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="cp_factura"># Factura</label>
                <input type="text" name="cp_factura" id="cp_factura" value="<?php echo $cheque['cp_factura']; ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="cp_pago">Pago</label>
                <input type="date" required name="cp_pago" id="cp_pago" value="<?php echo $cheque['cp_pago']->format('Y-m-d'); ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-6">
            <div class="form-group">
                <label for="cp_banco_emision">Banco de Emisi&oacute;n</label>
                <input type="text" name="cp_banco_emision" value="<?php echo $cheque['cp_banco_emision']; ?>" id="cp_banco_emision" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="cp_numero"># Cheque</label>
                <input type="text" name="cp_numero" id="cp_numero" value="<?php echo $cheque['cp_numero']; ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-6">
            <div class="form-group">
                <label for="cp_titular">Titular</label>
                <input type="text" name="cp_titular" id="cp_titular" value="<?php echo $cheque['cp_titular']; ?>" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col col-xs-12 col-sm 12 col-md-3">
            <div class="form-group">
                <label for="cp_monto">Monto</label>
                <input type="text" required name="cp_monto" id="cp_monto" value="<?php echo $cheque['cp_monto']; ?>" class="form-control form-control-sm">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-xs-12 col-sm 12 col-md-12">
            <div class="form-group">
                <label for="cp_observacion">Observaciones</label>
                <textarea class="form-control form-control-sm" name="cp_observacion" id="cp_observacion" rows="4"><?php echo $cheque['cp_observacion']; ?></textarea>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <button type="submit" class="btn btn-block btn-primary">Guardar</button>
        </div>
    </div>
</form>

<script>

</script>


<?php include 'assets/php/footer.php'; ?>