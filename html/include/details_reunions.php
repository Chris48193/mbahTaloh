<h2>Détails des réunions</h2>
<button type = "button" class = "btn btn btn-primary font-weight-bold" title = "Créer une nouvelle session de réunion" onclick="toggle_hide_show()">Nouvelle session</button>
<div class = "row mt-3">
    <div class = "col-lg-12" id = "form_reunion" style = "display:none;">
        <form method = "post" action = "../php/details_reunions.php">
            <fieldset>
            <legend class="scheduler-border">Nouvelle réunion</legend>
                
                <div class = "form-group">
                <label class="col-md-3 control-label" for="annee">Annee* : </label>
					<div class="col-md-9">
					    <input name="annee" type="text" placeholder="Annee de la reunion" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="arrivee">Arrivée* : </label>
					<div class="col-md-9">
					    <input name="arrivee" type="date" placeholder="Date d'arrivée" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="debut_location_standard">Debut location standard* : </label>
					<div class="col-md-9">
					    <input name="debut_location_standard" type="date" placeholder="Debut location standard" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="fin_location">Fin location* : </label>
					<div class="col-md-9">
					    <input name="fin_location" type="date" placeholder="Fin location" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="nombre_de_nuits">Nombre de nuits: </label>
					<div class="col-md-9">
					    <input name="nombre_de_nuits" type="number" placeholder="Nombre de nuits" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="nombre_de_participants">Nombre de participants* : </label>
					<div class="col-md-9">
					    <input name="nombre_de_participants" type="number" placeholder="Nombre de participants" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="depenses_totales">Dépenses totales* : </label>
					<div class="col-md-9">
					    <input name="depenses_totales" type="text" placeholder="Dépenses totales" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="nombre_de_contribuables">Nombre de contribuables* : </label>
					<div class="col-md-9">
					    <input name="nombre_de_contribuables" type="number" placeholder="Nombre de contribuables" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="contribution_par_personne">Contribution par personne : </label>
					<div class="col-md-9">
					    <input name="contribution_par_personne" type="text" placeholder="Contribution par personne" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="montant_achat">Montant achat* : </label>
					<div class="col-md-9">
					    <input name="montant_achat" type="text" placeholder="Montant achat" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="montant_achat_plus_dons">Montant achat plus dons* : </label>
					<div class="col-md-9">
					    <input name="montant_achat_plus_dons" type="text" placeholder="Montant achat plus dons" class="form-control" required>
                    </div>
                </div>

                <div class = "form-group">
                <label class="col-md-3 control-label" for="montant_location">Montant location* : </label>
					<div class="col-md-9">
					    <input name="montant_location" type="text" placeholder="Montant location" class="form-control" required>
                    </div>
                </div>

                
                <!-- Est contribuable input -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for = "est_contribuable">Etes-vous contribuable ?</label>
                    <div class="col-md-9">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name = "est_contribuable" class="form-check-input" value="Y">Oui
                            </label>
                            </div>
                            <div class="form-check">
                            <label class="form-check-label">
                                <input type="radio" name = "est_contribuable" class="form-check-input" value="N">Non
                            </label>
                        </div>
                    </div>
                </div>
            <fieldset>
            <input type = "submit" class = "btn btn-primary">
        </form>
    </div>
</div>

<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$response_reunion = $bdd->query('SELECT * FROM session_reunion');

?>

<div id = "accordion" class = "mt-2">
    <?php
        if ($response_reunion->rowCount() == 0)
        {
    ?>
    <div class = "card">
        <div class = "card-header" id = "details_reunions">
            <h5 class = "mb-0">
                <button class = "btn btn-link" data-toggle = "collapse" data-target = "#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <div>
                        Aucune réunion en cours
                    </div>
                </button>
            </h5>
        </div>

        <div id = "collapseOne" class = "collapse show" aria-labelledby="details_reunions" data-parent = "#accordion">
            <div class = "card-body">
                Aucune information disponible
            </div>
        </div>
    </div>
    <?php
        }
        else
        {
            $response_reunion = $bdd->query('SELECT *, YEAR(Arrivee) AS session_year FROM session_reunion');
            while($donnees_reunion = $response_reunion->fetch())
            {
                $annee = $donnees_reunion['session_year'];
                ?>
                    <div class = "card">
                        <div class = "card-header" id = "details_reunions">
                            <h5 class = "mb-0">
                                <button class = "btn btn-link" data-toggle = "collapse" data-target = <?php echo "#".$donnees_reunion['Id_session'] ?> aria-expanded="true" aria-controls="collapseOne">
                                    <div>
                                        <?php
                                            echo "Session $annee";
                                        ?>
                                    </div>
                                </button>
                            </h5>
                        </div>

                        <div id = <?php echo $donnees_reunion['Id_session']; ?> class = <?php if($_SESSION['session_reunion'] == $annee) {echo "show";} else {echo "collapse";} ?> aria-labelledby="details_reunions" data-parent = "#accordion">
                            <div class = "card-body">
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
                                <!-- <ul>
                                    $arrivee = $donnees_reunion['Arrivee'];
                                    $debut_location_standard = $donnees_reunion['Debut_location_standard'];
                                    $fin_location = $donnees_reunion['Fin_location'];
                                    $nmbre_nuit = $donnees_reunion['Nmbr_de_nuit'];
                                    $nmbre_participants = $donnees_reunion['Nmbr_de_participants'];
                                    $nombre_contribuables = $donnees_reunion['Nmbr_de_contribuables'];
                                    $nombre_contribution_par_personne = $donnees_reunion['Contribution_par_personne'];
                                    $montant_achat =  $donnees_reunion['Montant_achat'];
                                    $montant_achat_et_dons =  $donnees_reunion['Montant_achat_et_dons'];
                                    $montant_location = $donnees_reunion['Montant_location'];
                                    $depenses_totales = $donnees_reunion['Depenses_totales'];?>
                                    <li>Arrivée: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Debut location standard: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Fin location: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Nombre de Nuits: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Nombre de participants: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Nombre de contribuables: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Contribution par personne: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Montant achat: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Montant achat + Dons: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Montant Location: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                    <li>Depenses totales: <?php echo "<input type='text' name='Quantite' onchange='insert_data(this)'>"; ?></li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                <?php
            }
        }
        $response_reunion->closeCursor();
        ?>
</div>

<script>
    function toggle_hide_show() {
        var formulaire = document.getElementById("form_reunion");
        if (formulaire.style.display === "none") {
            formulaire.style.display = "block";
        } else {
            formulaire.style.display = "none";
        }
        }
</script>