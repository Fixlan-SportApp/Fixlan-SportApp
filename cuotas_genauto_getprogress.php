<?php

include 'assets/php/db.php';
include 'assets/php/functions.php';

if(isset($_COOKIE['gencuo_periodo'])){
    $periodo = $_COOKIE['gencuo_periodo'];

    $total = get_total_cuotas_generar($periodo);

    $cuotas_generadas = get_total_cuotas_generadas($periodo);

    $porcentaje = round((($cuotas_generadas * 100) / $total), 2);

    echo $porcentaje;
    
}else{
    echo '0';
}