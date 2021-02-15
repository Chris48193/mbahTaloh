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
    $annee = $_SESSION['session_reunion'];
?>
<h2>Actifs</h2>
<table class="table table-striped table-hover mt-3">
    <thead>
      <tr>
        <th>Responsable</th>
        <th>Quantite</th>
        <th>Article</th>
        <th>Lieu</th>
      </tr>
    </thead>
    <tbody>
        <?php
            echo "<datalist id='responsables' onclick='bind_respo_lieu(this)'>";
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
            $response = $pdd->query("SELECT *
                                    FROM membre
                                    RIGHT JOIN actifs
                                    ON membre.Id_membre = actifs.Id_responsable
                                    ORDER BY actifs.Id_actif ASC");
            while($donnees = $response->fetch())
            {
                echo "<tr>";
                    //$nom = $donnees['Prenom'].' '.$donnees['Nom'];
                    $quantite = $donnees['Quantite'];
                    $responsable = $donnees['Prenom'];
                    $article = $donnees['Article'];
                    $id_actif = $donnees['Id_actif'];
                    $id_responsable = $donnees['Id_membre'];
                    $lieu = $donnees['Lieu'];
                    $annee = $_SESSION['session_reunion'];
                    echo "<td><input type='text' class='form-control' name='Id_responsable' list = 'responsables' value='$responsable' title='$id_actif' onchange='update_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Quantite' value='$quantite' title='$id_actif' onchange='update_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Article' value='$article' title='$id_actif' onchange='update_data(this)'></td>";
                    echo "<td><input type='text' class='form-control' name='Lieu' value='$lieu' title='$id_actif' onchange='update_data(this)'></td>";
                echo "</tr>";
            }
            echo "<tr>";
                echo "<td><input type='text' class='form-control' name='Id_responsable' list = 'responsables' onchange='insert_data(this, $annee)'></td>";
                echo "<td><input type='text' class='form-control' name='Quantite' onchange='insert_data(this, $annee)'></td>";
                echo "<td><input type='text' class='form-control' name='Article' onchange='insert_data(this, $annee)'></td>";
                echo "<td><input type='text' class='form-control' name='Lieu' onchange='insert_data(this, $annee)'></td>";
            echo "</tr>";
        ?>
    </tbody>
  </table>
  <script>
    function update_data(e)
    {
        let value = e.value;
        let id_actif = e.title;
        let name = e.name;
        if (value == "Aucun") {value = ''}
        let formdata = new FormData();
        console.log(id_actif);
        formdata.append('id_actif', id_actif);
        console.log(value);
        formdata.append('value', value);
        console.log(name);
        formdata.append('name', name);
        formdata.append('action', 'update');
        fetch('../php/save_actif.php', {
            method: 'post',
            body: formdata,
        }).then(function(response) {
            console.log(response);
            if (name == "Id_responsable") {window.location.reload();}
        })
    }

    function insert_data(e, annee)
    {
        let value = e.value;
        let name = e.name;
        let formdata = new FormData();
        console.log(value);
        formdata.append('value', value);
        console.log(name);
        formdata.append('name', name);
        formdata.append('annee', annee);
        formdata.append('action', 'insert');
        fetch('../php/save_actif.php', {
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