<?php $titulo = "Cobranza - Tesoreria"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5><hr>
<form action="" method="post">
    <div class="row justify-content-center">
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
                <label>Carnet</label>
                <input class="form-control" type="text" id="carnet" name="carnet">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="form-group">
                <label>Documento</label>
                <input class="form-control" type="number" id="documento" name="documento">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2">
            <div class="form-group">
                <label>&nbsp;</label><br>
                <button class="btn btn-success" id="btn_submit" type="submit">Buscar</button>
            </div>
        </div>
    </div>
</form>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $carnet = $_POST['carnet'];
        $documento = $_POST['documento'];

        if($carnet != ""){
            // if(check_carnet($carnet)){

            // }else{
            //     echo "No se encuentra el carnet";
            // }
        }else{
            if(!check_socio($documento)){
                $id_socio = get_socnro_alta($documento);
                header('location: tesoreria_cobranza.php?id='.$id_socio);
            }else{
                echo "No se encuentra el carnet";
            }
      }
    }
?>
<script>
    $(document).ready(function(){

        $("#btn_submit").prop("disabled", true);

        $('#carnet').keyup(function() {
            if($("#carnet").val() != ""){
                $("#documento").prop("readonly", true);
                $("#btn_submit").prop("disabled", false);
            }else{
                $("#carnet").prop("readonly", false);
                $("#documento").prop("readonly", false);
                $("#btn_submit").prop("disabled", true);
            }
        });
        $('#documento').keyup(function() {
            if($("#documento").val() != ""){
                $("#carnet").prop("readonly", true);
                $("#btn_submit").prop("disabled", false);
            }else{
                $("#carnet").prop("readonly", false);
                $("#documento").prop("readonly", false);
                $("#btn_submit").prop("disabled", true);
            }
        });

        $('#btn_submit').click(function(){
            if($("#documento").val() == "" && $("#carnet").val() == ""){
                $.dialog({
                    title: 'Text content!',
                    content: 'Simple modal!',
                });
            }
        });

    });
</script>

<?php include 'assets/php/footer.php'; ?>
