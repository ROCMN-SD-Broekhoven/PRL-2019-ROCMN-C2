<?php
include 'cookiecheck.php';
?>

<?php
    $em = $_GET["email"];
    $un = $_GET["username"];
    $pw = $_GET["psw"];

    // db connect
    $servername = "localhost";
    $username = "Bas";
    $password = "spaarSpook9";
    $dbname = "winkelcentrum";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        writeMsg("verbinden mislukt, probeer het later nog eens");
        die();
    }
    // Prijs aanmaken

    $sql = "INSERT INTO adminaccounts (EMail, Username, Password)
    VALUES ('$em', '$un', '$pw')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  
    $conn->close();

    echo "<script>
        window.location.replace(\"admintoevoegen.php\");
        </script>";
    die();
?>