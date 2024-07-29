<div class="container-fluid">
    <div class="row align-items-center" id="coverHome">
        <div class="col-5 ms-3">
        <h1><strong>Putovanja kao inspiracija</strong></h1>
        <h3>Blog Katarine Milićević</h3>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-11 mx-auto">
        <h1 class="text-center my-5"><strong>Najnoviji postovi</strong></h1>
        <?php
            $blogovi = najnovijiBlog();
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
                        <h3 class="card-title mb-4"><strong><?= $blog -> naslov?></strong></h3>
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