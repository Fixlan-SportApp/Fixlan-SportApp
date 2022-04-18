<?php $titulo = "Lotes de D&eacute;bito Autom&aacute;tico"; ?>
<?php include 'assets/php/header.php'; ?>

<div class="float-right">
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevo_lote">Nuevo Lote</button>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div id="aviso" class="alert alert-info" role="alert" style="display: none">
    <span id="text_aviso"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="card shadow mb-3">
    <div class="card-body">
        <table id="tabla_lotes" class="table table-sm table-bordered" style="width:100%; font-size: 13px;">
            <thead>
                <tr>
                    <th>Lote</th>
                    <th>Base</th>
                    <th>Empresa débito</th>
                    <th>Tarjeta</th>
                    <th>Usuario</th>
                    <th>Débitos</th>
                    <th>Devolución / Rechazos</th>
                    <th>Cant. Registros</th>
                    <th>Suma importes</th>
                    <th>Fecha alta</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['fp'])) {
        $forpag = get_nombre_forpag($_GET['fp']);
        $tarjeta = get_datos_tarjeta($_GET['t'])["t_nombre"];
        echo "<script> $('#text_aviso').text('No hay cuotas para {$forpag} - {$tarjeta}'); $('#aviso').show(); </script>";
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_FILES['file'])) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $fecha = date('Ymd');
            $hora = date('Hi');
            $carpeta = "{$_POST['empresa']}/{$_POST['nombre_tarjeta']}";
            $nombre_archivo = "{$fecha}-{$hora}-DEVOLUCION-{$_POST['nombre_tarjeta']}.txt";

            try {
                validar($_FILES['file'], "disk/{$_POST['base']}/files/{$carpeta}/{$nombre_archivo}");
                agregar_devolucion($_POST['id_lote'], $nombre_archivo);
?>
                <script> $('#text_aviso').text('Archivo cargado correctamente.'); $('#aviso').show(); </script>
<?php
            }
            catch (Exception $e) {
?>
                <script> $('#text_aviso').text('No se pudo cargar el archivo. <?php echo $e->getMessage()?>'); $('#aviso').show(); </script>
<?php
            }
        }
        else if (generar_lote($_POST['l_forpag'], $_POST['l_tarjeta'])) {
            header("location: lotes_index.php");
        }
        else{
            header("location: lotes_index.php?fp={$_POST['l_forpag']}&t={$_POST['l_tarjeta']}");
        }
    }

    function validar($file, $nombre_archivo) {
        if (!isset($file['error']) || is_array($file['error'])) {
            throw new Exception('Parámetros inválidos.');
        }
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('Ningún archivo enviado.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('Se excedió el tamaño de archivo permitido.');
            default:
                throw new Exception('Error desconocido.');
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if ($finfo->file($file['tmp_name'], FILEINFO_MIME_TYPE) != "text/plain") {
            throw new Exception('Formato de archivo inválido.');
        }
        if (!move_uploaded_file($file['tmp_name'], $nombre_archivo)) {
            throw new Exception('Falló la carga del archivo.');
        }
        return TRUE;
    }
?>

<div class="modal fade" id="nuevo_lote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Lote</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-8">
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                <select id="forpag" name="l_forpag" class="form-control form-control-sm">
                                    <?php echo get_select_forpag_lote(0); ?>
                                </select>
                            </div>
                        </div>
                        <div id="tarjetas" class="col-4">
                            <div class="form-group">
                                <label>Tarjeta</label>
                                <select name="l_tarjeta" class="form-control form-control-sm">
                                    <?php echo get_select_tarjetas_lote(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Generar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var data = [];
        data = <?php echo json_encode(get_lista_lotes()); ?>;
        $('#tabla_lotes').DataTable({
            data: data,
            columns: [
                { data: "id"},
                { data: "base", "visible": false },
                { data: "t_empresa_debito" },
                { data: "t_nombre" },
                { data: "u_usuario" },
                {
                    data: "l_archivo",
                    render: function (data, type, row) {
                        return "<a href='disk/" + row[1] + "/files/" + row[2] + "/" + row[3] + "/" + data + "' target='_blank'>" + data + "</a>";
                    },
                },
                {
                    data: "l_devolucion",
                    render: function (data, type, row) {
                        // $link = "<a href='disk/" + row[1] + "/files/" + row[2] + "/" + row[3] + "/" + data + "' target='_blank'>" + data + "</a>";

                        $link = "<a href='rechazos_index.php?lote=" + row[0] + "'>Ver rechazos</a>";

                        $form = "<form id='form_" + row[0] + "' method='post' action='' enctype='multipart/form-data'>" + 
                                "<input type='file' name='file' id='" + row[0] + "' class='form-control' accept='text/plain'>" + 
                                "<input type='hidden' name='id_lote' id='id_lote_" + row[0] + "' value=''>" +
                                "<input type='hidden' name='base' id='base_" + row[0] + "' value='" + row[1] + "'>" +
                                "<input type='hidden' name='empresa' id='empresa_" + row[0] + "' value='" + row[2] + "'>" +
                                "<input type='hidden' name='nombre_tarjeta' id='nombre_tarjeta_" + row[0] + "' value='" + row[3] + "'>" +
                                "</form>";
                        return data ? $link : $form;
                    }
                },
                { data: "l_cant_registros", className: 'dt-right' },
                { data: "l_suma_importes", className: 'dt-right' },
                { data: "l_alta", className: 'dt-center' },
            ],
            deferRender: true,
            scrollY: 300,
            scrollCollapse: true,
            scroller: true,
            paging: false,
            "order": [[ 9, "desc" ]]
        });

        // if ($('#forpag option:selected').text() == "DEBITO AUTOMATICO TARJETA") {
        if ($('#forpag option:selected').text().startsWith("DEBITO AUTOMATICO TARJETA")) {
            $('#tarjetas').show();
        }
        else{
            $('#tarjetas').hide();
        }
        
        $('#forpag').change(function() {
            //if ($('#forpag option:selected').text() == "DEBITO AUTOMATICO TARJETA") {
            if ($('#forpag option:selected').text().startsWith("DEBITO AUTOMATICO TARJETA")) {
                $('#tarjetas').show();
            }
            else {
                $('#tarjetas').hide();
            }
        });

        $('input[type="file"]').change(function(e) {
            e.preventDefault();
            let id = e.target.id;
            $('#id_lote_' + id).val(id);
            $('#form_' + id).submit();
        });
    });
</script>

<?php include 'assets/php/footer.php'; ?>
