<?php $titulo = "Cheques Terceros Vencidos"; ?>
<?php include 'assets/php/header.php'; ?>

<h4 class="mt-4 text-center">Cheques Terceros Vencidos</h4>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="table-responsive">
            <?php echo tabla_cheques_terceros_vencidos(); ?>
        </div>
    </div>
</div><hr>
<div class="row justify-content-end">
    <div class="col-xs-12 col-sm-12 col-md-3">
        <a href="ct_index.php" class="btn btn-block btn-warning">Volver</a>
    </div>
</div><hr class="m-4">
<script>
    $(document).ready( function () {
        $('#table_cheques').DataTable();
    } );
</script>

<?php include 'assets/php/footer.php'; ?>