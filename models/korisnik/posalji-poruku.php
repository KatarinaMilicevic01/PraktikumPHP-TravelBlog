<?php
    session_start();
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $naslov = $_POST['tbNaslov'];
        $poruka = $_POST['tbPoruka'];
        $korisnik = $_SESSION['korisnik'];
        $idOsoba = $korisnik -> idOsoba;

        $greske = 0;

        if($naslov == ""){
            $greske++;
        }

        if($poruka == ""){
            $greske++;
        }

        if($greske == 0){
            try{
                $conn -> beginTransaction();

                $tabela ="poruka";
                $kolone = "naslov, poruka, idOsoba, procitano";
                $vrednosti = [$naslov, $poruka, $idOsoba, 0];

                $rezultat = upis($tabela, $kolone, $vrednosti);

                if(!$rezultat){
                    $error = "Došlo je do greške. Pokušajte kasnije.";
                    header("Location: ../../index.php?page=kontakt&error=".$error);
                }

                $conn -> commit();
                $odg = "Poruka je uspešno poslata. Hvala na izdvojenom vremenu.";
                header("Location: ../../index.php?page=kontakt&poruka=".$odg);
            }
            catch(PDOException $ex){
                http_response_code(500);
            }
        }
        else{
            http_response_code(204);
            $error = "Molim Vas unesite sve podatke.";
            header("Location: ../../index.php?page=kontakt&error=".$error);
        }
    }
?>