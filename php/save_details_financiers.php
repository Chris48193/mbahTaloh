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
    if ($_POST['action'] == 'update')
    {
        $id_membre = $_POST['id_membre'];
        $value = $_POST['value'];
        $column_name = $_POST['column_name'];
        $annee = $_POST['annee'];
        $sql = "UPDATE participer SET $column_name = '$value' WHERE Id_member = $id_membre AND Id_session = $annee";
        $req = $pdd->exec($sql);
    }
?>