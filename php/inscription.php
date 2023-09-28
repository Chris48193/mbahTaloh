<?php session_start();
#<!--
#----------------------------------
#- Filename: inscription.php
#- Author: Christopher Yepmo
#- Date: 21-08-2020
#- Description: Page php de traitement de l'inscription
#----------------------------------
#--><!-- Démarrage de la session -->

    $error = "";

    /**
     * fonction de comptage du nombre d'entrées d'une réponse sql
     * @param $response réponse d'une requete sql
     * @return int $entries Nombre d'éléments retournés par la réponse
     **/
    function count_results($response)
    {
        $entries = 0;
        while ($response->fetch())
        {
            $entries+=1;
        }
        return $entries;
    }

    /**
     * fonction de génération aléatoire de chaine pour salage de mot de passe
     * @param int $length la longueur de la chaine a générer
     * @return string $randomString Chaine aléatoire retournée par la fonction
     **/
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if (!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['email']) || !isset($_POST['mdp']) || !isset($_POST['telephone']) || !isset($_POST['date_naissance']) || !isset($_POST['adresse']))
    {
        $error = "Vérifiez vos entrées s'il vous plait. Certaines ne sont pas valides";
        //header("Location:../html/create_account.php?error=$error");
        $url = "../html/create_account.php?error=$error";
        echo "<script>window.location.href='$url';</script>";
    }

    else
    {
        #Traitement (Enlevement des espaces dans les entrées et prévention contre les injections XML) des données
        $name = trim(htmlspecialchars($_POST['name']));
        $surname = trim(htmlspecialchars($_POST['surname']));
        $email = trim(htmlspecialchars($_POST['email']));
        $mdp = trim(htmlspecialchars($_POST['mdp']));
        $randomString = generateRandomString();
        $salt = $randomString;
        $hashe = hash("sha256", $salt.$mdp);
        $telephone = trim(htmlspecialchars($_POST['telephone']));
        $date_naissance = trim(htmlspecialchars($_POST['date_naissance']));
        $adresse = trim(htmlspecialchars($_POST['adresse']));
        #$est_contribuable = trim(htmlspecialchars($_POST['est_contribuable']));

        #Connexion a la base
        include '../config/db_config.php';
        $pdd = null;
        
        try {
            $pdd = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
            $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        #En cas d'erreur
        catch (Exception $e)
        {
            $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
            //header("Location: ../html/login.php?error=$error");
            $url = "../html/create_account.php?error=$error";
            echo "<script>window.location.href='$url';</script>";
            #die('Erreur : ' . $e->getMessage());
        }
        
        #Verification de la présence du membre dans la base
        $response = $pdd->query('SELECT * FROM membre WHERE Email="'.$email.'"');
        if (count_results($response) == 0) {
            //header("Location:../html/page_confirmation_email.html");
            //$url = "../html/page_confirmation_email.html";
            //echo "<script>window.location.href='$url';</script>";
            try {
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
                $success = "Bienvenue, vous venez de créer votre compte !";
                //header("Location:../html/acceuil_login.php?success=$success");
                $url = "../html/acceuil_login.php?success=$success";
                echo "<script>window.location.href='$url';</script>";
            } catch(Exception $e) {
                $error = "Une erreur est survenue, veillez réessayer ultérieurement.";
                //header("Location: ../html/login.php?error=$error");
                $url = "../html/create_account.php?error=$error";
                echo "<script>window.location.href='$url';</script>";
            } 
            $error = "Une erreur est survenue, veillez réessayer ultérieurement.";
            //header("Location: ../html/login.php?error=$error");
            $url = "../html/create_account.php?error=$error";
            echo "<script>window.location.href='$url';</script>";
        }

        else
        {
            $error = "Un compte avec cet E-mail existe déja. Veillez vous connecter";
            //header("Location: ../html/login.php?error=$error");
            $url = "../html/login.php?error=$error";
            echo "<script>window.location.href='$url';</script>";
        }
    }
?>