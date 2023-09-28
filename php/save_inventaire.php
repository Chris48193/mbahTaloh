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
        //header("Location: ../html/login.php?error=$error");
        $url = "../html/login.php?error=$error";
        echo "<script>window.location.href='$url';</script>";
        #die('Erreur : ' . $e->getMessage());
    }
    if ($_POST['action'] == 'insert')
    {
        $annee = $_POST['annee'];
        $name = $_POST['name'];
        $value = $_POST['value'];

        $sql = "INSERT INTO inventaire($name, annee) VALUE('$value', '$annee')";
        echo $sql;
        $req = $pdd->exec($sql);
    }
    if ($_POST['action'] == 'update')
    {
        $id_inventaire = $_POST['id_inventaire'];
        $value = $_POST['value'];
        $name = $_POST['name'];
        $sql = "UPDATE inventaire SET $name = '$value' WHERE Id_inventaire = $id_inventaire";
        echo $sql;
        $req = $pdd->exec($sql);
    }
?>