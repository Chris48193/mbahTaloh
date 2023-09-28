<!--
----------------------------------
- Filename: personal_details.html
- Author: Christopher Yepmo
- Date: 01-08-2020
- Description: Page pour la gestion des informations personnelles de l'utilisateur
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
    <title>Task Manager</title>

    <!--Calling bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/acd1bbd1c0.js" crossorigin="anonymous"></script>
    <link href="../css/index.css" rel="stylesheet">
</head>
<body>
    <div class = "container-fluid">
        <!-- Entete (Logo, slogan, nom du site, bouton login) -->
        <div class = "container">
            <header class = "row pt-2">
                <div class = "col-md-offset-1 col-md-9 logo_slogan">
                    <img src = "../images/logo.jpg" alt = "logo" class = "rounded image-fluid align-baseline logo mr-1" width="60"><span class = "logo_title align-baseline font-weight-bold">LeavenGo</span>
                    <h5 class = "font-weight-bold slogan">Life becomes just easier with us</h5>
                </div>
                <div class = "col-md-1 mt-3 mr-2 login_button"><button href = "" type="button" class="btn btn-primary font-weight-bold"><span class = "fas fa-user"></span>&nbsp;&nbsp;User</button></div>
                <div class = "col-md-1 mt-3 login_button"><button href = "" type="button" class="btn btn-primary font-weight-bold"><span class = "fas fa-sign-out-alt"></span>&nbsp;&nbsp;Logout</button></div>
            </header>
        </div>

        <!-- Navbar -->
        <div class = "row mx-2">
            <nav class = "col-md-12 navbar navbar-expand-md|lg|xl navbar-light sticky-top" style = "background-color: #eeeeee;">
                <form class = "form-inline" action="/">
                    <input class = "form-control mr-sm-2" type = "text" placeholder="Search">
                    <button class = "btn btn-primary font-weight-bold" type = "submit">Search</button>
                </form>
                <ul class = "nav">
                    <li class = "nav-item"><a class = "nav-link active" href="#">Home</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >My Account</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >Our Services</a></li>
                    <li class = "nav-item"><a class = "nav-link" href="#" >Help</a></li>
                </ul>
            </nav>
        </div>

        <div class = "row mt-2 ml-1">
            <div class = "col-md-3 list-group list-group-flush">
                <a href = "#" class = "list-group-item list-group-item-action">User informations</a>
            </div>

            <!-- Effet accordéon: la class "show" permet a l'élément a qui il a été attribué d'etre ouverte par 
            défaut -->
            <div class = "col-md-9 mt-2">
                <h3>Personal data</h3>
                <div>
                    Name :
                    <br>Surname :
                    <br>Date of birth :
                    <br>Date of registration :
                    <div class = "mt-1"><button data-toggle = "modal" href = "#mdpchange" type="button" class="btn btn-primary font-weight-bold">Modify Password</button></div>
                </div>
                <h3>Contact data</h3>
                <div>
                    Phone :
                    <br>Email :
                </div>
                <h3>Statistics</h3>
                <div>
                    Number of tasks :
                </div>
            </div>
        </div>


        <footer class = "row">
            <div class = "col-lg-12">
                <div class = "row m-3" style="background-color: #eeeeee;">
                    <div class = "col-lg-4">
                        <h2>Explore</h2>
                        Video examples
                        <br>Help
                        <h2>About</h2>
                        Story
                        <br>Blogs
                    </div>
                    <div class = "col-lg-4">
                        <h2>About</h2>
                        Who we are
                        <br>Our vision
                        <h2>Contact</h2>
                    </div>
                    <div class = "col-lg-4">
                        <h2>Follow Us</h2>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <!-- Calling jquery, popper and bootstrap's javascript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>