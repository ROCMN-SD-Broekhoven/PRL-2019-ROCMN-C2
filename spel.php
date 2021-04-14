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
                <div class="item1 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="11"
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item2 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="12"
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item3 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="13"
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item4 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="21"
                        src="getImage.php?id=2" class="cards__back"></div>
                <div class="item5 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="22"
                        src="getImage.php?id=2" class="cards__back"></div>
                <div class="item6 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="23"
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item7 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="31"
                        src="getImage.php?id=2" class="cards__back"></div>
                <div class="item8 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="32"
                        src="getImage.php?id=1" class="cards__back"></div>
                <div class="item9 cards__single"><img src="media/vraagteken.png" class="cards__front"><img id="33"
                        src="getImage.php?id=2" class="cards__back"></div>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sideClose">
        <h1>Spelregels:</h1><br><br>
        <p>U heeft 9 kaarten voor u staan.</p><br>
        <p>Druk 1 voor 1 op de kaarten om ze om te draaien.</p><br>
        <p>Heeft u drie op en rij? Dan heeft u een prijs gewonnen!</p><br>
        <p>Heeft u geen drie op een rij? Dan heeft u verloren. Volgende keer beter!</p><br><br>
        <button class="closeSpelRegels" onclick="closeSide()">Naar Spel</button>
    </div>

    <script>
        function closeSide(){
            document.getElementById("sideClose").style.display = "none";
        }
    </script>

    <?php 
        $win = 0;
        $sess = $_COOKIE["session"];
        $PrijsID = 0;
        $winkelID = 0;
        $alleWinkelLogos = array();

        $servername = "localhost";
        $username = "Bas";
        $password = "spaarSpook9";
        $dbname = "winkelcentrum";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo("verbinden mislukt, probeer het later nog eens");
            die();
        }
        echo "$sess";
        $sql = "SELECT * FROM codes where SessionID = '$sess'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            if($row["Gewonnen"] == 1){
              $win = 1;
              $PrijsID = $row["PrijsID"];
            }
          }
        }

        $sql2 = "SELECT * FROM winkels";
        $result2 = $conn->query($sql2);

        $alleWinkelIDs = array();

        if ($result2->num_rows > 0) {
          while($row = $result2->fetch_assoc()) {
              array_push($alleWinkelIDs, $row["ID"]);
          }
        }
            echo "$PrijsID";
        $sql3 = "SELECT * FROM prijzen WHERE ID = $PrijsID LIMIT 1";
        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {
          while($row = $result3->fetch_assoc()) {
            $winkelID = $row["WinkelID"];

          }
        }

        $sql4 = "SELECT * FROM winkels WHERE ID = $winkelID LIMIT 1";
        $result4 = $conn->query($sql4);

        if ($result4->num_rows > 0) {
          while($row = $result4->fetch_assoc()) {
            $logo = $row["WinkelLogoPath"];
            
          }
        }

    $sql5 = "SELECT * FROM winkels ORDER BY ID";
        $result5 = $conn->query($sql5);

        if ($result5->num_rows > 0) {
          while($row = $result5->fetch_assoc()) {
              array_push($alleWinkelLogos, $row["WinkelLogoPath"]);
            
          }
        }
        


        function checkFunction($num1, $num2, $num3) {
            if($num1 == $num2 && $num2 == $num3){
                return True;
            }
        }

        $winkelids = array (
            array(0, 0, 0),
            array(0, 0, 0),
            array(0, 0, 0)
        );
        if($win == 1){
            $winrij = rand(0, 2);
            $winkelids[$winrij] = array($winkelID, $winkelID, $winkelID);
            if (($key = array_search($winkelID, $alleWinkelIDs)) !== false) {
                unset($alleWinkelIDs[$key]);
            }
            // de rest opvullen:
            for($i = 0; $i<count($winkelids); $i++){
                if($i !== $winrij){
                    shuffle($alleWinkelIDs);
                    $winkelids[$i] = array($alleWinkelIDs[0], $alleWinkelIDs[1], $alleWinkelIDs[2]);
                }
            }
            
        }
        else{
            $goedVeld = false;
            while($goedVeld == false){
                for($i = 0; $i<count($winkelids); $i++){
                    shuffle($alleWinkelIDs);
                    $winkelids[$i] = array($alleWinkelIDs[0], $alleWinkelIDs[1], $alleWinkelIDs[2]);
                }
                // check voor goed veld
                if(!(($winkelids[0][0] == $winkelids[0][1] && $winkelids[0][1] == $winkelids[0][2]) || ($winkelids[1][0] == $winkelids[1][1] && $winkelids[1][1] == $winkelids[1][2]) || ($winkelids[2][0] == $winkelids[2][1] && $winkelids[2][1] == $winkelids[2][2]))){
                    if(!(($winkelids[0][0] == $winkelids[1][0] && $winkelids[1][0] == $winkelids[2][0]) || ($winkelids[0][1] == $winkelids[1][1] && $winkelids[1][1] == $winkelids[2][1]) || ($winkelids[0][2] == $winkelids[1][2] && $winkelids[1][2] == $winkelids[2][2]))){
                        if(!(($winkelids[0][0] == $winkelids[1][1] && $winkelids[1][1] == $winkelids[2][2]) || ($winkelids[0][2] == $winkelids[1][1] && $winkelids[1][1] == $winkelids[2][0]))){
                            $goedVeld = true;
                        }
                    }
                }
            }
        }
        $n1 = $alleWinkelLogos[$winkelids[0][0]-1];
        $n2 = $alleWinkelLogos[$winkelids[0][1]-1];
        $n3 = $alleWinkelLogos[$winkelids[0][2]-1];
        $n4 = $alleWinkelLogos[$winkelids[1][0]-1];
        $n5 = $alleWinkelLogos[$winkelids[1][1]-1];
        $n6 = $alleWinkelLogos[$winkelids[1][2]-1];
        $n7 = $alleWinkelLogos[$winkelids[2][0]-1];
        $n8 = $alleWinkelLogos[$winkelids[2][1]-1];
        $n9 = $alleWinkelLogos[$winkelids[2][2]-1];
        if(rand(0,10)/10 < 0.5){
            if($win == 1){
                echo "<script>
                const cards = document.querySelectorAll(\".cards__single\");
                var numCards = 0;
                
                function flipCard() {
                    this.classList.toggle(\"flip\");
                    this.removeEventListener(\"click\", flipCard);
                    numCards++;
                    if(numCards == 9){
                        setTimeout(function(){ window.location.replace(\"winner.php\"); }, 1500);
                    }
                }
                
                cards.forEach((card) => card.addEventListener(\"click\", flipCard));

                document.getElementById(\"11\").src = \"$n1\";
                document.getElementById(\"12\").src = \"$n2\";
                document.getElementById(\"13\").src = \"$n3\";

                document.getElementById(\"21\").src = \"$n4\";
                document.getElementById(\"22\").src = \"$n5\";
                document.getElementById(\"23\").src = \"$n6\";

                document.getElementById(\"31\").src = \"$n7\";
                document.getElementById(\"32\").src = \"$n8\";
                document.getElementById(\"33\").src = \"$n9\";
                
            </script>";
            }
            else{
                echo "<script>
                const cards = document.querySelectorAll(\".cards__single\");
                var numCards = 0;
                
                function flipCard() {
                    this.classList.toggle(\"flip\");
                    this.removeEventListener(\"click\", flipCard);
                    numCards++;
                    if(numCards == 9){
                        setTimeout(function(){ window.location.replace(\"verloren.php\"); }, 1500);
                    }
                }
                
                cards.forEach((card) => card.addEventListener(\"click\", flipCard));

                document.getElementById(\"11\").src = \"$n1\";
                document.getElementById(\"12\").src = \"$n2\";
                document.getElementById(\"13\").src = \"$n3\";

                document.getElementById(\"21\").src = \"$n4\";
                document.getElementById(\"22\").src = \"$n5\";
                document.getElementById(\"23\").src = \"$n6\";

                document.getElementById(\"31\").src = \"$n7\";
                document.getElementById(\"32\").src = \"$n8\";
                document.getElementById(\"33\").src = \"$n9\";
                
            </script>";
            }
        }
        else{
            if($win == 1){
            echo "<script>
                const cards = document.querySelectorAll(\".cards__single\");
                var numCards = 0;
                
                function flipCard() {
                    this.classList.toggle(\"flip\");
                    this.removeEventListener(\"click\", flipCard);
                    numCards++;
                    if(numCards == 9){
                        setTimeout(function(){ window.location.replace(\"winner.php\"); }, 1500);
                    }
                }
                
                cards.forEach((card) => card.addEventListener(\"click\", flipCard));

                document.getElementById(\"11\").src = \"$n1\";
                document.getElementById(\"12\").src = \"$n4\";
                document.getElementById(\"13\").src = \"$n7\";

                document.getElementById(\"21\").src = \"$n2\";
                document.getElementById(\"22\").src = \"$n5\";
                document.getElementById(\"23\").src = \"$n8\";

                document.getElementById(\"31\").src = \"$n3\";
                document.getElementById(\"32\").src = \"$n6\";
                document.getElementById(\"33\").src = \"$n9\";
                
            </script>";}
            else{
                echo "<script>
                const cards = document.querySelectorAll(\".cards__single\");
                var numCards = 0;
                
                function flipCard() {
                    this.classList.toggle(\"flip\");
                    this.removeEventListener(\"click\", flipCard);
                    numCards++;
                    if(numCards == 9){
                        setTimeout(function(){ window.location.replace(\"verloren.php\"); }, 1500);
                    }
                }
                
                cards.forEach((card) => card.addEventListener(\"click\", flipCard));

                document.getElementById(\"11\").src = \"$n1\";
                document.getElementById(\"12\").src = \"$n4\";
                document.getElementById(\"13\").src = \"$n7\";

                document.getElementById(\"21\").src = \"$n2\";
                document.getElementById(\"22\").src = \"$n5\";
                document.getElementById(\"23\").src = \"$n8\";

                document.getElementById(\"31\").src = \"$n3\";
                document.getElementById(\"32\").src = \"$n6\";
                document.getElementById(\"33\").src = \"$n9\";
                
            </script>";
            }
        }


        
    ?>

</body>

</html>