<?php

abstract class devolucion_debito {

    protected $lista_registros;
    protected $lista_devoluciones;

    protected $base;
    protected $carpeta;
    protected $nombre_archivo;
    protected $empresa_debito;
    protected $nombre_tarjeta;

    // protected $cambiar_tarjeta;

    protected $cant_registros_en_archivo;
    protected $suma_importes;

    public function __construct($nombre_archivo, $base, $datos_tarjeta /*, $cambiar_tarjeta*/) {
        $this->base = $base;
        $this->empresa_debito = $datos_tarjeta["t_empresa_debito"];
        $this->nombre_tarjeta = $datos_tarjeta["t_nombre"];
        $this->carpeta = "{$this->empresa_debito}/{$this->nombre_tarjeta}";
        $this->nombre_archivo = $nombre_archivo;
        // $this->cambiar_tarjeta = $cambiar_tarjeta;

        $this->lista_registros = file("disk/{$this->base}/files/{$this->carpeta}/{$this->nombre_archivo}", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->cant_registros_en_archivo = count($this->lista_registros);
        $this->suma_importes = 0;
        $this->convertir();
        $this->verificar_archivo();
    }

    abstract protected function convertir();

    abstract protected function verificar_archivo();

    abstract public function get_lista_devoluciones();
}
