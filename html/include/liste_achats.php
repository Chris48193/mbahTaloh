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
	echo "<div id = 'annee' title = '$annee' hidden></div>";
?>
<hr>
<h2>Liste des achats</h2>
<button type = "button" class = "btn btn btn-primary font-weight-bold" title = "Nouvel achat" onclick="toggle_hide_show()">Nouvel achat</button>

<div class = "row mt-3" id = "form_nouvel_achat" style = "display:none;">
    <div class = "col-lg-6">
        <form class="my-form" id = "my-form" action = "">
            <legend>Nouvel achat (Enregistrement juste par une facture et le montant total)</legend>
            <div class="form-group">
			    <label class="col-md-3 control-label">Acheteur</label>
					<div class="col-md-12">
					    <select name="acheteur" id="acheteur" class="form-control" required>
                        <?php
                            $response = $pdd->query('SELECT Id_membre, Nom, Prenom FROM membre');
                            while($donnees = $response->fetch())
                            {
                                $nom = $donnees['Prenom'].' '.$donnees['Nom'];
                                $id_membre = $donnees['Id_membre'];
                                echo "<option value = \"$id_membre\">$nom</option>";
                            }
                        ?>
                        </select>
					</div>
			</div>
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
                            <p><input type="file" id="fileElem" multiple accept="image/*" onchange="handleFiles(this.files)">
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
                <div id="uploads_names_factures"></div>
            </div>
        </div>
    </div>
    <div class = "col-lg-6">
        <form method = "post" action = "../php/nouveau_achat.php">
            <fieldset>
            <legend class="scheduler-border">Nouvel achat (Entrée détaillée)</legend>
            <!--Buyer name input-->
            <div class="form-group">
			    <label class="col-md-3 control-label">Acheteur</label>
					<div class="col-md-12">
					    <select name="acheteur" class="form-control" required>
                        <?php
                            $response = $pdd->query('SELECT Id_membre, Nom, Prenom FROM membre');
                            while($donnees = $response->fetch())
                            {
                                $nom = $donnees['Prenom'].' '.$donnees['Nom'];
                                $id_membre = $donnees['Id_membre'];
                                echo "<option value = \"$id_membre\">$nom</option>";
                            }
                        ?>
                        </select>
					</div>
			</div>
			<!--article name input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Article</label>
                <div class="col-md-12">
                    <input name="article" type="text" placeholder="Nom de l'article" class="form-control" required>
                </div>
            </div>
            <!-- store name input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Magasin</label>
                <div class="col-md-12">
                    <input name="magasin" type="text" placeholder="Nom du magasin" class="form-control" required>
                </div>
            </div>
            <!-- unit price input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Prix Unitaire</label>
                <div class="col-md-12">
                    <input name="prix_unit" type="text" placeholder="Ex: 6.5 (Non 6,5)" class="form-control" required>
                </div>
            </div>
            <!-- Quantity input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Quantité</label>
                <div class="col-md-12">
                    <input name="quantite" type="text" placeholder="Quantité" class="form-control" required>
                </div>
            </div>
            <!-- Amount input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Montant</label>
                <div class="col-md-12">
                    <input name="montant" type="text" placeholder="Montant en €" class="form-control" required>
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
                    <input name="date" type="date" placeholder="Date" class="form-control" required>
                </div>
            </div>
            <!-- Form actions -->
            <div class="form-group">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary font-weight-bold">Terminé</button>
                </div>
            </div>
            <fieldset>
        </form>
    </div>
    
</div>
<hr>
<div id = "membres">
<h3>Récapitulatif (Cliquez sur chaque nom pour voir les détails)</h3>
<table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Nom et prenom</th>
        <th>Total des achats</th>
      </tr>
    </thead>
    <tbody>
            <?php
            //Requete dans la table achat
                $annee = $_SESSION['session_reunion'];
                $sql = "SELECT membre.Nom AS member_name, membre.Prenom AS member_surname, Id_achat, Id_acheteur AS id, annee, Montant, FORMAT(SUM(all_achats.Montant), 2) AS total_amount
                        FROM membre
                        RIGHT JOIN(
                            SELECT Id_achat, Id_acheteur, annee, Montant FROM achat WHERE achat.annee = $annee
                            UNION ALL
                            SELECT Id_achat, Id_acheteur, Session_, montant_total FROM achat_avec_facture WHERE achat_avec_facture.Session_ = $annee) AS all_achats
                        ON membre.Id_membre = all_achats.Id_acheteur
                        GROUP BY all_achats.Id_acheteur";
                $response = $pdd->query($sql);
                while($donnees = $response->fetch())
                {
                    echo "<tr>";
                        //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                        $achats = $donnees['total_amount'];
                        $name = $donnees['member_surname']. ' ' . $donnees['member_name'];
                        $id = $donnees['id'];
                        echo "<th><a href='details_achats_par_personne.php?id_acheteur=$id&nom=$name&page=liste_achats'>$name</a></th>";
                        if ($achats != NULL) echo "<th>$achats €</th>";
                        else echo "<th>$achats</th>";
                    echo "</tr>";
                }
            ?>
    </tbody>
  </table>
</div>
<div id = "liste_par_membre"></div>

<script>
    let dropArea = document.getElementById('dropArea_factures');
	let progressBar = document.getElementById('progress_bar_factures');
	let upload_names = document.getElementById('uploads_names_factures');
    let myForm = document.getElementById('my-form');
    let id_membre = document.getElementById('acheteur');
    let annee = document.getElementById('annee').title;
	url = url = '../php/save_bill.php'


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
        //initializeProgress(files.length);
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

    function toggle_hide_show() {
        var formulaire = document.getElementById("form_nouvel_achat");
        if (formulaire.style.display === "none") {
            formulaire.style.display = "";
        } else {
            formulaire.style.display = "none";
        }
        }
</script>






<!-- <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Prenom</th>
        <th>Article</th>
        <th>Magasin</th>
        <th>Unité(€)</th>
        <th>Nombre</th>
        <th>Montant(€)</th>
        <th>Remarque</th>
      </tr>
    </thead>
    <tbody>
            <?php/*
                echo "<datalist id='responsables'>";
                    $response = $pdd->query("SELECT Id_membre, Prenom FROM membre ORDER BY Id_membre ASC");
                    echo "<option value = 'Aucun'></option>";
                    while($donnees = $response->fetch())
                    {
                        $id_membre = $donnees['Id_membre'];
                        $prenom = $donnees['Prenom'];
                        echo "<option value = '$id_membre'>$prenom</option>";
                    }
                echo "</datalist>";
                $response = $pdd->query('SELECT * 
                                        FROM achat
                                        INNER JOIN membre
                                        ON achat.Id_acheteur = membre.Id_membre');
                while($donnees = $response->fetch())
                {
                    $acheteur=$donnees['Prenom'];
                    $article=$donnees['Article'];
                    $magasin=$donnees['Magasin'];
                    $prix_unitaire=$donnees['Prix_unitaire'];
                    $nombre=$donnees['Nombre'];
                    $montant=$donnees['Montant'];
                    $remarque=$donnees['Remarque'];
                    $id=$donnees['Id_achat'];

                    echo "<tr>";
                        echo "<td><input type='text' class='form-control' list='responsables' name='Prenom' value='$acheteur' title='$id' onchange='update_data(this)'></td>";
                        echo "<td><input type='text' class='form-control' name='Article' value='$article' title='$id' onchange='update_data(this)'></td>";
                        echo "<td><input type='text' class='form-control' name='Magasin' value='$magasin' title='$id' onchange='update_data(this)'></td>";
                        echo "<td><input type='text' class='form-control' name='Prix_unitaire' value='$prix_unitaire' title='$id' onchange='update_data(this)'></td>";
                        echo "<td><input type='text' class='form-control' name='Nombre' value='$nombre' title='$id' onchange='update_data(this)'></td>";
                        echo "<td><input type='text' class='form-control' name='Montant' value='$montant' title='$id' onchange='update_data(this)'></td>";
                        echo "<td><input type='text' class='form-control' name='Remarque' value='$remarque' title='$id' onchange='update_data(this)'></td>";
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td><input type='text' class='form-control' list='responsables' name='Prenom' value='' title='' onchange='insert_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Article' value='' title='' onchange='insert_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Magasin' value='' title='' onchange='insert_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Prix_unitaire' value='' title='' onchange='insert_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Nombre' value='' title='' onchange='insert_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Montant' value='' title='' onchange='insert_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Remarque' value='' title='' onchange='insert_data(this)'></td>";
                echo "</tr>"; */
            ?>
    </tbody>
  </table>
</div>
<div id = "liste_par_membre"></div>

<script>
    function update_data(e)
    {
        let value = e.value;
        let id_achat = e.title;
        let name = e.name;
        if (value == "Aucun") {value = ''}
        let formdata = new FormData();
        console.log(id_achat);
        formdata.append('id_achat', id_achat);
        console.log(value);
        formdata.append('value', value);
        console.log(name);
        formdata.append('name', name);
        formdata.append('action', 'update');
        fetch('../php/save_achat.php', {
            method: 'post',
            body: formdata,
        }).then(function(response) {
            console.log(response);
            if (name == "Id_responsable") {window.location.reload();}
        })
    }

    function insert_data(e)
    {
        let value = e.value;
        let name = e.name;
        let formdata = new FormData();
        console.log(value);
        formdata.append('value', value);
        console.log(name);
        formdata.append('name', name);
        formdata.append('action', 'insert');
        fetch('../php/save_achat.php', {
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
</script>-->