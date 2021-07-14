<?php $titulo = "Integrantes del Grupo Familiar"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    $cabecera = $_GET['id'];
    $socio = get_integrante_grupofliar($cabecera);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(agregar_integrante_grupofliar($_POST['gf_cabecera'], $_POST['gf_integrante'])){
            header('location: socio_grupo.php?id='.$_POST['gf_cabecera']);
        }else{
            insertar_error('El integrante ' . $_POST['gf_integrante'] . ', no se pudo agregar al Grupo: ' . $_POST['gf_cabecera']);
        }
    }
?>
<div class="float-right">
    <?php
        if(get_cantidad_grupofliar($cabecera) == 0){
            echo '<a href="gf_default_ai.php?id='.$cabecera.'" class="btn btn-sm btn-success">Agregar este Integrante</a>';
        }
    ?>
    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#grupo_fliar">Agregar Integrante al Grupo Familiar</button>
</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-10">
                <table class="table table-sm table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Apellido y Nombre</th>
                        <th>Documento</th>
                        <th>Categor&iacute;a</th>
                        <th>Subcategor&iacute;a</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                            echo get_listado_grupofliar($cabecera);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="grupo_fliar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Periodo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="" autocomplete="off">
                <input hidden name="gf_cabecera" value="<?php echo $cabecera; ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Busque por Apellido o Documento</label><br>
                                <select id="select_socio" name="gf_integrante" class="js-example-basic-single">
                                    <?php echo get_select_socios_grupofliares(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar Integrante</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#select_socio').select2({
            theme: 'bootstrap4',
        });
    });

</script>

<?php include 'assets/php/footer.php'; ?>
