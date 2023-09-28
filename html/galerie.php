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
    $id_membre = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie</title>

    <style>
h1{
    color: #ffffff !important;
}
body {
  background-color:#d3c7b7 !important;
  font-family: "Asap", sans-serif !important;
  color:#989898;
  margin:10px;
  font-size:16px;
}

#demo {
  height:100%;
  position:relative;
  overflow:hidden;
}


.green{
  background-color:#6fb936;
}
        .thumb{
            margin-bottom: 30px;
        }
        
        .page-top{
            margin-top:85px;
        }

   
img.zoom {
    width: 100%;
    height: 200px;
    border-radius:5px;
    object-fit:cover;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
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

    </style>

<style>
		#dropArea_factures
		{
			border: dashed #b5936e 3px;
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
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
</head>
<body>
    <h1 class = "text-center my-3">Galerie photos Mbah Taloh</h1>
    <div class = "container">
        <div class = "row p-3 flex_box">
            <div id = "dropArea_factures" class = "col-md-4 drop-area px-3 justify-content-center">
                <div>
                    <form class="my-form">
                        <h6 class = "m-1">Ajouter des images ici par glissé déposé ou par selection d'une image dans votre mobile</h6>
                        <div class = "flex-box">
                            <p class = "text-center my-2">Déposer les images ici
                            <p><input type="file" id="fileElem" multiple accept="image/*" onchange='handleFiles(this.files)' required="required">
                            <label class="button btn btn-primary font-weight-bold" for="fileElem">Choisir des images</label>
                        </div>
                        <progress id = "progress_bar_factures" role="progressbar" class = "progress progress-bar-info progress-bar" aria-valuemax="100" aria-valuemin="0" style="width:100%"></progress>
                        <hr>
                    </form>
                </div>
            </div>
        </div>
        <div class = "row mt-2">
            <div class = "col-md-12 flex_box">
                <div id="uploads_names_factures" class = "col-md-4"></div>
            </div>
        </div>
        <a href="" class = "btn btn-primary font-weight-bold">Terminé</a>
        <a href="acceuil_login.php" class = "btn btn-primary font-weight-bold">Retour à l'acceuil</a>
        <div class="row mt-3">
            <?php
            echo "<div id = 'id_membre' value = '$id_membre' hidden>$id_membre</div>";
                if($dossier = opendir("../uploads/images_galerie"))
                {
                    while(false != ($fichier = readdir($dossier)))
                    {
                        if($fichier != '.' && $fichier != '..'){
                            ?>
                                <div class="col-lg-3 thumb">
                                <a href = <?php echo "../uploads/images_galerie/$fichier"; ?> class="fancybox" rel="ligthbox">
                                    <img alt=<?php echo "$fichier"; ?> src = <?php echo "../uploads/images_galerie/$fichier"; ?> class="img-fluid zoom">
                                </a>
                                </div>
                            <?php
                        }
                    }
                }
            ?>
        </div>
    </div>
    <script>
    let dropArea = document.getElementById('dropArea_factures');
	let progressBar = document.getElementById('progress_bar_factures');
	let upload_names = document.getElementById('uploads_names_factures');
	url = '../php/galerie_upload.php'


	let filesDone = 0;
	let filesToDo = 0;
	let files_global = [];

	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, preventDefaults, false)
	});

	['dragenter', 'dragover'].forEach(eventName => {
		dropArea.addEventListener(eventName, highlight, false)
	});

	['dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, unhighlight, false)
	});

	dropArea.addEventListener('drop', handleDrop, false);

	//Function qui gere l'upload de plusieurs fichiers
	function handleFiles(files){
		files = [...files];
		files_global = [...files];
		initializeProgress(files.length);
		(files).forEach(uploadFile, id_membre);
	}

	//Function d'upload
	function uploadFile(file){
		let formData = new FormData;
		formData.append('file', file);
		formData.append('id_membre', document.getElementById('id_membre').textContent);
		formData.append('action', 'save_bill');
		//When a data from a form is appended to this object, the data can be retrieved
		//from php according to the data type. Files are retrieved from the superglobal
		//FILE and text types are retrieved from superglobal POST or GET according to the
		//sending method

		fetch(url, {
			method: 'POST',
			body: formData
		})
		.then((response) => {
			progressDone();
		})
		.catch((error) => {
			console.log(error)
		})
	}

	function handleDrop(e) {
		let dt = e.dataTransfer; //used to hold the data that is being dragged during a drag and drop operation.
		let files = dt.files;

		handleFiles(files);
	}

	function highlight(e){
		dropArea.classList.add('highlight')
	}

	function unhighlight(e){
		dropArea.classList.remove('highlight')
	}

	function preventDefaults(e){
		e.preventDefault()
		e.stopPropagation()
	}

	function initializeProgress(numfiles){
		progressBar.value = 0;
		filesDone = 0;
		filesToDo = numfiles;
	}

	function progressDone() {
		filesDone++
		console.log(files_global[filesDone-1].name);
		upload_names.innerHTML += files_global[filesDone-1].name + '<br>';
		progressBar.value = filesDone / filesToDo * 100;
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