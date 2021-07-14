<?php
include 'assets/php/db.php';
include 'assets/php/session.php';
include 'assets/php/functions.php';
set_time_limit(20);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    //OBTENER EL PERIODO
    $aux_periodo = $_POST['periodo'];
    $periodo = date('Y-m-01', strtotime($aux_periodo));
    
    sleep(2);
    
    if(check_existencia_periodo($periodo)){
        $sql = "SELECT
                '".$periodo."' AS 'c_periodo',
                a.sc_socio AS 'c_socio',
                a.id AS 'c_sc',
                a.sc_forpag AS 'c_forpag',
                a.sc_frepag AS 'c_frepag',
                a.sc_beca AS 'c_beca',
                a.sc_convenio AS 'c_convenio',
                    (SELECT CASE
                        WHEN a.sc_frepag = 1 THEN b.p_mensual
                        WHEN a.sc_frepag = 2 THEN b.p_bimestral
                        WHEN a.sc_frepag = 3 THEN b.p_trimestral
                        WHEN a.sc_frepag = 4 THEN b.p_semestral
                        ELSE b.p_anual END
                    FROM ".get_db().".periodo AS b
                    WHERE b.p_periodo = '".$periodo."' 
                        AND b.p_subcategoria = a.sc_subcategoria) AS 'c_monto',
                a.sc_subcategoria AS 'c_subcategoria'
                FROM ".get_db().".socio_categoria AS a WHERE a.sc_frepag IN ".get_frepag_periodo($periodo);

        $result = mysqli_query($conexion, $sql);

        while($fila = mysqli_fetch_array($result)){
            sleep(0.5);
            insert_cuota($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5], $fila[6], $fila[7], $fila[8]);
        }
    }
    
    
    
    
}