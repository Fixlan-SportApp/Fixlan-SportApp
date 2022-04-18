<?php

require_once 'devolucion_debito.php';

/*
=========================================================================================================================
DEVOLUCION DE TARJETA VISA
=========================================================================================================================

Registro cabecera
=================
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- TipoRegistro        1       1     AN                  "0"             Tipo de registro
- Constante1          2       8     AN                  "RDEBLIQC"      Constante
- Constante2         10      10     AN                  “900000    ”    Constante
- Establecimiento    20      10     AN                                  Número del Establecimiento que generó el archivo
- FechaOrigen        30       8     N       AAAAMMDD                    Fecha de generación del archivo origen
- HoraOrigen         38       4     N       HHMM                        Hora de generación del archivo origen
- Constante3         42       1     A                   " "             
- Constante4         43       2     AN                  "  "            
- Libre              45     255     AN                                  Constante 255 espacios
- MarcaFin          300       1     AN                  "*"             Marca de fin de registro – Constante “*”
=========================================================================================================================
0RDEBLIQC900000    0037311321202105061253                                                                                                                                                                                                                                                                  *
=========================================================================================================================

Registro detalle
================
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- TipoRegistro        1      1      AN                  "1"             Tipo de Registro (Fijo "1")
- CodBanco            2      3      AN                                  Código de Banco
- CodCasa             5      3      AN                                  Código de Casa
- NroLote             8      4      AN                                  Número de Lote
- CodTransaccion     12      4      AN                  0005: Consumos en Pesos     Código de Transacción
                                                        6000: Devolución
- Reservado1         16      1      AN                  " "
- Establecimiento    17     10      AN                                  Número de Establecimiento
- NroTarjeta         27     16      AN                                  Número de Tarjeta
- NroCupon           43      8      AN                                  Número de Cupón (Para establecimientos de seguros)
- FechaOrigen        51      6      N       DDMMAA                      Fecha de Origen
- Reservado2         57      6      AN
- Importe            63     15      N       n13d2                       Importe (13 dígitos enteros y 2 decimales con ceros a izquierda)
- Cuotas             78      2      N       
- Reservado3         80     15      AN
- Identificador      95     15      AN
- MarcaPrimerDebito 110      1      AN
- NroCuenta         111     10      AN
- CodRamaSeguro     121      3      AN
- EndosoPoliza      124      3      AN
- Reservado4        127      3      AN
- EstadoMovimiento  130      1      AN                                  Estado del movimiento
- RechazoCodMot1    131      2      AN                                  Rechazo Código Motivo 1
- RechazoDescr1     133     29      AN                                  Descripción motivo de rechazo 1
- RechazoCodMot2    162      2      AN                                  Rechazo Código Motivo 2
- RechazoDescr2     164     29      AN                                  Descripción motivo de rechazo 2
- Reservado5        193     16      AN
- NroTarjetaNueva   209     16      AN                                  Número de Tarjeta Nueva
- FechaPresentacion 225      6      N       DDMMAA                      Fecha de Presentación
- FechaPago         231      6      N       DDMMAA                      Fecha de Pago
- Cartera           237      2      AN
- Reservado6        239     12      AN
- Libre             251     49      AN
- MarcaFin          300      1      AN                  "*"             Marca de fin de registro – Constante “*”
=========================================================================================================================
104401304120005 003731132145465909105537600000000101052103561 000000000125000  000000011100900000000011100900 0517443989         000                             00                             93210000100000204824690000828933060521      02                                                             *
=========================================================================================================================

Registro final
==============
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- TipoRegistro        1       1     AN                  "9"             Código del tipo de Registro – Constante “9”
- Constante1          2       8     AN                  "RDEBLIQC"      Constante
- Constante2         10      10     AN                  “900000    ”    Constante
- Establecimiento    20      10     AN                                  Número del Establecimiento que generó el archivo
- FechaOrigen        30       8     N       AAAAMMDD                    Fecha de generación del archivo origen
- HoraOrigen         38       4     N       HHMM                        Hora de generación del archivo origen
- CantRegistros      42       7     N       n7                          Cantidad total registros detalle (7 dígitos enteros con ceros a izquierda)
- SumaImportes       49      15     N       n13d2                       Sumatoria Importes registros detalle (13 dígitos enteros y 2 decimales con ceros a izquierda)
- Libre              64     236     AN
- MarcaFin          300      1      AN                  "*"             Marca de fin de registro – Constante “*”
=========================================================================================================================
9RDEBLIQC900000    00373113212021050612530005754000000642147400                                                                                                                                                                                                                                            *
=========================================================================================================================
*/

class devolucion_debito_prisma_visa extends devolucion_debito {

    private function crear_cabecera($registro) {
        $result["TipoRegistro"] = substr($registro, 0, 1);          // - TipoRegistro        1       1     AN                  "0"             Tipo de registro
        $result["Establecimiento"] = substr($registro, 19, 10);     // - Establecimiento    20      10     AN                                  Número del Establecimiento que generó el archivo
        $result["FechaOrigen"] = substr($registro, 29, 8);          // - FechaOrigen        30       8     N       AAAAMMDD                    Fecha de generación del archivo origen
        $result["HoraOrigen"] = substr($registro, 37, 4);           // - HoraOrigen         38       4     N       HHMM                        Hora de generación del archivo origen
        return $result;
    }

    private function crear_detalle($registro) {
        $result["TipoRegistro"] = substr($registro, 0, 1);          // - TipoRegistro        1      1      AN                  "1"             Tipo de Registro (Fijo "1")
        $result["Establecimiento"] = substr($registro, 16, 10);     // - Establecimiento    17     10      AN                                  Número de Establecimiento
        $result["NroTarjeta"] = substr($registro, 26, 16);          // - NroTarjeta         27     16      AN                                  Número de Tarjeta
        $result["NroCupon"] = substr($registro, 42, 8);             // - NroCupon           43      8      AN                                  Número de Cupón (Para establecimientos de seguros)
        $result["FechaOrigen"] = substr($registro, 50, 6);          // - FechaOrigen        51      6      N       DDMMAA                      Fecha de Origen
        $result["Importe"] = substr($registro, 62, 15);             // - Importe            63     15      N       n13d2                       Importe (13 dígitos enteros y 2 decimales con ceros a izquierda)
        $result["Cuotas"] = substr($registro, 77, 2);               // - Cuotas             78      2      N       
        $result["Identificador"] = substr($registro, 94, 15);       // - Identificador      95     15      AN
        $result["MarcaPrimerDebito"] = substr($registro, 109, 1);   // - MarcaPrimerDebito 110      1      AN
        $result["NroCuenta"] = substr($registro, 110, 10);          // - NroCuenta         111     10      AN
        $result["EstadoMovimiento"] = substr($registro, 129, 1);    // - EstadoMovimiento  130      1      AN                                  Estado del movimiento
        $result["RechazoCodMot1"] = substr($registro, 130, 2);      // - RechazoCodMot1    131      2      AN                                  Rechazo Código Motivo 1
        $result["RechazoDescr1"] = substr($registro, 132, 29);      // - RechazoDescr1     133     29      AN                                  Descripción motivo de rechazo 1
        $result["RechazoCodMot2"] = substr($registro, 161, 2);      // - RechazoCodMot2    162      2      AN                                  Rechazo Código Motivo 2
        $result["RechazoDescr2"] = substr($registro, 163, 29);      // - RechazoDescr2     164     29      AN                                  Descripción motivo de rechazo 2
        $result["NroTarjetaNueva"] = substr($registro, 208, 16);    // - NroTarjetaNueva   209     16      AN                                  Número de Tarjeta Nueva
        $result["FechaPresentacion"] = substr($registro, 224, 6);   // - FechaPresentacion 225      6      N       DDMMAA                      Fecha de Presentación
        $result["FechaPago"] = substr($registro, 230, 6);           // - FechaPago         231      6      N       DDMMAA                      Fecha de Pago
        return $result;
    }

    private function crear_final($registro) {
        $result["TipoRegistro"] = substr($registro, 0, 1);          // - TipoRegistro        1       1     AN                  "9"             Código del tipo de Registro – Constante “9”
        $result["Establecimiento"] = substr($registro, 19, 10);     // - Establecimiento    20      10     AN                                  Número del Establecimiento que generó el archivo
        $result["FechaOrigen"] = substr($registro, 29, 8);          // - FechaOrigen        30       8     N       AAAAMMDD                    Fecha de generación del archivo origen
        $result["HoraOrigen"] = substr($registro, 37, 4);           // - HoraOrigen         38       4     N       HHMM                        Hora de generación del archivo origen
        $result["CantRegistros"] = substr($registro, 41, 7);        // - CantRegistros      42       7     N       n7                          Cantidad total registros detalle (7 dígitos enteros con ceros a izquierda)
        $result["SumaImportes"] = substr($registro, 48, 15);        // - SumaImportes       49      15     N       n13d2                       Sumatoria Importes registros detalle (13 dígitos enteros y 2 decimales con ceros a izquierda)
        return $result;
    }

    protected function convertir() {
        $this->lista_devoluciones[] = $this->crear_cabecera($this->lista_registros[0]);
        for ($i = 1; $i < $this->cant_registros_en_archivo - 1; $i++) {
            $detalle = $this->crear_detalle($this->lista_registros[$i]);
            $this->lista_devoluciones[] = $detalle;
            $this->suma_importes += $detalle["Importe"];
        }
        $this->lista_devoluciones[] = $this->crear_final($this->lista_registros[$i]);
    }

    protected function verificar_archivo() {
        if ($this->lista_devoluciones[$this->cant_registros_en_archivo - 1]["CantRegistros"] != ($this->cant_registros_en_archivo - 2)) {
            throw new Exception('La cantidad de registros del archivo no coincide con la cantidad informada en el registro final.');
        }
        if ($this->lista_devoluciones[$this->cant_registros_en_archivo - 1]["SumaImportes"] != $this->suma_importes) {
            throw new Exception('La suma de los importes no coincide con la informada en el registro final.');
        }
        return TRUE;
    }

    public function get_lista_devoluciones() {
        $lista = $this->lista_devoluciones;
        array_shift($lista);    // eliminar registro de cabecera
        array_pop($lista);      // eliminar registro final
        return $lista;
    }
}