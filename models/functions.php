<?php
    // ******** DOHVATANJE SVIH PODATAKA IZ TABELE
    function dohvatiPodatke($tabela){
        global $conn;

        $upit = "SELECT * FROM $tabela";
        $rezultat = $conn -> query($upit) -> fetchAll();
        return $rezultat;
    }

    // ******** UPIS PODATA U BILO KOJU TABELU
    function upis($tabela, $kolone, $vrednosti){

        $vrednostiNiz =[];
        for($i=0; $i < count($vrednosti); $i++){
            $vrednostiNiz[] = "?";
        }
        $vrednostiString = implode(",", $vrednostiNiz);
        
        global $conn;
        
        $upit = "INSERT INTO $tabela($kolone) VALUES ($vrednostiString)";
        $insert = $conn -> prepare($upit);
        $rezultat = $insert -> execute($vrednosti);

        return $rezultat;
    }

    // ******** BRISANJE PODATAKA BILO KOJE TABELE
    function brisanje($tabela, $kolona, $id){
        global $conn;

        $upit = "DELETE FROM $tabela WHERE $kolona = ?";
        $delete = $conn -> prepare($upit);
        $rezultat = $delete -> execute($id);
        
        return $rezultat;
    }

    // ******** 5 POSLEDNJE DODATIH BLOGOVA ZA ISPIS NA POCETNOJ STRANI
    function najnovijiBlog(){
        global $conn;

        $upit = "SELECT * FROM blog b JOIN slika s ON b.idSlika = s.idSlika ORDER BY datum DESC LIMIT 5";
        $blogovi = $conn -> query($upit) -> fetchAll();
        return $blogovi;
    }

    // ******** IZMENA PODATAKA O USPEŠNOSTI LOGOVANJA
    function updateLogovanje($brGreske, $poslednjneLog, $vremeGreske, $email){
        global $conn;

        $upit = "UPDATE osoba SET brGreske = :br, vremeLog = :vremeLog, vremeGreske = :greska WHERE email = :email";
        $priprema = $conn -> prepare($upit);
        $priprema -> bindParam(":br", $brGreske);
        $priprema -> bindParam(":vremeLog", $poslednjneLog);
        $priprema -> bindParam(":greska", $vremeGreske);
        $priprema -> bindParam(":email", $email);

        $izmena = $priprema -> execute();
        return $izmena;
    }

    // ******** DOHVATANJE BLOGA NA OSNOVU PROSLEĐENOG ID-a ZA PRIKAZ CELOKUPNOG POSTA 
    function dohvatiBlog($id){
        global $conn;

        $upit = "SELECT * FROM blog b JOIN slika s ON b.idSlika = s.idSlika 
                JOIN kategorija_blog kb ON b.idBlog = kb.idBlog
                WHERE b.idBlog = $id";
        $blog = $conn -> query($upit) -> fetch();
        return $blog;
    }

    // ******** PODNASLOVI ZA BLOG KOJI TREBA DA SE PRIKAŽE
    function dohvatiPodnaslove($idBlog){
        global $conn;

        $upit = "SELECT * FROM podnaslov WHERE idBlog = $idBlog";
        $podnaslovi = $conn -> query($upit) -> fetchAll();
        return $podnaslovi;
    }

    // ******** SLIKE ZA ODGOVARAJUĆI PODNASLOV
    function dohvatiSliku($idPodnaslov){
        global $conn;

        $upit = "SELECT * FROM podnaslov pn JOIN slika s ON pn.idSlika = s.idSlika WHERE pn.idPodnaslov = $idPodnaslov";
        $slika = $conn -> query($upit) -> fetch();
        return $slika;
    }
    
    // ******** KOMENTARI BLOGA
    function dohvatiKomentare($idBlog){
        global $conn;

        $upit = "SELECT * FROM komentar k JOIN blog b ON k.idBlog = b.idBlog
        JOIN osoba o ON k.idOsoba = o.idOsoba
        WHERE k.idBlog = $idBlog";
        $komentari = $conn -> query($upit) -> fetchAll();
        return $komentari;
    }

    // ******** LAJKOVI BLOGA
    function dohvatiLajkove($idBlog){
        global $conn;
        
        $upit = "SELECT * FROM lajk l JOIN blog b ON l.idBlog = b.idBlog
        JOIN osoba o ON l.idOsoba = o.idOsoba WHERE l.idBlog = $idBlog";
        $lajkovi = $conn -> query($upit) -> fetchAll(); 
        return $lajkovi;
    }

    // ******** OSOBE KOJE SU LAJKOVALE BLOG
    function osobaLike($idOsoba,$idBlog){
        global $conn;

        $upit = "SELECT * FROM lajk WHERE idOsoba=$idOsoba AND idBlog=$idBlog";
        $lajk = $conn -> query($upit) -> fetch();
        return $lajk;
    }

    // ******** UKUPAN BROJ DODATIH BLOGOVA ********
    function brojBlogova(){
        global $conn;

        $upit = "SELECT COUNT(*) as brBlogova FROM blog";
        $brBlogova = $conn -> query($upit) -> fetch();

        return $brBlogova;
    }

    // ******** ODREĐIVANJE POTREBNOG BROJA STRANA ZA PAGINACIJU
    function brStrana(){
        
        $brBlogovaObj = brojBlogova();

        $brStr = ceil($brBlogovaObj -> brBlogova / BLOG_OFFSET);
        return $brStr;
    }

    // ******** DOHVATANJE BLOGOVA SA ARGUMENTIMA ZA PAGINACIJU, PRETRAGU I FILTRIRANJE
    define("BLOG_OFFSET", 3);
    function sviBlogovi($limit=0, $search="", $kategorija=0){
        global $conn;

        $upit = "SELECT * FROM blog b JOIN slika s ON b.idSlika = s.idSlika 
            JOIN kategorija_blog kb ON b.idBlog = kb.idBlog WHERE naslov LIKE '%$search%'";
        if($kategorija != 0){
            $upit .= "AND idKategorija = $kategorija";
        }    
        
        $upit .= " GROUP BY naslov LIMIT :limit, :offset";

        $select = $conn -> prepare($upit);

        $limit = ((int) $limit) * BLOG_OFFSET;
        $select -> bindParam(":limit", $limit, PDO::PARAM_INT);

        $offset = BLOG_OFFSET;
        $select -> bindParam(":offset", $offset, PDO::PARAM_INT);

        $select -> execute();
        $blogovi = $select -> fetchAll();

        return $blogovi;
    }

    // ******** BROJ STRANA ZA PAGINACIJU FILTRIRANIH BLOGOVA
    function brFiltriranihStrana($search="", $kategorija=0){
        global $conn;

        $upit = "SELECT * FROM blog b JOIN slika s ON b.idSlika = s.idSlika 
            JOIN kategorija_blog kb ON b.idBlog = kb.idBlog WHERE naslov LIKE '%$search%'";
        if($kategorija != 0){
            $upit .= "AND idKategorija = $kategorija";
        }  

        $blogovi = $conn -> query($upit) -> fetchAll();

        $brBlogova = count($blogovi);
        $brStr = ceil($brBlogova / BLOG_OFFSET);

        return $brStr;
    }

    // ******** PORUKE ********
    function dohvatiPoruke(){
        global $conn;

        $upit = "SELECT * FROM poruka p JOIN osoba o ON p.idOsoba = o.idOsoba ORDER BY procitano";
        $poruke = $conn -> query($upit) -> fetchAll();
        return $poruke;
    }

    // ******** PODACI IZ LOG FAJLA
    function logFajlPodaci($vreme){
        
        $sviPodaci = file("data/log.txt");
        $podaci = [];
        if($sviPodaci){
            foreach($sviPodaci as $p){
                // var_dump($p);
                $p = trim($p);
                list($strana, $vremePosete, $user, $ip) = explode("__", $p);
                $str = explode("/", $strana);
                // if($str[1] !== "models"){
                    if($vreme == "danas"){
                        $danas = time();
                        $vremePosete = strtotime($vremePosete);
        
                        if($danas - $vremePosete < 60*60*24){
                            if($str[1] !== "models"){
                            $podaci[] = $p;
                            }
                        }
                    }
                    else{
                        $podaci[] = $p;
                    }
                    
                // }
                
            }
        
        }
        else{
            return "Nije bilo poseta sajtu u poslednjia 24h.";
        }
        return $podaci;
    }

    // ******** POSEĆENE STRANICE BEZ PONAVLJANA
    function posebneStranice(){
        $podaci = logFajlPodaci("sve");

        $stranice = [];
        foreach($podaci as $red){
            $red = trim($red);
            list($stranica, $vreme, $korisnik, $ip) = explode("__", $red);

            $user = explode("@", $korisnik);

            if($user[0] != "admin"){
                if(!in_array($stranica, $stranice)){
                    $stranice [] = $stranica;
                } 
            }
        }
        return $stranice;
    }

    // ******** BROJ POSETA SVAKOJ OD STRANICA
    function brPoseta($stranica, $podaci){
        
        $brPoseta = 0;
        foreach($podaci as $p){
            $p = trim($p);
            list($strana, $vremePosete, $user, $ip) = explode("__", $p);

            if($stranica == $strana){
                $brPoseta++;
            }
        }

        return $brPoseta;
    }

    // ******** PROCENTUALNA POSEĆENOST SVAKOJ STRANICI
    function procenatPosecenosti($podaci, $brPoseta){
        
        $ukupnoPoseta = count($podaci);
        $procenat = 100 * $brPoseta / $ukupnoPoseta;

        return number_format($procenat, 2, ".", "");
    }    
?>