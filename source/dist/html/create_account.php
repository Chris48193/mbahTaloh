<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="../css/index.css" rel="stylesheet">
	
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
    <!-- Fenetre de création de compte -->

			<div id = "signup">
				<div class = "modal-dialog modal-lg">
					<div class = "modal-content">
						<div class = "modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Creer un compte</h5>
					    </div>
					    <div class = "modal-body">
							<?php
								if ((isset($_GET['error'])) && $_GET['error'] != '')
								{
									?>
									<div class="alert alert-warning" role="alert"> <?php echo $_GET['error']; ?></div>
									<?php
								}
							?>
							<div class = "card card-body bg-light modal-body">
								<form class = "form-horizontal" action = "../php/confirm_email.php" method = "post">
									<fieldset>
										<!--name input-->
										<div class="form-group">
					              			<label class="col-md-3 control-label">Nom</label>
					              			<div class="col-md-12">
					                			<input name="name" type="text" placeholder="Votre Nom" class="form-control" required>
					              			</div>
				           				</div>
				           				<!--surname input-->
										<div class="form-group">
				              				<label class="col-md-3 control-label">Prenom</label>
				              				<div class="col-md-12">
				                				<input name="surname" type="text" placeholder="Votre prenom" class="form-control" required>
				              				</div>
			           					</div>
			           					<!-- Email input-->
			            				<div class="form-group">
			              					<label class="col-md-3 control-label">E-mail</label>
			             	 				<div class="col-md-12">
			                					<input name="email" type="text" placeholder="example@gmail.com" class="form-control" required>
			             					</div>
			            				</div>
										<!-- Telephone input-->
			            				<div class="form-group">
			              					<label class="col-md-3 control-label">Telephone</label>
			             	 				<div class="col-md-12">
			                					<input name="telephone" type="text" placeholder="Votre telephone" class="form-control" required>
			             					</div>
			            				</div>
			            				<!--password input-->
										<div class="form-group">
			              					<label class="col-md-3 control-label">Mot de passe</label>
			              					<div class="col-md-12">
			                					<input name="mdp" type="password" placeholder="Votre mot de passe" class="form-control" required>
			              					</div>
			           					</div>
			           					<!--password confirm input -->
										<div class="form-group">
			              					<label class="col-md-4 control-label">Confirmer le mot de passe</label>
			              					<div class="col-md-12">
			                					<input name="mdp_confirm" type="password" placeholder="Confirmez votre mot de passe" class="form-control" required>
			              					</div>
                                        </div>
										<!-- Date de naissance input -->
			            				<div class="form-group">
			              					<label class="col-md-3 control-label">Date de naissance</label>
			             	 				<div class="col-md-12">
			                					<input name="date_naissance" type="date" placeholder="Votre date de naissance" class="form-control" required>
			             					</div>
			            				</div>
										<!-- Adresse input-->
			            				<div class="form-group">
			              					<label class="col-md-3 control-label">Adresse</label>
			             	 				<div class="col-md-12">
			                					<input name="adresse" type="text" placeholder="Votre adresse" class="form-control" required>
			             					</div>
			            				</div>
										<!-- Adresse input-->
			            				<!--<div class="form-group alert-warning" style = "border-radius:5px; padding:10px;">
			              					<label class="col-md-12 control-label">Vos données sont protégées et transférées de manière sécurisée. <a href = "#">En savoir plus sur le traitement de nos données.</a></label>
			            				</div> -->
										<!-- Est contribuable input -->
			            				<!--<div class="form-group">
			              					<label class="col-md-4 control-label" for = "est_contribuable">Etes-vous contribuable ?</label>
			             	 				<div class="col-md-12">
											  	<div class="form-check">
													<label class="form-check-label">
														<input type="radio" name = "est_contribuable" class="form-check-input" value="Y">Oui
													</label>
													</div>
													<div class="form-check">
													<label class="form-check-label">
														<input type="radio" name = "est_contribuable" class="form-check-input" value="N">Non
													</label>
											  	</div>
			             					</div>
			            				</div>-->
									    <!-- Form actions -->
									    <div class="form-group">
									        <div class="col-md-12 text-right">
									            <button type="submit" class="btn btn-primary font-weight-bold">Terminé</button>
									        </div>
									    </div>
									</fieldset>
								</form>
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