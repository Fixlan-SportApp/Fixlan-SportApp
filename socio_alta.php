<?php $titulo = "Alta de Socio"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(alta_socio($_POST['s_apellido'], $_POST['s_nombre'], $_POST['s_documento'], $_POST['s_fecnac'], $_POST['s_telefono'], $_POST['s_celular'], $_POST['s_email'], $_POST['s_sexo'], $_POST['s_domicilio'], $_POST['s_latitud'], $_POST['s_longitud'])){
            $id_socio = get_socnro_alta($_POST['s_documento']);
            header('location: socio_info.php?id='.$id_socio);
        }else{
            echo 'error';
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
        min-height: 200px;
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

/*
    li {
        padding: 3px 20px;
        margin: 0;
    }

    li:hover {
        background: #7FDFFF;
        border-color: #7FDFFF;
    }
*/

    .geocoder-control-selected {
        background: #7FDFFF;
        border-color: #7FDFFF;
    }

/*
    ul li {
        list-style-type: none;
    }
*/

</style>
<h5><?php echo $titulo; ?></h5>
<form method="post" action="" autocomplete="off">
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Datos Personales</p>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_apellido"><strong>Apellido</strong></label><input class="form-control form-control-sm" type="text" required name="s_apellido"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_nombre"><strong>Nombre</strong></label><input class="form-control form-control-sm" required type="text" name="s_nombre"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_documento"><strong>Documento</strong></label><input class="form-control form-control-sm" type="text" required name="s_documento"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_fecnac"><strong>Fecha de Nacimiento</strong></label><input class="form-control form-control-sm" type="date" required name="s_fecnac"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_sexo"><strong>Sexo</strong></label>
                                        <select name="s_sexo" required class="form-control form-control-sm">
                                            <?php echo get_select_sexos(0);?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Datos de Contacto</p>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_telefono"><strong>Tel&eacute;fono</strong></label><input class="form-control form-control-sm" type="text" name="s_telefono"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_celular"><strong>Celular</strong></label><input class="form-control form-control-sm" type="text" name="s_celular"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_email"><strong>Correo Electr&oacute;nico</strong></label><input class="form-control form-control-sm" type="text" name="s_email"></div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="s_domicilio"><strong>Domicilio</strong></label>
                                        <button id="reestablecer_direccion" type="button" class="btn btn-sm btn-link">Reestablecer Mapa</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="col">
                                    <div style="min-height:400px;" class="form-group">
                                        <div id="map"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><input readonly class="form-control form-control-sm" type="text" id="s_domicilio" name="s_domicilio"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><input readonly class="form-control form-control-sm" type="text" id="s_latitud" name="s_latitud"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><input readonly class="form-control form-control-sm" type="text" id="s_longitud" name="s_longitud"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <button class="btn btn-lg btn-success" type="submit">Alta</button>
        </div>
    </div>
</form>

<script>
    var map;

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

    $('#reestablecer_direccion').click(function() {
        var geocoder = L.esri.Geocoding.geocodeService();
        geocoder.geocode().text('Provincia de Buenos Aires').run(function(error, response) {
            if (error) {
                return;
            }
            map.fitBounds(response.results[0].bounds);
        });
    });

    function inicializar_mapa() {
        map = L.map('map').setView([-36.9812077, -63.270597], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var searchControl = L.esri.Geocoding.geosearch({
            placeholder: 'Ingrese la dirección del socio'
        }).addTo(map);

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

</script>



<?php include 'assets/php/footer.php'; ?>
