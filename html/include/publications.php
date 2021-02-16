<?php
try
{
    $pdd = new PDO('mysql:host=localhost;dbname=reunion_famille;charset=utf8', 'root', '');
}
#En cas d'erreur
catch (Exception $e)
{
    $error = "Erreur de connexion à la base de données, veillez réessayer ultérieurement.";
    header("Location: acceuil_login.php?error=$error");
}
?>

<style>
    .thumb {
        margin-bottom: 0px !important;
    }
    a:hover {
        text-decoration: none;
        color:red
    }
</style>


<div class = "row mt-2">
    <div class = "col-md-12">
        <div class = "row">
            
                <!--Teaser Galerie -->
                <div class = "d-none d-md-inline-block col-md-3 my-2 font-weight-bold sticky-top">
                    <div>
                        <h3>Liens utiles</h3>
                        <ul>
                            <li><a href = "galerie.php" class = "link">Galerie d'images</a></li>
                            <li><a href = "administration.php" class = "link">Administration</a></li>
                            <li><a href = "mon_compte.php?mon_compte=contribution_et_participation" class = "link">Achats et finances</a></li>
                            <li><a href = "mon_compte.php?mon_compte=contribution_et_participation" class = "link">Effectuer un virement</a></li>
                            <li><a href = "mon_compte.php?mon_compte=rapports_details_financiers" class = "link">Rapports financiers</a></li>
                            <li><a href = "mon_compte.php?mon_compte=donnees_personnelles" class = "link">Données personnelles</a></li>
                        </ul>
                    </div>
                </div>
                <div class = "col-md-6 my-2" id = "publication_element">
                    <h2>Publications</h2>
                    <textarea class = "form-control font-weight-bold" data-toggle = "modal" href = "#publication" class = "">Que voulez-vous dire, <?php echo $_SESSION['surname']; ?> ?</textarea>
                </div>
                <?php
                    $response = $pdd->query('SELECT * FROM publication
                                            INNER JOIN membre
                                            ON publication.Id_publicateur = membre.Id_membre
                                            ORDER BY publication.Id_publication DESC');
                    $count = 0;
                    while($donnees = $response->fetch())
                    {
                        $count += 1;
                        $nom = $donnees['Nom'];
                        $prenom = $donnees['Prenom'];
                        $date_pub = $donnees['date_publication'];
                        $contenu = $donnees['Content'];
                        $id_publication = $donnees['Id_publication'];
                        $pictures = glob("../uploads/images_publication/*_$id_publication*");
                        ?>
                        <div class = "offset-md-3 col-md-6 my-2" id = "publication_element">
                            <div class = "head ml-3">
                                <div class="media">
                                    <label class = "btn btn-primary font-weight-bold mb-0 mr-2"><?php echo "$prenom[0]$nom[0]"; ?></label>
                                    <div class="media-body" style = "line-height:0px;">
                                        <h5 class="mt-0"><span class = "font-weight-bold"><?php echo " $prenom $nom"; ?></span></h5>
                                        <span><?php echo "Publié le $date_pub"; ?></span>
                                    </div>
                                </div>
                                <div class = "content text-left" id = "<?php echo $id_publication; ?>">
                                        <span class = "font-weight-bold"><?php echo "$contenu"; ?></span>
                                    </div>
                                    <a class = "font-weight-bold lire_plus" href="" onclick='return toggle_publication_content(this, "<?php echo $id_publication; ?>")'>Afficher plus</a><br>
                                    
                            </div>
                            <!--<div class = "content" id = <?php #echo "content.$count"; ?>>-->
                            
                            <!-- <a class = "font-weight-bold lire_plus" href="" onclick='return toggle_publication_content(this, <?php #echo "content.$count"; ?>)'>Afficher plus</a><br> -->
                            
                            <?php
                                $numb_picture=0;
                                foreach($pictures as $picture){
                                ?>
                                <div class = "images mt-2" <?php if($numb_picture != 0) echo "hidden";?> >
                                    <div class="col-xs-12 thumb">
                                        <a href = '<?php echo "$picture"; ?>' class = "fancybox" rel = '<?php echo "$id_publication"; ?>'>
                                            <img alt="picture" src = '<?php echo "$picture"; ?>' class="img-fluid zoom_pub">
                                        </a>
                                    </div>
                                </div>
                                <?php
                                $numb_picture+=1;
                                }
                            ?>
                        </div>
                <?php
                    }
                ?>
            
        </div>
    </div>
</div>