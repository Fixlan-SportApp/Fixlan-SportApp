<?php $titulo = "Clases"; ?>
<?php include 'assets/php/header.php'; ?>
<?php $fullcalendar = get_fullcalendar(); ?>

<style>
    .fc-scroller {
        overflow-y: hidden !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: ['<?php echo $fullcalendar['initialView']; ?>'],
            headerToolbar: { <?php echo $fullcalendar['headerToolbar']; ?> },
            themeSystem: 'bootstrap',
            events: [<?php echo get_clases(); ?>],
            locale: 'es',
            height: "auto",
            scrollTime: "<?php echo $fullcalendar['scrollTime']; ?>",
            firstDay: "<?php echo $fullcalendar['firstDay']; ?>",
            //hiddenDays: [0],
            businessHours: { <?php echo $fullcalendar['businessHours']; ?> },
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>



<?php include 'assets/php/footer.php'; ?>