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