<?php $titulo = "Listado de Socios"; ?>
<?php include 'assets/php/header.php'; ?>
<h5><?php echo $titulo; ?></h5><hr>
<div class="alert alert-info" role="alert">
    Para visualizar el perfil societario haga click en la fila del socio seleccionado
</div>
<div class="card shadow mb-3">
    <div class="card-body">
        <table id="tabla_socios" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Nro de Socio</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Fec Nacimiento</th>
                    <th>Fec Ingreso</th>
                    <th>Estado</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        var data = [];
        data = <?php echo json_encode(get_lista_socios()); ?>;
        $('#tabla_socios').DataTable({
            data: data,
            deferRender: true,
            scrollY: 300,
            scrollCollapse: true,
            scroller: true,
            paging: false
        });

        interaccion_tabla();
        
        $('#tabla_socios').scroll(function(){
            interaccion_tabla();
        });
    });

    function interaccion_tabla() {
        $('tr td').hover(function() {
            $(this).parent().addClass('table-success');
            $(this).parent().css('cursor', 'pointer');
        }, function() {
            $(this).parent().removeClass('table-success');
        });

        $('td').click(function() {
            var value = $(this).closest('tr').children('td:first').text();
            window.open('socio_info.php?id=' + value, "_self");
        });
    }

</script>

<?php include 'assets/php/footer.php'; ?>
