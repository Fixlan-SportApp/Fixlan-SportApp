<?php $titulo = "Cuotas Anuladas"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $actividad = $_GET['id'];
    }
?>
<div class="float-right">
    <a href="actividades_info.php?id=<?php echo $actividad; ?>" class="btn btn-sm btn-secondary">Volver a Actividad</a>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <table id="cuotas_anuladas" class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Forma de Pago</th>
                    <th>Frecuencia de Pago</th>
                    <th>Beca</th>
                    <th>Convenio</th>
                    <th>Monto</th>
                    <th>Generaci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    echo get_listado_cuotas_anuladas($actividad);
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#cuotas_anuladas').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>
