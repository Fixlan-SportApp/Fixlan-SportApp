<?php
    $desde = "2021-04-01";
    $hasta = "2022-04-01";
    $begin = new DateTime( $desde );
    $end = new DateTime( $hasta );
    
    $interval = DateInterval::createFromDateString('1 day');
    $daterange = new DatePeriod($begin, $interval ,$end);
    
    foreach($daterange as $date){
        echo $date->format("Ymd") . "<br>";
    }