<!--
----------------------------------
- Filename: acceuil_login.html
- Author: Christopher Yepmo
- Date: 01-08-2020
- Description: Page d'acceuil pour utilisateur authentifiés ou non authentifiés
----------------------------------
-->
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
        header("Location: login.php?error=Veillez vous connecter svp&pageUrl=$pageUrl");
    }
    $id_membre = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>

    <!--Calling bootstrap-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
    <style>
        .green{
            background-color:#6fb936;
        }

        .thumb{
            margin-bottom: 30px;
        }

        .page-top{
            margin-top:85px;
        }

        
        img.zoom, img.zoom_pub {
            width: 100%;
            height: 20vh;
            border-radius:5px;
            object-fit:cover;
            -webkit-transition: all .3s ease-in-out;
            -moz-transition: all .3s ease-in-out;
            -o-transition: all .3s ease-in-out;
            -ms-transition: all .3s ease-in-out;
        }
        img.zoom_pub{
            height: 35vh !important;
        }
        .transition {
            -webkit-transform: scale(1.2); 
            -moz-transform: scale(1.2);
            -o-transform: scale(1.2);
            transform: scale(1.2);
        }
        .modal-header {
            border-bottom: none;
        }
        .modal-title {
            color:#000;
        }
        .modal-footer{
        display:none;  
        }
        #publication_element
        {
            background-color: #eeeeee;
            padding: 1vw;
            border-radius: 10px;
            text-align: justify;
        }
        .content{
            height: 1.5rem;
            overflow: hidden;
        }
        .lire_plus{
            text-decoration:none;
        }
    </style>
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

        <!-- Navbar medium screen -->
        <div class = "row mx-2 d-none d-md-flex">
            <nav class = "col-md-12 navbar navbar-expand-md|lg|xl navbar-light" style = "background-color: #eeeeee;">
                <form class = "form-inline" action="/">
                    <input class = "form-control mr-sm-2" type = "text" placeholder="Rechercher">
                    <button class = "btn btn-primary font-weight-bold" type = "submit">Rechercher</button>
                </form>
                <ul class = "nav">
                    <li class = "nav-item"><a class = "nav-link active" href="#">Acceuil</a></li>
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
                    <a class = "nav-link active" href="#" style="color:#006ddd;">Acceuil <span class="sr-only">(current)</span></a>
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

        <!-- carousel -->
        <div class = "row">
            <div class = "col-md-12 mt-2">
                <div id = "demo" class = "carousel slide" data-ride = "carousel">
                    <!-- Indicators -->
                    <ol class = "carousel-indicators">
                        <li data-target="#demo" data-slide-to="0" class = "active"></li>
                        <li data-target="#demo" data-slide-to="1"></li>
                        <li data-target="#demo" data-slide-to="2"></li>
                    </ol>

                    <!-- The Slideshow -->
                    <div class = "carousel-inner">
                        <div class = "carousel-item active"  data-interval="10000">
                            <img src = "../images/slide-image-1.jpg" class="d-block w-100" alt="">
                            <div class="carousel-caption">
                                <h3 class="h3-responsive">Bienvenue sur le site de la famille Mba Taloh</h3>
                                <!--<p>First text</p>-->
                            </div>
                        </div>
                        <div class = "carousel-item" data-interval="2000">
                            <img src = "../images/slide-image-2.jpg" class="d-block w-100" alt="">
                        </div>
                        <div class = "carousel-item">
                            <img src = "../images/slide-image-3.jpg" class="d-block w-100" alt="">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class = "carousel-control-prev" href = "#demo" role = "button" data-slide = "prev">
                        <span class = "carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class = "carousel-control-next" href = "#demo" role="button" data-slide = "next">
                        <span class = "carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class = "row mt-3 mx-1">
            <div class = "col-md-12 flex_box" style = "background-color: #eeeeee; padding:5px;">
                <div class = ""><a type="button" class="btn btn-primary font-weight-bold" href="mon_compte.php">Mon compte</a></div>
            </div>
        </div>

        <!-- Affichage des publications -->
        <div class = "row">
            <div class = "col-md-12" style = "margin-left:10px !important; margin-right:10px !important;">
                <?php
                    include("include/publications.php");
                ?>
            </div>
        </div>

        <!-- Teaser image -->
        <div class = "" style = "background-color: #eeeeee;">
            <a target = "_blank" style = "text-decoration: none;" href = "galerie.php"><h3 class = "text-center h3-responsive">Cliquer pour ici Explorer la galerie d'images</h3><a>
            <?php
                        $all_files = scandir("../uploads/images_galerie");
                        $length = count($all_files);
                        $pictures = array_slice($all_files, 2, $length-2);
                        $selected_pictures = array_rand($pictures, 4);
                        $picture1 = $pictures[$selected_pictures[0]];
                        $picture2 = $pictures[$selected_pictures[1]];
                        $picture3 = $pictures[$selected_pictures[2]];
                        $picture4 = $pictures[$selected_pictures[3]];
                    ?>
            <div class = "row mt-1 mx-3">
                <div class = "col-md-12 flex_box" style = "background-color: #eeeeee;">
                        <div class="col-lg-3 col-md-4 col-6 thumb my-3">
                        <a href = <?php echo "../uploads/images_galerie/$picture1"; ?> class="fancybox" rel="ligthbox">
                            <img alt="picture" src = <?php echo "../uploads/images_galerie/$picture1"; ?> class="img-fluid zoom">
                        </a>
                        </div>

                        <div class="col-lg-3 col-md-4 col-6 thumb my-3">
                        <a href = <?php echo "../uploads/images_galerie/$picture2"; ?> class="fancybox" rel="ligthbox">
                            <img alt="picture" src = <?php echo "../uploads/images_galerie/$picture2"; ?> class="img-fluid zoom">
                        </a>
                        </div>

                        <div class="col-lg-3 col-md-4 thumb my-3 d-none d-md-inline-block">
                        <a href = <?php echo "../uploads/images_galerie/$picture3"; ?> class="fancybox" rel="ligthbox">
                            <img alt="picture" src = <?php echo "../uploads/images_galerie/$picture3"; ?> class="img-fluid zoom">
                        </a>
                        </div>

                        <div class="col-lg-3 thumb my-3 d-none d-lg-inline-block">
                        <a href = <?php echo "../uploads/images_galerie/$picture4"; ?> class="fancybox" rel="ligthbox">
                            <img alt="picture" src = <?php echo "../uploads/images_galerie/$picture4"; ?> class="img-fluid zoom">
                        </a>
                        </div>
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
                                        <input type="file" id="publicationPicture" multiple accept="image/*" onchange="showPreview2(this.files)" capture hidden>
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
                        <span><a href = "https://www.facebook.com/Chrisdevs-118387616877345"><i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a></span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function toggle_publication_content(bouton_lire_plus, content_id){
            let publication_content = document.getElementById(content_id)
            if (publication_content.style.height != "auto"){
                publication_content.style.height = "auto";
                bouton_lire_plus.textContent = "Afficher moins"
            }
            else {
                publication_content.style.height = "1.5rem";
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
        function save_publication(id_membre){
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
            pictures.forEach(function(picture){
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
            })
            windows.reload();
        }
        $(document).ready(function(){
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
</body>
</html>