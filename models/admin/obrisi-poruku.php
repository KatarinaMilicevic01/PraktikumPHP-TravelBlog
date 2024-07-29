<?php
    include "../../config/connection.php";
    include "../functions.php";
    header("Content-type: application/json");

    if(isset($_GET['id'])){
        $idPoruka = $_GET['id'];
        try{
            $conn -> beginTransaction();
            
            $tabela = "poruka";
            $kolona = "idPoruka";
            $vrednost = [$idPoruka];

            $izbrisano = brisanje($tabela, $kolona, $vrednost);

            if(!$izbrisano){
                http_response_code(404);
                echo json_encode(["poruka" => "error"]);
            }
            $conn -> commit();

            $message = "Poruka je obrisana.";
            header("Location: ../../index.php?page=poruke&message=".$message);
        }
        catch(PDOException $ex){
            $error = "Došlo je do greške. Pokušajte kasnije.";
            header("Location: ../../index.php?page=poruke&error=".$error);
        }   
    }
?>