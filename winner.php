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
    


    <?php
        $winkelID = 0;
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
            $winkel = $row["WinkelID"];
            if($row["Gewonnen"] == 1){
                $sql2 = "SELECT * FROM winkels where ID = $winkel";
                $result2 = $conn->query($sql2);
                while($row2 = $result2->fetch_assoc()) {
                    $wnaam = $row2["WinkelNaam"];
                    $wimg = $row2["WinkelLogoPath"];
                    echo "<div class=\"middenvlakcontainer\">
                            <div class=\"middenvlak\">
                                <h2>Gefeliciteerd!</h2>
                                <p5>U heeft een prijs gewonnen bij de $wnaam!</p5>
                                <br>
                                <img src=\"$wimg\" alt=\"logo\" class=\"plaatje\">
                                <br>
                                <a href=\"login.html\">
                                    <button type=\"submit\" role=\"button\" tabindex=\"0\">Terug naar Login</button>
                                </a>
                            </div>
                        </div>";
                }
            }
          }
        }
    ?> 
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script>
        Email.send({
            Host: "smtp.gmail.com",
            Username: "email",
            Password: "ww",
            To: gotMail,
            From: "email",
            Subject: "Speluitslag",
            Body: "U heeft de prijs: [prijs] gewonnen bij winkel: [winkel]!!"
        }).then(
            message => alert(message)
        );
    </script>

</body>

</html>