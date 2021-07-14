<?php $titulo = "Edici&oacute;n de Actividad de Socio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $actividad = get_info_actividad_editar($_GET['id']);
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(editar_socio_categoria($_POST['id'], $_POST['sc_subcategoria'], $_POST['sc_forpag'], $_POST['sc_frepag'], $_POST['sc_beca'], $_POST['sc_convenio'], $_POST['sc_debito_tarjeta'], $_POST['sc_vencimiento'], $_POST['sc_tarjeta'], $_POST['sc_debito_cbu'], $_POST['sc_titular'], $_POST['sc_entidad'])){
            header('location: actividades_info.php?id='.$_POST['id']);
        }else{
            echo error('No se pudo editar la actividad, vuelva a intentarlo.');
            $actividad = get_info_actividad_editar($_POST['id']);
        }
    }
?>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <form method="post" action="" autocomplete="off">
            <input name="id" hidden value="<?php echo $actividad[0]; ?>">
            <input name="sc_socio" hidden value="<?php echo $actividad[13]; ?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Categor&iacute;a</label>
                            <select name="sc_categoria" id="categoria" required class="form-control form-control-sm">
                                <?php echo get_select_categorias($actividad[1]); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Subctegor&iacute;a</label>
                            <select name="sc_subcategoria" id="subcategoria" required class="form-control form-control-sm">
                                <?php echo get_select_subcategorias($actividad[2]); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Forma de Pago</label>
                            <select name="sc_forpag" id="forpag" required class="form-control form-control-sm">
                                <?php echo get_select_forpag($actividad[3]); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Frecuencia de Pago</label>
                            <select name="sc_frepag" required class="form-control form-control-sm">
                                <?php echo get_select_frepag($actividad[4]); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Beca</label>
                            <select name="sc_beca" required class="form-control form-control-sm">
                                <?php echo get_select_becas($actividad[5]); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Convenio</label>
                            <select name="sc_convenio" required class="form-control form-control-sm">
                                <?php echo get_select_convenios($actividad[6]); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="tarjeta">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Tarjeta <small>16 n&uacute;meros</small></label>&nbsp;&nbsp;&nbsp;<span id="characters_tarjeta"></span>
                                <input class="form-control form-control-sm" id="sc_debito_tarjeta" name="sc_debito_tarjeta" value="<?php echo $actividad[7]; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Fecha de Vencimiento</label>
                                <input class="form-control form-control-sm" name="sc_vencimiento" placeholder="Ejemplo: 11/25" value="<?php echo $actividad[8]; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label>Tarjeta</label>
                                <select name="sc_tarjeta" required class="form-control form-control-sm">
                                    <?php echo get_select_tarjetas($actividad[9]); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cbu">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>CBU <small>22 n&uacute;meros</small></label>&nbsp;&nbsp;&nbsp;<span id="characters_cbu"></span>
                                <input class="form-control form-control-sm" id="sc_debito_cbu" name="sc_debito_cbu" value="<?php echo $actividad[10]; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Titular</label>
                                <input class="form-control form-control-sm" name="sc_titular" value="<?php echo $actividad[11]; ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Entidad Bancaria</label>
                                <input class="form-control form-control-sm" name="sc_entidad" value="<?php echo $actividad[12]; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                <a type="button" class="btn btn-secondary" href="actividades_info.php?id=<?php echo $actividad[0]; ?>">Volver</a>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        $('#tabla_actividades').DataTable({
            "order": [
                [1, "asc"]
            ],
            stateSave: true
        });

        $('#tarjeta').hide();
        $('#cbu').hide();

        //SELECCION Y FILTRO AUTOMATICO DE CATEGORIA Y SUBCATEGORIA
        var allOptions = $('#subcategoria option')

        $('#categoria').change(function() {
            $('#subcategoria option').remove()
            var classN = $('#categoria option:selected').prop('class');
            var opts = allOptions.filter('.' + classN);
            $.each(opts, function(i, j) {
                $(j).appendTo('#subcategoria');
            });
        });

        //VISUALIZACION DE DIVS DE DEBITO EN BASE A FORPAG

        $('#forpag').change(function() {
            if ($('#forpag option:selected').text() == "DEBITO AUTOMATICO TARJETA") {
                $('#tarjeta').show();
                $('#cbu').hide();
            } else if ($('#forpag option:selected').text() == "DEBITO AUTOMATICO CBU") {
                $('#cbu').show();
                $('#tarjeta').hide();
            } else {
                $('#tarjeta').hide();
                $('#cbu').hide();
            }
        });

        //CONTADOR DE CARACTERES EN DEBITO AUTOMATICO
        $('#sc_debito_tarjeta').keyup(updateCount);
        $('#sc_debito_tarjeta').keydown(updateCount);
        $('#sc_debito_cbu').keyup(updateCount);
        $('#sc_debito_cbu').keydown(updateCount);
    });

    function updateCount() {
        var cs = $(this).val().length;
        $('#characters_tarjeta').text(cs);
        $('#characters_cbu').text(cs);
    }

</script>

<?php include 'assets/php/footer.php'; ?>
