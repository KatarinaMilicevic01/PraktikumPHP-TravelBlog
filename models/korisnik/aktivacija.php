<?php
    if(isset($_GET['kod']) && isset($_GET['email'])){
        $kod = $_GET['kod'];
        $email = $_GET['email'];

        $upit = "SELECT * FROM osoba WHERE kod = :kod AND email = :email";
        $priprema = $conn -> prepare($upit);
        $priprema -> bindParam(":kod", $kod);
        $priprema -> bindParam(":email", $email);
        $priprema -> execute();
        $provera = $priprema -> fetch();

        if($provera){
            $query = "UPDATE osoba SET status = 1";
            $promena = $conn -> prepare($query) -> execute(); ?>


<div class="container-fluid my-5">
    <div class="row d-flex justify-content-around my-5">
        <div class="col-8 alert alert-success mx-auto mb-5 my-5" role="alert" >
            <h1 class="alert-heading mb-5"><strong>Dobro došli!</strong></h1>
            <h3 class="my-5">Vaš nalog je uspešno verifikovan! Sada možete da nastavite sa korišćenjem sajta.</h3>
            <hr>
            <div class="row justify-content-center">
                <p>Ukoliko imate bilo kakvo pitanje, uvek me možeš kontaktirati <a href="index.php?page=kontakt" class="alert-link">ovde.</a></p>
            </div>
        </div>
    </div>
</div>
<?php
        
        }}
    else{
        header("Location: index.php?page=pocetna");
    }
?>