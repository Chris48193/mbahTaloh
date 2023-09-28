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
        $id = $_POST['id'];
        $table_name = $_POST['categorie'];

        $sql = "INSERT INTO $table_name($name, annee, Id_responsable) VALUE('$value', '$annee', '$id')";
        echo $sql;
        $req = $pdd->exec($sql);
    }
    if ($_POST['action'] == 'update')
    {
        $value = $_POST['value'];
        $table_name = $_POST['categorie'];
        $name = $_POST['name'];
        if($table_name == "inventaire")
        {
            $id_inventaire = $_POST['id_inventaire'];
            $sql = "UPDATE $table_name SET $name = '$value' WHERE Id_inventaire = $id_inventaire";
        }
        elseif($table_name == "actifs")
        {
            $id_actif = $_POST['id_inventaire'];
            $sql = "UPDATE $table_name SET $name = '$value' WHERE Id_actif = $id_actif";
        }
        echo $sql;
        $req = $pdd->exec($sql);
    }
?>