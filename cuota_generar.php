<?php $titulo = "Generaci&oacute;n Manual de Cuota"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $actividad = $_GET['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if(insert_cuota_socio($_POST['fecha'], $_POST['socio_categoria'], $_POST['monto_periodo'])){
            header('location: actividades_info.php?id='.$_POST['socio_categoria']);
        }else{
            echo 'ERROR';
            $actividad = $_POST['socio_categoria']; 
        }
    }
?>

<div class="float-right">
    <a class="btn btn-sm btn-secondary" href="actividades_info.php?id=<?php echo $actividad; ?>">Volver a Actividad</a>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <form method="post" action="">
            <input hidden name="socio_categoria" value="<?php echo $actividad; ?>">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label>Ingrese el periodo a generar</label>
                        <input class="form-control" name="fecha" type="date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <div class="form-inline">
                            <input type="radio" name="monto_periodo" class="mr-2" id="monto_actual" value="ACTUAL">
                            <label>Monto a valor actual</label>
                        </div>
                        <div class="form-inline">
                            <input type="radio" name="monto_periodo" class="mr-2" value="PERIODO">
                            <label>Monto asociado al periodo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Generar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#monto_actual').attr('checked', true);
    });
</script>

<?php include 'assets/php/footer.php'; ?>
