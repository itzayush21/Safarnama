<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geoguesser Game</title>
    
    <style>
        h1 {
            color: #00ff00; /* Bright green */
        }

        body {
            background-color: #000; /* Black */
            border-radius: 10px;
            text-align: center;
            font-family: Arial, sans-serif;
        }

        #image {
            width: 50%;
            margin: 0 auto; /* Center the image horizontally */
        }

        #location-image {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            border: 2px solid #333;
            animation: fadeIn 1s;
        }

        #options {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .option-button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            background-color: #3498db; /* Blue */
            color: #fff; /* White */
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .option-button:hover {
            background-color: #2980b9; /* Darker blue on hover */
        }

        #score {
            color: #fff; /* White */
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }

        #location-fact {
            color: #fff;
        }

        #location {
            background-color: #000;
            width: 100%;
            height: auto;
        }

        #timer {
            color: #fff; /* White */
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }

        #result {
            color: #fff; /* White */
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
    
</head>
<body>
    <h1>Geoguesser Game</h1>
    <div id="image">
        <img id="location-image" src="" alt="Guess the location">
    </div>
    <div id="location">
        <p id="location-fact"></p>
    </div>
    <div id="options">
        <!-- Options will be generated dynamically using JavaScript -->
    </div>
    <p id="score">Score: 0</p>
    <p id="consecutive">Consecutive Correct Answers: 0</p>
    <p id="timer">Time left: 10s</p>
    <p id="result"></p>

    <script>
        const locations = [
            { name: 'Paris', image: 'paris.webp', fact: 'Paris is known as the "City of Love" and is famous for the Eiffel Tower.' },
            { name: 'New York', image: 'newyork.avif', fact: 'New York City is the largest city in the United States and is often called the "Big Apple".' },
            { name: 'Tokyo', image: 'tokyo.webp', fact: 'Tokyo is the capital of Japan and one of the most populous cities in the world.' },
            { name: 'London', image: 'england.jpeg', fact: 'London is home to the iconic Big Ben and Buckingham Palace.' },
            { name: 'Nagaland', image: 'nagaland.jpg', fact: 'Nagaland is known for its rich culture and traditions.' },
            { name: 'Mizoram', image: 'mizoram.jpg', fact: 'Mizoram is a state in northeastern India known for its lush greenery.' },
            { name: 'Bhutan', image: 'bhutan.jpg', fact: 'Bhutan is a Himalayan kingdom known for its stunning landscapes.' },
            { name: 'Nepal', image: 'nepal.jpg', fact: 'Nepal is home to Mount Everest, the world\'s highest peak.' },
            { name: 'Nepal', image: 'nepal.jpg', fact: 'Nepal is home to Mount Everest, the world\'s highest peak.' },
             { name: 'Nepal', image: 'nepal.jpg', fact: 'Nepal is home to Mount Everest, the world\'s highest peak.' },
            
            // Add more locations, images, and facts here
        ];

        let currentLocationIndex = 0;
        let score = 0;
        let timer = 10;
        let timerInterval;
        let consecutiveCorrectAnswers = 0;

        function startTimer() {
            timerInterval = setInterval(() => {
                timer--;
                document.getElementById('timer').textContent = `Time left: ${timer}s`;

                if (timer == 0) {
                    clearInterval(timerInterval);
                    showResult(false);
                }
            }, 1000);
        }

        function showResult(isCorrect) {
            clearInterval(timerInterval);
            if (isCorrect) {
                score++;
                consecutiveCorrectAnswers++;
                document.getElementById('score').textContent = `Score: ${score}`;
                document.getElementById('result').textContent = 'Correct!';
                document.getElementById('consecutive').textContent = `Consecutive Correct Answers: ${consecutiveCorrectAnswers}`;

                if (consecutiveCorrectAnswers === 5) {
                    // User got 5 consecutive correct answers, award 10 bonus points
                    score += 10;
                    document.getElementById('score').textContent = `Score: ${score}`;
                    alert('Congratulations! You guessed 5 locations in a row correctly and earned 10 bonus points.');
                    consecutiveCorrectAnswers = 0; // Reset consecutiveCorrectAnswers
                }
            } else {
                // User chose a wrong answer, end the game
                document.getElementById('result').textContent = 'Incorrect. Game over!';
                consecutiveCorrectAnswers = 0;
                score = 0;
                document.getElementById('score').textContent = `Score: ${score}`;
                alert('Game over! Your final score: ' + score);
            }
            document.getElementById('location-fact').textContent = `Fun Fact: ${locations[currentLocationIndex].fact}`;

            // Delay for a moment and then load the next location
            setTimeout(loadNextLocation, 5000);
        }

        function loadNextLocation() {
            if (currentLocationIndex < locations.length - 1) {
                currentLocationIndex++;
            } else {
                // You've reached the end of the game; you can add logic here to handle it.
                alert('Game over! Your final score: ' + score);
                // Optionally, you can reset the game here.
                currentLocationIndex = 0;
                score = 0;
            }
        
            const location = locations[currentLocationIndex];
            document.getElementById('location-image').src = location.image;
            document.getElementById('result').textContent = '';
            document.getElementById('location-fact').textContent = '';
            timer = 10;
            document.getElementById('timer').textContent = `Time left: ${timer}s`;
            startTimer();
            shuffleOptions(); // Shuffle the options each time a new location is loaded
        }

        function shuffleOptions() {
            const options = [...locations]; // Copy the entire locations array
            const correctAnswer = options[currentLocationIndex].name;
            options.splice(currentLocationIndex, 1); // Remove the correct answer
            shuffleArray(options); // Shuffle the remaining options
            options.splice(3); // Keep only the first four options
            options.push({ name: correctAnswer }); // Add the correct answer back in the options
            shuffleArray(options); // Shuffle the options again

            const optionsDiv = document.getElementById('options');
            optionsDiv.innerHTML = ''; // Clear existing options

            options.forEach((location) => {
                const button = document.createElement('button');
                button.className = 'option-button';
                button.textContent = location.name;
                button.onclick = () => checkAnswer(location.name);
                optionsDiv.appendChild(button);
            });
        }

        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]]; // Swap elements
            }
        }
        function checkAnswer(selectedAnswer) {
            const correctAnswer = locations[currentLocationIndex].name;

            if (selectedAnswer === correctAnswer) {
                showResult(true);
            } else {
                showResult(false);
            }
        }


        // Initial load
        shuffleOptions();
        loadNextLocation();
    </script>
</body>
</html>

<?php
    // Include your database connection file here
    include("connection.php");

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $selectedAnswer = $_POST["selectedAnswer"];
        
        // Start a PHP session if not already started
        session_start();

        // Check if the user is logged in
        if (isset($_SESSION["username"])) {
            $user_name = $_SESSION["username"];
            
            // Check if the selected answer is correct
            $correctAnswer = locations[currentLocationIndex].name; // Replace with the actual correct answer
            
            if ($selectedAnswer === $correctAnswer) {
                // Increment consecutive correct answers counter in the session
                if (!isset($_SESSION["consecutiveCorrectAnswers"])) {
                    $_SESSION["consecutiveCorrectAnswers"] = 1;
                } else {
                    $_SESSION["consecutiveCorrectAnswers"]++;
                }

                if ($_SESSION["consecutiveCorrectAnswers"] == 5) {
                    // User got 5 consecutive correct answers, award 5 bonus points
                    $creditAward = 5;
                    $_SESSION["consecutiveCorrectAnswers"] = 0; // Reset consecutiveCorrectAnswers
                    $sql = "INSERT INTO credit (user_name, credit) VALUES ('$user_name,,'$creditAward')
                            ON DUPLICATE KEY UPDATE credit = credit + $creditAward ";
                    
                    $stmt = $conn->prepare($sql);

                    // Check if prepare was successful
                    if ($stmt) {
                        // Bind parameters
                        $stmt->bind_param("sii", $user_name, $creditAward, $creditAward);

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
                }
            } else {
                // User chose a wrong answer, reset consecutiveCorrectAnswers
                $_SESSION["consecutiveCorrectAnswers"] = 0;
            }
        } else {
            // User is not logged in
            echo "You must be logged in to play the game.";
        }
    }
?>
