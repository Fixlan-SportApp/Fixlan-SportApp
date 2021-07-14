<?php $titulo = "Inicio de Programa"; ?>
<?php include 'assets/php/header.php'; ?>
<h5><?php echo $titulo; ?></h5>
<hr>

<div class="row justify-content-center">
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ingresos <small>Mensuales</small></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo get_ingresos_mensuales(); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Egresos <small>Mensuales</small></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$ 0,00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>


<?php
    
?>

<?php include 'assets/php/footer.php'; ?>
