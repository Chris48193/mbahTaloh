<?php
    session_start();
    function get_current_page_url() {
        #Getting current page url
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
            $url = "https://";   
        else  
            $url = "http://";   
        // Append the host(domain name, ip) to the URL.   
        $url.= $_SERVER['HTTP_HOST'];   
        
        // Append the requested resource location to the URL   
        $url.= $_SERVER['REQUEST_URI'];
        return $url;    
    }
    if (!(isset($_SESSION['login'])))
    {
        $pageUrl = get_current_page_url();
        //header("Location: login.php?error=Veillez vous connecter svp&pageUrl=$pageUrl");
        $url = "login.php?error=Veillez vous connecter svp&pageUrl=$pageUrl";
        echo "<script>window.location.href='$url';</script>";
    }
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        h4 {
            color:blue;
        }
        h4:hover {
            color:red;
        }
        a:hover {
            text-decoration: none;
            color: red;
        }
    </style>
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class = "container-fluid">
        <!-- Entete (Logo, slogan, nom du site, bouton login) -->
        <div class = "container">
            <header class = "row pt-2 d-none d-md-flex">
                <div class = "col-md-offset-1 col-md-9 logo_slogan">
                    <img src = "../images/logo.jpg" alt = "logo" class = "rounded image-fluid align-baseline logo mr-1" width="60"><span class = "logo_title align-baseline font-weight-bold">Mba Taloh</span>
                    <h5 class = "font-weight-bold slogan">Ensemble nous allons loin</h5>
                </div>
                <div class = "col-md- mt-3 login_button"><button href = "" type="button" class="btn btn-primary font-weight-bold"><span class = "fas fa-user"></span>&nbsp;&nbsp;<?php echo $_SESSION['surname'][0].$_SESSION['name'][0]; ?></button></div>
                <div class = "col-md-2 mt-3 pl-2 login_button"><a type="button" href = "../php/logout.php" class="btn btn-primary btn-block font-weight-bold"><span class = "fas fa-sign-out-alt"></span>&nbsp;&nbsp;Déconnexion</a></div>
            </header>
        </div>

        <!-- Navbar -->
        <!--<div class = "row mx-2">
            <nav class = "col-md-12 navbar navbar-expand-md|lg|xl navbar-light sticky-top" style = "background-color: #eeeeee;">
                <form class = "form-inline" action="/">
                    <input class = "form-control mr-sm-2" type = "text" placeholder="Rechercher">
                    <button class = "btn btn-primary font-weight-bold" type = "submit">Rechercher</button>
                </form>
                <ul class = "nav">
                    <li class = "nav-item"><a class = "nav-link active" href="../index.php">Acceuil</a></li>
                    <li class = "nav-item">
                        <div class = "dropdown">
                            <a class = "nav-link dropdown-toggle" data-toggle="dropdown" href="">Mon compte</a>
                            <div class = "dropdown-menu">
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=rapports_details_financiers">Rapports et détails financiers</a>
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=contribution_et_participation">Contributions et participations</a>
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=donnees_personnelles">Données personnelles</a>
                            </div>
                        </div>
                    </li>
                    <li class = "nav-item"><a class = "nav-link" href="administration.php" >Administration</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="" >Aide</a></li>
                </ul>
            </nav>
        </div>-->

        <!-- Navbar medium screen -->
        <div class = "row mx-2 d-none d-md-flex">
            <nav class = "col-md-12 navbar navbar-expand-md|lg|xl navbar-light sticky-top" style = "background-color: #eeeeee;">
                <form class = "form-inline" action="/">
                    <input class = "form-control mr-sm-2" type = "text" placeholder="Rechercher">
                    <button class = "btn btn-primary font-weight-bold" type = "submit">Rechercher</button>
                </form>
                <ul class = "nav">
                    <li class = "nav-item"><a class = "nav-link active" href="acceuil_login.php">Acceuil</a></li>
                    <li class = "nav-item">
                        <div class = "dropdown">
                            <a class = "nav-link dropdown-toggle" data-toggle="dropdown" href="">Mon compte</a>
                            <div class = "dropdown-menu">
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=rapports_details_financiers">Rapports et détails financiers</a>
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=contribution_et_participation">Contributions et participations</a>
                                <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=donnees_personnelles">Données personnelles</a>
                            </div>
                        </div>
                    </li>
                    <li class = "nav-item"><a class = "nav-link" href="administration.php" >Administration</a></li>
                    <!--<li class = "nav-item"><a class = "nav-link" href="#" >Our Services</a></li>-->
                    <li class = "nav-item"><a class = "nav-link" href="aide.php" >Aide</a></li>
                </ul>
            </nav>
        </div>

        <!-- Navbar small screen -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
            <a class="navbar-brand" href="#"><img src = "../images/logo.jpg" alt = "logo" class = "rounded image-fluid align-baseline logo mr-1" width="60"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                    <a class = "nav-link active" href="acceuil_login.php" style="color:#006ddd;">Acceuil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" style="color:#006ddd;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mon compte
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=rapports_details_financiers">Rapports et détails financiers</a>
                            <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=contribution_et_participation">Contributions et participations</a>
                            <a class="dropdown-item font-weight-bold" style="color:red;" href="mon_compte.php?mon_compte=donnees_personnelles">Données personnelles</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class = "nav-link" href="administration.php" style="color:#006ddd;">Administration</a>
                    </li>
                    <li class="nav-item">
                    <a class = "nav-link" href="aide.php" style="color:#006ddd;">Aide</a>
                    </li>
                    <li class = "nav-item"><a class = "nav-link" style="color:#006ddd;" href = "../php/logout.php" class="font-weight-bold"><span class = "fas fa-sign-out-alt"></span>&nbsp;&nbsp;Déconnexion</a></li>
                </ul>
            </div>
        </nav>

        <div class = "row mt-2 ml-1">
            <div class = "col-md-12 mt-2" id = "div_message">
                <?php
					if ((isset($_GET['error'])) && $_GET['error'] != '')
						{
							?>
							<div class="alert alert-warning" role="alert"> <?php echo $_GET['error']; ?></div>
							<?php
                        }
				?>

                <div class="row">
                    <label class="control-label font-weight-bold">Session courante:&nbsp;</label>
                    <div class="">
                        <select onchange="update_session_reunion(this)" name="session_courante" type="text" placeholder="&nbsp;Session courante" class="form-control ml-1">
                        <?php
                                $response = $pdd->query("SELECT YEAR(Arrivee) AS session_year FROM session_reunion ORDER BY session_year DESC");
                                while($donnees = $response->fetch())
                                {
                                    $year = $donnees['session_year'];
                                    if (!$_SESSION['session_reunion'])
                                    {
                                        $_SESSION['session_reunion'] = $year;
                                    }
                                    if($_SESSION['session_reunion'] == $year){
                                    $selected = "selected";
                                    echo "<option value = '$year' class='form-control' $selected>$year</option>";}
                                    else echo "<option value = '$year' class='form-control'>$year</option>";
                                }
                        ?>
                        </select>
                    </div>
<!-- Fenetre de confirmation de participation a une session -->

<div class = "modal fade" id = "confirm_participation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Confirmez votre participation</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="well">
                                <form id="loginForm" method="POST" action="">
                                    <div class="form-group">
                                        <h6><label for="confirm" class="control-label">Allez vous participer a cette session <?php echo $_SESSION['session_reunion']; ?>?</label></h6>
                                        <a type="button" class="btn btn-success btn-block" href = "../php/confirm_participation.php?value=Oui&contribuable=Y" style="color:white;"><b>Oui et je suis contribuable</b></a>
                                        <a type="button" class="btn btn-success btn-block" href = "../php/confirm_participation.php?value=Oui&contribuable=N" style="color:white;"><b>Oui et je ne suis pas contribuable</b></a>
                                        <a type="button" class="btn btn-danger btn-block"  href = "../php/confirm_participation.php?value=Non" style="color:white;"><b>Non</b></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
                    <div style = "padding-left:10px;">
                        <?php
                            $id_membre = $_SESSION['id'];
                            $year = $_SESSION['session_reunion'];
                            $info_membre = $pdd->query("SELECT * FROM participer WHERE Id_session = $year AND Id_member = $id_membre");
                            if ($info_membre->rowCount() == 0 && !isset($_SESSION['confirm_participation'])) {
                                ?>
                                    <script>$('#confirm_participation').modal('show');</script>
                                    <button data-toggle = "modal" href = "#confirm_participation" class = "btn btn-success float-right">Confirmer votre participation</button>
                                <?php
                                
                            }
                            if (isset($_SESSION['confirm_participation']) && $info_membre->rowCount() == 0) {
                                echo "<button data-toggle = 'modal' href = '#confirm_participation' class = 'btn btn-success float-right'>Confirmer votre participation</button>";
                            }
                        ?>
                    </div>
                </div>
                <?php
                    // if(!isset($_GET['p'])) $_GET['p']='citation';

                    if(isset($_GET['mon_compte']))
                    { 
                        $fichier='include_users/'.$_GET['mon_compte'].'.php';
                        if(file_exists($fichier)) include($fichier);
                        else echo "Erreur 404 : la page demandée n’existe pas";
                    }
                    else
                    {
                        if(file_exists("include_users/rapports_details_financiers.php")) include("include_users/rapports_details_financiers.php");
                        else echo "Erreur 404 : la page demandée n’existe pas";
                    }
                ?>
            </div>
        </div>


        <footer class = "row">
            <div class = "col-lg-12">
                <div class = "row m-1 py-2" style="background-color: #eeeeee;">
                    <div class = "col-md-4 col-6">
                        <h2>Explorer</h2>
                        <a href = "galerie.php">Images</a>
                        <br><a href = "aide.php"Aide></a>
                        <h2>A propos</h2>
                        <a href = "www.chrisdevs.fr">Nos services</a>
                        <br>Blogs
                    </div>
                    <div class = "col-md-4 col-6">
                        <h2>A propos</h2>
                        Qui nous sommes
                        <br>Notre vision
                        <h2>Contact</h2>
                        <span><i class="fa fa-phone" aria-hidden="true"></i> +49 176 471 70820</span>
                        <br><span><i class="fa fa-whatsapp" aria-hidden="true"></i> +49 163 264 5907</span>
                        <br><span><i class="fa fa-envelope-o" aria-hidden="true"></i> yepmochristopher@yahoo.fr</span>

                    </div>
                    <div class = "col-md-4 d-none d-md-block">
                        <h2>Nous suivre</h2>
                        <span><a href = "https://www.facebook.com/Chrisdevs-118387616877345" target = "_blank"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <?php
        if (isset($_POST['session_year']) && isset($_POST['action']))
        {
            $_SESSION['session_reunion'] = $_POST['session_year'];
        }
    ?>
    <!-- Calling jquery, popper and bootstrap's javascript -->
    <script>
        function update_session_reunion(e)
        {
            let session_year = e.value;
            let div_message = document.getElementById('div_message');
            const child = document.createElement('p');
            console.log(session_year);
            let formdata = new FormData();
            formdata.append('session_year', session_year);
            formdata.append('action', 'change_session');
            fetch('#', {
                method: 'post',
                body: formdata,
            }).then(function(response) {
                console.log(response);
                window.location.reload();
            })
        }
    
        function lunch_modal()
        {
            $('#confirm_participation').modal('show');
        }

        function toggle_hide_show(id) {
            var element = document.getElementById(id);
            if (element.style.display === "none") {
                element.style.display = "";
            } else if (element.style.display == "") {
                element.style.display = "none";
            }
        }
    </script>

</body>
</html>