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
    function save_file($path)
    {
        if (isset($_FILES['file']) AND $_FILES['file']['error'] == 0)
        {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['file']['size'] <= 10000000)
            {
                global $pdd;
                $response = $pdd->query('SELECT * FROM achat_avec_facture');
                $donnees = $response->fetchAll();
                $ID_ACHAT = $donnees[count($donnees)-1]['Id_achat'];
                $ID_MEMBRE = $_POST['id_membre'];

                $all_files = scandir($path);
                $nombre_de_fichiers = count($all_files)-2;

                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['file']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                $date = new DateTime();
                $timestamp = strval($date->getTimestamp());
                $stored_file_name = $ID_MEMBRE . '_' . $timestamp . '_' . $ID_ACHAT . '_' . $nombre_de_fichiers . '.' . strval($extension_upload);
                if (in_array($extension_upload,  $extensions_autorisees))
                {
                    // On peut valider le fichier et le stocker  définitivement
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $path . $stored_file_name)){
                    print_r(["L'envoi a bien été effectué !"]);
                    }
                    else{
                        print_r(["Echec d'enregistrement' du fichier"]);
                    }
                }
                else{
                    print_r(["Le fichier n'est pas une image ou un document"]);
                }
            }
            else{
                print_r(["Le fichier est trop volumineux"]);
            }
        }
        else{
            print_r(["Echec de l'envoi du fichier"]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] == 'save_bill'){
            save_file('../uploads/factures/');
        }
        if ($_POST['action'] == 'save_montant_total'){
            $montant = floatval($_POST['montant_total']);
            $id_membre = floatval($_POST['id_membre']);
            $annee = floatval($_POST['annee']);
            $sql = "INSERT INTO achat_avec_facture(montant_total, id_acheteur, Session_) VALUE('$montant', '$id_membre', '$annee')";
            $pdd->exec($sql);
        }
    }
?>