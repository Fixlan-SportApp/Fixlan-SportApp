<script>
    $(document).ready(function() {
        $('#ejemplo').DataTable({
            "order": [
                [0, "asc"],
                [1, "asc"]
            ],
            stateSave: true
        });
    });
</script>


<!-- $('#tabla_reservas').DataTable({
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
        }); -->