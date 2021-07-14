<!DOCTYPE html>
<html>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php include 'db.php'; ?>
<?php include 'session.php'; ?>
<?php include 'functions.php'; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $titulo; ?> - SportApp</title>
    <?php $logo = get_logo(); ?>
    <link href="<?php echo "data:".$logo['c_icon_mime'].";base64,".base64_encode($logo['c_icon_data']).""; ?>" rel="icon" type="<?php echo $logo['c_icon_mime']; ?>" />
    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/css/sb-admin-2.css" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.jquery.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/buttons.dataTables.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendor/confirm/confirm.min.css">
    <link rel="stylesheet" href="assets/vendor/context/jquery.contextMenu.min.css">
    <link rel="stylesheet" href="assets/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/vendor/select2/css/select2-bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/fullcalendar/main.min.css">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/datatables/dataTables.jquery.min.js"></script>
    <!--    <script src="assets/vendor/datatables/buttons.bootstrap4.min.js"></script>-->
    <script src="assets/vendor/datatables/scroller.bootstrap4.min.js"></script>
    <script src="assets/vendor/datatables/datatables.buttons.min.js"></script>
    <script src="assets/vendor/datatables/buttons.flash.min.js"></script>
    <script src="assets/vendor/datatables/jszip.min.js"></script>
    <script src="assets/vendor/datatables/pdfmake.min.js"></script>
    <script src="assets/vendor/datatables/vfs_fonts.js"></script>
    <script src="assets/vendor/datatables/buttons.html5.min.js"></script>
    <script src="assets/vendor/datatables/buttons.print.min.js"></script>
    <script src="assets/js/initdatatables.js"></script>
    <script src="assets/vendor/confirm/confirm.min.js"></script>
    <script src="assets/vendor/jquery/jquery.cookie.js"></script>
    <script src="assets/vendor/moment/moment.js"></script>
    <script src="assets/vendor/moment/moment-local.js"></script>
    <script src="assets/vendor/context/jquery.ui.position.min.js"></script>
    <script src="assets/vendor/context/jquery.contextMenu.min.js"></script>
    <script src="assets/vendor/select2/js/select2.full.min.js"></script>
    <script src="assets/vendor/jscolor/jscolor.js"></script>
    <script src="assets/vendor/fullcalendar/main.min.js"></script>
    <script src="assets/vendor/fullcalendar/locales/es.js"></script>
    <style>
        .bg-gradient-club {
            background-color: <?php echo color_sidebar(); ?>!important;
            background-size: cover !important;
        }
        .collapse-inner {
            background-color: <?php echo color_sidebar(); ?>!important;
        }
        .nav-link {
            color:white;
        }
        
        a.collapse-item{
            color:white !important;
        }
    </style>

    <!-- Load Leaflet from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>


    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.4.1/dist/esri-leaflet.js" integrity="sha512-xY2smLIHKirD03vHKDJ2u4pqeHA7OQZZ27EjtqmuhDguxiUvdsOuXMwkg16PQrm9cgTmXtoxA6kwr8KBy3cdcw==" crossorigin=""></script>


    <!-- Load Esri Leaflet Geocoder from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css" integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g==" crossorigin="">
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js" integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA==" crossorigin=""></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php include 'navbar.php'; ?>
                <div class="container-fluid">
