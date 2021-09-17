<?php

    require 'vendor/autoload.php';

    require 'clientes/assets/php/functions.php';
    require 'assets/vendor/phpqrcode/qrlib.php';
    require 'assets/php/qr.php';
    require 'assets/php/db.php';
    require 'token.php';

    use Lcobucci\JWT\Configuration;
    use Lcobucci\JWT\Validation\Constraint\ValidAt;
    use Lcobucci\Clock\SystemClock;
    use Lcobucci\JWT\Token;

    $array_ini = parse_ini_file("clientes/boot.ini");

    $_COOKIE['CL_DB'] = $array_ini['database'];
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    

    //Validar token y extraer DNI.
    if(!empty($_SERVER['HTTP_AUTHORIZATION'])){
        
        if (! preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            header("HTTP/1.1 400 Bad Request");
            exit;
        }

        $jwt = $matches[1];
        if (! $jwt) {
            // No token was able to be extracted from the authorization header
            header('HTTP/1.0 400 Bad Request');
            exit;
        }
        
        // verifying part...


        $config = getConfiguration();
        
        $token = $config->parser()->parse($jwt);

        $constraints = [
            new ValidAt(SystemClock::fromUTC())
        ];

        if (! $config->validator()->validate($token, ...$constraints)) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $dni = $_GET['dni'];
            
            if(!empty(check_is_socio($dni))){
                $socio = get_socio_by_dni($dni);
                $socio['qr'] = QR::generate($dni);
                $img_socio = get_img_socio($socio['id']);
                $socio['imagen'] = "<embed style='width: 100%;max-width: 125px;margin-left: 20px;margin-top: 24px;' src='data:" . $img_socio['i_mime'] . ";base64," . base64_encode($img_socio['i_data']) . "'/>";
                
                $inicio = new DateTime('first day of this month');
                $fin = new DateTime('last day of this month');
                // $inicio->format('Y-m-d'),$fin->format('Y-m-d')
                // $inicio->modify('-2 months');
                // $fin->modify('-2 months');

                // if(!check_is_socio_moroso($dni,$inicio->format('Y-m-d'),$fin->format('Y-m-d'))){
                //     $socio['moroso']  = 'amarillo';
                // }else{
                //     $socio['moroso']  = 'rojo';
                // }
                if($socio['meses_adeudados'] == 0){
                    
                    $socio['moroso']  = 'verde';

                }elseif($socio['meses_adeudados'] == 1
                        || $socio['meses_adeudados'] == 2){

                    $socio['moroso']  = 'amarillo';

                }else{
                    $socio['moroso']  = 'rojo';
                }
                header("HTTP/1.1 200 OK");
                echo json_encode($socio);
                exit;
            }
            header('HTTP/1.1 404 Not Found');
            exit;

        }
    }

    //En caso de que ninguna de las opciones anteriores se haya ejecutado
    header("HTTP/1.1 400 Bad Request");
    exit;
?>