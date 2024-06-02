<?php
// Include your database connection file here
ob_start();
include("connection.php");
session_start();
//error_reporting(0); 

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    print_r($_POST);
    $username = $_POST["UserName"];
    $password = $_POST["Password"];

    // Prepare the SQL query to retrieve user data based on username
    $sql = "SELECT * FROM user WHERE user_name = '$username'";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if ($password===$row["password"]){
            // Password is correct, log the user in
            $_SESSION["username"] = $username;

            // Redirect to the main page (change "main.php" to your actual main page)
            header("Location:index.html");
            exit(); 
            
        } else {
            // Password is incorrect
            echo "Invalid password.";
        }
    } else {
        // User not found
        echo "User not found.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
    ob_end_flush();
}
?>
