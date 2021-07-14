<?php $titulo = "Saldar Deuda de Socio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id = $_GET['id'];
    }
?>

<div class="float-right">
    <a href="socio_info.php?id=<?php echo $id; ?>" class="btn btn-sm btn-secondary">Volver a Socio</a>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
    <div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Detalle de Cuotas y Actividades</p>
    </div>
    <div class="card-body">
        
    </div>
</div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
