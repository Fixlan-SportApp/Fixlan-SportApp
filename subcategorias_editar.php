<?php $titulo = "Edici&oacute;n de Subcategor&iacute;a"; ?>
<?php include 'assets/php/header.php'; ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $subcategoria = get_subcategoria($_GET['id']);     
    }else{
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(editar_subcategoria($_POST['id'], $_POST['sc_categoria'], $_POST['sc_nombre'], $_POST['sc_descripcion'], $_POST['sc_edadini'], $_POST['sc_edadfin'], $_POST['sc_antiguedad'], $_POST['sc_grupofliar'], $_POST['sc_proxima'], $_POST['sc_mensual'], $_POST['sc_bimestral'], $_POST['sc_trimestral'], $_POST['sc_semestral'], $_POST['sc_anual'])){
                header('location: subcategorias_index.php');
            }else{
                echo 'error';
            }
        }else{
            header('location: subcategorias_index.php');    
        }
    }

    
    
?>
<h5><?php echo $titulo; ?></h5><hr>
<div class="row justify-content-center">
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="card shadow mb-3">
            <div class="card-body">
                <form method="post" action="" autocomplete="off">
                    <input hidden name="id" value="<?php echo $subcategoria['id']; ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Categor&iacute;a</label>
                                    <select name="sc_categoria" required class="form-control form-control-sm">
                                        <?php echo get_select_categorias($subcategoria['sc_categoria']); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input required class="form-control form-control-sm" type="text" name="sc_nombre" value="<?php echo $subcategoria['sc_nombre']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Descripci&oacute;n</label>
                                    <textarea class="form-control form-control-sm" rows="2" name="sc_descripcion"><?php echo $subcategoria['sc_descripcion']; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Edad Inicio</label>
                                    <input required class="form-control form-control-sm" type="number" min="0" max="99" step="1" name="sc_edadini" value="<?php echo $subcategoria['sc_edadini']; ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Edad Fin</label>
                                    <input required class="form-control form-control-sm" type="number" min="0" max="99" step="1" name="sc_edadfin" value="<?php echo $subcategoria['sc_edadfin']; ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>¿Suma antig&uuml;edad?</label>
                                    <select name="sc_antiguedad" required class="form-control form-control-sm">
                                        <?php
                                        if($subcategoria['sc_antiguedad'] == 'SI'){
                                            echo '<option selected value="SI">SI</option>';
                                            echo '<option value="NO">NO</option>';
                                        }else{
                                            echo '<option value="SI">SI</option>';
                                            echo '<option selected value="NO">NO</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>¿Grupo Familiar?</label>
                                    <select name="sc_grupofliar" required class="form-control form-control-sm">
                                        <?php
                                        if($subcategoria['sc_grupofliar'] == 'SI'){
                                            echo '<option selected value="SI">SI</option>';
                                            echo '<option value="NO">NO</option>';
                                        }else{
                                            echo '<option value="SI">SI</option>';
                                            echo '<option selected value="NO">NO</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label>Pr&oacute;xima categor&iacute;a</label>
                                    <select name="sc_proxima" required class="form-control form-control-sm">
                                        <option value="NINGUNA">NINGUNA</option>
                                        <?php echo get_select_subcategorias($subcategoria['sc_proxima']); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Valor Mensual</label>
                                    <input required class="form-control form-control-sm" type="number" value="<?php echo $subcategoria['sc_mensual']; ?>" step="0.50" name="sc_mensual">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Valor Bimestral</label>
                                    <input required class="form-control form-control-sm" type="number" value="<?php echo $subcategoria['sc_bimestral']; ?>" step="0.50" name="sc_bimestral">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label>Valor Trimestral</label>
                                    <input required class="form-control form-control-sm" type="number" value="<?php echo $subcategoria['sc_trimestral']; ?>" step="0.50" name="sc_trimestral">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Valor Semestral</label>
                                    <input required class="form-control form-control-sm" type="number" value="<?php echo $subcategoria['sc_semestral']; ?>" step="0.50" name="sc_semestral">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label>Valor Anual</label>
                                    <input required class="form-control form-control-sm" type="number" value="<?php echo $subcategoria['sc_anual']; ?>" step="0.50" name="sc_anual">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="btn_convenio" class="btn btn-primary">Guardar</button>
                        <a href="subcategorias_index.php" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/php/footer.php'; ?>
