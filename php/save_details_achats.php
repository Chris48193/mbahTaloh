<?php
    session_start();
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
        //header("Location: ../html/login.php?error=$error");
        $url = "../html/login.php?error=$error";
        echo "<script>window.location.href='$url';</script>";
        #die('Erreur : ' . $e->getMessage());
    }
    $annee = $_SESSION['session_reunion'];
    if ($_POST['action'] == 'insert')
    {
        $id_acheteur = $_POST['id_acheteur'];
        $name = $_POST['name'];
        $value = $_POST['value'];

        $sql = "INSERT INTO achat($name, Id_acheteur, annee) VALUE('$value', '$id_acheteur', '$annee')";
        echo $sql;
        $req = $pdd->exec($sql);
    }
    if ($_POST['action'] == 'update')
    {
        $montant = $_POST['montant'];
        $id_article = $_POST['id_article'];
        $value = $_POST['value'];
        $column_name = $_POST['column_name'];
        $sql = "UPDATE achat SET $column_name = '$value', Montant = '$montant' WHERE Id_achat = $id_article";
        echo $sql;
        $req = $pdd->exec($sql);
    }
?>