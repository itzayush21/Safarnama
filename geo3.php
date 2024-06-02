<?php
    
    print_r($_POST);
    // Include your database connection file here
    include("connection.php");

    // Check if the form was submitted
    /*if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $selectedAnswer = $_POST["selectedAnswer"];*/
        
        // Start a PHP session if not already started
        session_start();

        // Check if the user is logged in
        if (isset($_SESSION["username"])) {
            $user_name = $_SESSION["username"];
            
            // Check if the selected answer is correct
            //$correctAnswer = $locations[$currentLocationIndex]['name']; // Replace with the actual correct answer
            
            /*if ($selectedAnswer === $correctAnswer) {
                // Increment consecutive correct answers counter in the session
                if (!isset($_SESSION["consecutiveCorrectAnswers"])) {
                    $_SESSION["consecutiveCorrectAnswers"] = 1;
                } else {
                    $_SESSION["consecutiveCorrectAnswers"]++;
                }

                if ($_SESSION["consecutiveCorrectAnswers"] == 5) {
                    // User got 5 consecutive correct answers, award 5 bonus points
                   
                    $_SESSION["consecutiveCorrectAnswers"] = 0; */// Reset consecutiveCorrectAnswers
                    $creditAward = 5;
                    $sql = "INSERT INTO credit (user_name, credit) VALUES ('$user_name','$creditAward')
                            ON DUPLICATE KEY UPDATE credit = credit + '$creditAward' ";
                    
                    $stmt = $conn->prepare($sql);

                    // Check if prepare was successful
                    if ($stmt) {
                        // Bind parameters
                        $stmt->bind_param("si", $user_name, $creditAward);

                        // Execute the query
                        if ($stmt->execute()) {
                            // Credit awarded successfully
                            echo "Congratulations! You guessed 5 locations in a row correctly and earned 5 bonus points.";
                        } else {
                            // Error executing query
                            echo "Error executing query: " . $stmt->error;
                        }

                        // Close the prepared statement
                        $stmt->close();
                    } else {
                        // Error in preparing the statement
                        echo "Error preparing statement: " . $conn->error;
                    }
        } else {
            // User is not logged in
            echo "You must be logged in to play the game.";
        }
    
?>