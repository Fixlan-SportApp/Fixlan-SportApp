<?php
    ob_start();
    session_start();
    include 'assets/php/db.php';
    include 'assets/php/session.php';
    include 'assets/php/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $t_socio = $_GET['t_socio'];
        $t_concepto = urldecode($_GET['t_concepto']);
        $t_tipo = $_GET['t_tipo'];
        $t_id = $_GET['t_id'];
        $t_monto = $_GET['t_monto'];
        $t_usuario = get_id_usuario();

        if(insert_item_tesoreria($t_socio, $t_concepto, $t_tipo, $t_id, $t_monto, $t_usuario)){
            header('location: tesoreria_cobranza.php?id='.$t_socio);
        }else{ 
            echo 'Ha ocurrido un error';
        }
        
    }else{
        header('location: tesoreria_busqueda.php');
    }
