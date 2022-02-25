<?php
if(isset($_POST['creer'])) {
    $pattern = '/^[a-zA-Z0-9]{3,}$/';
   
    if ( preg_match($pattern,$_POST['joueur']) ) {
    
    require_once "connect.php";
// connexion à la BDD en appelant le fichier de connexion

$req = "INSERT INTO players VALUES (NULL, ? , NOW() )";
// écriture de la requête

$sth = $dbh->prepare($req);
// préparation de la requête

$player_name = trim($_POST['joueur']);
// suppression des espaces superflus

if ( $sth->execute( [$player_name] ) )
echo  "Le joueur <b>" . $player_name . "</b> a bien été ajouté ";
// si l'exécution de la requête est un succès, on affiche un message de confirmation
}
 // CODE A INSERER ICI POUR COMMUNIQUER AVEC LA BDD // on vérifie que le formulaire a bien été cliqué, on vérifie ensuite si le format est bien respecté

 else "Format incorrect";
}
 


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .list-players p {
            display: flex;
            justify-content: space-between;
            padding: 5px;
        }
        .list-players p span {
            flex : 0 0 46%;
        }
        .head-list-players {
            background: #555;
            color: white;
            font-size: 150%;
        }
    </style>
</head>
<body>
    <div class="container">
          <div class="jumbotron bg-light p-3 my-3">      
             <h1>Créer un joueur</h1>
             <form action="" method="post">
             <input type="text" name="joueur" class="w-50 p-2">
             <input type="submit" name="creer" value="Créer le joueur" class="mx-2 btn btn-success btn-lg">
             </form>
          </div>
          <hr>
          <div class="row">
            <h2>Afficher tous les joueurs</h2>
             <div class="list-players">
              <p class="head-list-players"><span>Joueur</span><span>Date enregistrement</span><span>Id</span></p>
              <?php
              $reqall = "SELECT * FROM players";
              require_once "connect.php";
// connection à la BDD
 foreach($dbh->query($reqall) as $player) {
  echo "<p><span>{$player['player_name']}</span><span>{$player['player_register']}</span><span>{$player['player_id']}</span></p>";
 }
// écriture de chaque ligne de résultat à l'aide d'une boucle
$dbh = null; // on clôt la connexion à la BDD
              ?>
             </div>
            </div>
    </div> 
</body>
</html>