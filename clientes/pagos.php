<?php include 'assets/php/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mis Pagos</h1>
</div>


<table class="table" id="comprobantes_socio" style="font-size:14px;">
    <thead>
        <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Concepto</th>
            <th scope="col">Monto</th>
            <th scope="col">Estado de Pago</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $r_t = mysqli_query($conexion, "SELECT a.id, a.pago_fecha, a.pago_titulo, a.pago_monto, a.pago_status FROM ".get_db().".pago AS a WHERE a.pago_socio = '".get_id_usuario()."'");
            while($f_t = mysqli_fetch_array($r_t)){
                echo '<tr>';
                    echo '<td>'.$f_t[1].'</td>';
                    echo '<td>'.$f_t[1].'</td>';
                    echo '<td>'.substr($f_t[2], 0, 50).'...</td>';
                    echo '<td>$ '.number_format($f_t[3], 2, '.', ',').'</td>';
                    echo '<td>'.$f_t[4].'</td>';
                echo '</tr>';
            }
        ?>
    </tbody>
</table>




<?php include 'assets/php/footer.php'; ?>
