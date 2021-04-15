<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verloren :(</title>

    <link rel="stylesheet" href="algemeen.css">
    <link rel="stylesheet" href="winlose.css">
</head>

<body>
    <div class="middenvlakcontainer">
        <div class="middenvlak">
            <h2>Helaas!</h2>
            <p5>U heeft helaas geen prijs gewonnen</p5>
            <br>
            <img src="media/verloren.png" alt="verloren" class="plaatje">
            <br>
            <a href="login.html">
                <button type="submit" role="button" tabindex="0">Terug naar Login</button>
            </a>
        </div>
    </div>
</body>

<?php
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
                        Body: \"U heeft helaas niet gewonnen!!\",
                    })
                        .then(function (message) {
                            console.log(message)
                
                        });
                    </script>
                  ";
              }
            }
?>

</html>