<?php
    session_start();
    $annee = $_SESSION['session_reunion'];

    $error = "";
    $success = "";
    if (!isset($_POST['article']) || !isset($_POST['acheteur']) || !isset($_POST['magasin']) || !isset($_POST['prix_unit']) || !isset($_POST['quantite']) || !isset($_POST['montant']) || !isset($_POST['remarque']) || !isset($_POST['date']))
    {
        $error = "Vérifiez vos entrées s'il vous plait. Certaines ne sont pas valides";
        header("Location:../html/administration.php?page=liste_achats&error=$error");
        //$url = "../html/administration.php?page=liste_achats&error=$error";
        //echo "<script>window.location.href='$url';</script>";
    }
    else
    {
        $article = trim(htmlspecialchars($_POST['article']));
        $acheteur = trim(htmlspecialchars($_POST['acheteur']));
        $magasin = trim(htmlspecialchars($_POST['magasin']));
        $prix_unit = trim(htmlspecialchars($_POST['prix_unit']));
        $quantite = trim(htmlspecialchars($_POST['quantite']));
        $montant = trim(htmlspecialchars($_POST['montant']));
        $remarque = trim(htmlspecialchars($_POST['remarque']));
        $date = trim(htmlspecialchars($_POST['date']));


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
            header("Location:../html/administration.php?page=liste_achats&error=$error");
            //$url = "../html/administration.php?page=liste_achats&error=$error";
            //echo "<script>window.location.href='$url';</script>";
            #die('Erreur : ' . $e->getMessage());
        }

        $req = $pdd->prepare("INSERT INTO achat(annee, Id_acheteur, Article, Magasin, Prix_unitaire, Nombre, Montant, Remarque, Date_achat) 
                                            VALUES(:annee, :Id_acheteur, :Article, :Magasin, :Prix_unitaire, :Nombre, :Montant, :Remarque, :Date_achat)");
        $req->execute(array(
            'annee' => $annee,
            'Id_acheteur' => $acheteur,
            'Article' => $article,
            'Magasin' => $magasin,
            'Prix_unitaire' => $prix_unit,
            'Nombre' => $quantite,
            'Montant' => $montant,
            'Remarque' => $remarque,
            'Date_achat' => $date,
        ));
        #Redirection
        if(isset($_GET['page'])){
            $success = "L'article a été bien ajouté";
            if($_GET['page'] == "contribution"){
                header("Location:../html/include_users/scripts_de_modification/contribution.php?error=$error&success=$success");
                //$url = "../html/include_users/scripts_de_modification/contribution.php?error=$error&success=$success";
                //echo "<script>window.location.href='$url';</script>";
            }
        }
        else{
            header("Location:../html/administration.php?error=$error&page=liste_achats");
            //$url = "../html/administration.php?error=$error&page=liste_achats";
            //echo "<script>window.location.href='$url';</script>";
        }
    }
?>