<!--
----------------------------------
- Filename: administration.php
- Author: Christopher Yepmo
- Date: 01-08-2020
- Description: Page pour la gestion des taches de l'utilisateur
----------------------------------
-->
<?php
    session_start();
    if (!(isset($_SESSION['login'])))
    {
        header('Location: ../index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
</head>
<body>
    <div class = "container-fluid">
        <!-- Entete (Logo, slogan, nom du site, bouton login) -->
        <div class = "container">
            <header class = "row pt-2">
                <div class = "col-md-offset-1 col-md-9 logo_slogan">
                    <img src = "../images/logo.jpg" alt = "logo" class = "rounded image-fluid align-baseline logo mr-1" width="60"><span class = "logo_title align-baseline font-weight-bold">Mba Taloh</span>
                    <h5 class = "font-weight-bold slogan">Ensemble nous allons loin</h5>
                </div>
                <div class = "col-md- mt-3 login_button"><button href = "" type="button" class="btn btn-primary font-weight-bold"><span class = "fas fa-user"></span>&nbsp;&nbsp;<?php echo $_SESSION['surname'][0].$_SESSION['name'][0]; ?></button></div>
                <div class = "col-md-2 mt-3 pl-2 login_button"><a type="button" href = "../php/logout.php" class="btn btn-primary btn-block font-weight-bold"><span class = "fas fa-sign-out-alt"></span>&nbsp;&nbsp;Déconnexion</a></div>
            </header>
        </div>

        <!-- Navbar -->
        <div class = "row mx-2">
            <nav class = "col-md-12 navbar navbar-expand-md|lg|xl navbar-light sticky-top" style = "background-color: #eeeeee;">
                <form class = "form-inline" action="/">
                    <input class = "form-control mr-sm-2" type = "text" placeholder="Rechercher">
                    <button class = "btn btn-primary font-weight-bold" type = "submit">Rechercher</button>
                </form>
                <ul class = "nav">
                    <li class = "nav-item"><a class = "nav-link active" href="#">Acceuil</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >Mon compte</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >Administration</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >Aide</a></li>
                </ul>
            </nav>
        </div>

        <div class = "row mt-2 ml-1">
            <div class = "col-md-3 list-group list-group-flush">
                <a href = "#details_reunions" class = "list-group-item list-group-item-action">Détails des réunions</a>
                <a href = "#données_membres" class = "list-group-item list-group-item-action">Données des membres</a>
                <a href = "#participants_contribuables" class = "list-group-item list-group-item-action">Participants contribuables</a>
                <a href = "#liste_achats" class = "list-group-item list-group-item-action">Liste des achats</a>
                <a href = "#inventaire" class = "list-group-item list-group-item-action">Inventaire</a>
            </div>

            <!-- Effet accordéon: la class "show" permet a l'élément a qui il a été attribué d'etre ouverte par 
            défaut -->
            <div class = "col-md-9 mt-2">
                <h1>Bienvenue sur l'administration de la réunion</h1>
                <a type = "button" class = "btn btn btn-primary font-weight-bold" href = "#" title = "Créer une nouvelle session de réunion">Nouvelle session</a>
                <div id = "accordion" class = "mt-2">
                    <div class = "card">
                        <div class = "card-header" id = "details_reunions">
                            <h5 class = "mb-0">
                                <button class = "btn btn-link" data-toggle = "collapse" data-target = "#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Détails des réunions
                                </button>
                            </h5>
                        </div>

                        <div id = "collapseOne" class = "collapse show" aria-labelledby="details_reunions" data-parent = "#accordion">
                            <div class = "card-body">
                                Détails des réunions
                            </div>
                        </div>
                    </div>

                    <div class = "card">
                        <div class = "card-header" id = "données_membres">
                            <h5 class = "mb-0">
                                <button class = "btn btn-link" data-toggle = "collapse" data-target = "#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Données des membres
                                </button>
                            </h5>
                        </div>

                        <div id = "collapseTwo" class = "collapse" aria-labelledby="données_membres" data-parent = "#accordion">
                            <div class = "card-body">
                                Données des membres
                            </div>
                        </div>
                    </div>

                    <div class = "card">
                        <div class = "card-header" id = "participants_contribuables">
                            <h5 class = "mb-0">
                                <button class = "btn btn-link" data-toggle = "collapse" data-target = "#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Participants contribuables
                                </button>
                            </h5>
                        </div>

                        <div id = "collapseThree" class = "collapse" aria-labelledby="Participants_contribuables" data-parent = "#accordion">
                            <div class = "card-body">
                                Participants contribuables
                            </div>
                        </div>
                    </div>

                    <div class = "card">
                        <div class = "card-header" id = "liste_achats">
                            <h5 class = "mb-0">
                                <button class = "btn btn-link" data-toggle = "collapse" data-target = "#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Liste des achats
                                </button>
                            </h5>
                        </div>

                        <div id = "collapseFour" class = "collapse" aria-labelledby="liste_achats" data-parent = "#accordion">
                            <div class = "card-body">
                                Liste des achats
                            </div>
                        </div>
                    </div>

                    <div class = "card">
                        <div class = "card-header" id = "inventaire">
                            <h5 class = "mb-0">
                                <button class = "btn btn-link" data-toggle = "collapse" data-target = "#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Inventaire
                                </button>
                            </h5>
                        </div>

                        <div id = "collapseFive" class = "collapse" aria-labelledby="inventaire" data-parent = "#accordion">
                            <div class = "card-body">
                                Inventaire
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <footer class = "row">
            <div class = "col-lg-12">
                <div class = "row m-3" style="background-color: #eeeeee;">
                    <div class = "col-lg-4">
                        <h2>Explorer</h2>
                        Exemples de Video
                        <br>Aide
                        <h2>A propos</h2>
                        Histoires
                        <br>Blogs
                    </div>
                    <div class = "col-lg-4">
                        <h2>A propos</h2>
                        Qui nous sommes
                        <br>Notre vision
                        <h2>Contact</h2>
                    </div>
                    <div class = "col-lg-4">
                        <h2>Nous suivre</h2>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <!-- Calling jquery, popper and bootstrap's javascript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>