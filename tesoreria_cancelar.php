<?php
    ob_start();
    session_start();
    include 'assets/php/db.php';
    include 'assets/php/session.php';
    include 'assets/php/functions.php';
    
    if(cancelar_cobranza()){
        header('location: tesoreria_busqueda.php');
    }else{
        echo 'Ha ocurrido un error';
    }
