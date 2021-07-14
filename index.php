<!DOCTYPE html>
<html>
<?php session_start(); ?>
<?php include 'assets/php/db.php'; ?>
<?php include 'assets/php/functions.php'; ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Inicio de Sesi&oacute;n - SportApp</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/logo.png&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Inicio de Sesi&oacute;n</h4>
                                    </div>
                                    <?php
                                        $error = 0;

                                        if(isset($_COOKIE['SP_USER']) || isset($_COOKIE['SP_TOKEN'])){
                                            if($_COOKIE['SP_USER'] != ""){
                                                $_SESSION['SP_USER'] = $_COOKIE['SP_USER'];
                                                $_SESSION['SP_TOKEN'] = $_COOKIE['SP_TOKEN'];

                                                header('location: home.php');   
                                            }
                                        }
                                        if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                            $control = get_login(mssql_espape(strtolower($_POST['SP_USER'])), mssql_espape($_POST['SP_PASSWORD']));
                                            if($control == 1){
                                                $error = 0;
                                                $_SESSION['SP_USER'] = mssql_espape(strtolower($_POST['SP_USER']));
                                                set_token(mssql_espape(strtolower($_POST['SP_USER'])));
                                                $token_user = get_token(mssql_espape($_POST['SP_USER']));
                                                $_SESSION['SP_TOKEN'] = $token_user;
                                                setcookie('SP_USER', mssql_espape(strtolower($_POST['SP_USER'])), time() + 604800);
                                                setcookie('SP_TOKEN', mssql_espape(strtolower($_SESSION['SP_TOKEN'])), time() + 604800);
                                                setcookie('SP_DB', get_db_usuario(seguridad(strtolower($_POST['SP_USER']))), time() + 604800);
                                                header('location: home.php');   
                                            }else{
                                                $error = 1;
                                            }
                                        }
                                    ?>
                                    <form method="post" action="">
                                        <div class="form-group"><input class="form-control form-control-user" type="text" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Usuario" name="SP_USER"></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Contraseña" name="SP_PASSWORD"></div>
                                        <button class="btn btn-primary btn-block text-white btn-user" type="submit">Iniciar Sesi&oacute;n</button>
                                        <hr>
                                    </form>
                                    <div class="text-center"><a class="small" href="forgot-password.html">Restaurar contrase&ntilde;a</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
