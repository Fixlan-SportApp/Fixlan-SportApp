<?php $titulo = "Clase"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $clase = get_info_clase($_GET['id']);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(insert_reserva_clase($_POST['sc_socio'], $_POST['sc_clase'], "NO")){
            header('location: clases_info.php?id='.$_POST['sc_clase']);
        }else{
            echo error('No se pudo generar la reserva');
            $clase = get_info_clase($_POST['sc_clase']);
        }
    } 
?>
<div class="float-right">
    <a href="disciplina_info.php?id=<?php echo $clase[6]; ?>" class="btn btn-sm btn-secondary">Volver a Disciplina</a>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
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
                <div class="col-xs-12 col-sm-12 col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <a href="clases_aumentar_cupo.php?id=<?php echo $clase[0]; ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></a><a href="clases_decrementar_cupo.php?id=<?php echo $clase[0]; ?>" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if($clase[7] < $clase[2] ) { ?>

<button type="button" class="btn btn-sm btn-primary m-4" data-toggle="modal" data-target="#profesor">Generar Reserva</button>

<?php } ?>

<div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Reservas</p>
    </div>
    <div class="card-body">
        <table id="tabla_reservas" class="table table-sm table-bordered table-striped">
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Apellido y Nombre</th>
                    <th>Documento</th>
                    <th>Celular</th>
                    <th>Reserva</th>
                    <th>Deuda Acumulada</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php echo get_listado_reservas_clase($clase[0]); ?>
            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="profesor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <input hidden name="sc_clase" value="<?php echo $clase[0]; ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Seleccione a la persona deseada</label>
                                <select required class="js-example-basic-single" name="sc_socio">
                                    <option value="">Ingrese el Apellido / Nombre / Documento de la persona</option>
                                    <?php echo get_select_socios(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
<!--
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>¿Forma parte de un Abono?</label>
                                <select required class="form-control form-control-sm" name="sc_abono">
                                    <option value="SI">SI</option>
                                    <option selected value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
-->
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btn_reserva" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
