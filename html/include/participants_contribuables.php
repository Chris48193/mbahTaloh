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
    $session_reunion = $_SESSION['session_reunion'];
    $response = $pdd->query("SELECT Contribution_par_personne FROM session_reunion WHERE annee = $session_reunion");
                    while($donnees = $response->fetch())
                    {
                        $check = $donnees['Contribution_par_personne'];
                    }
?>
<h2>Détails financiers des participants contribuables</h2>
<div id = "participants_contribuable" style = "overflow:scroll;">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Prenom</th>
            <th>Achats(€)</th>
            <th>Préfinancement(€)</th>
            <th>Motif</th>
            <th>Check</th>
            <th>Comptes ouverts (À payer)(€)</th>
            <th>Comptes ouverts (surplus)(€)</th>
        </tr>
        </thead>
        <tbody>
                <?php
                echo "<datalist id='acheteurs'>";
                    $response = $pdd->query("SELECT Id_membre, Prenom FROM membre ORDER BY Id_membre ASC");
                    echo "<option value = 'Aucun'></option>";
                    while($donnees = $response->fetch())
                    {
                        $id_membre = $donnees['Id_membre'];
                        $prenom = $donnees['Prenom'];
                        echo "<option value = '$id_membre'>$prenom</option>";
                    }
                echo "</datalist>";
                $annee = $_SESSION['session_reunion'];
                /*$sql = "SELECT FORMAT(SUM(achat.Montant), 2) AS total_amount, 
                achat.Id_acheteur AS id, 
                achat.annee AS annee, 
                membre.Nom AS member_name, 
                membre.Prenom AS member_surname, 
                membre.Est_contribuable, 
                membre.Id_membre,
                membre.Prefinancement, 
                membre.Motif
                        FROM achat
                        RIGHT JOIN membre
                        ON achat.Id_acheteur = membre.Id_membre
                        WHERE achat.annee = '$annee'
                        GROUP BY membre.Id_membre
                        HAVING membre.Est_contribuable = 'Y'
                        ORDER BY FORMAT(SUM(achat.Montant), 2) DESC";*/
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
                #print_r($response->fetchAll());
                    while($donnees = $response->fetch())
                    {
                        echo "<tr>";
                            //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                            $achats = $donnees['total_amount'];
                            $name = $donnees['Prenom'];
                            $id_acheteur = $donnees['Id_acheteur'];
                            $id_membre = $donnees['Id_membre'];
                            $prefinancement = $donnees['Prefinancement'];
                            $motif = $donnees['Motif'];
                            $compte_ouvert = $check - ($prefinancement+$achats);
                            if ($compte_ouvert > 0) {
                                $a_payer = $compte_ouvert;
                                $surplus = 0;
                            }
                            else{
                                $a_payer = 0;
                                $surplus = $compte_ouvert;
                            }
                            echo "<th><a href='details_achats_par_personne.php?id_acheteur=$id_membre&nom=$name&page=participants_contribuables'>$name</a></th>";
                            if ($achats != '') echo "<th>$achats</th>";
                            else echo "<th>0</th>";
                            echo "<th><input type = 'text' class='form-control' value = '$prefinancement' title = '$id_membre' name = 'Prefinancement' onchange='update_data(this, $annee)'></th>";
                            echo "<th><input type = 'text' class='form-control' value = '$motif' title = '$id_membre' name = 'Motif' onchange='update_data(this, $annee)'></th>";
                            echo "<th style = 'color:'>$check</th>";
                            echo "<th style = 'color:green'>$a_payer</th>";
                            echo "<th style = 'color:red'>$surplus</th>";
                        echo "</tr>";
                    }
                ?>
        </tbody>
    </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            test: [],
            }
        },
        methods: {
            onTest: function () {
                var vm = this;
                    
            },
        }  
    })
</script>
<script>
    function update_data(e, annee)
    {
        let value = e.value;
        let id_membre = e.title;
        const column_name = e.name;
        let formdata = new FormData();
        console.log(id_membre);
        formdata.append('id_membre', id_membre);
        console.log(value);
        formdata.append('value', value);
        console.log(column_name);
        formdata.append('column_name', column_name);
        formdata.append('annee', annee);
        formdata.append('action', 'update');
        fetch('../php/save_details_financiers.php', {
            method: 'post',
            body: formdata,
        }).then(function(response) {
            console.log(response);
            window.location.reload();
        })
    }

    function toggle_hide_show() {
        var formulaire = document.getElementById("form_nouvel_article");
        if (formulaire.style.display === "none") {
            formulaire.style.display = "block";
        } else {
            formulaire.style.display = "none";
        }
    }
  </script>
</script>