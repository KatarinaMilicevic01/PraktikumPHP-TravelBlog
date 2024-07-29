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
    
    $podaci = logFajlPodaci("danas");
    if(!is_string($podaci)){ 
    
?>
<div class="container-fluid my-5">
    <div class="row my-5">
        <h1 class="my-5 text-center"><strong>Prikaz kompletnog log fajla poslednjih 24h</strong></h1>
        <?php
            $brKorisnika = 0;
            $korisnici =[];
            foreach($podaci as $p):
                $p = trim($p);
                list($strana, $vremePosete, $user, $ip) = explode("__", $p);

                if($user != "unauthorized"){
                    if(!in_array($user, $korisnici)){
                        $korisnici[] = $user;
                        $brKorisnika++;
                    }
                }
            endforeach;
        ?>
        <h3 class="col-10 mx-auto mt-5"><strong>Broj ulogovanih korisnika u poslednjih 24h:</strong>&nbsp&nbsp&nbsp<?= $brKorisnika ?></h3> 
    </div>
    <div class="col-10 mx-auto mb-5">
            <table class="table table-striped table-hover table-dark table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="col-1 text-center">#</th>
                        <th scope="col" class="col-3 text-center">Posećena stranica</th>
                        <th scope="col" class="col-2 text-center">Vreme posete</th>
                        <th scope="col" class="col-2 text-center">Korisnik</th>
                        <th scope="col" class="col-2 text-center">Ip adresa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rb=1;
                    foreach($podaci as $p):
                        $p = trim($p);
                        list($strana, $vremePosete, $user, $ip) = explode("__", $p);
                    ?>
                    <tr>
                        <th scope="row" class="col-1 text-center"><?= $rb ?></th>
                        <td class="col-3 text-center"><?= $strana ?></td>
                        <td class="col-2 text-center"><?= $vremePosete ?></td>
                        <td class="col-2 text-center"><?= $user ?></td>
                        <td class="col-2 text-center"><?= $ip ?></td>
                    </tr>
                    <?php $rb++; endforeach;?>
                </tbody>
                </table>

        <?php   }
                else{ ?>
                    <div style="height: 50vh;">
                    <h3 class="text-center my-5">Trenutno nema podataka.</h3>
                    </div>       
        <?php   }?>
    </div>
</div>