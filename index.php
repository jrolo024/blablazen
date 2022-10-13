<?php
session_start();
?>
<!DOCTYPE html>
<html>
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            <?php if(isset($_SESSION["login"])){ ?>

            <li class="nav-item">
            <a class="nav-link" href="myaccount.php">Mon profil</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="deconnexion.php">Déconnexion</a>
            </li>

            <?php }else{ ?>
            <li class="nav-item">
            <a class="nav-link" href="login.php">Log In</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="signin.php">Sign In</a>
            </li>
            <?php } ?>
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
      <br><br><h1 style="color: #7E3636;text-align: center;">Voyagez ensemble</h1>
    </header><br><br><br>


    <!-- corps de la page -->
    <section id="errors" class="container alert alert-danger" style="display: none">
    </section>
    
    <div class="container">
      <div class="row">
        <div class="offset-md-1"></div>
        <div class="card text-white" style="background-color: #4A4444;">
          <div class="card-body">
          <form class="row g-5" method="GET" action="searchtravel.php">

              <div class="col-auto">
                <select name="isen" id="depart"class="form-control" >
                    <option disabled selected style="display: none;">A partir d'un ISEN</option>
                    <option>Nantes</option>
                    <option>Brest</option>
                    <option>Rennes</option>
                    <option>Caen</option>
                </select>
              </div>

              <div class="col-auto">
                <input type="text" class="form-control" id="dest" name="destination" placeholder="Destination"/>
              </div>

              <div class="col-auto">
                <input type="datetime-local" class="form-control" id="date" name="date" placeholder="Date et Heure de départ"/>
              </div>
             
              <div class="col-auto">
                <button type="submit" id="search1" class="btn btn-danger">Rechercher</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div><br><br>

    
    <div class="container">
      <div class="row">
        <div class="offset-md-1"></div>
          <div class="card text-white" style="background-color: #4A4444;">
            <div class="card-body">
              <form class="row g-5" method="GET" action="searchtravel.php">

                <div class="col-auto">
                  <input type="text" class="form-control" id="depart1" name="depart1" placeholder="Départ">
                </div>

                <div class="col-auto">
                  <select name="isen" id="dest1" class="form-control" >
                    <option disabled selected style="display: none;">Vers un ISEN</option>
                    <option>Nantes</option>
                    <option>Brest</option>
                    <option>Rennes</option>
                    <option>Caen</option>
                  </select>

                </div>
                <div class="col-auto">
                <input type="datetime-local" class="form-control" id="date1" name="date" placeholder="Date et Heure de départ"/>
                </div>
                
                <div class="col-auto">
                  <button type="submit" id="search2" class="btn btn-danger">Rechercher</button></a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><br><br>

    <div class="container">
      <div class="row">
        <div class="offset-md-2">
        <div class="row g-3">
          <div class="col-auto">
            <img src="src/voyage_voiture.jpg" class="img-fluid" height="120" width="250">
          </div>
       
          <div class="col-auto">
            <img src="src/voyage_voiture2.jpg" class="img-fluid" height="120" width="220">
          </div>
          
          <div class="col-auto">
            <img src="src/voyage_voiture3.jpg" class="img-fluid" height="120" width="220">

          </div>
        </div>
      </div>
    </div><br><br>

    <!-- affichage des erreurs -->
    <?php
      if (isset($_GET["error1"])){ ?>
        <div class="card">
          <div class="card-body">
          Tous les champs n'ont pas été remplis 
          </div>
        </div>
      <?php }
      if (isset($_GET["error2"])){ ?>
        <div class="card">
          <div class="card-body">
            Problèmes de dates !
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
  
    <script src="js/ajax.js" defer></script>
    <script src="js/trajet.js" defer></script>
  </body>
</html>