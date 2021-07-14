<?php include 'assets/php/header.php'; ?>
<?php $fullcalendar = get_fullcalendar(); ?>

<style>
    .fc-scroller {
        //overflow-y: hidden !important;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: ['<?php echo $fullcalendar['initialView']; ?>'],
            headerToolbar: {
                <?php echo $fullcalendar['headerToolbar']; ?>
            },
            themeSystem: 'bootstrap',
            events: [<?php echo get_clases(); ?>],
            locale: 'es',
            scrollTime: "<?php echo $fullcalendar['scrollTime']; ?>",
            firstDay: "<?php echo $fullcalendar['firstDay']; ?>",
            hiddenDays: [0],
            height: $(window).height() - 200,
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
                //                alert('Event: ' + info.event.title);
                //                info.el.style.borderColor = 'red';
            }
        });
        calendar.render();
        calendar.setOption("minTime", "10:00:00");
        calendar.setOption("maxTime", "20:00:00");
    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Clases Disponibles</h1>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
        <div id='calendar'></div>
    </div>
</div>



<?php include 'assets/php/footer.php'; ?>
