<?php
    ob_start();
    session_start();
    include 'assets/php/db.php';
    include 'assets/php/session.php';
    include 'assets/php/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
        $socio = $_GET['socio'];
        if(delete_item_tesoreria($id)){
            header('location: tesoreria_cobranza.php?id='.$socio);
        }else{
            echo 'Ha ocurrido un error';
        }
    }else{
        header('location: tesoreria_busqueda.php');
    }
