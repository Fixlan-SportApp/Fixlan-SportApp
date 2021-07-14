<?php $titulo = "Incrementar Cupo Clase"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(incrementar_cupo_clase($_GET['id'])){
            header('location: clases_info.php?id='.$_GET['id']);
        }else{
            echo error("No se pudo incrementar el cupo de la clase seleccionada");
        }
    }
?>

<?php include 'assets/php/footer.php'; ?>
