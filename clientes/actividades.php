<?php include 'assets/php/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mis Actividades</h1>
</div>

<div class="card mb-2">
    <div class="card-header">
       Mis categor&iacute;as
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table id="tabla_actividadesOLD" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>C&oacute;d</th>
                    <th>Categor&iacute;a</th>
                    <th>Subcategor&iacute;a</th>
                    <th>Forma de Pago</th>
                    <th>Frecuencia de Pago</th>
                    <th>Beca</th>
                    <th>Convenio</th>
                    <th>Estado</th>
                    <th width="20px"></th>
                </tr>
            </thead>
            <tbody>
                <?php echo get_listado_actividades_socio(); ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="float-right">
            <a href="calendario.php" class="btn btn-sm btn-primary">Ver calendario</a>
        </div>
        Mis pr&oacute;ximas clases
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Clase</th>
                    <th>D&iacute;a</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th width="20px"></th>
                </tr>
            </thead>
            <tbody>
                <?php echo listado_clases_socio(); ?>
            </tbody>
        </table>
    </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
