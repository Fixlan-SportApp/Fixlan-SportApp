<?php

require_once 'orden_debito.php';

/*
=========================================================================================================================
DEBITO EN TARJETA VISA
=========================================================================================================================

Registro cabecera
=================
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- TipoRegistro        1      1      AN                  "0"             Tipo de registro
- Constante1          2      8      AN                  "DEBLIQC "      Constante
- Establecimiento    10     10      AN                                  Número del Establecimiento que generó el archivo
- Constante2         20     10      AN                  “900000    ”    Constante
- FechaGeneracion    30      8      N       AAAAMMDD                    Fecha de generación del archivo
- HoraGeneración     38      4      N       HHMM                        Hora de generación del archivo
- TipoArchivo        42      1      A                   "0"             Tipo de Archivo. Débitos a liquidar (“0”= Altas)
- EstadoArchivo      43      2      AN                  "  "            Estado archivo - Constante 2 espacios
- Reservado          45     55      AN                                  Constante 55 espacios
- MarcaFin          100      1      AN                  "*"             Marca de fin de registro – Constante “*”
=========================================================================================================================
0DEBLIQC 0037311321900000    2019111110540                                                         *
0DEBLIQC 0037356830900000    2021071900560                                                         *
=========================================================================================================================

Registro detalle
================
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- TipoRegistro        1      1      AN                  "1"             Tipo de Registro (Fijo "1")
- NroTarjeta          2     16      AN                                  Número de Tarjeta
- Reservado1         18      3      AN                  "   "           Constante 3 espacios
- Referencia         21      8      N                                   Referencia o número de comprobante o Nro. Secuencial ascendente único por archivo
- FechaOrigen        29      8      N       AAAAMMDD                    Fecha de origen o vencimiento del débito
- CodTransacción     37      4      AN                  "0005"          Código de Transacción – Constante 0005
- Importe            41     15      N       n13d2                       Importe (13 dígitos enteros y 2 decimales con ceros a izquierda)
- Identificador      56     15      AN                                  Identificador del débito
- CodAlta            71      1      AN                  "E" o " "       Código de alta de Identificador. Constante “E” si es el primer débito informado, si no espacios.
- Estado             72      2      AN                  "  "            Estado del registro – Constante 2 espacios
- Reservado2         74     26      AN                                  Constante 26 espacios
- MarcaFin          100      1      AN                  "*"             Marca de fin de registro – Constante “*”
=========================================================================================================================
14540738000700728   00000001201911010005000000000130000000000012999300                             *
14545454545454545   00000001202107170005000000000234500000000027058675E                            *
14545454545454545   00000001202107170005000000000234500000000027058675                             *
=========================================================================================================================

Registro final
==============
Campo               Inicio  Long    Tipo    Formato     Valor           Descripción
- TipoRegistro        1      1      AN                  "9"             Código del tipo de Registro – Constante “9”
- NombreArchivo       2      8      AN                  “DEBLIQC ”      Nombre del archivo - Constante “DEBLIQC” y un blanco
- Establecimiento    10     10      AN                                  Número de Establecimiento que generó el archivo
- EntidadDestino     20     10      AN                  “900000    ”    Entidad de destino – Constante “900000” y cuatro blancos
- FechaGeneracion    30      8      N       AAAAMMDD                    Fecha de generación del archivo
- HoraGeneracion     38      4      N       HHMM                        Hora de generación del archivo
- CantRegistros      42      7      N       n7                          Cantidad total registros detalle (7 dígitos enteros con ceros a izquierda)
- SumaImportes       49     15      N       n13d2                       Sumatoria Importes registros detalle (13 dígitos enteros y 2 decimales con ceros a izquierda)
- Reservado          64     36      AN                                  Constante 36 espacios
- MarcaFin          100      1      AN                  "*"             Marca de fin de registro – Constante “*”
=========================================================================================================================
9DEBLIQC 0037311321900000    2019111110540005701000000446523000                                    *
9DEBLIQC 0037356830900000    2021071900570000001000000000234500                                    *
=========================================================================================================================
*/

class orden_debito_prisma_visa extends orden_debito {

    public function __construct($lista_debitos, $nombre_forpag, $datos_tarjeta) {
        parent::__construct($lista_debitos, $nombre_forpag, $datos_tarjeta);
        $this->nombre_archivo_comun = "DEBLIQ{$this->DoC}";
        $this->fecha = date('Ymd', $this->time);
        $this->hora = date('Hi', $this->time);
    }

    private function crear_cabecera() {
        return
            "0" .                                                       // TipoRegistro        1      1      AN                  "0"             Tipo de registro
            "{$this->nombre_archivo_comun} " .                          // Constante1          2      8      AN                  "DEBLIQC "      Constante
            str_pad($this->establecimiento, 10, "0", STR_PAD_LEFT) .    // Establecimiento    10     10      AN                                  Número del Establecimiento que generó el archivo
            str_pad("900000", 10) .                                     // Constante2         20     10      AN                  “900000    ”    Constante
            $this->fecha .                                              // FechaGeneracion    30      8      N       AAAAMMDD                    Fecha de generación del archivo
            $this->hora .                                               // HoraGeneración     38      4      N       HHMM                        Hora de generación del archivo
            "0" .                                                       // TipoArchivo        42      1      A                   "0"             Tipo de Archivo. Débitos a liquidar (“0”= Altas)
            "  " .                                                      // EstadoArchivo      43      2      AN                  "  "            Estado archivo - Constante 2 espacios
            str_pad("", 55) .                                           // Reservado          45     55      AN                                  Constante 55 espacios
            "*" .                                                       // MarcaFin          100      1      AN                  "*"             Marca de fin de registro – Constante “*”
            PHP_EOL;
    }

    private function crear_detalle($debito, $NroSecuencia) {
        return
            "1" .                                                                               // TipoRegistro        1      1      AN                  "1"             Tipo de Registro (Fijo "1")
            str_pad($debito["sc_debito_tarjeta"], 16) .                                         // NroTarjeta          2     16      AN                                  Número de Tarjeta
            "   " .                                                                             // Reservado1         18      3      AN                  "   "           Constante 3 espacios
            str_pad($NroSecuencia, 8, "0", STR_PAD_LEFT) .                                      // Referencia         21      8      N                                   Referencia o número de comprobante o Nro. Secuencial ascendente único por archivo
            $debito["c_alta"] .                                                                 // FechaOrigen        29      8      N       AAAAMMDD                    Fecha de origen o vencimiento del débito
            "0005" .                                                                            // CodTransacción     37      4      AN                  "0005"          Código de Transacción – Constante 0005
            str_pad(number_format($debito["c_monto"], 2, "", ""), 15, "0", STR_PAD_LEFT) .      // Importe            41     15      N       n13d2                       Importe (13 dígitos enteros y 2 decimales con ceros a izquierda)
            str_pad($debito["s_documento"], 15, "0", STR_PAD_LEFT) .                            // Identificador      56     15      AN                                  Identificador del débito
            ($debito["primer_debito"] == "1" ? "E" : " ") .                                     // CodAlta            71      1      AN                  "E" o " "       Código de alta de Identificador. Constante “E” si es el primer débito informado, si no espacios.
            "  " .                                                                              // Estado             72      2      AN                  "  "            Estado del registro – Constante 2 espacios
            str_pad("", 26) .                                                                   // Reservado2         74     26      AN                                  Constante 26 espacios
            "*" .                                                                               // MarcaFin          100      1      AN                  "*"             Marca de fin de registro – Constante “*”
            PHP_EOL;
    }

    private function crear_final() {
        return
            "9" .                                                                               // TipoRegistro        1      1      AN                  "9"             Código del tipo de Registro – Constante “9”
            "{$this->nombre_archivo_comun} " .                                                  // NombreArchivo       2      8      AN                  “DEBLIQC ”      Nombre del archivo - Constante “DEBLIQC” y un blanco
            str_pad($this->establecimiento, 10, "0", STR_PAD_LEFT) .                            // Establecimiento    10     10      AN                                  Número de Establecimiento que generó el archivo
            str_pad("900000", 10) .                                                             // EntidadDestino     20     10      AN                  “900000    ”    Entidad de destino – Constante “900000” y cuatro blancos
            $this->fecha .                                                                      // FechaGeneracion    30      8      N       AAAAMMDD                    Fecha de generación del archivo
            $this->hora .                                                                       // HoraGeneracion     38      4      N       HHMM                        Hora de generación del archivo
            str_pad($this->cant_registros, 7, "0", STR_PAD_LEFT) .                              // CantRegistros      42      7      N       n7                          Cantidad total registros detalle (7 dígitos enteros con ceros a izquierda)
            str_pad(number_format($this->suma_importes, 2, "", ""), 15, "0", STR_PAD_LEFT) .    // SumaImportes       49     15      N       n13d2                       Sumatoria Importes registros detalle (13 dígitos enteros y 2 decimales con ceros a izquierda)
            str_pad("", 36) .                                                                   // Reservado          64     36      AN                                  Constante 36 espacios
            "*" .                                                                               // MarcaFin          100      1      AN                  "*"             Marca de fin de registro – Constante “*”
            PHP_EOL;
    }

    public function convertir() {
        // Crear registro cabecera
        // Por cada $this->lista_debitos
        //      Acumular datos necesarios para registro final
        //      Crear un registro detalle
        // Crear registro final
        $this->lista_registros[] = $this->crear_cabecera();
        $this->cant_registros = 0;
        $this->suma_importes = 0;
        foreach ($this->lista_debitos as $debito) {
            $this->suma_importes += $debito["c_monto"];    //acumular datos para registro final
            $this->lista_registros[] = $this->crear_detalle($debito, ++$this->cant_registros);
        }
        $this->lista_registros[] = $this->crear_final();
    }

}