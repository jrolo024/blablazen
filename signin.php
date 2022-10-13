<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <!-- Title -->
    <title>BlaBlaZen</title>
  
    <!-- CSS Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css"
      integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="/src/logo.png"/>
  
    <!-- JS Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"
      integrity="sha256-x3YZWtRjM8bJqf48dFAv/qmgL68SI4jqNWeSLMZaMGA=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>

  </head>
  <body>
    <!-- header -->
    <header>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="background-color: #4A4444;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="addtravel.php">Proposer un voyage</a>
            </li>
          </ul>
        </div>
        <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarTogglerDemo01">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="login.php">Log In</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signin.php">Sign In</a>
            </li>
          </ul>
        </div>
        <!-- affichage de la barre de recherche de façon responsive en version mobile -->
        <script>
          document.getElementsByClassName('navbar-toggler')[0].addEventListener('click', function(){
            if(document.getElementById('navbarTogglerDemo02').style.display == "none"){
              document.getElementById('navbarTogglerDemo02').style.display = "block";
              document.getElementById('navbarTogglerDemo01').style.display = "block";
            }else{
              document.getElementById('navbarTogglerDemo02').style.display = "none";
              document.getElementById('navbarTogglerDemo01').style.display = "none";
            }
          });
        </script>
      </nav>
    </header></br>
    
    <!-- corps de la page -->
      <h1 style="color: #7E3636;text-align:center;">Sign In</h1>
      <div class="row h-100 justify-content-center align-items-center">
        <div class="mx-auto">
          <div class="card text-white  mb-3" style="max-width: 40rem; background-color: #494747;">
            <div class="card-body">
              <p class="card-text">
                <form>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                          Username : 
                      </div>
                    </div>
                    <input type="text" class="form-control" name="user" id="user" >
                  </div>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Password :
                      </div>
                    </div>
                    <input name="pwd" type="password"  class="form-control" id="password"/>
                  </div></br>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                          Confirm Password :
                      </div>
                    </div>
                    <input name="pwd2" type="password"  class="form-control" id="confpwd"/>
                  </div></br>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Numéro de téléphone :
                      </div>
                    </div>
                    <input name="numtel" type="number" class="form-control" id="numtel"/>
                  </div></br>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Nom :
                      </div>
                    </div>
                    <input name="name" type="text"  class="form-control" id="nom"/>
                  </div></br>
                      
                  <button type="reset" class="btn btn-secondary">Supprimer</button>
                  <button type="button"  id="sign" class="btn btn-danger">S'inscrire</button>

                </form></br>
              <img src="src/signin.png" style="max-width: 70px; height:70px; display: block; margin-left: auto;margin-right: auto ;" alt="logo connexion">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- affichage des erreurs -->
    <?php
      if (isset($_GET["error1"])){ ?>
        <div class="card">
          <div class="card-body">
            Mots de passe différents !
          </div>
        </div>
      <?php }
        if (isset($_GET["error2"])){ ?>
          <div class="card">
            <div class="card-body">
            Tous les champs n'ont pas été remplis
            </div>
          </div>
        <?php }
      if (isset($_GET["error3"])){ ?>
        <div class="card">
          <div class="card-body">
            Il y a un problème dans le numéro de téléphone ou vous êtes déjà inscrit
          </div>
        </div>
      <?php }
      ?>

    <!-- footer -->
    <footer class="footer mt-auto py-3 bg-light">
      <div class="container" style="text-align:center;">
          <img src="src/logo.png" height="20" width="22"><span class="text-muted"> BlaBlaZen, 2021 © developed by Jessica Rolo and Valentin Baudon</span>
      </div>
    </footer>

    <script src="js/ajax.js" ></script>
    <script src="js/trajet.js" ></script>
  </body>
</html>