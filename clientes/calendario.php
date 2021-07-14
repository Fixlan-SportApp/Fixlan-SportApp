<?php include 'assets/php/header.php'; ?>
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
            events: [ <?php echo get_clases_socios(); ?> ],
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
                                $(location).attr('href', 'clase_info.php?id=' + info.event.id);
                            }
                        },
                        No: function() {}
                    }
                });
            }
        });
        calendar.render();
        calendar.setOption('height', $(window).height() - 250);

    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mi Calendario</h1>
    <div class="float-right">
        <a href="actividades.php" class="btn btn-secondary">Volver a Mis Actividades</a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div id='calendar'></div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
