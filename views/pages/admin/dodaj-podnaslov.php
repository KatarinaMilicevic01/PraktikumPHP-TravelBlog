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
<div class="container">
    <div class="row">
        <div class="col-7 mx-auto">
            <h2 class="text-center my-3">Dodaj podnaslov</h2>
            <div class="form-group">
                <select name="ddlNaslov" id="ddlNaslov" class="form-select form-control mb-3" aria-label=".form-select-lg example">
                    <option value="0">Izaberi blog za koji želiš podnaslov</option>
                    <?php
                        $blogovi = dohvatiPodatke("blog");
                        foreach($blogovi as $blog):?>
                    <option value="<?= $blog->idBlog ?>"><?= $blog->naslov ?></option>
                    <?php endforeach; ?>
                </select>
                <div id="izaberiBlog"></div>
            </div>
            <div class="form-group">
                <label for="podnaslovBlog">Podnaslov</label>
                <input type="text" name="naslovBlog" id="podnaslovBlog" class="form-control my-3">
                <p id="dodajNaslov"></p>
            </div>
            <div class="form-group">
                <label for="opisBlog">Opis</label>
                <textarea name="opisBlog" id="opisBlog" row="80" class="form-control my-3"></textarea>
                <p id="dodajOpis"></p>
            </div>
            <div class="form-group">
                <label for="fSlika">Slika</label>
                <input class="form-control my-3" type="file" id="fSlika">
                <p id="dodajSliku"></p>
            </div>
            <div class="form-group">
                <label for="opisSlike">Opis slike</label>
                <input type="text" name="opisSlike" id="opisSlike" class="form-control my-3">
                <p id="opisSlika"></p>
            </div>
            <input type="button" id="dodajPodnaslov" value="Dodaj podnaslov" class="btn btn-success form-control my-3"> 
            <p id="poruka"></p> 
        </div> 
    </div>
</div>