<?php $titulo = "Titulo"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
        $clase = $_GET['clase'];
        if(delete_reserva_clase($id, $clase)){
            header('location: clases_info.php?id='.$clase);
        }else{
            echo error("No se pudo eliminar la reserva");
        }
    }
?>

<?php include 'assets/php/footer.php'; ?>
