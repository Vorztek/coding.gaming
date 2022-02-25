<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:X-Requested-With");

    require "connect.php";
    $req = "SELECT joueur_name FROM joueur";

$jeu = $dbh->query($req);
$json = $jeu->fetchAll(PDO::FETCH_COLUMN);
// tester avec print_r($json); que des résultats sont bien générés

    echo json_encode($json);
        $dbh = null;







?>