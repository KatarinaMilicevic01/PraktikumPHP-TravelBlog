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
    if(is_array($podaci)){
    $stranice = posebneStranice();
?>
<div class="container-fluid">
    <div class="row my-5 justify-content-center">
        <h1 class="text-center my-3"><strong>Procentualna statistika poseta stranicama</strong></h1>
        <div class="col-9 mx-auto">
            <table class="table table-striped table-success table-bordered my-5">
                <thead>
                    <tr>
                        <th colspan="<?=count($stranice);?>" class="zaglavlje">
                            <h3 class="text-center">Poslednja 24h</h3>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php foreach($stranice as $str): 
                            $s = explode("=", $str); ?>
                            <td class="text-center"><strong><?= $s[1]; ?></strong></td>
                        <?php endforeach;?>
                    </tr>
                    <tr>
                        <?php foreach($stranice as $str): 
                        $brPoseta = brPoseta($str, $podaci);
                        $procenat = procenatPosecenosti($podaci, $brPoseta)?>
                            <td class="text-center"><?= $procenat;?>%</td>
                        <?php endforeach;?>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php } else{?>
            <div class="col-9 mx-auto d-flex align-items-center" style= "height: 65vh;">
                <p class="alert alert-danger mx-auto my-5 text-center align-middle col-5"><?= $podaci ?></p>
            </div>
        <?php }?>
    </div>
</div>
