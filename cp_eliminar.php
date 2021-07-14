<?php $titulo = "Eliminar Cheque Propio"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $cheque = get_info_cheque_propio($id);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['cheque_id'];

    $sql = "DELETE FROM [".get_db()."].[dbo].[tb_cheque_p] WHERE id = '".$id."'";
    if(mysqli_query($conexion, $sql)){
        header('location: cp_index.php');
    }else{
        $cheque = get_info_cheque_propio($id);
        error('No se pudo eliminar el cheque');
    }

}
?>

<h4 class="mt-4">Eliminar Cheque Propio</h4>

<form action="" method="post">
    <input type="text" hidden name="cheque_id" value="<?php echo $id; ?>">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="alert alert-danger">
                <?php
                    echo '<p>Proveedor: '.$cheque['cp_proveedor'].'</p>';
                    echo '<p>Factura: '.$cheque['cp_factura'].'</p>';
                    echo '<p>Nro Cheque: '.$cheque['cp_numero'].'</p>';
                    echo '<p>Monto: $'.moneda($cheque['cp_monto']).'</p>';
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