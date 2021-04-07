<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gewonnen :)</title>

    <link rel="stylesheet" href="algemeen.css">
    <link rel="stylesheet" href="winlose.css">
</head>

<body>
    <div class="middenvlakcontainer">
        <div class="middenvlak">
            <h2>Gefeliciteerd!</h2>
            <p5>U heeft een prijs gewonnen bij de Jumbo!</p5>
            <br>
            <img src="media/logos/logo1.png" alt="logo" class="plaatje">
            <br>
            <button type="submit" role="button" tabindex="0">Bevestigen</button>
        </div>
    </div>


    <?php
        $win = 0;
        $sess = $_COOKIE["session"];

        $servername = "localhost";
        $username = "Bas";
        $password = "spaarSpook9";
        $dbname = "winkelcentrum";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo("verbinden mislukt, probeer het later nog eens");
            die();
        }

        $sql = "SELECT * FROM codes where SessionID = '$sess'";
        $result = $conn->query($sql);
      
        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($row["Gewonnen"] == 1){
                $win = 1;
                $naam = $row["VolNaam"];
                $code = $row["Code"];
                $zip = $row["PostCode"];
                $email = $row["EMail"];
                $winkel = $row["WinkelID"];
                echo
                "<div class=\"sidebar\">
                    <h1>Uw gegevens:</h1>
                    <div class=\"sidediv\">
                        <p1 id=\"p1\">Naam: $naam</p1><br>
                        <p2 id=\"p2\">Code: $code</p2><br>
                        <p3 id=\"p3\">Postcode: $zip</p3><br>
                        <p4 id=\"p4\">E-mail: $email</p4>
                    </div>
    
                </div>
                <script>
                    alert(\"Een mail is verzonden dat je gewonnen hebt bij winkelID: $winkel\");
                </script>";
            }
          }
        }
    ?>

</body>

</html>