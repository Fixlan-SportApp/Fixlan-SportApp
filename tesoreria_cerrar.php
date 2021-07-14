<?php $titulo = "Cerrar Pago - Tesoreria"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $socio = get_info_socio($_GET['id']);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_comprobante($_POST['c_fecha'], '', '', $_POST['c_forpag'], $_POST['c_caja'], $_POST['c_monto'])){
            $c_usuario = get_id_usuario();
            $comprobante = get_nro_comprobante($_POST['c_fecha'], '', '', $c_usuario);

            $sql = "SELECT a.t_id, a.t_tipo FROM ".get_db().".aux_tesoreria AS a WHERE a.t_usuario = " . $c_usuario . " ORDER BY a.t_tipo, a.t_id ASC";
            $r_comp = mysqli_query($conexion, $sql);
            $arr_cuotas = "";
            $arr_clases = "";
            while($f_comp = mysqli_fetch_array($r_comp)){
                if($f_comp[1] == "CLASE"){
                    if (imputar_clase_paga($f_comp[0], $comprobante)) {
                        if($arr_clases == ""){
                            $arr_clases = $f_comp[0];
                        }else{
                            $arr_clases .= ", " . $f_comp[0];
                        }
                    }
                }
                if($f_comp[1] == "CUOTA"){
                    if(imputar_comprobante_cuota($f_comp[0], $comprobante)){
                        if($arr_cuotas == ""){
                            $arr_cuotas = $f_comp[0];
                        }else{
                            $arr_cuotas .= ", " . $f_comp[0];
                        }
                    }
                }
            }

            if(mysqli_query($conexion, "UPDATE ".get_db().".comprobante SET c_cuota = '".$arr_cuotas."', c_clase = '".$arr_clases."' WHERE id = '".$comprobante."'")){
                if(mysqli_query($conexion, "DELETE FROM ".get_db().".aux_tesoreria WHERE t_usuario = " . $c_usuario)){
                    header('location: tesoreria_busqueda.php');
                }else{
                    consola("No se pudo eliminar el listado aux_tesoreria");
                }
            }else{
                consola("No se pudo actualizar los array de comprobantes");
            }
        }
    }
?>

<div class="float-right"><a class="btn btn-sm btn-secondary" href="tesoreria_cancelar.php">Cancelar</a></div>
<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                <div class="card shadow mb-3">
                    <div class="card-header py-2">
                        <p class="text-primary m-0 font-weight-bold">Detalle de Cuota</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td class="text-center" colspan="2">Concepto</td>
                                <td class="text-center">Tipo</td>
                                <td class="text-center">Monto</td>
                            </tr>
                            <?php
                                $total = 0;
                                $r_detalle = mysqli_query($conexion, "SELECT a.id, a.t_concepto, a.t_tipo, a.t_monto, a.t_socio FROM ".get_db().".aux_tesoreria AS a WHERE a.t_usuario = '".get_id_usuario()."'");
                                while($f_detalle = mysqli_fetch_array($r_detalle)){
                                    echo "<tr>";
                                    echo "<td colspan='2'>".$f_detalle[1]."</td>";
                                    echo "<td class='text-center'>".$f_detalle[2]."</td>";
                                    echo "<td class='text-right'>$ ".moneda($f_detalle[3])."</td>";
                                    $total = $total + $f_detalle[3];
                                    echo "</tr>";
                                }
                            ?>
                            <tr>
                                <td class="text-left" colspan="3"><strong>Total</strong></td>
                                <td class="text-right"><strong>$ <?php echo moneda($total); ?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                <form method="post" action="">
                    <input hidden name="c_cuota" value="<?php echo $_GET['id']; ?>">
                    <input hidden name="actividad" value="<?php echo $cuota[18]; ?>">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Fecha de Pago</label>
                                <input class="form-control form-control-sm" type="date" name="c_fecha" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Caja</label>
                                <select name="c_caja" class="form-control form-control-sm">
                                    <?php echo get_select_cajas(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                <select name="c_forpag" class="form-control form-control-sm">
                                    <?php echo get_select_forpag(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="float-right">
                                    <div class="form-inline">
                                        <input type="checkbox" id="modificar_monto">
                                        <label>&nbsp;&nbsp;Modificar Monto</label>
                                    </div>
                                </div>
                                <label>Monto a abonar</label>
                                <input class="form-control form-control-sm text-right" id="c_monto" name="c_monto" value="<?php echo $total;?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <button class="btn btn-sm btn-success" type="submit">Cobrar</button>
                                <a class="btn btn-sm btn-secondary" href="tesoreria_cobranza.php?id=<?php echo $socio[0]; ?>">Volver</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#c_monto').attr('readonly', true);

        $('#modificar_monto').change(function() {
            if ($('#modificar_monto').is(':checked')) {
                $('#c_monto').attr('readonly', false);
            } else {
                $('#c_monto').attr('readonly', true);
            }
        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>
