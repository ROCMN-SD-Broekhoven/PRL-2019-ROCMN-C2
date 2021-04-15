<?php
include 'cookiecheck.php';
?>
<?php
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

$winkID = mysqli_real_escape_string($conn, $_POST['winkID']);
$prize = mysqli_real_escape_string($conn, $_POST['prize']);

$stmt = $conn->prepare("INSERT INTO prijzen (WinkelID,PrijsNaam ) VALUES (?, ?)");


$stmt->bind_param('is', $winkID,$prize);
$stmt->execute();

echo "<script>
      window.location.replace(\"prijsaanmaken.php\");
    </script>";
die();
?>