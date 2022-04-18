<?php
    if (isset($_COOKIE['SP_USER'])) {
        $user_token = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.u_token FROM {$sportapp_db}.tb_usuario AS a WHERE a.u_usuario='".$_COOKIE['SP_USER']."'"));
        if($user_token[0] == $_COOKIE['SP_TOKEN']){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
        }else{
            header('location: logout.php');
        }
    }  
    else {
        header('location: index.php');
    }
