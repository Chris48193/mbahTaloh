<?php
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
    header("Location: acceuil_login.php?error=$error");
    //$url = "acceuil_login.php?error=$error";
    //echo "<script>window.location.href='$url';</script>";
    #die('Erreur : ' . $e->getMessage());
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
    .publication_element
    {
        background-color: #eeeeee;
        padding: 1vw;
        border-radius: 10px;
        text-align: justify;
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
                <div class = "col-md-6 my-2 publication_element">
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
                        $pattern = "../uploads/images_publication/*" . $id_publication . "*";
                        $pictures = glob($pattern);
                        ?>
                        <div class = "offset-md-3 col-md-6 my-2 publication_element">
                            <div class = "head ml-3">
                                <div class="media">
                                    <label class = "btn btn-primary font-weight-bold mb-0 mr-2"><?php echo "$prenom[0]$nom[0]"; ?></label>
                                    <div class="media-body" style = "line-height:0px;">
                                        <h5 class="mt-0"><span class = "font-weight-bold"><?php echo " $prenom $nom"; ?></span></h5>
                                        <span><?php echo "Publié le $date_pub"; ?></span>
                                    </div>
                                </div>
                              <br>
                                <div class = "content text-left">
                                    <span class = "content-text font-weight-bold" id = "<?php echo $id_publication; ?>"><?php echo substr($contenu, 0, 120) ?></span>
                                    <?php if(strlen($contenu) > 120) { ?><a class = "font-weight-bold lire_plus" id="showMoreBtn" href="" onclick='return toggle_publication_content(this, "<?php echo $id_publication; ?>", "<?php echo $contenu; ?>")'>Afficher plus</a><?php } ?><br>
                                </div>
                                    
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

<!-- Fenetre modale de creation de publication -->
<div class = "modal fade" id = "publication">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel">Créer une publication</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-body bg-light">
                            <!--<form id="publicationForm" method="POST" action="../php/save_publication.php">-->
                            <form id="publicationForm" <?php echo "onsubmit='save_publication($id_membre)'"; ?>>
                                <div class="form-group">
                                    <label for="publication_body" class="control-label">Contenu de la publication</label>
                                    <textarea class="form-control" id="publication_body" name="publication_body" required="required" placeholder = "Que voulez vous dire, <?php echo $_SESSION['surname']; ?> ?"></textarea>
                                </div>
                                <div id = "image_preview2"></div>
                                <div class="form-group">
                                    <label class="button btn btn-primary font-weight-bold" for="publicationPicture">Ajouter des photos</label>
                                    <input type="file" id="publicationPicture" multiple accept="image/*" onchange="showPreview2(this.files)" hidden>
                                </div>
                                <input type = "submit" class="btn btn-success btn-block" value = "Publier">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggle_publication_content(bouton_lire_plus, content_id, full_content){
        event.preventDefault();
        let publication_content = document.getElementById(content_id)
        if (publication_content.textContent.length <= 120){
            publication_content.textContent = full_content;
            bouton_lire_plus.textContent = "Afficher moins"
        }
        else {
            publication_content.textContent = full_content.slice(0,120);
            bouton_lire_plus.textContent = "Afficher plus"
        }
        return false;
    }

    function showPreview2(files){
        files = [...files];
        if(files.length > 0){
            files.forEach(function(file){
                src = URL.createObjectURL(file);
                preview_div = document.createElement('div');
                preview_link = document.createElement('a');
                preview_img = document.createElement('img');
                preview_img.src = src;
                preview_img.setAttribute('class', 'img-fluid zoom mb-2');
                preview_link.append(preview_img);
                preview_link.setAttribute('class', 'fancybox');
                preview_link.setAttribute('rel', 'lightbox');
                preview_div.append(preview_link);
                preview_div.setAttribute('class', 'col-lg-6 thumb');
                preview_div.setAttribute('style', 'display:inline-block;');
                document.getElementById('image_preview2').append(preview_div);
            })
        }
    }

    // Fired when the publication form is submitted
    function save_publication(id_membre){
        event.preventDefault();
        input_publication_content = document.getElementById('publication_body');
        publication_content = input_publication_content.value;
        input_element = document.getElementById('publicationPicture');
        pictures = input_element.files;
        pictures = [...pictures];
        let formDataPublicationContent = new FormData;
        formDataPublicationContent.append('content', publication_content);
        formDataPublicationContent.append('id_membre', id_membre);
        formDataPublicationContent.append('action', 'save_publication_content');
        fetch('../php/save_publication.php', {
            method: 'POST',
            body: formDataPublicationContent
            })
            .then((response) => {
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            })
        pictures.forEach(function(picture, i){
            setTimeout(() => {
                let formData = new FormData;
                formData.append('pictures', picture);
                formData.append('id_membre', id_membre);
                formData.append('action', 'save_publication_pictures');
                fetch('../php/save_publication.php', {
                    method: 'POST',
                    body: formData
                    })
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    })
            }, 500 * i);
        })
        console.log("Reloading...")
        // location.reload();
    }

    $(document).ready(function(){
        // Fancy box settings
        $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });
            
            $(".zoom").hover(function(){
                
                $(this).addClass('transition');
            }, function(){
                $(this).removeClass('transition');
            });
    });
</script>