<?php $titulo = "Subcategor&iacute;as"; ?>
<?php include 'assets/php/header.php'; ?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#subcategoria">Nueva Subcategor&iacute;a</button>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mt-2 mb-3">
    <div class="card-body">
        <table id="tabla_subcategorias" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>C&oacute;d</th>
                    <th>Categor&iacute;a</th>
                    <th>Concepto</th>
                    <th>Mensual</th>
                    <th>Bimestral</th>
                    <th>Trimestral</th>
                    <th>Semestral</th>
                    <th>Anual</th>
                    <th>Antig&uuml;edad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php echo get_listado_subcategorias(); ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_subcategoria($_POST['sc_categoria'], $_POST['sc_nombre'], $_POST['sc_descripcion'], $_POST['sc_edadini'], $_POST['sc_edadfin'], $_POST['sc_antiguedad'], $_POST['sc_grupofliar'], $_POST['sc_proxima'], $_POST['sc_mensual'], $_POST['sc_bimestral'], $_POST['sc_trimestral'], $_POST['sc_semestral'], $_POST['sc_anual'])){
            header('location: subcategorias_index.php');
        }else{
            echo 'error';
        }
    }
?>

<div class="modal fade" id="subcategoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Subcategor&iacute;a</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Categor&iacute;a</label>
                                <select name="sc_categoria" required class="form-control form-control-sm">
                                    <?php echo get_select_categorias(0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input required class="form-control form-control-sm" type="text" name="sc_nombre">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Descripci&oacute;n</label>
                                <textarea class="form-control form-control-sm" rows="2" name="sc_descripcion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Edad Inicio</label>
                                <input required class="form-control form-control-sm" type="number" min="0" max="99" step="1" value="0" name="sc_edadini">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Edad Fin</label>
                                <input required class="form-control form-control-sm" type="number" min="0" max="99" step="1" value="0" name="sc_edadfin">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>¿Suma antig&uuml;edad?</label>
                                <select name="sc_antiguedad" required class="form-control form-control-sm">
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>¿Grupo Familiar?</label>
                                <select name="sc_grupofliar" required class="form-control form-control-sm">
                                    <option value="SI">SI</option>
                                    <option selected value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Pr&oacute;xima categor&iacute;a</label>
                                <select name="sc_proxima" required class="form-control form-control-sm">
                                    <option value="NINGUNA">NINGUNA</option>
                                    <?php echo get_select_subcategorias(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Valor Mensual</label>
                                <input required class="form-control form-control-sm" type="number" value="0.00" step="0.50" name="sc_mensual">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Valor Bimestral</label>
                                <input required class="form-control form-control-sm" type="number" value="0.00" step="0.50" name="sc_bimestral">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>Valor Trimestral</label>
                                <input required class="form-control form-control-sm" type="number" value="0.00" step="0.50" name="sc_trimestral">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Valor Semestral</label>
                                <input required class="form-control form-control-sm" type="number" value="0.00" step="0.50" name="sc_semestral">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Valor Anual</label>
                                <input required class="form-control form-control-sm" type="number" value="0.00" step="0.50" name="sc_anual">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabla_subcategorias').DataTable({
            "order": [
                [2, "asc"]
            ],
            stateSave: true
        });
    });

</script>

<?php include 'assets/php/footer.php'; ?>
