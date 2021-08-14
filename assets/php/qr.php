<?php

$array_ini = parse_ini_file("././boot.ini");

define('URL_SPORTAPP', $array_ini['url_sportapp']);
define('URL_CARNET', $array_ini['url_carnet']);

class QR {

  public static function generate($dni) {
    
    //Generate QR Code
    $tempDir = $_SERVER['DOCUMENT_ROOT'].'/assets/tmp';
    $qrContent = URL_CARNET.'/deuda.php?dni='.$dni;
    $filename = $tempDir.'/'.$dni.'.png';
    $filenameUrl = URL_SPORTAPP.'/assets/tmp/'.$dni.'.png';

    // Check if file exists else generate QR code
    if(!file_exists($filename)){
      QRcode::png($qrContent, $filename, QR_ECLEVEL_H);
    }

    // end displaying
    return "<img src='{$filenameUrl}' alt='QR' title='Código QR del socio'/>";

  }

}
?>