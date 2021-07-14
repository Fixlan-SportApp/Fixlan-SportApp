<?php $titulo = "Gesti&oacute;n de Cheques"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5><hr>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="form-group">
            <a class="btn btn-block btn-primary" href="cp_index.php">Cheques Propios</a>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="form-group">
            <a class="btn btn-block btn-secondary" href="ct_index.php">Cheques Terceros</a>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
