<?php
    if(isset($_SESSION['korisnik'])){
        $korisnik = $_SESSION['korisnik'];
        if($korisnik -> idUloga != 2){
            header("Location: index.php?page=pocetna");
        }
    }
    if(!isset($_SESSION['korisnik'])){
        header("Location: index.php?page=pocetna");
    }
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-7 mx-auto my-2">
            <h2 class="my-5"><strong>Ukoliko imaš bilo kakvo pitanje, sugestiju ili kritiku, osećaj se slobodno da me kontaktiraš</strong></h4>
            <form action="models/korisnik/posalji-poruku.php" method="post">
                <div class="form-group my-2">
                    <input type="text" placeholder="Naslov" name="tbNaslov" id="tbNaslov" class="form-control">
                </div>
                <div class="form-group my-2">
                    <textarea placeholder="Tekst poruke..." name="tbPoruka" id="tbPoruka" rows="3" class="form-control"></textarea>
                </div>
                <input type="submit" id="tbSend" value="Pošalji" class="btn btn-success form-control my-5">
            </form>
            <?php if(isset($_GET['poruka'])):?>
                <p class="alert alert-success form-group"><?=$_GET['poruka']?></p>
            <?php endif; if(isset($_GET['error'])):?>
                <p class="alert alert-danger form-control"><?=$_GET['error']?></p>
            <?php endif;?>
        </div>
    </div>
</div>