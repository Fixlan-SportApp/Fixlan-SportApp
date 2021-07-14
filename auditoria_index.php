<?php $titulo = "Auditor&iacute;a"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <form method="post" action="">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>Desde</label>
                        <input type="date" name="fecini" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>Hasta</label>
                        <input type="date" name="fecfin" class="form-control form-control-sm" value="<?php echo date('Y-m-d');?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <button class="btn btn-sm btn-primary" type="submit">Visualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
?>
<div class="card shadow mb-3">
    <div class="card-body">
        <table id="auditoria" class="table table-sm table-bordered" style="font-size:12px;">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Categor&iacute;a</th>
                    <th>Concepto</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php echo get_listado_auditoria($_POST['fecini'], $_POST['fecfin']); ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#auditoria').DataTable({
            "order": [
                [0, "asc"],[1,"asc"]
            ],
            stateSave: true
        });
    });
</script>

<?php } ?>

<?php include 'assets/php/footer.php'; ?>
