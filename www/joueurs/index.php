<?php

function cropResizeImage($inputImg,$inputName) {
    $destination = "avatar/$inputName";
    $sourceImage = imagecreatefromjpeg($inputImg);
    if($sourceImage == false)
    $sourceImage = imagecreatefromstring(file_get_contents($inputImg));
    $orgWidth = imagesx($sourceImage);
    $orgHeight = imagesy($sourceImage);
    $ref_size = ($orgWidth > $orgHeight) ? $orgHeight : $orgWidth;
    $destImage = imagecreatetruecolor(128,128);
    imagecopyresampled($destImage, $sourceImage, 0, 0, 0, 0, 128, 128, $ref_size, $ref_size);
    imagejpeg($destImage, $destination); // l'image générée est enregistrée dans le répertoire avatar/nom_joueur.jpg
    imagedestroy($sourceImage);
    imagedestroy($destImage);
}

if(isset($_POST['creer'])) {
    print_r($_FILES);
    $pattern = '/^[a-zA-Z0-9]{3,}$/';
    if ( preg_match($pattern,$_POST['joueur']) && ( $_FILES['avatar']['error'] == 0)) {
        require_once "connect.php";
        
        $req = "INSERT INTO joueur VALUES (NULL, ? , ?, NOW())";
        
        $sth = $dbh->prepare($req);
    
        $player_name = trim($_POST['joueur']);
        
        $sth->bindValue(1,$player_name,PDO::PARAM_STR);
        $sth->bindValue(2,"avatar/".strtolower($player_name).".jpg",PDO::PARAM_STR);
        if ( $sth->execute() ){
        echo  "Le joueur <b>" . $player_name . "</b> a bien été ajouté ";
        cropResizeImage($_FILES['avatar']['tmp_name'],strtolower($player_name).".jpg");
        }
       
    }
    else echo "Format incorrect";
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
        .list-players p span, .head-list-players p span{
            flex : 1 1;
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
             <form action="" method="post"enctype="multipart/form-data">
                 <label>Votre avatar</label>
                 <input type="file" name="avatar" value= "">
             <input type="text" name="joueur" class="w-50 p-2">
             <input type="submit" name="creer" value="Créer le joueur" class="mx-2 btn btn-success btn-lg">
             </form>
          </div>
          <hr>
          <div class="row">
            <h2>Afficher tous les joueurs</h2>
             <div class="list-players">
              <p class="head-list-players"><span>Joueur</span><span>Date enregistrement</span><span>Id</span><span>avatar</span></p>
 <?php
$reqall = "SELECT * FROM joueur";
    require_once "connect.php";
    
    foreach($dbh->query($reqall) as $player) {
    
        echo "<p><span>{$player['joueur_name']}</span><span>{$player['joueur_inscription']}</span><span>{$player['joueur_id']}</span>";
        echo '<span><img src="' . $player['joueur_avatar'] . '" alt= "' . $player['joueur_avatar'] . '"></span></p>';
    }
    
    $dbh = null; 


?>
            </div>
            </div>
    </div> 
</body>
</html>







