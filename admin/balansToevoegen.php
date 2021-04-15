<?php
include 'cookiecheck.php';
?>

<?php
        $dat = $_GET["trip-start"];
        $un = $_GET["bezoekers"];
        $pw = $_GET["weggegeven"];
    
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
    
        $sql = "INSERT INTO balanssysteem (Datum, AantalPrijzen, VerwachtteBezoekers)
        VALUES ('$dat', '$un', '$pw')";
    
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
      
        $conn->close();
    
        echo "<script>
            window.location.replace(\"balanssysteem.php\");
            </script>";
        die();
?>