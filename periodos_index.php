<?php $titulo = "Periodos"; ?>
<?php include 'assets/php/header.php'; ?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#periodo">Generar Periodo</button>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-body">
                <table id="tabla_periodos" class="table table-sm table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="display:none">periodo</th>
                            <th>Periodo</th>
                            <th>Cantidad Categor&iacute;as habilitadas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo get_listado_periodos(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(generar_periodo($_POST['p_periodo'])){
            header('location: periodos_index.php');
        }else{
            echo 'error';
        }
    }
?>

<div class="modal fade" id="periodo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Periodo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Seleccione el periodo a generar</label>
                                <input required class="form-control form-control-sm" type="date" name="p_periodo" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Generar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabla_periodos').DataTable({
            "order": [
                [0, "desc"]
            ],
            stateSave: true
        });
    });

</script>



<?php include 'assets/php/footer.php'; ?>
