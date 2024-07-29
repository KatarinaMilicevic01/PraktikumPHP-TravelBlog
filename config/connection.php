<?php
    include "config.php";

    zabeleziPristupe();

    try {
        $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USER,
        PASSWORD);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    catch(PDOException $ex){
        echo $ex->getMessage();
    }

    function zabeleziPristupe(){

        $stranica = explode("&", $_SERVER["REQUEST_URI"]);
        $posecenaStranica = $stranica[0];
        $vreme = date("d.m.Y h:i:s");
        $ip = $_SERVER["REMOTE_ADDR"];
        $user = "unauthorized";

        if(isset($_SESSION['korisnik'])){
            $user = $_SESSION['korisnik'] -> email;
        }
        
        $podaci = $posecenaStranica."__".$vreme."__".$user."__".$ip."\n";

        $fajl = fopen(LOG_FAJL, "a");
        $upis = fwrite($fajl, $podaci);

        if($upis){
            fclose($fajl);
        }
    }
    
?>