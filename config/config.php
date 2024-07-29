<?php
    define("BASE_URL", $_SERVER["DOCUMENT_ROOT"]."/");
    define("ENV", BASE_URL."config/.env");
    define("LOG_FAJL", BASE_URL."data/log.txt");

    define("SERVER", env("SERVER"));
    define("DATABASE", env("DATABASE"));
    define("USER", env("USER"));
    define("PASSWORD", env("PASSWORD"));

    function env($mark){
        $niz = file(ENV);
        $trazenaVrednost = "";

        foreach($niz as $red){
            $red = trim($red);
            list($identifikator, $vrednost) = explode("=", $red);

            if($identifikator == $mark){
                $trazenaVrednost = $vrednost;
                break;
            }
        }

        return $trazenaVrednost;
    }   
?>