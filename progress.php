<?php

include 'assets/php/db.php';
include 'assets/php/functions.php';

if (strlen(session_id()) === 0) {
    session_start();
}
$aux_periodo = $_POST['periodo'];
$periodo = date('Y-m-01', strtotime($aux_periodo));

makeProgress($periodo);

function makeProgress($periodo) {
    
    $progress = 0;
    $max = get_total_cuotas_generar($periodo);
    $_SESSION['max'] = $max;
    
    $sql = "SELECT
                '".$periodo."' AS 'c_periodo',
                a.sc_socio AS 'c_socio',
                a.id AS 'c_sc',
                a.sc_forpag AS 'c_forpag',
                a.sc_frepag AS 'c_frepag',
                (SELECT CASE
                    WHEN a.sc_frepag = 1 THEN b.p_mensual
                    WHEN a.sc_frepag = 2 THEN b.p_bimestral
                    WHEN a.sc_frepag = 3 THEN b.p_trimestral
                    WHEN a.sc_frepag = 4 THEN b.p_semestral
                    ELSE b.p_anual END FROM [".get_db()."].[dbo].[periodo] AS b
                WHERE b.p_periodo = '".$periodo."' AND b.p_subcategoria = a.sc_subcategoria) AS 'c_monto'
            FROM [".get_db()."].[dbo].[socio_categoria] AS a WHERE a.sc_frepag IN ".get_frepag_periodo($periodo);
    
    $result = mysqli_query($conexion, $sql);
    
    while($fila = mysqli_fetch_array($result)){
        if (isset($_SESSION['progress'])) {
            session_start(); //IMPORTANT!
        }
        if(insert_cuota_genaut($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5])){
            $progress++;
            $_SESSION['progress'] = $progress;
            session_write_close(); //IMPORTANT!
            sleep(1); //IMPORTANT!
            echo '<script>console.log("'.$_COOKIE['gencuo_insertados'].'");</script>';
        }
    }
}
