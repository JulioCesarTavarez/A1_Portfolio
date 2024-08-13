<!-- /*
Plugin Name: Road Kill Allert
plugin URI: www.Roadkillalert.com -->


<?php
$servername = "localhost";
$username = "3io";
$password = "Bigdawg13$$$";


// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>