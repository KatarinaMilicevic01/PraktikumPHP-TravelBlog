<?php

    if(isset($_GET['id'])){
        $idBlog = $_GET['id'];
        $blog = dohvatiBlog($idBlog);
        //var_dump($blog);
        echo '<div class="container-fluid">
                <div class="row">
                    <div class="col-8 mx-auto">
                        <h2>'. $blog[0] -> naslov .'</h2>
                        <p>'. $blog[0] -> opis .'</p>
                    </div>
                </div>
            </div>';
    }
?>