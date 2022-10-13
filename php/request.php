<?php
require_once('database.php');
$db = dbConnect();

$type = $_SERVER['REQUEST_METHOD'];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);
parse_str(file_get_contents("php://input"),$post_vars);

switch ($type) {
    //implémentation des différentes fonctions de la methode GET
    case 'GET':
        if(isset($_GET['depart'])){ //permet de lancer la fonction de recherche d'un trajet
            echo json_encode(dbRequestTrajet($db, $_GET['depart'], $_GET['dest'],$_GET['date']));
        }else if(isset($_GET['password'])){ //permet de lancer la fonction d'authentification d'un utilisateur
            echo json_encode(Authentification($db, $_GET['login'], $_GET["password"]));
        }else if(isset($_GET['infosCompte'])){ //permet de lancer la fonction d'obtention des informations sur un utilisateur
            echo json_encode(infosCompte($db));
        }else if(isset($_GET['idtrajet'])){ //permet de lancer la fonction de choix d'un trajet 
            echo json_encode(dbChoose($db,$_GET['idtrajet'],$_GET['log']));
        }else if(isset($_GET['log'])){ //permet de lancer la fonction de recherche des trajets où on est conducteurs
            echo json_encode(dbRequestTofConducteur($db,$_GET['log']));
        }else if(isset($_GET['value'])){ //permet de lancer la fonction d'ajout d'une réservation
            echo json_encode(addReservation($db,$_GET['logi'],$_GET['idtrajett']));
        }else if(isset($_GET['value2'])){ //permet de lancer la fonction de recherche des trajets où on est passagers
            echo json_encode(dbRequestTofPassagers($db,$_GET['loginadd']));
        }
        break;
    
    //implémentation des différentes fonctions de la methode POST
    case 'POST':
        if(isset($_POST["prix"])){ //permet de lancer la fonction d'ajout d'un trajet
             echo json_encode(dbAddTrajet($db, $_POST['vd'], $_POST['va'],$_POST['place'],$_POST['hd'],$_POST['ha'],$_POST['cpd'],$_POST['cpa'],$_POST['prix']));
        }else if (isset($_POST["user"])){ //permet de lancer la fonction d'ajout d'un utilisateur
            echo json_encode(addUser($db,$_POST["pwd"],$_POST["conf"], $_POST["user"],$_POST["nom"], $_POST["num"]));
        }
        break;

    //implémentation des différentes fonctions de la methode PUT
    case 'PUT':
        echo json_encode(dbModifyUsername($db, $post_vars['newlogin']));
        break;

    //implémentation des différentes fonctions de la methode DELETE
    case 'DELETE':
        echo json_encode(dbDeleteTrajet($db, $post_vars['idtrajetdelete']));
        break;
                            
    default:
        break;
}
?>