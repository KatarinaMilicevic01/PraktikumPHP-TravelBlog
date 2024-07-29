<?php
if(isset($_SESSION['korisnik'])){
    header("Location: ../index.php?page=pocetna");
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-5 mx-auto py-5">
            <form action="models/korisnik/registracija.php" method="POST" id="regForm">
                <h2 class="text-center my-3">Registruj se</h2>
                <div class="form-group">
                    <input type="text" placeholder="Ime" name="tbIme" id="tbIme" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Prezime" name="tbPrezime" id="tbPrezime" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <div class="form-group">
                    <input type="email" name="tbEmail" id="tbEmail" placeholder="Email:petar@gmail.com" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Lozinka" name="tbLozinka" id="tbLozinka" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Potvrdi lozinku" name="tbPotvrda" id="tbPotvrda" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <p class='text-center my-3'>Imate nalog?
                <a href="index.php?page=logovanje" class='ml-2 text-danger'>Prijavi se.</a></p>
                <input type="submit" value="Registruj se" id="btnReg" class="btn btn-danger form-control my-2">
            </form>
            <?php if(isset($_GET['poruka'])):?>
                <p class="alert alert-success form-group"><?=$_GET['poruka']?></p>
            <?php endif; if(isset($_GET['error'])):?>
                <p class="alert alert-danger form-control"><?=$_GET['error']?></p>
            <?php endif;?>
        </div>
    </div>
</div>