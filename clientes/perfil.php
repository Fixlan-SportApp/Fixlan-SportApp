<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $socio = get_info_socio(get_id_usuario());
    }else{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if(isset($_POST['btn_imagen'])){
                $i_socio = $_POST['id'];
                $DATA = $_FILES["img"]["tmp_name"];
                $MIME    = $_FILES["img"]["type"];
                $NAME  = $_FILES["img"]["name"];
                $extension = pathinfo($NAME, PATHINFO_EXTENSION);
                $nombre = $i_socio . '.' . $extension;
                $PATH = "img/".get_db();

                move_uploaded_file($DATA, "$PATH/$nombre");

                $sql = "INSERT INTO [".get_db()."].[dbo].[imagen] (i_socio, i_name, i_mime, i_data) VALUES ('".$i_socio."', '".$nombre."', '".$MIME."', (SELECT BulkColumn 
        FROM Openrowset( Bulk '".$_SERVER['DOCUMENT_ROOT']."/SportApp/img/".get_db()."/".$nombre."', Single_Blob) as img))";
                
                if(mysqli_query($conexion, $sql)){
                    header('location: socio_info.php?id='.$i_socio);
                }else{
                    echo 'Error al actualizar la foto del socio';
                    $socio = get_info_socio($_POST['id']);
                }
            }
            
        }else{
            header('location: home.php');    
        }
    }
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Mi Perfil</h1>
<!--
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
        </button>
    </div>
-->
</div>
<div class="row mb-5">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Carnet</p>
            </div>
            <div class="card-body">
                <div class="form-row justify-content-center mb-4">
                    <div class="col" id="contenedor_img">
                        <?php if(check_img_socio($socio['id'])){ ?>
                        <?php echo '<center><img style="width:100%;heigth:auto;max-width:200px;" src="img/perfil.jpg"></center>'; ?>
                        <?php } else {
                                $img_socio = get_img_socio($socio['id']);
                                echo "<center><embed style='width:100%;heigth:auto;max-width:200px;' src='data:".$img_socio['i_mime'].";base64,".base64_encode($img_socio['i_data'])."'/></center>"; 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Acciones</p>
            </div>
            <div class="card-body">
                <a href="actividades.php" class="btn btn-block btn-primary">Ver mis Actividades</a>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Datos Personales</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <input hidden name="id" value="<?php echo $socio['id']; ?>">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_apellido"><strong>Apellido</strong></label><input class="form-control form-control-sm" type="text" value="<?php echo $socio['s_apellido']; ?>" readonly id="s_apellido" name="s_apellido"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_nombre"><strong>Nombre</strong></label><input class="form-control form-control-sm" required type="text" name="s_nombre" id="s_nombre" readonly value="<?php echo $socio['s_nombre']; ?>"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_documento"><strong>Documento</strong></label><input class="form-control form-control-sm" type="text" required name="s_documento" readonly id="s_documento" value="<?php echo $socio['s_documento']; ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_fecnac"><strong>Fecha de Nacimiento</strong></label><input class="form-control form-control-sm" type="date" required disabled name="s_fecnac" id="s_fecnac" value="<?php echo $socio['s_fecnac']; ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_sexo"><strong>Sexo</strong></label>
                                        <select name="s_sexo" id="s_sexo" required disabled class="form-control form-control-sm">
                                            <?php echo get_select_sexos($socio['s_sexo']);?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <?php $estado = get_estado_socio($socio['id']); ?>
                        <div class="card bg-<?php echo $estado[1]; ?> text-white shadow" id="estado_socio">
                            <div class="card-body text-uppercase font-weight-bold text-center m-0 p-0">
                                <?php echo $estado[0]; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card shadow mb-3">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Datos de Contacto</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <input hidden name="id" value="<?php echo $socio['id']; ?>">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_telefono"><strong>Tel&eacute;fono</strong></label><input class="form-control form-control-sm" type="tel" readonly id="s_telefono" name="s_telefono" value="<?php echo $socio['s_telefono']; ?>"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group"><label for="s_celular"><strong>Celular</strong></label><input class="form-control form-control-sm" type="tel" readonly name="s_celular" id="s_celular" value="<?php echo $socio['s_celular']; ?>"></div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group"><label for="s_email"><strong>Correo Electr&oacute;nico</strong></label><input class="form-control form-control-sm" readonly type="email" id="s_email" name="s_email" value="<?php echo $socio['s_email']; ?>"></div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <form method="post" action="">
                            <input hidden name="id" value="<?php echo $socio['id']; ?>">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><strong>Domicilio</strong></label>
                                        <input readonly id="domicilio_anterior" class="form-control form-control-sm" type="text" value="<?php echo $socio['s_domicilio']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-4">
                                <div class="col">
                                    <div style="min-height:200px;" class="form-group">
                                        <div id="map" style="height: 200px;"></div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    var map;

    $(document).ready(function() {
        map = L.map('map').setView([<?php echo $socio['s_latitud']; ?>, <?php echo $socio['s_longitud']; ?>], 16);

        marcador = L.marker([<?php echo $socio['s_latitud']; ?>, <?php echo $socio['s_longitud']; ?>]).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    });

</script>



<?php include 'assets/php/footer.php'; ?>
