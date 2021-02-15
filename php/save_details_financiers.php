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