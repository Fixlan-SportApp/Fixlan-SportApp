<?php $titulo = "Eliminar Cheque Terceros"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $cheque = get_info_cheque_tercero($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['cheque_id'];

    $sql = "DELETE FROM [".get_db()."].[dbo].[tb_cheque_t] WHERE id = '".$id."'";
    if(mysqli_query($conexion, $sql)){
        header('location: ct_index.php');
    }else{
        $cheque = get_info_cheque_tercero($id);
        error('No se pudo eliminar el cheque');
    }

}
?>

<h4 class="mt-4">Eliminar Cheque de Tercero</h4>

<form action="" method="post">
    <input type="text" hidden name="cheque_id" value="<?php echo $id; ?>">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="alert alert-danger">
                <?php
                    echo '<p>Cliente: '.$cheque['ct_cliente'].'</p>';
                    echo '<p>Factura: '.$cheque['ct_factura'].'</p>';
                    echo '<p>Nro Cheque: '.$cheque['ct_numero'].'</p>';
                    echo '<p>Monto: $'.moneda($cheque['ct_monto']).'</p>';
                ?>
                <hr>
                <h5>Este proceso no se puede deshacer</h5>
            </div>
        </div>
    </div>
    <div class="row mt-4 justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <button type="submit" class="btn btn-block btn-danger">Eliminar cheque</button>
        </div>
    </div>
</form>

<script>
    
</script>


<?php include 'assets/php/footer.php'; ?>