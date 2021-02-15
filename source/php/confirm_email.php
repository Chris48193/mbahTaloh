<!--
----------------------------------
- Filename: confirm_email.php
- Author: Christopher Yepmo
- Date: 21-08-2020
- Description: Page php de confirmation de l'email fournie par l'utilisateur
----------------------------------
--><!-- Démarrage de la session -->
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require '../../../composer/vendor/autoload.php';

    #Définition des variables
    $error = "";

    /**
     * fonction de comptage du nombre d'entrées d'une réponse sql
     * @param $response réponse d'une requete sql
     * @return int Nombre d'éléments retournés par la réponse
     **/
    function count_results($response)
    {
        $entries = 0;
        while ($response->fetch())
        {
            $entries+=1;
        }
        return $entries;
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

    if (!isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['email']) || !isset($_POST['mdp']) || !isset($_POST['telephone']) || !isset($_POST['date_naissance']) || !isset($_POST['adresse']))
    {
        $error = "Vérifiez vos entrées s'il vous plait. Certaines ne sont pas valides";
        header("Location:../html/create_account.php?error=$error");
    }
    else
    {
        #Traitement (Enlevement des espaces dans les entrées et prévention contre les injections XML) des données
        $name = trim(htmlspecialchars($_POST['name']));
        $surname = trim(htmlspecialchars($_POST['surname']));
        $email = trim(htmlspecialchars($_POST['email']));
        $mdp = trim(htmlspecialchars($_POST['mdp']));
        $randomString = generateRandomString();
        $salt = $randomString;
        $hashe = hash("sha256", $salt.$mdp);
        $telephone = trim(htmlspecialchars($_POST['telephone']));
        $date_naissance = trim(htmlspecialchars($_POST['date_naissance']));
        $adresse = trim(htmlspecialchars($_POST['adresse']));
        #$est_contribuable = trim(htmlspecialchars($_POST['est_contribuable']));

        #stockage des variables de maniere temporaire valable pendant un jour. Dernier parametre permet de déactiver l'acces a ce cookie par javascript pour eviter les failles xss
        setcookie('name', $name, time() + 24*3600, null, null, false, true);
        setcookie('surname', $surname, time() + 24*3600, null, null, false, true);
        setcookie('email', $email, time() + 24*3600, null, null, false, true);
        setcookie('salt', $salt, time() + 24*3600, null, null, false, true);
        setcookie('hashe', $hashe, time() + 24*3600, null, null, false, true);
        setcookie('telephone', $telephone, time() + 24*3600, null, null, false, true);
        setcookie('date_naissance', $date_naissance, time() + 24*3600, null, null, false, true);
        setcookie('adresse', $adresse, time() + 24*3600, null, null, false, true);

        #Connexion a la base
        try
        {
            $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        }
        catch (PDOException $e)
        {
            $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
            header("Location: ../html/create_account.php?error=$error");
        }

        #Verification de la présence du membre dans la base
        $response = $pdd->query('SELECT * FROM membre WHERE Email="'.$email.'"');
        if (count_results($response) == 0)
        {
            #Validation de l'email
            $mail = new PHPMailer(TRUE);
            try{
                $mail->setFrom('chrisblack123br456@gmail.com', 'Christopher Yepmo');
                $mail->addAddress($email, $surname);
            
                $mail->isHTML(TRUE);
                $mail->Subject = "Confirmation de votre adresse E-mail";
                $mail->Body = "Veillez s'il vous plait cliquer sur <a href='http://127.0.0.1/reunion_fam/php/inscription.php'>le lien pour confirmer votre adresse mail</a> (Vous avez 24h pour valider votre E-mail)
                Si le lien ne fonction pas, veillez copier et coller ce lien dans votre navigateur: http://127.0.0.1/reunion_fam/php/inscription.php";
                
                $mail->isSMTP();
            
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = TRUE;
                $mail->SMTPSecure = 'tls';
                $mail->Username = 'chrisblack123br456@gmail.com';
                $mail->Password = 'Blancheneige123';
                $mail->Port = 587;
            
                $mail->SMTPDebug = 4;
            
                $mail->send();

                header("Location:../html/page_confirmation_email.html");
            }
            catch(Exception $e){
                #$error = $e->errorMessage();
                $error = "Erreur de connection au serveur mail. Veillez réessayer ultérieurement.";
                header("Location: ../html/create_account.php?error=$error");
            }
            catch(\Exception $e){
                /* PHP exception (note the backslash to select the global namespace Exception class). */
                #$error = $e->getMessage();
                $error = "Erreur de connection au serveur mail. Veillez réessayer ultérieurement.";
                header("Location: ../html/create_account.php?error=$error");
            }
            
        }
        else
        {
            $error = "Un compte avec cet E-mail existe déja. Veillez vous connecter";
            header("Location: ../html/create_account.php?error=$error");
        }
    }
?>