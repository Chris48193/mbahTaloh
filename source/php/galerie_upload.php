<?php
    function save_file($path)
    {
        if (isset($_FILES['file']) AND $_FILES['file']['error'] == 0)
        {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['file']['size'] <= 10000000)
            {
                // Testons si l'extension est autorisée
                $ID_MEMBRE = $_POST['id_membre'];
                $all_files = scandir($path);
                $nombre_de_fichiers = count($all_files)-2;
                $infosfichier = pathinfo($_FILES['file']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                $date = new DateTime();
                $timestamp = strval($date->getTimestamp());
                $stored_file_name = $ID_MEMBRE . '_' . $timestamp . '_' . $nombre_de_fichiers . '.' . strval($extension_upload);
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
            save_file('../uploads/images_galerie/');
        }
    }
?>