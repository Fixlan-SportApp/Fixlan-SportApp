<?php $titulo = "Tesoreria"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5><hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Funciones</p>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item"><a href="tesoreria_busqueda.php" class="btn btn-block btn-primary">Cobranza</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Movimientos del D&iacute;a</p>
            </div>
            <div class="card-body">
                <table style="font-size: 13px;" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Forma de Pago</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo get_tabla_diaria_tesoreria(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
