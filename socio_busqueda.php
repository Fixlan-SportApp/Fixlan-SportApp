<?php $titulo = "B&uacute;squeda de Socio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $campo = $_POST['campo'];
    }else{
        header('location: home.php');
    }
?>
<h5><?php echo $titulo; ?></h5>
<div class="card shadow mb-3">
    <div class="card-body">
        <?php if(is_numeric($campo) || !is_numeric($campo)) { ?>
        <table id="tabla_busqueda" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Nro Socio</th>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Fec Nacimiento</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php echo get_resultados_busqueda_socio($campo); ?>
            </tbody>
        </table>
        <?php } else { ?>
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Atenci&oacute;n</h4>
            <p>Para realizar la b&uacute;squeda del Socio es necesario que ingrese un documento o un apellido</p>
        </div>
        <?php } ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabla_busqueda').DataTable({
            "order": [
                [2, "asc"]
            ],
            stateSave: true
        });
    });

</script>

<?php include 'assets/php/footer.php'; ?>
