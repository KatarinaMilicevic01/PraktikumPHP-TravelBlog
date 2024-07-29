<?php
    session_destroy();
    unset($_SESSION['korisnik']);
    header("Location: ../../index.php?page=pocetna");
    ob_end_flush();
    die();
?>