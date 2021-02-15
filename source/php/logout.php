<!--
----------------------------------
- Filename: logout.php
- Author: Christopher Yepmo
- Date: 19-08-2020
- Description: Page de déconnexion
----------------------------------
-->
<!-- Démarrage de la session -->
<?php
    session_start();
    if (isset($_SESSION['login']))
    {
        session_destroy();
        header('location:../index.php');
    }
?>