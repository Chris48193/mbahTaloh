<?php
try
{
    $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
    $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $e)
{
    #die('Erreur : ' . $e->getMessage());
}

    /**
     * fonction de génération aléatoire de chaine pour salage de mot de passe
     * @param int $length la longueur de la chaine a générer
     * @return string $randomString Chaine aléatoire retournée par la fonction
     **/
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function save_file($path)
    {
        if (isset($_FILES['pictures']) AND $_FILES['pictures']['error'] == 0)
        {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['pictures']['size'] <= 10000000)
            {
                global $pdd;
                $randomString = generateRandomString(5);
                $response = $pdd->query('SELECT * FROM publication');
                $donnees = $response->fetchAll();
                $ID_PUBLICATION = $donnees[count($donnees)-1]['Id_publication'];
                $ID_MEMBRE = $_POST['id_membre'];

                $all_files = scandir($path);
                $nombre_de_fichiers = count($all_files)-2;
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['pictures']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                $date = new DateTime();
                $timestamp = strval($date->getTimestamp());
                $stored_file_name = $ID_MEMBRE . '_' . $randomString . '_' . $timestamp . '_' . $ID_PUBLICATION . '_' . $nombre_de_fichiers . '.' . strval($extension_upload);
                if (in_array($extension_upload,  $extensions_autorisees))
                {
                    // On peut valider le fichier et le stocker  définitivement
                    if (move_uploaded_file($_FILES['pictures']['tmp_name'], $path . $stored_file_name)){
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
        if ($_POST['action'] == 'save_publication_pictures'){
            save_file('../uploads/images_publication/');
        }
        elseif($_POST['action'] == 'save_publication_content'){
            $content = $_POST['content'];
            $id_membre = $_POST['id_membre'];
            $sql = "INSERT INTO publication(Content, Id_publicateur, date_publication) 
                    VALUE(\"$content\", '$id_membre', NOW())";
            $pdd->exec($sql);
        }
    }
?>