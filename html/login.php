<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../css/index.css" rel="stylesheet">
	
	<script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>

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
    <!-- Fenetre de login -->

			<div id = "login">
				<div class="modal-dialog modal-lg">
      				<div class="modal-content">
          				<div class="modal-header">
          					<h3 class="modal-title" id="myModalLabel">Se connecter au site familial</h3>
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
			                 	<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 mb-3">
			                     	<div class="card card-body bg-light">
			                         	<form id="loginForm" method="POST" action='<?php if(isset($_GET["pageUrl"]) && trim($_GET["pageUrl"]) != "") { $pageUrl = $_GET["pageUrl"]; echo "../php/authenticate.php?pageUrl=$pageUrl"; } else {echo "../php/authenticate.php";} ?>'>
						                    <div class="form-group">
						                        <label for="username" class="control-label">E-mail</label>
						                        <input type="text" class="form-control" id="username" name="email" required="required" title="Veillez entrer votre E-mail" placeholder = "example@gmail.com" value = <?php if (isset($_GET['email'])){ echo $_GET['email']; } ?>>
						                        <span class="help-block"></span>
						                    </div>
					                        <div class="form-group">
					                            <label for="password" class="control-label">Mot de passe</label>
					                            <input type="password" class="form-control" id="password" name="mdp" required="required" title="Veillez entrer ntrez votre mot de passe">
					                            <span class="help-block"></span>
                                            </div>
			                             	<button type="submit" class="btn btn-success btn-block" value = "submit_login">Se connecter</button>
                                            <div class="text-center">
                                                <a href="#">Vous avez oubliez votre Mot de passe ?</a>
					                        </div>
                                        </form>
			                     	</div>
								</div>
								<hr style="width:50%;text-align:center;margin-left:10;color:green;" class = "d-md-none">
			                 	<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
						            <p class="lead text-center">Ou créer votre compte <span class="text-success">GRATUITEMENT</span></p>
						                <ul class="list-unstyled style" style="line-height: 2">
					                        <li><span class="fa fa-check text-success"></span> Accès a toutes les informations</li>
					                        <li><span class="fa fa-check text-success"></span> Payement facile des contributions</li>
					                        <li><span class="fa fa-check text-success"></span> Plus de transparence</li>
					                        <li><span class="fa fa-check text-success"></span> Post des informations</li>
					                    </ul>
			                        <p><a href="create_account.php" class="btn btn-info btn-block">Oui, Créer mon compte maintenant</a></p>
			                 	</div>
			             	</div>
			         	</div>
			     	</div>
				</div>
			</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>