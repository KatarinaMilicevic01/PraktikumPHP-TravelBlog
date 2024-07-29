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

    $poruke = dohvatiPoruke();
?>
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <h1 class="text-center my-5"><strong>Lista poruka</strong></h1></a>
        <div class="col-12">
            <table class="table table-light table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ime i prezime</th>
                        <th scope="col">Naslov</th>
                        <th scope="col">Poruka</th>
                        <th scope="col">Datum</th>
                        <th scope="col">Pročitano</th>
                        <th scope="col">Obriši</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rb=1;
                    foreach($poruke as $p):?>
                    <tr class="<?=$p -> procitano == 1 ? "table-secondary" : "table-primary"?>">
                        <th scope="row"><?=$rb?></th>
                        <td><?=$p->ime?> <?=$p->prezime?></td>
                        <td><?=$p->naslov?></td>
                        <td><?=$p->poruka?></td>
                        <td><?=$p->datum?></td>
                        <td><a href="models/admin/promeni-status-poruke.php?id_poruka=<?=$p->idPoruka?>&status=<?=$p -> procitano == 1 ? "0" : "1"?>"
                        class="btn btn-<?=$p->procitano == 1 ? "secondary" : "primary"?> btnTable"><?=$p -> procitano == 1 ? "Označi kao nepročitano" : "Označi kao pročitano"?></a></td>
                        <td><a href="models/admin/obrisi-poruku.php?id=<?=$p -> idPoruka?>"class="btn btn-danger">Obriši</a></td>
                    </tr>
                    <?php $rb++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
if(isset($_GET['message']))
{ echo '<p class="alert alert-success mx-5 my-4 col-5 mx-auto">'.$_GET['message'].'</p>';}
if(isset($_GET['error']))
{ echo '<p class="alert alert-error mx-5 my-4 col-5" mx-auto>'.$_GET['error'].'</p>';}
?>