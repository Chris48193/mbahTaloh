<?php
    session_start();
    try
    {
        $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
        header("Location: ../html/mon_compte.php?mon_compte=contribution_et_participation?error=$error");
        #die('Erreur : ' . $e->getMessage());
    }
    if(isset($_GET['value']) && $_GET['value'] == 'Non')
    {
        $_SESSION['confirm_participation'] = 'Non';
        header("Location: ../html/mon_compte.php?mon_compte=contribution_et_participation");
    }
    elseif(isset($_GET['value']) && $_GET['value'] == 'Oui')
    {
        $est_contribuable = $_GET['contribuable'];
        $id = $_SESSION['id'];
        $annee = $_SESSION['session_reunion'];
        $sql = "INSERT INTO participer(Id_session, Id_member, Est_contribuable) VALUE('$annee', '$id', '$est_contribuable')";
        try{
            $req = $pdd->exec($sql);
        }
        catch(Exception $e){
            $error = "Echec d'enregistrement des données dans la base.";
            header("Location: ../html/mon_compte.php?mon_compte=contribution_et_participation?error=$error");
        }
        unset($_SESSION['confirm_participation']);
        header("Location: ../html/mon_compte.php?mon_compte=contribution_et_participation");
    }
?>