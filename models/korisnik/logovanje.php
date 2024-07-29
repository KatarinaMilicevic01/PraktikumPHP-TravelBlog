<?php
    session_start();
    header("Content-type: application/json");
    include "../functions.php";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        try{
            include "../../config/connection.php";

            $greske=0;

            $email = $_POST['email'];
            $lozinka = $_POST['lozinka'];
            $sifrovanaLozinka = md5($lozinka);

            $regEmail = "/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
            $regLozinka = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

            if(!preg_match($regEmail, $email)){
                $greske++;
            }

            if(!preg_match($regLozinka, $lozinka)){
                $greske++;
            }

            if($greske == 0){
                global $conn;
                $upit = "SELECT * FROM osoba WHERE email=? AND lozinka=?";
                $priprema = $conn -> prepare($upit);
                $priprema -> execute([$email, $sifrovanaLozinka]);
                $korisnik = $priprema -> fetch();
               
                if($korisnik){
                    
                    $trenutnoVreme = date("H:i:s");
                    $prosloVreme = strtotime($trenutnoVreme) - strtotime($korisnik -> vremeLog);

                    if($korisnik -> brGreske == 3 && $prosloVreme <= 10*60){
                        $vreme = 10*60 - $prosloVreme;
                        $preostaloVreme = date("i:s", $vreme);
                        echo json_encode(["poruka" => "10min", "vreme" => $preostaloVreme]);
                    }
                    else{
                        $_SESSION['korisnik'] = $korisnik;

                        updateLogovanje(0,0,0,$korisnik -> email);

                        echo json_encode(["aktivnost" => $korisnik -> status, "id" => $korisnik -> idUloga]);
                    }
                    
                }
                else{
                    $odg = ["korisnik" => "nema"];
                    echo json_encode($odg);
                }
                http_response_code(200);
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
?>