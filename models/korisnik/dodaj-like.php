<?php
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $idOsoba = $_POST['idOsoba'];
        $idBlog = $_POST['idBlog'];

        try{
            $conn -> beginTransaction();

            $tabela = "lajk";
            $kolone = "idOsoba,idBlog";
            $vrednosti = [$idOsoba,$idBlog];

            $dodajLajk = upis($tabela,$kolone,$vrednosti);

            if(!$dodajLajk){
                http_response_code(404);
                echo json_encode(["poruka" => "greska"]);
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