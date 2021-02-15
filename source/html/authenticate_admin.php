<?php
    session_start();
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
                            header("Location: administration.php");
                        }
                        else
                        {
                            $error = "Mot de passe incorrect";
                            header("Location: authenticate_admin.php?error=$error");
                        }
					}
			?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>