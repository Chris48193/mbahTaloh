<?php
session_start();
    try
    {
        $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
	}
	$annee = $_SESSION['session_reunion'];
	echo "<div id = 'annee' title = '$annee' hidden></div>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails achats</title>
	<style>
		#dropArea_factures
		{
			border: dashed #ccc 3px;
			border-radius: 20px;
		}
		#dropArea_factures.highlight
		{
			border-color: purple;
		}
		p
		{
			margin-top: 0;
		}
		.my-form
		{
			margin-bottom: 10px;
		}
		.button
		{
			display: inline-block;
			padding: 10px;
			background: #ccc;
			cursor: pointer;
			border-radius: 5px;
			border: 1px solid #ccc;
		}
		.button:hover
		{
			background: #ddd;
		}
		#fileElem
		{
			display: none;
		}
	</style>
    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../css/index.css" rel="stylesheet">
	<link rel="stylesheet" href="../css/style_fancy.css">
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
				<button type = "button" class = "btn btn-primary font-weight-bold mb-3" title = "Nouvel achat" onclick="toggle_hide_show()">Nouvel achat</button>
				<div class = "row" id = "form_nouvel_achat" style = "display:none;">
					<div class = "col-lg-6">
						<form class="my-form" id = "my-form" action = "">
							<legend>Nouvel achat (Enregistrement juste par une facture et le montant total)</legend>
							<!-- Amount input-->
							<div class="form-group">
								<label class="col-md-3 control-label">Montant total</label>
								<div class="col-md-12">
									<input name="montant_total" id="montant_total" type="text" placeholder="0.00" class="form-control">
								</div>
							</div>
							<div class = "row p-3 flex_box">
								<div id = "dropArea_factures" class = "drop-area px-3">
									<div>
										<h6 class = "m-2">Télécharger la facture ici par glissé déposé ou par selection d'une image dans votre mobile</h6>
										<div class = "flex-box">
											<p class = "text-center my-4">Déposer la facture ici
											<p><input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)" capture>
											<label class="button btn btn-primary font-weight-bold" for="fileElem">Choisir une photo ou un pdf</label>
										</div>
										<progress id = "progress_bar_factures" role="progressbar" class = "progress progress-bar-info progress-bar" aria-valuemax="100" aria-valuemin="0" style="width:100%"></progress>
										<hr>
									</div>
								</div>
							</div>
							<input type = "submit" class = "btn btn-primary">
						</form>
						<div class = "row mt-2">
							<div class = "col-md-12 flex_box">
								<div id="uploads_names_factures" style = "width:30vw;"></div>
							</div>
						</div>
					</div>
					<div class = "col-lg-6">
						<form method = "post" action = "../php/nouveau_achat.php">
							<fieldset>
							<legend class="scheduler-border">Nouvel achat (Fait par <?php echo $nom_acheteur ?> - Enregistrement détaillé)</legend>
							<!--Buyer name input-->
							<div class="form-group">
								<!--<label class="col-md-3 control-label">Acheteur</label>-->
									<div class="col-md-12">
										<select name="acheteur" id="acheteur" class="form-control" required hidden>
										<?php
											$response = $pdd->query('SELECT Id_membre, Nom, Prenom FROM membre');
											while($donnees = $response->fetch())
											{
												$nom = $donnees['Prenom'].' '.$donnees['Nom'];
												$id_membre = $donnees['Id_membre'];
												if ($id_membre == $_GET['id_acheteur']) echo "<option value = \"$id_membre\" selected>$nom</option>";
												else echo "<option value = \"$id_membre\">$nom</option>";
											}
										?>
										</select>
									</div>
							</div>
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
			</div>
		</div>
		<div class = "row">
			<div class = "col-lg-12">
				<div id = "achats" style = "overflow:scroll;">
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
			if(isset($_GET['page']))
			{
				$page = $_GET['page'];
				echo "<a href='administration.php?page=$page' class = 'btn btn-primary float-right my-2'>Page précédente</a>";
			}
		?>
	</div>
</div>
			
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script>
	let dropArea = document.getElementById('dropArea_factures');
	let progressBar = document.getElementById('progress_bar_factures');
	let upload_names = document.getElementById('uploads_names_factures');
	let myForm = document.getElementById('my-form');
	let id_membre = document.getElementById('acheteur');
	let annee = document.getElementById('annee').title;
	
	url = '../php/save_bill.php'


	let filesDone = 0;
	let filesToDo = 0;
	let all_files_global = [];

	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, preventDefaults, false)
	});

	['dragenter', 'dragover'].forEach(eventName => {
		dropArea.addEventListener(eventName, highlight, false)
	});

	['dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, unhighlight, false)
	});

	dropArea.addEventListener('drop', handleDrop, false);

	//Function qui gere l'upload de plusieurs fichiers
	function handleFiles(files){
		([...files]).forEach(show_name);
	}

	function show_name(file){
		upload_names.innerHTML += file.name + '<br>';
		all_files_global.push(file);
	}
	//Function d'upload
	myForm.addEventListener('submit', function (e){
		let formData = new FormData;

		preventDefaults(e);
		
		formData.append('montant_total', montant_total.value);
		formData.append('action', 'save_montant_total');
		formData.append('id_membre', id_membre.value);
		formData.append('annee', annee);
		fetch(url, {
			method: 'POST',
			body: formData
			})
			.then((response) => {
				//progressDone();
				console.log(response)
			})
			.catch((error) => {
				console.log(error)
			})
		
		//initializeProgress(all_files_global.length);
		all_files_global.forEach(file => {
			formData.append('file', file);
			formData.append('action', 'save_bill');
			formData.append('id_membre', id_membre.value);
			formData.append('annee', annee);
			fetch(url, {
			method: 'POST',
			body: formData
			})
			.then((response) => {
				//progressDone();
				console.log(response)
			})
			.catch((error) => {
				console.log(error)
			})
		});
		//When a data from a form is appended to this object, the data can be retrieved
		//from php according to the data type. Files are retrieved from the superglobal
		//FILE and text types are retrieved from superglobal POST or GET according to the
		//sending method
		window.location.reload();
	})

	function handleDrop(e) {
		let dt = e.dataTransfer; //used to hold the data that is being dragged during a drag and drop operation.
		let files = dt.files;

		handleFiles(files);
	}

	function highlight(e){
		dropArea.classList.add('highlight')
	}

	function unhighlight(e){
		dropArea.classList.remove('highlight')
	}

	function preventDefaults(e){
		e.preventDefault()
		e.stopPropagation()
	}

	function initializeProgress(numfiles){
		progressBar.value = 0;
		filesDone = 0;
		filesToDo = numfiles;
	}

	function progressDone() {
		filesDone++
		console.log(files_global[filesDone-1].name);
		upload_names.innerHTML += files_global[filesDone-1].name + '<br>';
		progressBar.value = filesDone / filesToDo * 100;
	}

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
            formulaire.style.display = "";
        } else {
            formulaire.style.display = "none";
        }
	}
	
	$(document).ready(function(){
	$(".fancybox").fancybox({
			openEffect: "none",
			closeEffect: "none"
		});
		
		$(".zoom").hover(function(){
			
			$(this).addClass('transition');
		}, function(){
			$(this).removeClass('transition');
		});
	});
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