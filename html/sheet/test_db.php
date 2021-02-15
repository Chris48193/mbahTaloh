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

    $sql = "SELECT membre.Nom AS member_name, membre.Prenom AS member_surname, Id_achat, Id_acheteur, annee, Montant, FORMAT(SUM(all_achats.Montant), 2) AS total_amount
            FROM membre
            RIGHT JOIN(
                SELECT Id_achat, Id_acheteur, annee, Montant FROM achat WHERE achat.annee = 2020
                UNION ALL
                SELECT Id_achat, Id_acheteur, Session_, montant_total FROM achat_avec_facture WHERE achat_avec_facture.Session_ = 2020) AS all_achats
            ON membre.Id_membre = all_achats.Id_acheteur
            GROUP BY all_achats.Id_acheteur";

    $response = $pdd->query($sql);
    echo $response->rowCount();
    $donnees = $response->fetchAll();
    //print_r($donnees);
    foreach($donnees as $donnee){
        print_r($donnee);
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
    }
?>