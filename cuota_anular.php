<?php 
$titulo = "Anulaci&oacute;n de Cuota";
include 'assets/php/header.php'; 

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $cuota = get_info_cuota($_GET['id']);
    if(anular_cuota($_GET['id'])){
        header('location: actividades_info.php?id='.$cuota[18]);
    }else{
        echo '<div class="alert alert-danger" role="alert">La cuota no pudo ser anulada. Intentelo nuevamente. <a href="cuota_info.php?id='.$_GET['id'].'">Volver</a></div>';
    }
}


include 'assets/php/footer.php';