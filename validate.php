<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen...</title>
</head>

<?php
// post variabelen
  $name = $_POST['name'];
  $code = $_POST['code'];
  $zip = $_POST['zip'];
  $email = $_POST['email'];
  $newsletter = $_POST['newsletter'];
  $voorwaarden = $_POST['voorwaarden'];

  // error bericht  functie
  function writeMsg($msg) {
    echo "<script>
      alert(\"$msg\");
      window.location.replace(\"login.html\");
    </script>";
    die();
  }  

  // Velden Validatie
  if(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
    writeMsg($name . " is geen valide naam input");
  }
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    writeMsg($email . " is geen valide email input");
  }
  if(!preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",$zip)){
    writeMsg($zip . " is geen valide postcode input");
  }

  // algemene voorwaarden validatie
  if(!isset($voorwaarden)){
    writeMsg("u moet akkoord gaan met de algemene voorwaarden om te spelen");
  }

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

  // alle codechecks
  $sql = "SELECT * FROM codes where Code = '$code'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      if($row["VolNaam"] != ""){
        writeMsg("de code die u heeft ingevoerd is helaas al gebruikt");
      }
    }
  } else {
    writeMsg("uw code klopt niet");
  }

  // check voor winst
  $date = date("Y-m-d");
  $winstPer = 0;

  $sql = "SELECT * FROM balanssysteem where Datum = '$date' ORDER BY ID DESC LIMIT 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $winstPer = $row["AantalPrijzen"] / $row["VerwachtteBezoekers"];
    }   
  }
  $rand = (float)rand()/(float)getrandmax();
  if ($rand < $winstPer)
     $winst = 1;
  else
     $winst = 0;

  // selecteer winkel
  $winkelID = 0;
  if($winst == 1){
    $sql = "SELECT * FROM winkels ORDER BY RAND() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $winkelID = $row["ID"];
        $winkelnaam = $row["Winkelnaam"];
      }
    } else {
      writeMsg("er is een fout opgetreden bij de winkel selectie, probeer het later opnieuw");
    }
  }

  // genereer sessie
  function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  $sessionID = generateRandomString(10);

  setcookie("session", $sessionID, 0);

  // voeg variabelen toe aan DB
  $sql = "UPDATE codes SET VolNaam='$name', PostCode='$zip', EMail='$email', NieuwsBrief='$newsletter', VoorwaardenGeaccepteerd='1', Gewonnen='$winst', WinkelID='$winkelID', SessionID='$sessionID' where Code='$code'";

  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }
  
  // redirect naar spel pagina
  echo "<script>
      window.location.replace(\"spel.php\");
    </script>";
  die();
?>

</html>