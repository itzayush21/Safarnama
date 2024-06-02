<?php
    // Include your database connection file here
    include("connection.php");

    // Initialize variables for filtering
    $selectedState = "";
    $whereClause = "";

    // Check if a state filter has been selected
    if (isset($_GET['state'])) {
        $selectedState = $_GET['state'];
        $whereClause = "WHERE location = '$selectedState'";
    }

    // Fetch reviews from the database based on the filter or display all by default
    $sql = "SELECT * FROM reviews ";
    if (!empty($whereClause)) {
        $sql .= $whereClause;
    }
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reviews</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1454372182658-c712e4c5a1db?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxleHBsb3JlLWZlZWR8NHx8fGVufDB8fHx8fA%3D%3D&w=1000&q=80');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            color: #343a40;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.8); /* Add transparency to the container */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .review-card {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .filter {
            margin-bottom: 20px;
        }
        select.form-control {
            width: 200px; /* Adjust the width of the select input */
        }
        h1 {
            text-align: center;
        }
    
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Reviews</h1>
        <div class="filter">
            <form method="GET">
                <div class="form-group">
                    <label for="state">Filter by State:</label>
                    <select class="form-control" id="state" name="state" onchange="this.form.submit()">
                        <option value="">All States</option>
                       
                        <option value="assam">Assam</option>
                        <option value="bihar">Bihar</option>
                        <option value="jharkhand">Jharkhand</option>
                        <option value="nagaland">Nagaland</option>
                        <option value="manipur">Manipur</option>
                        <option value="mizoram">Mizoram</option>
                        <option value="meghalaya">Meghalaya</option>
                        <option value="odisha">Odisha</option>
                        <option value="tripura">Tripura</option>
                        <!-- Add other state options here -->
                    </select>
                </div>
            </form>
        </div>
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="review-card">';
                    echo '<h3>' . $row['name'] . '</h3>';
                    echo '<p>Location: ' . $row['location'] . '</p>';
                    echo '<p>Rating: ' . $row['rating'] . ' Stars</p>';
                    echo '<p>Review: ' . $row['review'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No reviews found.</p>';
            }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
