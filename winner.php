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
            $prijs = $row["PrijsID"];
            if($row["Gewonnen"] == 1){
                $sql2 = "SELECT * FROM prijzen where ID = $prijs";
                $result2 = $conn->query($sql2);
                while($row2 = $result2->fetch_assoc()) {
                    $prijsn = $row2["PrijsNaam"];
                    $winid = $row2["WinkelID"];
                    $sql3 = "SELECT * FROM winkels where ID = $winid";
                    $result3 = $conn->query($sql3);
                    while($row3 = $result3->fetch_assoc()) {
                        $wnaam = $row3["WinkelNaam"];
                        $wimg = $row3["WinkelLogoPath"];
                        echo "<div class=\"middenvlakcontainer\">
                                <div class=\"middenvlak\">
                                    <h2>Gefeliciteerd!</h2>
                                    <p5>U heeft een $prijsn gewonnen bij de $wnaam!</p5>
                                    <br>
                                    <img src=\"$wimg\" alt=\"logo\" class=\"plaatje\">
                                    <br>
                                    <a href=\"login.html\">
                                        <button type=\"submit\" role=\"button\" tabindex=\"0\">Terug naar Login</button>
                                    </a>
                                </div>
                            </div>";
                            $email = $row["EMail"];
                            echo "
                            <script src=\"https://smtpjs.com/v3/smtp.js\"></script>
                            <script>
                            Email.send({
                                Host: \"smtp.gmail.com\",
                                Username: \"winkelcentrumamersfoort@gmail.com\",
                                Password: \"Winkelcentrum1234\",
                                To: \"$email\",
                                From: \"winkelcentrumamersfoort@gmail.com\",
                                Subject: \"Speluitslag\",
                                Body: \"U heeft een $prijsn gewonnen bij de $wnaam!\",
                            })
                                .then(function (message) {
                                    console.log(message)
                        
                                });
                            </script>
                          ";
                    }
                }
            }
          }
        }
    ?> 

</body>

</html>