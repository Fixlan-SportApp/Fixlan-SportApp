<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['lote'])) {
        $lote = $_GET['lote'];
    }
    $titulo = "Rechazos del lote {$lote}";
    include 'assets/php/header.php';
?>
<h5><?php echo $titulo; ?></h5><hr>
<div id="aviso" class="alert alert-info" role="alert" style="display: none">
    <span>No hay rechazos para el lote seleccionado.</span>
</div>
<div class="card shadow mb-3">
    <div class="card-body">
        <table id="tabla_rechazos" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Id.</th>
                    <th>Nro. de socio</th>
                    <th>Tarjeta</th>
                    <th>Fecha origen</th>
                    <th>Importe</th>
                    <th>Identificador</th>
                    <th>Cod. rechazo</th>
                    <th>Descripción rechazo</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        var data = [];
        data = <?php echo json_encode(get_lista_rechazos($lote)); ?>;
        data.length == 0 && $('#aviso').show();
        // console.log(data);
        $('#tabla_rechazos').DataTable({
            data: data,
            columns: [
                { data: "id", "visible": false },
                { data: "r_socio" },
                { data: "tarjeta" },
                { data: "fecha_origen" },
                { data: "importe" },
                { data: "identificador" },
                { data: "cod_rechazo" },
                { data: "descripcion_rechazo" },
            ],
            deferRender: true,
            scrollY: 300,
            scrollCollapse: true,
            scroller: true,
            paging: false
        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>
