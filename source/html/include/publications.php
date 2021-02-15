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


<div class = "row mt-2">
    <div class = "col-md-12">
        <div class = "row">
            <div class = "col-md-12 mb-3">
                <div class = "offset-lg-3 col-lg-6 my-2" id = "publication_element">
                    <h2>Publications</h2>
                    <textarea class = "form-control font-weight-bold" data-toggle = "modal" href = "#publication" class = "">Que voulez-vous dire, <?php echo $_SESSION['surname']; ?> ?</textarea>
                </div>
                <?php
                    $response = $pdd->query('SELECT * FROM publication
                                            INNER JOIN membre
                                            ON publication.Id_publicateur = membre.Id_membre');
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
                        <div class = "offset-lg-3 col-lg-6 my-2" id = "publication_element">
                            <div class = "head">
                                <label class = "btn btn-primary font-weight-bold mb-0"><?php echo "$prenom[0]$nom[0]"; ?></label>
                                <span class = "font-weight-bold"><?php echo "$prenom $nom"; ?></span>
                            </div>
                            <!--<div class = "content" id = <?php #echo "content.$count"; ?>>-->
                            <div class = "content" id = "content0">
                                <span class = "font-weight-bold"><?php echo "$contenu"; ?></span>
                            </div>
                            <!-- <a class = "font-weight-bold lire_plus" href="" onclick='return toggle_publication_content(this, <?php #echo "content.$count"; ?>)'>Afficher plus</a><br> -->
                            <a class = "font-weight-bold lire_plus" href="" onclick="return toggle_publication_content(this, 'content0')">Afficher plus</a><br>
                            <span><?php echo "Publié le $date_pub"; ?></span>
                            <?php
                                $numb_picture=0;
                                foreach($pictures as $picture){
                                ?>
                                <div class = "images mt-2" <?php if($numb_picture != 0) echo "hidden";?> >
                                    <div class="col-lg-12 thumb">
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
</div>