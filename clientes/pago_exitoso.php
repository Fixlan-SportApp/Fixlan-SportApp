<?php include 'assets/php/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Inicio</h1>
</div>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        
        if($_GET['t'] == 'CLASE'){

            $pago_socio = get_socnro();
            $pago_identificador = $_GET['identificador'];
            $pago_monto = $_GET['monto'];
            $pago_comprobante = $_GET['collection_id'];
            $pago_titulo = $_GET['external_reference'];
            $pago_tipo = "CUOTA ACTIVIDAD";
            $pago_forpag = $_GET['payment_type'];
            $pago_status = $_GET['collection_status'];
            $pago_orderid = $_GET['merchant_order_id'];

            //CHEQUEA SI EXISTE UN PAGO ONLINE CON EL MISMO NRO DE COMPROBANTE
            $check_comprobante = check_comprobante_mp($pago_comprobante);
            if($check_comprobante == 0){
                //INSERTA EL PAGO ONLINE CON LOS DATOS DE MP.
                if(insert_pago_online($pago_socio, $pago_cuota, $pago_monto, $pago_comprobante, $pago_titulo, $pago_tipo, $pago_forpag, $pago_status, $pago_orderid)){
                    //INSERTA EL COMPROBANTE
                    if(insert_comprobante(date('Y-m-d'), null, $c_clase, 4, 2, $pago_monto)){
                        $comprobante = get_nro_comprobante($c_fecha, $pago_identificador, $c_clase, get_socnro());
                        //IMPUTA LA CLASE CON SU NRO DE COMPROBANTE GENERADO
                        if(imputar_clase_paga($pago_identificador, $comprobante)){
                            consola("Clase imputada");
                        }else{
                            consola("No se pudo imputar la cuota");
                        }
                    }else{
                        consola("No se pudo generar el nro de comprobante");
                    }
                }else{
                    consola("No se pudo insertar el pago online");
                }
            }
        }
    }
?>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">Pago realizado con &eacute;xito</h4>
    <p>MercadoPago nos informa que el pago que intent&oacute; realizar, fue exitoso.</p>
    <p>En la brevedad se le imputara como PAGA la cuota abonada. Muchas gracias.</p>
    <p><a href="actividades.php" class="btn btn-primary">Volver a Mis Actividades</a></p>
</div>

<?php include 'assets/php/footer.php'; ?>
