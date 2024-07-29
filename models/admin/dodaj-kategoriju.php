<?php
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $kategorija = $_POST['kategorija'];
        
        try{
            $conn -> beginTransaction();

            $tabela = "kategorija";
            $kolona = "kategorija";
            $vrednost = [$kategorija];

            $rezultat = upis($tabela, $kolona, $vrednost);

            if(!$rezultat){
                http_response_code(404);
                echo json_encode(["poruka" => "Greška prilikom upisa u bazu."]);
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