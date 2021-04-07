<?php

    $id = $_GET['id'];

    $servername = "localhost";
        $username = "Bas";
        $password = "spaarSpook9";
        $dbname = "winkelcentrum";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo("verbinden mislukt, probeer het later nog eens");
            die();
        }

        
    $sql = "SELECT WinkelLogo FROM winkels WHERE ID=$id";
    $result = $conn->query($sql);
      
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            header("Content-type: image/jpeg");
            echo $row['WinkelLogo'];
          }
        }
?>