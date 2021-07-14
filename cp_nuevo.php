<?php
    ob_start();
    include 'assets/php/db.php';
    include 'assets/php/functions.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cp_entrega = $_POST['cp_entrega'];
        $cp_proveedor = strtoupper($_POST['cp_proveedor']);
        $cp_factura = $_POST['cp_factura'];
        $cp_pago = $_POST['cp_pago'];
        $cp_banco_emision = strtoupper($_POST['cp_banco_emision']);
        $cp_numero = $_POST['cp_numero'];
        $cp_titular = strtoupper($_POST['cp_titular']);
        $cp_monto = $_POST['cp_monto'];
        $cp_observacion = $_POST['cp_observacion'];
        $cp_estado = 'A PAGAR';

        $sql = "INSERT INTO [".get_db()."].[dbo].[tb_cheque_p] (cp_entrega, cp_proveedor, cp_factura, cp_pago, cp_banco_emision, cp_numero, cp_titular, cp_monto, cp_estado, cp_observacion) VALUES ('".$cp_entrega."', '".$cp_proveedor."', '".$cp_factura."', '".$cp_pago."', '".$cp_banco_emision."', '".$cp_numero."', '".$cp_titular."', '".$cp_monto."', '".$cp_estado."', '".$cp_observacion."')";

        if(mysqli_query($conexion, $sql)){
            header('location: cp_index.php');
        }else{
            echo 'Error al ingresar el cheque';
        }
    }
    