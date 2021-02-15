<h2>Données du compte</h2>
<div class = "row">
    <div class = "col-lg-6">
        <form method = "post" action = "../../../php/nouveau_achat.php?page=contribution">
            <fieldset>
            <legend class="scheduler-border">Données personelles (Ecrire pour modifier)</legend>
                <!--Name input-->
                <div class="form-group">
                    <label class="col-md-3 control-label">Nom: </label>
                    <div class="col-md-12">
                        <input name="nom" type="text" value="" class="form-control">
                    </div>
                </div>
                <!-- Surname input-->
                <div class="form-group">
                    <label class="col-md-3 control-label">Prenom: </label>
                    <div class="col-md-12">
                        <input name="prenom" type="text" value="" class="form-control">
                    </div>
                </div>
                <!-- Email input-->
                <div class="form-group">
                    <label class="col-md-3 control-label">E-mail: </label>
                    <div class="col-md-12">
                        <input name="email" type="text" class="form-control" value = "" disabled>
                    </div>
                </div>
                <!-- Password input-->
                <div class="form-group">
                    <label class="col-md-3 control-label">Mot de passe: </label>
                    <div class="col-md-12">
                        <input name="mdp" type="text" class="form-control" value = "*******">
                    </div>
                </div>
                <!-- telephone input-->
                <div class="form-group">
                    <label class="col-md-3 control-label">Telephone: </label>
                    <div class="col-md-12">
                        <input name="telephone" type="text" class="form-control" value = "">
                    </div>
                </div>
                <!-- Adresse input-->
                <div class="form-group">
                    <label class="col-md-3 control-label">Adresse: </label>
                    <div class="col-md-12">
                        <input name="adresse" type="text" class="form-control" value = "">
                    </div>
                </div>
                <!-- Form actions -->
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary font-weight-bold">Terminé</button>
                    </div>
                </div>
            <fieldset>
        </form>
    </div>
    <div class = "col-lg-6">
        <legend class="scheduler-border">Publications</legend>
    </div>
</div>