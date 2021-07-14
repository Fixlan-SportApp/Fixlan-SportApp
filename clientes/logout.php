<?php
ob_start();
session_start();
if(session_destroy()) {
    setcookie('CL_USER','',time()-100);
    setcookie('CL_TOKEN','',time()-100);
    setcookie('CL_DB','',time()-100);
    header("location: index.php");
}
