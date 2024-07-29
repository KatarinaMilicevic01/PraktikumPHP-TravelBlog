<?php
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $naslov = $_POST["naslov"];
        $opis = $_POST["opis"];
        $slika = $_FILES["slika"];
        $kategorije = $_POST["kategorije"];
        $alt = $_POST['opisSlike'];

        
        $slikaNaziv = time()."___".$slika['name'];
        $putanja = "../../assets/img/$slikaNaziv";
        $putanjaMala = "../../assets/img-mala/$slikaNaziv";
        $tmpSlike = $slika['tmp_name'];
    
        if(move_uploaded_file($tmpSlike, $putanja)){
            copy($putanja, $putanjaMala);
        }
            
        $dimenzije = getimagesize($putanjaMala);
        $sirina = $dimenzije[0];
        $visina = $dimenzije[1];
    
        $novaSirina = 300;
        $novaVisina = $visina / ($sirina / $novaSirina);
    
        $ekstenzija = pathinfo($putanjaMala, PATHINFO_EXTENSION);
    
        if($ekstenzija == 'png'){
            $uplodeSlika = imagecreatefrompng($putanjaMala);
            $platno = imagecreatetruecolor($novaSirina, $novaVisina);
            imagecopyresampled($platno, $uplodeSlika, 0, 0, 0, 0, $novaSirina, $novaVisina, $sirina, $visina);
            imagepng($platno, $putanjaMala);
        }
        else{
            $uplodeSlika = imagecreatefromjpeg($putanjaMala);
            $platno = imagecreatetruecolor($novaSirina, $novaVisina);
            imagecopyresampled($platno, $uplodeSlika, 0, 0, 0, 0, $novaSirina, $novaVisina, $sirina, $visina);
            imagejpeg($platno, $putanjaMala);
        }
        
        try{
            $conn -> beginTransaction();

            $tabela = "slika";
            $kolone = "putanja,alt";
            $vrednosti = [$slikaNaziv, $alt];

            $novaSlika = upis($tabela, $kolone, $vrednosti);
            if($novaSlika){
                $id = $conn ->lastInsertId();
                
                $tabelaNaziv = "blog";
                $koloneNaziv = "naslov,opis,idSlika";
                $vrednostiNaziv = [$naslov,$opis,$id];

                $noviPost = upis($tabelaNaziv,$koloneNaziv,$vrednostiNaziv);

                if($noviPost){
                    $nizKategorije = explode(",", $kategorije);

                    $nazivTabela = "kategorija_blog";
                    $nazivKolona = "idKategorija,idBlog";
                    $idPost = $conn -> lastInsertId();

                    foreach($nizKategorije as $kat){
                        $nazivVrednost = [$kat,$idPost];
                        $katBlog = upis($nazivTabela, $nazivKolona, $nazivVrednost);
                    }
                        
                    if(!$katBlog){
                        http_response_code(404);
                        echo json_encode(["poruka" => "Greška pri upisu kategorija bloga."]);
                    }
                }
                else{
                    http_response_code(404);
                    echo json_encode(["poruka" => "Greška pri upisu bloga."]);
                }
            }
            else{
                http_response_code(404);
                echo json_encode(["poruka" => "Greška pri upisu slike."]);
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