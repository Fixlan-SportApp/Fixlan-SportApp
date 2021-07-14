<ul class="navbar-nav bg-gradient-club sidebar sidebar-dark accordion estilo_sidebar" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
        <div class="sidebar-brand-icon">
            <?php $logo = get_logo(); ?>
            <?php echo "<embed class='mt-2 ml-2' src='data:".$logo['c_logo_mime'].";base64,".base64_encode($logo['c_logo_data'])."' height='65'/>"; ?>
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo get_nombre_club(); ?></div>
    </a>
<!-- ["SOCIOS", "GESTION", "CLASES", "MARKETING", "BOLETERIA", "TESORERIA", "CONTABLE", "RRHH", "ACCESOS", "INFRAESTRUCTURA"] -->
    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="home.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span></a>
    </li>
    <?php if(modulo_habilitado('SOCIOS')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#socios" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>Socios</span>
        </a>
        <div id="socios" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="socio_alta.php">Alta de Socio</a>
                <a class="collapse-item" href="socios_index.php">Listado de Socios</a>                
            </div>
        </div>
    </li>
    <?php } if(modulo_habilitado('GESTION')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#elclub" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Gesti&oacute;n</span>
        </a>
        <div id="elclub" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="cuotas_index.php">Cuotas</a>
                <a class="collapse-item" href="periodos_index.php">Periodos</a>
                <a class="collapse-item" href="categorias_index.php">Categor&iacute;as</a>
                <a class="collapse-item" href="subcategorias_index.php">Subcategor&iacute;as</a>
                <a class="collapse-item" href="tablas_index.php">Tablas</a>
                <a class="collapse-item" href="club_index.php">Datos del Club</a>
                <a class="collapse-item" href="socio_morosos.php">Socios Morosos</a>
                <a class="collapse-item" href="lotes_index.php">Lotes D&eacute;b Autom.</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('CLASES')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clases" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-running"></i>
            <span>Clases</span>
        </a>
        <div id="clases" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="disciplinas_index.php">Disciplinas</a>
                <a class="collapse-item" href="profesores_index.php">Profesores</a>
                <a class="collapse-item" href="clases_index.php">Clases</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('MARKETING')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#marketing" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-bullhorn"></i>
            <span>Marketing</span>
        </a>
        <div id="marketing" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Redes Sociales</a>
                <a class="collapse-item" href="mkt_i_mapas_socios.php">Mapa de Calor</a>
                <a class="collapse-item" href="#">Patrocinios y Licencias</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('BOLETERIA')){ ?>
<!--    <hr class="sidebar-divider">-->
<!--    <div class="sidebar-heading">Eventos</div>-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#eventos" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-ticket-alt"></i>
            <span>Boleter&iacute;a</span>
        </a>
        <div id="eventos" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Nuevo Evento</a>
                <a class="collapse-item" href="#">Eventos Activos</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('TESORERIA')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tesoreria" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-cash-register"></i>
            <span>Tesoreria</span>
        </a>
        <div id="tesoreria" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="tesoreria_index.php">Cobranza</a>
                <a class="collapse-item" href="#">Pagos</a>
                <a class="collapse-item" href="#">Informes</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('CONTABLE')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#contable" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Contable</span>
        </a>
        <div id="contable" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="ingresos_index.php">Ingresos</a>
                <a class="collapse-item" href="egresos_index.php">Egresos</a>
                <a class="collapse-item" href="balance_index.php">Balance</a>
                <a class="collapse-item" href="cajas_index.php">Cajas</a>
                <a class="collapse-item" href="cheques_index.php">Gestion de Cheques</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('RRHH')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#rrhh" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-briefcase"></i>
            <span>Recursos Humanos</span>
        </a>
        <div id="rrhh" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Empleados</a>
                <a class="collapse-item" href="#">Asistencias</a>
                <a class="collapse-item" href="#">Sueldos</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('ACCESOS')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#controlaccesos" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-traffic-light"></i>
            <span>Control de Accesos</span>
        </a>
        <div id="controlaccesos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Control en Tiempo Real</a>
            </div>
        </div>
    </li>
    <?php }if(modulo_habilitado('INFRAESTRUCTURA')){ ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#infraestructura" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-traffic-light"></i>
            <span>Infraestructura</span>
        </a>
        <div id="infraestructura" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">Proyectos</a>
                <a class="collapse-item" href="#">Relevamientos</a>
                <a class="collapse-item" href="#">Mantenimiento</a>
            </div>
        </div>
    </li>
    <?php }?>
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
