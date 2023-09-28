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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="../css/index.css" rel="stylesheet">
</head>
<body>
    <!-- Fenetre de login -->

			<div id = "login">
				<div class="modal-dialog modal-lg">
      				<div class="modal-content">
          				<div class="modal-header">
          					<h3 class="modal-title" id="myModalLabel">Connexion compte Administrateur</h3>
						</div>
			         	<div class="modal-body">
                         <?php
								if ((isset($_GET['error'])) && $_GET['error'] != '')
								{
									?>
									<div class="alert alert-warning" role="alert"> <?php echo $_GET['error']; ?></div>
									<?php
								}
							?>
							<div class="alert alert-warning" role="alert">L'accès à l'interface administrateur est limité à certains utilisateurs. Si vous ne connaissez pas le mot de passe, veillez nous contacter.
                            <br>Pour des raisons de test et sondage, le mot de passe est: root</div>
			             	<div class="row">
			                 	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
			                     	<div class="card card-body bg-light">
			                         	<form id="loginForm" method="POST" action="#">
					                        <div class="form-group">
					                            <label for="password" class="control-label">Mot de passe</label>
					                            <input type="password" class="form-control" id="password" name="mdp" required="required" title="Veillez entrer ntrez votre mot de passe">
					                            <span class="help-block"></span>
                                            </div>
			                             	<button type="submit" class="btn btn-success btn-block" value = "submit_login">Se connecter</button>
                                        </form>
			                     	</div>
			                 	</div>
			             	</div>
			         	</div>
			     	</div>
				</div>
            </div>
            <?php
				if ((isset($_POST['mdp'])))
					{
                        if ($_POST['mdp'] == "root")
                        {
                            $_SESSION['admin'] = TRUE;
                            //header("Location: administration.php");
                            $url = "administration.php";
                            echo "<script>window.location.href='$url';</script>";
                        }
                        else
                        {
                            $error = "Mot de passe incorrect";
                            //header("Location: authenticate_admin.php?error=$error");
                            $url = "authenticate_admin.php?error=$error";
                            echo "<script>window.location.href='$url';</script>";
                        }
					}
			?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>