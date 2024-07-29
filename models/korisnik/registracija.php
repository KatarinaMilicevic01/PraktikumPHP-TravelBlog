<?php
    include "../../helpers/mail.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        try{
            include "../../config/connection.php";
            include "../functions.php";

            $ime = $_POST['tbIme'];
            $prezime = $_POST['tbPrezime'];
            $email = $_POST['tbEmail'];
            $lozinka = $_POST['tbLozinka'];
            $potvrda = $_POST['tbPotvrda'];
            $sifrovanaLozinka = md5($lozinka);
            $kod = rand(100000, 999999);

            $greske=0;

            $regIme = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{2,50}$/";
            $regPrezime = "/^[A-ZŠĐŽČĆ][a-zšđžčć]{3,50}$/";
            $regEmail = "/^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/";
            $regLozinka = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

            if(!preg_match($regIme, $ime)){
                $greske++;
            }
            if(!preg_match($regPrezime, $prezime)){
                $greske++;
            }
            if(!preg_match($regEmail, $email)){
                $greske++;
            }
            if(!preg_match($regLozinka, $lozinka)){
                $greske++;
            }
            if($lozinka != $potvrda){
                $greske++;
            }

            if($greske == 0 ){
                global $conn;

                $proveriEmail = "SELECT * FROM osoba WHERE email = ?";
                $priprema = $conn -> prepare($proveriEmail);
                $priprema -> execute([$email]);
                $rez = $priprema ->fetchAll();
                $rezultat = $priprema -> rowCount();

                if($rezultat == 1){
                    $error = "Već postoji korisnik sa ovom email adresom. <a href='index.php?page=logovanje' class='ml-2 text-dark'>Prijavi se.</a>";
                    header("Location: ../../index.php?page=registracija&error=".$error);
                }
                else{
                    try{
                        $conn -> beginTransaction();

                        $tabela ="osoba";
                        $kolone = "ime, prezime, email, lozinka, idUloga, kod, status, brGreske, vremeLog, vremeGreske";
                        $vrednosti = [$ime, $prezime, $email, $sifrovanaLozinka, 2, $kod, 0, 0, 0, 0];

                        $odgovor = upis($tabela, $kolone, $vrednosti);

                        if(!$odgovor){
                            $error = "Greska prilikom upisa u bazu.";
                            header("Location: ../../index.php?page=registracija&error=".$error);
                        }
                        $conn -> commit();
                        
                        $body = '<div class="container-fluid my-5">
                        <div class="row d-flex justify-content-around my-5">
                            <div class="col-8 alert alert-secondary mx-auto mb-5 my-5" role="alert" >
                                <h1 class="alert-heading mb-5">Poštovani/a '.$ime.' '.$prezime.'</h1>
                                <h3 class="my-5">Kliknite na dugme ispod kako biste potvrdili svoj nalog i počeli da koristite sve prednosti sajta.</h3>
                                <hr>
                                <div class="row justify-content-center">
            <a href="https://putuj-sa-kacom.000webhostapp.com/index.php?page=aktivacija&kod='.$kod.'&email='.$email.'" class="btn btn-primary mx-auto col-5">Potvrdite nalog</a>
                                </div>
                            </div>
                        </div>
                    </div>';
                        $poruka = Mail::sendMail($email, "Aktivacioni mejl", $body, $ime, $prezime);
                        header("Location: ../../index.php?page=registracija&poruka=".$poruka);
                    }
                    catch(PDOException $e){
                        $conn -> rollback();
                        http_response_code(500);
                    }
                }
            }
            else{
                //var_dump($greske);
                header("Location: ../../index.php?page=registracija");
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }
?>