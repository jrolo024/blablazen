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
                    <a class="nav-link" href="deconnexion.php">D??connexion</a>
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
            <!-- affichage de la barre de recherche de fa??on responsive en version mobile -->
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
    </header><br>
    
    <!-- corps de la page -->
    <h1 style="color: #7E3636;text-align: center;">Mon compte</h1>
    <div class="container">
        <div class="row">
            <div class="offset-md-4"></div>
            <div class="card text-white" style="background-color: #4A4444;">
                <div class="card-body">
                    <span class="material-icons">account_circle</span>   Username : <span id="username"></span>  <button type="button" id="edit" class="btn btn-secondary" style="background-color: #4A4444;"><span class="material-icons">mode_edit</span></button><br>
                    <span class="material-icons">account_circle</span>   Nom : <span id="name"></span><br>
                    <span class="material-icons">phone</span> Num??ro de t??l??phone : <span id="telephone"></span>
                </div>
            </div>
        </div>
    </div><br>


    <div class="container">
        <div class="row">
            <div class="offset-md-2"></div>
            <div class="col-8">
                <div class="card text-white" style="background-color: #7C4747;">
                    <div class="card-title">
                        <h1 style="text-align: center; margin-top:auto; margin-bottom:auto;">Les voyages que j'ai r??serv??</h1>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div><br><br>


    <div id="addnotmy">
    <div class="container">
        <div class="row">
            <div class="offset-md-1"></div>
            <div class="card bg-dark">
                <div class="card-body">
                    <div class="row mb-3" style="max-height: 10px;">
                        <div class="mx-auto">
                            <p class="text-warning" id="dep">Date de d??part</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Date d'arriv??e</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning" >Heure de d??part</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Heure d'arriv??e</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Nom du conducteur</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Ville de d??part</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Ville d'arriv??e</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Prix</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Supprimer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br><br>
    </div>
          

    <div class="container">
        <div class="row">
            <div class="offset-md-2"></div>
            <div class="col-8">
                <div class="card text-white" style="background-color: #7C4747;">
                    <div class="card-title">
                        <h1 style="text-align: center;margin-top:auto; margin-bottom:auto;">Mes voyages</h1>
                    </div>
                </div>
            </div>
        </div>
    </div><br><br>
    

    <div id="addmy">
    <div class="container">
        <div class="row">
            <div class="offset-md-1"></div>
            <div class="card bg-dark" style="background-color: #B09696;">
                <div class="card-body">
                    <div class="row mb-3" style="max-height: 10px;">
                        <div class="mx-auto">
                            <p class="text-warning">Date de d??part</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Date d'arriv??e</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Heure de d??part</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Heure d'arriv??e</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Nombre de places</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Ville de d??part</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Ville d'arriv??e</p>
                        </div>
                        <div class="col-auto">
                            <p class="text-warning">Prix</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    </div>

    <!-- footer -->
    <footer class="footer mt-auto py-3 bg-light">
      <div class="container" style="text-align:center;">
          <img src="src/logo.png" height="20" width="22"><span class="text-muted"> BlaBlaZen, 2021 ?? developed by Jessica Rolo and Valentin Baudon</span>
      </div>
    </footer>

    <script src="js/ajax.js" ></script>
    <script src="js/trajet.js" ></script>
    </body>
</html>