<?php
    $sql = "SELECT * FROM prijzen ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            echo "<br> u heeft : ". $row["Prijsnaam"]. "<br> gewonnen";
            $winkel = $row["WinkelID"];
        }
    }
    else {
        echo "0 results";
    }
    $sql2 = "SELECT * FROM winkels WHERE ID = $winkel LIMIT 1";
    $result2 = $conn->query($sql2);
    if ($result2->num_rows > 0) {

        while($row2 = $result2->fetch_assoc()) {
            $logo = $row2["WinkelLogo"];
            echo "$logo";
        }
    }
    else {
        echo "0 results";
    }

?>