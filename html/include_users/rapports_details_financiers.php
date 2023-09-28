<h2>Rapports et détails financiers (Cliquer pour voir)</h2>
<hr>
<h4 style="cursor: pointer;" onclick = "toggle_hide_show('detail_reunion')">Détails de la réunion session <?php $annee = $_SESSION['session_reunion']; echo $annee; ?></h4>
<div id = "detail_reunion">
    <?php
    #Connexion a la base
    include '../config/db_config.php';

    try {
        $pdd = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
        $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    #En cas d'erreur
    catch (Exception $e)
    {
        $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
        //header("Location: acceuil_login.php?error=$error");
        $url = "acceuil_login.php?error=$error";
        echo "<script>window.location.href='$url';</script>";
        #die('Erreur : ' . $e->getMessage());
    }
    $annee = $_SESSION['session_reunion'];
    $response_reunion = $pdd->query("SELECT *, YEAR(Arrivee) AS session_year FROM session_reunion WHERE annee = $annee");
    while($donnees_reunion = $response_reunion->fetch())
        {
            ?>
                <ul>
                    <li>Session: <?php echo $donnees_reunion['session_year'] ?></li>
                    <li>Arrivée: <?php echo $donnees_reunion['Arrivee'] ?></li>
                    <li>Debut location standard: <?php echo $donnees_reunion['Debut_location_standard'] ?></li>
                    <li>Fin location: <?php echo $donnees_reunion['Fin_location'] ?></li>
                    <li>Nombre de Nuits: <?php echo $donnees_reunion['Nmbr_de_nuit'] ?></li>
                    <li>Nombre de participants: <?php echo $donnees_reunion['Nmbr_de_participants'] ?></li>
                    <li>Nombre de contribuables: <?php echo $donnees_reunion['Nmbr_de_contribuables'] ?></li>
                    <li>Contribution par personne: <?php echo $donnees_reunion['Contribution_par_personne'] ?></li>
                    <li>Montant achat: <?php echo $donnees_reunion['Montant_achat'] ?></li>
                    <li>Montant achat + Dons: <?php echo $donnees_reunion['Montant_achat_et_dons'] ?></li>
                    <li>Montant Location: <?php echo $donnees_reunion['Montant_location'] ?></li>
                    <li>Depenses totales: <?php echo $donnees_reunion['Depenses_totales'] ?></li>
                </ul>
            <?php
        }
    $response_reunion->closeCursor();
    ?>
</div>

<h4 style="cursor: pointer;" onclick = "toggle_hide_show('donnees_membres')">Données des membres</h4>
<div id = "donnees_membres" style = "overflow:scroll; display: none;">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Prenom</th>
            <th>Nom</th>
            <th>Telephone</th>
            <th>E-mail</th>
            <th>Adresse</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $annee = $_SESSION['session_reunion'];
                $sql = "SELECT * FROM membre ORDER BY Prenom ASC";
                $response = $pdd->query($sql);
                while($donnees = $response->fetch())
                {
                    $nom = $donnees['Nom'];
                    $prenom = $donnees['Prenom'];
                    $telephone = $donnees['Telephone'];
                    $email = $donnees['Email'];
                    $adresse = $donnees['Adresse'];
                    $id_membre = $donnees['Id_membre'];

                    echo "<tr>";
                        echo "<td>$prenom</td>";
                        echo "<td>$nom</td>";
                        echo "<td>$telephone</td>";
                        echo "<td>$email</td>";
                        echo "<td>$adresse</td>";
                    echo "</tr>";
                }
            $response->closeCursor();
            ?>
        </tbody>
    </table>
</div>

<h4 style="cursor: pointer;" onclick = "toggle_hide_show('participants_contribuable')">Détails financiers des participants contribuables</h4>
<div id = "participants_contribuable" style = "overflow:scroll; display: none;">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Prenom</th>
            <th>Achats(€)</th>
            <th>Préfinancement(€)</th>
            <th>Motif</th>
            <th>Check</th>
            <th>À payer(€)</th>
            <th>Surplus(€)</th>
        </tr>
        </thead>
        <tbody>
                <?php
                $session_reunion = $_SESSION['session_reunion'];
                $response = $pdd->query("SELECT Contribution_par_personne FROM session_reunion WHERE annee = $session_reunion");
                                while($donnees = $response->fetch())
                                {
                                    $check = $donnees['Contribution_par_personne'];
                                }

                $annee = $_SESSION['session_reunion'];
                /*$sql1 = "SELECT *, FORMAT(SUM(achats_session.Montant), 2) AS total_amount
                        FROM (SELECT * FROM achat WHERE achat.annee = '$annee') AS achats_session
                        RIGHT OUTER JOIN
                            (SELECT * FROM participer 
                            INNER JOIN membre 
                            ON participer.Id_member = membre.Id_membre
                            WHERE participer.Id_session = '$annee') AS participants_session
                        ON achats_session.Id_acheteur = participants_session.Id_membre
                        GROUP BY participants_session.Id_membre
                        HAVING participants_session.Est_contribuable = 'Y'
                        ORDER BY total_amount DESC";*/
                $sql = "SELECT *, FORMAT(SUM(achats_session.Montant), 2) AS total_amount
                FROM (SELECT Id_achat, Id_acheteur, annee, Montant FROM achat WHERE achat.annee = $annee
                      UNION ALL
                      SELECT Id_achat, Id_acheteur, Session_, montant_total FROM achat_avec_facture WHERE achat_avec_facture.Session_ = $annee) AS achats_session
                RIGHT OUTER JOIN
                    (SELECT * FROM participer 
                    INNER JOIN membre 
                    ON participer.Id_member = membre.Id_membre
                    WHERE participer.Id_session = '$annee') AS participants_session
                ON achats_session.Id_acheteur = participants_session.Id_membre
                GROUP BY participants_session.Id_membre
                HAVING participants_session.Est_contribuable = 'Y'
                ORDER BY total_amount DESC";
                    $response = $pdd->query($sql);
                    while($donnees = $response->fetch())
                    {
                        echo "<tr>";
                            //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                            $achats = $donnees['total_amount'];
                            $name = $donnees['Prenom'];
                            $id = $donnees['Id_acheteur'];
                            $id_membre = $donnees['Id_membre'];
                            $prefinancement = $donnees['Prefinancement'];
                            $motif = $donnees['Motif'];
                            $compte_ouvert = $check - ($prefinancement+$achats);
                            if ($compte_ouvert > 0) {
                                $a_payer = $compte_ouvert;
                                $surplus = 0;
                                $style = "color:red";
                            }
                            else{
                                $a_payer = 0;
                                $surplus = $compte_ouvert;
                                $style = "color:green";
                            }
                            echo "<th><a style='$style' href='details_achats_par_personne_users.php?id_acheteur=$id&nom=$name'>$name</a></th>";
                            if ($achats != '') echo "<td style='$style'>$achats</td>";
                            else echo "<td style='$style'>0</td>";
                            echo "<td style='$style'>$prefinancement</td>";
                            echo "<td style='$style'>$motif</td>";
                            echo "<td style='$style'>$check</td>";
                            echo "<td style='$style'>$a_payer</td>";
                            echo "<td style='$style'>$surplus</td>";
                        echo "</tr>";
                    }
                $response->closeCursor();
                ?>
        </tbody>
    </table>
</div>
<h4 style="cursor: pointer;" onclick = "toggle_hide_show('achats')">Liste des achats</h4>
<div id = "achats" style = "overflow:scroll; display: none;">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Nom et prenom</th>
            <th>Total des achats</th>
        </tr>
        </thead>
        <tbody>
                <?php
                $sql = "SELECT membre.Nom AS member_name, membre.Prenom AS member_surname, Id_achat, Id_acheteur AS id, annee, Montant, FORMAT(SUM(all_achats.Montant), 2) AS total_amount
                        FROM membre
                        RIGHT JOIN(
                            SELECT Id_achat, Id_acheteur, annee, Montant FROM achat WHERE achat.annee = $annee
                            UNION ALL
                            SELECT Id_achat, Id_acheteur, Session_, montant_total FROM achat_avec_facture WHERE achat_avec_facture.Session_ = $annee) AS all_achats
                        ON membre.Id_membre = all_achats.Id_acheteur
                        GROUP BY all_achats.Id_acheteur";
                /*$sql1 = "SELECT FORMAT(SUM(achat.Montant), 2) AS total_amount, achat.Id_acheteur AS id, membre.Nom AS member_name, membre.Prenom AS member_surname
                        FROM membre
                        RIGHT JOIN achat
                        ON membre.Id_membre = achat.Id_acheteur
                        WHERE achat.annee = $annee
                        GROUP BY achat.Id_acheteur";*/
                    $response = $pdd->query($sql);
                    while($donnees = $response->fetch())
                    {
                        echo "<tr>";
                            //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                            $achats = $donnees['total_amount'];
                            $name = $donnees['member_surname']. ' ' . $donnees['member_name'];
                            $id = $donnees['id'];
                            echo "<th><a href='details_achats_par_personne_users.php?id_acheteur=$id&nom=$name'>$name</a></th>";
                            if ($achats != NULL) echo "<th>$achats €</th>";
                            else echo "<th>$achats</th>";
                        echo "</tr>";
                    }
                ?>
        </tbody>
    </table>
</div>
<h4 style="cursor: pointer;" onclick = "toggle_hide_show('inventaire')">Inventaire</h4>
<div id = "inventaire" style = "overflow:scroll; display: none;">
    <table class="table table-striped table-hover mt-3">
        <thead>
        <tr>
            <th>Quantite</th>
            <th>Article</th>
            <th>Responsable</th>
            <th>Lieu</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $response = $pdd->query("SELECT inventaire.Id_inventaire AS id_inventaire, inventaire.Quantite AS quantite, inventaire.Article AS article, inventaire.Lieu AS lieu, membre.Nom AS nom_responsable, membre.Id_membre AS id, membre.Prenom AS prenom_responsable, membre.Id_membre AS id_membre
                                        FROM membre
                                        RIGHT JOIN inventaire
                                        ON membre.Id_membre = inventaire.Id_responsable
                                        ORDER BY inventaire.Id_inventaire ASC");
                while($donnees = $response->fetch())
                {
                    echo "<tr>";
                        //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                        $quantite = $donnees['quantite'];
                        $responsable = $donnees['prenom_responsable'];
                        $article = $donnees['article'];
                        $id_inventaire = $donnees['id_inventaire'];
                        $lieu = $donnees['lieu'];
                        echo "<td>$quantite</td>";
                        echo "<td>$article</td>";
                        echo "<td>$responsable</td>";
                        echo "<td>$lieu</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<h4 style="cursor: pointer;" onclick = "toggle_hide_show('actifs')">Actifs</h4>
<div id = "actifs" style = "overflow:scroll; display: none;">
    <table class="table table-striped table-hover mt-3">
        <thead>
        <tr>
            <th>Quantite</th>
            <th>Article</th>
            <th>Responsable</th>
            <th>Lieu</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $annee = $_SESSION['session_reunion'];
                $response = $pdd->query("SELECT actifs.Id_actif AS id_actif, actifs.Quantite AS quantite, actifs.Article AS article, actifs.Lieu AS lieu, membre.Nom AS nom_responsable, membre.Prenom AS prenom_responsable, membre.Id_membre AS id_membre
                                        FROM membre
                                        RIGHT JOIN actifs
                                        ON membre.Id_membre = actifs.Id_responsable
                                        ORDER BY actifs.Id_actif ASC");
                while($donnees = $response->fetch())
                {
                    echo "<tr>";
                        //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                        $quantite = $donnees['quantite'];
                        $responsable = $donnees['prenom_responsable'];
                        $article = $donnees['article'];
                        $id_actif = $donnees['id_actif'];
                        $lieu = $donnees['lieu'];
                        echo "<td>$quantite</td>";
                        echo "<td>$article</td>";
                        echo "<td>$responsable</td>";
                        echo "<td>$lieu</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>