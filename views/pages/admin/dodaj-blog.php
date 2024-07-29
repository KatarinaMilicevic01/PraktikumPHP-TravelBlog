<?php
    if(isset($_SESSION['korisnik'])){
        $korisnik = $_SESSION['korisnik'];
        if($korisnik -> idUloga != 1){
            header("Location: ../index.php?page=pocetna");
        }
    }
    if(!isset($_SESSION['korisnik'])){
        header("Location: ../index.php?page=pocetna");
    }
?>
<div class="container my-5">
    <div class="row">
        <div class="col-7 mx-auto">
                <div class="row d-flex justify-content-between">
                <h2 class="text-center my-3">Dodaj post</h2>
                <div class="col-4">
                        <label for="kategorije" class="mb-3">Kategorije</label>
                        <?php 
                            $kategorije = dohvatiPodatke("kategorija");
                            foreach($kategorije as $kat):?>
                            <div class="form-check" id="kategorije">
                                <input class="form-check-input" type="checkbox" name="chbKategorija" value="<?=$kat->idKategorija?>" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault"><?=$kat -> kategorija?></label>
                            </div>
                            <?php endforeach;?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-secondary my-3 dodajKat" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Dodaj novu kategoriju
                            </button>

                            <!-- Modal -->
                            <div class="modal fade dodajKat" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Dodaj kategoriju</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="kategorija" id="kategorija">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="button" id="dodajKategoriju" class="btn btn-success">Dodaj kategoriju</button>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <p id="kategorija"></p>
                    </div>
                    <div class="col-7 justify-content-end">
                        <div class="form-group">
                            <label for="naslovBlog">Naslov</label>
                            <input type="text" name="naslovBlog" id="naslovBlog" class="form-control my-3">
                            <p id="naslov"></p>
                        </div>
                        <div class="form-group">
                            <label for="opisBlog">Opis</label>
                            <textarea name="opisBlog" id="opisBlog" row="80" class="form-control my-3"></textarea>
                            <p id="opis"></p>
                        </div>
                        <div class="form-group">
                            <laubel for="fSlika">Naslovna slika</label>
                            <input class="form-control my-3" type="file" id="fSlika">
                            <p id="slika"></p>
                        </div>
                        <div class="form-group">
                            <label for="opisSlike">Opis slike</label>
                            <input type="text" name="opisSlike" id="opisSlike" class="form-control my-3">
                            <p id="opisSlika"></p>
                        </div>
                        <input type="button" value="Dodaj post" class="btn btn-success my-3 form-control" id="dodajBlog">
                    </div>
                    <div id="poruka"></div>
                    
                </div>
        </div>
    </div>
</div>