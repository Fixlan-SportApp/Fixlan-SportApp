<?php

ob_start();
include 'assets/php/db.php';
include 'assets/php/functions.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $ct_ingreso = $_POST['ct_ingreso'];
    $ct_cliente = strtoupper($_POST['ct_cliente']);
    $ct_factura = $_POST['ct_factura'];
    $ct_deposito = $_POST['ct_deposito'];
    $ct_banco_emision = strtoupper($_POST['ct_banco_emision']);
    $ct_numero = $_POST['ct_numero'];
    $ct_titular = strtoupper($_POST['ct_titular']);
    $ct_monto = $_POST['ct_monto'];
    $ct_observacion = $_POST['ct_observacion'];

    $sql = "INSERT INTO [".get_db()."].[dbo].[tb_cheque_t] (ct_ingreso, ct_cliente, ct_factura, ct_deposito, ct_banco_emision, ct_numero, ct_titular, ct_monto, ct_estado, ct_observacion) VALUES ('".$ct_ingreso."', '".$ct_cliente."', '".$ct_factura."', '".$ct_deposito."', '".$ct_banco_emision."', '".$ct_numero."', '".$ct_titular."', '".$ct_monto."', 'A DEPOSITAR', '".$ct_observacion."')";

    if(mysqli_query($conexion, $sql)){
        header('location: ct_index.php');
    }else{
        echo 'Error al ingresar el cheque';
    }
    
}


