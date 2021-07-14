<?php $titulo = "Informaci&oacute;n de Socio"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $socio = get_info_socio($_GET['id']);
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['btn_domicilio'])) {
            if (update_domicilio_socio($_POST['id'], $_POST['s_domicilio'], $_POST['s_latitud'], $_POST['s_longitud'])) {
                header('location: socio_info.php?id=' . $_POST['id']);
            } else {
                echo 'Error al actualizar domicilio';
                $socio = get_info_socio($_POST['id']);
            }
        }

        if (isset($_POST['btn_datos'])) {
            if (update_datos_socio($_POST['id'], $_POST['s_apellido'], $_POST['s_nombre'], $_POST['s_documento'], $_POST['s_fecnac'], $_POST['s_sexo'])) {
                header('location: socio_info.php?id=' . $_POST['id']);
            } else {
                echo 'Error al actualizar datos';
                $socio = get_info_socio($_POST['id']);
            }
        }

        if (isset($_POST['btn_contacto'])) {
            if (update_contacto_socio($_POST['id'], $_POST['s_telefono'], $_POST['s_celular'], $_POST['s_email'])) {
                header('location: socio_info.php?id=' . $_POST['id']);
            } else {
                echo 'Error al actualizar contacto';
                $socio = get_info_socio($_POST['id']);
            }
        }

        if (isset($_POST['btn_imagen'])) {
            $i_socio = $_POST['id'];
            $DATA = $_FILES['img']['tmp_name'];
            $MIME    = $_FILES["img"]["type"];
            $NAME  = $_FILES["img"]["name"];
            $extension = pathinfo($NAME, PATHINFO_EXTENSION);
            $nombre = $i_socio . '.' . $extension;
            $PATH = "./img/" . get_db();

            move_uploaded_file($DATA, "$PATH/$nombre");

            $image = addslashes(file_get_contents("$PATH/$nombre"));

            $sql = "INSERT INTO " . get_db() . ".imagen (i_socio, i_name, i_mime, i_data) VALUES ('{$i_socio}', '{$NAME}', '{$MIME}', '{$image}')";

            consola($sql);

            if (mysqli_query($conexion, $sql)) {
                header('location: socio_info.php?id=' . $i_socio);
            } else {
                echo 'Error al actualizar la foto del socio';
                $socio = get_info_socio($_POST['id']);
            }
        }
    } else {
        header('location: home.php');
    }
}
?>

<style>
    #map {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        min-height: 100px;
        z-index: 1;
    }

    #intro {
        min-height: 100%;
        height: auto !important;
        height: 100%;
    }

    .container {
        width: auto;
        max-width: 600px;
    }

    .input-group {
        width: 100%;
    }

    .geocoder-control-selected {
        background: #7FDFFF;
        border-color: #7FDFFF;
    }
</style>

<div class="float-right">

    <!--
    <div class="dropdown multilevel">
        <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Accesos Directos</button>
        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <div class="dropleft">
                <a class="dropdown-item" data-toggle="#actividades" data-target="#actividades" style="color:black;" aria-expanded="false" role="presentation">Actividades</a>
                <div class="dropdown-menu" role="menu" id="actividades">
                    <?php echo get_ad_actividades_socio($socio['id']); ?>
                </div>
                <a class="dropdown-item" data-toggle="#clases" data-target="#clases" style="color:black;" aria-expanded="false" role="presentation">Actividades</a>
                <div class="dropdown-menu" role="menu" id="clases">

                </div>
            </div>
                        <a class="dropdown-item" role="presentation" href="#">Third Item</a>
        </div>
    </div>
-->
</div>
<h5><?php echo $titulo . ' # <label id="socio_id">' . $socio['id'] . '</label>'; ?></h5>
<hr>
<div class="row mb-5">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Acciones</p>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-block btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opciones
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="actividades_socio.php?id=<?php echo $socio['id']; ?>">Actividades</a>
                                <a class="dropdown-item" href="clases_socio.php?id=<?php echo $socio['id']; ?>">Clases</a>
                                <a class="dropdown-item" href="socio_carnet.php?id=<?php echo $socio['id']; ?>">Imprimir Carnet</a>
                                <!-- <a class="dropdown-item" href="socio_saldar.php?id=<?php echo $socio['id']; ?>">Saldar Deuda de Socio</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <div class="float-right">
                    <input type="checkbox" class="form-check-input" id="editar_carnet">
                    <label class="form-check-label" for="exampleCheck1">Editar</label>
                </div>
                <p class="text-primary m-0 font-weight-bold">Carnet</p>
            </div>
            <div class="card-body">
                <div class="form-row justify-content-center mb-4">
                    <div class="col" id="contenedor_img">
                        <?php if (check_img_socio($socio['id'])) { ?>
                            <?php echo '<center><img style="width:100%;heigth:auto;max-width:200px;" src="img/perfil.jpg"></center>'; ?>
                        <?php } else {
                            $img_socio = get_img_socio($socio['id']);
                            echo "<center><embed style='width:100%;heigth:auto;max-width:200px;' src='data:" . $img_socio['i_mime'] . ";base64," . base64_encode($img_socio['i_data']) . "'/></center>";
                        }
                        ?>
                    </div>
                </div>
                <div id="div_img" class="form-row text-center mb-4">
                    <form enctype="multipart/form-data" action="" method="post">
                        <input hidden name="id" value="<?php echo $socio['id']; ?>">
                        <input class="form-control form-control-sm mb-4" id="file_img" type="file" style="height:40px;" name="img">
                        <button class="btn btn-sm btn-success" type="submit" name="btn_imagen">Actualizar Im&aacute;gen</button>
                    </form>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col">
                        <div class="form-group">
                            <label for="s_apellido"><strong>ID Carnet</strong></label>
                            <input class="form-control form-control-sm" type="text" readonly value="<?php echo $socio['s_carnet']; ?>" name="s_carnet">
                            <a class="btn btn-sm btn-block btn-primary mt-2" href="socio_vincular.php?id=<?php echo $socio['id']; ?>">Vincular Carnet</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-3" id="deuda_acumulada_socios">
            <div class="card-body">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Deuda acumulada</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo get_deuda_acumulada_socio($socio['id']); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <div class="float-right">
                            <input type="checkbox" class="form-check-input" id="editar_datos">
                            <label class="form-check-label" for="exampleCheck1">Editar</label>
                        </div>
                        <p class="text-primary m-0 font-weight-bold">Datos Personales</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <input hidden name="id" value="<?php echo $socio['id']; ?>">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_apellido"><strong>Apellido</strong></label><input class="form-control form-control-sm" type="text" value="<?php echo $socio['s_apellido']; ?>" id="s_apellido" name="s_apellido"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_nombre"><strong>Nombre</strong></label><input class="form-control form-control-sm" required type="text" name="s_nombre" id="s_nombre" value="<?php echo $socio['s_nombre']; ?>"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_documento"><strong>Documento</strong></label><input class="form-control form-control-sm" type="text" required name="s_documento" id="s_documento" value="<?php echo $socio['s_documento']; ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_fecnac"><strong>Fecha de Nacimiento</strong></label><input class="form-control form-control-sm" type="date" required name="s_fecnac" id="s_fecnac" value="<?php echo $socio['s_fecnac']; ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_sexo"><strong>Sexo</strong></label>
                                        <select name="s_sexo" id="s_sexo" required class="form-control form-control-sm">
                                            <?php echo get_select_sexos($socio['s_sexo']); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="div_datos" class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit" name="btn_datos">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <?php $estado = get_estado_socio($socio['id']); ?>
                        <div class="card bg-<?php echo $estado[1]; ?> text-white shadow" id="estado_socio">
                            <div class="card-body text-uppercase font-weight-bold text-center m-0 p-0">
                                <?php echo $estado[0]; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <div class="float-right">
                            <input type="checkbox" class="form-check-input" id="editar_contacto">
                            <label class="form-check-label" for="exampleCheck1">Editar</label>
                        </div>
                        <p class="text-primary m-0 font-weight-bold">Datos de Contacto</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <input hidden name="id" value="<?php echo $socio['id']; ?>">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_telefono"><strong>Tel&eacute;fono</strong></label><input class="form-control form-control-sm" type="tel" readonly id="s_telefono" name="s_telefono" value="<?php echo $socio['s_telefono']; ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_celular"><strong>Celular</strong></label><input class="form-control form-control-sm" type="tel" readonly name="s_celular" id="s_celular" value="<?php echo $socio['s_celular']; ?>"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_email"><strong>Correo Electr&oacute;nico</strong></label><input class="form-control form-control-sm" readonly type="email" id="s_email" name="s_email" value="<?php echo $socio['s_email']; ?>"></div>
                                </div>
                            </div>
                            <div id="div_contacto" class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit" name="btn_contacto">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <form method="post" action="">
                            <input hidden name="id" value="<?php echo $socio['id']; ?>">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="float-right">
                                            <input type="checkbox" class="form-check-input" id="editar_domicilio">
                                            <label class="form-check-label" for="exampleCheck1">Editar</label>
                                        </div>
                                        <label><strong>Domicilio</strong></label>
                                        <input readonly id="domicilio_anterior" class="form-control form-control-sm" type="text" value="<?php echo $socio['s_domicilio']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="col">
                                    <div style="min-height:200px;" class="form-group">
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="div_domicilio">
                                <div class="form-row mb-2">
                                    <div class="col">
                                        <input readonly class="form-control form-control-sm" type="text" id="s_domicilio" name="s_domicilio">
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="col">
                                        <input readonly class="form-control form-control-sm" type="text" id="s_latitud" name="s_latitud">
                                    </div>
                                    <div class="col">
                                        <input readonly class="form-control form-control-sm" type="text" id="s_longitud" name="s_longitud">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <button class="btn btn-success" type="submit" name="btn_domicilio">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mainmenu() {
        $(" #nav ul ").css({
            display: "none"
        }); // Opera Fix
        $(" #nav li").hover(function() {
            $(this).find('ul:first').css({
                visibility: "visible",
                display: "none"
            }).show(400);
        }, function() {
            $(this).find('ul:first').css({
                visibility: "hidden"
            });
        });
    }

    $(document).ready(function() {
        mainmenu();
    });

    $(document).ready(function() {
        $('#s_apellido').attr('readonly', true);
        $('#s_nombre').attr('readonly', true);
        $('#s_documento').attr('readonly', true);
        $('#s_fecnac').attr('readonly', true);
        $('#s_sexo').attr('disabled', true);
        $('#div_datos').hide();

        $('#domicilio_anterior').show();
        $('#div_domicilio').hide();

        $('#s_telefono').attr('readonly', true);
        $('#s_celular').attr('readonly', true);
        $('#s_email').attr('readonly', true);
        $('#div_contacto').hide();

        $('#div_img').hide();
    });


    var map;

    var searchControl;

    var marcador;

    function insertar_domicilio(domicilio) {
        $('#s_domicilio').val('');
        $('#s_domicilio').val(domicilio);
    }

    function insertar_latlng(latitud, longitud) {
        $('#s_latitud').val('');
        $('#s_longitud').val('');
        $('#s_latitud').val(latitud);
        $('#s_longitud').val(longitud);
    }

    $(document).ready(function() {
        inicializar_mapa();
    });

    function reestablecer_direccion() {
        var geocoder = L.esri.Geocoding.geocodeService();
        geocoder.geocode().text('Provincia de Buenos Aires').run(function(error, response) {
            if (error) {
                return;
            }
            map.fitBounds(response.results[0].bounds);
        });

        var results = L.layerGroup().addTo(map);

        searchControl.on('results', function(data) {
            results.clearLayers();
            for (var i = data.results.length - 1; i >= 0; i--) {
                results.addLayer(L.marker(data.results[i].latlng));
                insertar_domicilio(data.results[i].text);
                insertar_latlng(data.results[i].latlng.lat, data.results[i].latlng.lng);
            }
        });

    }

    function agregar_busqueda() {
        searchControl = L.esri.Geocoding.geosearch({
            placeholder: 'Ingrese la dirección del socio'
        }).addTo(map);

        reestablecer_direccion();
    }

    function quitar_busqueda() {
        searchControl.remove();
    }

    function inicializar_mapa() {
        map = L.map('map').setView([<?php echo $socio['s_latitud']; ?>, <?php echo $socio['s_longitud']; ?>], 16);

        marcador = L.marker([<?php echo $socio['s_latitud']; ?>, <?php echo $socio['s_longitud']; ?>]).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    }

    $('#editar_domicilio').change(function() {
        if ($('#editar_domicilio').is(':checked')) {
            agregar_busqueda();
            $('#domicilio_anterior').hide();
            $('#div_domicilio').show();
        } else {
            quitar_busqueda();
            $('#domicilio_anterior').show();
            $('#div_domicilio').hide();
        }
    });

    $('#editar_contacto').change(function() {
        if ($('#editar_contacto').is(':checked')) {
            $('#s_telefono').attr('readonly', false);
            $('#s_celular').attr('readonly', false);
            $('#s_email').attr('readonly', false);
            $('#div_contacto').show();
        } else {
            $('#s_telefono').attr('readonly', true);
            $('#s_celular').attr('readonly', true);
            $('#s_email').attr('readonly', true);
            $('#div_contacto').hide();
        }
    });

    $('#editar_datos').change(function() {
        if ($('#editar_datos').is(':checked')) {
            $('#s_apellido').attr('readonly', false);
            $('#s_nombre').attr('readonly', false);
            $('#s_documento').attr('readonly', false);
            $('#s_fecnac').attr('readonly', false);
            $('#s_sexo').attr('disabled', false);
            $('#div_datos').show();
        } else {
            $('#s_apellido').attr('readonly', true);
            $('#s_nombre').attr('readonly', true);
            $('#s_documento').attr('readonly', true);
            $('#s_fecnac').attr('readonly', true);
            $('#s_sexo').attr('disabled', true);
            $('#div_datos').hide();
        }
    });

    $('#editar_carnet').change(function() {
        if ($('#editar_carnet').is(':checked')) {
            $('#div_img').show();
        } else {
            $('#div_img').hide();
        }
    });

    (function($) {
        $('.multilevel .dropdown-menu > *').on('mouseenter click', function(e) {
            var elem = $(this);
            elem.parent().find('.dropdown-menu').removeClass('show');
            let menu = elem.find('.dropdown-menu').first();
            if (menu.length) {
                menu.addClass('show');
                e.stopPropagation();
            }
        });
        $('body').click(function() {
            $('.multilevel .dropdown-menu').removeClass('show');
        });
    })(jQuery);

    $(function() {
        $.contextMenu({
            selector: '#estado_socio',
            callback: function(key, options) {
                if (key == 'ALTA') {
                    $(location).attr('href', 'socio_estado.php?id=' + $('#socio_id').text() + '&estado=1');
                }
                if (key == 'BAJA') {
                    $(location).attr('href', 'socio_estado.php?id=' + $('#socio_id').text() + '&estado=2');
                }
                if (key == 'RENUNCIA') {
                    $(location).attr('href', 'socio_estado.php?id=' + $('#socio_id').text() + '&estado=3');
                }
                if (key == 'SUSPENCION') {
                    $(location).attr('href', 'socio_estado.php?id=' + $('#socio_id').text() + '&estado=4');
                }
                if (key == 'LICENCIA') {
                    $(location).attr('href', 'socio_estado.php?id=' + $('#socio_id').text() + '&estado=5');
                }
            },
            items: {
                "ALTA": {
                    name: "Cambiar a ALTA",
                    icon: "fas fa-arrow-up",
                    disabled: function(key, opt) {
                        if ($.trim($(this).text()) == key) {
                            return true;
                        } else {
                            if ($.trim($(this).text()) == 'BAJA') {
                                return true;
                            }
                            return false;
                        }
                    }
                },
                "RENUNCIA": {
                    name: "Cambiar a RENUNCIA",
                    icon: "fas fa-arrow-down",
                    disabled: function(key, opt) {
                        if ($.trim($(this).text()) == key) {
                            return true;
                        } else {
                            if ($.trim($(this).text()) == 'BAJA') {
                                return true;
                            }
                            return false;
                        }
                    }
                },
                "LICENCIA": {
                    name: "Cambiar a LICENCIA",
                    icon: "fas fa-plane-departure",
                    disabled: function(key, opt) {
                        if ($.trim($(this).text()) == key) {
                            return true;
                        } else {
                            if ($.trim($(this).text()) == 'BAJA') {
                                return true;
                            }
                            return false;
                        }
                    }
                },
                "SUSPENCION": {
                    name: "Cambiar a SUSPENCION",
                    icon: "fas fa-user-times",
                    disabled: function(key, opt) {
                        if ($.trim($(this).text()) == key) {
                            return true;
                        } else {
                            if ($.trim($(this).text()) == 'BAJA') {
                                return true;
                            }
                            return false;
                        }
                    }
                },
                "sep1": "---------",
                "BAJA": {
                    name: "Cambiar a BAJA",
                    icon: "fas fa-minus",
                    disabled: function(key, opt) {
                        if ($.trim($(this).text()) == key) {
                            return true;
                        } else {
                            return false;
                        }

                    }
                }
            }
        });
    });

    console.log($.trim($('#estado_socio').text()));

    $(function() {
        $.contextMenu({
            selector: '#deuda_acumulada_socios',
            callback: function(key, options) {
                if (key == 'saldar') {
                    $(location).attr('href', 'tesoreria_cobranza.php?id=' + $('#socio_id').text());
                }
            },
            items: {
                "saldar": {
                    name: "Saldar Deuda de Socio",
                    icon: "fas fa-receipt"
                }
            }
        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>