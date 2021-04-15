
<?php
    // ik weet dat dit niet het netste inl;ogsysteem is omdat de cookie door de client gefaked kan worden maar ivm tijdsnood doen we het even zo
    if($_COOKIE["LoggedIn"] != "true"){
        header("Location: login.php");
        exit;
    }
?>