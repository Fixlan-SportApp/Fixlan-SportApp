<?php
    $array_ini = parse_ini_file("././boot.ini");

    if (!isset($conexion)) {
        $conexion = mysqli_connect($array_ini['server'], $array_ini['db_user'], $array_ini['db_pass'], $array_ini['database']);
        $sportapp_db = $array_ini['database'];
    }
    
    if( $conexion ) {
        //echo '<script>console.log("Conexion con la base de datos exitosa");</script>';
    }else{
         include 'error_db.php';
         die();
    }