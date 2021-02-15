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
    $response = $pdd->query('SELECT FORMAT(SUM(achat.Montant), 2) AS total_amount, achat.Id_acheteur AS id, membre.Nom AS member_name, membre.Prenom AS member_surname, membre.Est_contribuable
                                            FROM achat
                                            RIGHT JOIN membre
                                            ON achat.Id_acheteur = membre.Id_membre
                                            GROUP BY membre.Id_membre
                                            HAVING membre.Est_contribuable = "Y"');
    print_r($response->fetchAll());
    ?>