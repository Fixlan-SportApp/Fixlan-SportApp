<?php
    $array_ini = parse_ini_file("././boot.ini");
    $conexion = mysqli_connect($array_ini['server'], $array_ini['db_user'], $array_ini['db_pass'], $array_ini['database']);

    if( $conexion ) {
        
    }else{
         include 'error_db.php';
         die();
    }