<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file']) AND $_FILES['file']['error'] == 0)
        {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['file']['size'] <= 2000000)
            {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['file']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload,  $extensions_autorisees))
                {
                    // On peut valider le fichier et le stocker  définitivement
                    move_uploaded_file($_FILES['file']['tmp_name'], '../../uploads/' . basename($_FILES['file']['name']));
                    print_r(["L'envoi a bien été effectué !"]);
                }
            }
        }
    }
?>