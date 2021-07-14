<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $clase = get_clase($_GET['id']);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_reserva_clase($_POST['sc_socio'], $_POST['sc_clase'], "NO")){
            header('location: clase_info.php?id='.$_POST['sc_clase']);
        }else{
            echo error('No se pudo generar la reserva');
            $clase = get_clase($_POST['sc_clase']);
        }
    } 
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Clase</h1>
    <div class="float-right">
    <a href="clases.php" class="btn btn-sm btn-secondary">Volver a Clases Disponibles</a>
</div>
</div>


<div class="card shadow">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Informaci&oacute;n de Clase</p>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Actividad</label>
                        <input readonly id="nombre_actividad" class="form-control form-control-sm" value="<?php echo $clase[1];?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label>Fecha</label>
                        <input readonly id="dia_actividad" class="form-control form-control-sm" type="date" value="<?php echo $clase[3];?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label>Inicio</label>
                        <input readonly class="form-control form-control-sm" type="time" value="<?php echo $clase[4];?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label>Fin</label>
                        <input readonly class="form-control form-control-sm" type="time" value="<?php echo $clase[5];?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <div class="form-group">
                        <label>Cupos</label>
                        <input readonly class="form-control form-control-sm" value="<?php echo $clase[2];?>">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if($clase[7] < $clase[2] ) { ?>

<?php if(!check_reserva_socio_clase(get_id_usuario(), $clase[0])){?>
<form action="" method="post">
    <input type="text" hidden name="sc_socio" value="<?php echo get_id_usuario(); ?>">
    <input type="text" hidden name="sc_clase" value="<?php echo $clase[0]; ?>">
    <center><button type="sumbit" class="btn btn-lg btn-primary m-4">Reservar Clase</button></center>
</form>
<?php }else { 
    echo "<div class='mt-4 alert alert-success'><h4>Clase reservada</h4> Si usted quiere cancelar la reserva, recuerde que tiene hasta ".$clase[8]." d&iacute;a para cancelar la reserva</div>";
    $id_sc = get_id_socio_clase(get_id_usuario(), $clase[0]);
    $fec_clase = $clase[3];
    $lim_cancelacion = $clase[8];
    $limite = date('Y-m-d', strtotime( $fec_clase . " -1 days"));
    if($limite >= date('Y-m-d')){
        if(!check_clase_paga_socio(get_id_usuario(), $clase[0])){
            
            echo "<a href='clase_pagar.php?id=".$id_sc."' class='mt-2 btn btn-lg btn-success'>Abonar clase</a>&nbsp;&nbsp;&nbsp;";
            echo "<a class='btn btn-lg btn-danger mt-2' href='eliminar_reserva_clase.php?clase=".$clase[0]."&socio=".get_id_usuario()."'>Eliminar reserva</a>";
        }else{
            echo "<div class='mt-2 alert alert-success'>La clase se encuentra abonada.</div>";
        }
    }else{
        echo "<div class='mt-2 alert alert-danger'>Usted no puede cancelar la reserva. Si desea hacerlo, debe comunicarse con la administraci&oacute;n.</div>";
        echo "<a href='clase_pagar.php?id=".$id_sc."' class='mt-2 btn btn-lg btn-success'>Abonar clase</a>&nbsp;&nbsp;&nbsp;";
    }
?>


<?php } } ?>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $(document).ready(function() {
        var cantidad_alumnos = $("#tabla_reservas tr").length - 1;
        $('#tabla_reservas').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                orientation: 'portrait',
                pageSize: 'A4',
                title: 'Clase: ' + $('#nombre_actividad').val() + ' - Dia: ' + $('#dia_actividad').val(),
                messageBottom: 'Cantidad de alumnos: ' + cantidad_alumnos
            }, {
                extend: "print",
                title: 'Clase: ' + $('#nombre_actividad').val() + ' - Dia: ' + $('#dia_actividad').val(),
                messageBottom: 'Cantidad de alumnos: ' + cantidad_alumnos,
                text: "Imprimir",
                customize: function(win) {

                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape; }',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
            }, 'copy', 'excel'],
            deferRender: true,
            scrollCollapse: true,
            scroller: true
        });
    });
    
</script>

<?php include 'assets/php/footer.php'; ?>
