<?php $titulo = "Informaci&oacute;n de Actividad de Socio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $actividad = get_info_actividad($_GET['id']);
        $datos = get_info_detallada_actividad($_GET['id']);
    }
?>

<style>
    td:hover {
        cursor: pointer;
    }

    .encabezado {
        min-width: 70px;
    }

</style>
<div class="float-right">
    <a class="btn btn-sm btn-primary" href="socio_info.php?id=<?php echo $actividad['sc_socio']; ?>">Volver a Socio</a>
    <a class="btn btn-sm btn-secondary" href="actividades_socio.php?id=<?php echo $actividad['sc_socio']; ?>">Volver a Actividades</a>
</div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-header py-2">
        <div class="float-right">
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="cuota_generar.php?id=<?php echo $actividad['id']; ?>">Generar Cuota</a>
                    <a class="dropdown-item" href="cuota_informe.php?id=<?php echo $actividad['id']; ?>">Informe de Actividad</a>
                    <a class="dropdown-item" href="actividades_editar.php?id=<?php echo $actividad['id']; ?>">Editar Actividad</a>
                </div>
            </div>
        </div>
        <p class="text-primary m-0 font-weight-bold">Datos de la Actividad</p>
    </div>
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                <div class="form-group">
                    <label>Nro de Socio</label>
                    <input readonly id="nro" class="form-control form-control-sm" value="<?php echo $datos[1]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-group">
                    <label>Apellido y Nombre</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[2]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Categor&iacute;a</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[4]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Subcategor&iacute;a</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[3]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Forma de Pago</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[5]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Frecuencia de Pago</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[6]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Beca</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[7]; ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Convenio</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo $datos[8]; ?>">
                </div>
            </div>
            <?php
                if($datos[10] == "SI"){
                    $nro = get_cabecera_grupofliar($_GET['id']);
                    if($nro == 0){
                        $cabecera_grupofliar = $actividad['id'];
                    }else{
                        $cabecera_grupofliar = $nro;
                    }
                    
            ?>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Integrantes del Grupo</label>
                    <input readonly class="form-control form-control-sm" value="<?php echo get_cantidad_grupofliar($cabecera_grupofliar); ?>">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <a class="btn btn-sm btn-block btn-primary" href="socio_grupo.php?id=<?php echo $cabecera_grupofliar; ?>">Ver Grupo Familiar</a>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>

<div class="card shadow mb-3">
    <div class="card-header py-2">
        <div class="float-right">
            <div class="dropdown">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="cuota_generar.php?id=<?php echo $actividad['id']; ?>">Generar Cuota</a>
                    <a class="dropdown-item" href="cuota_saldar.php?id=<?php echo $actividad['id']; ?>">Saldar Deuda de Actividad</a>
                    <a class="dropdown-item" href="cuota_anuladas.php?id=<?php echo $actividad['id']; ?>">Ver Cuotas Anuladas</a>
                </div>
            </div>
        </div>
        <p class="text-primary m-0 font-weight-bold">Vista detallada de Cuotas <small>&Uacute;ltimas 5 cuotas</small></p>
    </div>
    <div class="card-body">
        <table id="detalladas" class="table-responsive-lg table-bordered table-sm" width="100%" style="font-size: 14px;">
            <thead>
                <th>Periodo</th>
                <th>Categor&iacute;a</th>
                <th>Subcategor&iacute;a</th>
                <th>Forma de Pago</th>
                <th>Frecuencia de Pago</th>
                <th>Beca</th>
                <th>Convenio</th>
                <th>Monto</th>
                <th>Estado</th>
            </thead>
            <tbody>
                <?php echo get_ultimas_5_cuotas_socio($actividad['sc_socio'], $actividad['id']); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Vista Gr&aacute;fica de Cuotas <small>&Uacute;ltimos 5 a&ntilde;os</small></p>
    </div>
    <div class="card-body">
        <div class="table table-sm table-responsive">
            <table class="table-responsive-lg table-bordered table-sm" style="font-size:13px; color:black; text-align: center;" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="width: 20px;">A&ntilde;o</th>
                        <th class="encabezado">Enero</th>
                        <th class="encabezado">Febrero</th>
                        <th class="encabezado">Marzo</th>
                        <th class="encabezado">Abril</th>
                        <th class="encabezado">Mayo</th>
                        <th class="encabezado">Junio</th>
                        <th class="encabezado">Julio</th>
                        <th class="encabezado">Agosto</th>
                        <th class="encabezado">Septiembre</th>
                        <th class="encabezado">Octubre</th>
                        <th class="encabezado">Noviembre</th>
                        <th class="encabezado">Diciembre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $ano_inicial = date("Y", strtotime(date("Y", strtotime(date('Y'))) . " - 5 year"));
                        
                        for ($ano = $ano_inicial; $ano <= date('Y'); $ano++) {
                            echo "<tr>";
                                echo "<td><strong>".$ano."</strong></td>";
                                $control_mes = 0;
                                for ($mes = 1; $mes <= 12; $mes++) {
                                    $sql_control = "SELECT COUNT(a.id) FROM " . get_db() . ".cuota AS a WHERE YEAR(a.c_periodo) = '".$ano."' AND MONTH(a.c_periodo) = '".$mes."' AND a.c_sc = '".$actividad['id']."' AND a.c_anulada = 'NO'";
                                    $control_cuota = mysqli_fetch_array(mysqli_query($conexion, $sql_control));
                                    if($control_cuota[0] == 1){
                                        
                                        $sql_cuota = "SELECT a.c_comprobante, a.c_frepag, a.id FROM " . get_db() . ".cuota AS a WHERE YEAR(a.c_periodo) = '".$ano."' AND MONTH(a.c_periodo) = '".$mes."' AND a.c_sc = '".$actividad['id']."' AND a.c_anulada = 'NO'";

                                        $cuota = mysqli_fetch_array(mysqli_query($conexion, $sql_cuota));

                                        $colspan = get_colspan_cuota_socio($cuota[1]);

                                        if($cuota[0] == 0){
                                            echo "<td colspan='".$colspan."' cuotaid='".$cuota[2]."' mytitle='".$mes."/".$ano."' class='bg-danger cuota'>IMPAGA</td>";
                                        }else{
                                            echo "<td colspan='".$colspan."' cuotaid='".$cuota[2]."' mytitle='".$mes."/".$ano."' class='bg-success cuota'>PAGA</td>";
                                        }
                                        
                                        if($colspan == 2){
                                            $mes = $mes + 1;
                                        }

                                        if($colspan == 3){
                                            $mes = $mes + 2;
                                        }

                                        if($colspan == 6){
                                            $mes = $mes + 5;
                                        }

                                        if($colspan == 12){
                                            $mes = $mes + 11;
                                        }

                                    }else{
                                        echo "<td></td>";
                                    }
                                }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    //

    $(document).ready(function() {
        $('td').click(function() {
            var id_cuota = $(this).attr('cuotaid');
            if ($.isNumeric(id_cuota)) {
                $.confirm({
                    theme: 'modern',
                    title: 'Información de Cuota',
                    content: '¿Desea visualizar la cuota del mes ' + $(this).attr('mytitle') + '?',
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        Si: {
                            text: 'Si',
                            btnClass: 'btn-blue',
                            action: function() {
                                $(location).attr('href', 'cuota_info.php?id=' + id_cuota);
                            }
                        },
                        No: {
                            text: 'No',
                        }
                    }
                });
            }

        });
    });

    $(document).ready(function() {
        interaccion_tabla();

        $(function() {
            $.contextMenu({
                selector: '.cuota',
                callback: function(key, options) {
                    var m = "clicked: " + key;
                    //window.console && console.log(m) || alert(m);
                    if (key == 'copy') {
                        cobrar_cuota($(this).attr('mytitle'), $(this).attr('cuotaid'));
                    }

                    if (key == 'delete') {
                        anular_cuota($(this).attr('mytitle'), $(this).attr('cuotaid'));
                    }
                    
                    if (key == 'print') {
                        alert("Impresion");
                        //anular_cuota($(this).attr('mytitle'), $(this).attr('cuotaid'));
                    }
                },
                items: {
                    copy: {
                        name: "   Cobrar",
                        icon: "fas fa-money-bill-wave",
                        disabled: function(key, opt) {
                            if ($(this).text() === 'PAGA') {
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    "delete": {
                        name: "   Anular",
                        icon: "fas fa-trash-alt",
                        disabled: function(key, opt) {
                            if ($(this).text() === 'PAGA') {
                                return true;
                            }else{
                                return false;
                            }
                        }
                    },
                    "print": {
                        name: "   Imprimir",
                        icon: "fas fa-print",
                        disabled: function(key, opt) {
                            if ($(this).text() === 'PAGA') {
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                }
            });

            $('.context-menu-one').on('click', function(e) {
                console.log('clicked', this);
            })
        });
    });

    function anular_cuota(periodo, id_cuota) {
        $.confirm({
            theme: 'modern',
            title: 'Anular Cuota',
            content: '¿Desea anular la cuota del mes ' + periodo + '?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                Si: {
                    text: 'Si',
                    btnClass: 'btn-red',
                    action: function() {
                        $(location).attr('href', 'cuota_anular.php?id=' + id_cuota);
                    }
                },
                No: {
                    text: 'No',
                }
            }
        });
    }

    function cobrar_cuota(periodo, id_cuota) {
        $.confirm({
            theme: 'modern',
            title: 'Cobrar Cuota',
            content: '¿Desea cobrar la cuota del mes ' + periodo + '?',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                Si: {
                    text: 'Si',
                    btnClass: 'btn-blue',
                    action: function() {
                        $(location).attr('href', 'cuota_cobrar.php?id=' + id_cuota);
                    }
                },
                No: {
                    text: 'No',
                }
            }
        });
    }

    function interaccion_tabla() {
        $('#detalladas tr td').hover(function() {
            $(this).parent().addClass('table-success');
        }, function() {
            $(this).parent().removeClass('table-success');
        });

        $('#detalladas td').click(function() {
            var periodo = $(this).closest('tr').children('td:first').text();
            var id_cuota = $(this).closest('tr').children('td:first').attr('mytitle');
            $.confirm({
                theme: 'modern',
                title: 'Información de Cuota',
                content: '¿Desea visualizar la cuota del mes ' + periodo + '?',
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    Si: {
                        text: 'Si',
                        btnClass: 'btn-blue',
                        action: function() {
                            $(location).attr('href', 'cuota_info.php?id=' + id_cuota);
                        }
                    },
                    No: {
                        text: 'No',
                    }
                }
            });
        });
    }

</script>

<?php include 'assets/php/footer.php'; ?>
