<?php
include("connection.php");
// Assuming you have a users table with columns user_name and credit
session_start();
$userName =$_SESSION["username"]; // Replace with the actual user's name or fetch it from your session
$sql = "SELECT credit FROM credit WHERE user_name = '$userName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $credit = $row["credit"];
    echo $credit; // Send the credit amount as a response
} else {
    echo "0"; // Return 0 if the user is not found
}

$conn->close();
?>
