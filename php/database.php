<?php
  session_start();
  require_once('constants.php');

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  //fonction de connexion à la base de données
  function dbConnect(){
    try{
      $db = new PDO('pgsql:host='.DB_SERVER.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $exception){
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

  //connexion à la base de données
  $db = dbConnect();
  
  //requête de recherche d'un trajet
  function dbRequestTrajet($db, $ville_depart, $ville_arrivee, $date_depart){
    try{
      //gestion d'erreurs de compatibilité dûes à une ou des majuscules
      $villeD = strtolower($ville_depart);
      $villeA = strtolower($ville_arrivee);

      //gestion d'erreurs dûes à une mauvaise date
      $dateDD = new DateTime($date_depart);
      $now = new DateTime("NOW");
      if($dateDD < $now){
        return ["status" => 2];
      }

      //requête sql de recherche d'un trajet
      $request = 'SELECT * FROM trajet WHERE addresse_depart=:addresse_depart and addresse_arrivee=:addresse_arrivee and date_depart >= :date_depart and nb_places > 0';
      $statement = $db->prepare($request);
      $statement->bindParam(':addresse_depart', $villeD, PDO::PARAM_STR, 50);
      $statement->bindParam(':addresse_arrivee', $villeA, PDO::PARAM_STR, 50);
      $statement->bindParam(':date_depart', $date_depart, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $result;

    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return ["status" => 1];
    }
  }

  //fonction de recherche de trajet dont l'utilisateur pris en argument est le conducteur
  function dbRequestTofConducteur($db, $pseudo){
    try{
      //requête sql
      $request = 'SELECT * FROM trajet WHERE pseudo=:pseudo';
      $statement = $db->prepare($request);
      $statement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 50);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $result;

    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
  }

  //fonction de recherche de trajet dont l'utilisateur pris en argument est passsager
  function dbRequestTofPassagers($db, $pseudo){
    try{
      //requête sql
      $request = 'SELECT addresse_depart,addresse_arrivee,date_arrivee,date_depart,nb_places,prix,t.pseudo as pseudoC,r.pseudo,t.id_trajet FROM trajet t, reservation r WHERE t.pseudo!=:pseudo and r.pseudo =:pseudo and r.id_trajet=t.id_trajet ';
      $statement = $db->prepare($request);
      $statement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 50);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $result;
      
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
  }

  //fonction de recherche des informations sur l'utilisateur connecté
  function infosCompte($db){
    try{
      //requête sql
      $statement = $db->prepare('SELECT pseudo, nom, telephone FROM utilisateur WHERE pseudo =:pseudo;');
      $statement->bindParam(':pseudo', $_SESSION["login"], PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      return $result;

    }catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
  }

  //fonction de recherche des informations sur le trajet que l'utilisateur aura choisi 
  function dbChoose($db, $id_trajet, $login){
    try{
      //requête sql
        $statement = $db->prepare('SELECT addresse_depart,addresse_arrivee,date_arrivee,date_depart,nb_places,telephone,nom,r.pseudo FROM trajet t, utilisateur r WHERE t.pseudo=:pseudo and r.pseudo =:pseudo and t.id_trajet=:id_trajet;');
        $statement->bindParam(':id_trajet', $id_trajet, PDO::PARAM_STR);
        $statement->bindParam(':pseudo', $login, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;

    }catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
    }
  }

  //fonction permettant à un utilisateur de s'authentifier
  function Authentification($db, $pseudo, $password){
    if($pseudo != "" && $password!= ""){ //gestion d'erreurs de non complétion de champs de valeurs
      try{
        //requête sql
        $statement = $db->prepare('SELECT password, pseudo FROM utilisateur WHERE pseudo =:pseudo;');
        $statement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
  
        //vérification du mot de passe
        if(password_verify ( $password , $result["password"] )){
          $_SESSION["login"] = $pseudo;
          return ["status" => 0];
        }else{
          return ["status" => 1];
        }
        return $result;

      }catch (PDOException $exception){
          error_log('Request error: '.$exception->getMessage());
          return false;
      }
    }else{
      //envoi du code d'erreur de non complétion de champs de valeurs
      return ["status" => 2];
    }
  }

  //fonction permettant l'ajout d'une réservation pour un trajet par un utilisateur
  function addReservation($db, $pseudo, $id_trajet){
    try{
      //requête sql pour vérifier si ce n'est pas le conducteur qui essaye de réserver le trajet
      $request = 'SELECT pseudo FROM trajet WHERE id_trajet=:id_trajet';
      $statement = $db->prepare($request);
      $statement->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      if($_SESSION["login"] == $result["pseudo"]){ //renvoi d'une erreur si c'est le conducteur qui essaye de réserver le trajet
        return false;
      }

      //requête sql pour vérifier si l'utilisateur n'a pas déja réservé ce trajet avant
      $request2 = 'SELECT count(*) FROM reservation WHERE id_trajet=:id_trajet and pseudo=:pseudo';
      $statement2 = $db->prepare($request2);
      $statement2->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);
      $statement2->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 50);
      $statement2->execute();
      $result2 = $statement2->fetch(PDO::FETCH_ASSOC);

      if($result2["count"] > 0){ //renvoi d'une erreur si l'utilisateur a déja réservé ce trajet avant
        return false;
      }
      
    }
    catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    try{
      //requête sql d'insertion de la réservation
      $request = 'INSERT INTO reservation(id_trajet, pseudo) VALUES(:id_trajet, :pseudo)';
      $statement = $db->prepare($request);
      $statement->bindParam(':id_trajet', $id_trajet, PDO::PARAM_INT);
      $statement->bindParam(':pseudo', $_SESSION["login"], PDO::PARAM_STR, 50);
      $statement->execute();
    
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }

    dbDownNbPlace($db, $id_trajet); // appel de la fonction permettant de décrémenter le nombre de places du trajet
    return true;
  }

  //fonction permettant l'ajout d'un nouveau trajet
  function dbAddTrajet($db, $ville_depart, $ville_arrivee, $nbrplace, $dateD, $dateA, $codepostD, $codepostA, $prix){
    $login=$_SESSION["login"];
    //gestion d'erreurs dûes à une ou des majuscules en valeurs d'entrée
    $villeD = strtolower($ville_depart);
    $villeA = strtolower($ville_arrivee);

    //gestion d'erreurs dûes à une ou des mauvaises dates mises en entrée
    $dateDD = new DateTime($dateD);
    $dateAA = new DateTime($dateA);
    $now = new DateTime("NOW");
    if($dateDD > $dateAA || $dateDD < $now){
      return ["status" => 3];
    }

    $ok = true;//variable permettant de vérifier la présence d'erreurs ou non
    try{
      //requête sql afin de vérifier si la ville n'est pas déjà présente dans la table ville
      $statement1 = $db->prepare('SELECT COUNT(*) FROM ville WHERE ville =:ville;');
      $statement1->bindParam(':ville', $villeD, PDO::PARAM_STR);
      $statement1->execute();
      $result1 = $statement1->fetch(PDO::FETCH_ASSOC);

      if(intval($result1["count"]) == 0 &&  strlen($codepostD) == 5){//gestion d'erreurs dûes à un code postal invalide ou au fait que la ville est déjà présente dans la table ville
        //requête sql d'insertion de la ville de départ dans la table
        $request = 'INSERT INTO ville(addresse, ville, code_postal) VALUES(:addresse, :ville, :codepostale)';
        $statement = $db->prepare($request);
        $statement->bindParam(':addresse', $villeD, PDO::PARAM_STR, 50);
        $statement->bindParam(':ville', $villeD, PDO::PARAM_STR, 50);
        $statement->bindParam(':codepostale', $codepostD, PDO::PARAM_STR, 5);
        $statement->execute();
      }

      if(strlen($codepostD) != 5){ //suite de la gestion d'erreurs dûes à un code postal invalide
        $ok = false;
      } 
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return ["status" => 1];
    }


    try{
      //requête sql afin de vérifier si la ville n'est pas déjà présente dans la table ville
      $statement1 = $db->prepare('SELECT COUNT(ville) FROM ville WHERE ville =:ville;');
      $statement1->bindParam(':ville', $villeA, PDO::PARAM_STR);
      $statement1->execute();
      $result1 = $statement1->fetch(PDO::FETCH_ASSOC);

      if(intval($result1["count"]) == 0 &&  strlen($codepostA) == 5){//gestion d'erreurs dûes à un code postal invalide ou au fait que la ville est déjà présente dans la table ville
        //requête sql d'insertion de la ville d'arrivée dans la table
        $request = 'INSERT INTO ville(addresse, ville, code_postal) VALUES(:addresse, :ville, :codepostale)';
        $statement = $db->prepare($request);
        $statement->bindParam(':addresse', $villeA, PDO::PARAM_STR, 50);
        $statement->bindParam(':ville', $villeA, PDO::PARAM_STR, 50);
        $statement->bindParam(':codepostale', $codepostA, PDO::PARAM_STR, 5);
        $statement->execute();
      }

      if(strlen($codepostA) != 5){//suite de la gestion d'erreurs dûes à un code postal invalide
        $ok = false;
      }
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return ["status" => 1];
    }

    if($ok){//vérification de l'absence d'erreurs
      try{
        //requête sql d'insertion du trajet dans la table trajet
        $request = 'INSERT INTO trajet(pseudo, date_depart, date_arrivee, nb_places, prix, addresse_depart, addresse_arrivee) VALUES(:pseudo, :date_depart, :date_arrivee, :nb_places, :prix, :addresse_depart, :addresse_arrivee)';
        $statement = $db->prepare($request);
        $statement->bindParam(':pseudo', $login, PDO::PARAM_STR, 50);
        $statement->bindParam(':date_depart', $dateD, PDO::PARAM_STR, 50);
        $statement->bindParam(':date_arrivee', $dateA, PDO::PARAM_STR, 50);
        $statement->bindParam(':nb_places', $nbrplace, PDO::PARAM_INT);
        $statement->bindParam(':prix', $prix);
        $statement->bindParam(':addresse_depart', $villeD);
        $statement->bindParam(':addresse_arrivee', $villeA);
        $statement->execute();

      //gestion des différents renvoi de codes d'erreurs
      }catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return ["status" => 1];
      }
      return ["status" => 0];
    }else{
      return ["status" => 2];
    }
  }

  //fonction permettant l'ajout d'un nouvel utilisateur
  function addUser($db, $password, $checkpwd, $pseudo, $name, $number){
    if($password != $checkpwd){ //gestion d'erreur en cas de non concordance entre le mot de passe et le 2eme mot de passe demandé à l'inscription
      return ["status" => 1];
    }
    try{
      //requête sql afin de vérifier si l'utilisateur est déjà présent dans la table utilisateur
      $statement1 = $db->prepare('SELECT COUNT(*) FROM utilisateur WHERE pseudo =:pseudo;');
      $statement1->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
      $statement1->execute();
      $result1 = $statement1->fetch(PDO::FETCH_ASSOC);

      if(intval($result1["count"]) == 0 && strlen($number) == 10 && $number[0] == '0'){//gestion d'erreurs dûes à un numéro de téléphone invalide ou au fait que l'utilisateur est déjà présent dans la table utilisateur
        $password1 = password_hash($password, PASSWORD_DEFAULT); //encryptage du mot de passe

        //requête sql d'insertion de l'utilisateur dans la table utilisateur
        $request = 'INSERT INTO utilisateur(pseudo, nom, password, telephone) VALUES(:pseudo, :nom, :password, :telephone)';
        $statement = $db->prepare($request);
        $statement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $statement->bindParam(':nom', $name, PDO::PARAM_STR);
        $statement->bindParam(':password', $password1, PDO::PARAM_STR);
        $statement->bindParam(':telephone', $number, PDO::PARAM_STR);
        $statement->execute();

        //gestion des différents renvoi de codes d'erreurs
        return ["status" => 0];
      }else{
        return ["status" => 3];
      }
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return ["status" => 2];
    }
  }
  
 //fonction permettant la modification du pseudo de l'utilisateur
  function dbModifyUsername($db, $pseudo){
    try{
      
      //requête sql de modification du pseudo de l'utilisateur
      $request = 'UPDATE utilisateur SET pseudo=:pseudo WHERE pseudo=:ancienPseudo';
      $statement = $db->prepare($request);
      $statement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR, 50);
      $statement->bindParam(':ancienPseudo', $_SESSION["login"], PDO::PARAM_STR, 50);
      $statement->execute();
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    $_SESSION["login"]=$pseudo;
    return true;
  }

 //fonction permettant la décrémentation du nombre de places dans un trajet
  function dbDownNbPlace($db, $id_trajet){
    try{
      //requête sql de récupération du nombre de places initial du trajet
      $statement1 = $db->prepare('SELECT nb_places FROM trajet WHERE id_trajet =:id_trajet;');
      $statement1->bindParam(':id_trajet', $id_trajet, PDO::PARAM_STR);
      $statement1->execute();
      $result1 = $statement1->fetch(PDO::FETCH_ASSOC);
      
      if($result1["nb_places"]>0){
        $test=$result1["nb_places"]-1;
        //requête sql décrémentation du nombre de places
        $request = 'UPDATE trajet SET nb_places=:nb_place WHERE id_trajet=:id_trajet';
        $statement = $db->prepare($request);
        $statement->bindParam(':nb_place', $test, PDO::PARAM_STR, 50);
        $statement->bindParam(':id_trajet', $id_trajet, PDO::PARAM_STR);
        $statement->execute();
      }
      else 
        return false;
    }catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
      }
    return true;
  }

   //fonction permettant l'incrémentation du nombre de places dans un trajet
   function dbUpNbPlace($db, $id_trajet){
    try{
      //requête sql de récupération du nombre de places initial du trajet
      $statement1 = $db->prepare('SELECT nb_places FROM trajet WHERE id_trajet =:id_trajet;');
      $statement1->bindParam(':id_trajet', $id_trajet, PDO::PARAM_STR);
      $statement1->execute();
      $result1 = $statement1->fetch(PDO::FETCH_ASSOC);
      
      if($result1["nb_places"]>=0){
        $test=$result1["nb_places"]+1;
        //requête sql pour l'incrémentation du nombre de places
        $request = 'UPDATE trajet SET nb_places=:nb_place WHERE id_trajet=:id_trajet';
        $statement = $db->prepare($request);
        $statement->bindParam(':nb_place', $test, PDO::PARAM_STR, 50);
        $statement->bindParam(':id_trajet', $id_trajet, PDO::PARAM_STR);
        $statement->execute();
      }
      else 
        return false;
    }catch (PDOException $exception){
        error_log('Request error: '.$exception->getMessage());
        return false;
      }
    return true;
  }

  //fonction permettant de supprimer un trajet
  function dbDeleteTrajet($db, $id_trajet){
    try{
      //requête sql permettant de supprimer un trajet
      $request = 'DELETE FROM reservation WHERE id_trajet = :id_trajet';
      $statement = $db->prepare($request);
      $statement->bindParam(':id_trajet', $id_trajet, PDO::PARAM_STR, 50);
      $statement->execute();
    }catch (PDOException $exception){
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    dbUpNbPlace($db, $id_trajet); // appel de la fonction permettant d'incrémenter le nombre de places du trajet
    return true;
  }
?>