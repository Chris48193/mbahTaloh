<!--
----------------------------------
- Filename: index.php
- Author: Christopher Yepmo
- Date: 01-08-2020
- Description: Page d'acceuil pour utilisateur non authentifiés
----------------------------------
-->
<!-- Démarrage de la session -->
<?php
    session_start();
    if (isset($_SESSION['login']))
    {
        header("Location:html/acceuil_login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Bienvenue sur le site familial</title>

    <!--Calling bootstrap-->
    <!--Calling bootstrap-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="css/index.css" rel="stylesheet">

    <style>
        /* Small devices (landscape phones, 576px and up) */
        html {
            font-size: 0.6rem;
        }
        @media (min-width: 576px) { 
            html {
            font-size: 0.8rem;
        }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) { 
            html {
            font-size: 0.8rem;
        }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) { 
            html {
            font-size: 1rem;
        }
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) { 
            html {
            font-size: 1rem;
        }
        }
    </style>
</head>
<body>
    <div class = "container-fluid">
        <!-- Entete (Logo, slogan, nom du site, bouton login) -->
        <div class = "container">
            <header class = "row pt-2 d-none d-sm-flex">
                <div class = "col-md-offset-1 col-md-10 col-*-12 logo_slogan">
                    <img src = "images/logo.jpg" alt = "logo" class = "rounded image-fluid align-baseline logo mr-1" width="60"><span class = "logo_title align-baseline font-weight-bold">Mba Taloh</span>
                    <h5 class = "font-weight-bold font-italic slogan">Ensemble nous allons loin</h5>
                </div>
                <div class = "col-*-2 mt-3 login_button"><a href = "html/login.php" type="button" class="btn btn-primary btn-block font-weight-bold"><span class="fas fa-sign-in-alt"></span>&nbsp;&nbsp;Se connecter</a></div>
            </header>
        </div>

        <!-- Navbar medium screen -->
        <div class = "row mx-2 d-none d-md-flex">
            <nav class = "col-md-12 navbar navbar-expand-md|lg|xl navbar-light sticky-top" style = "background-color: #eeeeee;">
                <form class = "form-inline" action="/">
                    <input class = "form-control mr-sm-2" type = "text" placeholder="Rechercher">
                    <button class = "btn btn-primary font-weight-bold" type = "submit">Rechercher</button>
                </form>
                <ul class = "nav">
                    <li class = "nav-item"><a class = "nav-link active" href="#">Acceuil</a></li>
                    <li class = "nav-item">
                        <div class = "dropdown">
                            <a class = "nav-link dropdown-toggle" data-toggle="dropdown" href="">Mon compte</a>
                            <div class = "dropdown-menu">
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="html/mon_compte.php?mon_compte=rapports_details_financiers">Rapports et détails financiers</a>
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="html/mon_compte.php?mon_compte=contribution_et_participation">Contributions et participations</a>
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="html/mon_compte.php?mon_compte=donnees_personnelles">Données personnelles</a>
                            </div>
                        </div>
                    </li>
                    <li class = "nav-item"><a class = "nav-link" href="html/administration.php" >Administration</a></li>
                    <!--<li class = "nav-item"><a class = "nav-link" href="#" >Our Services</a></li>-->
                    <li class = "nav-item"><a class = "nav-link" href="#" >Aide</a></li>
                </ul>
            </nav>
        </div>

        <!-- Navbar small screen -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
                <a class="navbar-brand" href="#"><img src = "images/logo.jpg" alt = "logo" class = "rounded image-fluid align-baseline logo mr-1" width="60"></a>
                <a href = "html/login.php" type="button" class="btn btn-primary btn font-weight-bold"><span class="fas fa-sign-in-alt"></span>&nbsp;&nbsp;Se connecter</a>
            </nav>

        <!-- carousel -->
        <div class = "row">
            <div class = "col-md-12 mt-2">
                <div id = "demo" class = "carousel slide" data-ride = "carousel">
                    <!-- Indicators -->
                    <ol class = "carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class = "active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ol>

                    <!-- The Slideshow -->
                    <div class = "carousel-inner">
                        <div class = "carousel-item active"  data-interval="10000">
                            <img src = "images/slide-image-1.jpg" class="d-block w-100" alt="">
                            <div class="carousel-caption">
                                <h3 class="h3-responsive">Bienvenue sur le site de la famille Mba Taloh</h3>
                                <!--<p>First text</p>-->
                            </div>
                        </div>
                        <div class = "carousel-item" data-interval="2000">
                            <img src = "images/slide-image-2.jpg" class="d-block w-100" alt="">
                            <div class="carousel-caption">
                                <h3 class="h3-responsive">Controllez vos finances et vos achats</h3>
                                <!--<p>First text</p>-->
                            </div>
                        </div>
                        <div class = "carousel-item">
                            <img src = "images/slide-image-3.jpg" class="d-block w-100" alt="">
                            <div class="carousel-caption">
                                <h3 class="h3-responsive">Recevez les informations de la reunion</h3>
                                <!--<p>First text</p>-->
                            </div>
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class = "carousel-control-prev" href = "#demo" role = "button" data-slide = "prev">
                        <span class = "carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class = "carousel-control-next" href = "#demo" role="button" data-slide = "next">
                        <span class = "carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>


        <div class = "row mt-2 mx-3">
            <div class = "col-md-12 flex_box m-auto" style = "background-color: #eeeeee; padding:5px;">
                <div class = ""><a class="btn btn-primary font-weight-bold btn-flex" href="html/create_account.php">Créer un compte</a></div>
            </div>
        </div>
        <!-- Défilement de photos aléatoires -->
        <footer class = "row">
            <div class = "col-lg-12">
                <div class = "row m-3" style="background-color: #eeeeee;">
                    <div class = "col-md-4 col-6">
                        <h2>Explorer</h2>
                        Exemples de Video
                        <br>Aide
                        <h2>A propos</h2>
                        Histoires
                        <br>Blogs
                    </div>
                    <div class = "col-md-4 col-6">
                        <h2>A propos</h2>
                        Qui nous sommes
                        <br>Notre vision
                        <h2>Contact</h2>
                    </div>
                    <div class = "col-md-4 d-none d-md-block">
                        <h2>Nous suivre</h2>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>