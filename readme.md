# BlaBlaZen

BlaBlaZen est le nom que nous avons choisi pour ce site de covoiturage entre les sites de l'ISEN et d'autres villes.


## Installation

Pour installer le site, vous allez avoir besoin d'une base de données PostgreSQL et d'un serveur Apache.

Il vous faudra également changer les valeurs dans le fichier ```php/constants.php``` selon votre configuration :

```
<?php
  define('DB_USER', 'postgres');
  define('DB_PASSWORD', 'Isen44N');
  define('DB_NAME', 'voyage');
  define('DB_SERVER', 'localhost');
  define('DB_PORT', '5432');
?>
```

Pour ce qui est de la base de données, il vous faudra exécuter le fichier ```sql/bddfin.sql``` afin de pouvoir créer les différentes tables utiles par la suite.

## Informations pour la manipulation du site

L'adresse ip du site était : 35.195.175.100 mais la VM est fermée maintenant donc ouverture possible en localhost 

Voici un exemple d'un utilisateur déjà présent dans la base de données avec des réservations et des propositions de trajets déjà implémentés au préalable :

```
Username : nono

password : nono
```

## Répartition des fichiers et informations complémentaires

les fichiers php liés au traitement des données sont dans un dossier php. 

les fichiers js liés aux requêtes ajax sont dans un dossier js. 

le fichier sql contenant l'écriture de la base de données ainsi que les fichiers de MPD et de MCD sont dans un dossier sql.

les fichiers du type images sont contenus dans le dossier src.

Concernant les insertions manuelles présentes dans le fichier bddfin.sql, les 3 insertions manuelles fonctionnent quand la base de données est vide. Pour faire fonctionner cette dernière, il vous suffira de vider la base de donner puis enlever les commentaires.
