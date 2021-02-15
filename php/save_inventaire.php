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