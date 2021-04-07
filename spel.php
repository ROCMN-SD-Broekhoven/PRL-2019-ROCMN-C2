<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>spel</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="algemeen.css">
    <link rel="stylesheet" href="spel.css">
</head>

<body>
    <div class="middenvlakcontainer">
        <div class="middenvlak">
            <div class="grid">
                <div class="item1 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item2 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item3 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item4 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=2" class="cards__back"></div>
                <div class="item5 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=2" class="cards__back"></div>
                <div class="item6 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item7 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=2" class="cards__back"></div>
                <div class="item8 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item9 cards__single"><img src="media/vraagteken.png" class="cards__front"><img
                        src="getImage.php?id=2" class="cards__back"></div>
            </div>
        </div>
    </div>
    <div class="sidebar">

        <h1>Spelregels:</h1>
        <div class="sidediv">
            <p1>U heeft 9 kaarten voor u staan.</p1><br>
            <p2>Druk 1 voor 1 op de kaarten om ze om te draaien.</p2><br>
            <p3>Heeft u drie op en rij? Dan heeft u een prijs gewonnen!</p3><br>
            <p4>Heeft u geen drie op een rij? Dan heeft u verloren. Volgende keer beter!</p4>
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
            }
          }
        }

        if($win == 1){
            echo
            "<script>
            const cards = document.querySelectorAll(\".cards__single\");
            var numCards = 0;
        
            function flipCard() {
                this.classList.toggle(\"flip\");
                this.removeEventListener(\"click\", flipCard);
                numCards++;
                if(numCards == 9){
                    alert(\"Gewonnen\");
                    setTimeout(function(){ window.location.replace(\"winner.php\"); }, 1500);
                }
            }
            
            cards.forEach((card) => card.addEventListener(\"click\", flipCard));
            </script>";
        }
        else{
            echo
            "<script>
            const cards = document.querySelectorAll(\".cards__single\");
            var numCards = 0;
        
            function flipCard() {
                this.classList.toggle(\"flip\");
                this.removeEventListener(\"click\", flipCard);
                numCards++;
                if(numCards == 9){
                    alert(\"Verloren\");
                    setTimeout(function(){ window.location.replace(\"verloren.php\"); }, 1500);
                }
            }
            
            cards.forEach((card) => card.addEventListener(\"click\", flipCard));
            </script>";
        }
    ?>
    
</body>

</html>