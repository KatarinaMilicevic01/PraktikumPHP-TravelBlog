<?php
    if(isset($_SESSION['korisnik'])){
        $korisnik = $_SESSION['korisnik'];
        if($korisnik -> idUloga != 2){
            header("Location: index.php?page=pocetna");
        }
    }
?>

<div class="container-fluid my-5">
    <div class="row">
        <div class="col-5 d-flex justify-content-center my-5">
            <img src="assets/img/autor.jpg" alt="Katarina Milićević - autor">
        </div>
        <div class="col-7 my-5">
            <h2>Katarina Milićević</h2>
            <h3>57/19</h3>
            <p>Student sam Visoke ICT škole u Beogradu, smer internet tehnologije, modul Web
            programiranje.
            U svet programiranja uveo me je brat i jako sam mu zahvalna na tome. Posebno
            se interesujem za
            izradu web aplikacija, kako na front - u, tako i na back - u. Uživam u
            istraživanju i učenju novih
            stvari. Prikupljanje novih informacija, polako, prerasta u strast i opsesiju.
            Ukoliko želiš da
            zajedno unapređujemo svoje znanje iz ovih oblasti, ili imaš neko pitanje za
            mene, slobodno mi piši.</p>
            <div id="socMreze my-5" class="col-2">
                <div class="col-6 d-flex justify-content-between">
                    <h4><a href="https://www.linkedin.com/in/katarina-milicevic196b3a261/"><i class="fa fa-linkedin-square"></i></a></h4>
                    <h4><a href = "mailto: katarina.milicevic.2001@gmail.com"><i class="fa fa-envelope"></i></a></h4>
                </div>
            </div>
        </div>
    </div>
</div>