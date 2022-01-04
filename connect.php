<?php
$servername = 'thoranin.org';
$username = 'jrautoparts';
$password = 'a4s@Ne38';
$dbname = 'jrautoparts';

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);
mysqli_set_charset($conn, "utf8");
// Check connection
if(!$conn){
    die('error' . mysqli_error($conn));
}
else{
    echo 'Connected successfully';
}
?>