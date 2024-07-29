$(document).ready(function(){
    $(window).scroll(function() {
        if ($(document).scrollTop() > 400) {
          $('.scrollUp').fadeIn();
        } else {
          $('.scrollUp').fadeOut();
        }
      });
      $('.scrollUp').click(function() {
        $("html, body").animate({
          scrollTop: 0
        }, 50);
        return false;
      });

    function ajaxCallBackFormData(url, method, data, result){
        $.ajax({
        url: url,
        method: method,
        data: data,
        contentType: false,
        processData: false,
        success: result,
        error: function(xhr, status, errorMsg){
            //console.log(xhr);
            console.log("poruka:"+errorMsg);
        }
    })
    }

    function ajaxCallBack(url, method, data, result){
        $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: "JSON",
        success: result,
        error: function(xhr, status, errorMsg){
        //console.log(xhr);
        console.log("poruka:"+errorMsg);
        }
        })
    }
    
    // ******** VALIDACIJA ********
    function validacija(data, regEx, poruka){
        greske=0;
        
        if(!regEx.test(data.val())){
            data.addClass('border border-3 border-danger');
            data.parent().find("p").html(poruka);
            greske++;
        }
        else{
            data.removeClass('border border-3 border-danger');
            data.parent().find("p").html("");
        }

        return greske;
    }
    
    // ******** REGISTRACIJA ********
    $("#regForm").submit(function(){
        greske = 0;
        rezultat = true;

        ime = $('#tbIme');
        prezime = $('#tbPrezime');
        email = $('#tbEmail');
        lozinka = $("#tbLozinka");
        potvrda = $("#tbPotvrda");

        imeGreska = "Ime mora početi velikim slovom i imati najmanje 3 slova.";
        prezimeGreska = "Prezime mora početi velikim slovom i imati najmanje 4 slova.";
        emailGreska = "Email nije u odgovarajucem formatu.";
        lozinkaGreska = "Lozinka mora imati minimum 8 karaktera, jedno slovo i jedan broj.";
        potvrdaGreska = "Lozinka se ne podudara.";

        regIme = /^[A-ZŠĐŽČĆ][a-zšđžčć]{2,50}$/;
        regPrezime = /^[A-ZŠĐŽČĆ][a-zšđžčć]{3,50}$/;
        regEmail = /^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
        regLozinka = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        greske+=validacija(ime, regIme, imeGreska);
        greske+=validacija(prezime, regPrezime, prezimeGreska);
        greske+=validacija(email, regEmail, emailGreska);
        greske+=validacija(lozinka, regLozinka, lozinkaGreska);

        if(potvrda.val() == "" || lozinka.val() != potvrda.val()){
            potvrda.addClass('border border-3 border-danger');
            potvrda.parent().find("p").html(potvrdaGreska);
            greske++;
        }
        else{
            potvrda.removeClass('border border-3 border-danger');
            potvrda.parent().find("p").html("");
        }

        if(greske != 0){
            rezultat = false;
        }

        return rezultat;
    });
    
    // ******** LOGOVANJE ********
    $("#btnLog").on('click', function(){
        email = $("#tbEmail");
        lozinka = $("#tbLozinka");

        greske=0;

        emailGreska = "Email nije u odgovarajucem formatu.";
        lozinkaGreska = "Lozinka mora imati minimum 8 karaktera, jedno slovo i jedan broj.";

        regEmail = /^\w[.\d\w]*\@[a-z]{2,10}(\.[a-z]{2,3})+$/;
        regLozinka = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        greske+=validacija(email, regEmail, emailGreska);
        greske+=validacija(lozinka, regLozinka, lozinkaGreska);

        data = {
            email: email.val(),
            lozinka: lozinka.val()
        }

        if(greske==0){
            ajaxCallBack("models/korisnik/logovanje.php", "post", data, function(result){
                console.log(result);
                if(result.aktivnost == 1 && result.id == 1){
                    window.location.href = "index.php?page=blogovi";
                }
                if(result.aktivnost == 1 && result.id == 2){
                    window.location.href = 'index.php?page=pocetna';
                }
                if(result.aktivnost == 0){
                    $("#error").addClass('alert alert-danger form-control my-3');
                    $("#error").html("Niste aktivirali nalog. Molimo proverite email.");
                }
                if(result.poruka == "10min"){
                    $("#error").addClass('alert alert-danger form-control my-3');
                    $("#error").html("Neuspešno logovanje 3 puta za 5min. Nalog je zakljucan još "+result.vreme+" min.");   
                }
                if(result.korisnik == "nema"){
                    ajaxCallBack("models/korisnik/greska-log.php", "post", data, function(result){
                        if(result.odgovor == "10min"){
                            $("#error").addClass('alert alert-danger form-control my-3');
                            $("#error").html("Neuspešno logovanje 3 puta za 5min. Nalog je zakljucan narednih 10min.");   
                        }
                        if(result.odgovor == "greska"){
                            $("#error").addClass('alert alert-danger form-control my-3');
                            $("#error").html("Korisničko ime ili lozinka su neispravni. Pokušaj ponovo."); 
                        }
                        if(result.odgovor == "nema korisnika"){
                            $("#error").addClass('alert alert-danger form-control my-3 text-center');
                            $("#error").html("Nemate nalog? <a href='index.php?page=registracija' class='ml-2 text-primary'>Registruj se.</a>");
                        }
                    })
                }
            })
        }
    })

    // ******** PAGINACIJA ********
    $(document).on('click', ".paginacija", function(e){
        e.preventDefault();
        limit = $(this).attr('data-limit');
        search = $("#search").val();
        kategorija = $("#ddlKat option:selected").val();
        filterBlog(limit,search,kategorija);
    })

    // ******** FILTRIRANJE BLOGOVA ********
    function filterBlog(limit,search,kategorija){
        
        data = {limit: limit, search: search, kategorija: kategorija};
        console.log(limit);

        ajaxCallBack("models/paginacija.php", "post", data, function(result){
            console.log(result.blogovi);
            console.log(result.brStrana);

            if(result.brStrana != undefined){
                paginacija(result.brStrana);
            }
            if(result.poruka){
                $("#blogovi").html(`<h1 class="text-center my-5">${result.poruka}</h1>`);
                console.log(result.poruka);
            }
            else{
                ispisiBlogove(result.blogovi);
            }            
        })
    }

    // ******** PAGINACIJA FFILTRIRANIH BLOGOVA ********
    function paginacija(brStrana){
        html="";

        for(i = 0; i < brStrana; i++){
            html += `<li class="page-item">
                        <a class="page-link paginacija" href="#" data-limit="${i}">${i+1}</a>
                    </li>`;
        }
        $(".pagination").html(html);
    }

    // ******** DOHVATANJE VREDNOSTI PRETRAGE ********
    $("#search").on("keyup", function(){
        search = $("#search").val();
        kategorija = $("#ddlKat option:selected").val();
        filterBlog(0,search,kategorija);
    })

    // ******** IZABRANA KATEGORIJA ********
    $('#ddlKat').prop('selectedIndex',0);
    $("#ddlKat").on('change', function(){
        search = $("#search").val();
        kategorija = $("#ddlKat option:selected").val();
        
        filterBlog(0,search,kategorija);
    });

    // ******** ISPIS FILTRIRANIH BLOGOVA ********    
    function ispisiBlogove(blogovi){
        html="";
        for(let b of blogovi){
            html += `
            <a href="index.php?page=blog&id=${b.idBlog}">
                <div class="card mb-3">
                    <div class="row g-0 align-items-center justify-content-between">
                        <div class="col-4">
                            <div class="row justify-content-center">
                                <img src="assets/img-mala/${b.putanja}" class="img-fluid col-11" alt="${b.alt}">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h3 class="card-title"><strong>${b.naslov}</strong></h3>
                                <p class="card-text">${b.opis}</p>
                                <p class="card-text"><small class="text-muted">Last updated ${b.datum}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>`;
        }
        $("#blogovi").html(html);
        
        window.scrollTo({ top: 600, behavior: 'smooth' });
    }

    // ******** LIKE ********
    $("#like").on('click', function(){
        idOsoba = $("#korisnikId").text();
        idBlog = $("#postId").text();

        data = {idOsoba : idOsoba, idBlog : idBlog};

        ajaxCallBack("models/korisnik/dodaj-like.php", "post", data, function(result){
            console.log(result);
            location.reload();
        })
    })

    // ******** UNLIKE ********
    $("#unlike").on('click', function(){
        idLike = $(this).attr('data-id');

        data = {idLike : idLike};

        ajaxCallBack("models/korisnik/obrisi-like.php", "post", data, function(result){
            console.log(result);
            location.reload();
        })        
    })

    // ******** NOVI KOMENTAR ********
    $("#dodajKomentar").on('click', function(){
        idOsoba = $("#korisnikId").text();
        idBlog = $("#postId").text();
        komentar = $("#tbKom").val(); 
        greske = 0;

        data = {idOsoba : idOsoba, idBlog : idBlog, komentar : komentar};
        
        if(komentar == ""){
            $("#kom").addClass("alert alert-danger");
            $("#kom").html("Unesite komentar");
        }
        else{
            ajaxCallBack("models/korisnik/dodaj-komentar.php", "post", data, function(result){
                if(result.poruka == "uspeh"){
                    location.reload();
                }
            })
        }
    })

    // ******** NOVA KATEGORIJA ********
    $("#dodajKategoriju").on('click', function(){
        kategorija = $("#kategorija").val();

        if(!kategorija == ""){
            data = {kategorija : kategorija};
            ajaxCallBack("models/admin/dodaj-kategoriju.php", "post", data, function(result){
                if(result.poruka == "uspeh"){
                    location.reload();
                }
                else{
                    $("#poruka").html("<p class='alert alert-danger'>" + result.poruka + "</p>");
                }
            })
        }
    })

    // ******** NOVI BLOG ********
    $("#dodajBlog").on('click', function(){
        naslov = $("#naslovBlog").val();
        opis = $("#opisBlog").val();
        slika = $("#fSlika")[0].files[0];
        kategorije = $.map($('input[name="chbKategorija"]:checked'), function(c){return c.value; })
        opisSlike = $("#opisSlike").val();
        greske = 0;

        if(naslov == ""){
            $("#naslov").addClass("alert alert-danger my-3");
            $("#naslov").html("Unesite naslov.");
            greske++;
        }
        
        if(opis == ""){
            $("#opis").addClass("alert alert-danger my-3");
            $("#opis").html("Unesite opis.");
            greske++;
        }

        if(slika == undefined){
            $("#slika").addClass("alert alert-danger my-3");
            $("#slika").html("Dodajte naslovnu sliku.");
            greske++;
        }

        if(kategorije == ""){
            $("#kategorija").addClass("alert alert-danger my-3");
            $("#kategorija").html("Izaberite bar 1 kategoriju.");
            greske++;
        }
        if(opisSlike == ""){
            $("#opisSlika").addClass("alert alert-danger my-3");
            $("#opisSlika").html("Dodajte opis slike.");
            greske++;
        }

        podaci = new FormData();
        podaci.append("naslov", naslov);
        podaci.append("opis", opis);
        podaci.append("slika", slika);
        podaci.append("kategorije", kategorije);
        podaci.append("opisSlike", opisSlike);

        if(greske == 0){
            ajaxCallBackFormData("models/admin/dodaj-post.php", "post", podaci, function(result){
                if(result.poruka == "uspeh"){
                    $("#poruka").html("<p class='alert alert-success'>Uspešno ste dodali post!</p><a href='index.php?page=dodaj-podnaslov' class='btn btn-secondary'>Dodaj podnaslov</a>")
                }
                else{
                    $("#poruka").html("<p class='alert alert-danger'>" + result.poruka + "</p>");
                }
            })
        }
    })

    // ******** NOVI PODNASLOV ********
    $("#dodajPodnaslov").on('click', function(){
        naslov = $("#podnaslovBlog").val();
        opis = $("#opisBlog").val();
        slika = $("#fSlika")[0].files[0];
        idBlog = $("#ddlNaslov").find(":selected").val();
        opisSlike = $("#opisSlike").val();

        data = new FormData();
        greske = 0;

        if(idBlog == 0){
            $("#izaberiBlog").addClass("alert alert-danger my-3");
            $("#izaberiBlog").html("Izaberi blog o kom želiš da pišeš.");
            greske++;
        }

        if(naslov == ""){
            $("#dodajNaslov").addClass("alert alert-danger my-3");
            $("#dodajNaslov").html("Unesite naslov.");
            greske++;
        }
        
        if(opis == ""){
            $("#dodajOpis").addClass("alert alert-danger my-3");
            $("#dodajOpis").html("Unesite opis.");
            greske++;
        }

        if(slika != undefined){
            if(opisSlike == ""){
                $("#opisSlika").addClass("alert alert-danger my-3");
                $("#opisSlika").html("Dodajte opis slike.");
                greske++;
            }
            data.append("slika", slika);
            data.append("opisSlike", opisSlike);
        }

        data.append("podnaslov", naslov);
        data.append("opis", opis);
        data.append("id", idBlog);
        if(greske == 0){
            ajaxCallBackFormData("models/admin/dodaj-podnaslov.php", "post", data, function(result){
                if(result.poruka == "uspeh"){
                    $("#poruka").html("<p class='alert alert-success'>Uspešno ste dodali podnaslov!</p><a href='index.php?page=dodaj-podnaslov' class='btn btn-secondary'>Dodaj podnaslov</a>")
                }
                else{
                    $("#poruka").html("<p class='alert alert-danger'>" + result.poruka + "</p>");
                }
            });
        }
    })

    // ******** BRISANJE KOMENTARA ********
    $(".deleteComm").on('click', function(){
        idKom = $(this).attr("data-id");

        data  = {idKom : idKom};

        ajaxCallBack("models/admin/obrisi-komentar.php", "post", data, function(result){
            console.log(result);
            if(result.poruka == 'uspeh'){
                location.reload();
            }
        })
    })    

})