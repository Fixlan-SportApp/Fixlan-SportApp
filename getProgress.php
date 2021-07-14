<?php

if (strlen(session_id()) === 0) {
    session_start();
}

if (isset($_SESSION['progress'])) {
    echo $_SESSION['progress'];
    if ($_SESSION['progress'] == $_SESSION['max']) {
        unset($_SESSION['progress']);
    }
} else {
    echo '0';
}