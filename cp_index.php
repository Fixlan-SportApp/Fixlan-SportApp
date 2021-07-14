<?php $titulo = "Cheques Propios"; ?>
<?php include 'assets/php/header.php'; ?>

<div class="float-right">
    <a href="ct_index.php" class="btn btn-secondary">Cheques Terceros</a>
</div>
<h4 class="mt-4">Cheques Propios</h4>

<h4 class="mt-4 text-center">A Pagar</h4>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="table-responsive">
            <table class="table table-lg table-bordered table-striped" style="font-size: 15px;">
                <thead>
                    <tr>
                        <td></td>
                        <td>Hoy</td>
                        <td>1 - 7 d&iacute;as</td>
                        <td>8 - 15 d&iacute;as</td>
                        <td>16 - 30 d&iacute;as</td>
                        <td>31 - 60 d&iacute;as</td>
                        <td>> 60 d&iacute;as</td>
                        <td>
                            <h5>Total</h5>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Cheques en $</td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d'), date('Y-m-d')); ?></td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 1 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 7 day'))); ?></td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 8 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 15 day'))); ?></td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 16 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 30 day'))); ?></td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 31 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 60 day'))); ?></td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 61 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 365 day'))); ?></td>
                        <td><?php echo monto_cheques("PROPIO", date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d') . '+ 365 day'))); ?></td>
                    </tr>
                    <tr>
                        <td>Cantidad de Cheques</td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d'), date('Y-m-d')); ?></td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 1 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 7 day'))); ?></td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 8 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 15 day'))); ?></td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 16 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 30 day'))); ?></td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 31 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 60 day'))); ?></td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d', strtotime(date('Y-m-d') . '+ 61 day')), date('Y-m-d', strtotime(date('Y-m-d') . '+ 365 day'))); ?></td>
                        <td><?php echo cantidad_cheques("PROPIO", date('Y-m-d'), date('Y-m-d', strtotime(date('Y-m-d') . '+ 365 day'))); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
<div class="card p-4">
    <form method="post" action="">
        <div class="float-right">
            <?php echo cheques_vencidos('PROPIOS'); ?>
        </div>
        <div class="form-row align-items-center">
            <div class="col-auto">
                <label class="sr-only" for="desde">Desde</label>
                <input type="date" class="form-control form-control-sm mb-2" id="desde" name="desde" value="<?php if (isset($_POST['desde'])) {
                                                                                                                echo $_POST['desde'];
                                                                                                            } else {
                                                                                                                echo date('Y-m-d');
                                                                                                            } ?>">
            </div>
            <div class="col-auto">
                <label class="sr-only" for="hasta">Hasta</label>
                <input type="date" class="form-control form-control-sm mb-2" id="hasta" name="hasta" value="<?php if (isset($_POST['hasta'])) {
                                                                                                                echo $_POST['hasta'];
                                                                                                            } else {
                                                                                                                echo date('Y-m-d', strtotime(date('Y-m-d') . '+ 365 day'));
                                                                                                            } ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary mb-2">Filtrar</button>
            </div>
        </div>
    </form>
</div>
<div class="row mt-4">
    <div class="col">
        <div class="float-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Nuevo Cheque Propio</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Cheque Propio</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="cp_nuevo.php" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col col-xs-12 col-sm 12 col-md-3">
                                        <div class="form-group">
                                            <label for="cp_entrega">Entrega</label>
                                            <input type="date" value="<?php echo date('Y-m-d');?>" required name="cp_entrega" id="cp_entrega" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-9">
                                        <div class="form-group">
                                            <label for="cp_proveedor">Proveedor</label>
                                            <input type="text" required name="cp_proveedor" id="cp_proveedor" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-xs-12 col-sm 12 col-md-3">
                                        <div class="form-group">
                                            <label for="cp_factura"># Factura</label>
                                            <input type="text" name="cp_factura" id="cp_factura" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm 12 col-md-3">
                                        <div class="form-group">
                                            <label for="cp_pago">Pago</label>
                                            <input type="date" required name="cp_pago" id="cp_pago" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm 12 col-md-6">
                                        <div class="form-group">
                                            <label for="cp_banco_emision">Banco de Emisi&oacute;n</label>
                                            <input type="text" name="cp_banco_emision" id="cp_banco_emision" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-xs-12 col-sm 12 col-md-3">
                                        <div class="form-group">
                                            <label for="cp_numero"># Cheque</label>
                                            <input type="text" name="cp_numero" id="cp_numero" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm 12 col-md-6">
                                        <div class="form-group">
                                            <label for="cp_titular">Titular</label>
                                            <input type="text" name="cp_titular" id="cp_titular" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col col-xs-12 col-sm 12 col-md-3">
                                        <div class="form-group">
                                            <label for="cp_monto">Monto</label>
                                            <input type="text" required name="cp_monto" id="cp_monto" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-xs-12 col-sm 12 col-md-12">
                                        <div class="form-group">
                                            <label for="cp_observacion">Observaciones</label>
                                            <textarea class="form-control form-control-sm" name="cp_observacion" id="cp_observacion" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h4 class="mt-4 text-center">Listado</h4>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="table-responsive">
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
                $hasta = date('Y-m-d', strtotime(date('Y-m-d') . '+ 365 day'));
            }
            echo tabla_cheques_propios($desde, $hasta);
            ?>
        </div>
    </div>
</div>
<hr class="mt-4">

<script>
    $(document).ready( function () {
        $('#table_cheques').DataTable();
    } );
</script>

<?php include 'assets/php/footer.php'; ?>