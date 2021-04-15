
<?php
    if($_COOKIE["LoggedIn"] != "true"){
        header("Location: login.php");
        exit;
    }
?>