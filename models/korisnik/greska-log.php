<?php
    include "../functions.php";
    include "../../helpers/mail.php";
    session_start();
    header("Content-type: application/json");

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
                $upit = "SELECT * FROM osoba WHERE email=? OR lozinka=?";
                $priprema = $conn -> prepare($upit);
                $priprema -> execute([$email, $sifrovanaLozinka]);
                $korisnik = $priprema -> fetch();

                if($korisnik){                    
                    $fail = $korisnik -> brGreske;
                    $last_log = $korisnik -> vremeLog;
                    $err = $korisnik -> vremeGreske;
                    $trenutnoVreme = date("H:i:s");

                    if(strtotime($err) - strtotime($last_log) >= 5*60){
                        updateLogovanje(0, 0, 0, $korisnik -> email);
                    }
    

                    if($fail == 3 && strtotime($trenutnoVreme) - strtotime($err) <= 5*60){

                        $body = '<div class="container-fluid my-5">
                                    <div class="row d-flex justify-content-around my-5">
                                        <div class="col-8 alert alert-secondary mx-auto mb-5 my-5" role="alert" >
                                            <h1 class="alert-heading mb-5">Poštovani/a '.$korisnik -> ime.' '.$korisnik -> prezime.'</h1>
                                            <h3 class="my-5">Desila su se 3 neuspela pokušaja logovanja na Vaš korisnički nalog. Vaš nalog je privremeno blokiran. Mozete pokušati ponovo za 10 min.</h3>
                                        </div>
                                    </div>
                                </div>';
                            echo json_encode(["odgovor" => "10min"]);
                        return Mail::sendMail($email, "Upozorenje", $body, $korisnik -> ime, $korisnik -> prezime);
                    }
                    else{
                        if($fail == 0){
                            $err = $trenutnoVreme;
                        }
                        
                        $fail++;
                        $last_log = date("H:i:s", time());
                        updateLogovanje($fail,$last_log,$err,$email);
                        echo json_encode(["odgovor" => "greska"]);
                    }
                    
                }
                else{                   
                    
                    // http_response_code(204); 
                    echo json_encode(["odgovor" => "nema korisnika"]);
                }
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
?>