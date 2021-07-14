<?php $titulo = "Informaci&oacute;n de Periodo"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $periodo = $_GET['periodo'];        
    }else{
        header('location: periodos_index.php');
    }
?>
<div class="float-right"><a class="btn btn-sm btn-secondary" href="periodos_index.php">Volver</a></div>
<div class="float-left"><h4>Periodo: <?php echo date('m/Y', strtotime($periodo)); ?></h4></div><br><br>

<div class="card shadow mb-3">
    <div class="card-body">
        <table id="tabla_periodos" class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th>Categor&iacute;a</th>
                    <th>Subcategor&iacute;a</th>
                    <th>Mensual</th>
                    <th>Bimestral</th>
                    <th>Trimestral</th>
                    <th>Semestral</th>
                    <th>Anual</th>
                </tr>
            </thead>
            <tbody>
                <?php echo get_listado_categorias_periodo($periodo); ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
