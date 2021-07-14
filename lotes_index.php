<?php $titulo = "Lotes de D&eacute;bito Autom&aacute;tico"; ?>
<?php include 'assets/php/header.php'; ?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevo_lote">Nuevo Lote</button>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">

    </div>
</div>

<div class="modal fade" id="nuevo_lote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-row">
                        <div class="col-8">
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                <select id="forpag" class="form-control form-control-sm">
                                    <?php echo get_select_forpag_lote(0); ?>
                                </select>
                            </div>
                        </div>
                        <div id="tarjetas" class="col-4">
                            <div class="form-group">
                                <label>Tarjeta</label>
                                <select class="form-control form-control-sm">
                                    <?php echo get_select_tarjetas_lote(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Generar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        if ($('#forpag option:selected').text() == "DEBITO AUTOMATICO TARJETA") {
            $('#tarjetas').show();
        }else{
            $('#tarjetas').hide();
        }
        
        $('#forpag').change(function() {
            if ($('#forpag option:selected').text() == "DEBITO AUTOMATICO TARJETA") {
                $('#tarjetas').show();
            } else {
                $('#tarjetas').hide();
            }
        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>
