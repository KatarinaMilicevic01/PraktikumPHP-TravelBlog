<?php

    ob_start();
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    session_start();
    include "config/connection.php";
    include "views/fixed/head.php";
    include "views/fixed/nav.php";
    include "models/functions.php";
?>
    <button type="button" class="btn btn-success scrollUp"><i class='fas fa-angle-double-up'></i></button>
<?php
    if(isset($_GET['page'])){
        switch($_GET['page']){
            case 'pocetna':
                include "views/pages/home.php";
                break;
            case 'blogovi':
                include 'views/pages/svi-blogovi.php';
                break;
            case 'blog':
                include 'views/pages/blog.php';
                break;
            case 'autor':
                include 'views/pages/o-autoru.php';
                break;
            case 'registracija':
                include "views/pages/registracija.php"; 
                break;
            case 'aktivacija':
                include 'models/korisnik/aktivacija.php';
                break;
            case 'logovanje':
                include 'views/pages/logovanje.php';
                break;
            case 'kontakt':
                include 'views/pages/kontakt.php';
                break;
            case 'odjava':
                include 'models/korisnik/odjava.php';
                break;
            case 'dodaj-blog':
                include 'views/pages/admin/dodaj-blog.php';
                break;
            case 'dodaj-podnaslov':
                include 'views/pages/admin/dodaj-podnaslov.php';
                break;        
            case 'poruke':
                include 'views/pages/admin/pregled-poruka.php';
                break;
            case 'statistika':
                include 'views/pages/admin/statistika.php';
                break;
            case 'prikaz-log':
                include 'views/pages/admin/pregled-logFajla.php';
                break;          
        }
    }
    include "views/fixed/footer.php";
?>