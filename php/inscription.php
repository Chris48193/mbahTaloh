
<!--
----------------------------------
- Filename: inscription.php
- Author: Christopher Yepmo
- Date: 21-08-2020
- Description: Page php de traitement de l'inscription
----------------------------------
--><!-- Démarrage de la session -->
<?php
    session_start();

    $error = "";
    if (isset($_COOKIE['name'])){

        $name = $_COOKIE['name'];
        $surname = $_COOKIE['surname'];
        $email = $_COOKIE['email'];
        $telephone = $_COOKIE['telephone'];
        $date_naissance = $_COOKIE['date_naissance'];
        $adresse = $_COOKIE['adresse'];
        $salt = $_COOKIE['salt'];
        $hashe = $_COOKIE['hashe'];
        #$est_contribuable = trim(htmlspecialchars($_POST['est_contribuable']));

        #supression des cookies
        setcookie('name', $name, 5);
        setcookie('surname', $surname, 5);
        setcookie('email', $email, 5);
        setcookie('salt', $salt, 5);
        setcookie('hashe', $hashe, 5);
        setcookie('telephone', $telephone, 5);
        setcookie('date_naissance', $date_naissance, 5);
        setcookie('adresse', $adresse, 5);


        try
        {
            $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        }
        catch (Exception $e)
        {
            #die('Erreur : ' . $e->getMessage());
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
            'hashe' => $hashe,
            'telephone' => $telephone,
            'date_naissance' => $date_naissance,
            'adresse' => $adresse,
        ));

                
        #Définition des variables de sessions
        $_SESSION['login'] = TRUE;
        $_SESSION['surname'] = $surname;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $donnees['Id_membre'];
        header("Location:../html/acceuil_login.php#signup?error=$error");
    }
    else
    {
        header("Location:../html/page_lien_confirmation_expired.html");
    }
?>