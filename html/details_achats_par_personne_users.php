<?php
	session_start();
	function get_current_page_url() {
        #Getting current page url
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $url = "https://";   
        else  
            $url = "http://";   
        // Append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];   
        
        // Append the requested resource location to the URL   
        $url.= $_SERVER['REQUEST_URI'];
        return $url;    
    }
    if (!(isset($_SESSION['login'])))
    {
        $pageUrl = get_current_page_url();
        header("Location: login.php?error=Veillez vous connecter svp&pageUrl=$pageUrl");
    }
    try
    {
        $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails achats</title>

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
							$nom_acheteur = $_GET['nom'];
							echo "<h3 class='modal-title' id='exampleModalLabel'>Détails des achats faits par $nom_acheteur</h3>"
						?>
					</div>
					<hr>
					<div class = "row">
						<?php
							if ((isset($_GET['error'])) && $_GET['error'] != '')
							{
								?>
								<div class="alert alert-warning" role="alert"> <?php echo $_GET['error']; ?></div>
								<?php
							}
						?>
					</div>
					<div id = "achats">
					<h5>Détails des achats</h5>
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
									$annee = $_SESSION['session_reunion'];
									$id_membre = $_GET['id_acheteur'];
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
											echo "<td>$article</td>";
											echo "<td>$magasin</td>";
											echo "<td>$prix_unit</td>";
											echo "<td>$nombre</td>";
											echo "<td>$montant</td>";
											echo "<td>$remarque</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>

					<div class = "row">
						<div class = "col-lg-12">
						<h5>Détails des achats avec facture</h5>
					
							<?php
								$id_membre = $_GET['id_acheteur'];
								$response_achat = $pdd->query("SELECT * FROM achat_avec_facture WHERE Id_acheteur = $id_membre");

							?>
							<div id = "accordion" class = "mt-2 col-lg-12">
								<?php
									if ($response_achat->rowCount() == 0)
									{
										$nom = $_GET['nom'];
										echo "<div>$nom n'a aucun achat par facture</div>";
									}
									else
									{
										while($donnees_achat = $response_achat->fetch())
										{
											$montant_total = $donnees_achat['montant_total'];
											$id_achat = $donnees_achat['Id_achat'];
											$id_acheteur = $donnees_achat['Id_acheteur'];
											$pictures = glob("../uploads/factures/*_$id_achat*");
											?>
												<div class = "card">
													<div class = "card-header" id = "details_reunions">
														<h5 class = "mb-0">
															<button class = "btn btn-link" data-toggle = "collapse" data-target = <?php echo "#".$donnees_achat['Id_achat'] ?> aria-expanded="true" aria-controls="collapseOne">
																<div>
																	<?php
																		echo "Montant total: $montant_total €";
																	?>
																</div>
															</button>
														</h5>
													</div>

													<div id = <?php echo $donnees_achat['Id_achat']; ?> aria-labelledby="details_achats" class = "collapse" data-parent = "#accordion">
														<div class = "card-body">
															<div class = "images mt-2">
																<?php
																	foreach($pictures as $picture){
																	?>
																		<div class="col-lg-3 thumb" style="display:inline-block">
																			<a href = '<?php echo "$picture"; ?>' class = "fancybox" rel = '<?php echo "$id_achat"; ?>'>
																				<img alt="picture" src = '<?php echo "$picture"; ?>' class="img-fluid zoom_pub">
																			</a>
																		</div>
																	<?php
																	}
																?>
															</div>
														</div>
													</div>
												</div>
											<?php
										}
									}
									$response_achat->closeCursor();
								?>
							</div>
						</div>
					</div>
					<?php
							echo "<a href='mon_compte.php?mon_compte=rapports_details_financiers' class = 'btn btn-primary float-right my-2'>Page précédente</a>";
					?>
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
        fetch('../php/save_details_achats.php', {
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
        fetch('../php/save_details_achats.php', {
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