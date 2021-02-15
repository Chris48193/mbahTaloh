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

        $sql = "INSERT INTO achat($name) VALUE('$value')";
        echo $sql;
        $req = $pdd->exec($sql);
    }
    if ($_POST['action'] == 'update')
    {
        $id_achat = $_POST['id_achat'];
        $value = $_POST['value'];
        $name = $_POST['name'];
        $sql = "UPDATE achat SET $name = '$value' WHERE Id_achat = $id_achat";
        echo $sql;
        $req = $pdd->exec($sql);
    }
?>