
<?php  // <--- THIS TAG MUST BE HERE
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carwash";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>