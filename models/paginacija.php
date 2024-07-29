<?php
    include "../config/connection.php";
    include "functions.php";
    header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $limit = $_POST["limit"];

        $search = $_POST["search"];

        $kategorija = $_POST["kategorija"];
        
        try{
            $blogovi = sviBlogovi($limit, $search, $kategorija);

            $brBlogova = count($blogovi);
            $brStrana = brFiltriranihStrana($search, $kategorija);

            $data['blogovi'] = $blogovi;
            
            if($search != "" || $kategorija !=0){
                $data['brStrana'] = $brStrana;
            }
            //var_dump($blogovi);

            if($blogovi){
                echo json_encode($data);
            }
            else{
                echo json_encode(["poruka" => "Nema postova za zadate parametre.", "brStrana" => $brStrana]);
            }
        }
        catch(PDOException $ex){
            http_response_code(500);
        }
    }

?>