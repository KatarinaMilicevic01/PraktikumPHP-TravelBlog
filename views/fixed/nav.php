<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid justify-content-between">
    <?php 
    if(isset($_SESSION['korisnik'])){
      $korisnik = $_SESSION['korisnik'];
        if($korisnik -> idUloga == 1){?>
          <a class="navbar-brand" href="index.php?page=blogovi"><h1><i class='fas fa-users-cog'></i>  Admin panel</h1></a>
  <?php }
        else{?>
        <a class="navbar-brand" href="#"><img src="assets/img/logo.png"></a>
  <?php
        }
    }
    else{?>
    <a class="navbar-brand" href="#"><img src="assets/img/logo.png"></a>
<?php }?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

        <ul class="navbar-nav">
          <?php
            if(isset($_SESSION['korisnik'])){
              $korisnik = $_SESSION['korisnik'];
              if($korisnik -> idUloga == 1){?>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=dodaj-blog">Dodaj blog</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=dodaj-podnaslov">Dodaj podnaslov</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=poruke">Poruke</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=statistika">Statistika pristupa</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=prikaz-log">Log fajl</a>
                </li> 
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=odjava">Odjavi se</a>
                </li> 
        <?php }
              else{?>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="index.php?page=pocetna">Početna</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=blogovi">Blogovi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=autor">O autoru</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=kontakt">Kontakt</a>
                </li>      
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=odjava">Odjavi se</a>
                </li> 
                <li class="nav-item">
                  <a class="nav-link" href="#" style="color:grey;"><i class="fas fa-user-circle mx-2"></i><?= $korisnik -> ime ?></a>
                </li>
            <?php }
            }
            else{?>
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="index.php?page=pocetna">Početna</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=blogovi">Blogovi</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=autor">O autoru</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=registracija">Registruj se</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php?page=logovanje">Log in</a>
                </li>
      <?php }?>
      </ul>
    </div>
  </div>
</nav>