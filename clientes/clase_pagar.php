<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
        $clase = get_info_clase($id);
        $socio = get_info_socio(get_id_usuario());
        $detalle = $socio[1] . ', ' . $socio[2] . '. DNI: ' . $socio[3];
    }
?>

<?php
    require_once 'assets/vendor/autoload.php';
   
    $access_token = get_access_token_mp();
    $dominio_retorno = get_dominio_retorno_mp();

    $referencia = 'Soci@: ' . $detalle . '. CLASE: ' . $clase[8] . '. Dia ' . $clase[9];

    MercadoPago\SDK::setAccessToken($access_token);

    $preference = new MercadoPago\Preference();

    $payer = new MercadoPago\Payer();
    $payer->email = $socio[7];

    $item = new MercadoPago\Item();
    $item->title = $referencia;
    $item->quantity = 1;
    $item->currency_id = "ARS";
    $item->unit_price = $clase[4];

    $preference->items = array($item);
    $preference->payer = $payer;

    $preference->back_urls = array(
    "success" => $dominio_retorno."/pago_exitoso.php?t=CLASE&identificador=".$clase[0]."&monto=".$clase[4],
    "failure" => $dominio_retorno."/pago_rechazado.php?t=CLASE&identificador=".$clase[0]."&monto=".$clase[4],
    "pending" => $dominio_retorno."/pago_pendiente.php?t=CLASE&identificador=".$clase[0]."&monto=".$clase[4]
    );
    $preference->auto_return = "all";

    $preference->external_reference = $referencia;

    $preference->save();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Clase</h1>
</div>

<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                Detalle de Pago
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <td><?php echo $clase[8]; ?></td>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <td><?php echo $clase[9]; ?></td>
                        </tr>
                        <tr>
                            <th>Horario</th>
                            <td><?php echo $clase[10] . ' - ' . $clase[11]; ?></td>
                        </tr>
                        <tr>
                            <th>Monto</th>
                            <td><?php echo "$ " . moneda($clase[4]); ?></td>
                        </tr>
                    </thead>
                </table>
                <div class="float-right">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="terminos">
                    <label class="form-check-label" for="defaultCheck1">
                        Acepto los <a href="#">T&eacute;rminos y Condiciones</a>
                    </label>
                </div>
                </div>
                <div style="display:none" id="btn_pagar">
                    <a class="btn btn-primary" href="<?php echo $preference->init_point; ?>">Pagar</a>
                    <!-- <script src="https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js" data-preference-id="<?php echo $preference->id; ?>"></script> -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('#terminos').click(function(){
            if($('#terminos').prop('checked')){
                $('#btn_pagar').show();
            }else{
                $('#btn_pagar').hide();
            }
        });
    });
</script>


<?php include 'assets/php/footer.php'; ?>
