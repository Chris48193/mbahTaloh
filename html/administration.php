<!--
----------------------------------
- Filename: administration.php
- Author: Christopher Yepmo
- Date: 01-08-2020
- Description: Page pour la gestion des taches de l'utilisateur
----------------------------------
-->
<?php
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
    
    session_start();
    if (isset($_SESSION['admin']))
    {
        
    }
    else
    {
        if (!(isset($_SESSION['login'])))
        {
            $pageUrl = get_current_page_url();
            header("Location: login.php?error=Veillez vous connecter svp&pageUrl=$pageUrl");
        }
        else
        {
            header('Location: authenticate_admin.php');
        }
    }
    try
    {
        $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
        $pdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>

    <style>
        a:hover {
            text-decoration: none !important;
            color: red !important;
        }
		#dropArea_factures
		{
			border: dashed #ccc 3px;
			border-radius: 20px;
		}
		#dropArea_factures.highlight
		{
			border-color: purple;
		}
		p
		{
			margin-top: 0;
		}
		.my-form
		{
			margin-bottom: 10px;
		}
		.button
		{
			display: inline-block;
			padding: 10px;
			background: #ccc;
			cursor: pointer;
			border-radius: 5px;
			border: 1px solid #ccc;
		}
		.button:hover
		{
			background: #ddd;
		}
		#fileElem
		{
			display: none;
		}
	</style>
    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
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
        <!-- <div class = "row mx-2">
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
                    <li class = "nav-item"><a class = "nav-link" href="#">Administration</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >Aide</a></li>
                </ul>
            </nav>
        </div> -->

        <!-- Navbar medium screen -->
        <div class = "row mx-2 d-none d-md-flex">
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
                    <a class = "nav-link active" href="../index.php" style="color:#006ddd;">Acceuil <span class="sr-only">(current)</span></a>
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
            <div class = "col-md-3 list-group list-group-flush">
                <a href = "administration.php?page=details_reunions" class = "list-group-item list-group-item-action">Détails des réunions</a>
                <a href = "administration.php?page=donnees_membres" class = "list-group-item list-group-item-action">Données des membres</a>
                <a href = "administration.php?page=participants_contribuables" class = "list-group-item list-group-item-action">Détails financiers des participants contribuables</a>
                <a href = "administration.php?page=liste_achats" class = "list-group-item list-group-item-action">Liste des achats</a>
                <a href = "administration.php?page=inventaire" class = "list-group-item list-group-item-action">Inventaire</a>
                <a href = "administration.php?page=actifs" class = "list-group-item list-group-item-action">Actifs</a>
            </div>


            <div class = "col-md-9 mt-2" id = "div_message">
                <?php
					if ((isset($_GET['error'])) && $_GET['error'] != '')
						{
							?>
							<div class="alert alert-warning" role="alert"> <?php echo $_GET['error']; ?></div>
							<?php
                        }
				?>
                <h1>Administration de la réunion</h1>
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
                </div>
                <?php
                    // if(!isset($_GET['p'])) $_GET['p']='citation';

                    if(isset($_GET['page'])) 
                    { $fichier='include/'.$_GET['page'].'.php';
                        if(file_exists($fichier)) include($fichier);
                        else echo "Erreur 404 : la page demandée n’existe pas";
                    }
                    else
                    {
                        if(file_exists("include/details_reunions.php")) include("include/details_reunions.php");
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
    </script>

</body>
</html>