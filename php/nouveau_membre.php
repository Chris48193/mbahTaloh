
<!--
----------------------------------
- Filename: nouveau_membre.php
- Author: Christopher Yepmo
- Date: 21-08-2020
- Description: Page php de traitement de l'inscription
----------------------------------
--><!-- Démarrage de la session -->
<?php
    session_start();

    function count_results($response)
    {
        $entries = 0;
        while ($response->fetch())
        {
            $entries+=1;
        }
        return $entries;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $error = "";
    #if (!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['email']) || !isset($_POST['mdp']) || !isset($_POST['telephone']) || !isset($_POST['date_naissance']) || !isset($_POST['adresse']))
    #{
        #$error = "Vérifiez vos entrées s'il vous plait. Certaines ne sont pas valides";
        #header("Location:../html/create_account.php?error=$error");
    #}
    #else
    #{
        $name = trim(htmlspecialchars($_POST['name']));
        $surname = trim(htmlspecialchars($_POST['surname']));
        $email = trim(htmlspecialchars($_POST['email']));
        $mdp = trim(htmlspecialchars($_POST['mdp']));
        $telephone = trim(htmlspecialchars($_POST['telephone']));
        $date_naissance = trim(htmlspecialchars($_POST['date_naissance']));
        $adresse = trim(htmlspecialchars($_POST['adresse']));
        $est_contribuable = trim(htmlspecialchars($_POST['est_contribuable']));
        $randomString = generateRandomString();
        $salt = $randomString;


        try
        {
            $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
            $error = "Erreur de connection a la base de données";
            header("Location: ../html/create_account.php?error=$error");
        }

        $req = $pdd->prepare("INSERT INTO membre(Nom, Prenom, Email, Sel, Hashe, Telephone, Date_de_naissance, Adresse) 
                                            VALUES(:nom, :prenom, :email, :sel, :hashe, :telephone, :date_naissance, :adresse)");
        $req->execute(array(
            'nom' => $name,
            'prenom' => $surname,
            'email' => $email,
            'sel' => $salt,
            'hashe' => hash("sha256", $salt.$mdp),
            'telephone' => $telephone,
            'date_naissance' => $date_naissance,
            'adresse' => $adresse,
        ));

        $req = $pdd->prepare("INSERT INTO participer(Id_member, Id_session, Est_contribuable) VALUES('$id', '$annee', '$est_contribuable')");
        #Redirection
        header("Location:../html/administration.php?error=$error&page=donnees_membres");
    #}
?>