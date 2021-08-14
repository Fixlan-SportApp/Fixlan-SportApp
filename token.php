<?php

    require 'vendor/autoload.php';
    
    use Lcobucci\JWT\Configuration;
    use Lcobucci\JWT\Signer;
    use Lcobucci\JWT\Signer\Key\LocalFileReference;
    use Lcobucci\JWT\Signer\Key\InMemory;

    $array_ini = parse_ini_file("././boot.ini");

    define('URL_SPORT_APP', $array_ini['url_sportapp']);
    define('URL_CARNET_VIRTUAL', $array_ini['url_carnet']);

    function getConfiguration(){
        
        $now   = new DateTimeImmutable();

        $configuration = Configuration::forAsymmetricSigner(
            // You may use RSA or ECDSA and all their variations (256, 384, and 512) and EdDSA over Curve25519
            new Signer\Rsa\Sha256(),
            LocalFileReference::file(__DIR__ . '/key.pem'),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
            // You may also override the JOSE encoder/decoder if needed by providing extra arguments here
        );

        $configuration->builder()
                    // Configures the issuer (iss claim)
                    ->issuedBy(URL_SPORT_APP)
                    // Configures the audience (aud claim)
                    ->permittedFor(URL_CARNET_VIRTUAL)
                    // Configures the id (jti claim)
                    ->identifiedBy('4f1g23a12aaBcs')
                    // Configures the time that the token was issue (iat claim)
                    ->issuedAt($now)
                    // Configures the time that the token can be used (nbf claim)
                    ->canOnlyBeUsedAfter($now->modify('+3 minute'))
                    // Configures the expiration time of the token (exp claim)
                    ->expiresAt($now->modify('+180 minutes'));

        return $configuration;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {        
        $configuration = getConfiguration();

        $token = $configuration->builder()
                    // Builds a new token
                    ->getToken($configuration->signer(), $configuration->signingKey());

        echo json_encode([ 'token' => $token->toString() ]); // The string representation of the object is a JWT string
        
    }
?>