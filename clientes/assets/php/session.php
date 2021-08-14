<?php
    if (isset($_COOKIE['CL_USER'])) {
        $user_token = mysqli_fetch_array(mysqli_query($conexion, "SELECT a.c_token FROM {$array_ini['database']}.tb_cliente AS a WHERE a.c_email='".$_COOKIE['CL_USER']."'"));
        if($user_token[0] == $_COOKIE['CL_TOKEN']){
            date_default_timezone_set('America/Argentina/Buenos_Aires');
        }else{
            header('location: logout.php');
        }
    }  
    else {
        header('location: index.php');
    }