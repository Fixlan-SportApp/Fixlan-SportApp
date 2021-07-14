<?php $titulo = "Opciones de Sistema"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    $estilo = get_estilo_club();
?>

<script>
    jscolor.presets.default = {
        format: 'rgb'
    };
</script>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['color_sidebar'])){
            if(update_color_sidebar($_POST['e_color_sidebar'])){
                header('location: sistema_opciones.php');
            }else{
                echo error("No se pudo guardar el color deseado. Intentelo nuevamente.");
            }
        }
    }
?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <div class="float-right">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit-color_sidebar">
                        <label class="form-check-label">Editar</label>
                    </div>
                </div>
                <p class="text-primary m-0 font-weight-bold">Color del Men&uacute;</p>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <input data-jscolor="{value:'<?php echo $estilo['e_color_sidebar']; ?>'}" name="e_color_sidebar">
                            </div>
                        </div>
                    </div>
                    <div id="div_color_sidebar" class="row">
                        <div class="col">
                            <div class="form-group">
                                <button name="color_sidebar" type="submit" class="btn btn-sm btn-success">Cambiar</button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#div_color_sidebar').hide();
    });
    
    $('#edit-color_sidebar').change(function() {
        if ($('#edit-color_sidebar').is(':checked')) {
            $('#div_color_sidebar').show();
        } else {
            $('#div_color_sidebar').hide();
        }
    });
    
    
</script>

<?php include 'assets/php/footer.php'; ?>
