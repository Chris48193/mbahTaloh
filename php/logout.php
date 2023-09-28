<?php
    session_start();
/*<!--
----------------------------------
- Filename: logout.php
- Author: Christopher Yepmo
- Date: 19-08-2020
- Description: Page de déconnexion
----------------------------------
-->
<!-- Démarrage de la session -->*/
    if (isset($_SESSION['login']))
    {
        session_destroy();
        //header('location:../index.php');
        $url = "../index.php";
        echo "<script>window.location.href='$url';</script>";
    }
?>