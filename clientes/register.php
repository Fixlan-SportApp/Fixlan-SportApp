<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

    <title>Registro - SportApp</title>

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
            max-width: 600px;
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

<body class="text-center">
    <form method="post" action="" class="form-signin">
        <!--        <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">-->
        <h1 class="h3 mb-3 font-weight-normal">Registro</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <input type="email" id="inputEmail" class="form-control mb-2" placeholder="Documento de Identidad" required autofocus>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <input type="email" id="inputEmail" class="form-control mb-2" placeholder="Correo Electr&oacute;nico" required autofocus>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <input type="password" id="inputPassword" class="form-control mb-2" placeholder="Contrase&ntilde;a" required>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <input type="password" id="inputPassword" class="form-control mb-2" placeholder="Repita su Contrase&ntilde;a" required>
            </div>
        </div>
<div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button class="btn btn-primary btn-block mb-4" type="submit">Ingresar</button>
            </div>
        </div>
        <center><a class="mt-4" href="forgot-password.php">Olvid&eacute; mi contrase&ntilde;a</a></center>
        <p class="mt-4 mb-3 text-muted">SportApp &copy; <?php echo date('Y'); ?> </p>
    </form>
</body>

</html>
