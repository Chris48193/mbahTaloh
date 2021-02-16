
<!--
----------------------------------
- Filename: authenticate.php
- Author: Christopher Yepmo
- Date: 22-08-2020
- Description: Page php de traitement de l'authentification
----------------------------------
-->
<?php
    #Démarrage de la session
    session_start();
    #Définition des variables globales
    $error = "";

    /**
     * fonction de comptage du nombre d'entrées d'une réponse sql
     * @param $response réponse d'une requete sql
     * @return int $entries Nombre d'éléments retournés par la réponse
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
    
    #Control des données soumises
    if (!isset($_POST['email']) || !isset($_POST['mdp']))
    {
        $error = "Veillez vérifier l'entrée de vos données";
        if(isset($_GET["pageUrl"]) && trim($_GET["pageUrl"]) != "") { 
            header("Location:../html/login.php?error=$error&pageUrl=$pageUrl"); 
        } else {
            header("Location:../html/login.php?error=$error");
        }
    }
    else
    {
        #Récupération des données
        $email = trim(htmlspecialchars($_POST['email']));
        $mdp = trim(htmlspecialchars($_POST['mdp']));
        #Connexion a la base
        try
        {
            $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        }
        #En cas d'erreur
        catch (Exception $e)
        {
            $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
            header("Location: ../html/login.php?error=$error");
            #die('Erreur : ' . $e->getMessage());
        }
        #S'exécute toujours peu importe l'erreur
        finally
        {
            $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
            header("Location: ../html/login.php?error=$error");
        }

        #Exécution de la requete pour récupérer le membre dans la base de donnée
        $response = $pdd->query('SELECT * FROM membre WHERE Email="'.$email.'"');
        
        #Vérification de la présence du membre dans la base
        if (count_results($response) != 1)
        {
            $error = "L'utilisateur est inexistant. Veillez créer un compte";
            if(isset($_GET["pageUrl"]) && trim($_GET["pageUrl"]) != "") { 
                header("Location:../html/login.php?error=$error&pageUrl=$pageUrl&email=$email"); 
            } else {
                header("Location:../html/login.php?error=$error&email=$email");
            }
        }
        else
        {
            #Récupération du membre
            $response = $pdd->query('SELECT * FROM membre WHERE Email="'.$email.'"');
            $donnees = $response->fetch();

            #Control du mot de passe
            if (hash("sha256", $donnees['Sel'].$mdp) == $donnees['Hashe'])
            {
                $_SESSION['login'] = TRUE;
                $_SESSION['surname'] = $donnees['Prenom'];
                $_SESSION['name'] = $donnees['Nom'];
                $_SESSION['email'] = $donnees['Email'];
                $_SESSION['id'] = $donnees['Id_membre'];
                
                if(isset($_GET["pageUrl"]) && trim($_GET["pageUrl"]) != "") {
                    $page_url = $_GET["pageUrl"];
                    header("Location: $page_url"); 
                } else {
                    header("Location: ../html/acceuil_login.php");
                }
            }
            else
            {
                $error = "Mot de passe incorrect";
                $salt = $donnees['Hashe'];
                if(isset($_GET["pageUrl"]) && trim($_GET["pageUrl"]) != "") { 
                    header("Location:../html/login.php?error=$error&pageUrl=$pageUrl&email=$email"); 
                } else {
                    header("Location:../html/login.php?error=$error&email=$email");
                }
            }
        }

        #Fermeture de la base
        $reponse->closeCursor();
        
    }
?>