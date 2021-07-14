<!doctype html>
<html lang="en">
<?php session_start(); ?>
<?php include 'assets/php/db.php'; ?>
<?php include 'assets/php/functions.php'; ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

    <title>Iniciar Sesi&oacute;n - SportApp</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

    </style>
</head>

<?php
    $error = 0;

    if(isset($_COOKIE['CL_USER']) || isset($_COOKIE['CL_TOKEN'])){
        if($_COOKIE['CL_USER'] != ""){
            $_SESSION['CL_USER'] = $_COOKIE['CL_USER'];
            $_SESSION['CL_TOKEN'] = $_COOKIE['CL_TOKEN'];

            header('location: home.php');   
        }
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $control = get_login(seguridad(strtolower($_POST['CL_USER'])), seguridad($_POST['CL_PASSWORD']));
        if($control == 1){
            $error = 0;
            $_SESSION['CL_USER'] = seguridad(strtolower($_POST['CL_USER']));
            set_token(seguridad(strtolower($_POST['CL_USER'])));
            $token_user = get_token(seguridad($_POST['CL_USER']));
            $_SESSION['CL_TOKEN'] = $token_user;
            setcookie('CL_USER', seguridad(strtolower($_POST['CL_USER'])), time() + 604800);
            setcookie('CL_TOKEN', seguridad(strtolower($_SESSION['CL_TOKEN'])), time() + 604800);
            setcookie('CL_DB', get_db_usuario(seguridad(strtolower($_POST['CL_USER']))), time() + 604800);
            header('location: home.php');   
        }else{
            $error = 1;
        }
    }
?>

<body class="text-center">
    <form class="form-signin" method="post" action="">
        <h1 class="h3 mb-3 font-weight-normal">Sede Virtual - Inicio de Sesi&oacute;n</h1>
        <label for="inputEmail" class="sr-only">Correo Electr&oacute;nico</label>
        <input type="email" id="inputEmail" name="CL_USER" class="form-control" placeholder="Correo Electr&oacute;nico" required autofocus>
        <label for="inputPassword" class="sr-only">Contrase&ntilde;a</label>
        <input type="password" name="CL_PASSWORD" id="inputPassword" class="form-control" placeholder="Contrase&ntilde;a" required>
        <div class="checkbox mb-3 mt-2">
            <label>
                <input type="checkbox" checked value="remember-me"> Recordar sesi&oacute;n
            </label>
        </div>
        <button class="btn btn-primary btn-block mb-4" type="submit">Ingresar</button>
        <center><a class="mt-4" href="forgot-password.php">Olvid&eacute; mi contrase&ntilde;a</a></center>
        <p class="mt-4 mb-3 text-muted">SportApp &copy; <?php echo date('Y'); ?> </p>
    </form>
</body>

</html>
