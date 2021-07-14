<?php $titulo = "Vinculaci&oacute;n de Carnet"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
    }
?>

<div class="float-right">
    <a class="btn btn-sm btn-secondary" href="socio_info.php?id=<?php echo $id; ?>">Volver a Socio</a>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Datos Principales</p>
    </div>
    <div class="card-body">
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
