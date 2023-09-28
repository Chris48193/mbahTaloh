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
        $name = $_POST['name'];
        $value = $_POST['value'];
        $annee = $_POST['annee'];

        $sql = "INSERT INTO actifs($name, annee) VALUE('$value', '$annee')";
        echo $sql;
        $req = $pdd->exec($sql);
    }
    if ($_POST['action'] == 'update')
    {
        $id_actif = $_POST['id_actif'];
        $value = $_POST['value'];
        $name = $_POST['name'];
        $sql = "UPDATE actifs SET $name = '$value' WHERE Id_actif = $id_actif";
        echo $sql;
        $req = $pdd->exec($sql);
    }
?>