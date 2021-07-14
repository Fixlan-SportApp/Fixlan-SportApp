<?php $titulo = "El Club"; ?>
<?php include 'assets/php/header.php'; ?>

<?php
$club = get_info_club();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['btnlogo'])) {
        $DATA = $_FILES["logo"]["tmp_name"];
        $MIME    = $_FILES["logo"]["type"];
        $NAME  = $_FILES["logo"]["name"];
        $PATH = "clubes/" . get_db();

        move_uploaded_file($DATA, "$PATH/$NAME");

        $image = addslashes(file_get_contents("$PATH/$NAME"));

        $sql = "UPDATE " . get_db() . ".club SET c_logo_name = '" . $NAME . "', c_logo_mime = '" . $MIME . "', c_logo_data = '{$image}' WHERE id = 1";

        if (mysqli_query($conexion, $sql)) {
            header('location: club_index.php');
        }
    }

    if (isset($_POST['btnicono'])) {
        $DATA = $_FILES["icono"]["tmp_name"];
        $MIME    = $_FILES["icono"]["type"];
        $NAME  = $_FILES["icono"]["name"];
        $PATH = "clubes/" . get_db();

        move_uploaded_file($DATA, "$PATH/$NAME");

        $image = addslashes(file_get_contents("$PATH/$NAME"));

        $sql = "UPDATE " . get_db() . ".club SET c_icon_name = '" . $NAME . "', c_icon_mime = '" . $MIME . "', c_icon_data = '{$image}' WHERE id = 1";

        if (mysqli_query($conexion, $sql)) {
            header('location: club_index.php');
        }
    }

    if (isset($_POST['btn_datos'])) {
        $c_nombre = $_POST['c_nombre'];
        $c_telefono = $_POST['c_telefono'];
        $c_celular = $_POST['c_celular'];
        $c_email = $_POST['c_email'];
        $c_domicilio = $_POST['c_domicilio'];
        $c_cuit = $_POST['c_cuit'];
        $c_web = $_POST['c_web'];

        $sql = "UPDATE " . get_db() . ".club SET c_nombre = '" . $c_nombre . "', c_telefono = '" . $c_telefono . "', c_celular = '" . $c_celular . "', c_email = '" . $c_email . "', c_domicilio = '" . $c_domicilio . "', c_cuit = '" . $c_cuit . "', c_web = '" . $c_web . "' WHERE id = 1";

        if (mysqli_query($conexion, $sql)) {
            header('location: club_index.php');
        } else {
            header('location: error.php?id=1');
        }
    }

    if (isset($_POST['btn_redes'])) {
        $c_facebook = $_POST['c_facebook'];
        $c_twitter = $_POST['c_twitter'];
        $c_instagram = $_POST['c_instagram'];
        $c_youtube = $_POST['c_youtube'];

        $sql = "UPDATE " . get_db() . ".club SET c_facebook = '" . $c_facebook . "', c_twitter = '" . $c_twitter . "', c_instagram = '" . $c_instagram . "', c_youtube = '" . $c_youtube . "' WHERE id = 1";
        if (mysqli_query($conexion, $sql)) {
            header('location: club_index.php');
        } else {
            header('location: error.php?id=2');
        }
    }
}
?>

<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Datos Principales</p>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fas fa-building"></i></span>
                            </div>
                            <input type="text" id="c_nombre" name="c_nombre" class="form-control" value="<?php echo $club['c_nombre']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fas fa-phone-square-alt"></i></span>
                            </div>
                            <input type="text" id="c_telefono" name="c_telefono" class="form-control" value="<?php echo $club['c_telefono']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fab fa-whatsapp"></i></span>
                            </div>
                            <input type="text" id="c_celular" name="c_celular" class="form-control" value="<?php echo $club['c_celular']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fas fa-envelope"></i></span>
                            </div>
                            <input type="text" id="c_email" name="c_email" class="form-control" value="<?php echo $club['c_email']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fas fa-map-marker-alt"></i></span>
                            </div>
                            <input type="text" id="c_domicilio" name="c_domicilio" class="form-control" value="<?php echo $club['c_domicilio']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><img width="50px;" src="assets/icons/afip.png"></span>
                            </div>
                            <input type="text" id="c_cuit" name="c_cuit" class="form-control" value="<?php echo $club['c_cuit']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fas fa-globe-americas"></i></span>
                            </div>
                            <input type="text" id="c_web" name="c_web" class="form-control" value="<?php echo $club['c_web']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xs-12">
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="edit-datos">
                        <label class="form-check-label">Editar</label>
                    </div>
                </div>
            </div>
            <div id="btn_datos" class="row justify-content-center">
                <div class="col-xs-12">
                    <div class="form-check mb-2">
                        <button class="btn btn-success" name="btn_datos" type="submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-3">
    <div class="card-header py-2">
        <p class="text-primary m-0 font-weight-bold">Redes Sociales</p>
    </div>
    <div class="card-body">
        <form method="post" action="">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fab fa-facebook-square"></i></span>
                            </div>
                            <input type="text" id="c_facebook" name="c_facebook" class="form-control" value="<?php echo $club['c_facebook']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fab fa-twitter-square"></i></span>
                            </div>
                            <input type="text" id="c_twitter" name="c_twitter" class="form-control" value="<?php echo $club['c_twitter']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fab fa-instagram"></i></span>
                            </div>
                            <input type="text" id="c_instagram" name="c_instagram" class="form-control" value="<?php echo $club['c_instagram']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i style="font-size:22px;" class="fab fa-youtube-square"></i></span>
                            </div>
                            <input type="text" id="c_youtube" name="c_youtube" class="form-control" value="<?php echo $club['c_youtube']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xs-12">
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="edit-redes">
                        <label class="form-check-label">Editar</label>
                    </div>
                </div>
            </div>
            <div id="btn_redes" class="row justify-content-center">
                <div class="col-xs-12">
                    <div class="form-check mb-2">
                        <button class="btn btn-success" name="btn_redes" type="submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="card mb-3">
            <center>
                <h4 class="mt-2">Logo</h4>
            </center>
            <div class="card-body text-center shadow">
                <?php echo "<embed class='mb-4' src='data:" . $club['c_logo_mime'] . ";base64," . base64_encode($club['c_logo_data']) . "' height='200'/>"; ?>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="edit-logo">
                    <label class="form-check-label">Editar</label>
                </div>
                <div id="form-logo" class="mb-3">
                    <form enctype="multipart/form-data" action="" method="post">
                        <input class="form-control form-control-sm mb-4" type="file" accept=".png" style="height:40px;" name="logo">
                        <input name="btnlogo" class="btn btn-success" type="submit" value="Actualizar Imágen">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-4">
        <div class="card mb-3">
            <center>
                <h4 class="mt-2">Icono</h4>
            </center>
            <div class="card-body text-center shadow">
                <?php echo "<embed class='mb-4' src='data:" . $club['c_icon_mime'] . ";base64," . base64_encode($club['c_icon_data']) . "' height='200'/>"; ?>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="edit-icon">
                    <label class="form-check-label">Editar</label>
                </div>
                <div id="form-icon" class="mb-3">
                    <form enctype="multipart/form-data" action="" method="post">
                        <input class="form-control form-control-sm mb-4" type="file" accept=".ico" style="height:40px;" name="icono">
                        <input name="btnicono" class="btn btn-success" type="submit" value="Actualizar Imágen">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form-logo').hide();
        $('#form-icon').hide();
        bloquear_elementos();
    });

    $('#edit-logo').change(function() {
        if ($('#edit-logo').is(':checked')) {
            $('#form-logo').show();
        } else {
            $('#form-logo').hide();
        }
    });

    $('#edit-icon').change(function() {
        if ($('#edit-icon').is(':checked')) {
            $('#form-icon').show();
        } else {
            $('#form-icon').hide();
        }
    });

    $('#edit-datos').change(function() {
        if ($('#edit-datos').is(':checked')) {
            liberar_datos();
            $('#btn_datos').show();
        } else {
            bloquear_datos();
            $('#btn_datos').hide();
        }
    });

    $('#edit-redes').change(function() {
        if ($('#edit-redes').is(':checked')) {
            liberar_redes();
            $('#btn_redes').show();
        } else {
            bloquear_redes();
            $('#btn_redes').hide();
        }
    });



    function bloquear_elementos() {
        bloquear_datos();
        bloquear_redes();
        $('#btn_datos').hide();
        $('#btn_redes').hide();
    }

    function bloquear_datos() {
        $('#c_nombre').attr('readonly', true);
        $('#c_telefono').attr('readonly', true);
        $('#c_celular').attr('readonly', true);
        $('#c_email').attr('readonly', true);
        $('#c_domicilio').attr('readonly', true);
        $('#c_cuit').attr('readonly', true);
        $('#c_web').attr('readonly', true);
    }

    function bloquear_redes() {
        $('#c_facebook').attr('readonly', true);
        $('#c_twitter').attr('readonly', true);
        $('#c_instagram').attr('readonly', true);
        $('#c_youtube').attr('readonly', true);
    }

    function liberar_datos() {
        $('#c_nombre').attr('readonly', false);
        $('#c_telefono').attr('readonly', false);
        $('#c_celular').attr('readonly', false);
        $('#c_email').attr('readonly', false);
        $('#c_domicilio').attr('readonly', false);
        $('#c_cuit').attr('readonly', false);
        $('#c_web').attr('readonly', false);
    }

    function liberar_redes() {
        $('#c_facebook').attr('readonly', false);
        $('#c_twitter').attr('readonly', false);
        $('#c_instagram').attr('readonly', false);
        $('#c_youtube').attr('readonly', false);
    }
</script>

<?php include 'assets/php/footer.php'; ?>

<!--
else{
                if( ($errors = sqlsrv_errors() ) != null) {
                    foreach( $errors as $error ) {
                        echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                        echo "code: ".$error[ 'code']."<br />";
                        echo "message: ".$error[ 'message']."<br />";
                    }
                }
            }
-->