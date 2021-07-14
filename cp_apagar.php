<?php $titulo = "Cheque Propio a Pagar"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $cheque = get_info_cheque_propio($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['cheque_id'];
    $cp_observacion = $_POST['cp_observacion'];

    $sql = "UPDATE [".get_db()."].[dbo].[tb_cheque_p] SET cp_observacion = '".$cp_observacion."', cp_estado = 'A PAGAR' WHERE id = '".$id."'";
    if(mysqli_query($conexion, $sql)){
        header('location: cp_index.php');
    }else{
        $cheque = get_info_cheque_propio($id);
        error('No se pudo modificar el cheque');
    }

}
?>

<h4 class="mt-4">Cheque Propio a Pagar</h4>

<form action="" method="post">
    <input type="text" hidden name="cheque_id" value="<?php echo $id; ?>">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="alert alert-info">
                <?php
                    echo '<p>Proveedor: '.$cheque['cp_proveedor'].'</p>';
                    echo '<p>Factura: '.$cheque['cp_factura'].'</p>';
                    echo '<p>Nro Cheque: '.$cheque['cp_numero'].'</p>';
                    echo '<p>Monto: $'.moneda($cheque['cp_monto']).'</p>';
                ?>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <label for="ct_observacion">Observaciones</label>
                <textarea class="form-control" id="cp_observacion" name="cp_observacion"><?php echo $cheque['cp_observacion']; ?></textarea>
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