<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $clase = $_GET['clase'];
        $socio = $_GET['socio'];
        if(delete_reserva_clase($clase, $socio)){
            header('location: clase_info.php?id='.$clase);
        }else{
            echo error("No se pudo eliminar la reserva");
        }
    }
?>

<?php include 'assets/php/footer.php'; ?>