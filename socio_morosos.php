<?php $titulo = "Socios Morosos"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <form method="post" action="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>Entre</label>
                        <input type="date" name="fecini" class="form-control form-control-sm" value="<?php echo date('Y-m-01');?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>y</label>
                        <input type="date" name="fecfin" class="form-control form-control-sm" value="<?php echo date('Y-m-01');?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Categor&iacute;a</label>
                        <select name="sc_categoria" id="categoria" required class="form-control form-control-sm">
                            <option value="TODAS">TODAS</option>
                            <?php echo get_select_categorias(0); ?>
                        </select>
                    </div>
                </div>
                <div id="div_subcategoria" class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Subcategor&iacute;a</label>
                        <select name="sc_subcategoria" id="subcategoria" required class="form-control form-control-sm">
                            <?php echo get_select_subcategorias(0); ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-success btn-sm">Generar Informe</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<?php if($_SERVER['REQUEST_METHOD'] == 'POST') { ?>

<table id="socios_morosos" class="table table-sm table-bordered" style="font-size:13px;">
    <div class="row">
        <caption>Desde: <?php echo date('m/Y', strtotime($_POST['fecini'])); ?> | Hasta: <?php echo date('m/Y', strtotime($_POST['fecfin'])); ?></caption>
    </div>
    <thead>
        <tr>
            <th>Socio</th>
            <th>Apellido y Nombre</th>
            <th>Documento</th>
            <th>Categor&iacute;a</th>
            <th>Subcategor&iacute;a</th>
            <th>Deuda</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php echo reporte_morosos($_POST['fecini'], $_POST['fecfin'], $_POST['sc_categoria'], $_POST['sc_subcategoria']); ?>
    </tbody>
</table>
<?php } ?>

<script>
    $(document).ready(function() {
        $('#socios_morosos').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            deferRender: true,
            scrollCollapse: true,
            scroller: true
        });

        $('#div_subcategoria').hide();

        //SELECCION Y FILTRO AUTOMATICO DE CATEGORIA Y SUBCATEGORIA
        var allOptions = $('#subcategoria option')
        //        $('#categoria').ready(function() {
        //            $('#subcategoria option').remove()
        //            var classN = $('#categoria option:selected').prop('class');
        //            var opts = allOptions.filter('.' + classN);
        //            $.each(opts, function(i, j) {
        //                $(j).appendTo('#subcategoria');
        //            });
        //        });

        $('#categoria').change(function() {
            if ($('#categoria option:selected').text() == 'TODAS') {
                $('#div_subcategoria').hide();
            } else {
                $('#div_subcategoria').show();
                $('#subcategoria option').remove()
                var classN = $('#categoria option:selected').prop('class');
                var opts = allOptions.filter('.' + classN);
                $.each(opts, function(i, j) {
                    $(j).appendTo('#subcategoria');
                });
                $("#subcategoria").prepend("<option value='TODAS'>TODAS</option>").val('TODAS');
            }

        });
    });

</script>

<?php include 'assets/php/footer.php'; ?>
