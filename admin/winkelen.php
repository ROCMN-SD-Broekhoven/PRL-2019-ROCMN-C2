<?php
include 'cookiecheck.php';
?>

<?php
// dit werkt nog niet helemaal als gehoopt
    $em = $_POST["winkelnaam"];

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

    $sql = "INSERT INTO winkels (WinkelNaam)
    VALUES ('$em')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $filename = "";
    $id = 0;

    $sql2 = "SELECT ID FROM winkels ORDER BY ID LIMIT 1";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        while($row = $result2->fetch_assoc()) {
            $id = $row["ID"];
            $filename = "logo$id";
        }
    } else {
        echo "something went wrong";
    }
    $path = "";
    if (($_FILES['upload']['name']!="")){
        // Where the file is going to be stored
         $target_dir = "media/logos/";
         $file = $_FILES['upload']['name'];
         $path = pathinfo($file);
         $ext = $path['png'];
         $temp_name = $_FILES['upload']['tmp_name'];
         $path_filename_ext = $target_dir.$filename.".".$ext;

         $path = "$target_dir$filename.$ext";
         
        // Check if file already exists
        if (file_exists($path_filename_ext)) {
            echo "Sorry, file already exists.";
        }else{
            move_uploaded_file($temp_name,$path_filename_ext);
            echo "Congratulations! File Uploaded Successfully.";
        }
    }

    

    $sql3 = "UPDATE winkels SET WinkelLogoPath = $path WHERE ID = $id";


    if ($conn->query($sql3) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
  
    $conn->close();

    echo "<script>
        window.location.replace(\"winkels.php\");
        </script>";
    die();
?>

