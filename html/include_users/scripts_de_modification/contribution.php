<?php
session_start();
    #Connexion a la base
	include '../../../config/db_config.php';

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
	$sql = "SELECT * FROM session_reunion WHERE annee = $annee";
	$response = $pdd->query($sql);
	$donnees = $response->fetch();
	$contribution = $donnees['Contribution_par_personne'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
        /* Small devices (landscape phones, 576px and up) */
        html {
            font-size: 0.6rem;
        }
        @media (min-width: 576px) { 
            html {
            font-size: 0.8rem;
        }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) { 
            html {
            font-size: 0.8rem;
        }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) { 
            html {
            font-size: 1rem;
        }
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) { 
            html {
            font-size: 1rem;
        }
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contributions</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="../css/index.css" rel="stylesheet">
</head>
<body>
<div id = "app">
	<div class = "container">
		<div class = "row">
			<div class = "col-lg-12">
					<div class = "header">
						<?php
							$nom_acheteur = $_SESSION['surname'];
							echo "<h3 class='modal-title' id='exampleModalLabel'>Vos contributions</h3>"
						?>
					</div>
					<hr>
					<div class = "row">
						<div class = "col-lg-12">
							<h4>Contributions financieres</h4>
							<?php
							if(isset($_GET['success']) && $_GET['success'] != "") {
								$success = $_GET['success'];
								echo "<div class = 'alert alert-success' role='alert'>$success</div>";
							}
							$id_membre = $_SESSION['id'];
							$annee = $_SESSION['session_reunion'];
							$sql = "SELECT *, FORMAT(SUM(all_achats.Montant), 2) AS total_amount
									FROM (
										SELECT Id_achat, Id_acheteur, annee, Montant FROM achat WHERE achat.annee = $annee
										UNION ALL
										SELECT Id_achat, Id_acheteur, Session_, montant_total FROM achat_avec_facture WHERE achat_avec_facture.Session_ = $annee) AS all_achats
									RIGHT JOIN (SELECT * FROM membre 
												INNER JOIN participer
												ON membre.Id_membre = participer.Id_member) AS membre_session
									ON all_achats.Id_acheteur = membre_session.Id_membre
									WHERE membre_session.Id_membre = '$id_membre'
									GROUP BY all_achats.Id_acheteur";

							$sql2 = "SELECT *, FORMAT(SUM(achats_session.Montant), 2) AS total_amount
									FROM (SELECT * FROM achat WHERE achat.annee = $annee) AS achats_session
									RIGHT JOIN (SELECT * FROM membre 
												INNER JOIN participer
												ON membre.Id_membre = participer.Id_member) AS membre_session
									ON achats_session.Id_acheteur = membre_session.Id_membre
									WHERE membre_session.Id_membre = $id_membre";
								#$sql = "SELECT * FROM membre WHERE Id_membre = $id_membre AND annee = $annee";
								$response = $pdd->query($sql);
								$donnees = $response->fetch();
								$est_contribuable = $donnees['Est_contribuable'];
								$achats = $donnees['total_amount'];
								if ($achats=='') $achats = 0;
								if($est_contribuable == 'N')
								{
									echo "<div class = 'alert alert-info' role='alert'>Vous n'etes pas un participant contribuable</div>";
									echo "<div class = 'alert alert-info' role='alert'>Vous avez fait des achats de $achats €</div>";
									echo "<div class = 'alert alert-info' role='alert'>Vous allez recevoir $achats €</div>";
								}
								elseif($est_contribuable == 'Y')
								{
									$prefinancement = $donnees['Prefinancement'];
									echo "<div class = 'alert alert-info'>Vous avez déja payé $prefinancement € sur $contribution € a payer. Vos achats s'élevent a $achats €</div>";
									$reste = ((float)$contribution - ((float)$prefinancement + (float)$achats));
									if($reste > 0) {
										echo "<a href='' class = 'btn btn-primary'>Payer $reste €</a>";
										echo "<hr>";
									}
									elseif($reste < 0){
										$surplus = abs($reste);
										echo "<div class = 'alert alert-info'>Vous allez recevoir $surplus €</div>";
										echo "<a href='' class = 'btn btn-primary'>Effectuer un payement</a>";
										echo "<hr>";
									}
									elseif($reste == 0){
										$surplus = abs($reste);
										echo "<div class = 'alert alert-info'>Vous n'avez plus rien a payer</div>";
										echo "<a href='' class = 'btn btn-primary'>Effectuer un payement</a>";
										echo "<hr>";
									}
								}
								else
								{
									echo "<div class = 'alert alert-info'>Vous n'etes pas participant de cette session de reunion</div>";
								}
							?>
						</div>
					</div>
					<div class = "row" style = "display:none;">
						<div class = "col-lg-12">
						<h4>Section des contributions par des achats</h4>
						<?php
							if ((isset($_GET['error'])) && $_GET['error'] != '')
							{
								?>
								<div class="alert alert-warning" role="alert"> <?php echo $_GET['error']; ?></div>
								<?php
							}
							elseif ((isset($_GET['success'])) && $_GET['success'] != '')
							{
								?>
								<div class="alert alert-success" role="alert"> <?php echo $_GET['success']; ?></div>
								<?php
							}
						?>
							<button type = "button" class = "btn btn-primary font-weight-bold mb-3" title = "Nouvel achat" onclick="toggle_hide_show()">Ajouter un nouvel achat</button>
							<div class = "row" id = "form_nouvel_achat" style = "display:none;">
								<form method = "post" action = "../../../php/nouveau_achat.php?page=contribution">
									<fieldset>
									<legend class="scheduler-border">Nouvel achat</legend>
									<!--Buyer name input-->
									<!--<div class="form-group">
										<label class="col-md-3 control-label">Acheteur</label>
											<div class="col-md-12">-->
												<?php
														$nom = $_SESSION['surname'].' '.$_SESSION['name'];
														$id_membre = $_SESSION['id'];
														echo "<input name='acheteur' type = 'text' value = '$id_membre' placeholder = 'Nom' class = 'form-control' hidden>"
												?>
											<!--</div>
									</div>-->
									<!--article name input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Article</label>
										<div class="col-md-12">
											<input name="article" type="text" placeholder="Nom de l'article" class="form-control">
										</div>
									</div>
									<!-- store name input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Magasin</label>
										<div class="col-md-12">
											<input name="magasin" type="text" placeholder="Nom du magasin" class="form-control">
										</div>
									</div>
									<!-- unit price input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Prix Unitaire</label>
										<div class="col-md-12">
											<input name="prix_unit" type="text" v-model="prix_unit" v-bind:value="prix_unit" class="form-control">
										</div>
									</div>
									<!-- Quantity input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Quantité</label>
										<div class="col-md-12">
											<input name="quantite" type="text" v-model="quantite" v-bind:value="quantite" placeholder="Quantité" class="form-control">
										</div>
									</div>
									<!-- Amount input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Montant</label>
										<div class="col-md-12">
											<input name="montant" type="text" v-model="montant" v-bind:value="montant" placeholder="montant" class="form-control">
										</div>
									</div>
									<!-- Remark input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Remarque</label>
										<div class="col-md-12">
											<input name="remarque" type="text" placeholder="remarque" class="form-control">
										</div>
									</div>
									<!-- Date of order input-->
									<div class="form-group">
										<label class="col-md-3 control-label">Date</label>
										<div class="col-md-12">
											<input name="date" type="date" placeholder="Date" class="form-control">
										</div>
									</div>
									<!-- Form actions -->
									<div class="form-group">
										<div class="col-md-12 text-right">
											<button type="submit" class="btn btn-primary btn-lg font-weight-bold">Terminé</button>
										</div>
									</div>
									<fieldset>
								</form>
							</div>
						</div>
					<div id = "achats">
					<h5>Détails des achats (Ecrire sur la derniere ligne pour ajouter un article)</h5>
						<table class="table table-striped table-hover">
							<thead>
							<tr>
								<th>Articles</th>
								<th>Magasin</th>
								<th>Unité</th>
								<th>Nombre</th>
								<th>Montant</th>
								<th>Remarque</th>
							</tr>
							</thead>
							<tbody>
								<?php
									$id_membre = $_SESSION['id'];
									$sql = "SELECT * FROM achat WHERE Id_acheteur = $id_membre AND annee = $annee";
									$response = $pdd->query($sql);
									while($donnees = $response->fetch())
									{
										//$nom = $donnees['Prenom'].' '.$donnees['Nom'];
										echo "<tr>";
											$id_achat = $donnees['Id_achat'];
											$article = $donnees['Article'];
											$magasin = $donnees['Magasin'];
											$prix_unit = $donnees['Prix_unitaire'];
											$nombre = $donnees['Nombre'];
											$montant = $donnees['Montant'];
											$remarque = $donnees['Remarque'];
											echo "<td><input type = 'text' class='form-control' value = '$article' title = '$id_achat' name = 'Article' onchange='update_data(this)' id = 'article$id_achat'></td>";
											echo "<td><input type = 'text' class='form-control' value = '$magasin' title = '$id_achat' name = 'Magasin' onchange='update_data(this)' id = 'magasin$id_achat'></td>";
											echo "<td><input type = 'text' class='form-control' value = '$prix_unit' title = '$id_achat' name = 'Prix_unitaire' onchange='update_data(this)' id = 'prix_unitaire$id_achat'></td>";
											echo "<td><input type = 'text' class='form-control' value = '$nombre' title = '$id_achat' name = 'Nombre' onchange='update_data(this)' id = 'nombre$id_achat'></td>";
											echo "<td><input type = 'text' class='form-control' value = '$montant' title = '$id_achat' name = 'Montant' onchange='update_data(this)' id = 'montant$id_achat'></td>";
											echo "<td><input type = 'text' class='form-control' value = '$remarque' title = '$id_achat' name = 'Remarque' onchange='update_data(this)' id = 'remarque$id_achat'></td>";
										echo "</tr>";
									}
									echo "<tr>";
											echo "<td><input type = 'text' class='form-control' title = '$id_membre' name = 'Article' onchange='insert_data(this)'></td>";
											echo "<td><input type = 'text' class='form-control' title = '$id_membre' name = 'Magasin' onchange='insert_data(this)'></td>";
											echo "<td><input type = 'text' class='form-control' title = '$id_membre' name = 'Prix_unitaire' value = '0' onchange='insert_data(this)'></td>";
											echo "<td><input type = 'text' class='form-control' title = '$id_membre' name = 'Nombre' value = '0' onchange='insert_data(this)'></td>";
											echo "<td><input type = 'text' class='form-control' title = '$id_membre' name = 'Montant' value = '0' onchange='insert_data(this)'></td>";
											echo "<td><input type = 'text' class='form-control' title = '$id_membre' name = 'Remarque' onchange='insert_data(this)'></td>";
										echo "</tr>";
								?>
							</tbody>
						</table>
					</div>
				</div>
				<a href="../../../html/mon_compte.php?mon_compte=contribution_et_participation" class = "btn btn-primary float-right">Page précédente</a>
			</div>
		</div>
	</div>
</div>
			
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
	<script>
	function update_data(e)
    {
        let value = e.value;
        let id_article = e.title;
        let column_name = e.name;
		let champ_montant = document.getElementById(('montant'+id_article));
		let champ_prix_unit = document.getElementById(('prix_unitaire'+id_article));
		let champ_quantite = document.getElementById(('nombre'+id_article));
        let formdata = new FormData();
        formdata.append('id_article', id_article);
        formdata.append('value', value);
        formdata.append('column_name', column_name);
        formdata.append('montant', (Number(champ_quantite.value) * Number(champ_prix_unit.value)).toFixed(2));
        formdata.append('action', 'update');
        fetch('../../../php/save_details_achats.php', {
            method: 'post',
            body: formdata,
        }).then(function(response) {
            console.log(response);
			champ_montant.value = (Number(champ_quantite.value) * Number(champ_prix_unit.value)).toFixed(2);
        })
    }
	function insert_data(e)
    {
		let id_acheteur = e.title;
        let value = e.value;
        let name = e.name;
        let formdata = new FormData();
        console.log(value);
        formdata.append('value', value);
        formdata.append('id_acheteur', id_acheteur);
        console.log(name);
        formdata.append('name', name);
        formdata.append('action', 'insert');
        fetch('../../../php/save_details_achats.php', {
            method: 'post',
            body: formdata,
        }).then(function(response) {
            console.log(response);
            window.location.reload();
        })
    }
    function toggle_hide_show() {
        var formulaire = document.getElementById("form_nouvel_achat");
        if (formulaire.style.display === "none") {
            formulaire.style.display = "block";
        } else {
            formulaire.style.display = "none";
        }
        }
	</script>
	<script>
		var app = new Vue({
			el: '#app',
			data: {
				prix_unit: 0,
				quantite: 0,
			},
			methods: {
			
			},
			computed:{
				montant: function(){
					return Number(Number(this.prix_unit) * Number(this.quantite)).toFixed(2);
				}
			}
		})
	</script>
</body>
</html>