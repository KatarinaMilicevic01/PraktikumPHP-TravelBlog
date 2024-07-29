<?php
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        try{
            $conn -> beginTransaction();

            $podnaslov = $_POST['podnaslov'];
            $opis = $_POST['opis'];
            $idBlog = $_POST['id'];

            if(isset($_FILES['slika'])){
                $slika = $_FILES['slika'];
                $alt = $_POST['opisSlike'];

                $nazivSlike = time()."___".$slika['name'];
                $putanja = "../../assets/img/$nazivSlike";
                $tmp_slika = $slika['tmp_name'];

                move_uploaded_file($tmp_slika,$putanja);

                $tabela = "slika";
                $kolone = "putanja,alt";
                $vrednosti = [$nazivSlike,$alt];
                $novaSlika = upis($tabela,$kolone,$vrednosti);
                if($novaSlika){
                    $idSlika = $conn -> lastInsertId();
                }
                else{
                    http_response_code(404);
                    echo json_encode(["poruka" => "Greška pri dodavanju slike."]);
                }
                
            }
            else{
                $idSlika = NULL;
            }
            
            $tabelaNaziv = "podnaslov";
            $koloneNaziv = "podnaslov,podNaslovOpis,idSlika,idBlog";
            $vrednostiNaziv = [$podnaslov,$opis,$idSlika,$idBlog];

            $noviPodnaslov = upis($tabelaNaziv,$koloneNaziv,$vrednostiNaziv);

            if(!$noviPodnaslov){
                http_response_code(404);
                echo json_encode(["poruka" => "Greška pri dodavanju podnaslova."]);
            }

            $conn -> commit();
            http_response_code(201);
            echo json_encode(["poruka" => "uspeh"]);

        }
        catch(PDOException $ex){
            $conn -> rollback();
            http_response_code(500);
        }
    }
?>
