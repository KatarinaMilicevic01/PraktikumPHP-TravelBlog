<?php
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idKomentar = $_POST['idKom'];
        try{
            $conn -> beginTransaction();
            
            $tabela = "komentar";
            $kolona = "idKomentar";
            $vrednost = [$idKomentar];

            $deleteComm = brisanje($tabela, $kolona, $vrednost);

            if(!$deleteComm){
                http_response_code(404);
                echo json_encode(["poruka" => "error"]);
            }
            $conn -> commit();
            http_response_code(202);
            echo json_encode(["poruka" => "uspeh"]);
        }
        catch(PDOException $ex){
            $conn -> rollBack();
            http_response_code(500);
        }
    }
?>