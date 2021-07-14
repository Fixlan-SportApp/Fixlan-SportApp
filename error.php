<?php $titulo = "Pantalla de Errores"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if(isset($_GET['id'])){
            $error = get_error($_GET['id']);
            
            echo '<div class="alert alert-'.$error['e_color'].'" role="alert">
                        <h4 class="alert-heading">'.$error['e_titulo'].'</h4>
                        <p>'.$error['e_descripcion'].'</p>
                    </div>';
            
            
            
        }else{
            header('location: home.php');
        }
    }else{
        header('location: home.php');
    }

?>


<?php include 'assets/php/footer.php'; ?>
