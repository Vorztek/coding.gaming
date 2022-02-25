<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:X-Requested-With");

    require "connect.php";
    $req = "SELECT joueur_name, joueur_avatar FROM joueur";

$jeu = $dbh->query($req);
$json = $jeu->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($json);
        $dbh = null;



?>