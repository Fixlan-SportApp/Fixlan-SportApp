<?php $titulo = "Agregar Integrante Grupo Familiar Default"; ?>
<?php include 'assets/php/header.php'; ?>

<h5><?php echo $titulo; ?></h5><hr>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $cabecera = $_GET['id'];
        $integrante = $cabecera;
        if(agregar_integrante_grupofliar($cabecera, $integrante)){
            header('location: socio_grupo.php?id='.$cabecera);
        }else{
            insertar_error('El integrante no se pudo insertar');
        }
    }
?>

<?php include 'assets/php/footer.php'; ?>
