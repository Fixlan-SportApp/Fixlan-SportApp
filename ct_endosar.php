<?php $titulo = "Endosar Cheque Terceros"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $cheque = get_info_cheque_tercero($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['cheque_id'];
    $ct_endoso = $_POST['ct_endoso'];
    $ct_destinatario_endoso = strtoupper($_POST['ct_destinatario_endoso']);
    $ct_observacion = $_POST['ct_observacion'];

    $sql = "UPDATE [".get_db()."].[dbo].[tb_cheque_t] SET ct_endoso = '".$ct_endoso."', ct_destinatario_endoso = '".$ct_destinatario_endoso."', ct_observacion = '".$ct_observacion."', ct_estado = 'ENDOSADO', ct_banco_depositado = null WHERE id = '".$id."'";
    if(mysqli_query($conexion, $sql)){
        header('location: ct_index.php');
    }else{
        $cheque = get_info_cheque_tercero($id);
        error('No se pudo endosar el cheque');
    }

}
?>

<h4 class="mt-4">Endosado</h4>

<form action="" method="post">
    <input type="text" hidden name="cheque_id" value="<?php echo $id; ?>">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="alert alert-info">
                <?php
                    echo '<p>Cliente: '.$cheque['ct_cliente'].'</p>';
                    echo '<p>Factura: '.$cheque['ct_factura'].'</p>';
                    echo '<p>Nro Cheque: '.$cheque['ct_numero'].'</p>';
                    echo '<p>Monto: $'.moneda($cheque['ct_monto']).'</p>';
                ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <label for="ct_endoso">Fecha de endoso</label>
                <input type="date" required class="form-control" id="ct_endoso" name="ct_endoso" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <label for="ct_destinatario_endoso">Destinatario de Endoso</label>
                <input type="text" required class="form-control" id="ct_destinatario_endoso" name="ct_destinatario_endoso">
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <label for="ct_observacion">Observaciones</label>
                <textarea class="form-control" id="ct_observacion" name="ct_observacion"><?php echo $cheque['ct_observacion']; ?></textarea>
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