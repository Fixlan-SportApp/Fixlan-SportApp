<?php $titulo = "Generación de Cuotas - Automáticas"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if(isset($_COOKIE['gencuo_periodo'])){
        setcookie('gencuo_periodo','',time()-100);
    }
?>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <form id="formulario">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label>Seleccione el periodo a generar</label>
                        <input type="date" name="periodo" id="periodo" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <button type="submit" id="btn_generar" class="btn btn-sm btn-success">Generar</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" id="progreso">
            <input hidden id="contador" type="text">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressbar" role="progressbar" style="width: 0%">
                        <div id="porcentaje"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#progreso').hide();
        $('#formulario').show();

        var request;

        $("#formulario").submit(function(event) {

            var period = moment($('#periodo').val()).format('YYYY-MM-01');
            
            $.cookie("gencuo_periodo", period);

            getProgress();

            event.preventDefault();
            if (request) {
                request.abort();
            }
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();

            $inputs.prop("disabled", true);
            $('#formulario').hide();
            $('#progreso').show();
            request = $.ajax({
                url: "cuotas_genauto_progress.php",
                type: "post",
                data: serializedData,
                timeout: 10000,
                async: true, //IMPORTANT!
            });
            request.done(function(response, textStatus, jqXHR) {
                if($('#contador').val() != 0){
                    console.log("Proceso terminado");
                    exito();
                }else{
                    console.log("Proceso cancelado");
                    cancelado();
                    
                }
                
            });
            request.fail(function(jqXHR, textStatus, errorThrown) {
                console.error(
                    "Error: " +
                    textStatus, errorThrown
                );
            });
            request.always(function() {
                $inputs.prop("disabled", false);
            });
        });
    });

    function getProgress() {
        $.ajax({
            url: "cuotas_genauto_getprogress.php",
            type: "GET",
            contentType: false,
            processData: false,
            async: false,
            success: function(data) {
                console.log(data + '%');
                $('#contador').val(data);
                $('#porcentaje').text(data + '%');
                $('#progressbar').css('width', data + '%');
                if (data != 100) {
                    setTimeout('getProgress()', 20);
                }
            }
        });
    }

    function exito() {
        var label_period = moment($('#periodo').val()).format('MM/YYYY');
        $.confirm({
            theme: 'modern',
            title: 'Periodo generado con éxito!',
            content: 'El periodo ' + label_period + ' fue generado con éxito.',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                Ok: {
                    text: 'Ok',
                    btnClass: 'btn-blue',
                    action: function() {
                        $(location).attr('href', 'home.php');
                    }
                }
            }
        });
    }
    
    function cancelado() {
        var label_period = moment($('#periodo').val()).format('MM/YYYY');
        $.confirm({
            theme: 'modern',
            title: 'Error',
            content: 'La generación de cuotas para el mes ' + label_period + ' fue abortada. El periodo no existe o ya estan todas las cuotas generadas',
            type: 'red',
            typeAnimated: true,
            buttons: {
                Ok: {
                    text: 'Ok',
                    btnClass: 'btn-red',
                    action: function() {
                        $(location).attr('href', 'cuotas_automaticas.php');
                    }
                }
            }
        });
    }

</script>

<?php include 'assets/php/footer.php'; ?>
