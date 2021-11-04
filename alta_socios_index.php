<?php $titulo = "Actualización de Socios"; ?>
<?php include 'assets/php/header.php'; ?>



<div class="float-right">
   <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nuevo_lote">Carga de Excel</button>-->


</div>
<h5><?php echo $titulo; ?></h5>
<hr>
<div class="card shadow mb-3">
    <div class="card-body">

     <form action='cargarexcel_socios.php' method='post' enctype="multipart/form-data">
                     <div class="form-row">
                          <!-- <div class="card">-->
                            <!--<label for="xls" class="col-lg-2 control-label">Archivo .xls</label>-->
                            <label>Archivo .xls</label>
                           <div class="col-md-12">
                                   <input type="file" name="xls"  accept=".xls,.xlsx"  id="xls" placeholder="Archivo">
                           
                              <button type="submit" id="cargar" class="btn btn-primary"><i class='fa fa-upload'></i> Cargar Excel</button>
                            </div>
                    </div>
                </form>
    </div>
    <div class="loader"></div>
</div>

<div class="modal fade" id="nuevo_lote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <!--  <h5 class="modal-title" id="exampleModalLabel">Carga de Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </div>



            <div class="modal-body">
                   <form action='cargarexcel_cuotas.php' method='post' enctype="multipart/form-data">
                     <div class="form-row">
                          <!-- <div class="card">-->
                            <!--<label for="xls" class="col-lg-2 control-label">Archivo .xls</label>-->
                            <label>Archivo .xls</label>
                           <div class="col-md-6">
                                   <input type="file" name="xls"  accept=".xls,.xlsx"  id="xls" placeholder="Archivo">
                            </div>       
                            <div class="col-md-6">
                              <button type="submit" id="agregar" class="btn btn-primary"><i class='fa fa-upload'></i> Cargar Excel</button>
                            </div>
                    </div>
                </form>
               <!-- <form method="post" action="">
                    <div class="form-row">
                        <div class="col-8">
                            <div class="form-group">
                                <label>Forma de Pago</label>
                                <select id="forpag" class="form-control form-control-sm">
                                    <?php echo get_select_forpag_lote(0); ?>
                                </select>
                            </div>
                        </div>
                        <div id="tarjetas" class="col-4">
                            <div class="form-group">
                                <label>Tarjeta</label>
                                <select class="form-control form-control-sm">
                                    <?php echo get_select_tarjetas_lote(0); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Generar</button>-->
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

          $("#cargar").click(function() {
            $('.loader').html('<div class="loading"></div>');
            // $('.loader').html('<div class="loading"><img src="img/ring.gif" alt="loading" /><br/>Un momento, por favor...</div>');

             //$('.loader').css("background-image", "url(img/ring.gif)");  
             //$(".loader").fadeOut("slow");
          });   
       
    });
</script>

<?php include 'assets/php/footer.php'; ?>
