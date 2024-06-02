<?php
$servername = "localhost"; // Your database server name
$username = "id21275500_ayush21"; // Your database username
$password = ".Aman1999"; // Your database password
$dbname = "id21275500_project"; // Your database name
// Create a connection
$conn = new mysqli($servername,$username,$password,$dbname);
$err=mysqli_connect_error();
print($err);
// Check the connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}
?>
