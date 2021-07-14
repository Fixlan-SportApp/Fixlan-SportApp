<?php $titulo = "Subcategor&iacute;as"; ?>
<?php include 'assets/php/header.php'; ?>


<div class="card shadow mb-3">
    <div class="card-body">
        <table id="turnos_socio" class="table table-sm table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Socio</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#turnos_socio').DataTable({
            <?php
                $data = get_lista_socios();
            ?>
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            deferRender: true,
            scrollCollapse: true,
            scroller: true,
            data: <?php echo json_encode($data); ?>
        });
    });

</script>

<?php include 'assets/php/footer.php'; ?>