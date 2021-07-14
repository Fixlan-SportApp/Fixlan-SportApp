<?php $titulo = "Mapa de Calor de Socios"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <div id="map" style="width:100%; height: 600px;"></div>
    </div>
</div>

<script>
    var mymap;
    
    $(document).ready(function() {
        inicializar_mapa();
        //ubicacion("Calle 9 475, La Plata, Buenos Aires, Argentina");
    });

    function inicializar_mapa() {

        mymap = L.map('map').setView([-34.9215866, -57.9672237], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        L.control.scale().addTo(mymap);
    }
    
    function marcar_en_mapa(lat, lng, datos) {
        var circle = L.circle([lat, lng], {
            color: 'blue',
            fillColor: '#182394',
            fillOpacity: 0.5,
            radius: 3
        }).addTo(mymap).bindPopup(datos);
    }
    
    function ubicacion(direccion) {
        L.esri.Geocoding.geocode({
                requestParams: {
                    maxLocations: 1
                }
            })
            .text(direccion)
            .run(function(error, results, response) {
                marcar_en_mapa(results.results[0].latlng.lat, results.results[0].latlng.lng);
            });
    }

</script>
<?php
    $result = mysqli_query($conexion, "SELECT a.s_apellido, a.s_nombre, a.s_latitud, a.s_longitud, a.s_documento, a.id FROM ".get_db().".socio AS a");
    while($fila = mysqli_fetch_array($result)){
        echo '<script>$(document).ready(function() { marcar_en_mapa('.$fila[2].', '.$fila[3].', "<b>#'.$fila[5].'</b><br><b>'.utf8_decode($fila[0]).', '.utf8_decode($fila[1]).'</b><br>Documento: '.$fila[4].'"); });</script>';
    }
?>



<?php include 'assets/php/footer.php'; ?>
