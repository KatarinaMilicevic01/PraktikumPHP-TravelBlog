<?php
    if(isset($_GET['id'])){
        $idBlog = $_GET['id'];
        
        $blog = dohvatiBlog($idBlog);
        $podnaslovi = dohvatiPodnaslove($idBlog);
        
        //var_dump($blog);
        //var_dump($podnaslovi);
        ?>
        
        <div id="coverBlog">
            <img src="assets/img/<?= $blog -> putanja ?>" alt="<?= $blog -> alt ?>">
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 mx-auto my-5">
                    <h1 class="text-center"><strong><?= $blog -> naslov ?></strong></h1>
                    <p class="my-5"><?= $blog ->opis ?></p>
        <?php
                    foreach($podnaslovi as $podnaslov): ?>
                    <h2 class="mt-5"><strong><?= $podnaslov -> podnaslov ?></strong></h2>
                    <p class="my-3"><?= $podnaslov -> podnaslovOpis ?></p>
        <?php    
                if($podnaslov -> idSlika != NULL){
                $slika = dohvatiSliku($podnaslov -> idPodnaslov);
                echo '      <div class="text-center">
                                <img src="assets/img/'.$slika -> putanja.'" alt="'.$slika -> alt.'" class="img-fluid">
                                <p class="fst-italic text-center">'.$slika -> alt.'</p>
                            </div>';
            }
        endforeach; ?>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-5 ms-5 border-bottom border-secondary">
                    <div class="row d-flex justify-content-between">
                        <div class="col-3">
                            <?php
                            $lajkovi = dohvatiLajkove($idBlog);
                            echo '<button type="button" class="btn btn-link my-3 ispisLajk col-12" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;&nbsp;'.count($lajkovi).' 
                            </button>

                            <!-- Modal -->
                            <div class="modal fade ispisLajk" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModalLabel">Osobe kojima se sviđa objava</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">';
                                        if(count($lajkovi) == 0){
                                            echo '<h3 class="my-5">Još uvek niko nije označio da mu se objava sviđa.</h3>';
                                        }
                                        else{
                                            foreach($lajkovi as $like){
                                                echo '<p>'.$like -> ime.' '.$like -> prezime.'</p>';
                                            }
                                        }
                            echo'       </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            ?>
                        </div>
                        <div class="col-3">
                            <?php
                            $komentari = dohvatiKomentare($idBlog);
                            echo '<button type="button" class="btn btn-link my-3 ispisKomentar col-12" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                            <i class="fa fa-commenting" aria-hidden="true"></i>&nbsp;&nbsp;'.count($komentari).' 
                            </button>

                            <!-- Modal -->
                            <div class="modal fade ispisKomentar" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="exampleModal1Label">Osobe koje su komentarisale objavu</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">';
                                        if(count($komentari) == 0){
                                            echo '<h3 class="my-5">Još uvek niko nije ostavio komentar.</h3>';
                                        }
                                        else{
                                            foreach($komentari as $komentar){
                                                echo '<figure class="border-secondary border-bottom mb-5">
                                                        
                                                        <blockquote class="blockquote">
                                                        <h3>'.$komentar -> komentar.'</h3>
                                                        </blockquote>
                                                        ';
                                                    if(isset($_SESSION['korisnik'])){
                                                        $korisnik = $_SESSION['korisnik'];        
                                                        if($korisnik -> idUloga == 1){
                                                            echo '
                                                            <figcaption class="blockquote-footer d-flex justify-content-between">
                                                                <div class="col-9">
                                                                '.$komentar -> datum.' <cite title="Source Title">'.$komentar -> ime.' '.$komentar -> prezime.'</cite>
                                                                </div>
                                                                <div class="col-2">
                                                                    <input type="button" value="Obriši" class="btn btn-danger btn-sm col-12 deleteComm" data-id="'.$komentar -> idKomentar.'">
                                                                </div>
                                                            </figcaption>';
                                                        
                                                        }
                                                        else{
                                                            echo '<figcaption class="blockquote-footer">
                                                            '.$komentar -> datum.' <cite title="Source Title">'.$komentar -> ime.' '.$komentar -> prezime.'</cite>                                                         
                                                        </figcaption>';
                                                        }
                                                    }
                                                    else{
                                                        echo '<figcaption class="blockquote-footer">
                                                            '.$komentar -> datum.' <cite title="Source Title">'.$komentar -> ime.' '.$komentar -> prezime.'</cite>                                                         
                                                        </figcaption>';
                                                    }
                                                        
                                                  echo '</figure>';
                                                }
                                        }
                            echo'       </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            if(isset($_SESSION['korisnik'])){
                $korisnik = $_SESSION['korisnik'];
                $idOsoba = $korisnik -> idOsoba; 
                $lajk = osobaLike($idOsoba,$idBlog);
                if($korisnik -> idUloga == 2){
                    echo'<div class="container-fluid">
                            <div class="row">
                                <div class="col-5 ms-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="visually-hidden" id="korisnikId">'.$korisnik -> idOsoba.'<p>
                                            <p class="visually-hidden" id="postId">'.$idBlog.'<p>';
                                        if($lajk){
                                     echo'  <button class="btn btn-primary col-12 my-3" id="unlike" data-id="'.$lajk -> idLike.'">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;&nbsp;Ne sviđa mi se
                                            </button>';
                                        }
                                        else{
                                     echo'  <button class="btn btn-outline-primary col-12 my-3" id="like">
                                                <i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp;&nbsp;Sviđa mi se
                                            </button>';
                                        } 
                                  echo '</div>
                                        <div class="col-6 my-3">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-outline-secondary col-12 my-3 dodajKomentar" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                                <i class="fa fa-commenting" aria-hidden="true"></i>&nbsp;&nbsp;Dodaj komentar
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade dodajKomentar" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModal2Label">Dodaj komentar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="visually-hidden" id="korisnikId">'.$korisnik -> idOsoba.'<p>
                                                            <p class="visually-hidden" id="postId">'.$idBlog.'<p>
                                                            <textarea placeholder="Komentar..." name="tbKom" id="tbKom" rows="3" class="form-control"></textarea>
                                                            <p id="kom"></p>    
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" id="dodajKomentar">Dodaj komentar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            }
        ?>
<?php } ?>        

