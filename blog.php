
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Immersive Blog Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1454372182658-c712e4c5a1db?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8NHx8fGVufDB8fHx8fA%3D%3D&w=1000&q=80'); /* Replace with your background image URL */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            color: #343a40;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }
        h2, h3 {
            color: #343a40;
        }
        .blog-post {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            margin-top: 100px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .blog-post:hover {
            transform: scale(1.02);
        }
        .review-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .review-form:hover {
            transform: scale(1.02);
        }
        .form-group label {
            font-weight: bold;
            color: #343a40;
        }
        .rating label {
            font-size: 30px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="index.html">Safarnama.</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="blog_display.php">read_blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
               <!-- <div class="blog-post">
                    <h2 class="mb-4">Blog Post Title</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                </div> -->
                <div class="blog-post">
                    <h2 class="mb-4">Share your experience</h2>
                    <p>Credit point system: 20 points for reviewing  </p>
                </div>
                <div class="review-form">
                    <h3 class="mb-3">Leave a Review</h3>
                    <form class="form" action="blog.php" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <select class="form-control" name="location" id="location">
                                    
                                    <option value="assam">Assam</option>
                                    <option value="bihar">Bihar</option>
                                    <option value="jharkhand">Jharkhand</option>
                                    <option value="nagaland">Nagaland</option>
                                    <option value="manipur">Manipur</option>
                                    <option value="mizoram">Mizoram</option>
                                    <option value="meghalaya">Meghalaya</option>
                                    <option value="odisha">Odisha</option>
                                    <option value="tripura">Tripura</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea class="form-control" name="review" id="review" rows="3" placeholder="Write your review here"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select class="form-control" name="rating" id="rating">
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                        <!--<div class="form-group">-->
                        <!--    <label for="image">Upload Image</label>-->
                        <!--    <input type="file" class="form-control-file" id="image">-->
                        <!--</div>-->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
print_r($_POST);
// Include your database connection file here
include("connection.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"]==="POST") {
    // Get user input
    $name = $_POST["name"];
    $location = $_POST["location"];
    $review = $_POST["review"];
    $rating = $_POST["rating"];

    // Start a PHP session if not already started
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION["username"])) {
        $user_name = $_SESSION["username"];

        // Prepare the SQL query to insert the review
        $sql = "INSERT INTO reviews (user_name, name, location, review, rating) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        // Check if prepare was successful
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("ssssi", $user_name, $name, $location, $review, $rating);

            // Execute the query
            if ($stmt->execute()) {
                // Data insertion successful

                // Award 5 points to the user in the credit database
                $creditAward = 20;

                // Use ON DUPLICATE KEY UPDATE with a unique key constraint on "user_name"
                $sqlCredit = "INSERT INTO credit (user_name, credit) VALUES (?, ?)
                              ON DUPLICATE KEY UPDATE credit = credit + ?";
                $stmtCredit = $conn->prepare($sqlCredit);

                // Check if prepare was successful
                if ($stmtCredit) {
                    // Bind parameters for credit update
                    $stmtCredit->bind_param("sii", $user_name, $creditAward, $creditAward);

                    // Execute the credit update query
                    if ($stmtCredit->execute()) {
                        echo "Review submitted successfully! You have been awarded 5 credits.";
                    } else {
                        echo "Error updating credits: " . $stmtCredit->error;
                    }

                    // Close the credit update statement
                    $stmtCredit->close();
                } else {
                    echo "Error preparing statement for credit update: " . $conn->error;
                }
            } else {
                // Data insertion failed
                echo "Error executing query: " . $stmt->error;
            }

            // Close the review insertion statement
            $stmt->close();
        } else {
            // Error in preparing the review insertion statement
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        // User is not logged in
        echo "You must be logged in to submit a review.";
    }

    // Close the database connection
    $conn->close();
}
?>


