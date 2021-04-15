<?php
include 'cookiecheck.php';
?>

<?php
function array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

$data = array (
    "koppen"  => array("Naam", "Postcode", "Email")
);

        $servername = "localhost";
        $username = "Bas";
        $password = "spaarSpook9";
        $dbname = "winkelcentrum";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo("verbinden mislukt, probeer het later nog eens");
            die();
        }

        $sql = "SELECT * FROM codes where VoorwaardenGeaccepteerd = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $name = $row["VolNaam"];
                $zip = $row["PostCode"];
                $email = $row["EMail"];
                array_push($data, array("$name", "$zip", "$email"));
            }
        }

download_send_headers("data_export_" . date("Y-m-d") . ".csv");
echo array2csv($data);




?>