<?php $titulo = "Cobranza - Tesoreria"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $socio = get_info_socio($_GET['id']);
    }
?>


<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="">N&uacute;mero</label>
            <input readonly type="text" class="form-control" value="<?php echo $socio['id'];?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="form-group">
            <label for="">Apellido</label>
            <input readonly type="text" class="form-control" value="<?php echo $socio['s_apellido'];?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3">
        <div class="form-group">
            <label for="">Nombre</label>
            <input readonly type="text" class="form-control" value="<?php echo $socio['s_nombre'];?>">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2">
        <div class="form-group">
            <label for="">Documento</label>
            <input readonly type="text" class="form-control" value="<?php echo $socio['s_documento'];?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Cuotas Societarias</h6>
            </div>
            <div class="card-body">
                <table style="font-size: 14px;" class="table table-sm table-bordered table-striped">
                    <tr>
                        <th>#</th>
                        <th>Categoria</th>
                        <th>Periodo</th>
                        <th>Monto</th>
                        <th></th>
                    </tr>
                    <?php echo get_cuotas_impagas_socio($socio[0]); ?>
                </table>  
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
    <div class="card">
            <div class="card-header">
                <h6>Clases</h6>
            </div>
            <div class="card-body">
                <table style="font-size: 14px;" class="table table-sm table-bordered table-striped">
                    <tr>
                        <th>#</th>
                        <th>Actividad</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th></th>
                    </tr>
                    <?php echo get_clases_impagas_socio($socio[0]); ?>
                </table>  
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <table id="tb_cobranza" class="table table-bordered table-striped table-sm text-center">
            <tr>
                <th>Concepto</th>
                <th>Monto</th>
                <th></th>
            </tr>
            <?php echo tabla_tesoreria_cobranza(); ?>
        </table>
    </div>
</div>
<hr>
<div id="btn_cerrar" class="text-center">
<a class="btn btn-lg btn-primary" href="tesoreria_cerrar.php?id=<?php echo $socio[0]; ?>">Cobrar</a>
</div>

<script>
    $(document).ready(function(){
        $('#btn_cerrar').hide();
        $('#tb_cobranza tr').each(function() {
            var monto_total = $(this).find("#total_cobranza").html();    
            console.log(monto_total);

            if(monto_total == '<center>$0,00</center>'){
                $('#btn_cerrar').hide();
            }else{
                $('#btn_cerrar').show();
            }

        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>
