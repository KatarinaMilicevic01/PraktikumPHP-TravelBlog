<?php 
    if(isset($_SESSION['korisnik'])){
        header("Location: index.php?page=pocetna");
    }
?>

<div class="container-fluid" style="height:80vh;">
    <div class="row">
        <div class="col-4 mx-auto py-5" id="logForm">
            <form action="">
                <h2 class="text-center my-3">Prijavi se</h2>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="tbEmail" id="tbEmail" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <div class="form-group">
                    <label for="">Lozinka</label>
                    <input type="password" name="tbLozinka" id="tbLozinka" class="form-control">
                    <p class="text-danger"></p>
                </div>
                <p class='text-center my-3'>Nemate nalog?
                <a href="index.php?page=registracija" class='ml-2 text-primary'>Registruj se.</a>
                </p>
                <input type="button" value="Prijavi se" id="btnLog" class="btn btn-primary form-control">
                <p id="error"></p>
            </form>
        </div>
    </div>
</div>