<?php

abstract class orden_debito {

    protected $lista_debitos;
    protected $lista_registros;

    protected $datos_tarjeta;
    protected $nombre_tarjeta;
    protected $establecimiento;
    protected $DoC;
    protected $empresa_debito;

    protected $time;
    protected $fecha;
    protected $hora;

    protected $cant_registros;
    protected $suma_importes;

    protected $carpeta;
    protected $nombre_archivo;
    protected $nombre_archivo_comun;
    
    public function __construct($lista_debitos, $nombre_forpag, $datos_tarjeta) {
        $this->lista_debitos = $lista_debitos;
        $this->lista_registros = [];
        $this->cant_registros = 0;
        $this->suma_importes = 0;

        $this->datos_tarjeta = $datos_tarjeta;  // id, t_nombre, t_establecimiento, t_DoC, t_empresa_debito
        $this->nombre_tarjeta = $datos_tarjeta['t_nombre'];
        $this->establecimiento = $datos_tarjeta['t_establecimiento'];
        $this->DoC = $datos_tarjeta['t_DoC'];
        $this->empresa_debito = $datos_tarjeta['t_empresa_debito'];

        $this->time = time();
        $fecha = date('Ymd', $this->time);
        $hora = date('Hi', $this->time);

        $this->carpeta = "{$this->empresa_debito}/{$this->nombre_tarjeta}";
        $this->nombre_archivo = "{$fecha}-{$hora}-{$nombre_forpag}-{$this->nombre_tarjeta}.txt";
    }

    abstract public function convertir();

    public function get_cant_registros() {
        return $this->cant_registros;
    }

    public function get_suma_importes() {
        return $this->suma_importes;
    }

    public function get_nombre_archivo() {
        return $this->nombre_archivo;
    }

    public function guardar_archivo($base) {
        try {
            file_put_contents("disk/{$base}/files/{$this->carpeta}/{$this->nombre_archivo}", $this->lista_registros);
            return true;
        }
        catch (Exception $e) {
            return false;
        }
    }
}