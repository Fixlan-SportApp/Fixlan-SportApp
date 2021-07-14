<?php $titulo = "Actividades del Socio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_GET['id'];
        if(condiciones_alta_categoria_socio($_POST['sc_socio'], $_POST['sc_subcategoria'])){
            if(alta_socio_categoria($_POST['sc_socio'], $_POST['sc_subcategoria'], $_POST['sc_forpag'], $_POST['sc_frepag'], $_POST['sc_beca'], $_POST['sc_convenio'], $_POST['sc_debito_tarjeta'], $_POST['sc_vencimiento'], $_POST['sc_tarjeta'], $_POST['sc_debito_cbu'], $_POST['sc_titular'], $_POST['sc_entidad'])){
                header('location: actividades_socio.php?id='.$_POST['sc_socio']);
            }else{
                echo error("No se pudo dar de alta la actividad, vuelva a intenterlo");
            }
        }else{
            echo error("El socio no posee los requerimientos para la categoria");
        }

    }
    
?>
<div class="float-right">
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#actividad">Nueva Actividad</button>
<a class="btn btn-sm btn-secondary" href="socio_info.php?id=<?php echo $id; ?>">Volver a Socio</a>
</div>

<h5><?php echo $titulo; ?></h5><hr>

<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="card shadow mb-3">
            <div class="card-header py-2">
                <p class="text-primary m-0 font-weight-bold">Listado de Actividades</p>
            </div>
            <div class="card-body">
                <table id="tabla_actividades" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
                    <thead>
                        <tr>
                            <th>C&oacute;d</th>
                            <th>Categor&iacute;a</th>
                            <th>Subcategor&iacute;a</th>
                            <th>Forma de Pago</th>
                            <th>Frecuencia de Pago</th>
                            <th>Beca</th>
                            <th>Convenio</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo get_listado_actividades_socio($id); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="actividad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Actividad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <input hidden name="sc_socio" value="<?php echo $id; ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Categor&iacute;a</label>
                                <select name="sc_categoria" id="categoria" required class="form-control form-control-sm">
                                    <?php echo get_select_categorias(0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Subctegor&iacute;a</label>
                                <select name="sc_subcategoria" id="subcategoria" required class="form-control form-control-sm">
                                    <?php echo get_select_subcategorias(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                <select name="sc_forpag" id="forpag" required class="form-control form-control-sm">
                                    <?php echo get_select_forpag(0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Frecuencia de Pago</label>
                                <select name="sc_frepag" required class="form-control form-control-sm">
                                    <?php echo get_select_frepag(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Beca</label>
                                <select name="sc_beca" required class="form-control form-control-sm">
                                    <?php echo get_select_becas(0); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Convenio</label>
                                <select name="sc_convenio" required class="form-control form-control-sm">
                                    <?php echo get_select_convenios(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="tarjeta">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Tarjeta <small>16 n&uacute;meros</small></label>&nbsp;&nbsp;&nbsp;<span id="characters_tarjeta"></span>
                                    <input class="form-control form-control-sm" id="sc_debito_tarjeta" name="sc_debito_tarjeta">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Fecha de Vencimiento</label>
                                    <input class="form-control form-control-sm" name="sc_vencimiento" placeholder="Ejemplo: 11/25">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Tarjeta</label>
                                    <select name="sc_tarjeta" required class="form-control form-control-sm">
                                        <?php echo get_select_tarjetas(0); ?>
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
                                    <input class="form-control form-control-sm" id="sc_debito_cbu" name="sc_debito_cbu">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Titular</label>
                                    <input class="form-control form-control-sm" name="sc_titular">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Entidad Bancaria</label>
                                    <input class="form-control form-control-sm" name="sc_entidad">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
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
        $('#categoria').ready(function() {
            $('#subcategoria option').remove()
            var classN = $('#categoria option:selected').prop('class');
            var opts = allOptions.filter('.' + classN);
            $.each(opts, function(i, j) {
                $(j).appendTo('#subcategoria');
            });
        });

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
