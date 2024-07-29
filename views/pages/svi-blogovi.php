<div class="container-fluid">
    <div class="row" id="blogoviCover">
        
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-11 mx-auto">
            <h1 class="text-center my-5"><strong>Svi postovi</strong></h1>
            <div class="row justify-content-between">
                <div class="col-4">
                    <select class="form-select form-control mb-5" id="ddlKat" aria-label=".form-select-lg example">>
                        <option selected value="0">Filtriraj po kategoriji</option>
                        <?php
                            $kategorije = dohvatiPodatke("kategorija");
                            foreach($kategorije as $kat){
                                echo '<option value="'.$kat -> idKategorija.'">'.$kat -> kategorija.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-4">
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" id="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success btn-sm" type="submit">Search</button>
                    </form>
                </div>
            </div>
            <div id="blogovi" class="mt-5">
            <?php
                $blogovi = sviBlogovi();

                foreach($blogovi as $blog): ?>
                <a href="index.php?page=blog&id=<?= $blog -> idBlog?>">
                    <div class="card mb-3">
                        <div class="row g-0 align-items-center justify-content-between">
                            <div class="col-4">
                                <div class="row justify-content-center">
                                    <img src="assets/img-mala/<?= $blog -> putanja?>" class="img-fluid col-11" alt="<?= $blog -> alt?>">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <h3 class="card-title"><strong><?= $blog -> naslov?></strong></h3>
                                    <p class="card-text"><?= $blog -> opis?></p>
                                    <p class="card-text"><small class="text-muted">Last updated <?= $blog -> datum?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<nav aria-label="...">
  <ul class="pagination justify-content-center my-5">
    <?php 
        $brStrana = brStrana();
        for($i = 0; $i < $brStrana; $i++):?>
            <li class="page-item">
                <a class="page-link paginacija" href="#" data-limit="<?= $i ?>"><?= ($i+1) ?></a>
            </li>
        <?php endfor;
    ?>
  </ul>
</nav>