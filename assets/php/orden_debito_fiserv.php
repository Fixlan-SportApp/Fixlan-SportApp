<?php

require_once 'orden_debito.php';

/*
=========================================================================================================================
DEBITO EN TARJETA MASTERCARD
=========================================================================================================================

Registro cabecera
=================
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- NroComercio         1      8              9(8)                        Informar el número de comercio.
- TipoRegistro        9      1              9(1)        1               Indicando que se trata de un registro Header
- Presentacion       10      6              DDMMAA                      Fecha en la Cual el comercio fue designado a presentar.
- CantRegistros      16      7              9(7)                        Cantidad de registros detalle. Justificado a derecha, con ceros a la izquierda.
- SignoImporteTotal  23      1              X(1)        0 (cero)  = signo positivo
                                                        - (guion) = signo negativo.
- SumaImportes       24     14              9(12)v99                    Suma de los importes de los registros de detalle.
                                                                        Alineado a derecha, con ceros a la izquierda. Sin punto ni coma decimal.
                                                                        Los importes de los registros de detalle se suman o restan según sean débitos o créditos.
- Filler             38     91              X(91)                       Se completará con espacios en blanco.

=========================================================================================================================
1691125010906210000043000000047122508                                                                                           
=========================================================================================================================

Registro detalle
================
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- NroComercio         1      8              9(8)                        Informar el número de comercio.
- TipoRegistro        9      1              9(1)        2 = registro detalle de débito automático
                                                        3 = registro detalle de cupón crédito

- NroTarjeta         10     16              9(16)                       número de tarjeta del socio
- NroSocio           26     12              9(12)                       Referencia; nro de socio con el que lo identifica el establecimiento
                                                                        Alineado a derecha, con ceros a la izquierda.
- Cuotas             38      3              9(3)                        Alineado a derecha, con ceros a la izquierda.
                                                                        Adhesiones nuevas: cuota a partir de la cual comienza el débito automático de las mismas.
                                                                            El dato a informar deberá ser:
                                                                            - 1 (uno) o 
                                                                            - mayor a 1 (sólo cuando se desee cobrar más de una cuota en el mismo período) y 
                                                                              menor que la cantidad informada en cuotas plan.
                                                                        Adhesiones existentes: cantidad de cuotas que se cancelan.
                                                                            En caso de informarse ceros se cobrará el importe indicado en la novedad
                                                                            pero no se cancelarán cuotas.
- CuotasPlan         41      3              9(3)                        Alineado a derecha, con ceros a la izquierda.
                                                                        Es la cantidad de cuotas del plan al que pertenece la adhesión.
                                                                        Si se trata de un plan ilimitado de cuotas deberá informarse “999”.
- Frecuencia         44      2              9(2)        01              Periodicidad de debitación de las cuotas.
- Importe            46     11              9(9)v99                     Importe del débito automático cobrado o del cupón crédito devuelto por el Establecimiento al socio.
                                                                        Alineado a derecha, con ceros a la izquierda. Sin punto ni coma decimal, ni signo
- Periodo            57      5              X(5)                        Período al que corresponde la cuota del débito.
                                                                        Si corresponde a un cupón crédito, este campo deberá informar “CRED “.
- Filler1            62      1              X(1)        " "             Espacio en blanco.
- FechaVencimiento   63      6              DDMMAA                      Fecha de vencimiento de la obligación de pago del débito automático.
- Filler2            69     60              X(60)       " ... "         Espacios en blanco.
=========================================================================================================================
1691125025165850145672950000000008288001999010000035330007/21                                                                   
=========================================================================================================================
*/


class orden_debito_fiserv extends orden_debito {

    private $signo_suma_importes;

    public function __construct($lista_debitos, $nombre_forpag, $datos_tarjeta) {
        parent::__construct($lista_debitos, $nombre_forpag, $datos_tarjeta);
        $this->nombre_archivo_comun = "DA168D";
        $this->fecha = date('dmy', $this->time);
        // $this->hora = date('Hi', $this->time);
    }

    private function crear_cabecera() {
        return
            str_pad($this->establecimiento, 8, "0", STR_PAD_LEFT) .                             // - NroComercio         1      8              9(8)                        Informar el número de comercio.
            "1" .                                                                               // - TipoRegistro        9      1              9(1)        1               Indicando que se trata de un registro Header
            $this->fecha .                                                                      // - Presentacion       10      6              DDMMAA                      Fecha en la Cual el comercio fue designado a presentar.
            str_pad($this->cant_registros, 7, "0", STR_PAD_LEFT) .                              // - CantRegistros      16      7              9(7)                        Cantidad de registros detalle. Justificado a derecha, con ceros a la izquierda.
            $this->signo_suma_importes .                                                        // - SignoImporteTotal  23      1              X(1)        0 (cero)  = signo positivo
                                                                                                //                                                         - (guion) = signo negativo.
            str_pad(number_format($this->suma_importes, 2, "", ""), 14, "0", STR_PAD_LEFT) .    // - SumaImportes       24     14              9(12)v99                    Suma de los importes de los registros de detalle.
                                                                                                //                                                                         Alineado a derecha, con ceros a la izquierda. Sin punto ni coma decimal.
                                                                                                //                                                                         Los importes de los registros de detalle se suman o restan según sean débitos o créditos.
            str_pad("", 91) .                                                                   // - Filler             38     91              X(91)                       Se completará con espacios en blanco.
            PHP_EOL;
    }

    private function crear_detalle($debito, $NroSecuencia) {
        return
            str_pad($this->establecimiento, 8, "0", STR_PAD_LEFT) .                         // - NroComercio         1      8              9(8)                        Informar el número de comercio.
            "2" .                                                                           // - TipoRegistro        9      1              9(1)        2 = registro detalle de débito automático
                                                                                            //                                                         3 = registro detalle de cupón crédito
            str_pad($debito["sc_debito_tarjeta"], 16) .                                     // - NroTarjeta         10     16              9(16)                       número de tarjeta del socio
            str_pad($debito["s_id"], 12, "0", STR_PAD_LEFT) .                               // - NroSocio           26     12              9(12)                       Referencia; nro de socio con el que lo identifica el establecimiento
                                                                                            //                                                                         Alineado a derecha, con ceros a la izquierda.
            "001" .                                                                         // - Cuotas             38      3              9(3)                        Alineado a derecha, con ceros a la izquierda.
                                                                                            //                                                                         Adhesiones nuevas: cuota a partir de la cual comienza el débito automático de las mismas.
                                                                                            //                                                                             El dato a informar deberá ser:
                                                                                            //                                                                             - 1 (uno) o 
                                                                                            //                                                                             - mayor a 1 (sólo cuando se desee cobrar más de una cuota en el mismo período) y 
                                                                                            //                                                                               menor que la cantidad informada en cuotas plan.
                                                                                            //                                                                         Adhesiones existentes: cantidad de cuotas que se cancelan.
                                                                                            //                                                                             En caso de informarse ceros se cobrará el importe indicado en la novedad
                                                                                            //                                                                             pero no se cancelarán cuotas.
            "999" .                                                                         // - CuotasPlan         41      3              9(3)                        Alineado a derecha, con ceros a la izquierda.
                                                                                            //                                                                         Es la cantidad de cuotas del plan al que pertenece la adhesión.
                                                                                            //                                                                         Si se trata de un plan ilimitado de cuotas deberá informarse “999”.
            "01" .                                                                          // - Frecuencia         44      2              9(2)        01              Periodicidad de debitación de las cuotas.
            str_pad(number_format($debito["c_monto"], 2, "", ""), 11, "0", STR_PAD_LEFT) .  // - Importe            46     11              9(9)v99                     Importe del débito automático cobrado o del cupón crédito devuelto por el Establecimiento al socio.
                                                                                            //                                                                         Alineado a derecha, con ceros a la izquierda. Sin punto ni coma decimal, ni signo
            $debito["c_periodo"] .                                                          // - Periodo            57      5              X(5)                        Período al que corresponde la cuota del débito.
                                                                                            //                                                                         Si corresponde a un cupón crédito, este campo deberá informar “CRED “.
            " " .                                                                           // - Filler1            62      1              X(1)        " "             Espacio en blanco.
            "      " .                                                                      // - FechaVencimiento   63      6              DDMMAA                      Fecha de vencimiento de la obligación de pago del débito automático.
            str_pad("", 60) .                                                               // - Filler2            69     60              X(60)       " ... "         Espacios en blanco.
            PHP_EOL;
    }

    public function convertir() {
        // Por cada $this->lista_debitos
        //      Acumular datos necesarios para registro final
        //      Crear un registro detalle
        // Crear registro cabecera
        $this->cant_registros = 0;
        $this->suma_importes = 0;
        foreach ($this->lista_debitos as $debito) {
            $this->suma_importes += $debito["c_monto"];    //acumular datos para registro final
            $this->lista_registros[] = $this->crear_detalle($debito, ++$this->cant_registros);
        }
        
        $this->signo_suma_importes = 0; // 0 (cero)  = signo positivo / - (guion) = signo negativo.
        if ($this->suma_importes < 0) {
            $this->signo_suma_importes = "-";
            $this->suma_importes = -$this->suma_importes;
        }
        array_unshift($this->lista_registros, $this->crear_cabecera());
    }
}