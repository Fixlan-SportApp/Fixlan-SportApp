<?php
    //'SOCIOS', 'GESTION', 'CLASES', 'MARKETING', 'BOLETERIA', 'TESORERIA', 'CONTABLE', 'RRHH', 'ACCESOS', 'INFRAESTRUCTURA'

    $modulos = array('SOCIOS', 'CLASES', 'CONTABLE');

    $myJSON = json_encode($modulos);

    echo $myJSON;