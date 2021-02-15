<h2>Données des membres</h2>
<button type = "button" class = "btn btn btn-primary font-weight-bold" title = "Créer un nouveau membre" onclick="toggle_hide_show()">Nouveau membre</button>
<div class = "row mt-3">
    <div class = "col-lg-12" id = "form_reunion" style = "display:none;">
        <form method = "post" action = "../php/nouveau_membre.php">
            <fieldset>
            <legend class="scheduler-border">Nouveau membre</legend>
            <div class="form-group">
			    <label class="col-md-3 control-label">Nom</label>
					<div class="col-md-9">
					    <input name="name" type="text" placeholder="Nom" class="form-control" required>
					</div>
			</div>
			<!--surname input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Prenom</label>
                <div class="col-md-9">
                    <input name="surname" type="text" placeholder="Prenom" class="form-control" required>
                </div>
            </div>
            <!-- Email input-->
            <div class="form-group">
                <label class="col-md-3 control-label">E-mail</label>
                <div class="col-md-9">
                    <input name="email" type="text" placeholder="example@gmail.com" class="form-control" required>
                </div>
            </div>
            <!-- Telephone input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Telephone</label>
                <div class="col-md-9">
                    <input name="telephone" type="text" placeholder="Telephone" class="form-control" required>
                </div>
            </div>
            <!--password input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Mot de passe</label>
                <div class="col-md-9">
                    <input name="mdp" type="password" placeholder="Mot de passe" class="form-control" required>
                </div>
            </div>
            <!-- Date de naissance input -->
            <div class="form-group">
                <label class="col-md-3 control-label">Date de naissance</label>
                <div class="col-md-9">
                    <input name="date_naissance" type="date" placeholder="Date de naissance" class="form-control" required>
                </div>
            </div>
            <!-- Adresse input-->
            <div class="form-group">
                <label class="col-md-3 control-label">Adresse</label>
                <div class="col-md-9">
                    <input name="adresse" type="text" placeholder="Adresse" class="form-control" required>
                </div>
            </div>
            <!-- Est contribuable input -->
            <div class="form-group">
                <label class="col-md-4 control-label" for = "est_contribuable">Membre contribuable ?</label>
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


<div id = "members_info">
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
                #$sql = "SELECT * FROM membre WHERE annee = $annee";
                $sql = "SELECT * FROM membre";
                $response = $pdd->query($sql);
                $nombre_de_membre = $response->rowCount();
                while($donnees = $response->fetch())
                {
                    $nom = $donnees['Nom'];
                    $prenom = $donnees['Prenom'];
                    $telephone = $donnees['Telephone'];
                    $email = $donnees['Email'];
                    $adresse = $donnees['Adresse'];
                    $id_membre = $donnees['Id_membre'];

                    echo "<tr>";
                        echo "<td><input type = 'text' class='form-control' value = '$prenom' title = '$id_membre' name = 'Prenom' onchange='update_data(this)'></td>";
                        echo "<td><input type = 'text' class='form-control' value = '$nom' title = '$id_membre' name = 'Nom' onchange='update_data(this)'></td>";
                        echo "<td><input type = 'text' class='form-control' value = '$telephone' title = '$id_membre' name = 'Telephone' onchange='update_data(this)'></td>";
                        echo "<td><input type = 'text' class='form-control' value = '$email' title = '$id_membre' name = 'Email' onchange='update_data(this)'></td>";
                        echo "<td><input type = 'text' class='form-control' value = '$adresse' title = '$id_membre' name = 'Adresse' onchange='update_data(this)'></td>";
                    echo "</tr>";
                }
            ?>
    </tbody>
  </table>
  <hr>
  <?php
    echo "<p>Nombre de membres : $nombre_de_membre</p>";
  ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            blockchain: [],
            }
        },
        methods: {
            onCreateWallet: function () {
                // Send Http request to create a new wallet (and return keys)
                var vm = this;
                    
            },
        }  
    })
</script>
<script>
    function update_data(e)
        {
            let value = e.value;
            let id_membre = e.title;
            let column_name = e.name;
            let formdata = new FormData();
            console.log(id_membre);
            formdata.append('id_membre', id_membre);
            console.log(value);
            formdata.append('value', value);
            console.log(column_name);
            formdata.append('column_name', column_name);
            formdata.append('action', 'update');
            fetch('../php/save_donnees_membres.php', {
                method: 'post',
                body: formdata,
            }).then(function(response) {
                console.log(response);
            })
        }
    /*var tabledata = [];
    fetch('../php/donnees_membres.php', {
        method: 'post',
    }).then(function(response) {
        console.log(response);
        return response.json();
    }).then(function(data) {
        for (member in data)
        {
            window.tabledata.push(data[member]);
        }
        console.log((window.tabledata));
        //define table
        var table = new Tabulator("#members_info", {
            data:tabledata, //assign data to table
            layout:"fitColumns", //fit columns to width of table (optional)
            columns:[ //Define Table Columns
                {title:"Nom", field:"Nom", editor:"input"},
                {title:"Prenom", field:"Prenom", editor:"input"},
                {title:"Telephone", field:"Telephone", editor:"input"},
                {title:"Email", field:"Email", editor:"input"},
                {title:"Adresse", field:"Adresse", editor:"input"},
            ],
            rowClick:function(e, row){ //trigger an alert message when the row is clicked
               //alert("Row " + row.getData().Email + " Clicked!!!!");
            },
        });
    });*/

    function toggle_hide_show() {
        var formulaire = document.getElementById("form_reunion");
        if (formulaire.style.display === "none") {
            formulaire.style.display = "block";
        } else {
            formulaire.style.display = "none";
        }
        }
</script>