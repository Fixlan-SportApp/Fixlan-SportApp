<?php
    $serverName = "PC-STIER\\SISTEMAS";
    $connectionInfo = array( "Database"=>'master', "UID"=>'sa', "PWD"=>'sa', "CharacterSet" => "UTF-8");
    $conexion = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conexion ) {
        
    }else{
         echo "Connection could not be established.<br />";
         die( print_r( sqlsrv_errors(), true));
    }

    $data = array();
    $r = mysqli_query($conexion, "SELECT SOC_NRO, SOC_APE, SOC_NOM FROM [gelp].[dbo].[SOCIOS] WHERE ESS_COD = 1");
    while($fila = mysqli_fetch_array($r)){
        array_push($data, $fila);
    }
    echo json_encode($data);
?>
