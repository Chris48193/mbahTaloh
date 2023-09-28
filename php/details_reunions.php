<?php session_start();
    $annee = $_SESSION['session_reunion'];
    $id = $_SESSION['id'];
    $error = "";
    if (!isset($_POST['arrivee']) || !isset($_POST['debut_location_standard']) || !isset($_POST['fin_location']) || !isset($_POST['nombre_de_nuits']) || !isset($_POST['nombre_de_participants']) || !isset($_POST['nombre_de_contribuables']) || !isset($_POST['contribution_par_personne']) || !isset($_POST['montant_achat']) || !isset($_POST['montant_achat_plus_dons']) || !isset($_POST['montant_location']) || !isset($_POST['depenses_totales']))
    {
        $error = "Vérifiez vos entrées s'il vous plait. Certaines ne sont pas valides";
        header("Location:../html/administration.php?page='details_reunions'&error=$error");
    }
    else
    {
        $arrivee = trim(htmlspecialchars($_POST['arrivee']));
        $debut_location_standard = trim(htmlspecialchars($_POST['debut_location_standard']));
        $fin_location = trim(htmlspecialchars($_POST['fin_location']));
        $nombre_de_nuits = trim(htmlspecialchars($_POST['nombre_de_nuits']));
        $nombre_de_participants = trim(htmlspecialchars($_POST['nombre_de_participants']));
        $nombre_de_contribuables = trim(htmlspecialchars($_POST['nombre_de_contribuables']));
        $contribution_par_personne = trim(htmlspecialchars($_POST['contribution_par_personne']));
        $montant_achat = trim(htmlspecialchars($_POST['montant_achat']));
        $montant_achat_plus_dons = trim(htmlspecialchars($_POST['montant_achat_plus_dons']));
        $montant_location = trim(htmlspecialchars($_POST['montant_location']));
        $depenses_totales = trim(htmlspecialchars($_POST['depenses_totales']));
        $annee = trim(htmlspecialchars($_POST['annee']));

        try
        {
            include '../config/db_config.php';

            $pdd = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
            $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $req = $pdd->prepare("INSERT INTO session_reunion(annee, Arrivee, Debut_location_standard, Fin_location, Nmbr_de_nuit, Nmbr_de_participants, Nmbr_de_contribuables, Contribution_par_personne, Montant_achat, Montant_achat_et_dons, Montant_location, Depenses_totales) 
            VALUES(:annee, :arrivee, :debut_location_standard, :fin_location, :nombre_de_nuits, :nombre_de_participants, :nombre_de_contribuables, :contribution_par_personne, :montant_achat, :montant_achat_plus_dons, :montant_location, :depenses_totales)");
            $req->execute(array(
                'annee' => $annee,
                'arrivee' => $arrivee,
                'debut_location_standard' => $debut_location_standard,
                'fin_location' => $fin_location,
                'nombre_de_nuits' => $nombre_de_nuits,
                'nombre_de_participants' => $nombre_de_participants,
                'nombre_de_contribuables' => $nombre_de_contribuables,
                'contribution_par_personne' => $contribution_par_personne,
                'montant_achat' => $montant_achat,
                'montant_achat_plus_dons' => $montant_achat_plus_dons,
                'montant_location' => $montant_location,
                'depenses_totales' => $depenses_totales,
            ));

            //header("Location:../html/administration.php?page=details_reunions&error=$error");
            $url = "../html/administration.php?page=details_reunions&error=$error";
            echo "<script>window.location.href='$url';</script>";
        }
        catch (Exception $e)
        {
            $error = $e->getMessage();
            //header("Location:../html/administration.php?page=details_reunions&error=$error");
            $url = "../html/administration.php?page=details_reunions&error=$error";
            echo "<script>window.location.href='$url';</script>";
        }
        //header("Location:../html/administration.php?page=details_reunions&error=$error");
        $url = "../html/administration.php?page=details_reunions&error=$error";
        echo "<script>window.location.href='$url';</script>";
    }
?>