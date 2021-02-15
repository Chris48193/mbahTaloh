<?php
    try
    {
        $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
    
    /*$response = $pdd->query("SELECT * FROM membre WHERE Est_contribuable = 'Y'");
    $donnees = $response->fetchAll();
    echo json_encode($donnees);*/
?>