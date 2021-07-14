<?php include 'assets/php/header.php'; ?>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Inicio</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <!-- <div class="btn-group mr-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                </div> -->
                <a class="btn btn-sm btn-outline-secondary" href="calendario.php"><span data-feather="calendar"></span> Ver mi Calendario</a>
            </div>
        </div>

        <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->

        <div class="row justify-content-end">
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                    <h4>Anuncios Importantes</h4>
                    </div>
                    <div class="card-body">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="float-right">
                                    <p>Fecha: 11/12/2020</p>
                                </div>
                                <h6>Titulo 1</h6>
                            </div>
                            <div class="card-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nibh lectus, elementum pulvinar porta vitae, sagittis id erat. Aenean ultricies fringilla placerat. Ut maximus nibh at urna elementum, et vestibulum mi egestas. Curabitur sed risus vitae arcu cursus venenatis. Mauris luctus sapien rutrum, scelerisque arcu at, lobortis velit. Nullam ut nisi mauris. Integer sed velit dolor. Maecenas tincidunt blandit mi, eu dictum est mollis id.</p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="float-right">
                                    <p>Fecha: 12/12/2020</p>
                                </div>
                                <h6>Titulo 2</h6>
                            </div>
                            <div class="card-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nibh lectus, elementum pulvinar porta vitae, sagittis id erat. Aenean ultricies fringilla placerat. Ut maximus nibh at urna elementum, et vestibulum mi egestas. Curabitur sed risus vitae arcu cursus venenatis. Mauris luctus sapien rutrum, scelerisque arcu at, lobortis velit. Nullam ut nisi mauris. Integer sed velit dolor. Maecenas tincidunt blandit mi, eu dictum est mollis id.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        Mis pr&oacute;ximas clases
                    </div>
                    <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Clase</th>
                                <th>D&iacute;a</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo listado_clases_socio_home(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    

<?php include 'assets/php/footer.php'; ?>