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
	$id = $_SESSION['id'];
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
    <title>Actifs et inventaires</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="../../../css/index.css" rel="stylesheet">
</head>
<body>
<div id = "app">
	<div class = "container">
		<div class = "row">
			<div class = "col-lg-12">
				<h2>Actifs et Inventaire</h2>
					<h3>Inventaire (Ecrire sur la derniere ligne pour ajouter un article)</h3>
						<table class="table table-striped table-hover mt-3">
						<thead>
							<tr>
							<th>Quantite</th>
							<th>Article</th>
							<th>Lieu</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$response = $pdd->query("SELECT *
														FROM inventaire
														WHERE inventaire.Id_responsable = $id
														ORDER BY inventaire.Id_inventaire ASC");
								$categorie = '"inventaire"';
								while($donnees = $response->fetch())
								{
									echo "<tr>";
										//$nom = $donnees['Prenom'].' '.$donnees['Nom'];
										$quantite = $donnees['Quantite'];
										$article = $donnees['Article'];
										$id_inventaire = $donnees['Id_inventaire'];
										$lieu = $donnees['Lieu'];
										echo "<td><input type='text' class='form-control' name='Quantite' value='$quantite' title='$id_inventaire' onchange='update_data(this,  $categorie)'></td>";
										echo "<td><input type='text' class='form-control' name='Article' value='$article' title='$id_inventaire' onchange='update_data(this, $categorie)'></td>";
										echo "<td><input type='text' class='form-control' name='Lieu' value='$lieu' title='$id_inventaire' onchange='update_data(this, $categorie)'></td>";
									echo "</tr>";
								}
								echo "<tr>";
									echo "<td><input type='text' class='form-control' name='Quantite' onchange='insert_data(this, $annee, $id, $categorie)'></td>";
									echo "<td><input type='text' class='form-control' name='Article' onchange='insert_data(this, $annee, $id, $categorie)'></td>";
									echo "<td><input type='text' class='form-control' name='Lieu' onchange='insert_data(this, $annee, $id, $categorie)'></td>";
								echo "</tr>";
							?>
						</tbody>
					</table>
			</div>
		</div>
		<div class = "row">
			<div class = "col-lg-12">
				<h3>Actifs</h3>
				<table class="table table-striped table-hover mt-3">
						<thead>
							<tr>
							<th>Quantite</th>
							<th>Article</th>
							<th>Lieu</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$response = $pdd->query("SELECT *
														FROM actifs
														WHERE actifs.Id_responsable = $id
														ORDER BY actifs.Id_actif ASC");
								$categorie = '"actifs"';
								while($donnees = $response->fetch())
								{
									echo "<tr>";
										//$nom = $donnees['Prenom'].' '.$donnees['Nom'];
										$quantite = $donnees['Quantite'];
										$article = $donnees['Article'];
										$id_actif = $donnees['Id_actif'];
										$lieu = $donnees['Lieu'];
										echo "<td><input type='text' class='form-control' name='Quantite' value='$quantite' title='$id_actif' onchange='update_data(this, $categorie)'></td>";
										echo "<td><input type='text' class='form-control' name='Article' value='$article' title='$id_actif' onchange='update_data(this, $categorie)'></td>";
										echo "<td><input type='text' class='form-control' name='Lieu' value='$lieu' title='$id_actif' onchange='update_data(this, $categorie)'></td>";
									echo "</tr>";
								}
								echo "<tr>";
									echo "<td><input type='text' class='form-control' name='Quantite' onchange='insert_data(this, $annee, $id, $categorie)'></td>";
									echo "<td><input type='text' class='form-control' name='Article' onchange='insert_data(this, $annee, $id, $categorie)'></td>";
									echo "<td><input type='text' class='form-control' name='Lieu' onchange='insert_data(this, $annee, $id, $categorie)'></td>";
								echo "</tr>";
							?>
						</tbody>
					</table>
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
	function update_data(e, categorie)
    {
        let value = e.value;
        let id_inventaire = e.title;
        let name = e.name;
        if (value == "Aucun") {value = ''}
        let formdata = new FormData();
        console.log(id_inventaire);
        formdata.append('id_inventaire', id_inventaire);
        console.log(value);
        formdata.append('value', value);
        console.log(name);
        formdata.append('name', name);
        formdata.append('categorie', categorie);
        formdata.append('action', 'update');
        fetch('../../../php/save_inventaire_et_actif.php', {
            method: 'post',
            body: formdata,
        }).then(function(response) {
            console.log(response);
            if (name == "Id_responsable") {window.location.reload();}
        })
    }

    function insert_data(e, annee, id, categorie)
    {
        let value = e.value;
        let name = e.name;
        let formdata = new FormData();
        formdata.append('value', value);
        formdata.append('name', name);
        formdata.append('annee', annee);
        formdata.append('categorie', categorie);
        formdata.append('id', id);
        formdata.append('action', 'insert');
        fetch('../../../php/save_inventaire_et_actif.php', {
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
</body>
</html>