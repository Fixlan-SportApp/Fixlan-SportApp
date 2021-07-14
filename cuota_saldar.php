<?php $titulo = "Saldar Deuda de Actividad"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $actividad = $_GET['id'];
    }


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $c_monto = str_replace(",", ".", $_POST['c_monto']);
        if(insert_comprobante($_POST['c_fecha'], $_POST['cuotas'], "", $_POST['c_forpag'], $_POST['c_caja'], $c_monto)){
            $cuotas = explode(',', $_POST['cuotas']);
            $comprobante = get_nro_comprobante($_POST['c_fecha'], $_POST['cuotas'], "", get_id_usuario());
            foreach ($cuotas as $cuota){
                if(imputar_comprobante_cuota($cuota, $comprobante)){
                    
                }else{
                    insertar_error('La cuota: ' . $cuota . ' no se pudo imputar al comprobante: ' . $comprobante);
                }
            }
            header('location: actividades_info.php?id='.$_POST['actividad']);
        }else{
            insertar_error('No se pudo insertar el comprobante');
            $actividad = $_POST['actividad'];
        }
    }
?>

<h5><?php echo $titulo; ?></h5><hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="card shadow mb-3">
                    <div class="card-header py-2">
                        <p class="text-primary m-0 font-weight-bold">Detalle</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td class="text-center" colspan="2">Concepto</td>
                                <td class="text-center">Monto</td>
                            </tr>
                            <?php
                                $r = mysqli_query($conexion, "SELECT a.c_periodo, c.sc_nombre, d.c_nombre, a.c_monto, a.id FROM [".get_db()."].[dbo].[cuota] AS a INNER JOIN [".get_db()."].[dbo].[socio_categoria] AS b ON a.c_sc = b.id INNER JOIN [".get_db()."].[dbo].[subcategoria] AS c ON b.sc_subcategoria = c.id INNER JOIN [".get_db()."].[dbo].[categoria] AS d ON c.sc_categoria = d.id WHERE a.c_sc = '".$actividad."' AND a.c_comprobante = 0 AND a.c_anulada = 'NO' ORDER BY a.c_periodo DESC");
                                $total = 0;
                                $cuotas = "";
                                while($f = mysqli_fetch_array($r)){
                                    echo '<tr><td class="text-left" colspan="2">Periodo: '.$f[0]->format('m/Y').' | '.$f[2].' - '.$f[1].'</td><td class="text-right"> $ '.moneda($f[3]).'</td></tr>';
                                    if($total == 0){
                                        $cuotas .= $f[4];
                                    }else{
                                        $cuotas .= ','.$f[4];
                                    }
                                    $total = $total + $f[3];
                                }
                            ?>
                            
                            <tr>
                                <td class="text-left" colspan="2"><strong>Total</strong></td>
                                <td class="text-right"><strong>$ <?php echo moneda($total);?></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <form method="post" action="">
                    <input hidden name="actividad" value="<?php echo $actividad; ?>">
                    <input hidden name="cuotas" value="<?php echo $cuotas; ?>">
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
                                <input class="form-control form-control-sm" id="c_monto" name="c_monto" value="<?php echo $total;?>">
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-inline">
                                    <input type="checkbox" id="comprobante_email">
                                    <label>&nbsp;&nbsp;Enviar comprobante por correo electr&oacute;nico</label>
                                </div>
                            </div>
                        </div>
                    </div>
-->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <button class="btn btn-sm btn-success" type="submit">Cobrar</button>
                                <a class="btn btn-sm btn-secondary" href="actividades_info.php?id=<?php echo $actividad; ?>">Volver</a>
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
