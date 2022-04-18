<?php

require_once 'devolucion_debito.php';

/*
=========================================================================================================================
DEVOLUCION DE TARJETA MASTERCARD
=========================================================================================================================

Registro cabecera
=================
Campo               Inicio  Long    Tipo    Formato     Valor               Descripción
- Sigla               1       2             X(2)        "AC".               Se informa "AC"
- TipoRegistro        3       1             9(1)        "1"                 Se informa "1"
- Identificacion      4       9             X(9)        "DEB-AUT"           Se informa "DEB-AUT".
- NroComercio        13       8             9(8)                            Número de comercio.
- FechaPresentacion  21       6             9(6)        DDMMAA              Fecha en que fueron procesados los débitos informados.
                                                                            Corresponde a la fecha de vencimiento o a la fecha en que fue presentado por el comercio
                                                                            (la que fuese mayor).
- FechaClearing      27       6             9(6)        DDMMAA              Fecha de clearing en la cual los débitos serán liquidados al comercio.
- CantDebitos        33       6             9(6)                            Cantidad de registros detalle
- SignoSumaImportes  39       1             X(1)        "0" signo positivo  Signo de la suma de los importes
                                                        "-" signo negativo
- SumaImportes       40      12             9(10,2)                         Suma de los débitos y créditos aceptados.
                                                                            El monto no incluye punto ni coma decimal.
                                                                            Alineado a derecha, con ceros a la izquierda.
                                                                            Se suman los débitos y se restan los créditos.
- Filler             52     109             X(109)                          Espacios en blanco.

=========================================================================================================================

=========================================================================================================================

Registro detalle
================
Campo               Inicio  Long    Tipo    Formato     Valor                       Descripción
- Sigla               1      2              X(2)        "AC"                        Se informa "AC".
- TipoRegistro        3      1              9(1)        "2" o "3"                   "2" si es registro Detalle
                                                                                    "3" si es cupón crédito
- NroTarjeta          4     16              9(16)                                   Número de tarjeta del socio.
- Filler1            20      7              9(7)        "0000000"                   Se informarán ceros.
- Nroreferencia      27     12              9(12)                                   Número mediante el cual el socio es identificado por el Establecimiento.
- Filler2            39      2              9(2)        "00"                        Se informarán ceros.
- Importe            41     11              9(9,2)                                  Importe del débito o crédito.
                                                                                    El monto no incluye punto ni coma decimal.
                                                                                    Alineado a derecha, con ceros a la izquierda.
- CantCuotas         52      3              9(3)                                    Cantidad de cuotas canceladas. Alineado a derecha, con ceros a izquierda.
- Vencimiento        55      4              9(4)        MMAA                        Mes de vencimiento de la tarjeta del socio.
- CodRechazo         59      2              9(2)                                    Código de rechazo.
- Periodo            61      5              X(5)                                    Período al que corresponde el débito.
                                                                                    Los cupones crédito se identificarán con la palabra CRED.
- Fechapresentacion  66      6              9(6)        DDMMAA                      Fecha en que el Comercio presentó la novedad para ser procesada.
                                                                                    Puede ir con blancos.
- Filler3            72     89              X(89)                                   Se completará con espacios en blanco.
=========================================================================================================================

=========================================================================================================================
*/

const CODIGOS_RECHAZO = [
    "00" => "Indicación de transacción aceptada o tarjeta con cambio de número",
    "01" => "Comercio informado no existe o dado de baja",
    "13" => "Falta importe de Débito",
    "14" => "Importe del débito invalido",
    "15" => "Socio/Solicitud/Referencia, no existe o de baja",
    "17" => "Cuota referencia ya fue ingresada",
    "50" => "Causa de rechazo en boletín",
    "61" => "Socio dado de baja en maestro",
    "62" => "Tarjeta vencida",
    "63" => "Cantidad de cuotas del plan inválida",
    "65" => "Tarjeta no vigente",
    "66" => "Tarjeta inexistente",
    "72" => "Cuota inicial invalida",
    "73" => "Frecuencia de debilitación inválida",
    "75" => "Número de referencia inválido",
    "81" => "Comercio no autorizado a operar en dólares",
    "83" => "Entidad Pagadora inexistente",
    "85" => "Stop Debit",
    "86" => "Autorización inexistente",
    "87" => "Importe supera tope /débito acotado",
    "88" => "Autorización rechazada socio en mora",
    "89" => "Autorización rechazada socio Líder",
    "90" => "IMP. CUPON CREDITO SUPERA SUMA ULT.DEB",
    "91" => "ADH. INEXISTENTE PARA CUPON CREDITO",
    "92" => "SOCIO INTERNACIONAL P/CUPON CREDITO"
];

class devolucion_debito_fiserv extends devolucion_debito {

    private function crear_cabecera($registro) {
        $result["TipoRegistro"] = substr($registro, 2, 1);          // - TipoRegistro        3       1             9(1)        "1"                 Se informa "1"
        $result["Establecimiento"] = substr($registro, 12, 8);      // - NroComercio        13       8             9(8)                            Número de comercio.
        $result["FechaPresentacion"] = substr($registro, 20, 6);    // - FechaPresentacion  21       6             9(6)        DDMMAA              Fecha en que fueron procesados los débitos informados.
        $result["CantDebitos"] = substr($registro, 32, 6);          // - CantDebitos        33       6             9(6)                            Cantidad de registros detalle
        $result["SignoSumaImportes"] = substr($registro, 38, 1);    // - SignoSumaImportes  39       1             X(1)        "0" signo positivo "-" signo negativo
        $result["SumaImportes"] = substr($registro, 39, 12);        // - SumaImportes       40      12             9(10,2)                         Suma de los débitos y créditos aceptados.
        return $result;
    }

    private function crear_detalle($registro) {
        // AC243383300018163350000000000000001429000000020000000123110009/21090821                                        230821                                           
        $result["TipoRegistro"] = substr($registro, 2, 1);          // - TipoRegistro        3      1              9(1)        "2" o "3"                   "2" si es registro Detalle. "3" si es cupón crédito
        $result["NroTarjeta"] = substr($registro, 3, 16);           // - NroTarjeta          4     16              9(16)                                   Número de tarjeta del socio.
        $result["Socio"] = substr($registro, 26, 12);               // - NroReferencia      27     12              9(12)                                   Número mediante el cual el socio es identificado por el Establecimiento.
        $result["Identificador"] = substr($registro, 26, 12);       // - NroReferencia      27     12              9(12)                                   Número mediante el cual el socio es identificado por el Establecimiento.
        $result["Monto"] = substr($registro, 40, 11);               // - Importe            41     11              9(9,2)                                  Importe del débito o crédito.
        $result["CantCuotas"] = substr($registro, 51, 3);           // - CantCuotas         52      3              9(3)                                    Cantidad de cuotas canceladas. Alineado a derecha, con ceros a izquierda.
        $result["Vencimiento"] = substr($registro, 54, 4);          // - Vencimiento        55      4              9(4)        MMAA                        Mes de vencimiento de la tarjeta del socio.
        $result["CodRechazo"] = substr($registro, 58, 2);           // - CodRechazo         59      2              9(2)                                    Código de rechazo.
        $result["DescripcionRechazo"] = CODIGOS_RECHAZO[$result["CodRechazo"]];
        // if ($result["CodRechazo"] === "00" && Tarjeta enviada para el débito != $result["NroTarjeta"]) {
        //     // Reemplazar nro de tarjeta registrado por el indicado en el campo "NroTarjeta"
        //     $this->cambiar_tarjeta(Tarjeta enviada para el débito, $result["NroTarjeta"]);
        // }
        $result["PeriodoMes"] = substr($registro, 60, 2);           // - Periodo            61      5              X(5)                                    Período al que corresponde el débito. Los cupones crédito se identificarán con la palabra CRED.
        $result["PeriodoAno"] = "20" . substr($registro, 63, 2);
        $result["FechaOrigen"] = substr($registro, 65, 6);          // - FechaPresentacion  66      6              9(6)        DDMMAA                      Fecha en que el Comercio presentó la novedad para ser procesada. Puede ir con blancos.

        return $result;
    }

    protected function convertir() {
        $this->lista_devoluciones[] = $this->crear_cabecera($this->lista_registros[0]);
        for ($i = 1; $i < $this->cant_registros_en_archivo; $i++) {
            $detalle = $this->crear_detalle($this->lista_registros[$i]);
            $this->lista_devoluciones[] = $detalle;
            $this->suma_importes += $detalle["Monto"];
        }
    }

    protected function verificar_archivo() {
        if ($this->lista_devoluciones[0]["CantDebitos"] != ($this->cant_registros_en_archivo - 1)) {
            throw new Exception('La cantidad de registros del archivo no coincide con la cantidad informada en el registro de cabecera.');
        }
        if ($this->lista_devoluciones[0]["SumaImportes"] != $this->suma_importes) {
            throw new Exception('La suma de los importes no coincide con la informada en el registro final.');
        }
        return TRUE;
    }

    public function get_lista_devoluciones() {
        $lista = $this->lista_devoluciones;
        array_shift($lista);    // eliminar registro de cabecera
        return $lista;
    }    
}