<?php
ob_start();
session_start();
if(session_destroy()) {
    setcookie('SP_USER','',time()-100);
    setcookie('SP_TOKEN','',time()-100);
    setcookie('SP_DB','',time()-100);
    header("location: index.php");
}
