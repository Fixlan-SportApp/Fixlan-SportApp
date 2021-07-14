<?php $titulo = "Clases de Socio"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
    }
?>
<?php $fullcalendar = get_fullcalendar(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: ['<?php echo $fullcalendar['initialView']; ?>'],
            headerToolbar: {
                <?php echo $fullcalendar['headerToolbar']; ?>
            },
            themeSystem: 'bootstrap',
            events: [ <?php echo get_clases_socios($id); ?> ],
            locale: 'es',
            windowResize: true,
            scrollTime: "<?php echo $fullcalendar['scrollTime']; ?>",
            firstDay: "<?php echo $fullcalendar['firstDay']; ?>",
            hiddenDays: [0],
            businessHours: {
                <?php echo $fullcalendar['businessHours']; ?>
            },
            eventClick: function(info) {
                $.confirm({
                    theme: 'modern',
                    title: 'Información',
                    content: 'Evento: ' + info.event.title + '<br> Hora de Inicio: ' + moment(info.event.start).format('LT') + '<br> Hora de Inicio: ' + moment(info.event.end).format('LT') + ' <br>¿Desea visualizar la clase?',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        Si: {
                            text: 'Ok',
                            btnClass: 'btn-green',
                            action: function() {
                                $(location).attr('href', 'clases_info.php?id=' + info.event.id);
                            }
                        },
                        No: function() {}
                    }
                });
                //                alert('Event: ' + info.event.title);
                //                info.el.style.borderColor = 'red';
            }
        });
        calendar.render();

    });
</script>


<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="float-right">
                    
                </div>
                <h5>Listado de Clases Pendientes</h5>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Clase</th>
                            <th>D&iacute;a</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo listado_clases_socio($id); ?>
                    </tbody>
                </table>
            </div>
        </div><hr>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>



<?php include 'assets/php/footer.php'; ?>
