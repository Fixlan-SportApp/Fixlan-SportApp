<?php $titulo = "Ingresos"; ?>
<?php include 'assets/php/header.php'; ?>

<?php

$desde = "";
$hasta = "";
if (isset($_POST['desde'])) {
    $desde = $_POST['desde'];
} else {
    $desde = date('Y-m-d');
}
if (isset($_POST['hasta'])) {
    $hasta = $_POST['hasta'];
} else {
    $hasta = date('Y-m-d');
}
?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <form action="" method="post">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="desde">Desde</label>
                        <input type="date" name="desde" id="desde" class="form-control" value="<?php echo $desde; ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="hasta">Hasta</label>
                        <input type="date" name="hasta" id="hasta" class="form-control" value="<?php echo $hasta; ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="hasta">&nbsp;</label><br />
                        <button type="submit" class="btn btn-success">Filtrar</button>
                    </div>
                </div>
            </div>
        </form>
        <?php echo tabla_ingresos($desde, $hasta); ?>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>