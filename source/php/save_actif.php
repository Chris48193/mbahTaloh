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