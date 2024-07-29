<?php
    include '../../config/connection.php';

    global $conn;

    if($_SERVER['REQUEST_METHOD'] == "GET"){

        $id = $_GET['id_poruka'];
        $procitano = $_GET['status'];
        try{
    
            $izmeni = "UPDATE poruka SET procitano = ? WHERE idPoruka = ?";
            $priprema = $conn -> prepare($izmeni);
            $priprema -> execute([$procitano,$id]);
            
            $message = "Uspešno ste promenili status.";
            header("Location: ../../index.php?page=poruke&message=".$message);
        }
        catch(PDOException $ex){
            $error = "Došlo je do greške. Pokušajte kasnije.";
            header("Location: ../../index.php?page=poruke&error=".$error);
        }   
    }
?>